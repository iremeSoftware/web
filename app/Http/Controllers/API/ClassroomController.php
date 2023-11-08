<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\classrooms;
use App\Models\license_keys;
use App\Models\Students;
use App\Http\Resources\ClassroomsResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use DB;



class ClassroomController extends Controller
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
        * path="/api/classroom/{school_id}",
        * operationId="getClassroom",
        * tags={"Get classroom list by school ID"},
        * summary="Get classroom list by school ID",
        * description="Get classroom list by school ID",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *  @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               @OA\Property(property="limit", type="text"),
        *               @OA\Property(property="page", type="text"),
        *               @OA\Property(property="sort", type="text"), 
        *               @OA\Property(property="sort_by", type="text"), 
        *
        *        ),
        *     ),
        *  ),
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *         required=true,
        *      ),
        *      @OA\Parameter(
        *         name="class_id",
        *         in="query",
        *         description="Class ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Got the list of classrooms",
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
        $page = $request->page ?? 1;    
        $limit=$request->limit ?? 10;
        $sort_by = $request->sort_by ?? 'ASC';
        $page=$page-1;
        $offset=ceil($limit*$page);

        if(!empty($request->school_id) && empty($request->class_id))
        {
        $total_classrooms = classrooms::select('*')
        ->where('school_id', '=', $request->school_id)
        ->get()
        ->count();

        $classrooms = classrooms::select('classrooms.*','name')
        ->leftjoin('users','users.account_id','=','classrooms.classroom_representative')
        ->where('classrooms.school_id', '=', $request->school_id)
        ->orderBy('classrooms.classroom_name','ASC')
        ->offset($offset)
        ->limit($limit)
        ->orderBy('classrooms.classroom_name',$sort_by)
        ->get();
    }
    else if(!empty($request->school_id) && !empty($request->class_id))
    {
        $classrooms = classrooms::select('*')
           ->where([
            ['school_id', '=', $request->school_id],
            ['class_id', '=', $request->class_id]
             ])
           ->first();
    }
        

        return response()->json([ 'classrooms' => $classrooms,'no_of_classroom'=>$total_classrooms,'offset'=>$offset,'message' => 'Retrieved successfully'], 200);
    }

    
     /**
        * @OA\Get(
        * path="/api/classteacher/{school_id}",
        * operationId="getClassTeacher",
        * tags={"Get class teacher by account ID"},
        * summary="Get class teacher by account ID",
        * description="Get class teacher by account ID",
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
        *          description="Got class teacher details",
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
     public function getClassTeacher(Request $request)
    {
        //
        $classTeacher=auth()->user()->account_id;

        $classrooms = classrooms::select('*')
        ->where('school_id', '=', $request->school_id)
        ->where('classroom_representative',$classTeacher)
        ->orderBy('classroom_name','ASC')
        ->get();
       
        return response()->json([ 'classrooms' => $classrooms, 'message' => 'Retrieved successfully'], 200);
    }

     /**
        * @OA\Get(
        * path="/api/classteacher/{school_id}/{class_id}",
        * operationId="getClassTeacherByClassId",
        * tags={"Get class teacher by class ID"},
        * summary="Get class teacher by class ID",
        * description="Get class teacher by class ID",
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
        *      @OA\Response(
        *          response=200,
        *          description="Got class teacher details by class ID",
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
    
    public function getClassTeacherByClass(Request $request)
    {
        //
        $class_id=$request->class_id;

        $classrooms = classrooms::select('classrooms.*','name')
        ->leftjoin('users','users.account_id','=','classrooms.classroom_representative')
        ->where('classrooms.school_id', '=', $request->school_id)
        ->where('classrooms.class_id',$class_id)
        ->orderBy('classroom_name','ASC')
        ->first();
        
        $getStudentsNumber = Students::select('*')
        ->where('classroom',$class_id)->get()->count();
        
       
        return response()->json([ 'classrooms' => $classrooms,'no_of_students'=>$getStudentsNumber, 'message' => 'Retrieved successfully'], 200);
    }

    /**
        * @OA\Get(
        * path="/api/classrooms/getNoOfStudents/{school_id}",
        * operationId="getStudentNo",
        * tags={"Get student total numbers for selected classes"},
        * summary="Get student total numbers for selected classes",
        * description="Get student total numbers for selected classes",
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
        *         name="selected_classes",
        *         in="query",
        *         description="Selected Classrooms",
        *         required=true,
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Got total number of students for selected classes",
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
    

    public function getNoOfStudents(Request $request)
    {
        $classrooms=explode(' ',$request->selected_classes);
        $Counter=0;
        foreach ($classrooms as $key => $class) {
        $getNoOfStudents = Students::select('*')
        ->where('school_id', $request->school_id)
        ->where('classroom',$class)
        ->get()
        ->count();
        $Counter=$getNoOfStudents+$Counter;
       }
       return response()->json([ 'no_of_students' => $Counter, 'message' => 'Retrieved successfully'], 200);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     /**
        * @OA\Post(
        * path="/api/classroom",
        * operationId="createClassroom",
        * tags={"Create new classroom"},
        * summary="Create new classroom",
        * description="Create new classroom",
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
        *               required={"school_id", "class_id","classroom_representative","classroom_name"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="text"),
        *               @OA\Property(property="classroom_representative", type="text"),
        *               @OA\Property(property="classroom_name", type="text"),
        *              @OA\Property(property="classroom_alias", type="text"),
        *            ),
        *        ),
        *    ),
        
        *      @OA\Response(
        *          response=201,
        *          description="New classromm is successfully created",
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
           return response()->json(['error' => ['license_expired'=>'message.license_expired']], 401); 
         }
         else
         {
        $data = $request->all();

        $validator = Validator::make($data, [
            'classroom_name' => 'required'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error'],422);
        }

        $check_classroom = classrooms::select('*')->where([
            ['school_id', '=', $request->school_id],
            ['classroom_name','=',$request->classroom_name]
        ])->count();



        if($check_classroom>0)
        {
            return response(['error' => ['classroom_name'=>'add_new_class_Modal.class_room_exist'], 'Validation Error'],422);
        }
        

        $classrooms = classrooms::create($data);

        return response([ 'classrooms' => new ClassroomsResources($classrooms), 'message' => 'Created successfully'], 201);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
    public function show(classrooms $classrooms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/classroom/update/{school_id}",
        * operationId="updateClassroom",
        * tags={"Update classroom Information"},
        * summary="Update classroom Information",
        * description="Update classroom Information",
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
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={ "class_id","classroom_name"},
        *               @OA\Property(property="class_id", type="text"),
        *               @OA\Property(property="classroom_name", type="text"),
        *            ),
        *        ),
        *    ),
        
        *      @OA\Response(
        *          response=201,
        *          description="Classromm is successfully updated",
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
       
        $update_class = DB::table('classrooms')
        ->where([
            ['school_id', '=', $request->school_id],
            ['class_id', '=', $request->class_id]
        ])
        ->update([
        'classroom_name'=>$request->classroom_name,
        'classroom_alias'=>$request->classroom_alias,
        'classroom_representative'=>$request->classroom_representative
        ]);    
            
        return response()->json(['message'=>'Updated successfully'],200);   
    }
    /**
     * Update class teacher.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/classroom/designate_class_teacher",
        * operationId="designateClassTeacher",
        * tags={"Designate class teacher"},
        * summary="Designate new class teacher",
        * description="Designate new class teacher",
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
        *               required={ "school_id","teacher_id","classroom_id"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="teacher_id", type="text"),
        *               @OA\Property(property="classroom_id", type="number"),
        *            ),
        *        ),
        *    ),
        
        *      @OA\Response(
        *          response=201,
        *          description="Class teacher is successfully designated",
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
    public function designate_class_teacher(Request $request)
    {
        //
        $validate = Validator::make($request->all(), [
            'school_id'      => 'required',
            'teacher_id'     => 'required',
            'classroom_id'     => 'required',
        ]);   

         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }   

        $check_teacher = classrooms::select('classroom_representative as class_teacher')
        ->where([
            ['school_id', '=', $request->school_id],['class_id', '=', $request->classroom_id]
        ])
        ->first();


        $assign_class_teacher = DB::update('update classrooms set classroom_representative = ? where school_id = ? AND class_id= ?',[$request->teacher_id,$request->school_id,$request->classroom_id]);

        if($assign_class_teacher)
        {
          return response()->json(['status'=>'Updated successfully'],200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
        /**
     * Update class teacher.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/classroom/destroy/{school_id}",
        * operationId="deleteClassRoom",
        * tags={"Delete classroom by Class ID"},
        * summary="Delete classroom by Class ID",
        * description="Delete classroom by Class ID",
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
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={ "class_id"},
        *               @OA\Property(property="class_id", type="text"),
        *            ),
        *        ),
        *    ),        
        *      @OA\Response(
        *          response=201,
        *          description="Classroom is successfully deleted",
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
    public function destroy(Request $request)
    {
        //
         $delete_from_marks = DB::table('classrooms')

        ->where([
            ['school_id', '=', $request->school_id],
            ['class_id', '=', $request->class_id]
        ])
        ->delete();

        $delete_from_designated_teacher = DB::table('designated_teachers')

        ->where([
            ['school_id', '=', $request->school_id],
            ['class_id', '=', $request->class_id]
        ])
        ->delete();



        $delete_from_out_of_marks = DB::table('out_of_marks')
        ->where([
            ['school_id', '=', $request->school_id],
            ['class_id', '=', $request->class_id]
        ])
        ->delete();

         $delete_classroom = DB::table('classrooms')
        ->where([
            ['school_id', '=', $request->school_id],
            ['class_id', '=', $request->class_id]
        ])
        ->delete();
         
            
        return response()->json(['message'=>'Deleted successfully'],200);
    }
}
