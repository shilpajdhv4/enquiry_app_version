<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Dealer;
use App\Machine;
use Session;

class EnquiryFieldController extends Controller
{

    public function __construct()
    {
       // $this->middleware('auth');
       $this->middleware('auth.basic');
       $this->middleware(function ($request, $next) {
           // $this->user= Auth::user();
            $this->admin = Auth::guard('admin')->user();
            $this->employee = Auth::guard('employee')->user();
            return $next($request);
        });
    }
    
    //Product
    public function saveProduct(Request $request){
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
        if(isset($requestData['product_arr'])){
            foreach($requestData['product_arr'] as $prod){
                $product['prod_name'] = $prod;
                $product['cat_id'] = $requestData['cat_id'];
                $product['user_id'] = $this->admin->rid;
                \App\EnquiryProduct::create($product);
            }
        }
        return redirect('enq_category');
    }
    
    //Setting
    public function getSetting(){
        if(Auth::guard('web')->check()){
            $id = $this->user->id;
        }
        else if(Auth::guard('admin')->check()){
            $id = $this->admin->rid;
        }
        
        $setting = \App\Admin::select('enq_setting')->where(['rid'=>$id])->first();
        if(!empty($setting)){
            if(isset($setting->enq_setting)){
                $setting->enq_setting = json_decode($setting->enq_setting,true);
            }
        }
//        echo "<pre>";print_r($setting->enq_setting);exit;
        return view('enq_master.setting',['setting'=>$setting]);
    }

    public function saveSetting(Request $request){
        $requestData = $request->all();
//        $setting = "0";
        if(isset($requestData['parameter_textbox'])){
            $setting = json_encode($requestData['parameter_textbox']);
        }else{
            $requestData['parameter_textbox'][] = "0";
            $setting = json_encode($requestData['parameter_textbox']);
        }
        $id = $this->admin->rid;
        \App\Admin::where(['rid'=>$id])->update(['enq_setting'=>$setting]);
        Session::flash('alert-success', 'Saved Successfully.');
        return redirect('enq-setting');
    }

    //Enquiry Template
    
    public function getTemplateList(){
        $id = $this->admin->rid;
        $enq_template = \App\EnquiryTemplate::where(['user_id'=>$id,'is_active'=>0])->get();
        $enq_root_category = \App\EnquiryCategory::select('cat_id','cat_name')->where(['user_id'=>$id,'is_active'=>0])->whereNull('parent_cat_name')->get(); 
        return view('enq_master.enq_template_list',['enq_template'=>$enq_template,'enq_root_category'=>$enq_root_category]);
    }
    
    public function getTemplate(){
        $id = $this->admin->rid;
        $location = \App\EnquiryLocation::select('loc_id','loc_name')->where(['user_id'=>$id,'is_active'=>0])->get();
//        $location = \App\EnquiryLocation::select('loc_id','loc_name')->get();
        return view('enq_master.add_enq_template',['location'=>$location]);
    }
    
    public function saveTemplate(Request $request){
        $requestData = $request->all();
       //echo "<pre>";print_r($requestData);exit;
        $requestData['user_id'] = $this->admin->rid;
        if(isset($requestData['loc_id'])){
            $requestData['loc_id'] = implode(",",$requestData['loc_id']);
        }
       // echo "<pre>";print_r($requestData);exit;
        \App\EnquiryTemplate::create($requestData);
        return redirect('enq_templates');
    }
    
    public function editEnquiry(){
        $id = $_GET['id'];
        $user_id = $this->admin->rid;
        $location = \App\EnquiryLocation::select('loc_id','loc_name')->where(['user_id'=>$user_id,'is_active'=>0])->get();
        $enq_root_category = \App\EnquiryCategory::select('cat_id','cat_name')->where(['user_id'=>$user_id])->whereNull('parent_cat_name')->get(); 
        $enq_temp = \App\EnquiryTemplate::where(['enq_temp_id'=>$id])->first();
        return view('enq_master.edit_enq_template',['enq_temp'=>$enq_temp,'enq_root_category'=>$enq_root_category,'location'=>$location]);
    }
    
