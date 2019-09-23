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
         $this->middleware('auth');
    }
    
    public function validateEmail($id) {
        $id = trim($id);
        if (\App\User::where('email', $id)->exists()) {
            echo "Email Already exists!";
        }
    }
   
   protected function saveUser(Request $request)
    {
        $requestData = $request->all();
        $requestData['password'] = bcrypt($requestData['password']);
        User::create($requestData);
        
        return redirect('user-list');
    }
    
    public function userList(){
        $userData = User::where(['is_active'=>0])->get();
        return view('auth.user_list',['userData'=>$userData]);
    }
  
    public function userEdit(){
        $id = $_GET['id'];
        $userData = User::findorfail($id);
        return view('auth.edit_user',['userData'=>$userData]);
    }
    
    public function updateUser($id,Request $request)
    {
        $requestData = $request->except('password');
//        echo "<pre>";print_r($requestData);exit;
        if ($request->password)
            $requestData['password'] = bcrypt($request->password);
        $users = \App\User::findorfail($id);
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