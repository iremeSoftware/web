<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\School_registration_requests;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\Sendmail;
use Illuminate\Support\Facades\Auth;




class SchoolRegistrationRequestsController extends Controller
{
    public function __construct()
    {
            $this->middleware('auth:api', ['except' => ['index', 'store']]);
        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
          /**
        * @OA\Get(
        * path="/api/registration/request/{id}",
        * operationId="getRegistrationRequest",
        * tags={"Get school registration request API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="id",
        *         in="path",
        *         description="Registration ID",
        *      ),
        *      @OA\Parameter(
        *         name="page",
        *         in="query",
        *         description="Page",
        *      ),
        *      @OA\Parameter(
        *         name="limit",
        *         in="query",
        *         description="Limit",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="School registration requests are successfully retrieved",
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
        $count_requests=School_registration_requests::count();
        if($request->id=='all')
        {
        $page=$request->page-1;
        $limit=$request->limit;
        $offset=ceil($limit*$page);
        $RegistrationRequests=School_registration_requests::offset($offset)->limit($limit)->get();
        }
        else
        {
        $RegistrationRequests=School_registration_requests::where('request_id',$request->id)->first();
          $offset=0;
        }
        return response()->json(['School_registration_requests'=>$RegistrationRequests,'count'=>$count_requests,'offset'=>$offset]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/registration/request/send",
        * operationId="createSchoolRegistrationRequest",
        * tags={"Create school registration request API"},
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"name","email","phone_number","school_name","school_scale"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="phone_number", type="text"),
        *               @OA\Property(property="school_name", type="text"),
        *               @OA\Property(property="school_scale", type="text"), 
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="School registration request is successfully created",
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
        //
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|required',
            'phone_number'=>'required|min:10|max:10',
            'school_name'=>'required',
            'school_scale'=>'required'
        ]);
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        } 
        $RegistrationRequests=new School_registration_requests();
        $RegistrationRequests->request_id=Helper::generate_token();
        $RegistrationRequests->name=$request->name;
        $RegistrationRequests->email=$request->email;
        $RegistrationRequests->phone_number=$request->phone_number;
        $RegistrationRequests->school_name=$request->school_name;
        $RegistrationRequests->scale=$request->school_scale;
        $RegistrationRequests->save();

        return response()->json(['message'=>'Requested successfully'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\School_registration_requests  $school_registration_requests
     * @return \Illuminate\Http\Response
     */
    public function show(School_registration_requests $school_registration_requests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\School_registration_requests  $school_registration_requests
     * @return \Illuminate\Http\Response
     */

         /**
        * @OA\Post(
        * path="/api/registration/request/accept/{id}",
        * operationId="updateSchoolRegistrationRequest",
        * tags={"Update school registration request API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *  @OA\Parameter(
        *         name="id",
        *         in="path",
        *         description="Content ID",
        *      ),
        *   @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"name","email","phone_number","school_name"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="phone_number", type="text"),
        *               @OA\Property(property="school_name", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="School registration request is successfully approved",
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
        //
        $RegistrationRequests=School_registration_requests::where('request_id',$request->id)->first();

        $request_id=$RegistrationRequests->request_id;
        $name=$RegistrationRequests->name;
        $email=$RegistrationRequests->email;
        $phone_number=$RegistrationRequests->phone_number;
        $school_name=$RegistrationRequests->school_name;
        $scale=$RegistrationRequests->scale;

        $subject="Registration request accepted";
        $details = [
            'subject' => $subject,
        'body' => "
        <h2>Registering of ".$school_name." is accepted</h2>

        <p>Hello ". $name .", Thank you for requesting registration of ".$school_name.", click on the link below to complete registration</p>



        <a style='background-color:#6a4bce;border-radius:3px;color:#ffffff;display:inline-block;font-family:verdana;font-size:16px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:200px' target='_blank' href='".Helper::web_url()."/auth/register/" . $request_id . "/'>Register your school</a>
        <br><br><br>",
        'from'=>'iremeapp.com',
        'receiver'=>$email
       ];
   
        Mail::to($email)->send(new \App\Mail\Sendmail($details,$subject));
        


        return response()->json(['message'=>'Registration request accepted']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\School_registration_requests  $school_registration_requests
     * @return \Illuminate\Http\Response
     */
           /**
        * @OA\Post(
        * path="/api/registration/request/{request_id}/delete",
        * operationId="deleteSchoolRegistrationRequest",
        * tags={"Delete school registration request API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="request_id",
        *         in="path",
        *         description="Request ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="School registration request is successfully approved",
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
        $delete_request=School_registration_requests::delete_request($request->request_id);
        return response()->json(['message'=>'Request deleted successfully']);
    }
}
