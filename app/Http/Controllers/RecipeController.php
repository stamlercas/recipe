<?php

namespace Recipr\Http\Controllers;

use Recipr\Allergy;
use Recipr\User;
use Recipr\Diet;
use Recipr\Cuisine;
use Recipr\Course;
use Recipr\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
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

    public function search()
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

    public function create(Request $request)
    {
        //validation
        $this->validate($request, [
            'item' => 'required|max:20',
        ]);
        $inventory = new Inventory();
        $inventory->item = $request['item'];
        $inventory->user_id = Auth::user()->id;

        $message = 'There was an error.';
        if ($inventory->save()) //save post in relation to user
        {
            $message = 'Item successfully added!';
            return response()->json(['success' => true, 'item' => $inventory, 'message' => $message], 200);
        }
        return response()->json(['success' => false, 'message' => $message], 200);
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

    public function delete($inventory_id)
    {
        $item = Inventory::where('id', $inventory_id)->first();

        if (Auth::user() != $item->user)    //making sure users don't delete other user's posts
        {
            return redirect()->json(['success' => false, 'message' => 'You are not the correct user.'], 200);
        }
        $item->delete();
        
        return response()->json(['success' => true, 'message' => 'Item successfully deleted!'], 200);
    }

}
