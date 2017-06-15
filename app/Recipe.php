<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public function courses()
    {
        return $this->belongsToMany('Recipr\Course', 'recipes_courses');
    }

    public function cuisines()
    {
        return $this->belongsToMany('Recipr\Cuisine', 'recipes_cuisines');
    }

    public function holidays()
    {
        return $this->belongsToMany('Recipr\Holiday', 'recipes_holidays');
    }

    public function nutrition_estimates()
    {
    	return $this->hasMany('Recipr\NutritionEstimate');
    }

    public function ingredient_lines()
    {
    	return $this->hasMany('Recipr\IngredientLine');
    }
}