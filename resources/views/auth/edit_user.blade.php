@extends('layouts.app')
@section('title', 'Edit user')
@section('content')
<style>
    .error{
        color:red;
    }
</style>
<?php 
if(Auth::guard('employee')->check()){
   $cid = Auth::guard('employee')->user()->cid;
   $client_loc = App\Admin::select('location')->where(['rid'=>$cid])->first();
   $location = $client_loc->location;
   $logeed_id = Auth::guard('employee')->user()->id; 
   $role = Auth::guard('employee')->user()->role;
}else if(Auth::guard('admin')->check()){
   $logeed_id = Auth::guard('admin')->user()->rid; 
   $location = Auth::guard('admin')->user()->location; 
}else if(Auth::guard('web')->check()){
   $logeed_id = Auth::guard('web')->user()->id; 
}
?>
<section class="content-header">
      <h1>
          Edit Employee
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('user_mgt')}}"><i class="fa fa-dashboard"></i>Employee</a></li>
        <li class="active">Edit Employee</li>
      </ol>
    </section>
<section class="content">
<div class="row">
 <div class="col-md-8">
          <div class="box" style="border-top: 3px solid #ffffff;">
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
            {!! Form::model($userData,[
                        'method' => 'PUT',
                        'url' => ['update-user',$userData->id],
                        'class'=> 'form-horizontal',
                        'id'=>'orderForm'
                    ]) !!}
                {{ csrf_field() }}
              <div class="box-body">
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Employee Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" placeholder="Employee Name" value="{{$userData->name}}" name="name" required >
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="company" class="col-sm-4 control-label">Role</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" style="width: 100%;" name="role" required>
                                    <option value="">-- Select Role -- </option>
									<?php if($location == "multiple") { 
                                        if(Auth::guard('admin')->check()){ ?>
                                            <option value="1"<?php if($userData->role == "1") echo "selected"; ?>>Admin</option>
                                    <?php } }?>
                                    <option value="2"<?php if($userData->role == "2") echo "selected"; ?>>Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email" placeholder="Email" value="{{$userData->email}}" name="email" required >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" placeholder="Password" value="" name="password"  >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Mobile No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mobile_no" placeholder="Mobile No" value="{{$userData->mobile_no}}" name="mobile_no" required >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Address</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="address" placeholder="Address" name="address" required value="{{$userData->address}}">
                            </div>
                        </div>
						<?php // if($location == "multiple") { 
//                                        if(Auth::guard('admin')->check()){ ?>
                                    
                        <div class="form-group" >
                        <label for="company" class="col-sm-4 control-label">Location</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" style="width: 100%;" name="lid" required>
                                    <option value="">-- Select Location -- </option>
                                    @foreach($city as $c)
                                    <option value="{{$c->loc_id}}" <?php if($userData->lid == $c->loc_id) echo "selected"; ?>>{{$c->loc_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <?php // } }?>
                    </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update</button>
                  <a href="{{url('user-list')}}" class="btn btn-danger" >Cancel</a>
              </div>
            </form>
          </div>
        </div>   
</div>
  </section> 
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
 $(document).ready(function(){
    $('.select2').select2() 
 });
</script>
@endsection
