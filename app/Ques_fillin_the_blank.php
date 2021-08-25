<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ques_fillin_the_blank extends Model
{
    protected $table = 'ques_fillin_the_blank';
    protected $primaryKey = 'ftb_id';
    public $timestamps = false;

   public static function view_all($data)
    {       
        return Ques_fillin_the_blank::where($data)->get();
    }

    public static function view_single($data)
    {       
        return Ques_fillin_the_blank::where($data)->first();
    }

    
}
