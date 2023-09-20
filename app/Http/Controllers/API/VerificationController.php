<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Models\VerificationCodes;
use App\Models\User;

use Illuminate\Http\Request;
use DB;

class VerificationController extends Controller
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
        * path="/api/verification/{account_id}/{verification_code}",
        * operationId="checkVerificationCode",
        * tags={"Check verification code API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="account_id",
        *         in="path",
        *         description="Account ID",
        *      ),
        *      @OA\Parameter(
        *         name="verification_code",
        *         in="path",
        *         description="Verification Code",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Verification code is successfully matching",
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
        if($request->verification_code!=='')
        {
  
        $Codes=VerificationCodes::select('*')
        ->where([
            ['verification_code', '=', $request->verification_code],
            ['account_id','=',$request->account_id]
        ])
        ->first();

        if(!empty($Codes))
        {
                    return response()->json(['verified'=>1],200);

        }
        else
        {
                     return response()->json(['verified'=>0],401);

        }
    }

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
     * @param  \App\VerificationCodes  $verificationCodes
     * @return \Illuminate\Http\Response
     */
    public function show(VerificationCodes $verificationCodes)
    {
        //
    }

    /**
     * Resend verification code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VerificationCodes  $verificationCodes
     * @return \Illuminate\Http\Response
     */
            /**
        * @OA\Post(
        * path="/api/verification_code/resend/{account_id}",
        * operationId="resendVerificationCode",
        * tags={"Resend verification code API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="account_id",
        *         in="path",
        *         description="Account ID",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Another verification code is successfully sent",
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
    public function resend(Request $request)
    {
        //
       $account_id=$request->account_id;
       $user=User::select('*')
       ->where([
        ['account_id','=',$account_id]
       ])
       ->first();


        $verify_device = VerificationCodes::select('verification_code')
        ->where([
            ['account_id', '=', $account_id]
        ])
        ->count();

        if($verify_device==1)
        {
          $delete_old_verification_code = DB::table('verification_codes')
          ->where('account_id','=',$account_id)
          ->delete();

          $numeric="0123456789";
          $device_id=substr(str_shuffle($numeric),0,5);
          $VerificationCodes=new VerificationCodes;
          $VerificationCodes->account_id = $account_id;
          $VerificationCodes->verification_code = $device_id;
          $VerificationCodes->save();


          $subject="Account verification";
        $details = [
            'subject' => $subject,
        'body' => "
        <h2>Account verification</h2>

        <p>Copy the verification code below</p>

          <br>
          <h3>".$device_id."</h3>",
        'from'=>'Schoolmodify.com',
        'receiver'=>$user->email
       ];
   
        Mail::to($user->email)->send(new \App\Mail\Sendmail($details,$subject));
        }
       return response()->json(['message'=>'SUCCESS'],200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VerificationCodes  $verificationCodes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VerificationCodes $verificationCodes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VerificationCodes  $verificationCodes
     * @return \Illuminate\Http\Response
     */
    public function destroy(VerificationCodes $verificationCodes)
    {
        //
    }
}
