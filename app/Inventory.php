<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }
}
