<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class scs extends Model
{
    //
    public static function getData($data=array()){
      $value=DB::table('scs')
      ->where($data)
      ->orderBy('folder_file_name','ASC')
      ->get();
    return $value;
  }
  public static function getDataById($data=array()){
      $value=DB::table('scs')
      ->where($data)
      ->orderBy('folder_file_name','ASC')
      ->first();
    return $value;
  }
  public static function countData($data=array()){
      $value=DB::table('scs')
      ->where($data)
      ->count();
    return $value;
  }

  public static function insertData($data=array()){
  		DB::table('scs')->insert($data);
      return true;
  }

  public static function updateData($ids=array(),$data=array()){
  	
    $scs=DB::table('scs')
      ->where('school_id',"=",$ids['school_id'])
      ->where('folder_file_id',"=",$ids['folder_file_id'])
      ->update($data);

      $value=DB::table('scs')
      ->where('school_id',"=",$ids['school_id'])
      ->where('folder_file_id',"=",$ids['folder_file_id'])
      ->first();
      return $value;
  }

  public static function searchData($data=array()){
  	
    $response=DB::table('scs')
      ->where('school_id',"=",$data['school_id'])
      ->where('folder_file_name',"LIKE","%".$data['folder_file_name']."%")
      ->get();

      return $response;
  }

  public static function deleteData($data=array()){
    DB::table('scs')
    ->where('school_id',"=",$data['school_id'])
    ->where('folder_file_id',"=",$data['folder_file_id'])
    ->whereOr('file_hierarchy','like','%'.$data['folder_file_id'].'%')
    ->delete();
    return true;
  }
}
