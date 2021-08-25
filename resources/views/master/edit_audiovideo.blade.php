@extends('adminlte::page')
@section('title', 'Edit Audio / Video')
@section('content_header')
    {{-- <h1>Edit Audio / Video</h1> --}}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/validationEngine.jquery.css') }}">
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

<form class="form_validation" method="POST" action ="{{Config('app.url')}}/edit_audiovideo" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Edit Audio / Video</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
                <!-- <div class="row">             
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fk_class_id"> Class Name<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" onchange="get_class_from_type(this.value);" id="fk_type_id" name="fk_type_id" value="">    
                                    <option value="">Select</option>
                                    <option value="1" {{$data['row']['fk_type_id'] == 1?'Selected':''}}>Class</option>   
                                    <option value="2"  {{$data['row']['fk_type_id'] == 2?'Selected':''}}>Course</option>                                
                                  
                            </select>
                        </div>                    
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fk_class_id"> Class Name<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="fk_class_id" name="fk_class_id" onchange="get_subject_from_courseclass(this.value);" > 
                               
                            </select>                            
                        </div>                    
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fk_subject_id"> Subject Name<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="fk_subject_id" name="fk_subject_id"  >                                  
                            </select>                             
                        </div>                    
                    </div>                             
                 
                </div> -->

                <div class="row">             
              

              <div class="col-md-6">
                  <div class="form-group">
                      <label for="fk_class_id"> Subject Name<span class="red-color">*</span> </label>
                      <input type="text" class="form-control" value="{{$data['row']['su_name']}}" > 
                      
                  </div>                    
              </div>  

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="fk_class_id"> Chapter Name<span class="red-color">*</span> </label>
                      <input type="text" class="form-control" value="{{$data['row']['ch_name']}}" > 
                      
                  </div>                    
              </div>                            
           
          </div>

                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="av_name">Short Name<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="av_name" placeholder="Enter Short name" name="av_name" value="{{$data['row']['av_name']}}" >                            
                        </div>                    
                    </div>

                    <div class="col-md-6">
                <div class="form-group">
                <label for="video_type">Select Video Type<span class="red-color">*</span> </label>
                <select class="form-control validate[required]" id="video_type" name="video_type" >          
                <option value="Explanation"  {{$data['row']['video_type'] ==  'Explanation' ? 'selected':''}}  >Explanation</option>
                <option value="Conversation"  {{$data['row']['video_type'] ==  'Conversation' ? 'selected':''}} >Conversation</option>       
                </select>                 
                </div>                    
                </div> 

                                      
                 
                </div>

                <div class="row">

                <div class="col-md-6">
                <div class="form-group">
                <label for="video_type_url_file">Url Type<span class="red-color">*</span> </label>
                        <select class="form-control validate[required]" id="video_type_url_file" onchange="urltype(this.value);" name="video_type_url_file">
                                <option value="file" {{$data['row']['video_type_url_file'] ==  'file' ? 'selected':''}} >File</option>
                                <option value="url"  {{$data['row']['video_type_url_file'] ==  'url' ? 'selected':''}}  >Url</option>
                        </select>                
                </div>                    
                </div> 


                <div class="col-md-6">
                        <div class="form-group">
                            <label for="av_url">Attach File<span class="red-color">*</span> </label>
                            <input type="{{$data['row']['video_type_url_file'] ==  'file' ? 'file':'text'}}" value="{{$data['row']['video_type_url_file'] ==  'file' ? '':$data['row']['av_url']}}" class="form-control" id="av_url" name="av_url" >             
                            <input type="hidden" id="bk_av_url" name="bk_av_url" value="{{$data['row']['av_url']}}" >                    
                        </div>                    
                    </div>
                </div>

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">         
                            <input type="hidden" id="av_id" name="av_id" value="{{$data['row']['av_id']}}" >                        
                           <button type="submit" class="btn btn-success typesubmit" style="margin-top:30px;">Update</button>
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

        $(document ).ready(function() {
            get_class_from_type(<?= $data['row']['fk_type_id'];?>);
            get_subject_from_courseclass(<?= $data['row']['fk_class_id'];?>);          
            $('#fk_class_id').val(<?= $data['row']['fk_class_id'];?>);
            $('#fk_subject_id').val(<?= $data['row']['fk_subject_id'];?>);
        });
    
 function urltype(id){
      // alert(id);
        if($("#video_type_url_file").val() == 'url'){
            $("#av_url").prop('type','text');
        }else{
             $("#av_url").prop('type','file');
        } 
    }

        
</script>

@stop


