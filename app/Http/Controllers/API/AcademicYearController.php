<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\academic_year;

class AcademicYearController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:api',['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Get(
        * path="/api/academic_year",
        * operationId="AcademicYearController",
        * tags={"Academic Year"},
        * summary="Academic year",
        * description="Get academic year",
        *      @OA\Response(
        *          response=200,
        *          description="Got Academic year",
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
    public function index()
    {
        //
         $today=strtotime(date('Y-m-d'));
         $academic_year=academic_year::get();
         $term1_from=strtotime($academic_year[0]->term1_from);
         $term1_to=strtotime($academic_year[0]->term1_to);
         $term2_from=strtotime($academic_year[0]->term2_from);
         $term2_to=strtotime($academic_year[0]->term2_to);
         $term3_from=strtotime($academic_year[0]->term3_from);
         $term3_to=strtotime($academic_year[0]->term3_to);
         $academic_year=$academic_year[0]->academic_year;
         

         if($today>=$term1_from && $today<=$term1_to)
         {
            $term='1';
         }
         else if($today>=$term2_from && $today<=$term2_to)
         {
            $term='2';
         }
         else if($today>=$term3_from && $today<=$term3_to)
         {
            $term='3';
         }
         else{
            $term=null;
         }

         return response()->json(['term'=>$term,'academic_year'=>$academic_year],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
