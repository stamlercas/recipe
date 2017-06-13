<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class RecipeSearch extends Model
{
    public function user() {
    	return $this->belongsTo('Recipr\User');
    }
}
