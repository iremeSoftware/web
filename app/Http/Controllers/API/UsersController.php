<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


use App\Models\User;
use App\Models\Out_of_marks;
use App\Models\User_authentications;
use App\Models\Designated_teachers;
use App\Models\Tokens;
use App\Models\user_role;
use App\Models\Schools;
use App\Models\CSVImportUsers;
use App\Mail\Sendmail;

use Illuminate\Support\Facades\Validator;
use URL;
use DB;



class UsersController extends Controller
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
        * path="/api/users/{school_id}",
        * operationId="getUsers",
        * tags={"Get school users API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Users are successfully retrieved",
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
         $User = user_role::select('users.account_id','users.school_id','name','user_role')
         ->join('users','users.account_id',"=",'user_roles.account_id')
         ->where('users.school_id', '=', $request->school_id)
         ->distinct()
         ->orderBy('users.name','ASC')
         ->get();
        

        return response()->json([ 'users' => $User, 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/users",
        * operationId="createUser",
        * tags={"Create user API"},
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
        *               required={"name","school_id","email","select_user_role","phone_number"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="select_user_role", type="text"),
        *               @OA\Property(property="phone_number", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="New user is successfully created",
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
            'name'      => 'required',
            'school_id'      => 'required',
            'email'     => 'required|email',
            'select_user_role'     => 'required',
            'phone_number'  => 'required|string|min:10|max:10',
        ]);   

         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }   

        $account_id=Str::random(30);
        $check_user= User::select('*')->where([
            ['email', '=', $request->email]
        ])->count();
        if($check_user==0)
        {
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type='normal_user';
        $user->password = '';
        $user->phone_number = $request->phone_number;
        $user->school_id = $request->school_id;
        $user->account_id = $account_id;
        $user->account_enabled = 0;
        $user->profile_pic = '';
        $user->save();
        $tokens = Helper::generate_token();

        $user_role = new user_role;
        $user_role->school_id = $request->school_id;
        $user_role->account_id = $account_id;
        $user_role->user_role = $request->select_user_role;
        $user_role->save();

        $authentications = new User_authentications;
        $authentications->account_id =$account_id;
        $authentications->school_id =$request->school_id;
        $authentications->authentications ='';
        $authentications->save(); 

        $token = new Tokens;
        $token->token = $tokens;
        $token->token_expiry=Helper::generate_token_expiry(60*24*7);//token expiring after 7 days
        $token->account_id = $account_id;
        $token->save(); 
        $school= Schools::select('school_name as school_name')->where([
            ['school_id', '=', $request->school_id]
        ])->first();
        $locale=!empty($request->locale)?$request->locale:'en';
         $subject=$locale=='en'?"Complete your registration":($locale=='fr'?"Complétez votre inscription":"Uzuza kwiyandikisha kwawe");

        $details = $locale=='en'?[
            'subject' => $subject,
        'body' => "
        <h2>Welcome to Iremeapp</h2>

        <p>Hello <b>". $request->name ."</b>, You are successfully registered to the portal of <b>".$school->school_name."</b> as <b>". $request->select_user_role ."</b>,</p>

        <p>Click on the link below to complete registration</p>


        <a style='background-color:#6a4bce;border-radius:3px;color:#ffffff;display:inline-block;font-family:verdana;font-size:16px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px' target='_blank' href='".URL::to('/')."/auth/password/reset/" . $tokens . "'>Complete registration</a>
        <br><br><br><hr>
        Iremeapp is the online school management system that connects school administration and parents to improve the quality of education<br>",
        'receiver'=>$request->email
       ]:($locale=='fr'?
       [
            'subject' => $subject,
        'body' => "
        <h2>Welcome to Iremeapp</h2>

        <p>Bonjour <b> ". $request->name." </b>, Vous êtes inscrit avec succès sur le portail de <b> ". $school-> school_name." </b> as <b> ". $request -> select_user_role. "</b>,</p>

        <p>Cliquez sur le lien ci-dessous pour terminer l'inscription</p>


        <a style='background-color:#6a4bce;border-radius:3px;color:#ffffff;display:inline-block;font-family:verdana;font-size:16px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px' target='_blank' href='".URL::to('/')."/auth/complete/registration/" . $tokens . "'>Enregistrement complet</a>
        <br><br><br><hr>
        Iremeapp est le système de gestion scolaire en ligne qui relie l'administration scolaire et les parents pour améliorer la qualité de l'éducation<br>",
        'receiver'=>$request->email
       ]:[
            'subject' => $subject,
        'body' => "
        <h2>Welcome to Iremeapp</h2>

        <p>Muraho <b>". $request->name ."</b>, turabamenyesha ko mwanditswe muri porogaramu y'iremeapp mu kigo cya <b>".$school->school_name."</b> nka <b>". $request->select_user_role ."</b>,</p>

        <p>Kanda aho hasi wuzuze imyirondoro ibura</p>


        <a style='background-color:#6a4bce;border-radius:3px;color:#ffffff;display:inline-block;font-family:verdana;font-size:16px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px' target='_blank' href='".URL::to('/')."/auth/complete/registration/" . $tokens . "'>Uzuza kwiyandikisha</a>
        <br><br><br><hr>
        Iremeapp ni porogaramu ifasha ikigo mu mirimo itandukanye ikanahuza ubuyobozi bw'ikigo n'ababyeyi<br>",
        'receiver'=>$request->email
       ]);
   
        Mail::to($request->email)->send(new \App\Mail\Sendmail($details,$subject));
      }
      else
      {
        $user=User::select('*')
        ->where([
          ['email','=',$request->email]
        ])
        ->first();
        $account_id=$user->account_id;
        $user_role = new user_role;
        $user_role->school_id = $request->school_id;
        $user_role->account_id = $account_id;
        $user_role->user_role = $request->select_user_role;
        $user_role->save();

        $now=date("Y-m-d H:i:s");
        $my_auth=User_authentications::select('*')
        ->where([
            ['school_id', '=', $request->school_id],
            ['account_id', '=', $account_id]
        ])
        ->get();
           $check_exist=$my_auth->count();
 ###################################DEFINE USER'S AUTHORISATION#################################
        if($request->select_user_role=='Teacher')
        {
          $user_role='teacher';
        }
        else if($request->select_user_role=='Bursar')
        {
          $user_role='student_payment';
        }
        else if($request->select_user_role=='DOS')
        {
          $user_role='add_course,add_classroom,generate_report';
        }
        else if($request->select_user_role=='Patron')
        {
          $user_role='edit_conduct_marks';
        }
        else if($request->select_user_role=='Matron')
        {
          $user_role='edit_conduct_marks';
        }
###################################//DEFINE USER'S AUTHORISATION#################################
        if($check_exist==0)
        {  
        $authentications = new User_authentications;
        $authentications->account_id = $account_id;
        $authentications->school_id = $request->school_id;
        $authentications->authentications =$user_role;
        $authentications->save();
        }
        else
        {

        $update_authentication = DB::table('user_authentications')
        ->where([
            ['school_id', '=', $request->school_id],
            ['account_id', '=', $account_id]
        ])
        ->update([
        'authentications'=>$user_role.$my_auth[0]->authentications,
        'updated_at'=>$now
        ]);    
       }


      }

        return response()->json(['status' => 'success','data'=> $user,'user_role'=>$request->select_user_role],201);



    }

            /**
        * @OA\Post(
        * path="/api/users/{school_id}/importcsv",
        * operationId="importUser",
        * tags={"Import user API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"file"},
        *               @OA\Property(property="file", type="file", format="file"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="User is successfully imported",
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
    public function uploaduserscsv(Request $request){


      $file = $request->file('file');
      $school_id = $request->school_id;
            $school= Schools::select('school_name as school_name')
       ->where([
            ['school_id', '=', $school_id]
        ])->first();

      // File Details 
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();
      $tempPath = $file->getRealPath();
      $fileSize = $file->getSize();
      $mimeType = $file->getMimeType();

      // Valid File Extensions
      $valid_extension = array("csv");

      // 2MB in Bytes
      $maxFileSize = 2097152; 

      // Check file extension
      if(in_array(strtolower($extension),$valid_extension)){

        // Check file size
        if($fileSize <= $maxFileSize){

          // File upload location
          $location = 'uploads';

          // Upload file
          $file->move($location,$filename);

          // Import CSV to Database
          $filepath = public_path($location."/".$filename);

          // Reading file
          $file = fopen($filepath,"r");

          $importData_arr = array();
          $i = 0;
          $rows=0;

          while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
             
             if($i == 0){
                $i++;
                continue; 
             }
            
             $i++;

              $names = $data[0];
              $email = $data[1];
              $phone_number = $data[2];
              $user_roles = $data[3];

              $account_id=Str::random(30);
              $user = new User;
              $user_role = new user_role;
              $token = new Tokens;


          $user = User::select('*')->where([
                ['email', '=', $email]
            ])
          ->count();

          
          if($user==0)
          {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
              return response()->json(['message' => 'message.email_is_not_valid'],422);
            }

          $rows++;
          $now=date('Y-m-d H:i:s');
           $insert_user=DB::insert('INSERT INTO users(name,email,password,phone_number,school_id,account_id,account_enabled,profile_pic,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?)',[$names,$email,'',$phone_number,$school_id,$account_id,0,'',$now,$now]);

          $tokens = Str::random(255);  
          $user_role->school_id = $school_id;
          $user_role->account_id = $account_id;
          $user_role->user_role = $user_roles;
          $user_role->save();

          $token->token = $tokens;
          $token->account_id = $account_id;
          $token->token_expiry=Helper::generate_token_expiry(60*24*7);//token expiring after 7 days
          $token->save(); 
  ###################################DEFINE USER'S AUTHORISATION#################################
        if($user_roles=='Teacher')
        {
          $user_role='teacher';
        }
        else if($user_roles=='Bursar')
        {
          $user_role='student_payment';
        }
        else if($user_roles=='DOS')
        {
          $user_role='add_course,add_classroom,generate_report';
        }
        else if($user_roles=='Patron')
        {
          $user_role='edit_conduct_marks';
        }
        else if($user_roles=='Matron')
        {
          $user_role='edit_conduct_marks';
        }
###################################//DEFINE USER'S AUTHORISATION#################################

        $authentications = new User_authentications;
        $authentications->account_id =$account_id;
        $authentications->school_id =$school_id;
        $authentications->authentications =$user_role;
        $authentications->save();

           $subject="Complete registration";
        $details = [
            'subject' => $subject,
        'body' => "
        <h2>Welcome to Iremeapp</h2>

        <p>Hello ". $names .", You are successfully registered to  ".$school->school_name." as ". $user_roles .",</p>

        <p>Click on the link below to complete registration</p>


        <a style='background-color:#6a4bce;border-radius:3px;color:#ffffff;display:inline-block;font-family:verdana;font-size:16px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px' target='_blank' href='".URL::to('/')."/auth/password/reset/" . $tokens . "'>Complete registration</a>
        <br><br><br><hr>
        Schoolmodify is the online school management system that links school administration and parents to improve the quality of Rwandan education<br>",
        'receiver'=>$email
       ];
   
        Mail::to($email)->send(new \App\Mail\Sendmail($details,$subject));
        
      }
       else
      {
        $user=User::select('*')
        ->where([
          ['email','=',$email]
        ])
        ->first();
        $account_id=$user->account_id;
        $user_role = new user_role;
        $user_role->school_id = $request->school_id;
        $user_role->account_id = $account_id;
        $user_role->user_role = $user_roles;
        $user_role->save();

        $now=date("Y-m-d H:i:s");
        $my_auth=User_authentications::select('*')
        ->where([
            ['school_id', '=', $request->school_id],
            ['account_id', '=', $account_id]
        ])
        ->get();
           $check_exist=$my_auth->count();
 ###################################DEFINE USER'S AUTHORISATION#################################
        if($user_roles=='Teacher')
        {
          $user_role='teacher';
        }
        else if($user_roles=='Bursar')
        {
          $user_role='student_payment';
        }
        else if($user_roles=='DOS')
        {
          $user_role='add_course,add_classroom,generate_report';
        }
        else if($user_roles=='Patron')
        {
          $user_role='edit_conduct_marks';
        }
        else if($user_roles=='Matron')
        {
          $user_role='edit_conduct_marks';
        }
###################################//DEFINE USER'S AUTHORISATION#################################
        if($check_exist==0)
        {  
        $authentications = new User_authentications;
        $authentications->account_id = $account_id;
        $authentications->school_id = $request->school_id;
        $authentications->authentications =$user_role;
        $authentications->save();
        }
        else
        {
         
        $update_authentication = DB::table('user_authentications')
        ->where([
            ['school_id', '=', $request->school_id],
            ['account_id', '=', $account_id]
        ])
        ->update([
        'authentications'=>$user_role.$my_auth->authentications[0],
        'updated_at'=>$now
        ]);    
       }
      }




          }
          fclose($file);



          return response()->json(['status' => 'success','records'=> $i,'inserted'=> $rows],201);
        }
        else
        {
          return response()->json(['message' => 'message.file_is_big'],422);
        }
      }
      else
      {
        return response()->json(['message' => 'message.invalid_file_type'],422);
      }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
                /**
        * @OA\Post(
        * path="/api/change_school/{school_id}",
        * operationId="changeUserSchool",
        * tags={"Change User School API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="User school is successfully changed",
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
    public function change_school(Request $request)
    {
        //
      $user=auth()->user();
      if(!empty($request->school_id))
      {
        $now=date("Y-m-d H:i:s");
      $change_users_school = DB::table('users')
        ->where([
            ['account_id', '=', $user->account_id]
        ])
        ->update([
        'school_id'=>$request->school_id,
        'updated_at'=>$now
        ]);  

                return response()->json(['message'=>'Updated Successfully'],200);  

        }

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
      /**
        * @OA\Post(
        * path="/api/delete/user",
        * operationId="deleteUser",
        * tags={"Delete User API"},
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
        *          description="User is successfully deleted",
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
      $user=auth()->user();
      $check_if_still_have_courses=Designated_teachers::select('*')
        ->where([
          ['teacher_id','=',$request->account_id],
          ['school_id','=',$user->school_id],
        ])
        ->count();

        $check_if_still_have_roles=user_authentications::select('*')
        ->where([
          ['account_id','=',$request->account_id],
          ['school_id','=',$user->school_id],
        ])
        ->first();



        if($check_if_still_have_courses==0 && $check_if_still_have_roles->authentications=='')
        {
          $delete_user=User::select('*')
        ->where([
          ['account_id','=',$request->account_id]
        ])
        ->delete();

        $delete_auth=user_authentications::select('*')
        ->where([
          ['account_id','=',$request->account_id]
        ])
        ->delete();

           return response()->json(['message'=>'Deleted Successfully'],200);
        }
        else
        {
           return response()->json(['message'=>'Failed to delete user'],401);
        }

      

    }
}
