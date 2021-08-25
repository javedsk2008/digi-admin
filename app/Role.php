<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'ro_id';
    public $timestamps = false;

    public static function view_all($data)
    {       
        return Role::where($data)->get();
    }

    public static function view_single($data)
    {       
        return Role::where($data)->first();
    }

    
}
