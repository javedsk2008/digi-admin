<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ques_mcq extends Model
{
    protected $table = 'ques_mcq';
    protected $primaryKey = 'mcq_id';
    public $timestamps = false;

    // public static function view_all($data)
    // {       
    //     return Audiovideo::where($data)->get();
    // }

    public static function view_all($data)
    {       
        return Ques_mcq::where($data)->get();
    }

    public static function view_single($data)
    {       
        return Ques_mcq::where($data)->first();
    }

    
}
