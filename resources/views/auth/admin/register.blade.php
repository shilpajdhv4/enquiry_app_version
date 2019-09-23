@extends('layouts.admin_login')

@section('content')
<div class="register-box">
  <div class="register-logo">
    <a href="index2.html" style="color:white;"><b>Billing</b> App</a>
  </div>
    <div class="register-box-body">
    <p class="login-box-msg">Registration</p>
                        @isset($url)
                        <form method="POST" action='{{ url("register/$url") }}' aria-label="{{ __('Register') }}">
                        @else
                        <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @endisset
                            @csrf
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" placeholder="Full name" name="name">
        <span class="glyphicon glyphicon-user form-control-feedback"  id="name"></span>
                            
                        </div>
                        <div class="form-group has-feedback">
<!--                            <input type="text" class="form-control" placeholder="Mobile No." name="mobile" id="mobile" pattern="[1-9]{1}[0-9]{9}">
                            <span class="glyphicon glyphicon-user form-control-feedback"  id="name"></span>
                             @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror-->
<!--                            <input id="mobile_no" type="text" pattern="[789][0-9]{9}" class="form-control @error('mobile_no') is-invalid @enderror number number1" name="mobile_no" value="{{ old('mobile_no') }}" required autocomplete="mobile_no">
                                <label id="mobile_no_1" class="error" for="mobile_no"></label>
                                @error('mobile_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror-->
                        </div>

                        <div class="form-group has-feedback">
                            <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                       <div class="form-group has-feedback">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required autocomplete="new-password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group has-feedback">
                             <input type="password" id="password-confirm" class="form-control" placeholder="Retype password" name="password_confirmation" required autocomplete="new-password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
              
                        </div>
                              <div class="row">
        <div class="col-xs-4">
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
      </div><br>
    <div style="text-align:center;">
    <a href="{{ route('login') }}" class="text-center">Log In</a>
    </div>
</form>
    </div>
    
<!--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                   
                </div>
            </div>
        </div>
    </div>
</div>-->
<script type="text/javascript" src="js/plugins/jquery.min.js"></script>
<script type='text/javascript' src='js/plugins/jquery.validate.js'></script>
<script type="text/javascript">
//            $("#btnsubmit").on("click",function(){
$(document).ready(function($){
    $cf = $('#mobile_no');
    $cf.blur(function(e){
        phone = $(this).val();
        phone = phone.replace(/[^0-9]/g,'');
        if (phone.length != 10)
        {
            $("#mobile_no_1").html('Phone number must be 10 digits.');
            $('#mobile_no').val('');
            $('#mobile_no').focus();
        }
    });
});
@endsection