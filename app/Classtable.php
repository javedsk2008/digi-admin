<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classtable extends Model
{
    protected $table = 'classtable';
    protected $primaryKey = 'cl_id';
    public $timestamps = false;
    public static function view_all($data)
    {       
        return Classtable::where($data)->orderBy('cl_id','ASC')->get();
    }

         public static function view_all_not_same_id($data,$cl_id)
    {       
        return Classtable::where($data)->where('cl_id','!=',$cl_id)->orderBy('cl_id','ASC')->get();
    }

    public static function view_single($data)
    {       
        return Classtable::where($data)->first();
    }

    public static function autosearch_class($where,$string)
    {       
        //return $string;
        return Classtable::where($where)->where('cl_name', 'like', '%' .$string. '%')->get();
    }


   
}
