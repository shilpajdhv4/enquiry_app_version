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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Auth::user()->role;
        $id = Auth::user()->id;
        $date = date('Y-m-d');
        $today_en = DB::table('tbl_enquiry')
                  ->select('enquiry_no','customer_name','mobile_no','enquiry_id')
                  ->where('followup_date','=',$date)
                  ->get();
        //if($role == '2'){
            //return redirect('add-enquiry');
        //}else{
//            $data = DB::table('tbl_enquiry as e')
//                        ->select(DB::raw('count(enquiry_id) as count_enq'),'tbl_enquiry_status.status_name','e.status_id')
//                        ->leftjoin('tbl_enquiry_status','tbl_enquiry_status.id','=','e.status_id');
////                        ->leftjoin('users','users.id','=','e.emp_id')
//                    if($role == '2'){
//                            $data->where('emp_id','=',$id);
//                        }
//                   $enquiry_list =   $data->groupBy('e.status_id');
//                    $enquiry_list =  $data->get();
                    
        return view('home',['today_en'=>$today_en]);
        //}
    }
    
   
    
    
    

    
}
