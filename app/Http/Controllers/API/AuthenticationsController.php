<?php

namespace App\Http\Controllers\API;

use App\Models\User_authentications;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use DB;

class AuthenticationsController extends Controller
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
        * path="/api/authentication/{school_id}",
        * operationId="getAuthentication",
        * tags={"Get Authentication list by school Id"},
        * summary="Get Authentication by School Id",
        * description="Get Authentication by School Id",
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
        *         name="account_id",
        *         in="query",
        *         description="Account ID",
        *      ),
        *      @OA\Parameter(
        *         name="records",
        *         in="query",
        *         description="Records(all)",
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
        *      @OA\Parameter(
        *         name="sort_by",
        *         in="query",
        *         description="Sort BY",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Get List of Authentication by school ID ",
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
        ###############GET LIST OF MY AUTHENTICATIONS BY SCHOOL ################################
                 $user=auth()->user();

        if($request->school_id!=='null' && !empty($request->account_id))
        {
        $authentication=User_authentications::select('*')
        ->where([
            ['school_id', '=', $request->school_id],
            ['account_id', '=', $request->account_id]
        ])
        ->first();
        $offset=0;
        $records=$authentication->count();
        }
        ###########################GET LIST OF MY AUTHENTICATIONS################################
        else if($request->school_id=='null' && !empty($request->account_id))
        {

        $authentication=User_authentications::select('*')
        ->join('schools','schools.school_id','=','user_authentications.school_id')
        ->where([
            ['account_id', '=', $request->account_id]
        ])
        ->get();

        foreach($authentication as $key=>$auth)
        {
            $authentication[$key]->logo = Helper::checkIfFileExists($auth->logo,'school_logo','default.jpg');
        }

        $offset=0;
        $records=$authentication->count();
        }
    ###############GET LIST OF ALL AUTHENTICATED USERS OF SCHOOL ################################

        else if($request->school_id!=='null' && empty($request->account_id))
        {  
            
            $count=User_authentications::select('*')
            ->join('users','users.account_id','=','user_authentications.account_id')
        ->where([
            ['user_authentications.school_id', '=', $request->school_id],
        ])
        ->count();
           if($request->records=='pagination')
           {
            $limit=$request->limit;
            $page=$request->page-1;
            $offset=ceil($limit*$page);
            $authentication=User_authentications::select('*')
            ->join('users','users.account_id','=','user_authentications.account_id')
        ->where([
            ['user_authentications.school_id', '=', $request->school_id],
        ])
        ->offset($offset)
        ->limit($limit)
        ->orderBy('users.name','ASC')
        ->get();
          }
          else if($request->records=='all')
           {

            $page = $request->page !='undefined'? $request->page : 1;    
            $limit= $request->limit !='undefined'? $request->limit : 10;
            $sort = $request->sort !='undefined'? $request->sort : 'users.name';
            $sort_by = $request->sort_by !='undefined'? $request->sort_by : 'ASC';
            $page=$page-1;
            $offset=ceil($limit*$page);
            $authentication=User_authentications::select('*')
            ->join('users','users.account_id','=','user_authentications.account_id')
            ->where([
                ['user_authentications.school_id', '=', $request->school_id],
            ])
            ->offset($offset)
            ->limit($limit)
            ->orderBy($sort,$sort_by)
            ->get();

            foreach($authentication as $key=>$user)
            {
              if(filter_var($user->profile_pic, FILTER_VALIDATE_URL) === FALSE)
              {
                if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/avatar/'.($user->profile_pic!="" ? $user->profile_pic : 'null')))
                {
                    $authentication[$key]['profile_pic'] = 'default.png';
                }
              }
            }

          }

        $records=$count;
        }
       return response()->json(['authentication'=>$authentication,'offset'=>$offset,'records'=>$records],200);   

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
     * @param  \App\User_authentications  $User_authentications
     * @return \Illuminate\Http\Response
     */
    public function show(User_authentications $user_authentications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User_authentications  $authentications
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/authentication/{school_id}",
        * operationId="updateAuthentication",
        * tags={"Update User authentication"},
        * summary="Update Authentication",
        * description="Update Authentication",
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
        *               required={"account_id", "authentications"},
        *               @OA\Property(property="account_id", type="number"),
        *               @OA\Property(property="authentications", type="text"),
        *               @OA\Property(property="account_enabled", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Upadate Authentication by school ID ",
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
        $user=auth()->user();
        $now=date("Y-m-d H:i:s");
        $school_id = $request->school_id ?? $user->school_id;
        $check_exist=User_authentications::select('*')
        ->where([
            ['school_id', '=', $school_id],
            ['account_id', '=',$request->account_id]
        ])
        ->count();

        if($check_exist==0)
        {
            $authentications = new User_authentications;
            $authentications->account_id = $request->account_id;
            $authentications->school_id = $school_id;
            $authentications->authentications = $request->authentications;
            $authentications->save();
        }
        else
        {
         
        $update_authentication = DB::table('user_authentications')
        ->where([
            ['school_id', '=', $school_id],
            ['account_id', '=', $request->account_id]
        ])
        ->update([
        'authentications'=>$request->authentications,
        'updated_at'=>$now
        ]); 



        if($request->account_id !=$user->account_id)
        {
            $user = User::select('*')
            ->where([
                ['account_id', '=',$request->account_id]
            ])
            ->first();
            $user->account_enabled = $request->account_enabled;
            $user->save();
        }
       }
            
        return response()->json(['message'=>'Updated successfully'],200);   
    }
    /**
     * Search user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User_authentications  $authentications
     * @return \Illuminate\Http\Response
     */

         /**
        * @OA\Post(
        * path="/api/authentication/search/{school_id}",
        * operationId="SearchAuthentication",
        * tags={"Search User authentication"},
        * summary="Search Authentication",
        * description="Search Authentication",
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
        *               required={"user_name"},
        *               @OA\Property(property="user_name", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Successfully search auth",
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
       $count=User_authentications::select('*')
            ->join('users','users.account_id','=','user_authentications.account_id')
        ->where([
            ['user_authentications.school_id', '=', $request->school_id],
        ])
        ->count();
           
            $authentication=User_authentications::select('*')
            ->join('users','users.account_id','=','user_authentications.account_id')
        ->where([
            ['user_authentications.school_id', '=', $request->school_id],
            ['users.name', 'like', '%'.$request->user_name.'%'],
        ])
        ->orderBy('users.name','ASC')
        ->get();
        $offset=0;
        $records=$count;

        foreach($authentication as $key=>$user)
            {
              
              $authentication[$key]->profile_pic = Helper::checkIfFileExists($user->profile_pic,'avatar','default.png');
            }



       return response()->json(['authentication'=>$authentication,'offset'=>$offset,'records'=>$records],200);   

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User_authentications  $authentications
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_authentications $user_authentications)
    {
        //
    }
}
