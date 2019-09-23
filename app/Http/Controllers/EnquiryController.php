<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class EnquiryController extends Controller
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
    
    public function validateMobile($id) {
        $id = trim($id);
        if (\App\Enquiry::where('mobile_no', $id)->exists()) {
            $enquiry_data = \App\Enquiry::where('mobile_no', $id)->first();
            echo json_encode($enquiry_data);
        }
    }
    
    public function enquiryList()
    {
        $role = Auth::user()->role;
        $id = Auth::user()->id;
        
        $data = DB::table('tbl_enquiry')
                ->select('tbl_enquiry.*','tbl_item.item_name','tbl_enquiry_status.status_name','users.name')
                ->leftjoin('tbl_item','tbl_item.item_id','tbl_enquiry.product_id')
                ->leftjoin('tbl_enquiry_status','tbl_enquiry_status.id','tbl_enquiry.status_id')
                ->leftjoin('users','users.id','tbl_enquiry.emp_id');
                if($role == '2'){
                    $data->where('emp_id','=',$id);
                }
        $enquiry_list =  $data->where('tbl_enquiry.is_active','=',0);
        $enquiry_list =  $data->where('tbl_enquiry.active_inactive_status','=',1);
        $enquiry_list =  $data->get();
        
//                \App\Enquiry::where('is_active','=',0)->get();
        return view('enquiry.enquiry_list',['enquiry_list'=>$enquiry_list]);
    }
    
    public function addEnquiry()
    {
        $id = Auth::user()->id;
        $last_entry = \App\Enquiry::select('enquiry_no')->where(['emp_id'=>$id])->orderBy('enquiry_id','desc')->first();
        $status = \App\ActiveInactive::where(['is_active'=>0])->get();
        $city = \App\City::get();
        $custome_data = \App\CustomerMaster::select('cust_id','cust_name')->where(['is_active'=>1])->get();
        $product_data = \App\ItemMaster::select('item_id','item_name')->where(['is_active'=>1])->get();
        $employee_data = \App\User::select('id','name')->where(['role'=>2,'is_active'=>0])->get();
        $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0])->get();
        $source = \App\Source::select('name')->get();
        return view('enquiry.add_enquiry',['city'=>$city,'custome_data'=>$custome_data,'product_data'=>$product_data,'employee_data'=>$employee_data,'enquiry_status'=>$enquiry_status,'last_entry'=>$last_entry,'source'=>$source,'status'=>$status]);
    }
    
    public function saveEnquiry(Request $request)
    {
        $role = Auth::user()->role;
        $requestData = $request->all();
        $requestData['emp_id'] = Auth::user()->id;
        $requestData['insert_date'] = date('Y-m-d');
        
        if(isset($requestData['assign_to_emp_id']) && $role == '1'){
            $requestData['emp_id'] = $requestData['assign_to_emp_id'];
        }
        if(isset($requestData['follow_up'])){
            $arr = end($requestData['follow_up']);
            $requestData['followup_date'] = $arr[1];
            $requestData['follow_up'] = json_encode($requestData['follow_up']);
        }
//        echo "<pre>";print_r($requestData);exit;
        
        $requestData['create_at'] = date('Y-m-d h:m:s');
        if($requestData['en_id'] == ""){
            \App\Enquiry::create($requestData);
            Session::flash('alert-success', 'Created Successfully.');
        }else{
            $id = $requestData['en_id'];
            $data = \App\Enquiry::findorfail($id);
            $data->update($requestData);
            Session::flash('alert-success', 'Updated Successfully.');
        }
        return redirect('add-enquiry');
    }
    
    public function editEnquiry()
    {
        $id = $_GET['id'];
        $city = \App\City::get();
        $status = \App\ActiveInactive::where(['is_active'=>0])->get();
        $enquiry_data = \App\Enquiry::findorfail($id);
        $custome_data = \App\CustomerMaster::select('cust_id','cust_name')->where(['is_active'=>1])->get();
        $product_data = \App\ItemMaster::select('item_id','item_name')->where(['is_active'=>1])->get();
        $employee_data = \App\User::select('id','name')->where(['role'=>0,'is_active'=>0])->get();
        $enquiry_status = \App\EnquiryStatus::select('id','status_name')->where(['is_active'=>0])->get();
        $source = \App\Source::select('name')->get();
        return view('enquiry.edit_enquiry',['status'=>$status,'city'=>$city,'enquiry_data'=>$enquiry_data,'custome_data'=>$custome_data,'product_data'=>$product_data,'employee_data'=>$employee_data,'enquiry_status'=>$enquiry_status,'source'=>$source]);
    }
    
    public function updateEnquiry($id,Request $request)
    {
        $requestData = $request->all();
        $role = Auth::user()->role;
//        echo "<pre>";print_r($requestData);exit;
        if(isset($requestData['assign_to_emp_id']) && $role == '1'){
            $requestData['emp_id'] = $requestData['assign_to_emp_id'];
        }
        if(isset($requestData['follow_up'])){
            $arr = end($requestData['follow_up']);
            $requestData['followup_date'] = $arr[1];
            $requestData['follow_up'] = json_encode($requestData['follow_up']);
        }
//        $requestData['follow_up'] = json_encode($requestData['follow_up']);
        $requestData['modified_At'] = date("Y-m-d h:m:s");
        $users = \App\Enquiry::findorfail($id);
        $users->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('enquiry-list');
    }
    
    public function deletEnquiry($id)
    {
        $query= \App\Enquiry::where('enquiry_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enquiry-list');
    }
    
  
   
}