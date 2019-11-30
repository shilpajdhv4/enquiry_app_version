@extends('layouts.app')
@section('title', 'Settings')
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
        To Hide Please Tick Mark The Following Checkbox
    </h1>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif

<section class="content">
    <form  id="userForm" method="post" action="{{ url('enq-setting') }}">
{{ csrf_field() }}
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Modules</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="userName" class="col-sm-2 control-label">
                    <input type="checkbox" class="minimal-blue" name="parameter_textbox[]" value="1" <?php if(isset($setting->enq_setting)) { if(in_array(1, $setting->enq_setting)) echo "checked"; } ?>>
                </label> 
                <b>Add Category</b>
              </div>
            <div class="form-group">
                <label for="userName" class="col-sm-2 control-label">
                     <input type="checkbox" class="minimal-blue" name="parameter_textbox[]" value="3" <?php if(isset($setting->enq_setting)) { if(in_array(3, $setting->enq_setting)) echo "checked"; } ?>>
                </label> 
                <b>Add Field</b>
            </div>
                <div class="form-group">
<label for="userName" class="col-sm-2 control-label">
                                 <input type="checkbox" class="minimal-blue" name="parameter_textbox[]" value="5" <?php if(isset($setting->enq_setting)) { if(in_array(5, $setting->enq_setting)) echo "checked"; } ?>>
                            </label> 
                                <b>Add Location</b>
                </div>
                <div class="form-group">
<label for="userName" class="col-sm-2 control-label">
                                 <input type="checkbox" class="minimal-blue" name="parameter_textbox[]" value="7" <?php if(isset($setting->enq_setting)) { if(in_array(7, $setting->enq_setting)) echo "checked"; } ?>>
                            </label> 
                                <b>Employee Master</b>
                </div>
            </div>
          
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Fields</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
               <label for="userName" class="col-sm-2 control-label">
                                <input type="checkbox" class="minimal-blue" name="parameter_textbox[]" value="2" <?php if(isset($setting->enq_setting)) { if(in_array(2, $setting->enq_setting)) echo "checked"; } ?>>
                            </label> 
                                <b>Mobile Number</b>
              </div>
                <div class="form-group">
               <label for="userName" class="col-sm-2 control-label">
                                 <input type="checkbox" class="minimal-blue" name="parameter_textbox[]" value="4" <?php if(isset($setting->enq_setting)) { if(in_array(4, $setting->enq_setting)) echo "checked"; } ?>>
                            </label> 
                                <b>Customer Name</b>
              </div>
                <div class="form-group">
               <label for="userName" class="col-sm-2 control-label">
                                <input type="checkbox" class="minimal-blue" name="parameter_textbox[]" value="6" <?php if(isset($setting->enq_setting)) { if(in_array(6, $setting->enq_setting)) echo "checked"; } ?>>
                            </label> 
                                <b>Follow Up</b>
              </div>
              
            </div>
          
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col (right) -->
      </div>
<div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-success">Save</button>
                        <a href="{{url('enq-setting')}}" class="btn btn-danger" >Cancel</a>
                    </div>
      <!-- /.row -->
      </form>
    </section>

@endsection
