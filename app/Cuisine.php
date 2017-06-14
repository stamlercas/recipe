<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class Cuisine extends Model
{
    public $incrementing = false;

    public function recipe_searches() {
        return $this->belongsToMany('Recipr\RecipeSearch', 'recipe_searches_cuisines');
    }

    public function recipes() {
    	return $this->belongsToMany('Recipr\Recipes', 'recipes_cuisines');
    }
}
