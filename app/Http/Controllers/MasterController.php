<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Type;
use App\Category;
use App\Subscription;
use Session;
class MasterController extends Controller
{
    public function getItemData() {
        $item = DB::table('tbl_item')->where(['is_active' => '1'])->orderBy('item_name', 'asc')->get();
        return view('master_data.item_data',['type' => $item]);
    }
    
    public function dashboard_enq_list()
    {
        $status_id=$_GET['status_id'];
        $query = \App\Enquiry::where('status_id', $status_id)->get();
        $enq_status = \App\EnquiryStatus::select('status_name')->where(['id'=>$status_id])->first();
        return view('dashboard_enq_list',['status_data' => $query,'status_nm'=>$enq_status]);
    }
    
    public function getCustData() {
        $item = DB::table('tbl_cust_master')
                ->select('tbl_cust_master.*','all_cities.city_name','state_list.state')
                ->leftjoin('state_list','state_list.id','=','tbl_cust_master.state')
                ->leftjoin('all_cities','all_cities.city_id','=','tbl_cust_master.city')
                ->where(['tbl_cust_master.is_active' => '1'])
                ->orderBy('tbl_cust_master.cust_name', 'asc')
                ->get();
        return view('master_data.cust_data',['cust' => $item]);
    }
   
    public function getItem() {
        return view('master_data.add_item');
    }
    
    public function getCust() {
        $state = \App\State::get();
        return view('master_data.add_cust',['state'=>$state]);
    }
    
    public function addItem(Request $request) {
        $requestData = $request->all();
        \App\ItemMaster::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('item_data');
    }
    
    public function addCust(Request $request) {
        $requestData = $request->all();
        \App\CustomerMaster::create($requestData);
        Session::flash('alert-success','Added Successfully.');
        return redirect('cust_data');
    }
   
    public function editItem()
    {
        $item_id=$_GET['item_id'];
        $query = \App\ItemMaster::where('item_id', $item_id)->where(['is_active' => '1'])->first();
        return view('master_data.edit_item',['item_data' => $query]);
    }
    
    public function editCust()
    {
        $cust_id=$_GET['cust_id'];
        $state = \App\State::get();
        $query = \App\CustomerMaster::where('cust_id', $cust_id)->where(['is_active' => '1'])->first();
        $city = \App\City::select('city_id','city_name')->where(['state_code'=>$query->state])->get();
        return view('master_data.edit_cust',['cust_data' => $query,'state'=>$state,'city'=>$city]);
    }
  
    public function updateItem(Request $request)
    {
        $requestData = $request->all();
        $item_id=$requestData['item_id'];
        $item_name=$requestData['item_name'];
        $item_gst=$requestData['item_gst'];
        $item_rate=$requestData['item_rate'];
        $query = \App\ItemMaster::findorfail($item_id);
        DB::table('tbl_item')->where('item_id', '=',$item_id)->update(['item_name'=>$item_name,'item_rate'=>$item_rate,'item_gst'=>$item_gst]);
        Session::flash('alert-success','Updated Successfully.');
        return redirect('item_data');
    }
    
    public function updateCust(Request $request)
    {
        $requestData = $request->all();
        $cust_id=$requestData['cust_id'];
        $query = \App\CustomerMaster::findorfail($cust_id);
        $query->update($requestData);
        Session::flash('alert-success','Updated Successfully.');
        return redirect('cust_data');
    }
        
    public function deleteItem($item_id)
    {
        $query = \App\ItemMaster::where('item_id', $item_id)->update(['is_active' => 0]);
        return redirect('item_data');
    }
    public function deleteCust($cust_id)
    {
        $query = \App\CustomerMaster::where('cust_id', $cust_id)->update(['is_active' => 0]);
        return redirect('cust_data');
    }
    
    public function deleteCategory($cat_id)
    {
        $status = 0;
        $query = Category::where('cat_id', $cat_id)->update(['is_active' => $status]);
        return redirect('category_data');
    }
    
    public function deleteSubscription($sub_id)
    {
        $status = 0;
        $query = Subscription::where('sub_id', $sub_id)
                ->update(['is_active' => $status]);
        return redirect('subscription_data');
    }
    
    public function getCity($id){
        $city = \App\City::select('city_id','city_name')->where(['state_code'=>$id])->get();
//        echo "<pre>";print_r($city);exit;
        $data = "";
        $data = '<option value="">-- Select City -- </option>';
        foreach($city as $c)
        {
            $data .= '<option value="'.$c->city_id.'">'.$c->city_name.'</option>';
        }
        echo $data;
    }
    
}