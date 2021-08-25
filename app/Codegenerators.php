<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codegenerators extends Model
{
    protected $table = 'codegenerators';
    protected $primaryKey = 'co_id';
    public $timestamps = false;

    public static function view_all($data)
    {       
        return Codegenerators::where($data)->orderBy('co_id','DESC')->get();
    }
public static function view_all_join($data)
    {       
      
        return User_regi_code::
        join('codegenerators','codegenerators.co_code','=','user_regi_code.regi_code')->
        join('school','school.slug','=','codegenerators.fk_school_slug')->
        leftjoin('schoolbranch','schoolbranch.slug','=','codegenerators.fk_branch_slug')->
        where($data)->orderBy('co_id','DESC')->get();

}
    public static function view_single($data)
    {       
        return Codegenerators::where($data)->first();
    }

    
}
