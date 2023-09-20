<?php

namespace App\Http\Controllers\API;

use App\Models\Discipline;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Students;
use App\Models\academic_year;
use App\Models\license_keys;

use URL;
use DB;

class DisciplineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
       /**
        * @OA\Get(
        * path="/api/discipline/{school_id}",
        * operationId="getConductMarks",
        * tags={"Get displine marks API"},
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
        *         in="query",
        *         description="Class Id",
        *         required=true,
        *      ),
        *      @OA\Parameter(
        *         name="student_id",
        *         in="query",
        *         description="Student ID",
        *         required=true,
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Displine marks are successfully retrieved",
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
        //**************Get student by id FOR SPECIFIED SCHOOL***************

        if(!empty($request->school_id) && !empty($request->class_id) && !empty($request->student_id) )
        {
            

        $Discipline = Discipline::select('*')
        ->join('students','students.student_id','=','disciplines.student_id')
        ->where([
        ['disciplines.student_id', '=', $request->student_id]
        ])->first();

         $number_of_students=$Discipline->count();
         $offset=0;
        }
    //**************FETCH STUDENTS FROM CLASSROOM FOR SPECIFIED SCHOOL***************
        if(!empty($request->school_id) && !empty($request->class_id) && empty($request->student_id))
        {
          $sort_by=empty($request->sort_by)?'name':$request->sort_by; 
            $sort=empty($request->sort)?'ASC':$request->sort; 
            
                   $limit=$request->limit;
                   $page=$request->page-1;

           $offset=ceil($limit*$page);

        $all_students = Discipline::select('*')
         ->where([
        ['school_id', '=', $request->school_id],
        ['class_id','=',$request->class_id]
        ])->get();


         $Discipline = Discipline::select('*')
         ->selectRaw("RANK() OVER (ORDER BY `first_term` DESC) rank_term1")
         ->selectRaw("RANK() OVER (ORDER BY `second_term` DESC) rank_term2")
         ->selectRaw("RANK() OVER (ORDER BY `third_term` DESC) rank_term3")
         ->join('students','students.student_id','=','disciplines.student_id')
         ->where([
        ['disciplines.school_id', '=', $request->school_id],
        ['classroom','=',$request->class_id]
        ])
         ->offset($offset)
         ->limit($limit)
         ->orderBy($sort_by,$sort)
         ->get();


         $number_of_students=$all_students->count();
        }
    //***************************FETCH ALL STUDENTS OF SCHOOL************************
        else if(!empty($request->school_id) && empty($request->class_id) && empty($request->student_id))
        {
        
            
                   $limit=$request->limit;
                   $page=$request->page-1;

           $offset=ceil($limit*$page);

        $all_students = Discipline::select('*')
         ->where([
        ['school_id', '=', $request->school_id]
        ])->get();


         $Discipline = Discipline::select('*')
         ->join('students','students.student_id','=','disciplines.student_id')
         ->where([
        ['disciplines.school_id', '=', $request->school_id]
        ])
         ->offset($offset)
         ->limit($limit)
         ->orderBy('name')
         ->get();


         $number_of_students=$all_students->count();
       }
        

        return response()->json([ 'Discipline' => $Discipline,'no_of_students'=>$number_of_students,'offset'=>$offset,'message' => 'Retrieved successfully'], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     /**
        * @OA\Post(
        * path="/api/discipline",
        * operationId="saveConductMarks",
        * tags={"Save discipline marks API"},
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
        *               required={"school_id", "class_id","limit","page"},
        *               @OA\Property(property="teacher_id", type="text"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="limit", type="number"),
        *               @OA\Property(property="page", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Displine marks are successfully imported",
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
           return response()->json(['message' => 'message.license_expired'], 401); 
         }
         else
         {
         $school_id=$request->school_id; 
         $class_id=$request->class_id; 
         $rows=0;
         $today=strtotime(date('Y-m-d'));
         $academic_year=academic_year::get();
         $from=strtotime($academic_year[0]->term1_from);
         $to=strtotime($academic_year[0]->term3_to);
         if($today>=$from && $today<=$to)
         {
            $academic_year=(date('Y')).'-'.(date('Y')+1);
         }


        $students = Students::select('*')->where([
            ['school_id','=',$school_id],
            ['classroom','=',$class_id]
        ])->get();

        for($i=0;$i<=$students->count()-1;$i++)
        {

         $student_id=$students[$i]->student_id;
         $Discipline = Discipline::select('*')->where([
            ['student_id','=',$student_id]
        ])
       ->count();

          
          if($Discipline==0)
          {

          $rows++;
          $now=date('Y-m-d H:i:s');
           $disciplines=DB::insert('INSERT INTO disciplines(academic_year,school_id,student_id,class_id,first_term,second_term,third_term,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?)',[$academic_year,$school_id,$student_id,$class_id,40,40,40,$now,$now]);
       }
   }

   #################################AFTER IMPORTING LIST OF STUDENTS DISPLAY IT#####################
                   $limit=$request->limit;
                   $page=$request->page-1;
                   $offset=ceil($limit*$page);

        $all_students = Students::select('*')
         ->where([
        ['school_id', '=', $school_id],
        ['classroom','=',$class_id]
        ])->get();


         $Discipline = Discipline::select('*')
        ->join('students', 'students.student_id', '=', 'disciplines.student_id')
        ->where([
        ['disciplines.school_id', '=', $school_id],
        ['classroom','=',$class_id]
        ])
         ->offset($offset)
         ->limit($limit)
         ->orderBy('students.name')
         ->get();
#################################//AFTER IMPORTING LIST OF STUDENTS DISPLAY IT###################
   return response()->json(['Discipline'=>$Discipline,'message'=>'success','no_of_students'=>$all_students->count(),'offset'=>$offset,'records'=>$rows],201);


    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Discipline  $discipline
     * @return \Illuminate\Http\Response
     */
    public function show(Discipline $discipline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discipline  $discipline
     * @return \Illuminate\Http\Response
     */
         /**
        * @OA\Post(
        * path="/api/discipline/update",
        * operationId="updateConductMarks",
        * tags={"Update discipline marks API"},
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
        *               required={"school_id", "class_id","student_id"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="student_id", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Displine marks are successfully updated",
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
    public function update(Request $request, Discipline $discipline)
    {
        //########################Check whether license of the school expired or not
         $elapsed_time=license_keys::getLicense($request->school_id); 
         $remain_sec=$elapsed_time['remain_sec'];
        //########################//Check whether license of the school expired or not
         if($remain_sec<0)
         {
           return response()->json(['message' => 'message.license_expired'], 401); 
         }
         else
         {
         $school_id=$request->school_id; 
         $class_id=$request->class_id;
         $student_id=$request->student_id;
         $now=date('Y-m-d H:i:s');
         $today=strtotime(date('Y-m-d'));
         $academic_year=academic_year::first();
         $term1_from=strtotime($academic_year->term1_from);
         $term1_to=strtotime($academic_year->term1_to);
         $term2_from=strtotime($academic_year->term2_from);
         $term2_to=strtotime($academic_year->term2_to);
         $term3_from=strtotime($academic_year->term3_from);
         $term3_to=strtotime($academic_year->term3_to);

        $discipline = Discipline::select('*')
        ->where([               ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
        ])->first();


        if($request->term==1)
        {

         if($today>=$term1_from && $today<=$term3_to)
            {

            $discipline = DB::table('disciplines')
                            ->where([
                                ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'first_term'=>$discipline->first_term-$request->decrement,
                              'updated_at'=>$now
                            ]);


            return response()->json(['message'=>'Updated successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_marks_term1"],401);
        }

        }
        else         if($request->term==2)
        {
         if($today>=$term2_from && $today<=$term3_to)
            {
              $discipline = DB::table('disciplines')
                            ->where([
                                ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'second_term'=>$discipline->second_term-$request->decrement,
                              'updated_at'=>$now
                            ]);
            return response()->json(['message'=>'Updated successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_marks_term2"],401);
        }

        }
        else         if($request->term==3)
        {
         if($today>=$term3_from && $today<=$term3_to)
            {
            $discipline = DB::table('disciplines')
                            ->where([
                                ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'third_term'=>$discipline->third_term-$request->decrement,
                              'updated_at'=>$now
                            ]);


            return response()->json(['message'=>'Updated successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_marks_term3"],401);
        }

        }
    }


    }

    /**
     * Update selected students the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discipline  $discipline
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/discipline/bulk_edit",
        * operationId="updateBulkConductMarks",
        * tags={"Bulk update discipline API"},
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
        *               required={"school_id", "class_id","student_id"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="student_id", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Displine marks are successfully updated in bulk",
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
    public function update_selected(Request $request, Discipline $discipline)
    {
        //
             //########################Check whether license of the school expired or not
         $elapsed_time=license_keys::getLicense($request->school_id); 
         $remain_sec=$elapsed_time['remain_sec'];
        //########################//Check whether license of the school expired or not
         if($remain_sec<0)
         {
           return response()->json(['message' => 'message.license_expired'], 401); 
         }
         else
         {
         $school_id=$request->school_id; 
         $class_id=$request->class_id;
         $student_id=$request->student_id;
         $now=date('Y-m-d H:i:s');
         $today=strtotime(date('Y-m-d'));
         $academic_year=academic_year::first();
         $term1_from=strtotime($academic_year->term1_from);
         $term1_to=strtotime($academic_year->term1_to);
         $term2_from=strtotime($academic_year->term2_from);
         $term2_to=strtotime($academic_year->term2_to);
         $term3_from=strtotime($academic_year->term3_from);
         $term3_to=strtotime($academic_year->term3_to);

        $discipline = Discipline::select('*')
        ->where([               ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
        ])->first();

            
        if($request->term==1)
        {


         if($today>=$term1_from && $today<=$term3_to)
            {
               $student_id=str_replace(" ",",",$request->student_id);

            $discipline =DB::update("UPDATE disciplines SET `first_term`=`first_term` - $request->decrement,`updated_at`='$now'  WHERE  student_id IN($student_id)");


            return response()->json(['message'=>'Updated successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_marks_term1"],401);
        }

        }
        else         if($request->term==2)
        {
         if($today>=$term2_from && $today<=$term3_to)
            {
               $student_id=str_replace(" ",",",$request->student_id);

            $discipline =DB::update("UPDATE disciplines SET `second_term`=`second_term` - $request->decrement,`updated_at`='$now'  WHERE  student_id IN($student_id)");

            return response()->json(['message'=>'Updated successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_marks_term2"],401);
        }

        }
        else         if($request->term==3)
        {
         if($today>=$term3_from && $today<=$term3_to)
            {
            $student_id=str_replace(" ",",",$request->student_id);

            $discipline =DB::update("UPDATE disciplines SET `third_term`=`third_term` - $request->decrement,`updated_at`='$now'  WHERE  student_id IN($student_id)");


            return response()->json(['message'=>'Updated successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_marks_term3"],401);
        }

        }
    }


    }
    /**
     * Search students.
     *
     * @param  \App\Discipline  $discipline
     * @return \Illuminate\Http\Response
     */
            /**
        * @OA\Post(
        * path="/api/discipline/search",
        * operationId="searchConductMarks",
        * tags={"Search students behavior marks API "},
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
        *               required={"student_name", "school_id","class_id"},
        *               @OA\Property(property="student_name", type="text"),
        *               @OA\Property(property="school_id", type="number"),
        *               @OA\Property(property="class_id", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Students behavior marks are successfully retrieved",
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
        //
        $disciplines = Discipline::select('*')
        ->join('students','students.student_id','=','disciplines.student_id')
        ->where([
        ['students.name', 'like', '%'. $request->student_name.'%'],
        ['disciplines.school_id', '=', $request->school_id],
        ['disciplines.class_id','=',$request->class_id]

        ])
         ->limit('5')
         ->get();
         $number_of_students=$disciplines->count();
         return response()->json([ 'Discipline' => $disciplines,'no_of_students'=>$number_of_students, 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discipline  $discipline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discipline $discipline)
    {
        //
    }
}
