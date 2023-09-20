<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class license_keys extends Model
{
    //
        protected $fillable=['school_id','license_key','activated_from','end_date','days','price','free_trial'];


        public function schools()
        {
        $this->belongTo('App\Schools');
        }

        public static function getLicense($school_id){

         $LicenseKey=license_keys::select('*')
            ->where('school_id','=',$school_id)
            ->first();


         $date1 = strtotime(date('Y-m-d H:i:s'));  //now
         $date2 = strtotime($LicenseKey->end_date);  
         $remain_sec = $date2 - $date1; 
         $diff = abs($date2 - $date1); 
         $years = floor($diff / (365*60*60*24)); 
         $months = floor(($diff - $years * 365*60*60*24)  / (30*60*60*24));   
         $days = floor(($diff - $years * 365*60*60*24 -  $months*30*60*60*24)/ (60*60*24)); 
         $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
         $minutes = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);   
         $seconds = floor(($diff - $years * 365*60*60*24- $months*30*60*60*24 - $days*60*60*24- $hours*60*60 - $minutes*60));  
         $elapsed_time=array('license_key'=>$LicenseKey,'years'=>$years,'months'=>$months,'days'=>$days,'remain_sec'=>$remain_sec);

        return $elapsed_time;
  }


  public static function get_free_license($school_id,$days,$uuid){
           $number_of_days=$days;
           $now=date("Y-m-d H:i:s");

            $end_date=date('Y-m-d H:i:s', strtotime($now. "+$number_of_days day"));
            $license_keys=new license_keys();
            $license_keys->school_id=$school_id;
            $license_keys->license_key=$uuid;
            $license_keys->activated_from=$now;
            $license_keys->end_date=$end_date;
            $license_keys->days=$number_of_days;
            $license_keys->save();

            return true;
  }

}
