<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class EnquiryStatusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
         $this->middleware('auth');
      
    }
    
  
    
    public function statusList()
    {
            $status_list = \App\EnquiryStatus::where('is_active','=',0)->get();
            return view('enquiry_status.enquiry_status_list',['status_list'=>$status_list]);
    }
    
    public function addEnquirystatus()
    {
        return view('enquiry_status.add_enquiry_status');
    }
    
    public function saveStatus(Request $request)
    {
        $requestData = $request->all();
        $requestData['created_at'] = date('Y-m-d h:m:s');
        \App\EnquiryStatus::create($requestData);
        Session::flash('alert-success', 'Created Successfully.');
        return redirect('enquiry-status');
    }
    
    public function editStatus()
    {
        $id = $_GET['id'];
        $status = \App\EnquiryStatus::findorfail($id);
        return view('enquiry_status.edit_enquiry_status',['status'=>$status]);
    }
    
    public function updateStatus($id,Request $request)
    {
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
        $requestData['modify_at'] = date('Y-m-d h:m:s');
        $status = \App\EnquiryStatus::findorfail($id);
        $status->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('enquiry-status');
    }
    
    public function deleteStatus($id)
    {
        $query= \App\EnquiryStatus::where('id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enquiry-status');
    }
    
  
   
}