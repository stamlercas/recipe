<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class IngredientLine extends Model
{
    public function recipe()
    {
    	return $this->belongsTo('Recipr\Recipe');
    }
}
