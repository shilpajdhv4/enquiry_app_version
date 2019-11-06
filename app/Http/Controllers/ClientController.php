<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Dealer;
use App\Machine;
use Session;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
//       $this->middleware(function ($request, $next) {
//            $this->user= Auth::user();
//
//            return $next($request);
//        });
    }
    
    public function indexHome()
    {         
        return view('home');//,['today_en'=>$today_en]);
    }
    
    
    public function index(){
        return view('master_data.register');
    }

        public function getClientData() {
        $client_data = DB::table('tbl_registration')->orderBy('rid', 'asc')->get();
        return view('master_data.client_data',['client_data' => $client_data]);
    }   
    
    public function getActivate($id,$val){
//        echo $val;
        $data = \App\Admin::findorfail($id);
        $employee = \App\Employee::where(['cid'=>$data->rid])->update(['activate_flag'=>$val]);
//        echo "<pre>";print_r($data);exit;
        $requestdata['activate_flag'] = $val;
        $data->update($requestdata);
    }
}