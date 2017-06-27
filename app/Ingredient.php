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
}
