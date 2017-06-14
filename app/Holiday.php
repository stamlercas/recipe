<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    public $incrementing = false;

    public function recipe_searches() {
        return $this->belongsToMany('Recipr\RecipeSearch', 'recipe_searches_holidays');
    }

    public function recipes() {
    	return $this->belongsToMany('Recipr\Recipes', 'recipes_holidays');
    }
}
