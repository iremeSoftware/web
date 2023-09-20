<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserTrackers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;

class UserTrackersController extends Controller
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
        * path="/api/user/tracker",
        * operationId="getUsersTracker",
        * tags={"Get user track API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Response(
        *          response=200,
        *          description="User tracker is successfully retrieved",
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
        $UserTrackers=UserTrackers::select('*')
        ->join('users','users.account_id','=','user_trackers.account_id')
        ->where([
            ['user_trackers.account_id','=',$user->account_id]
        ])
        ->first();

        return response()->json(['UserTrackers'=>$UserTrackers,'message'=>'Retrived successfully'],200);
    }
    /*
Get IP Address
*/
        public function IpAddr(){
            if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                //ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                //ip pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }else{
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
            /**
        * @OA\Post(
        * path="/api/user/tracker/",
        * operationId="createUserTracker",
        * tags={"Create user tracker API"},
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
        *               required={"account_id"},
        *               @OA\Property(property="account_id"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="User tracker is successfully created",
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
    public function store($account_id)
    {
        //
        $user = User::where([
            ['account_id', '=', $account_id],
            ['account_enabled','=',1]
        ])
        ->first();

        $check_user_exist=UserTrackers::select('*')
        ->join('users','users.account_id','=','user_trackers.account_id')
        ->where([
            ['user_trackers.account_id','=',$user->account_id]
        ])
        ->count();
                  $now=date('Y-m-d H:i:s');

        if($check_user_exist==0)
        {
          $UserTrackers=new UserTrackers();
          $UserTrackers->account_id=$user->account_id;
          $UserTrackers->ip_address=UserTrackersController::IpAddr();
          $UserTrackers->logged_in=1;
          $UserTrackers->active_time=$now;
          $UserTrackers->save();

        }
        else
        {
            $update=DB::table('user_trackers')
            ->where([
                ['user_trackers.account_id','=',$user->account_id]
            ])
            ->update([
                'ip_address'=>UserTrackersController::IpAddr(),
                'logged_in'=>1,
                'active_time'=>$now
            ]);
        }
        return response()->json(['message'=>'Info updated successfully'],200);
    }

    /**
     * Check inactive users.
     *
     * @param  \App\UserTrackers  $userTrackers
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Get(
        * path="/api/user/tracker/active",
        * operationId="inactiveUserTracker",
        * tags={"Inactive user API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Response(
        *          response=200,
        *          description="Inactive users are successfully retrieved",
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
    public function inactive_users(UserTrackers $userTrackers)
    {
        //After 30 mins without any action you will be logged out 
        $user=auth()->user();
        $now=date('Y-m-d H:i:s');
        $active=DB::select("SELECT count(*) AS inactive FROM user_trackers INNER JOIN users ON users.account_id=user_trackers.account_id WHERE TIMESTAMPDIFF(second,user_trackers.active_time,'$now')>=3600 AND user_trackers.account_id='$user->account_id'");
        if($active[0]->inactive==1)
        {
            $update=DB::table('user_trackers')
            ->where([
                ['user_trackers.account_id','=',$user->account_id]
            ])
            ->update([
                'ip_address'=>UserTrackersController::IpAddr(),
                'logged_in'=>0
            ]);
        }

        return response()->json(['inactive'=>$active,'message'=>'Retrived successfully'],200);
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserTrackers  $userTrackers
     * @return \Illuminate\Http\Response
     */
    public function show(UserTrackers $userTrackers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserTrackers  $userTrackers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserTrackers $userTrackers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserTrackers  $userTrackers
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserTrackers $userTrackers)
    {
        //
    }
}
