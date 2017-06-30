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
        $grocery_lists = Auth::user()->grocery_lists()->where('status', 'open')->orderBy('created_at', 'desc')->get();
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
                $ingredients = Recipe::find($grocery_list->recipe_id)->ingredients()->get();
                $users_ingredients = Auth::user()->ingredients()->get();
                $ingredientsToAdd = array();

                foreach($ingredients as $ingredient) {
                    $found = false;
                    foreach($users_ingredients as $ingredient_in_pantry) {
                        if ($ingredient->id == $ingredient_in_pantry->id) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        array_push($ingredientsToAdd, $ingredient->id);
                    }
                }

                $grocery_list->ingredients()->attach($ingredientsToAdd);
            }

            // return redirect()->route('recipe.get', ['recipe_id' => $grocery_list->recipe_id]);
            return redirect()->route('grocery_list.get', [
                'username' => Auth::user()->username,
                'slug' => $grocery_list->slug
            ]);
        }
    }

    public function close($username, $grocery_list_slug, Request $request) {
        $grocery_list = Auth::user()->grocery_lists()->where('slug', $grocery_list_slug)->first();
        if ($grocery_list != null) {
            $grocery_list->status = 'closed';
            $grocery_list->update();

            if ($request->ajax()) {
                return response()->json(['success' => true]);
            } else {
                return ($grocery_list->recipe_id == null) ? redirect()->route('grocery_lists') : redirect()->route('recipe.get', ['recipe_id' => $grocery_list->recipe_id]);
            }
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

    protected function getGroceryList($slug) {
        return Auth::user()->grocery_lists()->where('slug', $slug)->first();
    }

}
