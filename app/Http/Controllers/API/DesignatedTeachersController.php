<?php

namespace App\Http\Controllers\API;

use App\Models\Designated_teachers;
use App\Models\classrooms;
use App\Models\User_authentications;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\license_keys;
use DB;


class DesignatedTeachersController extends Controller
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
        * path="/api/designated_teachers/{school_id}",
        * operationId="getDesignatedTeacher",
        * tags={"Designated Teachers by school API"},
        * summary="Designated Teacher  API",
        * description="Designated Teacher API",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *         required=true,
        *      ),
 
        *      @OA\Response(
        *          response=200,
        *          description="Designated teachers are successfully retrieved",
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
         $Designated_teachers = Designated_teachers::select('*')
         ->where('school_id', '=', $request->school_id)
         ->get();
        

        return response()->json([ 'Designated_teachers' => $Designated_teachers, 'message' => 'Retrieved successfully'], 200);
    }
    /**
     * Designated class for specific teacher.
     *
     * @return \Illuminate\Http\Response
     */
     /**
        * @OA\Get(
        * path="/api/designated_teachers/{school_id}/{teacher_id}",
        * operationId="getDesignatedTeacherByTeacherID",
        * tags={"Get designated teacher by Teacher ID API"},
        * summary="Designated teacher by teacher ID API",
        * description="Designated teacher by teacher ID API",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *         required=true,
        *      ),
        *      @OA\Parameter(
        *         name="teacher_id",
        *         in="path",
        *         description="Teacher ID",
        *         required=true,
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Designated teachers are successfully retrieved",
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
    public function class_room(Request $request)
    {
        //
         $class_room = Designated_teachers::select('designated_teachers.class_id','classrooms.classroom_name')
         ->leftjoin('classrooms', 'designated_teachers.class_id', '=', 'classrooms.class_id')
         ->where([
            ['designated_teachers.school_id', '=', $request->school_id],
            ['designated_teachers.teacher_id', '=', $request->teacher_id]

        ])
         ->distinct()
         ->get();
        

        return response()->json([ 'class_room' => $class_room, 'message' => 'Retrieved successfully'], 200);
    }
    /**
     * Get teacher by classroom.
     *
     * @return \Illuminate\Http\Response
     */
         /**
        * @OA\Get(
        * path="/api/designated_teachers/{school_id}/{teacher_id}/{class_id}",
        * operationId="getDesignatedTeacherByTeacherIdAndClassId",
        * tags={"Get designated teacher by Teacher & Class ID API"},
        * summary="Get designated teacher by Teacher & Class ID API",
        * description="Get designated teacher by Teacher & Class ID API",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *         required=true,
        *      ),
        *      @OA\Parameter(
        *         name="teacher_id",
        *         in="path",
        *         description="Teacher ID",
        *         required=true,
        *      ),
        *      @OA\Parameter(
        *         name="class_id",
        *         in="path",
        *         description="Class ID",
        *         required=true,
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Designated teachers are successfully retrieved",
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
    public function get_teachers(Request $request)
    {
        //
        if($request->class_id!='empty')
         $teachers = Designated_teachers::select('designated_teachers.class_id','classrooms.classroom_name','users.name','courses.course_name','users.phone_number','users.email','users.profile_pic')
         ->join('classrooms', 'designated_teachers.class_id', '=', 'classrooms.class_id')
         ->join('users', 'designated_teachers.teacher_id', '=', 'users.account_id')
         ->join('courses', 'courses.course_id', '=', 'designated_teachers.course_id')
         ->where([
            ['designated_teachers.school_id', '=', $request->school_id],
            ['designated_teachers.class_id', '=', $request->class_id]

         ])
         ->distinct()
         ->get();
        else 
            $teachers = Designated_teachers::select('designated_teachers.class_id','classrooms.classroom_name','users.name','courses.course_name','users.phone_number','users.email','users.profile_pic')
            ->join('classrooms', 'designated_teachers.class_id', '=', 'classrooms.class_id')
            ->join('users', 'designated_teachers.teacher_id', '=', 'users.account_id')
            ->join('courses', 'courses.course_id', '=', 'designated_teachers.course_id')
            ->where([
            ['designated_teachers.school_id', '=', $request->school_id],

            ])
            ->distinct()
            ->get();
        return response()->json([ 'teachers' => $teachers, 'message' => 'Retrieved successfully'], 200);
    }
    /**
     * Designated courses per classroom for specific teacher.
     *
     * @return \Illuminate\Http\Response
     */
     /**
        * @OA\Get(
        * path="/api/designated_teachers/get/teachers/{school_id}/{class_id}",
        * operationId="getDesignatedTeacherInClass",
        * tags={"Get designated teacher in classroom API"},
        * summary="Get designated teacher in classroom API",
        * description="Get designated teacher in classroom API",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *         required=true,
        *      ),
        *      @OA\Parameter(
        *         name="class_id",
        *         in="path",
        *         description="Class ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Designated teachers are successfully retrieved",
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
    public function courses(Request $request)
    {
        //
         $courses = Designated_teachers::select('courses.course_name','courses.course_id')
        ->leftjoin('courses', 'courses.course_id', '=', 'designated_teachers.course_id')
         ->where([
            ['designated_teachers.school_id', '=', $request->school_id],
            ['designated_teachers.teacher_id', '=', $request->teacher_id],
            ['designated_teachers.class_id', '=', $request->class_id]

        ])
         ->distinct()
         ->get();
        

        return response()->json([ 'courses' => $courses, 'message' => 'Retrieved successfully'], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/designated_teachers",
        * operationId="designateNewTeacher",
        * tags={"Designate new teacher API"},
        * summary="Designate new teacher API",
        * description="Designate new teacher API",
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
        *               required={"teacher_id", "course_id","school_id","class_id"},
        *               @OA\Property(property="teacher_id", type="text"),
        *               @OA\Property(property="course_id", type="number"),
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="New teacher is successfully assigned",
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
        //########################Check whether license of the school expired or not
         $elapsed_time=license_keys::getLicense($request->school_id); 
         $remain_sec=$elapsed_time['remain_sec'];
        //########################//Check whether license of the school expired or not
         if($remain_sec<0)
         {
           return response()->json(['license_expired'=>'message.license_expired'], 401); 
         }
         else
         {
        $validate = Validator::make($request->all(), [
            'school_id'      => 'required',
            'teacher_id'     => 'required',
            'classroom_id'     => 'required',
            'course_id'  => 'required',
        ]);   

         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }   

        $check_teacher = Designated_teachers::select('*')
        ->where([
            ['school_id', '=', $request->school_id],['class_id', '=', $request->classroom_id],['course_id', '=', $request->course_id]
        ])
        ->count();


        if($check_teacher>0)
        {
            return response()->json(['exist'=>'assign_teacher_Modal.exist'],401);
        }


        $Designated_teachers = new Designated_teachers;
        $Designated_teachers->school_id = $request->school_id;
        $Designated_teachers->teacher_id = $request->teacher_id;
        $Designated_teachers->class_id = $request->classroom_id;
        $Designated_teachers->course_id = $request->course_id;
        $Designated_teachers->save();

        

        if($Designated_teachers)
        {
            return response()->json(['status'=>'Inserted successfully'],201);
        }
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designated_teachers  $designated_teachers
     * @return \Illuminate\Http\Response
     */
    public function show(Designated_teachers $designated_teachers)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designated_teachers  $designated_teachers
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/change_teacher/{school_id}/{class_id}",
        * operationId="updateDesignatedTeacher",
        * tags={"Change teacher's course API"},
        * summary="Change teacher's course API",
        * description="Change teacher's course API",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *         required=true,
        *      ),
        *      @OA\Parameter(
        *         name="class_id",
        *         in="path",
        *         description="Class ID",
        *         required=true,
        *      ),
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"teacher_id", "course_id"},
        *               @OA\Property(property="teacher_id", type="text"),
        *               @OA\Property(property="course_id", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Teacher designation is successfully updated",
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
    public function update(Request $request)
    {
        //


           //########################Check whether license of the school expired or not
         $elapsed_time=license_keys::getLicense($request->school_id); 
         $remain_sec=$elapsed_time['remain_sec'];
        //########################//Check whether license of the school expired or not
         if($remain_sec<0)
         {
           return response()->json(['error' => ['license_expired'=>'message.license_expired']], 401); 
         }
         else
         {
        $update_designated_teachers = DB::table('designated_teachers')
        ->where([
            ['school_id', '=', $request->school_id],
            ['class_id', '=', $request->class_id],
            ['course_id', '=', $request->course_id]
        ])
        ->update([
        'teacher_id'=>$request->teacher_id
        ]);

        $update_out_of_marks = DB::table('out_of_marks')
        ->where([
            ['school_id', '=', $request->school_id],
            ['class_id', '=', $request->class_id],
            ['course_id', '=', $request->course_id]
        ])
        ->update([
        'teacher_id'=>$request->teacher_id
        ]);

        $update_marks = DB::table('marks')
        ->where([
            ['school_id', '=', $request->school_id],
            ['class_id', '=', $request->class_id],
            ['course_id', '=', $request->course_id]
        ])
        ->update([
        'teacher_id'=>$request->teacher_id
        ]);    
        

       
            
        return response()->json(['message'=>'Updated successfully'],200);    

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designated_teachers  $designated_teachers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designated_teachers $designated_teachers)
    {
        //
    }
}
