<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class RecipeSearch extends Model
{
    public function user() {
    	return $this->belongsTo('Recipr\User');
    }

    public function allergies()
    {
        return $this->belongsToMany('Recipr\Allergy', 'recipe_searches_allergies');
    }

    public function courses()
    {
        return $this->belongsToMany('Recipr\Course', 'recipe_searches_courses');
    }

    public function cuisines()
    {
        return $this->belongsToMany('Recipr\Cuisine', 'recipe_searches_cuisines');
    }

    public function diets()
    {
        return $this->belongsToMany('Recipr\Diet', 'recipe_searches_diets');
    }

    public function holidays()
    {
        return $this->belongsToMany('Recipr\Holiday', 'recipe_searches_holidays');
    }
}
