<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answer';
    protected $primaryKey = 'a_id';
    public $timestamps = false;

    public static function view_all($data)
    {       
        return Answer::where($data)->get();
    }

    public static function view_single($data)
    {       
        return Answer::where($data)->first();
    }

    
}
