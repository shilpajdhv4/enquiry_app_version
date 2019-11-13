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
//        if(Auth::guard('admin')->check()){
            $this->middleware('auth.basic');
//        }else{
//            $this->middleware('auth.employee');
//        }
//       
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $this->admin = Auth::guard('admin')->user();
            $this->employee = Auth::guard('employee')->user();
            return $next($request);
        });
    }
    
    public function getEnqfield($id){
        $enq_temp = \App\EnquiryTemplate::where(['enq_temp_id'=>$id])->first();
        $arr = array();
        $field = json_decode($enq_temp['enq_fields'],true);
//        echo "<pre>";print_r($field);exit;
        $category = json_decode($enq_temp['enq_categories'],true);
        $field_temp = $cat_temp = $required = "";
        $i = $k = 0; 
        if(!empty($field)>0){ 
           foreach($field as $f){
                if($i == 2){ 
                   $field_temp .= '<div class="form-group">';   
                }
                if($i == 0){
                    $field_temp .= '<div class="form-group">';   
                }
                if(isset($f[2])){
                    if($f[2] == "on")
                        $required = "required";
                }else{
                    $required = "";
                }
                $field_temp .= '<label for="userName" class="col-sm-2 control-label"  readonly style="padding-top: 7px;margin-bottom: 0;text-align: right;" >'.$f[0].'</label>
                   <div class="col-sm-4">';
                    if(isset($f[1])){
                        $type = $f[1];
                        if($f[1] == "logtext"){
                            $field_temp .= '<textarea class="form-control" placeholder="'.$f[0].'" value="" row="3" name="parameter_textbox['.$f[0].'] "'.$required.'></textarea>';
                        }
                        else if($f[1] == "dropdown"){
                            $field_temp .= '<select class="form-control select2" style="width: 100%;" name="parameter_textbox['.$f[0].'][product][] "'.$required.' >';
                                          if(isset($f['product'])){
                                              foreach($f['product'] as $p){
                                               $field_temp .= '<option value="'.$p.'">'.$p.'</option>';
                                              }
                                          }
                                                
                                     $field_temp .= '</select>';
                        }
                        else{
                            $field_temp .= '<input type="'.$type.'" class="form-control" placeholder="'.$f[0].'" value="" name="parameter_textbox['.$f[0].'] "'.$required.'>';
                        }
                    }
                   $field_temp .= '</div>';
                $i++; 
                if($i == 2){ 
                    $field_temp .= '</div>';$i=0;
                } $k++; 
            } 
        }
        
        if(!empty($category)){
            $category_val = \App\EnquiryCategory::select('cat_id','cat_name')->whereIn('cat_id',$category)->get();
//            echo "<pre>";print_r($category_val);exit;
            //$cat_temp .= '<div class="form-group">';  
            $cat_temp .= '<label for="userName" class="col-sm-2 control-label"  readonly style="padding-top: 7px;margin-bottom: 0;text-align: right;" >Select Category</label>
                <div class="col-sm-2">
              <select class="form-control select2" style="width: 100%;" name="category[]" id="category">
                <option value="">-- Select --</option>';
                foreach($category_val as $cat){                                   
                    $cat_temp .= '<option value="'.$cat->cat_id.":".$cat->cat_name.'" >'.$cat->cat_name.'</option>';
                }
            $cat_temp .= '</select></div><div id="sub_level_box"></idv>';
        }
        
        $arr['field'] = $field_temp;
        $arr['category'] = $cat_temp;
        echo json_encode($arr);
        //echo $field_temp;
    }
    
    public function getSubcat($id){
        $cat_temp = $prod_temp = "";
        $sub_cat = \App\EnquiryCategory::select(['cat_id','cat_name'])->where(['parent_cat_id'=>$id])->get();
        $prd_cat = \App\EnquiryProduct::select(['prod_id','prod_name'])->where(['cat_id'=>$id])->get();
//        echo "<pre>";print_r($prd_cat);exit;
        if(count($sub_cat)>0){
           // $cat_temp .= '<div class="form-group">';  
            $cat_temp .= '<label for="userName" class="col-sm-2 control-label"  readonly style="padding-top: 7px;margin-bottom: 0;text-align: right;" >Level</label>
                <div class="col-sm-2">
                <select class="form-control select2" style="width: 100%;" name="category[]" id="category1">
                <option value="">-- Select --</option>';
                foreach($sub_cat as $cat){                                   
                    $cat_temp .= '<option value="'.$cat->cat_id.":".$cat->cat_name.'" >'.$cat->cat_name.'</option>';
                }
            $cat_temp .= '</select>';
            $arr['category'] = $cat_temp;
        }else{
            $arr['category'] = "";
        }
        
        if(count($prd_cat)>0){
            $prod_temp .= '<label for="userName" class="col-sm-2 control-label"  readonly style="padding-top: 7px;margin-bottom: 0;text-align: right;" >Product</label>
                           <div class="col-sm-3"><select class="form-control select2" style="width: 100%;" multiple name="produc_field[]" id="produc_field">
                           <option value="">-- Select --</option>';
                foreach($prd_cat as $prod){ 
                    $prod_temp .= '<option value="'.$prod->prod_id.":".$prod->prod_name.'" >'.$prod->prod_name.'</option>';
                }
                $prod_temp .= '</select></div>';
            $arr['product'] = $prod_temp;
        }else{
            $arr['product'] = ""; 
        }
        
//        if(count($prd_cat)>0){
//            $prod_temp .= '<div class="row">';
//            $prod_temp .= '<label for="userName" class="col-sm-2 control-label"  readonly style="padding-top: 7px;margin-bottom: 0;text-align: right;" >Product</label>';
//                foreach($prd_cat as $prod){                                   
//                    $prod_temp .= '<div class="col-sm-2"><label>
//                              <input type="checkbox" class="minimal" name="produc_field['.$prod->prod_name.']" value="'.$prod->prod_id.'"> '.$prod->prod_name.'
//                            </label>
//                        </div>';
//                }
//            $prod_temp .= '</select></div>';
//			$arr['product'] = $prod_temp;
//        }
	echo json_encode($arr);
//        echo $cat_temp;
    }
    
    public function getEnqfield1($id){
        $enq_temp = \App\EnquiryTemplate::where(['enq_temp_id'=>$id])->first();
        $arr = array();
        $field = json_decode($enq_temp['enq_fields'],true);
//        echo "<pre>";print_r($field);exit;
        $category = json_decode($enq_temp['enq_categories'],true);
        $field_temp = $cat_temp = $required = "";
        $i = $k = 0; 
        if(!empty($field)>0){ 
           foreach($field as $f){
//                $field_temp .= '<div class="form-group form-float">';  
                if(isset($f[2])){
                    if($f[2] == "on")
                        $required = "required";
                }else{
                    $required = "";
                }
                
                $field_temp .= '<div class="form-group form-float"><div class="form-line">';
                    if(isset($f[1])){
                        $type = $f[1];
                        if($f[1] == "logtext"){
                            $field_temp .= '<textarea class="form-control no-resize" value="" cols="30" rows="5" name="parameter_textbox['.$f[0].'] "'.$required.'></textarea><label  class="form-label" >'.$f[0].'</label>';
                        }
                        else if($f[1] == "dropdown"){
                            $field_temp .= '<p><b>'.$f[0].'</b></p><select class="form-control show-tick" data-live-search="true" name="parameter_textbox['.$f[0].'][product][] "'.$required.' >';
                                          if(isset($f['product'])){
                                              foreach($f['product'] as $p){
                                               $field_temp .= '<option value="'.$p.'">'.$p.'</option>';
                                              }
                                          }
                                                
                                     $field_temp .= '</select>';
                        }
                        else{
                            $field_temp .= '<input type="'.$type.'" class="form-control" value="" name="parameter_textbox['.$f[0].'] "'.$required.'><label  class="form-label" >'.$f[0].'</label>';
                        }
                    }
                   $field_temp .= '</div></div>';
                $i++;  $k++; 
            } 
        }
        
        if(!empty($category)){
            $category_val = \App\EnquiryCategory::select('cat_id','cat_name')->whereIn('cat_id',$category)->get();
//            echo "<pre>";print_r($category_val);exit;
            //$cat_temp .= '<div class="form-group">';  
            $cat_temp .= '<div class="form-group form-float"><div class="form-line"><p><b>Select Category</b></p>
              <select class="form-control show-tick" data-live-search="true" name="category[]" id="category">
                <option value="">-- Select --</option>';
                foreach($category_val as $cat){                                   
                    $cat_temp .= '<option value="'.$cat->cat_id.":".$cat->cat_name.'" >'.$cat->cat_name.'</option>';
                }
            $cat_temp .= '</select></div></div><div id="sub_level_box"></idv>';
        }
        
        $arr['field'] = $field_temp;
        $arr['category'] = $cat_temp;
        echo json_encode($arr);
        //echo $field_temp;
    }    
    
    public function getSubcat1($id){
        $cat_temp = $prod_temp = "";
        $sub_cat = \App\EnquiryCategory::select(['cat_id','cat_name'])->where(['parent_cat_id'=>$id])->get();
        $prd_cat = \App\EnquiryProduct::select(['prod_id','prod_name'])->where(['cat_id'=>$id])->get();
//        echo "<pre>";print_r($prd_cat);exit;
        if(count($sub_cat)>0){
           // $cat_temp .= '<div class="form-group">';  
            $cat_temp .= '<div class="form-group form-float"><div class="form-line"><p><b>Level</b></p>
                <select class="form-control show-tick" data-live-search="true" name="category[]" id="category1">
                <option value="">-- Select --</option>';
                foreach($sub_cat as $cat){                                   
                    $cat_temp .= '<option value="'.$cat->cat_id.":".$cat->cat_name.'" >'.$cat->cat_name.'</option>';
                }
            $cat_temp .= '</select></div></div>';
            $arr['category'] = $cat_temp;
        }else{
            $arr['category'] = "";
        }
        
        if(count($prd_cat)>0){
            $prod_temp .= '<div class="form-group form-float"><div class="form-line"><p><b>Product</b></p>
                           <select class="form-control show-tick" data-live-search="true" name="produc_field[]" id="produc_field" multiple>
                           <option value="">-- Select --</option>';
                foreach($prd_cat as $prod){ 
                    $prod_temp .= '<option value="'.$prod->prod_id.":".$prod->prod_name.'" >'.$prod->prod_name.'</option>';
                }
                $prod_temp .= '</select></div></div>';
            $arr['product'] = $prod_temp;
        }else{
            $arr['product'] = ""; 
        }
        
//        if(count($prd_cat)>0){
//            $prod_temp .= '<div class="row">';
//            $prod_temp .= '<label for="userName" class="col-sm-2 control-label"  readonly style="padding-top: 7px;margin-bottom: 0;text-align: right;" >Product</label>';
//                foreach($prd_cat as $prod){                                   
//                    $prod_temp .= '<div class="col-sm-2"><label>
//                              <input type="checkbox" class="minimal" name="produc_field['.$prod->prod_name.']" value="'.$prod->prod_id.'"> '.$prod->prod_name.'
//                            </label>
//                        </div>';
//                }
//            $prod_temp .= '</select></div>';
//			$arr['product'] = $prod_temp;
//        }
	echo json_encode($arr);
//        echo $cat_temp;
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
        if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
            $enquiry_list = DB::table('enq_enquiries')
                     ->select('enq_enquiries.enq_id','enq_enquiries.enq_mobile_no','enq_enquiries.enq_name','enq_enquiries.enq_followup_date',
                             'enq_enquiries.insert_date','enq_location.loc_name')
                     ->leftjoin('enq_location','enq_location.loc_id','enq_enquiries.lid')
                     ->where(['enq_enquiries.is_active'=>0,'enq_user_id'=>$id])
                     ->get();
            return view('enquiry.enquiry_list',['enquiry_list'=>$enquiry_list]);
        }
        else if(Auth::guard('employee')->check()){
            $cid = $this->employee->cid;
            $lid = $this->employee->lid;
            $emp_id = $this->employee->id;
            $role = $this->employee->role;
            $enquiry_list = DB::table('enq_enquiries')
                     ->select('enq_enquiries.enq_id','enq_enquiries.enq_mobile_no','enq_enquiries.enq_name','enq_enquiries.enq_followup_date',
                             'enq_enquiries.insert_date','enq_location.loc_name')
                     ->leftjoin('enq_location','enq_location.loc_id','enq_enquiries.lid')
                     ->where(['enq_enquiries.is_active'=>0,'enq_enquiries.enq_user_id'=>$cid,'enq_enquiries.lid'=>$lid,'enq_enquiries.enq_emp_id'=>$emp_id])
                     ->get();
            return view('enquiry_employee.enquiry_list',['enquiry_list'=>$enquiry_list]);
        }  
