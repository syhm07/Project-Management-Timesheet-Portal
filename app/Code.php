<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'codes';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}