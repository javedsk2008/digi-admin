<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'py_id';
    public $timestamps = false;

    public static function view_all($data)
    {       
        return Payments::where($data)->get();
    }

    public static function view_single($data)
    {       
        return Payments::where($data)->first();
    }

   

    
}