//        return view('enquiry.enquiry_list',['enquiry_list'=>$enquiry_list]);
        
    }
    
    public function addEnquiry()
    {
        if(Auth::guard('admin')->check() || Auth::guard('employee')->check()){
            if(Auth::guard('admin')->check()){
                $user_id = $this->admin->rid;
                $enq_template = \App\EnquiryTemplate::select('temp_name','enq_temp_id')->where(['user_id'=>$user_id,'is_active'=>0])->get();
                return view('enquiry.add_enquiry',['enq_template'=>$enq_template]);
            }else if( Auth::guard('employee')->check()){
                $user_id = $this->employee->cid;
                $lid = $this->employee->lid;
                $enq_template = \App\EnquiryTemplate::select('temp_name','enq_temp_id')->where(['user_id'=>$user_id,'is_active'=>0])->whereRaw('FIND_IN_SET(?, loc_id)', [$lid])->get();
                return view('enquiry_employee.add_enquiry',['enq_template'=>$enq_template]);
            }
//            return view('enquiry.add_enquiry',['enq_template'=>$enq_template]);
//            echo "<pre>";print_r($enq_template);exit;
            //,['city'=>$city,'brand'=>$brand,'custome_data'=>$custome_data,'product_data'=>$product_data,'employee_data'=>$employee_data,'enquiry_status'=>$enquiry_status,'last_entry'=>$last_entry,'source'=>$source,'status'=>$status,'category'=>$category]);
        }else{
            return redirect('home');
        }
    }
    
    public function saveEnquiry(Request $request)
    {
        $requestData = $request->all();
        //echo "<pre>";print_r($requestData);exit;
        if(Auth::guard('admin')->check()){
            $requestData['enq_user_id'] = $this->admin->rid;
        }
        else if(Auth::guard('employee')->check()){
            $requestData['enq_user_id'] = $this->employee->cid;
            $requestData['lid'] = $this->employee->lid;
            $requestData['enq_emp_id'] = $this->employee->id;
        }
        
        $requestData['insert_date'] = date('Y-m-d');
        if(Auth::guard('admin')->check()){
            if(isset($requestData['assign_to_emp_id'])){
                $requestData['emp_id'] = $requestData['assign_to_emp_id'];
            }
        }
        if(isset($requestData['parameter_textbox'])){
                $requestData['enq_fields'] = json_encode($requestData['parameter_textbox']);
        }
        if(isset($requestData['category'])){
                $requestData['enq_category'] = json_encode($requestData['category']);
        }
        if(isset($requestData['produc_field'])){
                $requestData['enq_product'] = json_encode($requestData['produc_field']);
        }
		
        if(isset($requestData['follow_up'])){
            $arr = end($requestData['follow_up']);
			if(isset($arr[1])){
                            $requestData['enq_followup_date']  = date("Y-m-d", strtotime($arr[1]));
			}
            $requestData['follow_up'] = json_encode($requestData['follow_up']);
        }
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
        if(Auth::guard('admin')->check() || Auth::guard('employee')->check()){
            if(Auth::guard('admin')->check()){
                $user_id = $this->admin->rid;
            }else if( Auth::guard('employee')->check()){
                $user_id = $this->employee->cid;
            }
            $enq_template = \App\EnquiryTemplate::select('temp_name','enq_temp_id')->where(['user_id'=>$user_id,'is_active'=>0])->get();
            $enquiry_data = DB::table('enq_enquiries')
                     ->select('*')
                     ->where(['is_active'=>0,'enq_id'=>$id])
                     ->first();
//            echo "<pre>";print_r($enquiry_data);exit;
            return view('enquiry.edit_enquiry',['enq_template'=>$enq_template,'enquiry_data'=>$enquiry_data]);//,['city'=>$city,'brand'=>$brand,'custome_data'=>$custome_data,'product_data'=>$product_data,'employee_data'=>$employee_data,'enquiry_status'=>$enquiry_status,'last_entry'=>$last_entry,'source'=>$source,'status'=>$status,'category'=>$category]);
        }else{
            return redirect('home');
        }
       
//        return view('enquiry.edit_enquiry',['category'=>$category,'brand_list'=>$brand_list,'status'=>$status,'city'=>$city,'enquiry_data'=>$enquiry_data,'custome_data'=>$custome_data,'product_data'=>$product_data,'employee_data'=>$employee_data,'enquiry_status'=>$enquiry_status,'source'=>$source]);
    }
    
    public function updateEnquiry($id,Request $request)
    {
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
        if(Auth::guard('admin')->check()){
            if(isset($requestData['assign_to_emp_id'])){
                $requestData['emp_id'] = $requestData['assign_to_emp_id'];
            }
        }
        
        if(isset($requestData['parameter_textbox'])){
                $requestData['enq_fields'] = json_encode($requestData['parameter_textbox']);
        }
        if(isset($requestData['category'])){
                $requestData['enq_category'] = json_encode($requestData['category']);
        }
        if(isset($requestData['produc_field'])){
                $requestData['enq_product'] = json_encode($requestData['produc_field']);
        }
        
        if(isset($requestData['follow_up'])){
            $arr = end($requestData['follow_up']);
			if(isset($arr[1])){
                            $requestData['enq_followup_date']  = date("Y-m-d", strtotime($arr[1]));
			}
            $requestData['follow_up'] = json_encode($requestData['follow_up']);
        }
//        $requestData['follow_up'] = json_encode($requestData['follow_up']);
//        $requestData['updated_at'] = date("Y-m-d h:m:s");
        $users = \App\Enquiry::findorfail($id);
        $users->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('enquiry-list');
    }
    
    public function deletEnquiry($id)
    {
        $query= \App\Enquiry::where('enq_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enquiry-list');
    }
  
   
}