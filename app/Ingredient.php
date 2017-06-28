<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public function users() {
        return $this->belongsToMany('Recipr\User', 'users_ingredients')->withTimestamps();
    }

    public function recipes()
    {
    	return $this->belongsToMany('Recipr\Recipe', 'recipes_ingredients');
    }

    public function grocery_lists() {
    	return $this->belongsToMany('Recipr\GroceryList', 'grocery_lists_ingredients');
    }
}
