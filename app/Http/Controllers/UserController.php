<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use App\User;

class UserController extends Controller
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
    
    public function validateEmail($id) {
        $id = trim($id);
        if (\App\Admin::where('reg_emailid', $id)->exists()) {
            echo "Email Already exists!";
        }
    }
    
    public function validateMobile($id) {
        $id = trim($id);
        if (\App\Admin::where('reg_mobileno', $id)->exists()) {
            echo "Mobile No Already exists!";
        }
    }
    
    public function validateEmployeeMobile($id) {
        $id = trim($id);
        if (\App\Employee::where('mobile_no', $id)->exists()) {
            echo "Mobile No Already exists!";
        }
    }
    
    public function addEmployee(){
//        $city = \App\City::select('city_id','city_name')->get();
        $id = $this->admin->rid;
        $city = \App\EnquiryLocation::select('loc_id','loc_name')->where(['user_id'=>$id])->get();
//        echo "<pre>";print_r($location);exit;
        return view('auth.register',['city'=>$city]);
    }

    public function saveUser(Request $request)
    {
//        echo "<pre>";print_r($request->all());exit;
        $requestData = $request->all();
        $requestData['cid'] = $this->admin->rid;
        $requestData['android_password'] = $requestData['password'];
        $requestData['password'] = bcrypt($requestData['password']);
        \App\Employee::create($requestData);
        
        return redirect('user-list');
    }
    
    public function userList(){
        if(Auth::guard('admin')->check()){
            $cid = $this->admin->rid;
            $userData = DB::table('tbl_employees')
                     ->select('id','name','mobile_no','loc_name','email')
                     ->leftjoin('enq_location','enq_location.loc_id','tbl_employees.lid')
                     ->where(['tbl_employees.is_active'=>0,'cid'=>$cid])
                     ->get();
            return view('auth.user_list',['userData'=>$userData]);
        }else{
            return redirect('home');
        }
    }
  
    public function userEdit(){
        $id = $_GET['id'];
        $userData = \App\Employee::findorfail($id);
        $id = $this->admin->rid;
        $city = \App\EnquiryLocation::select('loc_id','loc_name')->where(['user_id'=>$id])->get();
        return view('auth.edit_user',['userData'=>$userData,'city'=>$city]);
    }
    
    public function updateUser($id,Request $request)
    {
        $requestData = $request->except('password');
//        echo "<pre>";print_r($requestData);exit;
        if ($request->password){
            $requestData['android_password'] = $request->password;
            $requestData['password'] = bcrypt($request->password);
        }
        $users = \App\Employee::findorfail($id);
        $users->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('user-list');
    }
    
    public function deletUser($id)
    {
        $query= \App\User::where('id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('user-list');
    }
   
}