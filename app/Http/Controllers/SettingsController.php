<?php

namespace Recipr\Http\Controllers;

use Recipr\User;
use Recipr\Allergy;
use Recipr\Diet;
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
            'users_allergies' => Auth::user()->allergies()->get(),
            'diets' => Diet::get(),
            'users_diets' => Auth::user()->diets()->get()
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
            if ($request[$allergy->id] && !$user->allergies()->find($allergy->id)) {
                $allergy->users()->attach($user->id);
            } else if ($request[$allergy->id] && $user->allergies()->find($allergy->id)) {
                ;
            } else {
                $allergy->users()->detach($user->id);
            }
        }
        /*
        // updating allergies
        $allergies = Allergy::get();
        foreach ($allergies as $allergy) {
            if ($request[$allergy->id] && !$user->allergies()->find($allergy->id)) {
                $allergy->users()->attach($user->id);
            } else if ($request[$allergy->id] && $user->allergies()->find($allergy->id)) {
                ;
            } else {
                $allergy->users()->detach($user->id);
            }
        }
        */
        // updating diet
        $diets = Diet::get();
        foreach ($diets as $diet) {
            if ($request['diet'] == $diet->id) {
                $diet->users()->attach($user->id);
            } else {
                $diet->users()->detach($user->id);
            }
        }

        //$this->updateIntersects($request, Diet::get(), $user->diets());

        return redirect()->route('settings');
    }

    function updateIntersects($request, $table, $intersect)
    {
        foreach ($table as $value) {
            if ($request[$value->id] && !$intersect->find($value->id)) {
                $intersect->attach($value->id);
            } else if ($request[$value->id] && $intersect->find($value->id)) {
                ;
            } else {
                $intersect->detach($value->id);
            }
        }
    }
}