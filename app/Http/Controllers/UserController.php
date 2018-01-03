<?php

namespace Recipr\Http\Controllers;

use Recipr\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function saved($username) {
		$saved_recipes = Auth::user()->recipes_saved()->get();
		$formatted_saved_recipes = array();
		foreach($saved_recipes as $recipe) {
			array_push($formatted_saved_recipes, app('Recipr\Http\Controllers\RecipeController')->getRecipe($recipe->id));
		}
		return view('user.saved', [
			'saved_recipes' => $formatted_saved_recipes
		]);
	}

	public function getActivity($username) {

		$recipes_made = Auth::user()->recipes_made()->get()->map(function($item) {
			$item->table ="recipes_made";
			return $item;
		});
		$recipe_views = Auth::user()->recipe_views()->get()->map(function($item) {
			$item->table ="recipe_views";
			return $item;
		});
		$recipes_saved = Auth::user()->recipes_saved()->get()->map(function($item) {
			$item->table = "recipes_saved";
			return $item;
		});
		$collection = $recipes_made->concat($recipe_views)->concat($recipes_saved)->sortByDesc(function($item, $key) {
			return $item->pivot->created_at;
		})->take(50);
		return response()->view('user.activity', [
			'activity' => $collection->values()->all()
		]);
	}
}