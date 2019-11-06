@extends('layouts.app')
@section('title', 'Add Owner')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>

<section class="content-header">
    <h1>
        Add Enquiry Template
    </h1>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('add_enq_template') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Enquiry template Name<span style="color:red"> * </span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  placeholder="Template Name" value="" id="temp_name" name="temp_name"  required >
                            </div>
                           
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control"  placeholder="Description" value="" name="temp_description"  ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-4 control-label">Assign To Location</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" multiple="multiple" style="width: 100%;" name="loc_id[]" id="loc_id">
                                    <option value="">-- Select Location --</option>
                                    @foreach($location as $loc)
                                    <option value="{{$loc->loc_id}}">{{$loc->loc_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-success">Save</button>
                        <a href="{{url('enq_templates')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
        </div>   
    </div>
</section>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">  
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="js/jquery.steps.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
   
$(document).ready(function () {
    $('select').select2();
});
</script>
@endsection
