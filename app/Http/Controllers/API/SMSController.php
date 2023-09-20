<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\MarksController;
use App\Http\Controllers\API\AcademicYearController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DB;


use App\Models\Students;
use App\Models\Marks;
use App\Models\Schoolfees;
use App\Models\classrooms;
use App\Models\license_keys;
use App\Models\Schools;

use URL;

class SMSController extends Controller
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
    public function index()
    {
        //
    }
    /**
     * Send SMS TO THE ONE STUDENT .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/sms/send/single/{school_id}/{classroom}",
        * operationId="sendSMS",
        * tags={"Send SMS API"},
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
        *         name="classroom",
        *         in="path",
        *         description="Class ID",
        *      ),
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"student_id","sms_type","sms_header","selected_term"},
        *               @OA\Property(property="student_id", type="text"),
        *               @OA\Property(property="sms_header", type="text"),
        *               @OA\Property(property="sms_type", type="text"),
        *               @OA\Property(property="selected_term", type="number"),
        *               @OA\Property(property="message", type="text"),

        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Message is successfully sent",
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
    public function send_single_sms(Request $request)
    {
        
        //
         //########################Check whether license of the school expired or not
         $elapsed_time=license_keys::getLicense($request->school_id); 
         $remain_sec=$elapsed_time['remain_sec'];
        //########################//Check whether license of the school expired or not
         if($remain_sec<0)
         {
           return response()->json(['message' => 'message.license_expired'], 401); 
         }
         else
         {
        
        $AcademicYear=new AcademicYearController();
        $term=json_encode($AcademicYear->index());
        $term=(array) json_decode($term);
        $current_term=$request->selected_term;

        $school= Schools::select('*')  
         ->where([
        ['school_id', '=', $request->school_id]
        ])->first();

         

        $sms_header=$request->sms_header;
        $count_sent_message=0;
        $count_failed_message=0;
        $student_id=explode(' ',$request->student_id);
        $sms_remain_amount=0;
        $sms_total_cost=0;

################################SEND MESSAGE#############################################       
        if($request->sms_type=='message')
        {
            $message=$this->remove_accents($request->message);
            $message_len=strlen($message);
            $tot_amount=$this->sms_cost($message)*count($student_id);

            if($tot_amount>$school->sms_amount)
            {
                return response()->json(['amount'=>$tot_amount,'message' => 'send_sms.insufficient_amount'], 401);
            }

            
            

         foreach ($student_id as $key => $student_id) {
        $students = Students::select('*')
         ->where([
        ['student_id', '=', $student_id]
        ])->first();

    #########################################GET PHONENUMBER##################################
       if($students->priority_phone=='mp')
       {
        if(strlen($students->mothers_phone)==9)
        {
            $phone_number="+250".$students->mothers_phone;
        }
        else if(strlen($students->mothers_phone)==10)
        {
            $phone_number="+25".$students->mothers_phone;
        }
        else
        {
           $phone_number=$students->mothers_phone; 
        }

       }
       else if($students->priority_phone=='fp')
       {
        if(strlen($students->fathers_phone)==9)
        {
            $phone_number="+250".$students->fathers_phone;
        }
        else if(strlen($students->fathers_phone)==10)
        {
            $phone_number="+25".$students->fathers_phone;
        }
        else
        {
           $phone_number=$students->fathers_phone; 
        }

       }
       
      #########################################//GET PHONENUMBER#################################
#######################################Bulkgate SMS gateway#############################
                     

                      $data=array(
                        'application_id' => env('BULKGATE_APPID'),
                        'application_token' => env('BULKGATE_APP_TOKEN'),
                        'number' => $phone_number,
                        'text' => $message,
                        'unicode' => ' true',
                        'sender_id' => 'gText',
                        'sender_id_value' => $sms_header
                      );

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://portal.bulkgate.com/api/1.0/simple/promotional',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                   'Cookie: _nss=1'
                    ),
                  ));

                 $response = curl_exec($curl);

                 $httpcode=curl_getinfo($curl,CURLINFO_HTTP_CODE);

                 curl_close($curl);
                  if($httpcode==200)
                     {
                         $count_sent_message++;
                         $message_len=strlen($message);
                         if(intval($message_len)<=160)
                         {
                           $sms_remain_amount=env('SMS_PRICE1'); 
                         }
                         else if(intval($message_len)>161 && intval($message_len)<=306)
                         {
                           $sms_remain_amount=env('SMS_PRICE2'); 
                         }
                         else
                         {
                            $sms_remain_amount=env('SMS_PRICE3');
                         }

                         $sms_total_cost=$sms_total_cost+$sms_remain_amount;
                         
                         $sms_remain_amount=$school->sms_amount-$sms_remain_amount;
                     }

                                   
    
######################################//Bulkgate SMS gateway#############################
        }

        }
################################//SEND MESSAGE#####################################      
################################SCHOOL FEES REMINDER#####################################
        else if($request->sms_type=='schoolfees_reminder')
        {

            

         foreach ($student_id as $key => $student_id) {
            $Schoolfees = Schoolfees::select('*')
        ->selectRaw('`to_be_paid1`-`amount_term1` as remain1')
         ->selectRaw('`to_be_paid2`-`amount_term2` as remain2')
         ->selectRaw('`to_be_paid3`-`amount_term3` as remain3')
         //###########################FOR ANNUAL REPORT##################################
         ->selectRaw('(`to_be_paid1`+`to_be_paid2`+`to_be_paid3`)  as to_be_paid4')
         ->selectRaw('(`amount_term1`+`amount_term2`+`amount_term3`)  as amount_term4')
         ->selectRaw('(`to_be_paid1`-`amount_term1`) + (`to_be_paid2`-`amount_term2`) + (`to_be_paid3`-`amount_term3`)  as remain4')
        //###########################FOR ANNUAL REPORT##################################
        ->join('students','students.student_id','=','schoolfees.student_id')
        ->join('classrooms','classrooms.class_id','=','schoolfees.class_id')
        ->join('schools','schools.school_id','=','schoolfees.school_id')
        ->where([
        ['schoolfees.student_id', '=', $student_id]
        ])->first();
        $school_name=$Schoolfees->school_name;
        $student_name=$Schoolfees->name;
        $class_name=$Schoolfees->classroom_name;

        if($current_term==1)
        {
         $to_be_paid=$Schoolfees->to_be_paid1;
         $amount_paid=$Schoolfees->amount_term1;
         $remain=$to_be_paid-$amount_paid;
         $message="SCHOOL FEES:Term 1;CLASS:$class_name;STUDENT:$student_name;TO BE PAID: ".number_format($to_be_paid)." Rwf;PAID:".number_format($amount_paid)." Rwf;REMAIN:".number_format($remain)." Rwf;";
        }
        else if($current_term==2)
        {
         $to_be_paid=$Schoolfees->to_be_paid2;
         $amount_paid=$Schoolfees->amount_term2;
         $remain=$to_be_paid-$amount_paid;
         $message="SCHOOL FEES:Term 2;CLASS:$class_name;STUDENT:$student_name;TO BE PAID: ".number_format($to_be_paid)." Rwf;PAID:".number_format($amount_paid)." Rwf;REMAIN:".number_format($remain)." Rwf;";
        }
        else if($current_term==3)
        {
         $to_be_paid=$Schoolfees->to_be_paid3;
         $amount_paid=$Schoolfees->amount_term3;
         $remain=$to_be_paid-$amount_paid;
         $annual_to_be_paid=$Schoolfees->to_be_paid4;
         $annual_paid=$Schoolfees->amount_term4;
         $annual_remain=$Schoolfees->remain4;
         
         $message="SCHOOL FEES:Term 3;CLASS:$class_name;STUDENT:$student_name;TO BE PAID: ".number_format($to_be_paid)." Rwf;PAID:".number_format($amount_paid)." Rwf;REMAIN:".number_format($remain)." Rwf;";
        }
// CHECKS IF SCHOOL HAVE ENOUGH AMOUNT TO SEND SMS 
            $message_len=strlen($message);
            $tot_amount=$this->sms_cost($message);

            if($tot_amount>$school->sms_amount)
            {
                return response()->json(['amount'=>$tot_amount,'message' => 'send_sms.insufficient_amount'], 401);
            }
// CHECKS IF SCHOOL HAVE ENOUGH AMOUNT TO SEND SMS 



#########################################GET PHONENUMBER##################################
       if($Schoolfees->priority_phone=='mp')
       {
        if(strlen($Schoolfees->mothers_phone)==9)
        {
            $phone_number="+250".$Schoolfees->mothers_phone;
        }
        else if(strlen($Schoolfees->mothers_phone)==10)
        {
            $phone_number="+25".$Schoolfees->mothers_phone;
        }
        else
        {
           $phone_number=$Schoolfees->mothers_phone; 
        }

       }
       else if($Schoolfees->priority_phone=='fp')
       {
        if(strlen($Schoolfees->fathers_phone)==9)
        {
            $phone_number="+250".$Schoolfees->fathers_phone;
        }
        else if(strlen($Schoolfees->fathers_phone)==10)
        {
            $phone_number="+25".$Schoolfees->fathers_phone;
        }
        else
        {
           $phone_number=$Schoolfees->fathers_phone; 
        }

       }
####################################//GET PHONENUMBER#################################
#######################################Bulkgate SMS gateway#############################
            
            
         

        // $data=array(
        //                           "sender"=>$sms_header,
        //                           "recipients"=>$phone_number,
        //                           "message"=>$message,
        //                         );

        //              $url="https://www.intouchsms.co.rw/api/sendsms/.json";
        //              $data=http_build_query($data);
        //              $username="nyakurilevite";
        //              $password="Levite191098";

        //              $ch=curl_init();
        //              curl_setopt($ch,CURLOPT_URL,$url);
        //              curl_setopt($ch,CURLOPT_USERPWD,$username.":".$password);
        //              curl_setopt($ch,CURLOPT_POST,true);
        //              curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //              curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        //              curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        //              $result=curl_exec($ch);
        //              $httpcode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        //              curl_close($ch);

        //              if($httpcode==200)
        //              {
        //                  $count_sent_message++;
        //                  $message_len=strlen($message);
        //                 if(intval($message_len)<=160)
        //                  {
        //                    $sms_remain_amount=14; 
        //                  }
        //                  else if(intval($message_len)>161 && intval($message_len)<=306)
        //                  {
        //                    $sms_remain_amount=24; 
        //                  }
        //                  else
        //                  {
        //                     $sms_remain_amount=34;
        //                  }

        //                  $sms_total_cost=$sms_total_cost+$sms_remain_amount;
        //                  $sms_remain_amount=$school->sms_amount-$sms_remain_amount;
        //              } 

        $data=array(
          'application_id' => env('BULKGATE_APPID'),
          'application_token' => env('BULKGATE_APP_TOKEN'),
          'number' => $phone_number,
          'text' => $message,
          'unicode' => ' true',
          'sender_id' => 'gText',
          'sender_id_value' => $sms_header
        );
        
      $curl = curl_init();

      curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://portal.bulkgate.com/api/1.0/simple/promotional',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
     'Cookie: _nss=1'
      ),
    ));

   $response = curl_exec($curl);
   $httpcode=curl_getinfo($curl,CURLINFO_HTTP_CODE);

   curl_close($curl);
    if($httpcode==200)
       {
           $count_sent_message++;
           $message_len=strlen($message);
           if(intval($message_len)<=160)
           {
             $sms_remain_amount=env('SMS_PRICE1'); 
           }
           else if(intval($message_len)>161 && intval($message_len)<=306)
           {
             $sms_remain_amount=env('SMS_PRICE2'); 
           }
           else
           {
              $sms_remain_amount==env('SMS_PRICE3'); ;
           }

           $sms_total_cost=$sms_total_cost+$sms_remain_amount;
           
           $sms_remain_amount=$school->sms_amount-$sms_remain_amount;
       }

    

#####################################//Bulkgate SMS gateway#############################
         
        }

       }
###############################//SCHOOL FEES REMINDER##################################
###############################MID TERM REPORT FORM####################################


        else if($request->sms_type=='mid_term_report')
        {
//****Get student marks for all courses by student id FOR SPECIFIED SCHOOL***************
        if(!empty($request->school_id) && !empty($request->class_id) &&  !empty($request->student_id) )
        {
             
      

            $sort_by=empty($request->sort_by)?'course_name':$request->sort_by; 
            $sort=empty($request->sort)?'ASC':$request->sort; 

            $count=0;
         foreach ($student_id as $key => $student_id) {
            $count++;
               # code...
        $students = Students::select('*')
         ->where([
        ['student_id', '=', $student_id]
        ])->first();

         $students_count = Students::select('*')
         ->where([
        ['school_id', '=', $request->school_id],
        ['classroom', '=', $request->class_id]
        ])->count();




            $ranks_from_view= DB::table("report_form_view")
        ->select('*')
        ->selectRaw("RANK() OVER (ORDER BY `name` ASC) my_id")
        ->selectRaw("RANK() OVER (ORDER BY `term1_quiz` DESC) rank_term1")
        ->selectRaw("RANK() OVER (ORDER BY `term2_quiz` DESC) rank_term2")
        ->selectRaw("RANK() OVER (ORDER BY `term3_quiz` DESC) rank_term3")
        ->where([
        ['school_id', '=', $request->school_id],
        ['class_id', '=', $request->class_id]
        ])
         ->get();

       for($i=0;$i<=$ranks_from_view->count()-1;$i++) {
            if($ranks_from_view[$i]->student_id==$student_id)
                {
                   $my_ranks=$ranks_from_view[$i];
                }
            
        }




          $Marks = DB::table('marks')
        ->select('name','marks.term1_quiz','marks.term2_quiz','marks.term3_quiz','marks.student_id','course_name','rank1','rank2','rank3')
        ->selectRaw("`out_of_marks`.`term1_quiz` as out_of_marks_quiz_term1")

        ->selectRaw("`out_of_marks`.`term2_quiz` as out_of_marks_quiz_term2")

        ->selectRaw("`out_of_marks`.`term3_quiz` as out_of_marks_quiz_term3")
        
        ->join('students', 'students.student_id', '=', 'marks.student_id')
        ->join('courses', 'courses.course_id', '=', 'marks.course_id')
        ->join('out_of_marks', 'out_of_marks.course_id', '=', 'marks.course_id')
        ->where([
        ['marks.school_id', '=', $request->school_id],
        ['marks.student_id', '=', $student_id],
        ['out_of_marks.class_id', '=', $request->class_id]
        ])
         ->orderBy($sort_by,$sort)
         ->get();
#####################GENERATING MID TERM SMS#############################################
         if($current_term==1)
         //------------------FIRST TERM---------------------------------
         {
         $message="MID TERM REPORT FORM;STUDENT NAME:".$students->name.';TERM:1;';
         $total_out_of_marks=0;
         $student_total_marks=0;
         for($i=0;$i<=$Marks->count()-1;$i++)
         {
            $message=$message.$Marks[$i]->course_name.':'.$Marks[$i]->term1_quiz.'/'.$Marks[$i]->out_of_marks_quiz_term1.';';
            $total_out_of_marks=$total_out_of_marks+$Marks[$i]->out_of_marks_quiz_term1;
            $student_total_marks=$student_total_marks+$Marks[$i]->term1_quiz;
         }
         $message=$message."TOTAL:".round($student_total_marks,1).'/'.round($total_out_of_marks,1);
         $message=$message."PERCENTAGE:".round($student_total_marks/$total_out_of_marks*100,1)."%;";
         $message=$message."POSITION:".$my_ranks->rank_term1.'/'.$students_count;
         $message;
       }
       else if($current_term==2)
       //------------------SECOND TERM---------------------------------
         {
         $message="MID TERM REPORT FORM;STUDENT NAME:".$students->name.';TERM:2;';
         $total_out_of_marks=0;
         $student_total_marks=0;
         for($i=0;$i<=$Marks->count()-1;$i++)
         {
            $message=$message.$Marks[$i]->course_name.':'.$Marks[$i]->term2_quiz.'/'.$Marks[$i]->out_of_marks_quiz_term2.';';
            $total_out_of_marks=$total_out_of_marks+$Marks[$i]->out_of_marks_quiz_term2;
            $student_total_marks=$student_total_marks+$Marks[$i]->term2_quiz;
         }
         $message=$message."TOTAL:".round($student_total_marks,1).'/'.round($total_out_of_marks,1);

          $message=$message.";PERCENTAGE:".round($student_total_marks/$total_out_of_marks*100,1)."%;";
          $message=$message."POSITION:".$my_ranks->rank_term2.'/'.$students_count;
       }
        else if($current_term==3)
        //------------------THIRD TERM---------------------------------
         {
         $message="MID TERM REPORT FORM;STUDENT NAME:".$students->name.';TERM:3;';
         $total_out_of_marks=0;
         $student_total_marks=0;
         for($i=0;$i<=$Marks->count()-1;$i++)
         {
            $message=$message.$Marks[$i]->course_name.':'.$Marks[$i]->term3_quiz.'/'.$Marks[$i]->out_of_marks_quiz_term3.';';
            $student_total_marks=$student_total_marks+$Marks[$i]->term3_quiz;
            $total_out_of_marks=$total_out_of_marks+$Marks[$i]->out_of_marks_quiz_term3;
         }
         $message=$message."TOTAL:".round($student_total_marks,1).'/'.round($total_out_of_marks,1);

          $message=$message.";PERCENTAGE:".round($student_total_marks/$total_out_of_marks*100,1)."%;";
         $message=$message."POSITION:".$my_ranks->rank_term3.'/'.$students_count;
       }

       // CHECKS IF SCHOOL HAVE ENOUGH AMOUNT TO SEND SMS 
       $message_len=strlen($message);
       $tot_amount=$this->sms_cost($message);

       if($tot_amount>$school->sms_amount)
       {
           return response()->json(['amount'=>$tot_amount,'message' => 'send_sms.insufficient_amount'], 401);
       }
// CHECKS IF SCHOOL HAVE ENOUGH AMOUNT TO SEND SMS 


 ######################################GET PHONENUMBER##################################
       if($students->priority_phone=='mp')
       {
        if(strlen($students->mothers_phone)==9)
        {
            $phone_number="+250".$students->mothers_phone;
        }
        else if(strlen($students->mothers_phone)==10)
        {
            $phone_number="+25".$students->mothers_phone;
        }
        else
        {
           $phone_number=$students->mothers_phone; 
        }

       }
       else if($students->priority_phone=='fp')
       {
        if(strlen($students->fathers_phone)==9)
        {
            $phone_number="+250".$students->fathers_phone;
        }
        else if(strlen($students->fathers_phone)==10)
        {
            $phone_number="+25".$students->fathers_phone;
        }
        else
        {
           $phone_number=$students->fathers_phone; 
        }

       }
#######################################//GET PHONENUMBER#################################
########################################Bulkgate SMS gateway#############################
        $update_sms_credits = DB::table('students')
        ->where('student_id', '=', $student_id)
        ->update([
        'sms_credits'=>$students->sms_credits-1,
        ]);


        $data=array(
          'application_id' => env('BULKGATE_APPID'),
          'application_token' => env('BULKGATE_APP_TOKEN'),
          'number' => $phone_number,
          'text' => $this->remove_accents($message),
          'unicode' => ' true',
          'sender_id' => 'gText',
          'sender_id_value' => $sms_header
        );
        
      $curl = curl_init();

      curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://portal.bulkgate.com/api/1.0/simple/promotional',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
     'Cookie: _nss=1'
      ),
    ));

   $response = curl_exec($curl);
   $httpcode=curl_getinfo($curl,CURLINFO_HTTP_CODE);

   curl_close($curl);
    if($httpcode==200)
       {
           $count_sent_message++;
           $message_len=strlen($message);
           if(intval($message_len)<=160)
           {
             $sms_remain_amount=env('SMS_PRICE1'); 
           }
           else if(intval($message_len)>161 && intval($message_len)<=306)
           {
             $sms_remain_amount=env('SMS_PRICE2'); 
           }
           else
           {
              $sms_remain_amount==env('SMS_PRICE3'); ;
           }

           $sms_total_cost=$sms_total_cost+$sms_remain_amount;
           
           $sms_remain_amount=$school->sms_amount-$sms_remain_amount;
       }
                                
    


#####################################//Bulkgate SMS gateway#############################
##################//GENERATING MID TERM SMS#############################################

        
     }
 }
 }
       $update_sms_credits = DB::table('schools')
        ->where('school_id', '=', $request->school_id)
        ->update([
        'sms_amount'=>$school->sms_amount - $sms_total_cost,
        ]);

        return response()->json([ 'SMS_SENT' => $count_sent_message,'response'=>$response,'COST'=>$sms_total_cost,'message' => 'Sent successfully'], 200);
    }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sms_cost($sms)
    {
        $message_len=strlen($sms);
                        if(intval($message_len)<=160)
                         {
                           $sms_remain_amount=env('SMS_PRICE1'); 
                         }
                         else if(intval($message_len)>161 && intval($message_len)<=306)
                         {
                           $sms_remain_amount=env('SMS_PRICE2'); 
                         }
                         else
                         {
                            $sms_remain_amount=env('SMS_PRICE3');
                         }
                         return $sms_remain_amount;
    }
    /**
     * Function for removing french accents
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function remove_accents($string) {
      return strtr(utf8_decode($string), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Students $students)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function destroy(Students $students)
    {
        //
    }
}
