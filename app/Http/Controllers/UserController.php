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
}