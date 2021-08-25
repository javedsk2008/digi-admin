<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $table = 'chapter';
    protected $primaryKey = 'ch_id';
    public $timestamps = false;

    public static function view_all($data)
    {       
        return Chapter::where($data)->get();
    }

    public static function view_single($data)
    {       
        return Chapter::where($data)->first();
    }

    public static function view_all_withjoin($where)
    {
        return Chapter::
        join('subjects','subjects.su_id','=','chapter.fk_subject_id')->
        where($where)->
        first(['chapter.*','subjects.su_name']);
    }

    
}
