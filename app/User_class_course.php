<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_class_course extends Model
{
    protected $table = 'user_class_course';
    protected $primaryKey = 'ucc_id';
    public $timestamps = false;
    public static function view_all($data)
    {       
        return User_class_course::where($data)->get();
    }

 public static function view_all_join($data)
    {       
        return User_class_course::
        join('classtable','classtable.cl_id','=','user_class_course.fk_class_id')->
        where($data)->get(['user_class_course.*','classtable.cl_name']);
    }

    public static function view_single($data)
    {       
        return User_class_course::where($data)->first();
    }

    public static function view_all_single($data)
    {       
        return User_class_course::
        select(\DB::raw("GROUP_CONCAT(fk_class_id) as scc_id"))->        
        where($data)->first();
    }

       
}
