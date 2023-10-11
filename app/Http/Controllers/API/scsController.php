<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Illuminate\Http\Request;

use App\Models\scs;
use DB;
use Str;
use File;


class scsController extends Controller
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
        * path="/api/scs/get_files_folders/{school_id}/{file_hierarchy}",
        * operationId="getSCS",
        * tags={"Get School Cloud Storage API"},
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
        *         name="file_hierarchy",
        *         in="query",
        *         description="File Hierarchy",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="School Cloud Storage  are successfully retrieved",
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
         $data= array(
            'school_id' => $request->school_id,
            'file_hierarchy' => $request->file_hierarchy,
         );
         

         $folders=explode(',', $request->file_hierarchy);
         $breadcrumb=[];
         foreach ($folders as  $value) {
            $data1= array(
            'school_id' => $request->school_id,
            $value=='empty'?'file_hierarchy':'folder_file_id' => $value,
         );
            $breadcrumb=array_merge($breadcrumb,array(scs::getDataById($data1)));
            
             # code...
         }

        $value=scs::getData($data);
        $countData=scs::countData($data);
        return response()->json(['scs'=>$value,'breadcrumb'=>$breadcrumb,'count'=>$countData]);
    }

        /**
        * @OA\Get(
        * path="/api/scs/get_files/{school_id}/all",
        * operationId="getAllFiles",
        * tags={"Get all files & folders API"},
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

    public function get_all(Request $request)
    {
        //
         $data= array(
            'school_id' => $request->school_id,
         );
        $feedback=scs::getData($data);
        $countData=scs::countData($data);
        $totalUsageStorage=0;
        foreach ($feedback as $value) {
            # code...
            
            $totalUsageStorage=$totalUsageStorage+$value->file_size;

        }
        return response()->json(['scs'=>$feedback,'disk_usage'=>round($totalUsageStorage/1024000,1),'count'=>$countData]);
    }

    /**
        * @OA\Get(
        * path="/api/scs/get_files_byId/{school_id}/{folder_file_id}",
        * operationId="getOneFiles",
        * tags={"Get one file or folder API"},
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
        *         name="folder_file_id",
        *         in="path",
        *         description="File or folder ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="File or folder is successfully retrieved",
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


    public function getFileById(Request $request)
    {
        //
         $data= array(
            'school_id' => $request->school_id,
            'folder_file_id' => $request->folder_file_id,
         );

        $value=scs::getDataById($data);
        return response()->json(['scs'=>$value]);
    }

        /**
        * @OA\Post(
        * path="/api/scs/get_files_byId/{school_id}/{folder_file_id}",
        * operationId="getOneFile",
        * tags={"Get one file or folder API"},
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
        *         name="folder_file_id",
        *         in="path",
        *         description="File or folder ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Files and folders is successfully retrieved",
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

    public function search_files(Request $request)
    {
        //
         $data= array(
            'school_id' => $request->school_id,
            'folder_file_name' => $request->folder_file_name,
         );

        $value=scs::searchData($data);
        return response()->json(['scs'=>$value]);
    }

    /**
        * @OA\Post(
        * path="/api/scs/get_files_byId/{school_id}/{folder_file_id}/rename",
        * operationId="searchFilesAPI",
        * tags={"Rename file or folder API"},
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
        *         name="folder_file_id",
        *         in="path",
        *         description="File or folder ID",
        *      ),
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"new_folder_name"},
        *               @OA\Property(property="new_folder_name", type="text"),   
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Files and folders are successfully updated",
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
         $data= array(
            'folder_file_name' => $request->new_folder_name,
         );

         $where=array(
            'school_id' => $request->school_id,
            'folder_file_id' => $request->folder_file_id
        );

        $value=scs::updateData($where,$data);
        return response()->json(['scs'=>$value,"message"=>"Updated successfully"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
        * @OA\Post(
        * path="/api/scs/create_folder",
        * operationId="createFolder",
        * tags={"Create folder API"},
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
        *               required={"school_id","folder_file_name","file_parent_folder","file_hierarchy"},
        *               @OA\Property(property="school_id", type="text"), 
        *               @OA\Property(property="folder_file_name", type="text"),   
        *               @OA\Property(property="file_parent_folder", type="text"),   
        *               @OA\Property(property="file_hierarchy", type="text"),   
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Folder is successfully created",
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

    public function create_folder(Request $request)
    {
        //
        $data= array(
            'school_id' => $request->school_id,
            'folder_file_type' => 1,
            'folder_file_id' => Helper::generate_file_id(),
            'file_url' => '',
            'file_format' => '',
            'file_size' => '',
            'folder_file_name' => $request->folder_file_name,
            'file_parent_folder' => $request->file_parent_folder,
            'file_hierarchy' => $request->file_hierarchy,
            'file_type'=> '',
            'created_at' => Helper::now(),
            'updated_at' => Helper::now()
         );

        $value=scs::insertData($data);
        $value=$value?true:false;
        return $value==true?response()->json(['message'=>'Inserted successfully'],201):response()->json(['message'=>'Failed to be inserted'],422);

    }

         /**
        * @OA\Post(
        * path="/api/scs/get_files_folders/{school_id}/{file_hierarchy}/upload",
        * operationId="uploadAWSFolder",
        * tags={"Upload to AWS API"},
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
        *               required={"school_id","folder_file_name","file_parent_folder","file_hierarchy","file"},
        *               @OA\Property(property="school_id", type="text"), 
        *               @OA\Property(property="folder_file_name", type="text"),   
        *               @OA\Property(property="file_parent_folder", type="text"),   
        *               @OA\Property(property="file_hierarchy", type="text"), 
        *               @OA\Property(property="file", type="file", format="file"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Folder is successfully created",
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

    public function upload_to_AWS(Request $request)
    {
        //
        if(!empty($request->file('file')))
        {
          $folder="schoolCloudStorage";  
          $file = $request->file('file');
          $mime_type=File::mimeType($file);
          $file_url=Helper::upload_file_to_AWS($folder,$file);
        }

        $data= array(
            'school_id' => $request->school_id,
            'folder_file_type' => 2,
            'folder_file_id' => Helper::generate_file_id(),
            'folder_file_name' => $request->folder_file_name,
            'file_url' => $file_url,
            'file_format' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'file_parent_folder' => $request->file_parent_folder,
            'file_hierarchy' => $request->file_hierarchy,
            'file_type'=> $mime_type,
            'created_at' => Helper::now(),
            'updated_at' => Helper::now()
         );

        $value=scs::insertData($data);
        $value=$value?true:false;
        return $value==true?response()->json(['message'=>'Inserted successfully'],201):response()->json(['message'=>'Failed to be inserted'],422);

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
             /**
        * @OA\Post(
        * path="/api/scs/download_file/{school_id}",
        * operationId="downloadFile",
        * tags={"Download file API"},
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
        *         name="file_url",
        *         in="query",
        *         description="File URL",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="File is successfully downloaded",
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
    public function download(Request $request)
    {
        //
        if(!empty($request->file_url))
        { 
                 $name = explode('/',$request->file_url);
                 $tempImage = tempnam(sys_get_temp_dir(), $name[4]);
                 copy($request->file_url, $tempImage);
                 return response()->download($tempImage, $name[4]); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/scs/get_files_byId/{school_id}/{folder_file_id}/delete",
        * operationId="deleteFile",
        * tags={"Delete file API"},
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
        *         name="folder_file_id",
        *         in="path",
        *         description="File or folder ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="File is successfully deleted",
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
        if(!empty($request->file_url))
        {
                 $delete_file=Helper::delete_file_from_AWS($request->file_url);
   
        }

        $data= array(
            'school_id' => $request->school_id,
            'folder_file_id' => $request->folder_file_id
         );
        $value=scs::deleteData($data);
        $value=$value?true:false;
        return $value==true?response()->json(['message'=>'Deleted successfully'],201):response()->json(['message'=>'Failed to be deleted'],422);
    }
}
