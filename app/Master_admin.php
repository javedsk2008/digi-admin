<?php

namespace App;
namespace App;
use Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;

class Master_admin extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected $fillable = [
     'email', 'password',
    ];
    protected $hidden = [
        'password',
    ];

    /**
     * Automatically creates hash for the user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // public static function view_all($where)
    // {       
    //     //return Master_admin::where($data)->get();
    //     return Master_admin::
    //         Leftjoin('role','role.ro_id','=','master_admin.fk_role_id')->
    //         Leftjoin('classtable','classtable.cl_id','=','master_admin.fk_class_id')->
    //         Leftjoin('school','school.sc_id','=','master_admin.fk_school_id')->
    //         where($where)->orderBy('id','ASC')->
    //         get(['master_admin.*','role.ro_name','classtable.cl_name','school.sc_name']);
    // }

    // public static function view_single($where)
    // {       
    //     //return Master_admin::where($data)->first();
    //     return Master_admin::
    //         Leftjoin('role','role.ro_id','=','master_admin.fk_role_id')->
    //         Leftjoin('classtable','classtable.cl_id','=','master_admin.fk_class_id')->
    //         Leftjoin('school','school.sc_id','=','master_admin.fk_school_id')->
    //         where($where)->orderBy('id','ASC')->
    //         first(['master_admin.*','role.ro_name','classtable.cl_name','school.sc_name']);
    // }

    public static function view_all($where)
    {       
        //return Master_admin::where($data)->get();
        return Master_admin::
            Leftjoin('role','role.ro_id','=','users.fk_role_id')->
            Leftjoin('classtable','classtable.cl_id','=','users.fk_class_id')->
            Leftjoin('school','school.sc_id','=','users.fk_school_id')->
            where($where)->orderBy('id','ASC')->
            get(['users.*','role.ro_name','classtable.cl_name','school.sc_name']);
    }

    public static function view_single($where)
    {       
        //return Master_admin::where($data)->first();
        return Master_admin::
            Leftjoin('role','role.ro_id','=','users.fk_role_id')->
            Leftjoin('classtable','classtable.cl_id','=','users.fk_class_id')->
            Leftjoin('school','school.sc_id','=','users.fk_school_id')->
            where($where)->orderBy('id','ASC')->
            first(['users.*','role.ro_name','classtable.cl_name','school.sc_name']);
    }

    public static function checkcount($where)
    {       
        return Master_admin::where($where)->count();
    }

    
}
