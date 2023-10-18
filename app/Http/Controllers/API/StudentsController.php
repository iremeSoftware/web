<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;


use App\Models\User;
use App\Models\Tokens;
use App\Models\user_role;
use App\Models\Students;
use App\Models\Marks;
use App\Models\Schoolfees;
use App\Models\Discipline;
use App\Models\Schools;
use App\Models\designated_parents;

use App\Mail\Sendmail;
use URL;
use DB;




class StudentsController extends Controller
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
        * path="/api/students/{school_id}/{class_id}/{student_id}",
        * operationId="getStudents",
        * tags={"Get students API"},
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
        *         name="student_id",
        *         in="path",
        *         description="Student ID",
        *      ),
        *      @OA\Parameter(
        *         name="limit",
        *         in="query",
        *         description="Limit",
        *      ),
        *      @OA\Parameter(
        *         name="sort",
        *         in="query",
        *         description="Sort",
        *      ),
        *      @OA\Parameter(
        *         name="sort_by",
        *         in="query",
        *         description="Sort By",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Students are successfully retrieved",
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
      //**************Get student by id FOR SPECIFIED SCHOOL***************
        if(!empty($request->school_id) && !empty($request->class_id) && !empty($request->student_id) )
        {

        $students = Students::select('*')
         ->where([
        ['student_id', '=', $request->student_id]
        ])->first();

         $number_of_students=$students->count();
         $offset=0;
         $accessToken='';
        }

        if(empty($request->school_id) && empty($request->class_id) && !empty($request->student_id) )
        {

        $students = Students::select('*')
         ->where([
        ['student_id', '=', $request->student_id]
        ])->first();

         $user=User::findOrFail(32)->first();

          $accessToken  = $user->createToken('UserToken', ['*'])->accessToken;

         $number_of_students=$students->count();
         $offset=0;
        }
    //**************FETCH STUDENTS FROM CLASSROOM FOR SPECIFIED SCHOOL***************
        if(!empty($request->school_id) && !empty($request->class_id) && empty($request->student_id))
        {
          
            
                   $limit=$request->limit;
                   $page=$request->page-1;

           $offset=ceil($limit*$page);

        $all_students = Students::select('*')
         ->where([
        ['school_id', '=', $request->school_id],
        ['classroom','=',$request->class_id]
        ])->get();


         $students = Students::select('*')
         ->where([
        ['school_id', '=', $request->school_id],
        ['classroom','=',$request->class_id]
        ])
         ->offset($offset)
         ->limit($limit)
         ->orderBy('name')
         ->get();


         $number_of_students=$all_students->count();
         $accessToken='';
        }
    //***************************FETCH ALL STUDENTS OF SCHOOL************************
        else if(!empty($request->school_id) && empty($request->class_id) && empty($request->student_id))
        {
        
            
                   $limit=$request->limit;
                   $page=$request->page-1;

           $offset=ceil($limit*$page);

        $all_students = Students::select('*')
         ->where([
        ['school_id', '=', $request->school_id],
        ['deleted', '=', 0]
        ])->get();


         $students = Students::select('*')
         ->where([
        ['school_id', '=', $request->school_id]
        ])
         ->offset($offset)
         ->limit($limit)
         ->orderBy('name')
         ->get();


         $number_of_students=$all_students->count();
         $accessToken='';
       }
        

        return response()->json([ 'Students' => $students,'no_of_students'=>$number_of_students,'offset'=>$offset,'token'=>$accessToken,'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     /**
        * @OA\Post(
        * path="/api/students",
        * operationId="createStudent",
        * tags={"Create student API"},
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
        *               required={"school_id","student_id","name","student_sex","classroom"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="student_id", type="text"),
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="student_sex", type="text"),
        *               @OA\Property(property="classroom", type="text"),
        *               @OA\Property(property="fathers_name", type="text"),
        *               @OA\Property(property="mothers_name", type="text"),
        *               @OA\Property(property="mothers_phone", type="text"),
        *               @OA\Property(property="fathers_phone", type="text"),
        *               @OA\Property(property="priority_phone", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Student is successfully created",
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

        $validator = Validator::make($data, [
            'school_id' => 'required',
            'student_id' => 'required',
            'name' => 'required|max:255',
            'student_sex' => 'required',
            'classroom' => 'required',
            //'fathers_name' => 'required',
           // 'mothers_name' => 'required',
           // 'mothers_phone' => 'required|min:13|max:13',
            //'fathers_phone' => 'required|min:13|max:13',
            //'priority_phone' => 'required'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error'],422);
        }
        $students = Students::create($data);

        if(!empty($request->parent_email))
        {
        $account_id=Helper::generate_user_id(); 
        $tokens =Helper::generate_token();

        $token = new Tokens;
        $token->token = $tokens;
        $token->token_expiry=Helper::generate_token_expiry(60*24*7);//token expiring after 7 days
        $token->account_id = $account_id;
        $token->save();

        $check_parent_exist=User::where('email',$request->parent_email)->first();


        $designated_parents = new designated_parents;
        $designated_parents->school_id = $request->school_id;
        $designated_parents->parent_id = $check_parent_exist!=null? $check_parent_exist->account_id:$account_id;
        $designated_parents->student_id = $request->student_id;
        $designated_parents->save(); 

        if($check_parent_exist==null)
        {
        $user = new User;
        $user->name = $request->fathers_name;
        $user->email = $request->parent_email;
        $user->user_type='normal_user';
        $user->password = '';
        $user->phone_number = $request->fathers_phone;
        $user->school_id = $request->school_id;
        $user->account_id = $account_id;
        $user->account_enabled = 0;
        $user->profile_pic = '';
        $user->save(); 
        }


        $school= Schools::select('school_name as school_name')->where([
            ['school_id', '=', $request->school_id]
        ])->first();

//#######################INVITE PARENT TO USE THE SYSTEM#################################
        $subject="Complete registration";
        $details = [
            'subject' => $subject,
        'body' => "
        <h2>Welcome to Iremeapp</h2>

        <p>Hello ". $request->fathers_name ." and ". $request->mothers_name .", You are successfully registered to the portal of <b>".$school->school_name."</b> as parent of ". $request->name .",where Iremeapp will help you to know your kid's perfomance.</p>

        <p>Click on the link below to complete registration</p>


        <a style='background-color:#6a4bce;border-radius:3px;color:#ffffff;display:inline-block;font-family:verdana;font-size:16px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px' target='_blank' href='".URL::to('/')."auth/password/reset/" . $tokens . "'>Complete registration</a>
        <br><br><br><hr>
        Iremeapp is the online school management system that links school administration and parents to improve the quality of Rwandan education<br>",
        'receiver'=>$request->parent_email
       ];
   
        Mail::to($request->parent_email)->send(new \App\Mail\Sendmail($details,$subject));
//#####################//INVITE PARENT TO USE THE SYSTEM#################################
        }

        



        return response([ 'Students' => new StudentResource($students), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function show(Students $students)
    {
        //
    }


     /**
     * Search student.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
         /**
        * @OA\Post(
        * path="/api/students/search",
        * operationId="searchStudent",
        * tags={"Search student API"},
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
        *               required={"student_name","school_id","class_id"},
        *               @OA\Property(property="student_name", type="text"),
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Students are searched successfully",
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
    public function search(Students $students,Request $request)
    {
        //
      $students = Students::select('*')
         ->where([
        ['name', 'like', '%'. $request->student_name.'%'],
        ['school_id', '=', $request->school_id],
        ['classroom','=',$request->class_id]

        ])
         ->get();
         $number_of_students=$students->count();
         return response()->json([ 'Students' => $students,'no_of_students'=>$number_of_students, 'message' => 'Retrieved successfully'], 200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */

        /**
        * @OA\Post(
        * path="/api/students/{school_id}/{class_id}/importcsv",
        * operationId="importStudents",
        * tags={"Import students API"},
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
        *          description="Students are successfully imported",
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
    public function uploadstudentscsv(Request $request)
    {
        //
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
             
             // Skip first row (Remove below comment if you want to skip the first row)
             if($i == 0){
                $i++;
                continue; 
             }
            $alpha='0123456789';
              $i++;
              $student_id=substr(str_shuffle($alpha),0,10);              
              $student_name=$data[0];
              $student_sex=$data[1];
              $classroom=$request->class_id;
              $fathers_name=$data[2];
              $fathers_id=$data[3];
              $mothers_name=$data[4];
              $mothers_id=$data[5];
              $mothers_phone=$data[6];
              $fathers_phone=$data[7];
              $parent_email=$data[8];
              $location_district=$data[9];
              $location_sector=$data[10];
              $location_cell=$data[11];
              $location_village=$data[12];
              $priority_phone='mp';


       $students = Students::select('*')->where([
            ['school_id','=',$school_id],
            ['classroom','=',$classroom],
            ['fathers_name','=',$fathers_name],
            ['mothers_name','=',$mothers_name],
            ['name', '=', $student_name]
        ])
       ->count();

          
          if($students==0)
          {

          $rows++;
          $now=date('Y-m-d H:i:s');
           $insert_user=DB::insert('INSERT INTO students(school_id,student_id,name,student_sex,classroom,fathers_name,mothers_name,mothers_phone,fathers_phone,priority_phone,parent_email,fathers_id,mothers_id,location_district,location_sector,location_cell,location_village,sms_credits,deleted,registered_by,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$school_id,$student_id,$student_name,$student_sex,$classroom,$fathers_name,$mothers_name,$mothers_phone,$fathers_phone,$priority_phone,$parent_email,$fathers_id,$mothers_id,$location_district,$location_sector,$location_cell,$location_village,'0','0','',$now,$now]);

          $token = new Tokens;
          $tokens = Str::random(100);
          $account_id = Str::random(30);

          $check_user= User::select('*')
          ->where([
            ['email', '=', $parent_email]
            ])
          ->get();
          if($check_user->count()>0)
          {
            $user= User::select('*')->where([
            ['email', '=', $parent_email]
                ])
              ->first();
            $account_id=$user->account_id;
            $message="<br><br>";

          }


           


        $designated_parents = new designated_parents;
        $designated_parents->school_id = $school_id;
        $designated_parents->parent_id = $account_id;
        $designated_parents->student_id = $student_id;
        $designated_parents->save();
        

        if($check_user->count()==0)
        {
        $user = new User;
        $user->name = $fathers_name;
        $user->email = $parent_email;
        $user->password = '';
        $user->phone_number = $fathers_phone;
        $user->school_id = $school_id;
        $user->account_id = $account_id;
        $user->account_enabled = 0;
        $user->profile_pic = '';
        $user->save();

          $token->token = $tokens;
          $token->account_id = $account_id;
          $token->save();

          $message="<p>Click on the link below to complete registration</p><a style='background-color:#6a4bce;border-radius:3px;color:#ffffff;display:inline-block;font-family:verdana;font-size:16px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px' target='_blank' href='".URL::to('/')."/auth/complete/registration/" . $tokens . "'>Complete registration</a><br><br><br><hr>";
        }



          $subject="Complete registration";
        $details = [
            'subject' => $subject,
        'body' => "
        <h2>Welcome to iremeapp</h2>

        <p>Hello <b>". $fathers_name ."</b> and <b>". $mothers_name ."</b>, You are successfully registered to the portal of <b>".$school->school_name."</b> as parent of <b>". $student_name ."</b>,where Iremeapp system will help you to know your child perfomance.</p>".$message."Iremeapp is the online school management system that links school administration and parents to improve the quality of Rwandan education<br>",
        'receiver'=>$parent_email
       ];
   
        Mail::to($parent_email)->send(new \App\Mail\Sendmail($details,$subject));
        /****************************************************************************************/
      }




          }
          $delete_file=Helper::delete_file($location,$filename);
          
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
      /**
        * @OA\Post(
        * path="/api/students/update",
        * operationId="updateStudents",
        * tags={"Update students API"},
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
        *               required={"school_id","student_id","name","student_sex","classroom"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="student_id", type="text"),
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="student_sex", type="text"),
        *               @OA\Property(property="classroom", type="text"),
        *               @OA\Property(property="fathers_name", type="text"),
        *               @OA\Property(property="mothers_name", type="text"),
        *               @OA\Property(property="mothers_phone", type="text"),
        *               @OA\Property(property="fathers_phone", type="text"),
        *               @OA\Property(property="priority_phone", type="text"),
        *               @OA\Property(property="parent_email", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Students are successfully updated",
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
       $validator = Validator::make($request->all(), [
            'school_id' => 'required',
            'student_id' => 'required',
            'name' => 'required|max:255',
            'student_sex' => 'required',
            'classroom' => 'required',
            //'fathers_name' => 'required',
            //'mothers_name' => 'required',
            //'mothers_phone' => 'required|min:13|max:13',
            //'fathers_phone' => 'required|min:13|max:13',
            //'priority_phone' => 'required',
            //'parent_email' => 'email'
        ]);
       

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error'],422);
        }

        $check_student = Students::select('*')->where([
          ['student_id', '=', $request->student_id]
        ])
        ->first();

         if(!empty($request->parent_email))
         {
          if($check_student->classroom!=$request->classroom)
          {
             
            $delete_marks=Marks::select('*')
            ->where('student_id',$request->student_id)
            ->delete();
          }

          if($check_student->parent_email!=$request->parent_email)
          
          {

        //$check_student = User::select('*')->where(['email',$check_student->parent_email])->delete();
        $account_id=Helper::generate_user_id(); 
        $tokens =Helper::generate_token();

        $token = new Tokens;
        $token->token = $tokens;
        $token->account_id = $account_id;
        $token->save();


        $check_parent_exist=User::where('email',$request->parent_email)->first();


        $designated_parents = new designated_parents;
        $designated_parents->school_id = $request->school_id;
        $designated_parents->parent_id = $check_parent_exist!=null? $check_parent_exist->account_id:$account_id;
        $designated_parents->student_id = $request->student_id;
        $designated_parents->save(); 


        if($check_parent_exist==null)
        {
          $user = new User;
          $user->name = $request->fathers_name;
          $user->email = $request->parent_email;
          $user->user_type='normal_user';
          $user->password = '';
          $user->phone_number = $request->fathers_phone;
          $user->school_id = $request->school_id;
          $user->account_id = $account_id;
          $user->account_enabled = 0;
          $user->profile_pic = '';
          $user->save(); 
        }
        


        $school= Schools::select('school_name as school_name')->where([
            ['school_id', '=', $request->school_id]
        ])->first();

//#######################INVITE PARENT TO USE THE SYSTEM#################################
        $subject="Complete registration";
        $details = [
            'subject' => $subject,
        'body' => "
        <h2>Welcome to Iremeapp</h2>

        <p>Hello ". $request->fathers_name ." and ". $request->mothers_name .", You are successfully registered to the portal of <b>".$school->school_name."</b> as parent of ". $request->name .",where Iremeapp will help you to know your kid's perfomance.</p>

        <p>Click on the link below to complete registration</p>


        <a style='background-color:#6a4bce;border-radius:3px;color:#ffffff;display:inline-block;font-family:verdana;font-size:16px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px' target='_blank' href='".URL::to('/')."/auth/complete/registration/" . $tokens . "'>Complete registration</a>
        <br><br><br><hr>
        Iremeapp is the online school management system that links school administration and parents to improve the quality of Rwandan education<br>",
        'receiver'=>$request->parent_email
       ];
   
        Mail::to($request->parent_email)->send(new \App\Mail\Sendmail($details,$subject));
//#####################//INVITE PARENT TO USE THE SYSTEM#################################
        }
         }

         


        $update = DB::table('students')
                            ->where('student_id', '=', $request->student_id)
                            ->update([
                              'name'=>$request->name,
                              'student_sex'=>$request->student_sex,
                              'classroom'=>$request->classroom,
                              'fathers_name'=>$request->fathers_name,
                              'mothers_name'=>$request->mothers_name,
                              'mothers_phone'=>$request->mothers_phone,
                              'fathers_phone'=>$request->fathers_phone,
                              'priority_phone'=>$request->priority_phone,
                              'parent_email'=>$request->parent_email,
                              'fathers_ID'=>$request->fathers_ID,
                              'mothers_ID'=>$request->mothers_ID,
                              'location_district'=>$request->location_district,
                              'location_sector'=>$request->location_sector,
                              'location_cell'=>$request->location_cell,
                              'location_village'=>$request->location_village
                            ]);




        return response()->json(['message' => 'success'],200);

    }

    /**
     * Move students to another class.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/student/move",
        * operationId="moveStudents",
        * tags={"Move students API"},
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
        *               required={"school_id","student_id","from_class","to_class"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="student_id", type="text"),
        *               @OA\Property(property="from_class", type="text"),
        *               @OA\Property(property="to_class", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Students are successfully moved",
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
    public function move_students(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'school_id' => 'required',
        'student_id' => 'required',
        'from_class' => 'required',
        'to_class' => 'required',
        ]);

        $student_id_arr=explode(' ',$request->student_id);
        foreach ($student_id_arr as $key => $student_id) {
          $updateStudent = Students::where('student_id', '=', $student_id)
          ->where('school_id', '=', $request->school_id)
          ->first();
          $updateStudent->classroom = $request->to_class;
          $updateStudent->save();

          if($request->from_class != $request->to_class)
          {
            $delete_marks= Marks::select('student_id as student_id')
            ->where('student_id', '=', $student_id)
            ->delete();

            $delete_Discipline= Discipline::select('student_id as student_id')
            ->where('student_id', '=', $student_id)
            ->delete();
          }
        }

        return response()->json(['message' => 'success','no_of_students'=>count($student_id_arr)],200);


      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/students/delete/{student_id}",
        * operationId="deleteStudents",
        * tags={"Delete students API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="student_id",
        *         in="path",
        *         description="Student ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Student is successfully deleted",
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
        $check_student = Students::select('student_id as student_id')
        ->where('student_id', '=', $request->student_id)
        ->get();
        if($check_student->count()>0)
        {
           $delete_student= Students::select('student_id as student_id')
        ->where('student_id', '=', $request->student_id)
        ->delete();
           $delete_marks= Marks::select('student_id as student_id')
        ->where('student_id', '=', $request->student_id)
        ->delete();
          $delete_schoolfees= Schoolfees::select('student_id as student_id')
        ->where('student_id', '=', $request->student_id)
        ->delete();
        $delete_Discipline= Discipline::select('student_id as student_id')
        ->where('student_id', '=', $request->student_id)
        ->delete();
        $delete_designited_parent= designated_parents::select('student_id as student_id')
        ->where('student_id', '=', $request->student_id)
        ->delete();
        $delete_report_form= DB::table('report_form_view')
        ->where('student_id', '=', $request->student_id)
        ->delete();
        return response()->json(['message' => 'deleted_successfully'],200);
        }
    }
}
