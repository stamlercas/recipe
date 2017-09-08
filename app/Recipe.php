<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public $incrementing = false;
    
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

    public function ingredients()
    {
        return $this->belongsToMany('Recipr\Ingredient', 'recipes_ingredients');
    }

    public function nutrition_estimates()
    {
    	return $this->hasMany('Recipr\NutritionEstimate');
    }

    public function ingredient_lines()
    {
    	return $this->hasMany('Recipr\IngredientLine');
    }

    public function users_made() {
        return $this->belongsToMany('Recipr\User', 'recipes_made')->withTimestamps();
    }

    public function users_saved() {
        return $this->belongsToMany('Recipr\User', 'recipes_saved')->withTimestamps();
    }

    public function users_viewed() {
        return $this->belongsToMany('Recipr\User', 'recipe_views')->withTimestamps();
    }
}
