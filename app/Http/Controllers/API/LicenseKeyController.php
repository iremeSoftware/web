<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\license_keys;
use App\Models\license_requests;
use App\Models\sms_requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use DB;
use PDF;



class LicenseKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
        * @OA\Get(
        * path="/api/license/{school_id}",
        * operationId="checkSchoolLicense",
        * tags={"Check license key API"},
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
        *          description="School license key is successfully retrieved",
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
           
       $elapsed_time=license_keys::getLicense($request->school_id);
       $remain_sec=$elapsed_time['remain_sec'];

        return response()->json($elapsed_time,200);

    }
    /**
     * Display license requests.
     *
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Get(
        * path="/api/license/request/{school_id}",
        * operationId="getSchoolLicenseRequest",
        * tags={"Get school license request API"},
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
        *          description="License requests are successfully retrieved",
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

        public function get_license_requests(Request $request)
    {
        //
        
        if($request->school_id!=='null')
        {
        $license_requests=license_requests::select('*')
        ->where([
            ['school_id','=',$request->school_id]
        ])
        ->get();
        }
        else if($request->school_id=='null')
        {   
            $limit=$request->limit;
            $page=$request->page-1;
            $offset=ceil($limit*$page);
            $license_requests=license_requests::select('license_requests.request_id','license_requests.days','license_requests.price','license_requests.done_by','license_requests.phone_number','license_requests.activated','license_requests.created_at','schools.school_name','users.name')
            ->where('activated',$request->activated)
            ->join('schools','schools.school_id','=','license_requests.school_id')
            ->join('users','users.account_id','=','license_requests.done_by')
            ->offset($offset)
            ->limit($limit)
            ->get();


            $count=license_requests::select('*')
            ->where('activated',$request->activated)->count();
        }

        return response()->json(['license_requests'=>$license_requests,'offset'=>$offset,'count'=>$count,'message'=>'Retrieved successfully'],200);

    }
    /**
     * Activate license key license key.
     *
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/license/activate/license",
        * operationId="activateLicenseRequest",
        * tags={"Activate license request API"},
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
        *               required={"request_id", "license_key"},
        *               @OA\Property(property="request_id", type="text"),
        *               @OA\Property(property="license_key", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="License request is successfully activated",
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

        public function activate_license_key(Request $request)
    {
      
            $now=date("Y-m-d H:i:s");
            $get_license_requests=license_requests::select('license_requests.request_id','license_requests.days','license_requests.price','license_requests.done_by','license_requests.phone_number','license_requests.activated','license_requests.created_at','schools.school_name','schools.school_email','schools.school_id','users.name')
            ->where([
                ['request_id',$request->request_id]
            ])
            ->join('schools','schools.school_id','=','license_requests.school_id')
            ->join('users','users.account_id','=','license_requests.done_by')
            ->first();


            $get_license_key=license_keys::select('*')
            ->where([
                ['school_id',$get_license_requests->school_id]
            ])
            ->first();

            $check_license_exist=license_requests::select('*')
            ->where([
                ['license_key',$get_license_key->license_key],
                ['school_id',$get_license_key->school_id],
                ['activated',0]

            ])
            ->get()
            ->count();

            if($check_license_exist>0)
            {
                return response()->json(['message'=>'This license is already used'],401);
            }
            else
            {

            $update_license_requests=DB::table('license_requests')
            ->where([
                ['license_requests.request_id',$request->request_id]
            ])
            ->update([
                'activated'=>1,
                'license_key'=>$request->license_key
            ]);

            $number_of_days=$get_license_requests->days;

            $endDate = strtotime($get_license_key->end_date); // or your date as well
            $startDate = strtotime($get_license_key->activated_from);
            $datediff = $endDate - $startDate;

            $remain_days = round($datediff / (60 * 60 * 24));
            $number_of_days = $number_of_days + $remain_days;

            $end_date=date('Y-m-d H:i:s', strtotime($now. "+$number_of_days day"));
             

         
            $update_license_key=DB::table('license_keys')
            ->where('license_keys.school_id',$get_license_requests->school_id)
            ->update([
                'license_key'=>$request->license_key,
                'activated_from'=>$now,
                'end_date'=>$end_date,
                'days'=>$get_license_requests->days,
                'updated_at'=>$now
            ]);


            $subject="License key activated";
        $details = [
            'subject' => $subject,
        'body' => "
        <h2>School license key activated successfully</h2>

        <p>Hello ". $get_license_requests->name .", Thank you for activating license key of (".$get_license_requests->days.") days which will end at ".$end_date."</p>

       Note: If you have any problem while activating the license, please contact us through our email or contact us with our phone number",
        'receiver'=>$get_license_requests->school_email
       ];
   
        Mail::to($get_license_requests->school_email)->send(new \App\Mail\Sendmail($details,$subject));


        return response()->json(['message'=>'License activated successfully'],200);
    }

    }

    /**
     * Activate sms requests.
     *
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/sms/activate",
        * operationId="activateSMSRequest",
        * tags={"Activate SMS request API"},
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
        *               required={"request_id"},
        *               @OA\Property(property="request_id", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="SMS request is successfully activated",
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

        public function activate_sms(Request $request)
    {
      
            $now=date("Y-m-d H:i:s");
            $get_sms_requests=sms_requests::select('sms_requests.request_id','sms_requests.classes','sms_requests.number_of_sms','sms_requests.price','sms_requests.account_id','sms_requests.phone_number','schools.school_name','schools.school_email','schools.school_id','users.name','users.email')
            ->where('request_id',$request->request_id)
            ->join('schools','schools.school_id','=','sms_requests.school_id')
            ->join('users','users.account_id','=','sms_requests.account_id')
            ->first();
            
            $check_sms_request_exist=sms_requests::select('*')
            ->where([
                ['school_id',$get_sms_requests->school_id],
                ['activated',1]

            ])
            ->get()
            ->count();
            $update_sms_requests=sms_requests::where([
                ['sms_requests.request_id',$request->request_id]
            ])->first();
            $update_sms_requests->activated = 1;
            $update_sms_requests->save();

            
                 $update_sms=DB::update("UPDATE schools SET `sms_amount`=`sms_amount` + $get_sms_requests->price,`updated_at`='$now'  WHERE school_id='$get_sms_requests->school_id'");
                    
                 if($update_sms)
                 {
                    $data["subject"] = "IremeApp - SMS invoice";
                    $data['school_name'] = $get_sms_requests->school_name;
                    $data["email"] = $get_sms_requests->email;
                    $data["user_names"] = $get_sms_requests->name;
                    $data["amount_paid"] = number_format($get_sms_requests->price) . ' RWF';
                    $data["transaction_fees"] = "0 Rwf";
                    $data["payment_method"] = "MTN MOBILE MONEY";
                    $data['transaction_id'] = $request->request_id;
                    $data['date'] = $update_sms_requests->updated_at;
            
                    $pdf = PDF::loadView('mails.sms_invoice', $data);
            
                    Mail::send('mails.sms_invoice', $data, function($message)use($data, $pdf) {
                        $message->to($data["email"], $data["email"])
                                ->subject($data["subject"])
                                ->attachData($pdf->output(), "invoice_".$data["transaction_id"].".pdf");
                    });
                 }
                    
        return response()->json(['message'=>'SMS request activated successfully'],200);
    }

    /**
     * Display sms requests.
     *
     * @return \Illuminate\Http\Response
     */

         /**
        * @OA\Get(
        * path="/api/sms/request/{school_id}",
        * operationId="getSMSRequests",
        * tags={"Get SMS request API"},
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
        *          description="SMS request is successfully retrieved",
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


        public function get_sms_requests(Request $request)
    {
        //
        if($request->school_id!=='null')
        {
        $sms_requests=sms_requests::select('*')
        ->where([
            ['school_id','=',$request->school_id]
        ])
        ->get();
        }
        else if($request->school_id=='null')
        {
            
            $limit=$request->limit;
            $page=$request->page-1;
            $offset=ceil($limit*$page);
            $sms_requests=sms_requests::select('sms_requests.request_id','sms_requests.number_of_sms','sms_requests.price','sms_requests.account_id','sms_requests.phone_number','sms_requests.activated','sms_requests.created_at','schools.school_name','users.name')
            ->where('activated','=',$request->activated)
            ->join('schools','schools.school_id','=','sms_requests.school_id')
            ->join('users','users.account_id','=','sms_requests.account_id')
            ->offset($offset)
            ->limit($limit)
            ->get();

            $count_sms_requests=sms_requests::select('sms_requests.request_id','sms_requests.number_of_sms','sms_requests.account_id','sms_requests.phone_number','sms_requests.activated','sms_requests.created_at','schools.school_name','users.name')
            ->where([
                ['activated','=',$request->activated]
            ])
            ->count();

            $count=$count_sms_requests;

        return response()->json(['sms_requests'=>$sms_requests,'count'=>$count,'offset'=>$offset,'message'=>'Retrieved successfully'],200);
    }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      /**
        * @OA\Post(
        * path="/api/license",
        * operationId="createLicenseKey",
        * tags={"Create license key API"},
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
        *               required={"school_id","license_key","days","price"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="license_key", type="text"),
        *               @OA\Property(property="days", type="number"),
        *              @OA\Property(property="price", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="License key is successfully created",
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
        $check_school=LicenseKey::select('*')
        ->where([
            ['school_id','=',$request->school_id]
        ])
        ->first();
        $now=date('Y-m-d H:i:s');
        if($check_school->count()==0)
        {
            
            $LicenseKey=new LicenseKey();
            $LicenseKey->school_id=$request->school_id;
            $LicenseKey->license_key=$request->license_key;
            $LicenseKey->activated_from=$now;
            $LicenseKey->days=$check_school->days+$request->days;
            $LicenseKey->price=$request->price;
            $LicenseKey->free_trial=1;
            $LicenseKey->save();
        }
        else
        {
            $LicenseKey=DB::table('license_key')
            ->where([
                ['school_id','=',$request->school_id]
            ])
            ->update([
                'license_key'=>$request->license_key,
                'activated_from'=>$now,
                'days'=>$check_school->days+$request->days,
                'price'=>$request->price,
                'free_trial'=>0

            ]);
        }

        return response()->json(['message'=>'Updated successfully'],200);
        

    }


    /**
     * Store license requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
          /**
        * @OA\Post(
        * path="/api/license/request",
        * operationId="createLicenseRequest",
        * tags={"Create license request API"},
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
        *               required={"school_id","months","price","account_id","school_phone_number"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="months", type="number"),
        *               @OA\Property(property="price", type="number"),
        *               @OA\Property(property="account_id", type="text"),
        *               @OA\Property(property="school_phone_number", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="License request is successfully created",
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
    public function store_license_requests(Request $request)
    {
        //
            $request_id=substr(str_shuffle('0123456789'), 0,8);
            $license_requests=new license_requests();
            $license_requests->school_id=$request->school_id;
            $license_requests->request_id=$request_id;
            $license_requests->days=$request->months*30;
            $license_requests->price=$request->price;
            $license_requests->done_by=$request->account_id;
            $license_requests->phone_number=$request->school_phone_number;
            $license_requests->activated=0;
            $license_requests->save();
       
        return response()->json(['message'=>'Requested successfully'],200);
        

    }

     /**
     * Store sms requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/sms/request",
        * operationId="createSMSLicenseRequest",
        * tags={"Create license request API"},
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
        *               required={"school_id","price","account_id"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="price", type="number"),
        *               @OA\Property(property="account_id", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="SMS request is successfully created",
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
    public function store_sms_requests(Request $request)
    {
        //
            $request_id=substr(str_shuffle('0123456789'), 0,8);
            $sms_requests=new sms_requests();
            $sms_requests->school_id=$request->school_id;
            $sms_requests->request_id=$request_id;
            $sms_requests->number_of_sms='';
            $sms_requests->phone_number='';
            $sms_requests->account_id=$request->account_id;
            $sms_requests->classes='';
            $sms_requests->activated=0;
            $sms_requests->price=$request->price;
            $sms_requests->save();
       
        return response()->json(['message'=>'Requested successfully'],200);
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LicenseKey  $licenseKey
     * @return \Illuminate\Http\Response
     */
    public function show(LicenseKey $licenseKey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LicenseKey  $licenseKey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LicenseKey $licenseKey)
    {
        //
    }

    /**
     * Delete license request.
     *
     * @param  \App\LicenseKey  $licenseKey
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Get(
        * path="/api/license/key/delete/{request_id}",
        * operationId="deleteLicenseRequest",
        * tags={"Delete license request API"},
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
        *          description="License key is successfully deleted",
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
    public function delete_license_key(Request $request)
    {
        //
        $delete_license_request=DB::table('license_requests')
        ->where('request_id',$request->request_id)
        ->delete();

        return response()->json(['message'=>'Deleted successfully'],200);

    }

    /**
     * Delete sms request.
     *
     * @param  \App\LicenseKey  $licenseKey
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Get(
        * path="/api/sms/request/delete/{request_id}",
        * operationId="deleteSMSRequest",
        * tags={"Delete SMS request API"},
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
        *          description="SMS request is successfully deleted",
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
    
    public function delete_sms(Request $request)
    {
        //
        $delete_sms_request=DB::table('sms_requests')
        ->where('request_id',$request->request_id)
        ->delete();

        return response()->json(['message'=>'Deleted successfully'],200);

    }
}
