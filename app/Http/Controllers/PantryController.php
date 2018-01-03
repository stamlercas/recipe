<?php

namespace Recipr\Http\Controllers;

use Recipr\Inventory;
use Recipr\Ingredient;
use Recipr\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PantryController extends Controller
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
        $pantry = Auth::user()->ingredients()->orderBy('created_at', 'desc')->get();

        return view('pantry', ['pantry' => $pantry]);
    }

    public function add(Request $request)
    {
        //return response()->json(['success' => $request['id']]);
        //$ingredient = $request['ingredient'];
        $ingredient = Ingredient::find($request['id']);
        $user = Auth::user();
        if (!$user->ingredients()->find($ingredient->id))
        {
            $user->ingredients()->attach($ingredient->id);
            return response()->json(['success' => true, 'ingredient' => Auth::user()->ingredients()->where('ingredient_id', $ingredient->id)->first() ], 200);
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

}
