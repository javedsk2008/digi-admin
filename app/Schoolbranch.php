<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schoolbranch extends Model
{
    protected $table = 'schoolbranch';
    protected $primaryKey = 'sb_id';
    public $timestamps = false;

    // public static function view_all($data)
    // {       
    //     return Schoolbranch::where($data)->get();
    // }

 public static function view_all($where)
    {
        return Schoolbranch::
        join('school','school.slug','=','schoolbranch.fk_school_slug')->
        where($where)->orderBy('sb_id','DESC')->
        get(['schoolbranch.*']);
    }

    public static function view_single($data)
    {       
        return Schoolbranch::where($data)->first();
    }

    
}
