@extends('adminlte::page')
@section('title', 'Edit Fill In The Blank')
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

<form class="form_validation" method="POST" action ="{{Config('app.url')}}/edit_fillin_blanks" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Edit Fill In The Blank</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body"> 

                <div class="row">                     
                    <div class="col-md-12">
                    <div class="form-group">
                    <label for="question">Question<span class="red-color">*</span> </label>
                    <textarea class="form-control  validate[required]" id="question" name="question" placeholder="Enter Question"  >{{$data['rowques']['question']}}</textarea>                          
                    </div>                    
                    </div>
                </div>
                            
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                    <label for="optiona">Option A Answer<span class="red-color">*</span> </label>
                    <input type="text" class="form-control optioncls validate[required]"  value="{{$data['rowsubques']['op_a']}}" id="optiona" name="optiona" placeholder="Enter Option A"  >                          
                    </div>                    
                    </div>

                    <div class="col-md-6">
                    <div class="form-group">
                    <label for="optionb">Option B Answer<span class="red-color">*</span> </label>
                    <input type="text" class="form-control optioncls validate[required]"  value="{{$data['rowsubques']['op_b']}}"  id="optionb" name="optionb"  placeholder="Enter Option B"  > 
                    </div>                    
                    </div>    
                </div>    

                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                    <label for="optionc">Option C Answer<span class="red-color">*</span> </label>
                    <input type="text" class="form-control optioncls validate[required]" value="{{$data['rowsubques']['op_c']}}"  id="optionc" name="optionc"  placeholder="Enter Option C"  > 
                    </div>                    
                    </div>  

                    <div class="col-md-6">
                    <div class="form-group">
                    <label for="marks">Marks<span class="red-color">*</span> </label>
                    <input type="text" class="form-control optioncls validate[required]" value="{{$data['rowques']['marks']}}"  id="marks" name="marks"  placeholder="Enter Marks" >                          
                    </div>                    
                    </div>    
                </div>  

                   <div class="row">
                    
                    <div class="col-md-6 clearfix">
                    <div class="form-group">
                    <label for="q_audio">Marks<span class="red-color"></span> </label>
                    <input type="file" class="form-control optioncls"   id="q_audio" name="q_audio"   >                          
                    <input type="hidden" value="{{$data['rowques']['q_audio']}}" name="bk_q_audio">
                     </div>                    
                    </div>
                </div> 

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">         
                            <input type="hidden" id="id" name="id" value="{{$data['rowques']['q_id']}}" >                        
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

    
        
</script>

@stop


