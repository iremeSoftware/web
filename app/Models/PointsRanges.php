<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PointsRanges extends Model
{
    //
  public static function getData($data=array()){
      $value=DB::table('marks_grades')
      ->join('courses','courses.course_id', '=', 'marks_grades.course_id')
      ->where($data)
      ->orderBy('courses.course_name')
      ->first();
    return $value;
  }
  
  public static function countData($data=array()){
      $value=DB::table('marks_grades')
      ->join('courses','courses.course_id', '=', 'marks_grades.course_id')
      ->where($data)
      ->count();
    return $value;
  }

  public static function insertData($data=array()){
  	
  		DB::table('marks_grades')->insert($data);
      return true;
  }

  public static function updateData($ids=array(),$data=array()){
  	
    $marks_grades=DB::table('marks_grades')
      ->where('school_id',"=",$ids['school_id'])
      ->where('class_id',"=",$ids['class_id'])
      ->where('course_id',"=",$ids['course_id'])
      ->where('term',"=",$ids['term'])
      ->update($data);
      return true;
  }

  public static function deleteData($data=array()){
    DB::table('marks_grades')
    ->where('school_id',"=",$data['school_id'])
    ->where('class_id',"=",$data['class_id'])
    ->where('course_id',"=",$data['course_id'])
    ->delete();
    return true;
  }
}
