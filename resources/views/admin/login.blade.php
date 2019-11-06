@extends('layouts.login')
@section('content')
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<div class="login-box">
  <div class="login-logo">
    <a href="/" style="color:white;"><b>Enquiry</b> App</a>
  </div>
<!--    <div class="" style="text-align: center;">
        <img src="dist/img/logo3_new.png" class="img-circle" alt="User Image">
    </div>-->
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Log in to start your session</p>                        
                        <form method="POST" action="{{ url('admin-login') }}" aria-label="{{ __('Login') }}">
                            @csrf
<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="tel" id="reg_mobileno" name="reg_mobileno" onkeypress="return phoneno(event)" class="form-control" placeholder="Mobile">
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>
    <div class="form-group has-feedback"></div>
              <!-- /.row -->
        <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
        </div>
        <div class="col-xs-6">
          <a href="{{url('client-register')}}" class="btn btn-primary btn-block btn-flat">Register</a>
        </div>
        </div>
    </form>
  </div>
</div>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script>
    function check(cid)
    {
            $.ajax({
        url: 'check_location',
        type: "get",
        data: {cid:cid},
        success: function(reportdata) { 
                alert(reportdata);
            }
        });
    }
    
    function phoneno(){          
            $('#reg_mobileno').keypress(function(e) {
                var length = jQuery(this).val().length;
       if(length > 9) {
            return false;
       } else if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
       } else if((length == 0) && (e.which == 48)) {
            return false;
       }
            });
    }
</script>
@endsection