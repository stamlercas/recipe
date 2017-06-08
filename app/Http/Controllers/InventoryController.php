<?php

namespace Recipr\Http\Controllers;

use Recipr\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
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

    public function getInventory()
    {
        $inventory = Inventory::where('user_id', Auth::user()->id);
        return view('inventory', ['inventory' => $inventory]);
    }

    public function delete($inventory_id)
    {
        $item = Post::where('id', $inventory_id)->first();
        if (Auth::user() != $item->user)    //making sure users don't delete other user's posts
        {
            return redirect()->json(['success' => false, 'message' => 'You are not the correct user.'], 200);
        }
        $item->delete();
        
        return response()->json(['success' => true, 'message' => 'Item successfully deleted!'], 200);
    }

}
