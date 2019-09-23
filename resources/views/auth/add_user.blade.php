@extends('layouts.app')
@section('title', 'Add User')
@section('content')
<section class="content-header">
      <h1>
          Add User
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add User</li>
      </ol>
    </section>
   <section class="content">
<div class="row">
 <div class="col-md-12">
          <div class="box" style="border-top: 3px solid #ffffff;">
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
            <form class="form-horizontal" id="userForm" method="post" action="{{ url('add-user') }}">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="userName" class="col-sm-2 control-label">Name</label>

                  <div class="col-sm-4">
                      <input type="text" class="form-control" id="userName" placeholder="Name" name="name" required>
                  </div>
                   <label for="company" class="col-sm-2 control-label">Organization</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="company" placeholder="Organization" name="organization" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="gst" class="col-sm-2 control-label">GST No'</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="gst" placeholder="GST" name="gst_no" required>
                  </div>
                  <label for="gst" class="col-sm-2 control-label">PAN No'</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="pan_card" placeholder="PAN" name="pan_no" required>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-2 control-label">Address</label>  
                    <div class="col-sm-4">
                    <textarea class="form-control" rows="3" placeholder="Enter Address..." name="address"></textarea>   
                    </div>
                   <label for="gst" class="col-sm-2 control-label">Contact No'</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="contact" placeholder="Contact No" name="contact_no" required>
                  </div>
                </div>
                  <div class="form-group">
                   <label for="gst" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-4">
                      <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                  </div> 
                       <label for="gst" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                  </div>
                  </div>
                  <div class="form-group">
                <label class="col-sm-2 control-label">Type</label>
                <div class="col-sm-4">
                <select class="form-control select2" style="width: 100%;" name="type" required>
                 <option value="">-- Select Type -- </option>
                  @foreach($type_data as $t)
                  <option value="{{$t->type_id}}">{{$t->type_name}}</option>
                 @endforeach
                </select>
                </div>
                          <label class="col-sm-2 control-label">Category</label>
                <div class="col-sm-4">
                <select class="form-control select2" style="width: 100%;" name="category" required>
                  <option value="">-- Select Category -- </option>
                  @foreach($category_data as $t)
                  <option value="{{$t->cat_id}}">{{$t->cat_name}}</option>
                 @endforeach
                </select>
                </div>
              </div>
                  
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Submit</button>
                  <a href="{{url('user_mgt')}}" class="btn btn-danger" >Cancel</a>
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
