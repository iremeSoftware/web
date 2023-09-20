<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\PointsRanges;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class PointsRangesController extends Controller
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
        * @OA\Post(
        * path="/api/pointsRanges/get",
        * operationId="getPointRanges",
        * tags={"Get marks ranges API"},
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
        *               required={"school_id","course_id","term","class_id"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="course_id", type="number"),
        *               @OA\Property(property="term", type="number"),
        *               @OA\Property(property="class_id", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Maximum points is successfully retrieved",
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
        $data= array(
            'pointsranges.school_id' => $request->school_id,
            'pointsranges.class_id' => $request->class_id,
            'pointsranges.course_id' => $request->course_id,
            'term'=> $request->term,
         );

        $value=PointsRanges::getData($data);
        $countData=PointsRanges::countData($data);
        return response()->json(['points_ranges'=>$value,'count'=>$countData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      /**
        * @OA\Post(
        * path="/api/pointsRanges/post",
        * operationId="createPointRanges",
        * tags={"Save marks ranges API"},
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
        *               required={"school_id","course_id","teacher_id","term","class_id","division1","division2","division3","division4","division5","division6","division7","division8","division9"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="teacher_id", type="text"),
        *               @OA\Property(property="course_id", type="number"),
        *               @OA\Property(property="term", type="number"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="division1", type="number"),
        *               @OA\Property(property="division2", type="number"),
        *               @OA\Property(property="division3", type="number"),
        *               @OA\Property(property="division4", type="number"),
        *               @OA\Property(property="division5", type="number"),
        *               @OA\Property(property="division6", type="number"),
        *               @OA\Property(property="division7", type="number"),
        *               @OA\Property(property="division8", type="number"),
        *               @OA\Property(property="division9", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Maximum points is successfully created",
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
        
        $data= array(
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'course_id' => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'term' => $request->term,
            'division1' => $request->division1,
            'division2' => $request->division2,
            'division3' => $request->division3,
            'division4' => $request->division4,
            'division5' => $request->division5,
            'division6' => $request->division6,
            'division7' => $request->division7,
            'division8' => $request->division8,
            'division9' => $request->division9,
            'created_at' => Helper::now(),
            'updated_at' => Helper::now()
         );

         $where_conditions= array(
            'pointsranges.school_id' => $request->school_id,
            'pointsranges.class_id' => $request->class_id,
            'pointsranges.course_id' => $request->course_id,
            'term'=> $request->term,
         );

        $countData=PointsRanges::countData($where_conditions);
        if($countData ==0)
        {
        $value=PointsRanges::insertData($data);
        $value=$value?true:false;
        }
        else
        {
            $where_conditions= array(
                'school_id' => $request->school_id,
                'class_id' => $request->class_id,
                'course_id' => $request->course_id,
                'term'=> $request->term,
             );

            $value=PointsRanges::updateData($where_conditions,$data);
            $value=$value?true:false;
        }
        return $value==true?response()->json(['message'=>'Inserted successfully'],201):response()->json(['message'=>'Failed to be inserted'],422);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PointsRanges  $pointsRanges
     * @return \Illuminate\Http\Response
     */
    public function show(PointsRanges $pointsRanges)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PointsRanges  $pointsRanges
     * @return \Illuminate\Http\Response
     */
          /**
        * @OA\Post(
        * path="/api/pointsRanges/update",
        * operationId="updatePointRanges",
        * tags={"Update marks ranges API"},
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
        *               required={"school_id","course_id","teacher_id","term","class_id","division1","division2","division3","division4","division5","division6","division7","division8","division9"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="teacher_id", type="text"),
        *               @OA\Property(property="course_id", type="number"),
        *               @OA\Property(property="term", type="number"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="division1", type="number"),
        *               @OA\Property(property="division2", type="number"),
        *               @OA\Property(property="division3", type="number"),
        *               @OA\Property(property="division4", type="number"),
        *               @OA\Property(property="division5", type="number"),
        *               @OA\Property(property="division6", type="number"),
        *               @OA\Property(property="division7", type="number"),
        *               @OA\Property(property="division8", type="number"),
        *               @OA\Property(property="division9", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Maximum points is successfully updated",
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
        $validate = Validator::make($request->all(), [
            'division1'      => 'required',
            'division2'     => 'required',
            'division3'      => 'required',
            'division4'     => 'required',
            'division5'      => 'required',
            'division6'     => 'required',
            'division7'      => 'required',
            'division8'     => 'required',
            'division9'      => 'required',
        ]);        
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }  
        //
        $ids=array(
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'course_id' => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'term' => $request->term
        );

        $data= array(
            'division1' => $request->division1,
            'division2' => $request->division2,
            'division3' => $request->division3,
            'division4' => $request->division4,
            'division5' => $request->division5,
            'division6' => $request->division6,
            'division7' => $request->division7,
            'division8' => $request->division8,
            'division9' => $request->divisionU,
            'updated_at' => Helper::now()
         );

        $value=PointsRanges::updateData($ids,$data);
        $value=$value?true:false;
        return $value==true?response()->json(['message'=>'successfully updated'],200):response()->json(['message'=>'Failed to be updated'],401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PointsRanges  $pointsRanges
     * @return \Illuminate\Http\Response
     */

              /**
        * @OA\Post(
        * path="/api/pointsRanges/delete",
        * operationId="deletePointRanges",
        * tags={"Delete marks ranges API"},
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
        *               required={"school_id","course_id","teacher_id","term","class_id"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="teacher_id", type="text"),
        *               @OA\Property(property="course_id", type="number"),
        *               @OA\Property(property="term", type="number"),
        *               @OA\Property(property="class_id", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Maximum points is successfully deleted",
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
         $data=array(
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'course_id' => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'term' => $request->term,
        );

        $value=PointsRanges::deleteData($data);
        $value=$value?true:false;
        return $value==true?response()->json(['message'=>'successfully deleted'],200):response()->json(['message'=>'Failed to be deleted'],401);
    }
}
