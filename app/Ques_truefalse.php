<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ques_truefalse extends Model
{
    protected $table = 'ques_truefalse';
    protected $primaryKey = 'tf_id';
    public $timestamps = false;

    public static function view_all($data)
    {       
        return Ques_truefalse::where($data)->get();
    }

    public static function view_single($data)
    {       
        return Ques_truefalse::where($data)->first();
    }

    
}
