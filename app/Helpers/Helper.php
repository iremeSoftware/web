<?php 

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;


use Hash;

use App\User;

use App\Tokens;


use Mail;

use File;

use Log;

use Setting;

use DB;

class Helper {

    public static function clean($string) {

        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public static function web_url() {
        return url('/');
    }

    public static function now() {
        return date('Y-m-d H:i:s');
    }

    // Note: $error is passed by reference
    public static function is_token_valid($entity,$token) {
        if ($entity== 'tokens' && ($row = Tokens::where('token', '=', $token)->first()) )
         {
            if ($row->token_expiry > time()) {
                // Token is valid
                return true;
            } else {
                
                return false;
            }
        }
        return false;
    }

    // Convert all NULL values to empty strings
    public static function null_safe($arr) {
        $newArr = array();
        foreach ($arr as $key => $value) {
            $newArr[$key] = ($value == NULL) ? "" : $value;
        }
        return $newArr;
    }

    public static function generate_token() {
        return Helper::clean(Hash::make(rand() . time() . rand()));
    }

    public static function generate_token_expiry($minutes) {
        return time() + $minutes*60; 
    }

    public static function generate_user_id() {
        return Helper::clean(Hash::make(rand().rand()));
    }
    public static function generate_file_id()
    {
        $alpha='0123456789';
        return substr(str_shuffle($alpha),0,8);
    }

    public static function generate_password() {
        $new_password = time();
        $new_password .= rand();
        $new_password = sha1($new_password);
        $new_password = substr($new_password,0,8);
        return $new_password;
    }

    public static function upload_file($folder,$file,$valid_extension = array()) {

        $file_name = Helper::file_name();

        $ext = $file->getClientOriginalExtension();

        $local_url = $file_name . "." . $ext;
        if($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif" )
        {

        if($ext == "jpg" || $ext == "jpeg")
        {
         $src = imagecreatefromjpeg($file);
        }
        else if($ext == "png")
        {
         $src = imagecreatefrompng($file);
        }
        else 
        {
        $src = imagecreatefromgif($file);
        }

        $img = $src;

        list($width,$height)=getimagesize($file);
        if($folder=='bank_slips')
        {
            $newwidth=600;
        }
        else
        {
           $newwidth=100; 
        }
        
        $newheight=($height/$width)*$newwidth;
        $tmp=imagecreatetruecolor($newwidth,$newheight);
        imagecopyresampled($tmp,$img,0,0,0,0,$newwidth,$newheight,$width,$height);
        imagejpeg($tmp,"$folder/".$file_name. "." . $ext,100);

        return $local_url;

        }
        
        else if(in_array(strtolower($ext),$valid_extension)){

        $file->move($folder, $file_name . "." . $ext);

        $url = $local_url;

        return $url;
    }
    
    }

    public static function upload_file_to_AWS($folder,$file) {

           $name = Helper::file_name().'.'.$file->getClientOriginalExtension();
           $filePath = $folder.'/'. $name;
           $url = 'https://'.env('AWS_BUCKET').'.s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . $folder . '/'.$name;
           Storage::disk('s3')->put($filePath, file_get_contents($file),'public');
           return $url; 
    }

    public static function delete_file_from_AWS($url) {

           $url = parse_url($url);
           $delete_file=Storage::disk('s3')->delete($url);
           if($delete_file)
           {
            return true;
           }
           else
           {
            return false;
           }
           
    }

    public static function delete_file($folder,$picture) {
        File::delete($folder."/". basename($picture));
        return true;
    }

    public static function file_name() {

        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);

        return $file_name;
    }



    public static function time_diff($start,$end) {
        $start_date = new \DateTime($start);
        $end_date = new \DateTime($end);

        $time_interval = date_diff($start_date,$end_date);
        return $time_interval;

    }

    public static function formatHour($date) {
        $hour_time  = date("H:i:s",strtotime($date));
        return $hour_time;
    }

    public static function formatDate($date) {
        $newdate  = date("Y-m-d",strtotime($date));
        return $newdate;
    }

    public static function formatMonth() {
        $month  = date("F");
        return $month;
    }

    public static function add_date($date,$no_of_days) {

        $change_date = new \DateTime($date);
        $change_date->modify($no_of_days." hours");
        $change_date = $change_date->format("Y-m-d H:i:s");
        return $change_date;
    }

    public static function days_of_month($month) {

        $year=date('Y');
        if($month=='Jan')
        {
            $month='31';
        }
        else if($month=='Feb' && $year%4==0)
        {
            $month='29';
        }
        else if($month=='Feb' && $year%4!==0)
        {
            $month='28';
        }
        else if($month=='Mar')
        {
            $month='31';
        }
        else if($month=='Apr')
        {
            $month='30';
        }
        else if($month=='May')
        {
            $month='31';
        }
        else if($month=='Jun')
        {
            $month='30';
        }
        else if($month=='Jul')
        {
            $month='31';
        }
        else if($month=='Aug')
        {
            $month='31';
        }
        else if($month=='Sep')
        {
            $month='30';
        }
        else if($month=='Oct')
        {
            $month='31';
        }
        else if($month=='Nov')
        {
            $month='30';
        }
        else if($month=='Dec')
        {
            $month='31';
        }

        return $month;



        }

        public static function checkIfFileExists($file,$folder,$default){
           
            if(filter_var($file, FILTER_VALIDATE_URL) === FALSE)
            {
                
                if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$folder.'/'.($file!="" ? $file : 'null')))
                {
                    return $default;
                }

                return $file;
            }

            return $file;
        }
        



}