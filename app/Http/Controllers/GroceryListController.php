<?php

namespace Recipr\Http\Controllers;

use Recipr\GroceryList;
use Recipr\Ingredient;
use Recipr\Recipe;
use Recipr\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroceryListController extends Controller
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

    public function index()
    {
        $grocery_lists = Auth::user()->grocery_lists()->where('status', 'open')->get();
        return view('grocery_list.index', ['grocery_lists' => $grocery_lists]);
    }

    public function create(Request $request)
    {
        $grocery_list = new GroceryList();

        $this->validate($request, [
            'name' => 'required'
        ]);

        // to differentiate lists and make them unique by user
        // first get number of entries the user has that start with the slug
        // append that number to the end
        $numberOfListsBySlug = count(Auth::user()->grocery_lists()
            ->where('slug', 'like', str_slug($request['name']) . '%')->get());
        if ($numberOfListsBySlug > 0) {
            $grocery_list->slug = str_slug($request['name']) . '-' . $numberOfListsBySlug;
        } else {
            $grocery_list->slug = str_slug($request['name']);
        }

        $grocery_list->name = $request['name'];
        $grocery_list->recipe_id = (isset($request['id'])) ? $request['id'] : null;

        if (Auth::user()->grocery_lists()->save($grocery_list)) {
            // if recipe_id is set, then add the ingredients you need
            if ($grocery_list->recipe_id != null) {
                $ingredientsToAdd = Recipe::find($grocery_list->recipe_id)->ingredients()
                    ->whereNotIn('recipes_ingredients.id', Auth::user()->ingredients()->select('ingredient_id')->get())->get();
                $grocery_list->ingredients()->attach($ingredientsToAdd);
            }

            // return redirect()->route('recipe.get', ['recipe_id' => $grocery_list->recipe_id]);
            return redirect()->route('grocery_list.get', [
                'username' => Auth::user()->username,
                'slug' => $grocery_list->slug
            ]);
        }
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'item' => 'required|max:20'
        ]);
        $item = Inventory::find($request['id']);
        if (Auth::user() != $item->user)    //making sure users don't delete other user's posts
        {
            return redirect()->back();
        }
        $item->item = $request['item'];
        $item->update();
        return response()->json(['item' => $item], 200);
    }

    public function get($username, $grocery_list_slug) {
        $grocery_list = $this->getGroceryList($grocery_list_slug);
        $ingredients = $grocery_list->ingredients()->get();
        $users_ingredients = Auth::user()->ingredients()->get();
        return view('grocery_list.list', [
                'grocery_list' => $grocery_list,
                'ingredients' => $ingredients,
                'users_ingredients' => $users_ingredients
            ]);
    }

    //uses the 'id' index of request to find the ingredient and add to a list if not already there
    public function addIngredient($username, $grocery_list_slug, Request $request) {
        $this->validate($request, [
            'ingredient_id' => 'required'
        ]);
        $ingredient = Ingredient::find($request['ingredient_id']);
        $grocery_list = $this->getGroceryList($grocery_list_slug);
        if (!$grocery_list->ingredients()->find($ingredient->id))
        {
            $grocery_list->ingredients()->attach($ingredient->id);
            return response()->json(['success' => true, 'ingredient' => $ingredient], 200);
        } else {
            return response()->json(['success' => false, 'ingredient' => null], 200);
        }
    }

    public function delete($ingredient_id)
    {
        $ingredient = Ingredient::where('id', $ingredient_id)->first();

        Auth::user()->ingredients()->detach($ingredient->id);
        
        return response()->json(['success' => true, 'message' => 'Item successfully deleted!'], 200);
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'query' => 'required'
        ]);
        $results = Ingredient::where('description', 'like', '%' . $request['query'] . '%')->limit(10)->get();
        return response()->json(['success' => true, 'results' => $results], 200);
    }

    protected function getGroceryList($slug) {
        return Auth::user()->grocery_lists()->where('slug', $slug)->first();
    }

}
