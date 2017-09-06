<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class NutritionAttribute extends Model
{
    public function recipe_searches() {
        return $this->belongsToMany('Recipr\RecipeSearch', 'recipe_searches_nutrition_attributes');
    }
}
