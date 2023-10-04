<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Models\Schoolfees;
use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\academic_year;
use App\Models\bank_slips;
use App\Models\license_keys;
use DB;
use Str;

class Schoolfees_Controller extends Controller
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
    public function index(Request $request)
    {
        ////**************Get student by id FOR SPECIFIED SCHOOL***************
        if(!empty($request->school_id) && !empty($request->class_id) && !empty($request->student_id) )
        {
            

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
        ->where([
        ['schoolfees.student_id', '=', $request->student_id]
        ])->get();

         $number_of_students=$Schoolfees->count();
         $offset=0;
        }
    //**************FETCH STUDENTS FROM CLASSROOM FOR SPECIFIED SCHOOL***************
        if(!empty($request->school_id) && !empty($request->class_id) && empty($request->student_id))
        {
          $sort_by=empty($request->sort_by)?'name':$request->sort_by; 
            $sort=empty($request->sort)?'ASC':$request->sort; 
            $limit=$request->limit;
            $page=$request->page-1;
            $offset=ceil($limit*$page);

        $all_students = Schoolfees::select('*')
         ->where([
        ['school_id', '=', $request->school_id],
        ['class_id','=',$request->class_id]
        ])->get();


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
         ->where([
        ['schoolfees.school_id', '=', $request->school_id],
        ['classroom','=',$request->class_id]
        ])
         ->offset($offset)
         ->limit($limit)
         ->orderBy($sort_by,$sort)
         ->get();


         $number_of_students=$all_students->count();
        }
    //***************************FETCH ALL STUDENTS OF SCHOOL************************
        else if(!empty($request->school_id) && empty($request->class_id) && empty($request->student_id))
        {
        
                   $sort_by=empty($request->sort_by)?'name':$request->sort_by; 
                   $sort=empty($request->sort)?'ASC':$request->sort; 
                   $limit=$request->limit;
                   $page=$request->page-1;

           $offset=ceil($limit*$page);

        $all_students = Schoolfees::select('*')
         ->where([
        ['school_id', '=', $request->school_id]
        ])->get();


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
         ->where([
        ['schoolfees.school_id', '=', $request->school_id]
        ])
         ->offset($offset)
         ->limit($limit)
         ->orderBy($sort_by,$sort)
         ->get();


         $number_of_students=$all_students->count();
       }
        

        return response()->json([ 'Schoolfees' => $Schoolfees,'no_of_students'=>$number_of_students,'offset'=>$offset,'message' => 'Retrieved successfully'], 200);

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
         $school_id=$request->school_id; 
         $class_id=$request->class_id; 
         $rows=0;
         

         $now=date('Y-m-d H:i:s');
         $today=strtotime(date('Y-m-d'));
         $academic_year=academic_year::get();
         $from=strtotime($academic_year[0]->term1_from);
         $to=strtotime($academic_year[0]->term3_to);
         if($today>=$from && $today<=$to)
         {
            $academic_year=(date('Y')).'-'.(date('Y')+1);
         }
        $students = Students::select('*')->where([
            ['school_id','=',$school_id],
            ['classroom','=',$class_id]
        ])->get();

        for($i=0;$i<=$students->count()-1;$i++)
        {

         $student_id=$students[$i]->student_id;
         $Schoolfees = Schoolfees::select('*')->where([
            ['student_id','=',$student_id]
        ])
       ->count();

          
          if($Schoolfees==0)
          {

          $rows++;
          $now=date('Y-m-d H:i:s');
           $schoolfees=DB::insert('INSERT INTO schoolfees(academic_year,school_id,class_id,student_id,to_be_paid1,amount_term1,status1,to_be_paid2,amount_term2,status2,to_be_paid3,amount_term3,status3,status4,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$academic_year,$school_id,$class_id,$student_id,0,0,0,0,0,0,0,0,0,0,$now,$now]);
       }
   }

   #################################AFTER IMPORTING LIST OF STUDENTS DISPLAY IT#####################
                   $limit=$request->limit;
                   $page=$request->page-1;
                   $offset=ceil($limit*$page);

        $all_students = Students::select('*')
         ->where([
        ['school_id', '=', $school_id],
        ['classroom','=',$class_id]
        ])->get();


         $Schoolfees = Schoolfees::select('*')
        ->join('students', 'students.student_id', '=', 'schoolfees.student_id')
        ->where([
        ['schoolfees.school_id', '=', $school_id],
        ['classroom','=',$class_id]
        ])
         ->offset($offset)
         ->limit($limit)
         ->orderBy('students.name')
         ->get();
#################################//AFTER IMPORTING LIST OF STUDENTS DISPLAY IT###################
   return response()->json(['Schoolfees'=>$Schoolfees,'message'=>'success','no_of_students'=>$all_students->count(),'offset'=>$offset,'records'=>$rows],201);
}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schoolfees  $schoolfees
     * @return \Illuminate\Http\Response
     */
    public function show(Schoolfees $schoolfees)
    {
        //
    }
    /**
     * Upload student bank slip.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schoolfees  $schoolfees
     * @return \Illuminate\Http\Response
     */
    public function upload_bank_slip(Request $request, Schoolfees $schoolfees)
    {
        $user=auth()->user();
        if(!empty($request->file('file')))
        {
          $file = $request->file('file');
          $valid_extension = array('png','jpg','jpeg');
          $new_filename=Helper::upload_file('bank_slips',$file,$valid_extension);
        }


    $bank_slips=new bank_slips;
    $bank_slips->school_id=$request->school_id;
    $bank_slips->account_id=$user->account_id;
    $bank_slips->student_id=$request->student_id;
    $bank_slips->class_id=$request->class_id;
    $bank_slips->bank_slip_photo=$new_filename;
    $bank_slips->seen=0;
    $bank_slips->save();

    return response()->json(['message'=>'uploaded successfully'],201);

    }

     /**
     * Get uploaded bank slip.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schoolfees  $schoolfees
     * @return \Illuminate\Http\Response
     */
    public function get_bank_slips(Request $request)
    {
        $user=auth()->user();
        if($request->student_id!='all_students')
        {
        $bank_slips=bank_slips::select('*')
        ->where([
            ['school_id','=',$request->school_id],
            ['class_id','=',$request->class_id],
            ['account_id','=',$user->account_id],
            ['student_id','=',$request->student_id]
        ])
        ->orderBy('id','desc')
        ->get();
        $offset=0;
        $count=1;
        }
        else if($request->student_id=='all_students')
        {
        $count=bank_slips::select('*')
        ->where([
            ['school_id','=',$request->school_id]
        ])
        ->count();

            $limit=$request->limit;
            $page=$request->page-1;
            $offset=ceil($limit*$page);
            $bank_slips=bank_slips::select('bank_slips.id','students.student_id','bank_slips.seen','bank_slips.created_at','students.name','students.classroom','classrooms.classroom_name','bank_slips.bank_slip_photo')
            ->join('students','students.student_id','=','bank_slips.student_id')
            ->join('classrooms','classrooms.class_id','=','students.classroom')
            ->where([
            ['bank_slips.school_id','=',$request->school_id]
            ])
            ->offset($offset)
            ->limit($limit)
            ->orderBy('seen','asc')
            ->get();
        }
        return response()->json(['message'=>'Retrieved successfully','bank_slips'=>$bank_slips,'offset'=>$offset,'no_of_records'=>$count],200);
    }
     /**
     * Get uploaded bank slip.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schoolfees  $schoolfees
     * @return \Illuminate\Http\Response
     */
    public function search_bank_slips(Request $request)
    {
        $user=auth()->user();
        $bank_slips=bank_slips::select('bank_slips.id','students.student_id','bank_slips.seen','bank_slips.created_at','students.name','students.classroom','classrooms.classroom_name','bank_slips.bank_slip_photo')
        ->join('students','students.student_id','=','bank_slips.student_id')
        ->join('classrooms','classrooms.class_id','=','students.classroom')
        ->where([
            ['students.school_id','=',$request->school_id],
            ['students.name','like','%'.$request->student_name.'%']
        ])
        ->get();
        $offset=0;
        $count=$bank_slips->count();
        return response()->json(['message'=>'Retrieved successfully','bank_slips'=>$bank_slips,'offset'=>$offset,'no_of_records'=>$count],200);
    }
    /**
     * Bank slip delete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schoolfees  $schoolfees
     * @return \Illuminate\Http\Response
     */
    public function delete_bank_slips(Request $request)
    {
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
        $user=auth()->user();
        $get_bank_slip=bank_slips::find($request->id);
        $get_bank_slip->delete();
        $delete_image=Helper::delete_file('bank_slips',$get_bank_slip->bank_slip_photo);

        return response()->json(['message'=>'Deleted successfully'],200);
    }
    }

    /**
     * Bankslip mark as seen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schoolfees  $schoolfees
     * @return \Illuminate\Http\Response
     */
    public function mark_as_seen(Request $request)
    {
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
        $user=auth()->user();
        
        $bank_slips=DB::table('bank_slips')
        ->where([
            ['school_id','=',$request->school_id],
            ['id','=',$request->id]
        ])
        ->update([
            'seen'=>1
        ]);
        return response()->json(['message'=>'Updated successfully'],200);
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schoolfees  $schoolfees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schoolfees $schoolfees)
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
        $school_id=$request->school_id; 
         $class_id=$request->class_id;
         $student_id=$request->student_id;
         $now=date('Y-m-d H:i:s');
         $today=strtotime(date('Y-m-d'));
         $academic_year=academic_year::first();
         
        $Schoolfees = Schoolfees::select('*')
        ->where([               ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
        ])->first();


        if($request->term==1)
        {

            if(($Schoolfees->amount_term1+$request->amount)>$request->to_be_paid)
            {
                $amount_term1=$request->to_be_paid;
                $more_amount=($Schoolfees->amount_term1+$request->amount)-$request->to_be_paid;


            }
            else
            {
                $amount_term1=$Schoolfees->amount_term1+$request->amount;
                $more_amount=0; 
            }

            


            $Schoolfees = DB::table('schoolfees')
                            ->where([
                                ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'to_be_paid1'=>$request->to_be_paid,
                              'amount_term1'=>$amount_term1,
                              'amount_term2'=>$more_amount,
                              'updated_at'=>$now
                            ]);
#######################################GET VALUE AFTER UPDATE#############################
        $Schoolfees1 = Schoolfees::select('*')
                            ->selectRaw('`to_be_paid1`-`amount_term1` as remain1')
         ->selectRaw('`to_be_paid2`-`amount_term2` as remain2')
         ->selectRaw('`to_be_paid3`-`amount_term3` as remain3')
         //###########################FOR ANNUAL REPORT##################################
         ->selectRaw('(`to_be_paid1`+`to_be_paid2`+`to_be_paid3`)  as to_be_paid4')
         ->selectRaw('(`amount_term1`+`amount_term2`+`amount_term3`)  as amount_term4')
         ->selectRaw('(`to_be_paid1`-`amount_term1`) + (`to_be_paid2`-`amount_term2`) + (`to_be_paid3`-`amount_term3`)  as remain4')
        ->where([               
            ['student_id', '=', $request->student_id],
            ['class_id', '=', $request->class_id],
            ['school_id','=',$request->school_id]
        ])->first();


            if($Schoolfees1->amount_term1==0)
            {
                $status=0;
            }
            else if($request->to_be_paid-$Schoolfees1->amount_term1>0)
            {
                 $status=1;
            }
            else if($request->to_be_paid-$Schoolfees1->amount_term1==0)
            {
                $status=2;
            }
###################################UPDATE ANNUAL PAYMENT STATUS###########################
            if($Schoolfees1->remain4>0 && $Schoolfees1->amount_term4>0)
            {
                $status4=1;
            }
            else if($Schoolfees1->remain4==0 && $Schoolfees1->amount_term4>0)
            {
               $status4=2;
            }
            else
            {
                $status4=0;
            }
###################################//UPDATE ANNUAL PAYMENT STATUS#########################



            $update_status = DB::table('schoolfees')
                            ->where([
                                ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'status1'=>$status,
                              'status4'=>$status4
                            ]);
 ######################################GET VALUE AFTER UPDATE#############################
            return response()->json(['message'=>'Updated successfully'],200);

        }
        else   if($request->term==2)
        {


             if(($Schoolfees->amount_term2+$request->amount)>$request->to_be_paid)
            {
                $amount_term2=$request->to_be_paid;
                $more_amount=($Schoolfees->amount_term2+$request->amount)-$request->to_be_paid;


            }
            else
            {
                $amount_term2=$Schoolfees->amount_term2+$request->amount;
                $more_amount=0; 
            }

            


            $Schoolfees = DB::table('schoolfees')
                            ->where([
                                ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'to_be_paid2'=>$request->to_be_paid,
                              'amount_term2'=>$amount_term2,
                              'amount_term3'=>$more_amount,
                              'updated_at'=>$now
                            ]);
#######################################GET VALUE AFTER UPDATE#############################
        $Schoolfees2 = Schoolfees::select('*')
                            ->selectRaw('`to_be_paid1`-`amount_term1` as remain1')
         ->selectRaw('`to_be_paid2`-`amount_term2` as remain2')
         ->selectRaw('`to_be_paid3`-`amount_term3` as remain3')
         //###########################FOR ANNUAL REPORT##################################
         ->selectRaw('(`to_be_paid1`+`to_be_paid2`+`to_be_paid3`)  as to_be_paid4')
         ->selectRaw('(`amount_term1`+`amount_term2`+`amount_term3`)  as amount_term4')
         ->selectRaw('(`to_be_paid1`-`amount_term1`) + (`to_be_paid2`-`amount_term2`) + (`to_be_paid3`-`amount_term3`)  as remain4')
        ->where([               
            ['student_id', '=', $request->student_id],
            ['class_id', '=', $request->class_id],
            ['school_id','=',$request->school_id]
        ])->first();


            if($Schoolfees2->amount_term2==0)
            {
                $status=0;
            }
            else if($request->to_be_paid-$Schoolfees2->amount_term2>0)
            {
                 $status=1;
            }
            else if($request->to_be_paid-$Schoolfees2->amount_term2==0)
            {
                $status=2;
            }
###################################UPDATE ANNUAL PAYMENT STATUS###########################
            if($Schoolfees2->remain4>0 && $Schoolfees2->amount_term4>0)
            {
                $status4=1;
            }
            else if($Schoolfees2->remain4==0 && $Schoolfees2->amount_term4>0)
            {
               $status4=2;
            }
            else
            {
                $status4=0;
            }
###################################//UPDATE ANNUAL PAYMENT STATUS#########################



            $update_status = DB::table('schoolfees')
                            ->where([
                                ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'status2'=>$status,
                              'status4'=>$status4
                            ]);
 ######################################GET VALUE AFTER UPDATE#############################


            return response()->json(['message'=>'Updated successfully'],200);

        }
        else   if($request->term==3)
        {



            $Schoolfees = DB::table('schoolfees')
                            ->where([
                                ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'to_be_paid3'=>$request->to_be_paid,
                              'amount_term3'=>$Schoolfees->amount_term3+$request->amount,
                              'updated_at'=>$now
                            ]);

#######################################GET VALUE AFTER UPDATE#############################
                             $Schoolfees3 = Schoolfees::select('*')
                            ->selectRaw('`to_be_paid1`-`amount_term1` as remain1')
         ->selectRaw('`to_be_paid2`-`amount_term2` as remain2')
         ->selectRaw('`to_be_paid3`-`amount_term3` as remain3')
         //###########################FOR ANNUAL REPORT##################################
         ->selectRaw('(`to_be_paid1`+`to_be_paid2`+`to_be_paid3`)  as to_be_paid4')
         ->selectRaw('(`amount_term1`+`amount_term2`+`amount_term3`)  as amount_term4')
         ->selectRaw('(`to_be_paid1`-`amount_term1`) + (`to_be_paid2`-`amount_term2`) + (`to_be_paid3`-`amount_term3`)  as remain4')
        ->where([               
            ['student_id', '=', $request->student_id],
            ['class_id', '=', $request->class_id],
            ['school_id','=',$request->school_id]
        ])->first();



            if($Schoolfees3->amount_term3==0)
            {
                $status=0;
            }
            else if($request->to_be_paid-$Schoolfees3->amount_term3>0)
            {
                 $status=1;
            }
            else if($request->to_be_paid-$Schoolfees3->amount_term3==0)
            {
                $status=2;
            }


###################################UPDATE ANNUAL PAYMENT STATUS###########################
            if($Schoolfees3->remain4>0 && $Schoolfees3->amount_term4>0)
            {
                $status4=1;
            }
            else if($Schoolfees3->remain4==0 && $Schoolfees3->amount_term4>0)
            {
               $status4=2;
            }
            else
            {
                $status4=0;
            }
###################################//UPDATE ANNUAL PAYMENT STATUS#########################


            $update_status = DB::table('schoolfees')
                            ->where([
                                ['student_id', '=', $request->student_id],
                                ['class_id', '=', $request->class_id],
                                ['school_id','=',$request->school_id]
                            ])
                            ->update([
                              'status3'=>$status,
                              'status4'=>$status4
                            ]);
 ######################################GET VALUE AFTER UPDATE#############################


            return response()->json(['message'=>'Updated successfully'],200);

        }
    }
    }

     /**
     * Search students.
     *
     * @param  \App\Discipline  $discipline
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        if($request->class_id!=='all')
        {

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
        ->where([
        ['students.name', 'like', '%'. $request->student_name.'%'],
        ['schoolfees.school_id', '=', $request->school_id],
        ['schoolfees.class_id','=',$request->class_id]

        ])
         ->limit('5')
         ->get();
         }
        else if($request->class_id=='all')
        {
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
        ->where([
        ['students.name', 'like', '%'. $request->student_name.'%'],
        ['schoolfees.school_id', '=', $request->school_id]

        ])
         ->limit('5')
         ->get();
        }
         $number_of_students=$Schoolfees->count();
         return response()->json([ 'Schoolfees' => $Schoolfees,'no_of_students'=>$number_of_students, 'message' => 'Retrieved successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schoolfees  $schoolfees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schoolfees $schoolfees)
    {
        //
    }
}
