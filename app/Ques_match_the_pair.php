<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ques_match_the_pair extends Model
{
    protected $table = 'ques_match_the_pair';
    protected $primaryKey = 'mtp_id';
    public $timestamps = false;

   public static function view_all($data)
    {       
        return Ques_match_the_pair::where($data)->get();
    }

    public static function view_single($data)
    {       
        return Ques_match_the_pair::where($data)->first();
    }

    
}
