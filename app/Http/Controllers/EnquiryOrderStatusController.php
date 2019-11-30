<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class EnquiryOrderStatusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.basic');
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $this->admin = Auth::guard('admin')->user();
            $this->employee = Auth::guard('employee')->user();
            return $next($request);
        });
    }
    
     
    public function listOrderstatus(){
        $order_status = \App\EnquiryOrderStatus::where(['user_id'=>$this->admin->rid,'is_active'=>0])->get();
        return view('enq_order_status.enq_order_status',['order_status'=>$order_status]);
    }
  
    public function addOrderStatus(){
        return view('enq_order_status.add_order_status');
    }
    
    public function saveOrderStatus(Request $request){
        $requestData = $request->all();
        $requestData['user_id'] = $this->admin->rid;
        
        \App\EnquiryOrderStatus::create($requestData);
        Session::flash('alert-success', 'Added Successfully.');
        return redirect('enq_order_status_list');
    }
   
    public function editOrderStatus(){
        $id = $_GET['id'];
        $order_status = \App\EnquiryOrderStatus::where(['or_id'=>$id])->first();
        return view('enq_order_status.edit_order_status',['order_status'=>$order_status]);
    }
    
    public function updateOrderStatus(Request $request){
        $requestData = $request->all();
        $id = $requestData['or_id'];
        $location = \App\EnquiryOrderStatus::where(['or_id'=>$id])->first();
        $location->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('enq_order_status_list');
    }
    
    public function deleteOrderStatus($id){
        $query= \App\EnquiryOrderStatus::where('or_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enq_order_status_list');
    }
    
}