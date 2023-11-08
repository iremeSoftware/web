<?php

namespace App\Http\Controllers\API;

use App\Models\Courses;
use App\Http\Resources\CoursesResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Marks;
use App\Models\Out_of_marks;
use App\Models\license_keys;

use DB;


class CoursesController extends Controller
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
        * path="/api/course/{school_id}",
        * operationId="getCourseBySchool",
        * tags={"Get courses list API"},
        * summary="Get courses list API",
        * description="Get courses list API",
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
        *         required=true,
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Courses are successfully fetched",
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
            $page = $request->page ?? 1;    
            $limit=$request->limit ?? 10;
            $sort_by = $request->sort_by ?? 'ASC';
            $page=$page-1;
            $offset=ceil($limit*$page);
            if(!empty($request->school_id) && empty($request->class_id))
            {
            //
                    
                $Count_courses = Courses::select('*')->where('school_id', '=', $request->school_id)
                ->get()
                ->count();

                $Courses = Courses::select('*')->where('school_id', '=', $request->school_id)
                ->offset($offset)
                ->limit($limit)
                ->orderBy('course_name',$sort_by)
                ->get();
            
            }
            else if(!empty($request->school_id) && !empty($request->class_id))
            {
                $Count_courses = Courses::select('*')->where([
                    ['courses.school_id', '=', $request->school_id],
                    ['designated_teachers.class_id', '=', $request->class_id]
                ])
                ->get()
                ->count();

                $Courses = Courses::select('courses.course_name','courses.course_id','designated_teachers.teacher_id')
                ->join('designated_teachers','designated_teachers.course_id','=','courses.course_id')
                ->where([
                    ['courses.school_id', '=', $request->school_id],
                    ['designated_teachers.class_id', '=', $request->class_id]
                ])
                ->offset($offset)
                ->limit($limit)
                ->orderBy('course_name',$sort_by)
                ->get();
    
                foreach($Courses as $key=>$course)
                {
                    $max=Out_of_marks::select('term1_quiz','term1_exam','term2_quiz','term2_exam','term3_quiz','term3_exam',)
                    ->where('course_id',$course->course_id)
                    ->first();
    
                    $Courses[$key]->maximum=$max;
    
                }
        }

        return response()->json([ 'Courses' => $Courses,'no_of_courses'=>$Count_courses,'offset'=>$offset,'message' => 'Retrieved successfully'], 200);
    }


    /**
        * @OA\POst(
        * path="/api/course/search/{school_id}",
        * operationId="searchCourseSchool",
        * tags={"Search course API"},
        * summary="Search course API",
        * description="Search course API",
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
        *         name="search_query",
        *         in="query",
        *         description="Course name",
        *         required=true,
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Courses are successfully fetched",
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
    
        public function search(Request $request)
        {

                if(!empty($request->school_id) && !empty($request->search_query))
                {
    
                    $Courses = Courses::select('*')
                    ->where('school_id', '=', $request->school_id)
                    ->where('course_name','like', '%'. $request->search_query.'%')
                    ->get();
                
                }
                
    
            return response()->json([ 'Courses' => $Courses,'no_of_courses'=>$Courses->count(),'offset'=>0,'message' => 'Retrieved successfully'], 200);
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/course",
        * operationId="createNewCourse",
        * tags={"Create new course API"},
        * summary="Create new course API",
        * description="Create new course API",
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
        *               required={"school_id", "course_name","course_id"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="course_name", type="text"),
        *               @OA\Property(property="course_id", type="text"),        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="New course is successfully created",
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
            'course_name' => 'required'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error'],422);
        }

        $check_course = Courses::select('*')->where([
            ['school_id', '=', $request->school_id],
            ['course_name','=',$request->course_name]
        ])->count();

        if($check_course>0)
        {
            return response(['error' => ['course_name'=>'add_new_course_Modal.course_exist'], 'Validation Error'],422);
        }

        

        $Course = Courses::create($data);

        return response([ 'Courses' => new CoursesResource($Course), 'message' => 'Created successfully'], 201);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function show(Courses $courses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Courses  $courses
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/course/update/{school_id}",
        * operationId="updateCourse",
        * tags={"Update course API"},
        * summary="Update course API",
        * description="Update course API",
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
        *               required={"course_name","course_id"},
        *               @OA\Property(property="course_name", type="text"),
        *               @OA\Property(property="course_id", type="text"),        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Course is successfully updated",
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
         $update_course = DB::table('courses')
        ->where([
            ['school_id', '=', $request->school_id],
            ['course_id', '=', $request->course_id]
        ])
        ->update([
        'course_name'=>$request->course_name
        ]);    
            
        return response()->json(['message'=>'Updated successfully'],200);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Courses  $courses
     * @return \Illuminate\Http\Response
     */
          /**
        * @OA\Post(
        * path="/api/course/destroy/{school_id}",
        * operationId="delete_Course",
        * tags={"Delete course API"},
        * summary="Delete course API",
        * description="Delete course API",
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
        *               required={"course_id"},
        *               @OA\Property(property="course_id", type="text"),        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Course is successfully deleted",
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
        $delete_from_marks = DB::table('marks')

        ->where([
            ['school_id', '=', $request->school_id],
            ['course_id', '=', $request->course_id]
        ])
        ->delete();

        $delete_from_designated_teacher = DB::table('designated_teachers')

        ->where([
            ['school_id', '=', $request->school_id],
            ['course_id', '=', $request->course_id]
        ])
        ->delete();

        $delete_from_out_of_marks = DB::table('out_of_marks')
        ->where([
            ['school_id', '=', $request->school_id],
            ['course_id', '=', $request->course_id]
        ])
        ->delete();

         $delete_course = DB::table('courses')
        ->where([
            ['school_id', '=', $request->school_id],
            ['course_id', '=', $request->course_id]
        ])
        ->delete();


         
            
        return response()->json(['message'=>'Deleted successfully'],200);
    }
}
