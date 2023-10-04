<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Schools;
use Str;
use DB;


class SchoolController extends Controller
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
        * path="/api/school/{school_id}",
        * operationId="getListOfSchools",
        * tags={"Get schools API"},
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
        *          description="List of schools is successfully retrieved",
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

      if($request->school_id==null)
      {
        $page=$request->page-1;
        $limit=$request->limit;
        $offset=ceil($page*$limit);
        $schools=Schools::select('*')
        ->join('users','users.account_id','=','schools.school_representative')
        ->limit($limit)
        ->offset($offset)
        ->get();
      }
      else
      {
        $schools=Schools::select('*')
        ->where([
          ['school_id','=',$request->school_id]
        ])
        ->first();
      }

      return response()->json(['schools'=>$schools,'message'=>'Retrieved successfully','count'=>Schools::get()->count(),'offset'=>$offset],200);
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
      /**
        * @OA\Post(
        * path="/api/school/settings",
        * operationId="updateSchoolRecords",
        * tags={"Update school info API"},
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
        *               required={"school_name","school_id"},
        *               @OA\Property(property="school_name", type="text"),
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="school_email", type="text"),
        *               @OA\Property(property="school_phone_number", type="text"),
        *               @OA\Property(property="school_sector", type="text"),
        *               @OA\Property(property="school_district", type="text"),
        *               @OA\Property(property="file", type="file", format="file"),    
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="School info is successfully updated",
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
            'school_name' => 'required|max:255',
            //'school_email' => 'required',
            //'school_phone_number' => 'required|min:10|max:10',
            //'school_sector' => 'required',
            //'school_district' => 'required',
            'school_id' => 'required'
        ]);

         
      
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        if(!empty($request->file('file')))
        {
          $file = $request->file('file');

         // File Details 
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();
      $tempPath = $file->getRealPath();
      $fileSize = $file->getSize();
      $mimeType = $file->getMimeType();

      // Valid File Extensions
      $valid_extension = array('png','jpg','jpeg');

      // 2MB in Bytes
      $maxFileSize = 2097152; 
      $new_filename=Str::random(10).'.'.$extension;

      // Check file extension
      if(in_array(strtolower($extension),$valid_extension)){

        // Check file size
        if($fileSize <= $maxFileSize){

          // File upload location
          $location = 'school_logo';

          // Upload file
          $file->move($location,$new_filename);

          // Import CSV to Database
          $filepath = public_path($location."/".$new_filename);
           }
      else 
      {
        return response()->json(['message'=>'message.file_is_big'],401);
      }
    }
      else 
      {
        return response()->json(['message'=>'message.invalid_extensions'],401);
      }
    }

         $schools = Schools::select('*')
         ->where([
        ['school_id', '=', $request->school_id]
        ])->first();


        $new_filename=!empty($new_filename)?$new_filename:$schools->logo;


        $update_info = DB::table('schools')
        ->where('school_id', '=', $request->school_id)
        ->update([
        'school_name'=>$request->school_name,
        'school_phone_number'=>$request->school_phone_number,
        'school_email'=>$request->school_email,
        'school_district'=>$request->school_district,
        'school_sector'=>$request->school_sector,
        'logo'=>$new_filename,
        'school_motto'=>$request->school_motto
        ]);

        //$unset=unlink(URL::to('/')."/avatar/".$user->profile_pic);
    
        

        if($update_info)
        {
            
        return response()->json(['message'=>'Updated successfully'],200);    

        }
     
  
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
