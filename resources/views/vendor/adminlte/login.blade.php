

@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop
<style>
img{width:35%;}
#bg {
  position: fixed; 
  top: -50%; 
  left: -50%; 
  width: 200%; 
  height: 200%;
z-index: -1;
}
#bg img {
  position: absolute; 
  top: 0; 
  left: 0; 
  right: 0; 
  bottom: 0; 
  margin: auto; 
  min-width: 50%;
  min-height: 50%;
}

.newdivbg{
   /* Background pattern from Toptal Subtle Patterns */
   background-image: url("https://www.bhartiyaacademy.com/digiteachertest/public/img/sc5.jpg");
   height: 800px;
   width: 100%;

}

.welcome{
   /* Background pattern from Toptal Subtle Patterns */
   
   font-weight:bold;
   text-align:center;
   margin-top:90px;
  margin-bottom:20px;
}

.login-logo{
    margin-top:100px;
     margin-bottom:-75px !important;
}
</style>
@section('body_class', 'login-page')

@section('body')
    <!-- <div id="bg">
        <img src="{{ asset('img/sc5.jpg') }}">
    </div> -->
<div class="row">
<div class="col-md-8  newdivbg">
    

</div>
<div class="col-md-4" style="background-color:#ffffff;">

            <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
            {{-- <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><b style="color: #10428c;">TCIS</b> CMA</a> --}}
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body" style="">
           <h1 class="welcome">Welcome Back</h1>

@if (isset($_GET['cp']))
@if ($_GET['cp'] == 0)
<div class="alert alert-success show fade in" role="alert">
    Something Wrong Please Try Again.
</div>
@endif
@if ($_GET['cp'] == 1)
<div class="alert alert-success show fade in" role="alert">
    Passwrd Updated Suceessfully PLease Login.
</div>
@endif
@endif


            <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" style="border-radius:5.5px;" value="{{ old('email') }}"
                           placeholder="EMAIL / PHONE NUMBER">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="PASSWORD" style="border-radius:5.5px;"   >
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            
                <div class="row">
                    <div class="col-12">
                        <button type="submit" style="border-radius:55.5px;width:150px;margin-left:100px; font-weight:bold;"  class="btn btn-success btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
                <a href="forget_passwod" ><h5 style="margin-left:100px; margin-top:20px;color:black;  font-weight:bold;" >Forgot Password</h5></a>
            </form>
            <div class="auth-links">
                <!-- <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}"
                   class="text-center"
                >{{ trans('adminlte::adminlte.i_forgot_my_password') }}</a> -->
                <br>
            </div>
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
</div>
</div>
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            localStorage.setItem('active_first_level','');
            localStorage.setItem('active_second_level','');
            localStorage.setItem('active_third_level','');
        });
    </script>
    @yield('js')
@stop
