<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjects_class_course extends Model
{
    protected $table = 'subjects_class_course';
    protected $primaryKey = 'scc_id';
    public $timestamps = false;
    public static function view_all($data)
    {       
        return Subjects_class_course::where($data)->get();
    }

    public static function view_single($data)
    {       
        return Subjects_class_course::where($data)->first();
    }

    // public static function view_all_join_clascourse($data)
    // {       
    //     return Subjects_class_course::
    //     join('subjects','subjects.su_id','=','subjects_class_course.fk_subject_id')->
    //     join('classtable','classtable.cl_id','=','subjects_class_course.fk_class_id')->
    //     where($data)->get(['subjects.*','classtable.cl_name']);
    // }

    public static function view_all_comma_seprated_name($data)
    {       
        return Subjects_class_course::
        join('subjects','subjects.su_id','=','subjects_class_course.fk_subject_id')->
        join('classtable','classtable.cl_id','=','subjects_class_course.fk_class_id')->
        select(\DB::raw("GROUP_CONCAT(cl_name) as all_cl_name"))->        
        where($data)->first();
    }

         public static function view_all_single($data)
    {       
        return Subjects_class_course::
        select(\DB::raw("GROUP_CONCAT(fk_class_id) as scc_id_str"))->        
        where($data)->first();
    }

    public static function join_courseand_subject($data)
    {       
        return Subjects_class_course::
        join('subjects','subjects.su_id','=','subjects_class_course.fk_subject_id')->
        join('classtable','classtable.cl_id','=','subjects_class_course.fk_class_id')->
        where($data)->get(['subjects.*','classtable.cl_name']);
    }



   

       
}
