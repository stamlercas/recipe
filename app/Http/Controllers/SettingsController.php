<?php

namespace Recipr\Http\Controllers;

use Recipr\User;
use Recipr\Allergy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
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
        return view('settings', ['user' => Auth::user(), 
            'allergies' => Allergy::get(), 
            'users_allergies' => Auth::user()->allergies()->get()
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20'
        ]);
        $user = Auth::user();
        $user->first_name = $request['first_name']; 
        $user->last_name = $request['last_name'];
        
        $user->update();

        // updating allergies
        $allergies = Allergy::get();
        foreach ($allergies as $allergy) {
            if ($request[$allergy->allergy] && !$user->allergies()->find($allergy->id)) {
                $allergy->users()->attach($user->id);
            } else if ($request[$allergy->allergy] && $user->allergies()->find($allergy->id)) {
                ;
            } else {
                $allergy->users()->detach($user->id);
            }
        }

        return redirect()->route('settings');
    }
}