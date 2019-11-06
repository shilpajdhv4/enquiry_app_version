<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class EnquiryLocationController extends Controller
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
    
     
    public function listLocation(){
        $location = \App\EnquiryLocation::where(['user_id'=>$this->admin->rid,'is_active'=>0])->get();
        return view('enq_location.enq_location',['location'=>$location]);
    }
  
    public function addLocation(){
        return view('enq_location.add_location');
    }
    
    public function saveLocation(Request $request){
        $requestData = $request->all();
        $requestData['user_id'] = $this->admin->rid;
        
        \App\EnquiryLocation::create($requestData);
        Session::flash('alert-success', 'Added Successfully.');
        return redirect('enq_location_list');
    }
   
    public function editLocation(){
        $id = $_GET['id'];
        $location = \App\EnquiryLocation::where(['loc_id'=>$id])->first();
        return view('enq_location.edit_location',['location'=>$location]);
    }
    
    public function updateLocation(Request $request){
        $requestData = $request->all();
        $id = $requestData['loc_id'];
        $location = \App\EnquiryLocation::where(['loc_id'=>$id])->first();
        $location->update($requestData);
        Session::flash('alert-success', 'Updated Successfully.');
        return redirect('enq_location_list');
    }
    
    public function deleteLocation($id){
        $query= \App\EnquiryLocation::where('loc_id', $id)->update(['is_active' => 1]);
        Session::flash('alert-success', 'Deleted Successfully.');
        return redirect('enq_location_list');
    }
    
}