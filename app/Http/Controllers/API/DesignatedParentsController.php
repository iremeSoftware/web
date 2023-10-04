<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\designated_parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;


class DesignatedParentsController extends Controller
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
        * path="/api/designated_parent",
        * operationId="getDesignatedParents",
        * tags={"Get child by parent ID API"},
        * summary="Get child by parent ID API",
        * description="Get child by parent ID API",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Response(
        *          response=200,
        *          description="Designated parent is successfully retrieved",
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
        $user=auth()->user();
        $designated_parents=designated_parents::select('*')
        ->join('users','users.account_id','=','designated_parents.parent_id')
        ->join('students','students.student_id','=','designated_parents.student_id')
        ->where([
            ['designated_parents.parent_id','=',$user->account_id]
        ])
        ->get();

        return response()->json(['designated_parents'=>$designated_parents],200);

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
     * @param  \App\designated_parents  $designated_parents
     * @return \Illuminate\Http\Response
     */
    public function show(designated_parents $designated_parents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\designated_parents  $designated_parents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, designated_parents $designated_parents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\designated_parents  $designated_parents
     * @return \Illuminate\Http\Response
     */
    public function destroy(designated_parents $designated_parents)
    {
        //
    }
}
