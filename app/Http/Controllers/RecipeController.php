<?php

namespace Recipr\Http\Controllers;

use Recipr\Allergy;
use Recipr\User;
use Recipr\Diet;
use Recipr\Cuisine;
use Recipr\Course;
use Recipr\Holiday;
use Recipr\RecipeSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('search', [
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
        $url = $this->api_url . "/recipes?_app_id=" . env('APP_ID') . "&_app_key=" . env('API_KEY');
        if ($recipe_search->query != null)
            $url .= "&q=" . urlencode($recipe_search->query);

        $url .= $this->append($request, Allergy::get(), 'allowedAllergy[]');
        $url .= $this->append($request, Course::get(), 'allowedCourse[]');
        $url .= $this->append($request, Cuisine::get(), 'allowedCuisine[]');
        $url .= $this->append($request, Diet::get(), 'allowedDiet[]');
        $url .= $this->append($request, Holiday::get(), 'allowedHoliday[]');

        //return response()->json(['data' => $url]);
        $json = json_decode(file_get_contents("http://localhost:8000"));
        return response()->json($json);
        return redirect()->route('search.index');
    }

    protected function append($request, $table, $parameter)
    {
        $str = '';
        foreach ($table as $value) {
            if ($request[str_replace(" ", '_', $value->id)]) {  // really needs put into middleware somehow
                $str .= "&" . $parameter . "=" . $value->searchValue;
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

}
