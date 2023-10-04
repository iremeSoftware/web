<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\privacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class privacyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
          /**
        * @OA\Get(
        * path="/api/privacy",
        * operationId="getCMS",
        * tags={"Get all CMS API"},
        *      @OA\Response(
        *          response=200,
        *          description="CMS contents are successfully retrieved",
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
    public function index()
    {
        //
        $privacy=privacy::latest()->get();
        return response()->json(['message'=>$privacy]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/privacy",
        * operationId="createCMS",
        * tags={"Create new CMS API"},
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
        *               required={"page_type","contents","lang"},
        *               @OA\Property(property="page_type", type="text"),
        *               @OA\Property(property="contents", type="text"),
        *               @OA\Property(property="lang", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="CMS contents are successfully retrieved",
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
           'page_type' => 'required',
            'contents' => 'required',
            'lang'     =>  'required'
        ]);        
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }  

        $privacy= new privacy();
        $privacy->page_type=$request->page_type;
        $privacy->contents=$request->contents;
        $privacy->lang=$request->lang;
        $privacy->save();

        return response()->json(["message"=>'Created successfully'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Get(
        * path="/api/privacy/{id}",
        * operationId="getOneCMS",
        * tags={"Create new CMS API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="id",
        *         in="path",
        *         description="Content ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="CMS content are successfully retrieved",
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
    public function show(privacy $privacy,Request $request)
    {
        //
          $privacy=privacy::findOrFail($request->id);
          return response()->json(["message"=>'Retrieved successfully','privacy'=>$privacy],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/privacy/{id}",
        * operationId="updateCMS",
        * tags={"Update CMS API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="id",
        *         in="path",
        *         description="Content ID",
        *      ),
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"page_type","contents","lang"},
        *               @OA\Property(property="page_type", type="text"),
        *               @OA\Property(property="contents", type="text"),
        *               @OA\Property(property="lang", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="CMS contents is successfully updated",
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
    public function update(Request $request, privacy $privacy)
    {
        //

        $validate = Validator::make($request->all(), [
           'page_type' => 'required',
            'contents' => 'required',
            'lang'     =>  'required'
        ]);        
         if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        } 

        $privacy=privacy::findOrFail($request->id);
        $privacy->page_type=$request->page_type;
        $privacy->contents=$request->contents;
        $privacy->lang=$request->lang;
        $privacy->save();
        return response()->json(["message"=>'Updated successfully','privacy'=>$privacy],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(privacy $privacy)
    {
        //
    }
}
