<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\student_attendances;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;


class StudentAttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth:api');
    }

            /**
        * @OA\Get(
        * path="/api/student/attendances/{school_id}/{class_id}",
        * operationId="getAttendance",
        * tags={"Get attendance list API"},
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
        *         name="class_id",
        *         in="path",
        *         description="Class ID",
        *      ),
        *      @OA\Parameter(
        *         name="for",
        *         in="query",
        *         description="Attendance for",
        *      ),
        *      @OA\Parameter(
        *         name="sort",
        *         in="query",
        *         description="Sort",
        *      ),
        *      @OA\Parameter(
        *         name="sort_by",
        *         in="query",
        *         description="Sort By",
        *      ),
        *      @OA\Parameter(
        *         name="limit",
        *         in="query",
        *         description="Limit",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Attendence is successfully retrieved",
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


    public function index(Request $request)
    {
        //
         $page=$request->page-1;
         $limit=$request->limit;
         $offset=ceil($page*$limit);
         $sort=empty($request->sort)?'name':$request->sort;
         $sort_by=empty($request->sort_by)?'ASC':$request->sort_by;
        if($request->for=='student')
        {

          $no_of_records=student_attendances::join('students','students.student_id','=','student_attendances.student_id')
          ->join('classrooms','classrooms.class_id','=','student_attendances.class_id')
          ->where('student_attendances.school_id',$request->school_id)
          ->where('student_attendances.class_id',$request->class_id)
          ->where('year',date('Y'))
          ->where('month',$request->month)
          ->get()
          ->count(); 


          $student_attendances=student_attendances::select('classrooms.classroom_name','students.name','student_attendances.student_id','student_attendances.status')
       ->join('students','students.student_id','=','student_attendances.student_id')
       ->join('classrooms','classrooms.class_id','=','student_attendances.class_id')
       ->where('student_attendances.school_id',$request->school_id)
       ->where('student_attendances.class_id',$request->class_id)
       ->where('year',date('Y'))
       ->where('month',$request->month)
       ->where('student_attendances.student_id',$request->student_id)
       ->first();  

        }
        else  if($request->for=='class')
        {

          $no_of_records=1;

         $student_attendances=student_attendances::select('classrooms.classroom_name','students.name','student_attendances.status','student_attendances.month','student_attendances.student_id')
       ->join('students','students.student_id','=','student_attendances.student_id')
       ->join('classrooms','classrooms.class_id','=','student_attendances.class_id')
       ->where('student_attendances.school_id',$request->school_id)
       ->where('student_attendances.class_id',$request->class_id)
       ->where('year',date('Y'))
       ->where('month',$request->month)
       ->offset($offset)
       ->limit($limit)
       ->orderBy($sort,$sort_by)
       ->get(); 
        


         


        }
        else  if($request->for=='school')
        {
          $no_of_records=student_attendances::where('school_id',$request->school_id)
       ->where('year',date('Y'))
       ->where('month',$request->month)
       ->get()
       ->count(); 

         $student_attendances=student_attendances::select('classrooms.classroom_name','students.name','student_attendances.status','student_attendances.month')
       ->join('students','students.student_id','=','student_attendances.student_id')
       ->join('classrooms','classrooms.class_id','=','student_attendances.class_id')
       ->where('student_attendances.school_id',$request->school_id)
       ->where('year',date('Y'))
       ->where('month',$request->month)
       ->offset($offset)
       ->limit($limit)
       ->orderBy($sort,$sort_by)
       ->get();   
        }
        return response()->json(['student_attendances'=>$student_attendances,'offset'=>$offset,'no_of_records'=>$no_of_records]);

    }

            /**
        * @OA\Post(
        * path="/api/student/attendances/import",
        * operationId="importAttendanceStudents",
        * tags={"Import Attendance API"},
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
        *         name="classroom",
        *         in="path",
        *         description="Class ID",
        *      ),
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"school_id","class_id"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Students are successfully imported",
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

    

        public function import_students(Request $request)
        {
          $no_of_records=student_attendances::join('students','students.student_id','=','student_attendances.student_id')
       ->join('classrooms','classrooms.class_id','=','student_attendances.class_id')
       ->where('student_attendances.school_id',$request->school_id)
       ->where('student_attendances.class_id',$request->class_id)
       ->where('year',date('Y'))
       ->where('month',date('M'))
       ->get()
       ->count(); 

          if($no_of_records==0)
       {
  ######INSERT TODAY ATTENDANCE STATUS BCS N/A###################################### 

       
        $days_of_month=Helper::days_of_month(date('M'));
        $days="";
        for($i=1;$i<=$days_of_month;$i++)
        {
        $pre = ($i > 1)?",0":0;        
        $days=$days.$pre;
        }
        
        $students=Students::where('school_id',$request->school_id)
        ->where('classroom',$request->class_id)
        ->get();
        $no_of_imported=0;
        for($i=0;$i<=$students->count()-1;$i++)
        {
          
          $student_id=$students[$i]->student_id;
          $student_attendances=new student_attendances();
          $student_attendances->school_id=$request->school_id;
          $student_attendances->class_id=$request->class_id;
          $student_attendances->student_id=$student_id;
          $student_attendances->year=date('Y');
          $student_attendances->month=date('M');
          $student_attendances->status=$days;
          $student_attendances->save();
          $no_of_imported=$i+$no_of_imported;
        }

         

      
####//INSERT TODAY ATTENDANCE STATUS BCS N/A######################################  

       } 

                return response()->json(['message'=>'Created successfully','no_of_records'=>$no_of_imported],201);

        }

           /**
        * @OA\Get(
        * path="/api/daily/attendance/{school_id}/{class_id}",
        * operationId="getDailyAttendance",
        * tags={"Get attendance statistics API "},
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
        *         name="class_id",
        *         in="path",
        *         description="Class ID",
        *      ),
        *      @OA\Parameter(
        *         name="for",
        *         in="query",
        *         description="Attendance for",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Attendance statistics is successfully retrieved",
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


    public function attendance_daily_statistics(Request $request)
    {
        //
      if($request->for=='class' && $request->class_id!=='null')
      {
        
          $check_student=student_attendances::where('school_id',$request->school_id)
       ->where('class_id',$request->class_id)
       ->where('year',date('Y'))
       ->where('month',date('M'))
       ->get(); 
     }
     else if($request->for=='school'  && $request->class_id=='null')
     {
            $check_student=student_attendances::where('school_id',$request->school_id)
       ->where('year',date('Y'))
       ->where('month',date('M'))
       ->get();
     }
       $NA=0;
       $PR=0;
       $AB=0;
       $LA=0;
       $AB_RE=0;
       $LA_RE=0;

       for($i=0;$i<=$check_student->count()-1;$i++)
       {
        $str=explode(',',$check_student[$i]->status);
        $val='';
        foreach ($str as $key => $value) {
        if(date('d')==$key+1)
        {
          switch ($value) {
            case 0:
              $NA++;
              break;
            case 1:
              $PR++;
              break; 
            case 2:
              $AB++;
              break;
            default:
              $AB_RE++;
              break;
            
          }
        
        }
        
          
        }

       }

       return response()->json(['N_A'=>$NA,'present'=>$PR,'absent'=>$AB,'absent_Re'=>$AB_RE]);

       



        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        /**
        * @OA\Post(
        * path="/api/student/attendances",
        * operationId="updateAttendance",
        * tags={"Update Attendance API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"school_id","class_id","student_id"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="student_id", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Attendance is successfully updated",
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
    public function store(Request $request)
    {
        //
       $check_student=student_attendances::where('school_id',$request->school_id)
       ->where('class_id',$request->class_id)
       ->where('year',date('Y'))
       ->where('month',date('M'))
       ->where('student_id',$request->student_id)
       ->first();
       
       $date=!empty($check_student->updated_at)?explode(" ",$check_student->updated_at):'';
       $date=!empty($date)?$date[0]:"";

       $today=date('Y-m-d');
       
       

   

######UPDATE TODAY ATTENDANCE STATUS###############################################  
       
       
        $check_student->status;
        $str=explode(',',$check_student->status);
        $val='';
        foreach ($str as $key => $value) {
        if(intval(date('d'))==$key+1)
        {
        $value=$request->status;
        }
        
          $val1=($key > 0)?",$value":$value;
         $val=$val.$val1;
        }
        
        $check_student->status=$val;
        $check_student->save();
       
#####//UPDATE TODAY ATTENDANCE STATUS###########################################        


       return response()->json(['message'=>'Updated successfully'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\student_attendances  $student_attendances
     * @return \Illuminate\Http\Response
     */
    public function show(student_attendances $student_attendances)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\student_attendances  $student_attendances
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, student_attendances $student_attendances)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\student_attendances  $student_attendances
     * @return \Illuminate\Http\Response
     */
    public function destroy(student_attendances $student_attendances)
    {
        //
    }
}
