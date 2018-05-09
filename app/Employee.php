<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];

    public function user(){

        return $this->belongsTo('App\User','users_id');
    }

    public function country(){

        return $this->belongsTo('App\Country','country_id');
    }

    public function city(){

        return $this->belongsTo('App\City','city_id');
    }

    public function state(){

        return $this->belongsTo('App\State','state_id');
    }

    public function department(){

        return $this->belongsTo('App\Department','department_id');
    }

    public function organization(){

        return $this->belongsTo('App\Division','division_id');
    }

}
