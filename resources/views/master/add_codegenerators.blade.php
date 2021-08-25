@extends('adminlte::page')
@section('title', 'Add Code')
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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/add_codegenerators" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Add Codes</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
               
               
                  <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_school_slug"> School<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="fk_school_slug" name="fk_school_slug" onchange="get_branch_from_school(this.value);">    
                                    <option value="">Select School</option>
                                    @foreach($data['schooltable'] as $rdata)
                                    <option value="{{$rdata['slug']}}">{{$rdata['sc_name']}}</option>   
                                    @endforeach                                 
                            </select>
                        </div>                    
                    </div>  
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_branch_slug"> Branch<span class="red-color">*</span> </label>
                            <select class="form-control" id="fk_branch_slug" name="fk_branch_slug" onchange="rolebasehideshow(this.value);">    
                                    <option value="">Select Branch</option>
                                                            
                            </select>
                        </div>                    
                    </div> 
                </div>

                 <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_class_id"> Course<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="fk_class_id" name="fk_class_id"  onchange="get_bookorsubject_from_course(this.value);" >    
                                    <option value="">Select Course</option>
                                    @foreach($data['classtable'] as $cls)
                                    @if($cls->type == '2')
                                    <option value="{{$cls['cl_id']}}">{{$cls['cl_name']}}</option> 
                                    @endif
                                    @endforeach                               
                            </select>
                        </div>                    
                    </div>  
                        <div class="col-md-6 clearfix">
                        <div class="form-group">
                                <label for="fk_subject_slug"> Subject<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="fk_subject_slug" name="fk_subject_slug">    
                                    <option value="">Select Subject</option>
                                                            
                            </select>
                        </div>                    
                    </div> 
                </div>

                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                             <label for="noof_codes"> No. Of Code<span class="red-color">*</span> </label>
                            <input type="text" id="noof_codes" name="noof_codes" placeholder="Enter Number Of Codes" class="form-control validate[required]">
                        </div>                    
                    </div>  
                        <div class="col-md-6 clearfix">
                                           
                    </div> 
                </div>

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">                       
                        <button type="submit" class="btn btn-success typesubmit pull-right float-left" >Submit</button>
                        </div>                                    
                    </div>                
                </div>
            </div>
        
         

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
   function get_branch_from_school(fk_school_slug){
             // alert(fk_school_slug);
     $.ajax({
         headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         type: "post",
         url:"get_branch_from_school",
         data: {fk_school_slug:fk_school_slug},
         datatype: "text",
         async: false,
         success: function (data) {
             
            var selOpts = "<option value=''>Select Branch</option>";
            $.each(data, function(k, v)
            {
                    selOpts += "<option value='"+v['slug']+"'>"+v['sb_location']+"</option>";
            });
            $("#fk_branch_slug").html(selOpts);
            //alert(selOpts);
 
         }
     });
        }

         function get_bookorsubject_from_course(fk_class_id){
            // alert(fk_school_slug);
     $.ajax({
         headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         type: "post",
         url:"get_bookorsubject_from_course",
         data: {fk_class_id:fk_class_id},
         datatype: "text",
         async: false,
         success: function (data) {
            // alert(data);
            var selOpts = "<option value=''>Select Subject</option>";
            $.each(data, function(k, v)
            {
                    selOpts += "<option value='"+v['su_id']+"'>"+v['su_name']+"</option>";
            });
            $("#fk_subject_slug").html(selOpts);
            //alert(selOpts);
 
         }
     });
        }
</script>

@stop


