@extends('adminlte::page')
@section('title', 'Chapter Details')
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
             <fieldset disabled>
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Chapter Details</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">            
            <div class="box-body">              

            <div class="row">
                 <div class="col-md-12">
                <div class="form-group">
                <label for="ch_name">Subject Name<span class="red-color">*</span> </label>
                <input type="text" class="form-control validate[required]" id="ch_name" name="ch_name" value="{{$_GET['su_name']}}" placeholder="Enter Chapter Name" > 
                </div>                    
                </div>

                
            </div>

            <div class="row">
                 <div class="col-md-12">
                <div class="form-group">
                <label for="ch_name">Chapter Name<span class="red-color">*</span> </label>
                <input type="text" class="form-control validate[required]" id="ch_name" name="ch_name" value="{{$data['row']['ch_name']}}" placeholder="Enter Chapter Name" > 
                </div>                    
                </div>

                <div class="col-md-12">
                <div class="form-group">
                <label for="ch_description">Description<span class="red-color">*</span> </label>
                <textarea class="form-control validate[required]" id="ch_description" name="ch_description"  placeholder="Enter Description" >{{$data['row']['ch_description']}}</textarea> 
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
                        <a href="{{Config('app.url').'/'.'view_chapter'}}"><button type="button" class="btn btn-default">Back</button>
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


