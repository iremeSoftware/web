<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\UserTrackersController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use App\Models\license_keys;
use App\Models\School_registration_requests;
use App\Models\transactionApproved;
use App\Models\sms_requests;



use App\Models\User;
use App\Models\Mail\Sendmail;
use App\Models\Schools;
use App\Models\Tokens;
use App\Models\user_role;
use App\Models\classrooms;
use App\Models\User_authentications;
use App\Models\VerificationCodes;
use App\Models\Students;
use DB;
use URL;
use Socialite;


class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','confirm_account','forgot_password','get_reset_token','reset_password','updateUid']]);
    }

    /**
        * @OA\Post(
        * path="/api/register",
        * operationId="Register",
        * tags={"Register"},
        * summary="User Register",
        * description="User Register here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"name","email", "password","password_confirmation", "phone_number","school_name"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="password", type="password"),
        *               @OA\Property(property="password_confirmation", type="password"),
        *               @OA\Property(property="phone_number", type="text"),
        *               @OA\Property(property="school_name", type="text")
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
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


     public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed',
            'phone_number'  => 'required|string|min:10|max:10|unique:users',
            'school_name' => 'required|string|max:255',
            //'school_email' => 'required|string|email|max:255|unique:schools',
            //'school_phone_number' => 'required|string|min:10|max:10|unique:schools',
            //'school_district' => 'required|string|max:255',
            //'school_sector' => 'required|string|max:255'
        ]);        
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }   
            $school_id=Str::random(8);
            $account_id=Str::random(30);

        $user = new User;
        $user->user_type = 'normal_user';
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone_number = $request->phone_number;
        $user->school_id = $school_id;
        $user->account_id = $account_id;
        $user->account_enabled = 0;
        $user->profile_pic = '';
        $user->save(); 

        $schools = new Schools;
        $schools->school_name = $request->school_name;
        $schools->school_id = $school_id;
        $schools->school_representative = $account_id;
        $schools->school_email = $request->school_email;
        $schools->school_phone_number = $request->school_phone_number;
        $schools->school_district = $request->school_district;
        $schools->school_sector = $request->school_sector;
        $schools->enabled = 0;
        $schools->license_key_activated = 1;
        $schools->logo = '';
        $schools->save(); 

        $user_role = new user_role;
        $user_role->school_id = $school_id;
        $user_role->account_id = $account_id;
        $user_role->user_role = 'Director';
        $user_role->save(); 

        $tokens = Helper::generate_token();
        $token = new Tokens;
        $token->token = $tokens;
        $token->token_expiry = '';//in mins
        $token->account_id = $account_id;
        $token->save(); 


        $subject="Confirm your account";
        $details = [
            'subject' => $subject,
        'body' => "
        <h2>Welcome to Iremeapp.com</h2>

        <p>Hello ". $request->name .", Thank you for registering your school to Iremeapp.com, Iremeapp is online system where we have all  solutions you need to easily manage your school</p>

        <p>Click on the link below to complete registration</p>


        <a style='background-color:#6a4bce;border-radius:3px;color:#ffffff;display:inline-block;font-family:verdana;font-size:16px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px' target='_blank' href='".URL::to('/')."/auth/login?token=" . $tokens . "'>Confirm your account</a>
        <br><br><br><hr>
       Note: You will receive a 30 days free trial package, the next time you select a plan that matches your institution, we hope you will enjoy our services.<br>",
        'from'=>'Iremeapp.com',
        'receiver'=>$request->email
       ];
   
        Mail::to($request->email)->send(new \App\Mail\Sendmail($details,$subject));
        $delete_request=School_registration_requests::delete_request($request->request_id);

        return response()->json(['status' => 'success','data'=> $user,'schools'=>$schools,'user_role'=>$user_role,'token'=>$token],201);
    }
    /**
     * Confirm account.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
        * @OA\Get(
        * path="/api/confirm_account/{token}",
        * operationId="Confirm Account",
        * tags={"Confirm Account"},
        * summary="Confirm Account",
        * description="Confirm Account",
       *      @OA\Parameter(
       *         name="token",
       *         in="path",
       *         description="Confirm token",
       *         required=true,
       *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Confirm Account",
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



    public function confirm_account(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'token' => 'unique:tokens'
        ]);  
      
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $check_token = Tokens::select('*')
        ->join('users','users.account_id','=','tokens.account_id')
        ->where('token', '=', $request->token)
        ->first();



        if(empty($check_token))
        {
            return response()->json(['status'=>'failed'], 401);
        }
        else
        {
        $free_trial= 30;
        $get_free_license=license_keys::get_free_license($check_token->school_id,$free_trial,$request->uuid);//
        $confirm_user = DB::table('users')
                            ->where('account_id', '=', $check_token->account_id)
                            ->update(array('account_enabled'=>1));
                            if(!empty($confirm_user))
                            {
                             $delete_token = DB::table('tokens')
                            ->where('token', '=', $check_token[0]->token)
                            ->delete();
                            }
        $authentications = new User_authentications;
        $authentications->account_id =$check_token->account_id;
        $authentications->school_id =$check_token->school_id;
        $authentications->authentications ='add_classroom,add_course,edit_school_settings,generate_report,teacher,edit_students,edit_conduct_marks,student_payment,send_sms,pay_license,access_statistics,access_file_manager,add_new_users,edit_student_attendance,
        access_lms';
        $authentications->save(); 
                           
        }


         return response()->json(['status'=>'success'],200);    
    }
    /**
     * Get reset password token
     *
     * @return \Illuminate\Http\JsonResponse
     */
       /**
        * @OA\Get(
        * path="/api/get_reset_token/{token}",
        * operationId="Get Reset Token",
        * tags={"Get Reset Token"},
        * summary="Get Reset Token",
        * description="Get Reset Token",
        *      @OA\Parameter(
        *         name="token",
        *         in="path",
        *         description="Confirm token",
        *         required=true,
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Get Reset Token",
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



    public function get_reset_token(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'token' => 'unique:tokens',
        ]);  
      
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $check_token = Tokens::select('account_id as acc')->where('token', '=', $request->token)->first();




        if(!$check_token)
        {
            return response()->json(['status'=>'unauthenticated'], 401);
        }


         return response()->json(['status'=>'success'],200);    
    }

    /**
     * Reset account password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
        * @OA\Post(
        * path="/api/reset_password",
        * operationId="resetPassword",
        * tags={"Reset Password"},
        * summary="Reset Password",
        * description="Reset Password",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"password", "confirm_password","access_token"},
        *               @OA\Property(property="password", type="password"),
        *               @OA\Property(property="confirm_password", type="password"),
        *               @OA\Property(property="access_token", type="text")
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Account password reset",
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


    
    public function reset_password(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6',
            'access_token'=>'required'
        ]);  
      
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        if($request->password!=$request->confirm_password)
        {
           return response()->json(["errors"=>["confirm_password"=>"message.password_not_match"]
           ],422); 
        }


        $check_token = Tokens::select('account_id as acc')->where('token', '=', $request->access_token)->first();
        

        

        if(!$check_token)
        {
            return response()->json(['status'=>'unauthenticated'], 401);
        }


        // if(Helper::is_token_valid('tokens',$request->access_token)==false)
        // {
        //   return response()->json(["errors"=>["token_expired"=>"message.token_expired"]
        //    ],401);
        // }
        
       
        
        $change_password = DB::update('update users set password = ?,account_enabled=1 where account_id = ?',[bcrypt($request->password),$check_token->acc]);

        if($change_password)
        {
            $delete_token = DB::table('tokens')
                            ->where('token', '=', $request->access_token)
                            ->delete(); 
        return response()->json(['status'=>'success','account_id'=>$check_token->acc],200);    

        }


    }




    /**
     * Forgot your password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
     /**
        * @OA\Post(
        * path="/api/forgot_password",
        * operationId="forgotPassword",
        * tags={"Forgot Password"},
        * summary="Forgot Password",
        * description="Forgot Password",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"email"},
        *               @OA\Property(property="email", type="text")
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Reset password link sent",
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
    public function forgot_password(Request $request){
        
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);  
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        } 


        $user = User::select('*')->where('email', '=', $request->email)->first();
        if(!$user)
        {
            return response()->json(['status' => 'unauthenticated','email'=>['Your email is not registered']],401);

        }

        $check_token = Tokens::select('*')->where('account_id', '=', $user->account_id)->first();



        if($check_token)
        {
            $tokens=$check_token->token;
            $check_token->token_expiry=Helper::generate_token_expiry('60');//in mins
            $check_token->save();
        }
        else
        {
        $tokens = Helper::generate_token();
        $token = new Tokens;
        $token->token = $tokens;
        $token->token_expiry = Helper::generate_token_expiry('60');//in mins
        $token->account_id = $user->account_id;
        $token->save();
        }
        


        


        $subject="Forgot your password?";
        $details = [
            'subject' => $subject,
        'body' => "
        <h2>Forgot your password?</h2>

        <p>Hello ". $user->name .", Click on the link below to to reset your password</p>



        <a style='background-color:#6a4bce;border-radius:3px;color:#ffffff;display:inline-block;font-family:verdana;font-size:16px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px' target='_blank' href='".Helper::web_url()."/auth/password/reset/" . $tokens . "'>Reset password</a>
        <br><br><br>",
        'from'=>'Iremeapp.com',
        'receiver'=>$user->email
       ];
   
        Mail::to($request->email)->send(new \App\Mail\Sendmail($details,$subject));

        return response()->json(['status' => 'success','token'=>$tokens],200);





    }

    /**
        * @OA\Post(
        * path="/api/login/updateUid",
        * operationId="updateUid",
        * tags={"Update User Id"},
        * summary="Update User Id",
        * description="Update User Id",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"email","uid"},
        *               @OA\Property(property="email", type="email"),
        *               @OA\Property(property="uid", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="User Id is successfully updated",
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

    public function updateUid(Request $request)
    {
        $user=User::where([
            ['email', '=', $request->email]
        ])
        ->first();
        if($user)
        {
            if(strlen($request->accessToken) > 1000 )
            {
                $split_accessToken = explode('.',$request->accessToken);
                if(count($split_accessToken)==3)
                {
                    $user->uid = $request->uid;
                    $user->access_token = $request->accessToken;
                    $user->profile_pic = $request->photoURL;
                    $user->save();
                }
            }
            
        }

        return response()->json(['status'=>'UPDATED'],200);
    }

    /**
        * @OA\Post(
        * path="/api/login",
        * operationId="authLogin",
        * tags={"Login"},
        * summary="User Login",
        * description="Login User Here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"email", "password","d_id","loginWith"},
        *               @OA\Property(property="email", type="email"),
        *               @OA\Property(property="password", type="password"),
        *               @OA\Property(property="d_id", type="number"),
        *               @OA\Property(property="loginWith", type="text")
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Login Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Login Successfully",
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



    public function login(Request $request)
    {
        if($request->loginWith=='Google')
        {
         $loginData = $request->validate([
            'email' => 'email|required', 
            'uid' => 'required',
            'accessToken' => 'required'          
        ]); 
        }
        else
        {
          $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
            
        ]); 
        }
        
         $device_id=$request->d_id;
         $user_type=$request->user_type;
        $confirmed = User::where([
            ['email', '=', $request->email],
            ['account_enabled','=',1],
            ['user_type','LIKE', '%'. $user_type.'%']
        ])
        ->get();

        if($confirmed->count()==0)
        {
          return response()->json(['password'=>['Your account was not verified']], 401); 

        }

        if($request->loginWith=='Google')
        {
          $user=User::where([
            ['email', '=', $request->email],
            ['uid', '=', $request->uid],
            ['access_token', '=', $request->accessToken],
        ])->first();

          $accessToken  = $user->createToken('UserToken', ['*'])->accessToken;

        //   $authclass = new AuthController();
        //   $device_id=$authclass->VerificationCodes($device_id,$user->account_id);

        }
        else if($request->loginWith=='normal_login')
        {

        
        if (!auth()->attempt($loginData)) {
           return response()->json(['password'=>['Invalid email or password']], 401); 
        }

        $user=auth()->user();
       $accessToken = auth()->user()->createToken('authToken')->accessToken;
       $authclass = new AuthController();
      // $device_id=$authclass->VerificationCodes($device_id,$user->account_id);


        
      }

        return response()->json(['user' => $user,'d_id'=>"",'access_token' => $accessToken,'status'=>'SUCCESS'],200);

    }

    

    public function VerificationCodes($device_id,$account_id){

      $verify_device = VerificationCodes::select('verification_code')->where([
            ['verification_code', '=', $device_id],
            ['account_id','=',$account_id]
        ])->count();
      $user = DB::table('users')
       ->where([
        ['users.account_id',$account_id]
      ])
       ->first();

        if($verify_device==0)
        {
          $delete_old_verification_code = DB::table('verification_codes')
       ->where('account_id','=',$user->account_id)
       ->delete();

          $numeric="0123456789";
          $device_id=substr(str_shuffle($numeric),0,5);
          $VerificationCodes=new VerificationCodes;
          $VerificationCodes->account_id = $account_id;
          $VerificationCodes->verification_code = $device_id;
          $VerificationCodes->save();


          $subject="Account verification code";
        $details = [
            'subject' => $subject,
        'body' => "
        <h2>Verification code</h2>

        <p>Copy the verification code below</p>

          <br>
          <h3>".$device_id."</h3>",
        'from'=>'Iremeapp.com',
        'receiver'=>$user->email
       ];
   
        Mail::to($user->email)->send(new \App\Mail\Sendmail($details,$subject));
        $verified=0;
        $device_id='';
        $UserTrackers=new UserTrackersController();
        $store=$UserTrackers->store($account_id);
        return '';

        }
        else
        {
                  
                  $verified=1;
                  $UserTrackers=new UserTrackersController();
                  $store=$UserTrackers->store($account_id);
                  return $device_id;


        }
    }

    
    /**
        * @OA\Post(
        * path="/api/current_user",
        * operationId="get_user",
        * tags={"Get Current User"},
        * summary="Get Current User",
        * description="Get Current User",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Response(
        *          response=200,
        *          description="Get Current User",
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
    public function get_user(){
        $user=auth()->user();


        $data = DB::table('users')
       ->join('schools', 'users.school_id', '=', 'schools.school_id')
       ->where('users.account_id','=',$user->account_id)
       ->first();

        $check_classroom=classrooms::select('*')
        ->where('school_id','=',$user->school_id)
        ->get();

       if($check_classroom->count()>0){
        $class_teacher = DB::table('users')
        ->select('classrooms.class_id','classrooms.classroom_name')
       ->join('classrooms', 'classrooms.classroom_representative', '=', 'users.account_id')
       ->where('users.account_id','=',$user->account_id)
       ->first();
       }
       else
       {
         $class_teacher=null;
       }
        return response()->json(['user_info'=>$data,'class_teacher'=>$class_teacher],200);
    }

    /**
        * @OA\Post(
        * path="/api/current_admin",
        * operationId="get_current_admin",
        * tags={"Get Current Admin"},
        * summary="Get Current Admin",
        * description="Get Current Admin",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Response(
        *          response=200,
        *          description="Get Current Admin",
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


      public function get_admin(){
        $user=auth()->user();
        $data = DB::table('users')
       ->where('users.account_id','=',$user->account_id)
       ->first();

       
        return response()->json(['user_info'=>$data],200);
    }
    /**
     * UPDATE ACCOUNT INFO.
     *
     * @return \Illuminate\Http\JsonResponse
     */

      /**
        * @OA\Post(
        * path="/api/account/settings",
        * operationId="update_records",
        * tags={"Update user records"},
        * summary="Update user records",
        * description="Update user records",
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
        *               required={"name", "phone_number","file"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="phone_number", type="number"),
        *               @OA\Property(property="file", type="file", format="file"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Update user records",
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


    
    public function update_records(Request $request)
    {
        $user=auth()->user();
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required|min:10|max:10'
        ]);

         
      
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        if(!empty($request->file('file')))
        {
          $file = $request->file('file');
           // Valid File Extensions
          $valid_extension = array('png','jpg','jpeg');
          $upload_avatar=Helper::upload_file('avatar',$file,$valid_extension);
        }

        $new_filename=!empty($upload_avatar)?$upload_avatar:$user->profile_pic;
        $delete_old_pic=Helper::delete_file('avatar',$user->profile_pic);
        $update_info = DB::table('users')
        ->where('account_id', '=', $user->account_id)
        ->update([
        'name'=>$request->name,
        'phone_number'=>$request->phone_number,
        //'email'=>$request->email,
        'profile_pic'=>$upload_avatar ?? ''
        ]);
    
        

        if($update_info)
        {
            
        return response()->json(['message'=>'Updated successfully'],200);    

        }
     
  
}

    /**
     * Change account password.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
        * @OA\Post(
        * path="/api/account/change_password",
        * operationId="change_password",
        * tags={"Change user password"},
        * summary="Change user password",
        * description="Change user password",
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
        *               required={"new_password", "confirm_password"},
        *               @OA\Property(property="new_password", type="password"),
        *               @OA\Property(property="confirm_password", type="password"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Password is successfully updated",
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


    
    public function change_password(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
            'confirm_password'=>'required|min:6'
        ]);  
      
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        if($request->new_password!=$request->confirm_password)
        {
           return response()->json(["errors"=>"message.password_not_match"],422); 
        }
        $user=auth()->user();
        
        /*if($check_old_password==0)
        {
           return response()->json(["errors"=>["old_password"=>"message.old_password_not_valid"]
           ],401);
        }
        */

        
       
        
        $change_password = DB::update('update users set password = ? where account_id = ?',[bcrypt($request->new_password),$user->account_id]);

        if($change_password)
        {
           
        return response()->json(['status'=>'Password successfully changed'],200);    

        }


    }

    /**
        * @OA\Post(
        * path="/api/current_school/{school_id}",
        * operationId="get_current_school",
        * tags={"Get current school information"},
        * summary="Get current school information",
        * description="Get current school information",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School Id",
        *         required=true,
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Get current school information",
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


     public function get_school(Request $request){
        

        $get_school = Schools::select('*')->where('school_id', '=', $request->school_id)->first();

        return $get_school;
    }

    /**
     * Recharge amount to SMS resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
        * @OA\Post(
        * path="/api/donating/mobile_money",
        * operationId="donating_by_mobile_money",
        * tags={"Pay online using flutterwave"},
        * summary="Pay online using flutterwave",
        * description="Pay online using flutterwave",
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
        *               required={"price", "email","phone_number"},
        *               @OA\Property(property="price", type="number"),
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="phone_number", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Pay online using flutterwave",
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


    public function donating_by_mobile_money(Request $request){
        $user=auth()->user();
        $tx_ref=Helper::generate_file_id();
        $amount=$request->price;
        $email=$user->email;
        $phone_number=$request->phone_number;
        $fullName=$user->name;
        $currency='Rwf';
        $redirect_url=Helper::web_url()."/dashboard/welcome";
        $network='mtn';



        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //  CURLOPT_URL => 'https://api.flutterwave.com/v3/charges?type=mobile_money_rwanda',
        //  CURLOPT_RETURNTRANSFER => true,
        //  CURLOPT_ENCODING => '',
        //  CURLOPT_MAXREDIRS => 10,
        //  CURLOPT_TIMEOUT => 0,
        //  CURLOPT_FOLLOWLOCATION => true,
        //  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //  CURLOPT_CUSTOMREQUEST => 'POST',
        //  CURLOPT_POSTFIELDS => "tx_ref=MC-$tx_ref&amount=$amount&fullName=$fullName&email=$email&phone_number=$phone_number&currency=$currency&redirect_url=$redirect_url&network=$network",
        //  CURLOPT_HTTPHEADER => array(
        //      'Authorization: Bearer FLWSECK-994736594f8d7cb48efe74509a24b139-X'
        //       ),
        //  ));

        //  $response = curl_exec($curl);
        //  curl_close($curl);
        //  $resp=json_decode($response); 
        // if($resp)
        // {
            // $transaction=transactionApproved::create([
            //     'school_id'=>$user->school_id,
            //     'account_id'=>$user->account_id,
            //     'transaction_id'=>$tx_ref,
            //     'amount'=>$amount,
            //     'status'=>0,
            // ]);

            $transaction=sms_requests::create([
                'school_id'=>$user->school_id,
                'request_id'=>$tx_ref,
                'number_of_sms'=>0,
                'price'=>$amount,
                'phone_number'=>$phone_number,
                'activated'=>0,
                'classes'=>'',
                'account_id'=>$user->account_id
            ]);

            //####################################SEND SMS INFORMING ADMIN##########################


            $data=array(
                "sender"=>'Iremeapp',
                "recipients"=>'+250785980973',
                "message"=>"Hello admin,".$fullName." send payment of ".$amount." Rwf please check in your flutterwave account",
              );

           $url="https://www.intouchsms.co.rw/api/sendsms/.json";
           $data1=http_build_query($data);
           $username="nyakurilevite";
           $password="Levite191098";

           $ch=curl_init();
           curl_setopt($ch,CURLOPT_URL,$url);
           curl_setopt($ch,CURLOPT_USERPWD,$username.":".$password);
           curl_setopt($ch,CURLOPT_POST,true);
           curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
           curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
           curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
           $result=curl_exec($ch);
           $httpcode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
           curl_close($ch);
           if($httpcode==200)
           {
       
           }
        //##################################//SEND SMS INFORMING ADMIN##########################
        // }
         return response()->json(['response'=>$transaction],200);
        }


        /**
     * API for approve transaction.
     *
     * @return \Illuminate\Http\JsonResponse
     */

      /**
        * @OA\Post(
        * path="/api/sms_transaction/approve/{transaction_id}",
        * operationId="approveTransaction",
        * tags={"Approve SMS transaction"},
        * summary="Approve SMS transaction",
        * description="Approve SMS transaction",
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="transaction_id",
        *         in="path",
        *         description="Transaction ID",
        *         required=true,
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="SMS transaction approved successfully",
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


    public function approve_transaction(Request $request){
        $user=auth()->user();
        $transaction_id=explode('-',$request->transaction_id); 
        $transaction=transactionApproved::where('transaction_id',$transaction_id[1])->first();
        if($user->account_id==$transaction->account_id)
        {
            if($transaction->status==0)
            {
                $transaction->status=1;
                $transaction->save();
    
                $school=Schools::where('school_id',$user->school_id)->first();
                $school->sms_amount=$school->sms_amount+$transaction->amount;
                $school->save();


                $subject="SMS payment receipt";
                $details = [
                    'subject' => $subject,
                'body' => "
                <h2>SMS payment receipt</h2>
        
                <p>Hello <b>".$user->name."</b>, thanks for purchasing SMS amount which is equivalent to <b>".$transaction->amount." RWF</b>, your transaction id is: <b>MC-".$transaction->transaction_id."</b></p>",
                'from'=>'Iremeapp.com',
                'receiver'=>$user->email
               ];
           
                Mail::to($user->email)->send(new \App\Mail\Sendmail($details,$subject));
    
                $data['status']=200;
                $data['records']=$school;
                $data['message']='Approved successfully';
            }
            else
            {
                $data['status']=422;
                $data['records']='';
                $data['message']='Already approved';
            }
           
        }
        else
        {
            $data['status']=401;
            $data['records']='';
            $data['message']='You are not allowed to perform this action';
        }
        
        
         return response()->json($data);
        }
 

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
   
     /**
     * @OA\Post(
     *     path="/api/logout",
     *   operationId="logout",
     *   tags={"Logout User Authentication"},
     *   summary="Logout User Authentication",
     *   description="Logout User Authentication",
     *  security={
     *  {"passport": {}},
     *   },
     *     summary="LOGS OUT CURRENT LOGGED IN USER SESSION",
     *     operationId="logout",
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),


     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function logout(Request $request){
            $accessToken = Auth::user()->token();
            $user = auth()->user();
            $token= $request->user()->tokens->find($accessToken);
            $token->revoke();
            $response=array();
            $response['status']=1;
            $response['statuscode']=200;
            $response['msg']="Successfully logout";
             $update=DB::table('user_trackers')
            ->where([
                ['user_trackers.account_id','=',$user->account_id]
            ])
            ->update([
                'logged_in'=>0
            ]);
            return response()->json($response)->header('Content-Type', 'application/json');
        }
}
