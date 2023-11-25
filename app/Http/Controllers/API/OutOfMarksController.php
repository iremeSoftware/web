<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Out_of_marks;
use App\Models\academic_year;
use App\Models\Marks;
use App\Models\Students;
use App\Models\PointsRanges;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

use DB;

class OutOfMarksController extends Controller
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
        * path="/api/out_of_marks/{school_id}/{class_id}/{course_id}",
        * operationId="getMaximumMarks",
        * tags={"Get maximum points API"},
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
        *         name="term",
        *         in="query",
        *         description="Term",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Maximum points are successfully retrieved",
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
        //**************Get out of marks for all courses in class***************
        if(!empty($request->school_id) && !empty($request->class_id) && !empty($request->course_id))
        {

        $Out_of_marks = Out_of_marks::select('*')
        ->join('courses', 'courses.course_id', '=', 'out_of_marks.course_id')
        ->where([
        ['out_of_marks.school_id', '=', $request->school_id],
        ['out_of_marks.course_id', '=', $request->course_id],
        ['out_of_marks.class_id', '=', $request->class_id]
        ])->first();

        }
        return response()->json(['Out_of_marks'=>$Out_of_marks,'message'=>'Retrived successfully'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
         /**
        * @OA\Post(
        * path="/api/out_of_marks",
        * operationId="createMaximumMarks",
        * tags={"Create maximum points API"},
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
        *               required={"school_id","class_id","course_id","account_id","term","term_quiz","term_exam"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="course_id", type="number"),
        *               @OA\Property(property="account_id", type="number"),
        *               @OA\Property(property="term", type="number"),
        *               @OA\Property(property="term_quiz", type="number"),
        *               @OA\Property(property="term_exam", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Maximum points are successfully created",
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
        $data = $request->all();


        $check_course = Out_of_marks::select('*')->where([
            ['school_id', '=', $request->school_id],
            ['course_id','=',$request->course_id],
            ['teacher_id','=',$request->account_id],
            ['class_id','=',$request->class_id]
        ])->count();
         $now=date('Y-m-d H:i:s');
         $today=strtotime(date('Y-m-d'));
         $academic_year=academic_year::first();

         $term1_from=strtotime($academic_year->term1_from);
         $term1_to=strtotime($academic_year->term1_to);
         $term2_from=strtotime($academic_year->term2_from);
         $term2_to=strtotime($academic_year->term2_to);
         $term3_from=strtotime($academic_year->term3_from);
         $term3_to=strtotime($academic_year->term3_to);
         if($today>=$term1_from && $today<=$term3_to)
         {
            $academic_year=(date('Y')).'-'.(date('Y')+1);
         }

         


        if($check_course==0)
        {

           $insert_user=DB::insert('INSERT INTO out_of_marks(academic_year,school_id,course_id,teacher_id,class_id,term1_quiz,term1_exam,term1_total_marks,term2_quiz,term2_exam,term2_total_marks,term3_quiz,term3_exam,term3_total_marks,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$academic_year,$request->school_id,$request->course_id,$request->account_id,$request->class_id,0,0,0,0,0,0,0,0,0,$now,$now]);
        }
         $Out_of_marks = Out_of_marks::select('*')
        ->where([
                                ['teacher_id', '=', $request->account_id],
                                ['course_id', '=', $request->course_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
        ])->first();
         $data= array(
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'course_id' => $request->course_id,
            'teacher_id' => $request->account_id,
            'term' => $request->term,
            'division1' => '90-100',
            'division2' => '80-89',
            'division3' => '70-79',
            'division4' => '60-69',
            'division5' => '50-59',
            'division6' => '40-49',
            'division7' => '30-39',
            'division8' => '20-29',
            'division9' => '0-19',
            'created_at' => Helper::now(),
            'updated_at' => Helper::now()
         );
          $data1= array(
            'pointsranges.school_id' => $request->school_id,
            'pointsranges.class_id' => $request->class_id,
            'pointsranges.course_id' => $request->course_id,
            'term'=> $request->term,
           );
            $count=PointsRanges::countData($data1);

           if(empty($count))
           {
                       $value=PointsRanges::insertData($data);
           }

        if($request->term==1)
        {
            if($today>=$term1_from && $today<=$term3_to)
            {
             $data1= array(
            'pointsranges.school_id' => $request->school_id,
            'pointsranges.class_id' => $request->class_id,
            'pointsranges.course_id' => $request->course_id,
            'term'=> $request->term,
           );
           if(PointsRanges::getData($data1)==null)
           {
                       $value=PointsRanges::insertData($data);
           }


            

            $update = DB::table('out_of_marks')
                            ->where([
                                ['teacher_id', '=', $request->account_id],
                                ['course_id', '=', $request->course_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'term1_quiz'=>$Out_of_marks->term1_quiz+$request->term_quiz,
                              'term1_exam'=>$Out_of_marks->term1_exam+$request->term_exam,
                              'term1_total_marks'=>($Out_of_marks->term1_quiz)+($request->term_quiz+$request->term_exam),
                              'updated_at'=>$now
                            ]);


            return response()->json(['message'=>'Updated successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_total_marks_term1"],401);
        }

        }
        else if($request->term==2)
        {
             if($today>=$term2_from && $today<=$term3_to)
            {

             

            $update = DB::table('out_of_marks')
                            ->where([
                                ['teacher_id', '=', $request->account_id],
                                ['course_id', '=', $request->course_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'term2_quiz'=>$Out_of_marks->term2_quiz+$request->term_quiz,
                              'term2_exam'=>$Out_of_marks->term2_exam+$request->term_exam,
                              'term2_total_marks'=>$Out_of_marks->term2_total_marks+$request->term_quiz+$request->term_exam,
                              'updated_at'=>$now
                            ]);


            return response()->json(['message'=>'Updated successfully'],200);
             }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_total_marks_term2"],401);
        }

        }
        else if($request->term==3)
        {
             if($today>=$term3_from && $today<=$term3_to)
            {
            
            $update = DB::table('out_of_marks')
                            ->where([
                                ['teacher_id', '=', $request->account_id],
                                ['course_id', '=', $request->course_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'term3_quiz'=>$Out_of_marks->term3_quiz+$request->term_quiz,
                              'term3_exam'=>$Out_of_marks->term3_exam+$request->term_exam,
                              'term3_total_marks'=>$Out_of_marks->term3_total_marks+$request->term_quiz+$request->term_exam,
                              'updated_at'=>$now
                            ]);


            return response()->json(['message'=>'Updated successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_total_marks_term3"],401);
        }

        }


    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
         /**
        * @OA\Post(
        * path="/api/out_of_marks/convert",
        * operationId="convertMaximumMarks",
        * tags={"Convert maximum marks API"},
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
        *               required={"school_id","class_id","course_id","account_id","term","term_quiz","term_exam"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="course_id", type="number"),
        *               @OA\Property(property="account_id", type="number"),
        *               @OA\Property(property="term_quiz", type="number"),
        *               @OA\Property(property="term_exam", type="number"),
        *               @OA\Property(property="term", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Maximum points is successfully converted",
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
    public function convert(Request $request)
    {
        //
         //
        $data = $request->all();


        $check_course = Out_of_marks::select('*')->where([
            ['school_id', '=', $request->school_id],
            ['course_id','=',$request->course_id],
            ['teacher_id','=',$request->account_id],
            ['class_id','=',$request->class_id]
        ])->count();
         $now=date('Y-m-d H:i:s');
         $today=strtotime(date('Y-m-d'));
         $academic_year=academic_year::first();

         $term1_from=strtotime($academic_year->term1_from);
         $term1_to=strtotime($academic_year->term1_to);
         $term2_from=strtotime($academic_year->term2_from);
         $term2_to=strtotime($academic_year->term2_to);
         $term3_from=strtotime($academic_year->term3_from);
         $term3_to=strtotime($academic_year->term3_to);
         if($today>=$term1_from && $today<=$term3_to)
         {
            $academic_year=(date('Y')).'-'.(date('Y')+1);
         }

         


        if($check_course==0)
        {
           $insert_user=DB::insert('INSERT INTO out_of_marks(academic_year,school_id,course_id,teacher_id,class_id,term1_quiz,term1_exam,term1_total_marks,term2_quiz,term2_exam,term2_total_marks,term3_quiz,term3_exam,term3_total_marks,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$academic_year,$request->school_id,$request->course_id,$request->account_id,$request->class_id,0,0,0,0,0,0,0,0,0,$now,$now]);
        }
         $Out_of_marks = Out_of_marks::select('*')
        ->where([
                                ['teacher_id', '=', $request->account_id],
                                ['course_id', '=', $request->course_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
        ])->first();

        $students = Marks::select('*')
        ->where([
                                ['teacher_id', '=', $request->account_id],
                                ['course_id', '=', $request->course_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
        ])->get();
        if($request->term==1)
        {
            if($today>=$term1_from && $today<=$term3_to)
            {


            $quiz=$request->term_quiz==''?$Out_of_marks->term1_quiz:$request->term_quiz;
            $exam=$request->term_exam==''?$Out_of_marks->term1_exam:$request->term_exam;
            $total=$quiz + $exam;

            $update = DB::table('out_of_marks')
                            ->where([
                                ['teacher_id', '=', $request->account_id],
                                ['course_id', '=', $request->course_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'term1_quiz'=>$quiz,
                              'term1_exam'=>$exam,
                              'term1_total_marks'=>$total,
                              'updated_at'=>$now
                            ]);

                         $now=date('Y-m-d H:i:s');
                         for($i=0;$i<=$students->count()-1;$i++)
                         {

                            $student_id=$students[$i]->student_id;
                            $term1_quiz=$students[$i]->term1_quiz;
                            $term1_exam=$students[$i]->term1_exam;
                            $term1_total_marks=$students[$i]->term1_total_marks;

                            $term1_quiz=$term1_quiz && $Out_of_marks->term1_quiz?round(($term1_quiz/$Out_of_marks->term1_quiz)*$quiz,1):$term1_quiz;
                            $term1_exam=$term1_exam && $Out_of_marks->term1_exam>0?round(($term1_exam/$Out_of_marks->term1_exam)*$exam,1):$term1_exam;
                            $term1_total_marks=$term1_quiz + $term1_exam;

                            $update = DB::update("UPDATE marks SET `term1_quiz`=?,`term1_exam`=?,`term1_total_marks`=?,`updated_at`=? WHERE student_id=? AND teacher_id=? AND course_id=? AND class_id=? AND school_id=?",[$term1_quiz,$term1_exam,$term1_total_marks,$now,$student_id,$request->account_id,$request->course_id,$request->class_id,$request->school_id]);
                         }



            return response()->json(['message'=>'Converted successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_total_marks_term1"],401);
        }

        }
        else if($request->term==2)
        {
            if($today>=$term2_from && $today<=$term3_to)
            {


            $quiz=$request->term_quiz==''?$Out_of_marks->term2_quiz:$request->term_quiz;
            $exam=$request->term_exam==''?$Out_of_marks->term2_exam:$request->term_exam;
            $total=$quiz + $exam;

            $update = DB::table('out_of_marks')
                            ->where([
                                ['teacher_id', '=', $request->account_id],
                                ['course_id', '=', $request->course_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'term2_quiz'=>$quiz,
                              'term2_exam'=>$exam,
                              'term2_total_marks'=>$total,
                              'updated_at'=>$now
                            ]);

                         $now=date('Y-m-d H:i:s');
                         for($i=0;$i<=$students->count()-1;$i++)
                         {

                            $student_id=$students[$i]->student_id;
                            $term2_quiz=$students[$i]->term2_quiz;
                            $term2_exam=$students[$i]->term2_exam;
                            $term2_total_marks=$students[$i]->term2_total_marks;

                            $term2_quiz=$term2_quiz>0?round(($term2_quiz/$Out_of_marks->term2_quiz)*$quiz,1):$term2_quiz;
                            $term2_exam=$term2_exam>0?round(($term2_exam/$Out_of_marks->term2_exam)*$exam,1):$term2_exam;
                            $term2_total_marks=$term2_quiz + $term2_exam;


                            $update = DB::update("UPDATE marks SET `term2_quiz`=?,`term2_exam`=?,`term2_total_marks`=?,`updated_at`=? WHERE student_id=? AND teacher_id=? AND course_id=? AND class_id=? AND school_id=?",[$term2_quiz,$term2_exam,$term2_total_marks,$now,$student_id,$request->account_id,$request->course_id,$request->class_id,$request->school_id]);
                         }



            return response()->json(['message'=>'Converted successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_total_marks_term2"],401);
        }

        }
        else if($request->term==3)
        {
            if($today>=$term3_from && $today<=$term3_to)
            {


            $quiz=$request->term_quiz==''?$Out_of_marks->term3_quiz:$request->term_quiz;
            $exam=$request->term_exam==''?$Out_of_marks->term3_exam:$request->term_exam;
            $total=$quiz + $exam;

            $update = DB::table('out_of_marks')
                            ->where([
                                ['teacher_id', '=', $request->account_id],
                                ['course_id', '=', $request->course_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'term3_quiz'=>$quiz,
                              'term3_exam'=>$exam,
                              'term3_total_marks'=>$total,
                              'updated_at'=>$now
                            ]);

                         $now=date('Y-m-d H:i:s');
                         for($i=0;$i<=$students->count()-1;$i++)
                         {

                            $student_id=$students[$i]->student_id;
                            $term3_quiz=$students[$i]->term3_quiz;
                            $term3_exam=$students[$i]->term3_exam;
                            $term3_total_marks=$students[$i]->term3_total_marks;

                            $term3_quiz=$term3_quiz>0?round(($term3_quiz/$Out_of_marks->term3_quiz)*$quiz,1):$term3_quiz;
                            $term3_exam=$term3_exam>0?round(($term3_exam/$Out_of_marks->term3_exam)*$exam,1):$term3_exam;
                            $term3_total_marks=$term3_quiz + $term3_exam;

                            $update = DB::update("UPDATE marks SET `term3_quiz`=?,`term3_exam`=?,`term3_total_marks`=?,`updated_at`=? WHERE student_id=? AND teacher_id=? AND course_id=? AND class_id=? AND school_id=?",[$term3_quiz,$term3_exam,$term3_total_marks,$now,$student_id,$request->account_id,$request->course_id,$request->class_id,$request->school_id]);
                         }



            return response()->json(['message'=>'Converted successfully'],200);
        }
        else
        {
            return response()->json(['message'=>"marks_vue.failed_edit_total_marks_term3"],401);
        }

        }
        


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Out_of_marks  $out_of_marks
     * @return \Illuminate\Http\Response
     */
    public function show(Out_of_marks $out_of_marks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Out_of_marks  $out_of_marks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Out_of_marks $out_of_marks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Out_of_marks  $out_of_marks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Out_of_marks $out_of_marks)
    {
        //
    }
}
