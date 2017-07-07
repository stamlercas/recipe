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
            'holidays' => Holiday::get()
        ]);
    }

    public function search(Request $request)
    {
        //return response()->json(['data' => $request[str_replace("_", ' ', 'course-Main_Dishes')]]);
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
        $url .= $this->append($request, Diet::get(), 'allowedDiet[]');
        $url .= $this->append($request, Holiday::get(), 'allowedHoliday[]');

        //return response()->json(['data' => $url]);
        $results = json_decode(file_get_contents($url));
        //$results = json_decode('{"criteria":{"q":"burger","allowedDiet":["387^Lacto-ovo vegetarian"],"allowedIngredient":null,"excludedIngredient":null},"matches":[{"imageUrlsBySize":{"90":"http:\/\/lh3.ggpht.com\/zjvi-kK3P6JEFV02N9S3NtKqSVDPrBEFI_xo6w_ZyBbcrc5swMSTG55kuXVTZzEFvQGO2eeVmf5qkdZchp0B=s90-c"},"sourceDisplayName":"Williams-Sonoma","ingredients":["portabello mushroom","extra-virgin olive oil","burger buns","red wine vinegar","dijon mustard","minced garlic","kosher salt","freshly ground pepper","water","fresh thyme","fresh rosemary","fresh dill","mixed salad greens","tomatoes"],"id":"Portobello-Burgers-459219","smallImageUrls":["http:\/\/lh3.ggpht.com\/65xMRVD6J9RaJrrZ-Pz5IodY7IvoTZmmc33KiefoArsPm4fZg3rap_uLNC-JClB4k_cWCqEJKNgZ1Z2LUSm3Tt8=s90"],"recipeName":"Portobello Burgers","totalTimeInSeconds":2700,"attributes":{"course":["Lunch"],"cuisine":["Barbecue"],"holiday":["Summer"]},"flavors":{"piquant":0.3333333333333333,"meaty":0.16666666666666666,"bitter":0.3333333333333333,"sweet":0.16666666666666666,"sour":0.3333333333333333,"salty":0.3333333333333333},"rating":3},{"imageUrlsBySize":{"90":"http:\/\/lh6.ggpht.com\/kaPT0hlnqNYoViF3ybZBqRZhSD7thVD-ut67aF8eV3a_-clgmLvLq3-SIuXK2XGYa3sHl37sPpHkjnsEJyzpXw=s90-c"},"sourceDisplayName":"Awesome Cuisine","ingredients":["beets","carrots","oats","onions","parsley","cilantro leaves","thyme","corn flour","clove","salt","black pepper","oil","dijon mustard","burger buns","tomatoes","cucumber","lettuce leaves"],"id":"Beetroot-Burger-680819","smallImageUrls":["http:\/\/lh4.ggpht.com\/QJoNXGAC2RIne30khECXIXeE2Swu7BYv149QA44eiAW4zm8m7aO6Jvx4s6FMnFBK566TLcd1Gd2xAWqGlC5I=s90"],"recipeName":"Beetroot Burger","totalTimeInSeconds":2400,"attributes":{"course":["Lunch"]},"flavors":{"piquant":0.16666666666666666,"meaty":0.16666666666666666,"bitter":0.16666666666666666,"sweet":0.3333333333333333,"sour":0.6666666666666666,"salty":0.16666666666666666},"rating":3},{"imageUrlsBySize":{"90":"https:\/\/lh3.googleusercontent.com\/K_EeYooFJnNdKokzHqdVzyuPMMacYrysnzQ4M4yhmvL_QvMlBxGAJTMI9UIzbyP_7B-cSDJ7RF9eaK5diju3NfA=s90-c"},"sourceDisplayName":"Amuse Your Bouche","ingredients":["veggie burgers","bread rolls","chutney","salad leaves","mature cheddar","apples"],"id":"Ploughman_s-Burgers-1374986","smallImageUrls":["https:\/\/lh3.googleusercontent.com\/zZoEv2e5hGdCnnBXEF5qBEoBFop6g92oJQreCiZZ9UEEVNldu8oMSCcNqBIjAVH-q0pOhbp094t_O0nVLKXDRw=s90"],"recipeName":"Ploughman\'s Burgers","totalTimeInSeconds":1500,"attributes":{"course":["Lunch"]},"flavors":null,"rating":4},{"imageUrlsBySize":{"90":"http:\/\/lh3.googleusercontent.com\/T5DNKkNUnW-Ab2E7pROU97vI1lah87GIznAnEJ12zn939UPeVOMg5Hk5H4PbvKIB6wOR988uMgBaCr06PlX2CQ=s90-c"},"sourceDisplayName":"Eat Well Living Thin","ingredients":["cooked quinoa","shredded cheddar cheese","low-fat cottage cheese","carrots","eggs","all-purpose flour","green onions","sugar","black pepper","ground cumin","salt","garlic powder","olive oil","quinoa","water"],"id":"QUINOA-BURGER-1108070","smallImageUrls":["http:\/\/lh3.googleusercontent.com\/rQwge1RPGTsR8lHnFW0yMBhRW1bXbGL_KHBXBHhSjinhoocUcmCUA4ZjPlg1CaxsVfMsah9kInyhKWJyLtXcnQ=s90"],"recipeName":"QUINOA BURGER","totalTimeInSeconds":2400,"attributes":{"course":["Lunch"]},"flavors":{"piquant":0,"meaty":0.16666666666666666,"bitter":0.16666666666666666,"sweet":0.16666666666666666,"sour":0.16666666666666666,"salty":0.5},"rating":4},{"imageUrlsBySize":{"90":"https:\/\/lh3.googleusercontent.com\/m1-1aLlIud8KOPsmW5MuVljoA-Xno1xSFJTngKLym98UqXNA9HRxpnKG3-qx6Oy4uiEw4oC4RU8OYWgfBFe5pA0=s90-c"},"sourceDisplayName":"Plattershare","ingredients":["burger rolls","cucumber","tomatoes","butter","carrots","beans","potatoes","lemon","pepper","all-purpose flour","oil","salt"],"id":"Vegetable-Burger-1461714","smallImageUrls":["https:\/\/lh3.googleusercontent.com\/oplvu42ZrX3iQol2sOpMxuJ6TzviNcrjRAZ5-QFz0K5pP2tFTHXlZ2g7b2q8dV0PKdnU4RxdhSNjeXBrcmy7=s90"],"recipeName":"Vegetable Burger","totalTimeInSeconds":2400,"attributes":{"course":["Lunch"]},"flavors":{"piquant":0,"meaty":0.16666666666666666,"bitter":0.16666666666666666,"sweet":0.16666666666666666,"sour":0.6666666666666666,"salty":0.16666666666666666},"rating":3},{"imageUrlsBySize":{"90":"https:\/\/lh3.googleusercontent.com\/4kr_z07X2aQeBcZjqWtOswuG5yb_jQrzoNQyaS_zC9aRoYssbi_Tf2Mu-PvNpVu2R_cLC36Iwfg5MQDJ2fN_hA=s90-c"},"sourceDisplayName":"The Last Food Blog","ingredients":["halloumi","egg yolks","water","sesame seeds","mushrooms","olive oil","sea salt","cracked black pepper","whole grain roll","onions","cilantro leaves","arugula","mango chutney","chili flakes","apple cider vinegar"],"id":"Halloumi-Burgers-2068893","smallImageUrls":["https:\/\/lh3.googleusercontent.com\/9yo1LOnRCtSfZpFQ0O3z054nf259pozNSM2vlRbf-7W6EwAdy-G9m-6MA0c1DoPr0Zc5Qe-Ytl04n2cX1x9FKQ=s90"],"recipeName":"Halloumi Burgers","totalTimeInSeconds":1800,"attributes":{"course":["Lunch"]},"flavors":null,"rating":4},{"imageUrlsBySize":{"90":"https:\/\/lh3.googleusercontent.com\/thqr_4r6alw7I-V2ehZWdZtVBv0YT70obRzoD6X8osXtnL13NK__cxVZVMBvBQq4qYcXAGzaNBvSecE1ADEqRQ=s90-c"},"sourceDisplayName":"Connoisseurus Veg","ingredients":["quinoa","vegetable broth","chickpeas","garlic cloves","vegan margarine","cayenne pepper sauce","chili powder","oats","scallions"],"id":"Buffalo-Chickpea-Quinoa-Burgers-1932299","smallImageUrls":["https:\/\/lh3.googleusercontent.com\/BDO3uMhiHb7pRsJ1U9cbTcI7lV7gN-fgPcmWdAbaaBPnRtkO5UcWYmNp_vZVaKOkDd2JYOKcQMVBIjY-f5GWqg=s90"],"recipeName":"Buffalo Chickpea Quinoa Burgers","totalTimeInSeconds":2100,"attributes":{"course":["Main Dishes"]},"flavors":null,"rating":4},{"imageUrlsBySize":{"90":"https:\/\/lh3.googleusercontent.com\/g_vn2V4aB8KcTa4kGKIapPB86vyhTS2TLFLAyOcMk5LYJXV-SY5M4gHGE-GstaYLJ8-SOJR6xQpxOcQqZ8h6-A=s90-c"},"sourceDisplayName":"Connoisseurus Veg","ingredients":["sweet potatoes","vegetable oil","red kidney beans","panko breadcrumbs","purple onion","garlic cloves","soy sauce","ground cumin","cayenne","salt","pepper","pineapple rings","oil","tomato paste","water","maple syrup","apple cider vinegar","burger buns","lettuce","tomatoes","vegan mayonnaise"],"id":"Vegan-Hawaiian-Burgers-1703063","smallImageUrls":["https:\/\/lh3.googleusercontent.com\/zCTnJx_noJPwUQZIvYp0GXJC3DSrol6vVRWb6N4j028Qw9ru315s0-tLWxAS1rvHpl2Tox7aKfpSxLTWPKhd=s90"],"recipeName":"Vegan Hawaiian Burgers","totalTimeInSeconds":2700,"attributes":{"course":["Main Dishes"],"cuisine":["Hawaiian"]},"flavors":{"piquant":0.16666666666666666,"meaty":0.16666666666666666,"bitter":0.8333333333333334,"sweet":0.5,"sour":0.8333333333333334,"salty":0.6666666666666666},"rating":4},{"imageUrlsBySize":{"90":"http:\/\/lh3.googleusercontent.com\/PPY2b21nxJ1g-_QF5c-22iNxTBvnMFuTDwhLPSqER7LBoRayHTVkZgYgEFl6Vvn4PVRuGp8YTzjk_MglREAe=s90-c"},"sourceDisplayName":"Delightful E Made","ingredients":["veggie patties","lettuce leaves","purple onion","fresh pineapple","bbq sauce","sesame seeds buns"],"id":"Hawaiian-Veggie-Burgers-1202694","smallImageUrls":["http:\/\/lh3.googleusercontent.com\/PwiwvGGT7-t4ILDp9M34nRbTHLpgg7SYTQjafkBB_BLlAnAVm0K0VUkA4ZMTMuMfnFCHyzqRqLdG5LqgMqgA=s90"],"recipeName":"Hawaiian Veggie Burgers","totalTimeInSeconds":1200,"attributes":{"course":["Main Dishes","Lunch"],"cuisine":["Barbecue","Kid-Friendly","Hawaiian"]},"flavors":null,"rating":4},{"imageUrlsBySize":{"90":"http:\/\/lh3.googleusercontent.com\/-crh4hGYSNwO1LB6KNZt48sQFxiKN7xMsRhrFp74cgsOsRSfKcDTjOiYPz3cixYtPsNeQcYN7VqDbVFGnS5xGA=s90-c"},"sourceDisplayName":"Driftwood Gardens","ingredients":["balsamic vinegar","soy sauce","garlic powder","onion powder","portobello caps"],"id":"Portobello-Burgers-1167731","smallImageUrls":["http:\/\/lh3.googleusercontent.com\/ozRFAXBC7uwAY363GpxLZUaXCcwm0Juv196g3yLH6L-jALVdaZjp_nGHGppZn5mQZ9Z-2aIOfnA75HPrbAj3_Q=s90"],"recipeName":"Portobello Burgers","totalTimeInSeconds":600,"attributes":{"cuisine":["Barbecue"]},"flavors":{"piquant":0,"meaty":0.16666666666666666,"bitter":0.8333333333333334,"sweet":0.5,"sour":0.16666666666666666,"salty":0.8333333333333334},"rating":4}],"facetCounts":{},"totalMatchCount":3963,"attribution":{"html":"Recipe search powered by <a href=\'http:\/\/www.yummly.co\/recipes\'><img alt=\'Yummly\' src=\'https:\/\/static.yummly.co\/api-logo.png\'\/><\/a>","url":"http:\/\/www.yummly.co\/recipes\/","text":"Recipe search powered by Yummly","logo":"https:\/\/static.yummly.co\/api-logo.png"}}');
        //return response()->json(['data' => var_dump($results)]);
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
        }
        return view('search.results', ['results' => $results, 
            'users_ingredients' => Auth::user()->ingredients()->get()]);
    }

    public function get($recipe_id)
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
            $r->salty = $recipe->flavors->Salty;
            $r->meaty = $recipe->flavors->Meaty;
            $r->piquant = $recipe->flavors->Piquant;
            $r->bitter = $recipe->flavors->Bitter;
            $r->sour = $recipe->flavors->Sour;
            $r->sweet = $recipe->flavors->Sweet;

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

        return view('recipe', ['recipe' => $this->toJson($r), 
                                'users_ingredients' => Auth::user()->ingredients()->get(),
                                'grocery_list' => Auth::user()->grocery_lists()
                                    ->where('status', 'open')
                                    ->where('recipe_id', $r->id)->first()
                            ]);
    }

    public function made(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        Auth::user()->recipes_made()->attach($request['id']);

        return view('recipe.made', ['ingredients', Recipe::find($request['id'])->ingredients()->get()]);
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

    protected function toJson($recipe) {
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

        $nutrition_estimate = new \stdClass();
        $nutrition_estimate->unit = new \stdClass();
        $r->nutritionEstimates = array();   // get template and clear array to fill with data from db
        foreach($recipe->nutrition_estimates()->get() as $estimate) {
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

        return $r;
    }

}
