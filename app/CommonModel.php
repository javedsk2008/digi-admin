<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session; 
use Storage;
use File;
use ZipArchive;
use Zipper;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Intervention\Image\ImageManagerStatic as Image;

class CommonModel  extends Model
{
    protected $table = 'admin_role';
    public $timestamps = true;

   
    public static function add_slug($table_name,$slugstr){
         $slugid = \DB::table($table_name)->select('*')->where('slug',$slugstr)->get();            
        return count($slugid)==0?$slugstr:self::add_slug($table_name,bin2hex(openssl_random_pseudo_bytes(5)));
    } 
    public static  function upload_file($imgcheck,$imgname,$path)
    {
        $image       = $imgname;
        $extension = $image->getClientOriginalExtension();
        $filename    = $image->getClientOriginalName();
        $target = $path;
        $randomstr = str_random(20);
        $image->storeAs($target,$randomstr.'.'.$extension,'public');            
        return $filename = Config('app.url').'/'.'storage/'.$path.'/'.$randomstr.'.'.$extension;
    }

    public static function sub_question_data($table_name,$fk_question_id){
       return $data = \DB::table($table_name)->select('*')->where('fk_question_id',$fk_question_id)->get();            
       
   }

    public static function userdetails($userdata)
        {
            return $userdata->toUser();
        }
    
}
