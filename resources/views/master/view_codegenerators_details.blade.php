@extends('adminlte::page')
@section('title', 'Registration Code')
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
         
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <fieldset disabled="">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Registration Codes</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
               
               
                  <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_school_slug"> School<span class="red-color">*</span> </label>
                                <input type="text" id="" name=""  class="form-control validate[required]" value="{{$data['tabledata'][0]['schooldata']['sc_name']}}">

                        </div>                    
                    </div>  
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_branch_slug"> Branch<span class="red-color">*</span> </label>
                            <input type="text" id="" name=""  class="form-control validate[required]" value="{{$data['tabledata'][0]['branchdata']['sb_location']}}">

                        </div>                    
                    </div> 
                </div>

                 <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_class_id"> Course<span class="red-color">*</span> </label>
                           <input type="text" id="" name=""  class="form-control validate[required]" value="{{$data['tabledata'][0]['classcoursedata']['cl_name']}}">

                        </div>                    
                    </div>  
                        <div class="col-md-6 clearfix">
                        <div class="form-group">
                                <label for="fk_subject_slug"> Subject<span class="red-color">*</span> </label>
                            <input type="text" id="" name=""  class="form-control validate[required]" value="{{$data['tabledata'][0]['subjectdata']['su_name']}}">

                        </div>                    
                    </div> 
                </div>

                <!-- <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                             <label for="noof_codes"> No. Of Code<span class="red-color">*</span> </label>
                            <input type="text" id="" name="" value="{{$data['tabledata'][0]['noof_codes']}}" class="form-control validate[required]">
                        </div>                    
                    </div>  
                        <div class="col-md-6 clearfix">
                                           
                    </div> 
                </div> -->

                
            </div>
        
         

            </div>     
       </fieldset>
        
    <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">              
                        <a href="{{Config('app.url').'/'.'view_codegenerators'}}"><button type="button" class="btn btn-default">Back</button>
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


