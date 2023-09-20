<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AcademicYearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\file_managers;
use App\Helpers\Helper;
use DB;
use Str;


class FileManagersController extends Controller
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
        * path="/api/file_manager",
        * operationId="getFolders",
        * tags={"List files & folders API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
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
        *         name="department",
        *         in="query",
        *         description="Department",
        *      ),
        *      @OA\Parameter(
        *         name="term",
        *         in="query",
        *         description="Term",
        *      ),
        *      @OA\Parameter(
        *         name="class_id",
        *         in="query",
        *         description="Class ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Files & folders are successfully retrieved",
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
      $limit=$request->limit;
      $page=$request->page-1;
      $offset=ceil($limit*$page);
  
        $file_managers=file_managers::select('*')
        ->where([
            ['academic_year','=',$request->academic_year],
            ['school_id','=',$request->school_id],
            ['department','=',$request->department],
            ['term','=',$request->term],
            ['class_id','=',$request->class_id],
            
        ])
        ->offset($offset)
        ->limit($limit)
        ->get();

        

        $file_managers_count=file_managers::select('*')
        ->where([
            ['academic_year','=',$request->academic_year],
            ['school_id','=',$request->school_id],
            ['department','=',$request->department],
            ['term','=',$request->term],
            ['class_id','=',$request->class_id],
            
        ])
        ->get();


        $no_of_records=$file_managers_count->count();
        

        return response()->json(['file_managers'=>$file_managers,'offset'=>$offset,'no_of_records'=>$no_of_records,'message'=>'Retrieved successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/file_manager",
        * operationId="saveFiles",
        * tags={"Create files & folders API"},
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
        *               required={"file", "school_id","department","term","class_id","student_id"},
        *
        *               @OA\Property(property="file", type="file", format="file"),
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="department", type="text"),
        *               @OA\Property(property="term", type="text"),
        *               @OA\Property(property="class_id", type="text"),
        *               @OA\Property(property="student_id", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Folders are successfully created",
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
        $user=auth()->user();
        $AcademicYear=new AcademicYearController();
        $term=json_encode($AcademicYear->index());
        $term=(array) json_decode($term);
        $current_term=$term['original']->term;
        $academic_year=$term['original']->academic_year;
        $now=date('Y-m-d H:i:s');


         if(!empty($request->file('file')))
        {
          $folder="report_form";  
          $file = $request->file('file');
          $new_filename=Helper::upload_file_to_AWS($folder,$file);
        }  


        $check_file_manager=file_managers::select('*')
        ->where([
            ['school_id',$request->school_id],
            ['department',$request->department],
            ['term',$request->term],
            ['class_id',$request->class_id],
            ['student_id',$request->student_id],
        ])
        ->get();
        $new_filename=!empty($new_filename)?$new_filename:$check_file_manager->file_name;
        $extension=explode('.', $new_filename);
        $extension=$extension[1];
        if($check_file_manager->count()>0)
        {
           $delete_old_file=Helper::delete_file_from_AWS($check_file_manager[0]->file_url);

           $update_file_contents=DB::table('file_managers')
           ->where([
            ['academic_year',$academic_year],
            ['school_id',$request->school_id],
            ['department',$request->department],
            ['term',$request->term],
            ['class_id',$request->class_id],
            ['student_id',$request->student_id],
        ])
           ->update([
            'file_id'=>$new_filename,
            'file_type'=>$extension,
            'file_name'=>$request->file_name,
            'updated_at'=>$now
        ]);
        }
        else 
        {
            $file_managers=new file_managers();
            $file_managers->academic_year=$academic_year;
            $file_managers->school_id=$request->school_id;
            $file_managers->department=$request->department;
            $file_managers->term=$request->term;
            $file_managers->class_id=$request->class_id;
            $file_managers->student_id=$request->student_id;
            $file_managers->fileId=Helper::file_name();
            $file_managers->fileUrl=$new_filename;
            $file_managers->file_type=$extension;
            $file_managers->file_name=$request->file_name;
            $file_managers->save();
        }

        return response()->json(['message'=>'Uploaded successfully'],201);

    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/file_manager/search",
        * operationId="searchFiles",
        * tags={"Search files & folders API"},
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
        *               required={"school_id","department","term","class_id","file_name"},
        *        *      @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="department", type="text"),
        *               @OA\Property(property="term", type="text"),
        *               @OA\Property(property="class_id", type="text"),
        *               @OA\Property(property="file_name", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Folders are successfully retrieved",
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
    public function search_records(Request $request)
    {
        //
      
  
        $file_managers=file_managers::select('*')
        ->where([
            ['academic_year','=',$request->academic_year],
            ['school_id','=',$request->school_id],
            ['department','=',$request->department],
            ['term','=',$request->term],
            ['class_id','=',$request->class_id],
            ['file_name','like','%'.$request->file_name.'%']
            
        ])
        ->get();
                

        return response()->json(['file_managers'=>$file_managers,'message'=>'Retrieved successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\file_managers  $file_managers
     * @return \Illuminate\Http\Response
     */
    public function show(file_managers $file_managers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\file_managers  $file_managers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, file_managers $file_managers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\file_managers  $file_managers
     * @return \Illuminate\Http\Response
     */
     /**
        * @OA\Get(
        * path="/api/file_manager/delete/{file_id}",
        * operationId="deleteFiles",
        * tags={"Delete files & folders API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="fileId",
        *         in="path",
        *         description="File ID",
        *         required=true,
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Folder is successfully deleted",
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
        $file_managers=file_managers::select('*')
        ->where([
            ['fileId','=',$request->fileId],
            ['school_id','=',$user->school_id]
            
        ])
        ->first();
        $delete_old_file=Helper::delete_file_from_AWS($file_managers->file_url);
        $delete_file=file_managers::select('*')
        ->where([
            ['fileId','=',$request->fileId],
            ['school_id','=',$user->school_id]
            
        ])
        ->delete();

    return response()->json(['message'=>'Deleted successfully']);
    }
}
