<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'q_id';
    public $timestamps = false;

  
    public static function view_all($where)
    {       
       // return Questions::where($data)->get();
        return Questions::
        join('chapter','chapter.ch_id','=','questions.fk_chapter_id')->
        join('subjects','subjects.su_id','=','questions.fk_subject_id')->
        where($where)->orderBy('q_id','DESC')->
        get(['questions.*','chapter.ch_name','subjects.su_name']);
    }

    public static function view_all_imagetracing($where)
    {       
       // return Questions::where($data)->get();
        return Questions::where($where)->orderBy('q_id','DESC')->get();
    }

    public static function view_single($data)
    {       
        return Questions::where($data)->first();
    }

    
}
