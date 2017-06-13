<?php

namespace Recipr;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function inventories()
    {
        return $this->hasMany('Recipr\Inventory');
    }

    public function allergies()
    {
        return $this->belongsToMany('Recipr\Allergy', 'users_allergies');
    }

    public function diets()
    {
        return $this->belongsToMany('Recipr\Diet', 'users_diets');
    }

    public function ingredients()
    {
        return $this->belongsToMany('Recipr\Ingredient', 'users_ingredients')->withTimestamps();
    }
}