    public function updateCategory(Request $request){
        $requestData = $request->all();
        $enq_temp = \App\EnquiryTemplate::where(['enq_temp_id'=>$requestData['cat_id']])->first();
        if(isset($requestData['parameter_textbox'])){
            if($enq_temp->enq_categories != ""){
                $prev_field = json_decode($enq_temp->enq_categories,true);
                  foreach($requestData['parameter_textbox'] as $row){
                    array_push($prev_field,$row);
                  }
                 // echo "<pre>";print_r($prev_field);exit;
                  $requestData['enq_categories'] = json_encode($prev_field);
            }
            else{
                $requestData['enq_categories'] = json_encode($requestData['parameter_textbox']);
            }
        }
        $enq_temp->update($requestData);
        Session::flash('alert-success', 'Added Successfully.');
        return redirect('enq_templates');
//        echo "<pre>";print_r($requestData);exit;
    }

    public function updateField(Request $request){
        $requestData = $request->all();
//        echo "<pre>";
//        print_r($requestData);exit;
        $enq_temp = \App\EnquiryTemplate::where(['enq_temp_id'=>$requestData['cat_id']])->first();
        if(isset($requestData['parameter_field'])){
            if($enq_temp->enq_fields != ""){
                $prev_field = json_decode($enq_temp->enq_fields,true);
                  foreach($requestData['parameter_field'] as $row){
                    array_push($prev_field,$row);
                  }
                  $requestData['enq_fields'] = json_encode($prev_field);
            }
            else{
                $requestData['enq_fields'] = json_encode($requestData['parameter_field']);
            }
        }
//        echo "<pre>";
//        print_r($requestData);exit;
        $enq_temp->update($requestData);
        Session::flash('alert-success', 'Added Successfully.');
        return redirect('enq_templates');
    }
    
    public function updateEnquiry(Request $request){
        $requestData = $request->all();
        $imp_arr = array();
//        echo "<pre>";print_r($requestData);exit;
        
        
        $requestData['dashboard_field'] = json_encode($imp_arr);
//        echo "<pre>";print_r($imp_arr);exit;
        $id = $requestData['enq_id'];
        $enq_temp = \App\EnquiryTemplate::where(['enq_temp_id'=>$id])->first();
        if(isset($requestData['loc_id'])){
            $requestData['loc_id'] = implode(",",$requestData['loc_id']);//json_encode($requestData['loc_id']);
        }
        if(isset($requestData['parameter_textbox'])){
            $requestData['enq_categories'] = json_encode($requestData['parameter_textbox']);
        }
        if(isset($requestData['parameter_field'])){
            foreach($requestData['parameter_field'] as $f){
               if(isset($f[3])){
                 $imp_arr[$f[0]] = $f[3];
               }
            }
            $requestData['enq_fields'] = json_encode($requestData['parameter_field']);
        }
//        echo "<pre>";print_r($requestData);exit;
        $enq_temp->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('enq_templates');
//        $requestData['enq_fields'] = 
    }
    
    public function deleteEnqTep($id){
        $query= \App\EnquiryTemplate::where('enq_temp_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enq_templates');
    }

    
    //Category
    public function getCategoryList(){
        $id = $this->admin->rid;
        $enq_category = \App\EnquiryCategory::where(['user_id'=>$id,'is_active'=>0])->get();
//        $enq_root_category = \App\EnquiryCategory::select('cat_id','cat_name')->where(['user_id'=>$id])->get(); 
        return view('enq_master.enq_category_list',['enq_category'=>$enq_category]);
    }

    public function getDropdown(){
        $id = $this->admin->rid;
        $parent_cat = \App\EnquiryCategory::select('cat_name')->where(['user_id'=>$id,'is_active'=>0])->get();
        $parent_arr = array();
        foreach($parent_cat as $cat){
            $parent_arr[] = $cat->cat_name;
        }
        return view('enq_master.category_master',['parent_arr'=>$parent_arr]);
    }
    
    public function getPrevcat($id){
        $id1 = $this->admin->rid;
        $id = trim($id);
        if (\App\EnquiryCategory::where(['user_id'=>$id1,'is_active'=>0,'cat_name'=>$id])->exists()) {
            echo "true";
        }else{
            echo "Please Enter Correct Parent Category This Parent Category Not Exists !";
        }
//        $parent_cat = \App\EnquiryCategory::select('cat_name')->where(['user_id'=>$id,'is_active'=>0])->get();
    }

