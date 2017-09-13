<?php

namespace Recipr\Http\Controllers;

use Recipr\Allergy;
use Recipr\User;
use Recipr\Diet;
use Recipr\Cuisine;
use Recipr\Course;
use Recipr\Holiday;
use Recipr\RecipeSearch;
use Recipr\Recipe;
use Recipr\Ingredient;
use Recipr\IngredientLine;
use Recipr\NutritionAttribute;
use Recipr\NutritionEstimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    protected $api_url = "http://api.yummly.com/v1/api";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('search.index', [
            'allergies' => Allergy::get(), 
            'users_allergies' => Auth::user()->allergies()->get(),
            'diets' => Diet::get(),
            'users_diets' => Auth::user()->diets()->get(),
            'cuisines' => Cuisine::get(),
            'courses' => Course::get(),
            'holidays' => Holiday::get(),
            'nutrients' => NutritionAttribute::get()
        ]);
    }

    public function searchView()

    public function search(Request $request)
    {
        //$request->flash();

        $this->validate($request, [
            'nutrients.*.id' => 'required'/*,
            'nutrients.*.min' => 'numeric',     // todo: make validation so it has to be a number, but it is not required
            'nutrients.*.max' => 'numeric' */
        ]);

        // entering search info into database
        $recipe_search = new RecipeSearch();
        $recipe_search->query = ($request['query'] == null) ? '' : $request['query'];
        if ($request->user()->recipe_searches()->save($recipe_search))    // add all intersects
        {
            $tables = array(Allergy::get(), Course::get(), Cuisine::get(), Diet::get(), Holiday::get());
            foreach($tables as $table) {
                $this->attach($request, $table, $recipe_search->id);
            }
        }

        // making api call
        $url = $this->api_url . "/recipes?" . "_app_id=" . env('APP_ID') . "&_app_key=" . env('API_KEY');
        if ($recipe_search->query != null)
            $url .= "&q=" . urlencode($recipe_search->query);

        $url .= $this->append($request, Allergy::get(), 'allowedAllergy[]');
        $url .= $this->append($request, Course::get(), 'allowedCourse[]');
        $url .= $this->append($request, Cuisine::get(), 'allowedCuisine[]');
        if ($request['diet'] != 'none') {
            $url .= "&allowedDiet[]=" . urlencode(Diet::find($request['diet'])->searchValue);
        }
        $url .= $this->append($request, Holiday::get(), 'allowedHoliday[]');

        // TODO: append nutrition attribute values
        if (isset($request['nutrients'])) {
            foreach($request['nutrients'] as $nutrient) {
                $pivot_data = array();      // for saving pivot data at intersect (ex: min, max)
                $nutrition_attribute = NutritionAttribute::find($nutrient['id']);
                if (is_numeric($nutrient['min'])) {   // checking min
                    $url.= "&nutrition." . $nutrition_attribute->value . ".min=" . $nutrient['min'];
                    $pivot_data['min'] = $nutrient['min'];
                }
                if (is_numeric($nutrient['max'])) {   // checking min
                    $url.= "&nutrition." . $nutrition_attribute->value . ".max=" . $nutrient['max'];
                    $pivot_data['max'] = $nutrient['max'];
                }
                $recipe_search->nutrition_attributes()->save($nutrition_attribute, $pivot_data);
            }
        }

        $url .= "&maxResult=50&start=0";   // bumping results so users have more to see

        // return response()->json(['data' => $url]);
        $results = json_decode(file_get_contents($url));

        foreach($results->matches as $result) {
            $temp = array();
            $id = $result->id;
            foreach($result->ingredients as $ingredient) {
                $obj = Ingredient::where('description', $ingredient)->first();
                if ($obj == null) {
                    $obj = new \stdClass();     // instantiate a blank object to create an ingredient object to use in the view
                    $obj->searchValue = $ingredient;
                    $obj->description = $ingredient;
                    $obj->term = $ingredient;
                    $obj->id = null;
                }
                array_push($temp, $obj);

                // as well as adding the whole ingredient object to the result, we should add the ingredient to the interesect table with the recipe
                if (count(DB::table('recipes_ingredients')->where('recipe_id', $id)->where('ingredient_id', $obj->id)->get()) == 0
                        && ($obj->id != null))
                        $obj->recipes()->attach($id);
            }
            $result->ingredients = $temp;

            $result->saved = (Auth::user()->recipes_saved()->find($result->id)) ? true : false;
        }
        return view('search.results', ['results' => $results, 
            'users_ingredients' => Auth::user()->ingredients()->get()]);
    }

    public function get($recipe_id) {
        $recipe = $this->getRecipe($recipe_id);
        Auth::user()->recipe_views()->attach($recipe_id);
        return view('recipe', ['recipe' => $recipe, 
                                'users_ingredients' => Auth::user()->ingredients()->get(),
                                'grocery_list' => Auth::user()->grocery_lists()
                                    ->where('status', 'open')
                                    ->where('recipe_id', $recipe->id)->first()
                            ]);
    }

    public function getRecipe($recipe_id)
    {
        //$recipe = json_decode(file_get_contents(storage_path() . "/app/json/" . "recipe.json"));

        $r = Recipe::find($recipe_id);
        if (!Recipe::find($recipe_id)) {   // insert it
            $url = $this->api_url . '/recipe/' . $recipe_id . "?_app_id=" . env('APP_ID') . "&_app_key=" . env('API_KEY');
            $recipe = json_decode(file_get_contents($url));

            $r = new Recipe();

            // attributions
            $r->html = $recipe->attribution->html;
            $r->url = $recipe->attribution->url;
            $r->text = $recipe->attribution->text;
            $r->logo = $recipe->attribution->logo;

            // flavors
            if (isset($recipe->flavors)) {
                if (isset($recipe->flavors->Salty)) {   // if one isn't set, none will
                    $r->salty = $recipe->flavors->Salty;
                    $r->meaty = $recipe->flavors->Meaty;
                    $r->piquant = $recipe->flavors->Piquant;
                    $r->bitter = $recipe->flavors->Bitter;
                    $r->sour = $recipe->flavors->Sour;
                    $r->sweet = $recipe->flavors->Sweet;
                }
            }

            // images are nullable fields
            if (isset($recipe->images[0]->hostedLargeUrl))
                $r->hostedLargeUrl = $recipe->images[0]->hostedLargeUrl;
            if (isset($recipe->images[0]->hostedMediumUrl))
                $r->hostedMediumUrl = $recipe->images[0]->hostedMediumUrl;
            if (isset($recipe->images[0]->hostedSmallUrl))
                $r->hostedSmallUrl = $recipe->images[0]->hostedSmallUrl;

            $r->name = $recipe->name;
            $r->yield = $recipe->yield;
            $r->totalTime = $recipe->totalTime;
            $r->totalTimeInSeconds = $recipe->totalTimeInSeconds;
            $r->numberOfServings = $recipe->numberOfServings;

            // source
            $r->sourceRecipeUrl = $recipe->source->sourceRecipeUrl;
            $r->sourceSiteUrl = $recipe->source->sourceSiteUrl;
            $r->sourceDisplayName = $recipe->source->sourceDisplayName;

            $r->id = $recipe->id;

            $r->save();

            // ingredient lines
            foreach($recipe->ingredientLines as $ingredientLine) {
                $i = new IngredientLine();
                $i->line = $ingredientLine;
                $r->ingredient_lines()->save($i);
            }

            // nutrition estimates
            foreach($recipe->nutritionEstimates as $nutritionEstimate) {
                $n = new NutritionEstimate();
                $n->attribute = $nutritionEstimate->attribute;
                $n->description = $nutritionEstimate->description;
                $n->value = $nutritionEstimate->value;
                $n->unit_name = $nutritionEstimate->unit->name;
                $n->unit_abbreviation = $nutritionEstimate->unit->abbreviation;
                $n->unit_plural = $nutritionEstimate->unit->plural;
                $n->unit_plural_abbreviation = $nutritionEstimate->unit->pluralAbbreviation;

                $r->nutrition_estimates()->save($n);
            }

            //attributes
            if (isset($recipe->attributes->holiday)) {
                foreach($recipe->attributes->holiday as $holiday) {
                    $h = Holiday::where('name', $holiday)->first();
                    $r->holidays()->attach($h);
                }
            }

            if (isset($recipe->attributes->course)) {
                foreach($recipe->attributes->course as $course) {
                    $c = Course::where('name', $course)->first();
                    $r->courses()->attach($c);
                }
            }

            if (isset($recipe->attributes->cuisine)) {
                foreach($recipe->attributes->cuisine as $cuisine) {
                    $c = Cuisine::where('name', 'like', '%' . $cuisine . '%')->first();
                    $r->cuisines()->attach($c);
                }
            }
        }

        return $this->toJson($r);
    }

    public function made(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        Auth::user()->recipes_made()->attach($request['id']);

        return view('recipe.made', ['ingredients' => Recipe::find($request['id'])->ingredients()->get(),
                                   'users_ingredients' => Auth::user()->ingredients()->get()
                                   ]);
    }

    public function save(Request $request) {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $recipe = $this->getRecipe($request['id']);

        if (Auth::user()->recipes_saved()->find($request['id'])) {
            Auth::user()->recipes_saved()->detach($request['id']);
            return response()->json(['success' => true, 'saved' => false]);
        } else {
            Auth::user()->recipes_saved()->attach($request['id']);
            return response()->json(['success' => true, 'saved' => true]);
        }
    }

    protected function append($request, $table, $parameter)
    {
        $str = '';
        foreach ($table as $value) {
            if ($request[str_replace(" ", '_', $value->id)]) {  // really needs put into middleware somehow
                $str .= "&" . urlencode($parameter) . "=" . urlencode($value->searchValue);
            }
        }
        return $str;
    }

    protected function attach($request, $table, $id)
    {
        foreach ($table as $value) {
            if ($request[str_replace(" ", '_', $value->id)]) {  // really needs put into middleware somehow
                $value->recipe_searches()->attach($id);
            }
        }
    }

    public function toJson($recipe) {
        $r = new \stdClass();//json_decode(file_get_contents(storage_path() . '/app/json/recipe_template.json'));
        $r->attribution = new \stdClass();
        $r->flavors = new \stdClass();
        $r->images = new \stdClass();
        $r->attributes = new \stdClass();
        $r->source = new \stdClass();

        $r->attribution->html = $recipe->html;
        $r->attribution->url = $recipe->url;
        $r->attribution->text = $recipe->text;
        $r->attribution->logo = $recipe->logo;

        $ingredient_lines = $recipe->ingredient_lines()->get();
        for($i = 0; $i < count($ingredient_lines); $i++) {
            $r->ingredientLines[$i] = $ingredient_lines[$i]->line;
        }

        $r->flavors->Salty = $recipe->salty;
        $r->flavors->Meaty = $recipe->meaty;
        $r->flavors->Piquant = $recipe->piquant;
        $r->flavors->Bitter = $recipe->bitter;
        $r->flavors->Sour = $recipe->sour;
        $r->flavors->Sweet = $recipe->sweet;

        
        $r->nutritionEstimates = array();   // get template and clear array to fill with data from db
        foreach($recipe->nutrition_estimates()->get() as $estimate) {
            $nutrition_estimate = new \stdClass();
            $nutrition_estimate->unit = new \stdClass();
            $nutrition_estimate->attribute = $estimate->attribute;
            $nutrition_estimate->description = $estimate->description;
            $nutrition_estimate->value = $estimate->value;
            $nutrition_estimate->unit->name = $estimate->unit_name;
            $nutrition_estimate->unit->abbreviation = $estimate->unit_abbreviation;
            $nutrition_estimate->unit->plural = $estimate->unit_plural;
            $nutrition_estimate->unit->pluralAbbreviation = $estimate->unit_plural_abbreviaiton;

            array_push($r->nutritionEstimates, $nutrition_estimate);
        }

        $r->images->hostedLargeUrl = $recipe->hostedLargeUrl;
        $r->images->hostedMediumUrl = $recipe->hostedMediumUrl;
        $r->images->hostedSmallUrl = $recipe->hostedSmallUrl;

        $r->name = $recipe->name;
        $r->yield = $recipe->yield;
        $r->totalTime = $recipe->totalTime;

        if (count($recipe->holidays()->get()) > 0) {
            $r->attributes->holiday = array();
            foreach($recipe->holidays()->get() as $holiday) {
                array_push($r->attributes->holiday, $holiday->name);
            }
        }

        if (count($recipe->courses()->get()) > 0) {
            $r->attributes->course = array();
            foreach($recipe->courses()->get() as $course) {
                array_push($r->attributes->course, $course->name);
            }
        }

        if (count($recipe->cuisines()->get()) > 0) {
            $r->attributes->cuisine = array();
            foreach($recipe->cuisines()->get() as $cuisine) {
                array_push($r->attributes->cuisine, $cuisine->name);
            }
        }

        $r->totalTimeInSeconds = $recipe->totalTimeInSeconds;
        $r->numberOfServings = $recipe->numberOfServings;

        $r->source->sourceRecipeUrl = $recipe->sourceRecipeUrl;
        $r->source->sourceSiteUrl = $recipe->sourceSiteUrl;
        $r->source->sourceDisplayName = $recipe->sourceDisplayName;

        $r->id = $recipe->id;

        $r->ingredients = $recipe->ingredients()->get();

        $r->saved = (Auth::user()->recipes_saved()->find($r->id)) ? true : false;

        return $r;
    }

}
