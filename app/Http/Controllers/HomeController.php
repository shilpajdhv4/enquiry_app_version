<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
        $this->middleware('auth.basic');
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $this->admin = Auth::guard('admin')->user();
            $this->employee = Auth::guard('employee')->user();
            return $next($request);
        });
    }

    
    public function indexAdmin()
    {
        $date = date('Y-m-d');
        $id = $this->admin->rid;
        $location = \App\EnquiryLocation::where(['user_id'=>$id,'is_active'=>0])->get();
        $today_en = DB::table('enq_enquiries')
              ->select('enquiry_no','enq_name','enq_mobile_no','enq_id')
              ->where('enq_followup_date','=',$date)
              ->where('enq_user_id','=',$id)
              ->where('is_active','=',0)
              ->get();
        return view('admin.home',['today_en'=>$today_en,'location'=>$location]);
    }
    
    public function dashboard_enq_list()
    {
        $id=$_GET['id'];
        $cid = $this->admin->rid;
        $enquiry_list = DB::table('enq_enquiries')
                ->select('enq_enquiries.enq_id','enq_enquiries.enq_mobile_no','enq_enquiries.enq_name','enq_enquiries.enq_followup_date',
                        'enq_enquiries.insert_date','enq_location.loc_name')
                ->leftjoin('enq_location','enq_location.loc_id','enq_enquiries.lid')
                ->where(['enq_enquiries.is_active'=>0,'enq_user_id'=>$cid,'lid'=>$id])
                ->get();
        return view('dashboard_enq_list',['enquiry_list' => $enquiry_list]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   
    
    public function empIndex(){
        $date = date('Y-m-d');
        $cid = $this->employee->cid;
        $lid = $this->employee->lid;
        $emp_id = $this->employee->id;
        
        $today_en = DB::table('enq_enquiries')
              ->select('enquiry_no','enq_name','enq_mobile_no','enq_id')
              ->where(['enq_followup_date'=>$date,'enq_user_id'=>$cid,'lid'=>$lid,'enq_emp_id'=>$emp_id,'is_active'=>0])
              ->get();
        return view('employee.home',['today_en'=>$today_en]);
    }
    
    
    

    
}
