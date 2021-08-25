<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'school';
    protected $primaryKey = 'sc_id';
    public $timestamps = false;

    public static function view_all($data)
    {       
        return School::where($data)->get();
    }

    public static function view_single($data)
    {       
        return School::where($data)->first();
    }

    
}
