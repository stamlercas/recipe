<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class GroceryList extends Model
{
    public function users() {
    	return $this->belongsTo('Recipr\User');
    }

    public function ingredients() {
    	return $this->belongsToMany('Recipr\Ingredient', 'grocery_lists_ingredients');
    }
}
