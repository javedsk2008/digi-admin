<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $table = 'subjects';
    protected $primaryKey = 'su_id';
    public $timestamps = false;

    public static function view_all($data)
    {       
        return Subjects::where($data)->get();
    }

    public static function view_all_join($where)
    {       
        return Subjects::
        join('subjects_class_course','subjects_class_course.fk_subject_id','=','subjects.su_id')->       
        where($where)->groupBy('subjects.su_id')->orderBy('su_id','DESC')->get();
    }

    public static function view_all_array_in($data,$array_in)
    {       
        return Subjects::where($data)->whereIn('su_id', $array_in)->get();
    }

    public static function view_single($data)
    {       
        return Subjects::where($data)->first();
    }

    public static function get_subject_from_courseclass($where)
    {       
        //return Subjects::where($data)->get();
        return Subjects::
        join('subjects_class_course','subjects_class_course.fk_subject_id','=','subjects.su_id')->       
        where($where)->orderBy('su_id','DESC')->
        get();
    }

  

    
}
