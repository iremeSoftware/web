<?php

namespace App\Http\Controllers\API;

use App\Models\FeesTypes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;



class feesTypesController extends Controller
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
    
    
    public function index(Request $request, FeesTypes $feesTypes)
    {
        //
        $school_id=$request->school_id;
        $fees_types=$feesTypes::select('*')->where(['school_id'=>$school_id,'class_id'=>$request->class_id])->get();
        return response()->json(['fees_types'=>$fees_types,'message'=>'success'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FeesTypes $feesTypes)
    {
        //
        $school_id=$request->school_id;
        $count=$feesTypes::select('*')->where(['school_id'=>$school_id,'class_id'=>$request->class_id,'fees_name'=>$request->fees_name])->count();
        if($count>0)
          return response()->json(['message'=>'exist'],422);
        
        
        
        $feesTypes = new $feesTypes;
        $feesTypes->school_id = $school_id;
        $feesTypes->class_id = $request->class_id;
        $feesTypes->fees_id = Helper::generate_user_id();
        $feesTypes->fees_name = $request->fees_name;
        $feesTypes->save(); 
        
        return response()->json(['fees_types'=>$feesTypes,'message'=>'created'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FeesTypes  $feesTypes
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,FeesTypes $feesTypes)
    {
        //
        $fees_types=$feesTypes::select('*')->where(['fees_id'=>$request->fees_id])->first();
        return response()->json(['fees_types'=>$fees_types,'message'=>'created'],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FeesTypes  $feesTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeesTypes $feesTypes)
    {
        //
        $fees_types=$feesTypes::where(['fees_id'=>$request->fees_id])->first();
        $fees_types->fees_name = $request->fees_name;
        $fees_types->save();
        return response()->json(['fees_types'=>$fees_types,'message'=>'updated'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FeesTypes  $feesTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeesTypes $feesTypes)
    {
        //
        $fees_types=$feesTypes::where(['fees_id'=>$request->fees_id])->delete();
        return response()->json(['message'=>'deleted'],200);
        
    }
}
