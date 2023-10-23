<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\user_role;

class user_roles_controller extends Controller
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
        * path="/api/user_roles/{school_id}",
        * operationId="getUserRoles",
        * tags={"Get user roles API"},
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
        *         name="limit",
        *         in="query",
        *         description="Limit",
        *      ),
        *      @OA\Parameter(
        *         name="page",
        *         in="query",
        *         description="Page",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="User roles are successfully retrieved",
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
        $page=$page-1;
        $offset=ceil($limit*$page);
        $user_roles = user_role::select('*')
        ->where('school_id', '=', $request->school_id)
        ->offset($offset)
        ->limit($limit)
        ->get();
    
        return response()->json([ 'user_roles' => $user_roles,'offset'=>$offset, 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/user_roles",
        * operationId="createUserRole",
        * tags={"Create user roles API"},
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
        *               required={"school_id","user_name","user_role"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="user_name", type="text"),
        *               @OA\Property(property="user_role", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="User role is successfully created",
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
        $validate = Validator::make($request->all(), [
            'school_id'      => 'required',
            'user_name'     => 'required',
            'user_role'     => 'required'
        ]);   

         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }   

        $check_user_role = user_role::select('*')
        ->where([
            ['school_id', '=', $request->school_id],['account_id', '=', $request->user_name],['user_role', '=', $request->user_role]
        ])
        ->count();

        if($check_user_role>0)
        {
            return response()->json(['exist'=>'assign_staff_members_Modal.exist'],422);
        }


        $user_role = new user_role;
        $user_role->school_id = $request->school_id;
        $user_role->account_id = $request->user_name;
        $user_role->user_role = $request->user_role;
        $user_role->save();

        if($user_role)
        {
            return response()->json(['status'=>'Inserted successfully'],201);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Get(
        * path="/api/user_roles/{school_id}/{account_id}/{user_role}",
        * operationId="getUserRole",
        * tags={"Get role for user API"},
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
        *         name="account_id",
        *         in="path",
        *         description="Account ID",
        *      ),
        *      @OA\Parameter(
        *         name="user_role",
        *         in="path",
        *         description="User role",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="User role is successfully shown",
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
    public function show(Request $request)
    {
        //
        if(!empty($request->school_id) && !empty($request->account_id) && empty($request->user_role))
        {
        $user_roles = user_role::select('*')
        ->where([
            ['school_id', '=', $request->school_id],
            ['account_id', '=', $request->account_id]
        ])
        ->get();
        }
        else if(!empty($request->school_id) && !empty($request->account_id) && !empty($request->user_role))
        {
            $user_roles = user_role::select('*')
        ->where([
            ['school_id', '=', $request->school_id],
            ['account_id', '=', $request->account_id],
            ['user_role', '=', $request->user_role],
        ])
        ->get();

        }

        return response()->json([ 'user_roles' => $user_roles, 'message' => 'Retrieved successfully'], 200);
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