    public function saveCategory(Request $request){
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData['parameter_detail']);exit;
        foreach($requestData['parameter_detail'] as $row){
            $requestData['cat_name'] = $row['cat_name'];
            $requestData['cat_description'] = $row['cat_description'];
            if($row['parent_cat_name'] != ""){
                $search = \App\EnquiryCategory::select('cat_id','cat_name')->where('cat_name', 'LIKE', '%'. $row['parent_cat_name']. '%')->where(['user_id'=>$this->admin->rid,'is_active'=>0])->first();
                if(isset($search->cat_id)){
                    $requestData['parent_cat_id'] = $search->cat_id;
                }else{
                    $requestData['parent_cat_id'] = NULL;
                }
            }else{
                $requestData['parent_cat_id'] = NULL;
            }
            $requestData['parent_cat_name'] = $row['parent_cat_name'];
            $requestData['user_id'] = $this->admin->rid;
            \App\EnquiryCategory::create($requestData);
        }
        Session::flash('alert-success', 'Created Successfully.');
        return redirect('enq_category');
    }
    
    public function editCategory(){
        $id = $_GET['id'];
        $id1 = $this->admin->rid;
        $parent_cat = \App\EnquiryCategory::select('cat_name')->where(['user_id'=>$id1])->get();
        $parent_arr = array();
        foreach($parent_cat as $cat){
            $parent_arr[] = $cat->cat_name;
        }
        $enq_category = \App\EnquiryCategory::where(['cat_id'=>$id])->first(); 
        $product = \App\EnquiryProduct::select('prod_id','prod_name')->where(['cat_id'=>$id,'is_active'=>'0'])->get();
        return view('enq_master.edit_enq_category',['enq_category'=>$enq_category,'product'=>$product,'parent_arr'=>$parent_arr]);
    }

    public function updateEnqCategory(Request $request){
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
        $enq_category = \App\EnquiryCategory::where(['cat_id'=>$requestData['cat_id']])->first(); 
        if($requestData['parent_cat_name'] != ""){
            $search = \App\EnquiryCategory::select('cat_id','cat_name')->where('cat_name', 'LIKE', '%'. $requestData['parent_cat_name']. '%')->first();
            $requestData['parent_cat_id'] = $search->cat_id;
        }else{
            $requestData['parent_cat_id'] = NULL;
        }
        $enq_category->update($requestData);
        
        if(isset($requestData['product_prev_arr'])){
            if(count($requestData['product_prev_arr'])>0){
                foreach($requestData['product_prev_arr'] as $key=>$val){
                    $product = \App\EnquiryProduct::where(['prod_id'=>$key])->first();
                    $product_arr['prod_name'] = $val;
                    $product->update($product_arr);
                }
            }
        }
         
        if(isset($requestData['product_arr'])){
            if(count($requestData['product_arr'])>0){
                foreach($requestData['product_arr'] as $prod){
                    $product1['prod_name'] = $prod;
                    $product1['cat_id'] = $requestData['cat_id'];
                    $product1['user_id'] = $this->admin->rid;
                    \App\EnquiryProduct::create($product1);
                }
            }
        }
        Session::flash('alert-success', 'Product Created Successfully.');
        return redirect('enq_category');
        
    }
    
    public function deleteEnqCategory($id){
        $query= \App\EnquiryCategory::where('cat_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enq_category');
    }







    public function getField(){
        return view('enq_master.field_master');
    }


//    public function prevCategory($id){
//        $enq_temp = \App\EnquiryTemplate::select('enq_categories')->where(['enq_temp_id'=>$id])->first();
//        $enq_cat = json_decode($enq_temp->enq_categories);
//        echo json_encode($enq_cat);
//    }

    public function postField(Request $request){
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
        $requestData['u_id'] = 1;//$this->admin->rid;
        $requestData['enq_fields_val'] = json_encode($requestData['parameter_textbox']);
        \App\EnquiryField::create($requestData);
        return redirect('enq_field');
    }
    
}