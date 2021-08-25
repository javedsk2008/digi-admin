@extends('adminlte::page')
@section('title', 'User Details')
@section('content_header')
    {{-- <h1>Add Audio / Video</h1> --}}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/validationEngine.jquery.css') }}">
<style>
.optioncls{width:572px !important;}
</style>
@yield('css')
@stop

@section('content')
@if (\Session::has('msg'))
<div class="alert alert-success show fade in" role="alert">
    {{ \Session::get('msg') }}
</div>
@endif

@if (\Session::has('errmsg'))
<div class="alert alert-danger show fade in" role="alert">
        {{ \Session::get('errmsg') }}
    </div>
@endif
  <fieldset disabled>
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">User Details</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_role_id"> Role<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="fk_role_id" name="fk_role_id">    
                                    <option value="">Select Role {{$data['row']['fk_role_id']}}</option>
                                    @foreach($data['roletable'] as $rdata)
                                    <option value="{{$rdata['ro_id']}}" {{$data['row']['fk_role_id'] == $rdata['ro_id']?'selected':''}} >{{$rdata['ro_name']}}</option>   
                                    @endforeach                                 
                            </select>
                        </div>                    
                    </div>

                    <div class="col-md-6" hidden>
                        <div class="form-group">
                            <label for="regi_code">Registration code<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="regi_code" name="regi_code" value="{{$data['row']['regi_code']}}" placeholder="Enter Registartion Code" > 
                        </div>                    
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_name">Full Name<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="full_name" name="full_name" value="{{$data['row']['full_name']}}" placeholder="Enter Full Name" > 
                        </div>                    
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Phone Number<span class="red-color">*</span> </label>
                            <input type="text" readonly class="form-control validate[required,custom[number],minSize[10],maxSize[10]]" id="phone_number" name="phone_number"  value="{{$data['row']['phone_number']}}" placeholder="Enter Phone Number" > 
                        </div>                    
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email<span class="red-color">*</span> </label>
                            <input type="text" readonly class="form-control validate[required,custom[email]]" id="email" name="email" value="{{$data['row']['email']}}" placeholder="Enter Email" > 
                        </div>                    
                    </div>

                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="password" name="password" value="{{$data['row']['password']}}" placeholder="Enter Password" > 
                        </div>                    
                    </div> -->

                    <div class="col-md-6" hidden>
                        <div class="form-group">
                            <label for="dob">Date of Birth<span class="red-color"></span> </label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" id="datepicker" name="dob" class="form-control datepicker datetimepicker-input"  placeholder="Select Date of Birth" data-target="#reservationdate"/>
                        <!-- <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div> -->
                    </div>
                        </div>                    
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">Gender<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="gender" name="gender"  > 
                            <option value="">Select Gender</option>
                            <option value="M"  {{$data['row']['gender'] == "M"?'selected':''}}>Male</option>   
                            <option value="F"  {{$data['row']['gender'] == "F"?'selected':''}}>Female</option>   
                            <select>
                        </div>                    
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_school_id"> School<span class="red-color">*</span> </label>
                            <select class="form-control validate[required] show_on_stud_select" id="fk_school_id" name="fk_school_id">    
                                    <option value="">Select School</option>
                                    @foreach($data['schooltable'] as $rdata)
                                    <option value="{{$rdata['sc_id']}}" {{$data['row']['fk_school_id'] == $rdata['sc_id']?'selected':''}}  >{{$rdata['sc_name']}}</option>   
                                    @endforeach                                 
                            </select>
                        </div>                    
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_class_id"> Class<span class="red-color">*</span> </label>
                            <select class="form-control validate[required] show_on_stud_select" id="fk_class_id" name="fk_class_id">    
                                    <option value="">Select Class</option>
                                    @foreach($data['classtable'] as $cls)
                                    @if($cls->type == '1')
                                    <option value="{{$cls['cl_id']}}" {{$data['row']['fk_class_id'] == $cls['cl_id']?'selected':''}}   >{{$cls['cl_name']}}</option> 
                                    @endif
                                    @endforeach                                 
                            </select>
                        </div>                    
                    </div>


               
            </div>
            </div>
        
            <!-- /.box-body -->
            <!-- <div class="box-footer">
                <button type="submit" class="btn btn-primary">Add Class</button>
            </div>  -->

            </div>     
  </fieldset>

 <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">              
                        <a href="{{Config('app.url').'/'.'view_user'}}"><button type="button" class="btn btn-default">Back</button>
                        </div>                                    
                    </div>                
                </div>
            
        

@if (\Session::has('msg'))
<div class="alert alert-success show fade in" role="alert">
    {{ \Session::get('msg') }}
</div>
@endif

@if (\Session::has('errmsg'))
<div class="alert alert-danger show fade in" role="alert">
        {{ \Session::get('errmsg') }}
    </div>
@endif

@stop



@section('js')
<script src="{{ asset('js/common_js.js') }}"></script>

<script>
  
</script>

@stop


