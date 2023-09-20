<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Models\Contacts;
use App\Mail\Sendmail;
use DB;


class ContactusController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['contacts']]);
    }

        /**
        * @OA\Post(
        * path="/api/contacts",
        * operationId="contactUS",
        * tags={"Contact Us API"},
        * summary="Contact Us API",
        * description="Contact Us API",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"name", "email","subject","message"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="subject", type="text"),
        *               @OA\Property(property="message", type="text"),
        *            ),
        *        ),
        *    ),
        
        *      @OA\Response(
        *          response=201,
        *          description="Contact Us message is successfully sent",
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

    public function contacts(Request $request)
    {
    	$validate = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'subject'  => 'required',
            'message'  => 'required'
        ]);
        if($validate->fails())
        {
        	return response()->json($validate->errors(),422);
        } 

        $contact_us = new Contacts;
        $contact_us->name = $request->name;
        $contact_us->email = $request->email;
        $contact_us->subject = $request->subject;
        $contact_us->message = $request->message;
        $contact_us->save(); 

        $subject="Thank you for contacting us!";
        $details = [
        'subject' => $subject,
        'body' => "
        <h2>Thank you for contacting us!</h2>

        <p>Hello ". $request->name .", Thank you for contacting Schoolmodify team we will try to respond you as soon as possible </p><br>",
        'from'=>'Schoolmodify.com',
        'receiver'=>$request->email
       ];

   
        Mail::to($request->email)->send(new \App\Mail\Sendmail($details,$subject));

        return response()->json(['status' => 'success','data'=> $contact_us],201);


    }

        /**
        * @OA\Get(
        * path="/api/contacts/messages",
        * operationId="getContactMessages",
        * tags={"Get contact us messages"},
        * summary="Get contact us messages",
        * description="Get contact us messages",
        *      @OA\Response(
        *          response=200,
        *          description="Successfully got contact us messages",
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
    public function get_messages(Request $request)
    {
        $count_messages=Contacts::select('*')->get()->count();
        $limit=$request->limit;
        $page=$request->page-1;
        $offset=ceil($limit*$page);

        $messages=Contacts::select('*')
        ->offset($offset)
        ->limit($limit)
        ->orderBy('id','DESC')
        ->get();


        return response()->json(['messages'=>$messages,'offset'=>$offset,'no_of_records'=>$count_messages,'message'=>"Retrieved successfully"]);


    }
}
