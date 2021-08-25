<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_regi_code extends Model
{
    protected $table = 'user_regi_code';
    protected $primaryKey = 'urc_id';
    public $timestamps = false;

    public static function view_all($data)
    {       
        return User_regi_code::where($data)->get();
    }

    public static function view_single($data)
    {       
        return User_regi_code::where($data)->first();
    }

    public static function view_all_join($data)
    {       
        return User_regi_code::
        join('codegenerators','codegenerators.co_code','=','user_regi_code.regi_code')->
        where($data)->get();
    }

public static function view_all_join_single($data)
    {       

//select sc_name,sb_location from user_regi_code urc join codegenerators cg on cg.co_code = urc.regi_code join school s on s.slug = cg.fk_school_slug left join schoolbranch sb on sb.slug = cg.fk_branch_slug GROUP By s.sc_id
        return User_regi_code::
        join('codegenerators','codegenerators.co_code','=','user_regi_code.regi_code')->
        join('school','school.slug','=','codegenerators.fk_school_slug')->
        leftjoin('schoolbranch','schoolbranch.slug','=','codegenerators.fk_branch_slug')->
        where($data)->orderBy('urc_id','ASC')->first();
    }

    
}
