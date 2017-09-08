<?php

namespace Recipr\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Recipr\Recipe;

use Recipr\Http\Controllers\RecipeController;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDashboard()
    {
        $recipe_ids = DB::select(DB::raw("SELECT recipe_id
            FROM 
                (SELECT recipe_id, COUNT(recipe_id) * 3 AS `num` 
                    FROM recipes_made 
                    WHERE created_at >= NOW() - INTERVAL 7 day
                    GROUP BY recipe_id 
                    UNION ALL 
                    SELECT recipe_id, COUNT(recipe_id) * 2 AS `num` 
                    FROM recipes_saved 
                    WHERE created_at >= NOW() - INTERVAL 7 day
                    GROUP BY recipe_id
                    UNION ALL 
                    SELECT recipe_id, COUNT(recipe_id) AS `num` 
                    FROM recipe_views 
                    WHERE created_at >= NOW() - INTERVAL 7 day
                    GROUP BY recipe_id) AS T 
                GROUP BY recipe_id 
                ORDER BY SUM(num)
                LIMIT 6"));

        $trending = array();
        $rc = new RecipeController();
        foreach($recipe_ids as $result) {
            array_push($trending, 
                app('Recipr\Http\Controllers\RecipeController')->toJson(Recipe::find($result->recipe_id)));
        }

        return view('dashboard', [
            'trending' => $trending
        ]);
    }
}
