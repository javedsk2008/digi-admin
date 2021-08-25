@extends('adminlte::page')
@section('title', 'Add User')
@section('content_header')
    {{-- <h1>Add Audio / Video</h1> --}}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/validationEngine.jquery.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<style>
.optioncls{width:572px !important;}
.select2-container--default .select2-selection--multiple .select2-selection__choice{

  background-color:#367fa9 !important;
}
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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/add_user" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Add User</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_role_id"> Role<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="fk_role_id" name="fk_role_id" onchange="rolebasehideshow(this.value);">    
                                    <option value="">Select Role</option>
                                    @foreach($data['roletable'] as $rdata)
                                    <option value="{{$rdata['ro_id']}}">{{$rdata['ro_name']}}</option>   
                                    @endforeach                                 
                            </select>
                        </div>                    
                    </div>

                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_name">Full Name<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="full_name" name="full_name" placeholder="Enter Full Name" > 
                        </div>                    
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Phone Number<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required,custom[number],minSize[10],maxSize[10]]" id="phone_number" name="phone_number" placeholder="Enter Phone Number" > 
                        </div>                    
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email<span class="red-color">*</span> </label> 
                            <input type="text" class="form-control validate[required,custom[email]]" onkeyup="chech_onkeyup(this.value,'master_admin','email','email_msg','ma_delete');" id="email" name="email" placeholder="Enter Email" > 
                            <span class="email_msg" style="color:red;"><span>
                        </div>                    
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password<span class="red-color">*</span> </label>
                            <input type="password" class="form-control validate[required]" id="password" name="password" placeholder="Enter Password" > 
                        </div>                    
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">Gender<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="gender" name="gender"  > 
                            <option value="">Select Gender</option>
                            <option value="M">Male</option>   
                            <option value="F">Female</option>   
                            <select>
                        </div>                    
                    </div>

                    <div class="col-md-6 schoolside"  style="display:none;" >
                        <div class="form-group">
                            <label for="fk_school_id"> School<span class="red-color">*</span> </label>
                            <select class="form-control validate[required] show_on_stud_select" id="fk_school_id" name="fk_school_id">    
                                    <option value="">Select School</option>
                                    @foreach($data['schooltable'] as $rdata)
                                    <option value="{{$rdata['sc_id']}}">{{$rdata['sc_name']}}  (  {{$rdata['sc_city']}}  )</option>   
                                    @endforeach                                 
                            </select>
                        </div>                    
                    </div>

                  
            <div class="col-md-6 classside"  style="display:none;" >
                <div class="form-group">
                  <label>Class Name</label>
                  <div class="select2-purple">
                    <select class="select2 all_course_class all_class" multiple="multiple" onchange="all_course_class();" data-placeholder="Select a Class" data-dropdown-css-class="select2-purple" style="width: 100%;">
                          @foreach($data['classtable'] as $cls)
                          @if($cls->type == '1')
                          <option value="{{$cls['cl_id']}}" >{{$cls['cl_name']}}</option> 
                          @endif
                          @endforeach  
                    </select>
                  </div>
                </div>              
              </div>

              <!-- <div class="col-md-6">
                <div class="form-group">
                  <label>Course Name</label>
                  <div class="select2-purple">
                    <select class="select_course2 all_course_class all_course" multiple="multiple" onchange="all_course_class();" data-placeholder="Select a Course" data-dropdown-css-class="select2-purple" style="width: 100%;">
                          @foreach($data['classtable'] as $cls)
                          @if($cls->type == '2')
                          <option value="{{$cls['cl_id']}}">{{$cls['cl_name']}}</option> 
                          @endif
                          @endforeach  
                    </select>
                  </div>
                </div>              
              </div> -->
             

                    
                    <div class="col-md-6" hidden>
                        <div class="form-group">
                            <label for="dob">Date of Birth<span class="red-color"></span> </label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" id="datepicker" class="form-control datepicker datetimepicker-input"  placeholder="Select Date of Birth" data-target="#reservationdate"/>
                        <!-- <div class="input-group-append datetimepicker-input" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div> -->
                    </div>
                        </div>                    
                    </div>

                  

                    <div class="col-md-6" hidden>
                        <div class="form-group">
                            <label for="fk_class_id"> Class<span class="red-color">*</span> </label>
                            <select class="form-control validate[required] show_on_stud_select" id="fk_class_id" name="fk_class_id">    
                                    <option value="">Select Class</option>
                                    @foreach($data['classtable'] as $cls)
                                    @if($cls->type == '1')
                                    <option value="{{$cls['cl_id']}}">{{$cls['cl_name']}} </option> 
                                    @endif
                                    @endforeach                                 
                            </select>
                        </div>                    
                    </div>

                    <div class="col-md-6" hidden>
                        <div class="form-group">
                            <label for="regi_code">Registration code<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="regi_code" name="regi_code" placeholder="Enter Registartion Code" > 
                        </div>                    
                    </div>

                    <div class="col-md-6 clearfix"></div>

                   

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">           
                        <input type="hidden" id="str_fk_class_id" name="str_fk_class_id" value="">                      
                        <button type="submit" class="btn btn-success typesubmit pull-right float-right" style="margin-top:3px;margin-left:10px;">Submit</button>
                        </div>                                    
                    </div>                
                </div>
            </div>
            </div>
        
            <!-- /.box-body -->
            <!-- <div class="box-footer">
                <button type="submit" class="btn btn-primary">Add Class</button>
            </div>  -->

            </div>     
       
        
    </form>


            
        

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
      function rolebasehideshow(selectedval){

          if(selectedval == 5  || selectedval == 6){
            $('.schoolside').show();
          }else{
            $('.schoolside').hide();
          }

        if(selectedval == 6){
            $('.classside').show();
           // $('.schoolside').show();
          }else{
            $('.classside').hide();
            // $('.schoolside').hide();
          }


          
      }
  
function all_course_class(id){
  
  allcourse = [];var allcourse_count = 0;
  var couse1 = $('.all_course').map(function (_, el) {
    allcourse[allcourse_count] = $(el).val();
    allcourse_count++;
  }).get();
  
  allclass = [];var allclass_count = 0;
  var couse2 = $('.all_class').map(function (_, el) {
    allclass[allclass_count] = $(el).val();
    allclass_count++;
  }).get(); 
  var alldata  = allclass.concat(allcourse);
  var alldataconcat = allclass.concat(allcourse)
  var alldata = alldataconcat.filter((item, pos) => alldataconcat.indexOf(item) === pos);
  var post_commaseprated_id = alldata.join();
  $("#str_fk_class_id").val(post_commaseprated_id);
}
</script>

@stop


