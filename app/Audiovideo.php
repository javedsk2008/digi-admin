<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audiovideo extends Model
{
    protected $table = 'audiovideo';
    protected $primaryKey = 'av_id';
    public $timestamps = false;

    // public static function view_all($data)
    // {       
    //     return Audiovideo::where($data)->get();
    // }

    public static function view_single($where)
    {       
        return Audiovideo::
        join('chapter','chapter.ch_id','=','audiovideo.fk_chapter_id')->
        join('subjects','subjects.su_id','=','audiovideo.fk_subject_id')->
        where($where)->
        first(['audiovideo.*','chapter.ch_name','subjects.su_name']);
    }

    public static function view_all($where)
    {
        return Audiovideo::
        join('chapter','chapter.ch_id','=','audiovideo.fk_chapter_id')->
        join('subjects','subjects.su_id','=','audiovideo.fk_subject_id')->
        where($where)->orderBy('av_id','DESC')->
        get(['audiovideo.*','chapter.ch_name','subjects.su_name']);
    }

    
}
