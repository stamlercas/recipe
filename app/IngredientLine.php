<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class IngredientLine extends Model
{
	public $timestamps = false;

    public function recipe()
    {
    	return $this->belongsTo('Recipr\Recipe');
    }
}
