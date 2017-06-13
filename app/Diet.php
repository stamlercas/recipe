<?php

namespace Recipr;

use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    public function users() {
        return $this->belongsToMany('Recipr\User', 'users_diets');
    }
}
