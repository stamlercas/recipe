<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    public function users() {
        return $this->belongsToMany('Recipr\User', 'users_allergies');
    }

    public function recipe_searches() {
        return $this->belongsToMany('Recipr\RecipeSearch', 'recipe_searches_allergies');
    }
}
