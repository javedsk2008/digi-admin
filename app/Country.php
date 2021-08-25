<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function view_all($data)
    {       
        return Country::where($data)->orderBy('name','ASC')->get();
    }

    public static function view_single($data)
    {       
        return Country::where($data)->first();
    }

    
}
