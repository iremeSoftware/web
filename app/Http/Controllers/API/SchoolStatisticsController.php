<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Marks;
use App\Models\Students;
use App\Models\Schoolfees;
use DB;

class SchoolStatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
              /**
        * @OA\Get(
        * path="/api/statistics/schoolfees/{school_id}",
        * operationId="getSchoolFeesStatistics",
        * tags={"Get school fees statistics API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *      @OA\Parameter(
        *         name="for",
        *         in="query",
        *         description="For",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="School fees statistics are successfully retrieved",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function schoolfees_statistics(Request $request)
    {
        //
        if($request->for=='student')
        {
           $student_id=$request->student_id;
           $school_fees=Schoolfees::select('*')
           ->join('students','students.student_id','=','schoolfees.student_id')
           ->where([
            ['schoolfees.student_id','=',$student_id],
            ['schoolfees.school_id',$request->school_id]
        ])
        ->get();
        }
        else if($request->for=='class')
        {
           $class_id=$request->class_id;
           $school_fees=Schoolfees::selectRaw('class_id,SUM(to_be_paid1) as to_be_paid1,SUM(amount_term1) as amount_term1,SUM(to_be_paid2) as to_be_paid2,SUM(amount_term2) as amount_term2,SUM(to_be_paid3) as to_be_paid3,SUM(amount_term3) as amount_term3')
           ->join('students','students.student_id','=','schoolfees.student_id')
           ->where([
            ['schoolfees.class_id','=',$class_id],
            ['schoolfees.school_id',$request->school_id]
        ])
        ->get();
        }
        else if($request->for=='school')
        {
           $school_id=$request->school_id;
           $school_fees=Schoolfees::selectRaw('schoolfees.class_id,classroom_name,SUM(to_be_paid1) as to_be_paid1,SUM(amount_term1) as amount_term1,SUM(to_be_paid2) as to_be_paid2,SUM(amount_term2) as amount_term2,SUM(to_be_paid3) as to_be_paid3,SUM(amount_term3) as amount_term3')
           ->join('students','students.student_id','=','schoolfees.student_id')
           ->join('classrooms','classrooms.class_id','=','schoolfees.class_id')
           ->groupBy('schoolfees.class_id')
           ->where([
            ['schoolfees.school_id','=',$school_id],
            ['schoolfees.school_id',$school_id]
        ])
        ->get();
        }

        return response()->json(['schoolfees'=>$school_fees,'message'=>'Retrieved successfully']);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Get(
        * path="/api/statistics/marks/{school_id}",
        * operationId="getMarksStatistics",
        * tags={"Get marks statistics API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *      @OA\Parameter(
        *         name="for",
        *         in="query",
        *         description="For",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Marks statistics are successfully retrieved",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function marks_statistics(Request $request)
    {
        //
        if($request->for=='student')
        {
           $student_id=$request->student_id;
          
        $marks=DB::table("report_form_$request->school_id")
           ->selectRaw("SUM(report_form_$request->school_id.term1_total_marks)/SUM(out_of_marks.term1_total_marks)*100 as term1_total_marks,SUM(report_form_$request->school_id.term2_total_marks)/SUM(out_of_marks.term2_total_marks)*100 as term2_total_marks,SUM(report_form_$request->school_id.term3_total_marks)/SUM(out_of_marks.term3_total_marks)*100 as term3_total_marks")
           ->join('students','students.student_id','=',"report_form_$request->school_id.student_id")
           ->join('out_of_marks','out_of_marks.class_id','=',"report_form_$request->school_id.class_id")
           ->where([
            ["report_form_$request->school_id.student_id",'=',$student_id],
            ["report_form_$request->school_id.school_id",$request->school_id]
        ])
        ->get();
        }
        else if($request->for=='class')
        {
           $class_id=$request->class_id;
           $count_records=DB::table("students")
           ->select("*")
           ->where([
            ["students.classroom",'=',$class_id],
            ["students.school_id",'=',$request->school_id]
        ])
        ->get()
        ->count();

           $marks=DB::table("marks")
           ->selectRaw("courses.course_name,courses.course_id,(marks.term1_total_marks*$count_records)/(out_of_marks.term1_total_marks*$count_records)*100 as term1_total_marks,(marks.term2_total_marks*$count_records)/(out_of_marks.term2_total_marks*$count_records)*100 as term2_total_marks,(marks.term3_total_marks*$count_records)/(out_of_marks.term3_total_marks*$count_records)*100 as term3_total_marks")
           ->join('students','students.student_id','=',"marks.student_id")
           ->join('out_of_marks','out_of_marks.course_id','=',"marks.course_id")
           ->join('courses','courses.course_id','=',"marks.course_id")
           ->groupBy('courses.course_id')
           ->where([
            ["marks.class_id",'=',$class_id],
            ["marks.school_id",'=',$request->school_id]
        ])
        ->get();
        }
        else if($request->for=='school')
        {
            


           $school_id=$request->school_id;
           $marks=DB::table("report_form_$school_id")
           ->selectRaw("classrooms.classroom_name,classrooms.class_id,SUM(`report_form_$school_id`.`term1_total_marks`)/SUM(`report_form_$school_id`.`term1_maximum_marks`)*100 as term1_total_marks,SUM(`report_form_$school_id`.`term2_total_marks`)/SUM(`report_form_$school_id`.`term2_maximum_marks`)*100 as term2_total_marks,SUM(`report_form_$school_id`.`term3_total_marks`)/SUM(`report_form_$school_id`.`term3_maximum_marks`)*100 as term3_total_marks")
           ->join('students','students.student_id','=',"report_form_$school_id.student_id")
           ->join('classrooms','classrooms.class_id','=',"report_form_$school_id.class_id")
           ->groupBy("report_form_$school_id.class_id")
           ->where([
            ["report_form_$school_id.school_id",'=',$school_id],
            ["report_form_$school_id.school_id",'=',$request->school_id]
        ])
        ->get();
           
        }

        return response()->json(['marks'=>$marks,'message'=>'Retrieved successfully']);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

         /**
        * @OA\Get(
        * path="/api/statistics/students/{school_id}",
        * operationId="getStudentsStatistics",
        * tags={"Get Students statistics API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *      @OA\Parameter(
        *         name="for",
        *         in="query",
        *         description="For",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Students statistics are successfully retrieved",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    
    public function students_statistics(Request $request)
    {
        //
        if($request->for=='class')
        {
           $class_id=$request->class_id;
           $male=DB::table("students")
           ->selectRaw("COUNT(*) AS male")
           ->where([
            ["students.student_sex",'=','M'],
            ["students.classroom",'=',$class_id],
            ["students.school_id",'=',$request->school_id]

        ])
        ->first();
        $female=DB::table("students")
           ->selectRaw("COUNT(*) AS female")
           ->where([
            ["students.student_sex",'=','F'],
            ["students.classroom",'=',$class_id],
            ["students.school_id",'=',$request->school_id]

        ])
        ->first();
        


           
        }
        else if($request->for=='school')
        {
          
          $school_id=$request->school_id;
           $male=DB::table("students")
           ->selectRaw("COUNT(*) AS male")
           ->where([
            ["students.student_sex",'=','M'],
            ["students.school_id",'=',$school_id]
        ])
        ->first();
        $female=DB::table("students")
           ->selectRaw("COUNT(*) AS female")
           ->where([
            ["students.student_sex",'=','F'],
            ["students.school_id",'=',$school_id]
        ])
        ->first(); 
        }

        return response()->json(['male'=>$male,'female'=>$female,'message'=>'Retrieved successfully']);


    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
