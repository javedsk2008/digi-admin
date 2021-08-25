@extends('adminlte::page')
@section('title', 'Add Chapter')
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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/add_chapter" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Add Chapter</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">            
            <div class="box-body">              

            <div class="row">
            <div class="col-md-6">
                  <div class="form-group">
                      <label for="">Subject Name<span class="red-color">*</span> </label>
                      <input type="text" class="form-control " id="" name="" value="{{$data['row']['su_name']}}" > 
                  </div>                    
              </div>

              
              </div>

              <div class="row">
              <!-- <div class="col-md-6">
                  <div class="form-group">
                      <label for="ch_name">Chapter Name<span class="red-color">*</span> </label>
                      <input type="text" class="form-control validate[required]" id="ch_name" name="ch_name" placeholder="Enter Chapter Name" > 
                  </div>                    
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="ch_description">Description<span class="red-color">*</span> </label>
                      <textarea class="form-control validate[required]" id="ch_description" name="ch_description" placeholder="Enter Description" ></textarea> 
                  </div>                    
              </div> -->
              </div>

             

              
                <div class="row">             
                    <div class="addmorecode">                                                   
                    <input type="hidden" id="lastcount" value="0">
                    <section id="wrapper22"></section>
                    <button style="margin-left:15px;margin-top:30px;" class="btn btn-info" type="button" id="myBtn">Add Chapter</button>
                    </div>
                 
                </div>

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">    
                        <input type="hidden" id="fk_subject_id" name="fk_subject_id" value="{{$_GET['id']}}">                   
                        <button type="submit" class="btn btn-success typesubmit pull-right float-right" style="margin-top:10px;">Submit</button>
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
   


   var countmore = 1;
$('#myBtn').click(function(){
//alert();
    
   var lastcount =  $('#lastcount').val();
   
   $('#lastcount').val(countmore)
    var div = $('<div></div>');
    var design = '';
  
design += '<div class="row singleaddon'+countmore+'">';  


design += '<div class="row" style="margin-left:30px;border:1px solid black;width:1209px;padding-top:5px;">';  

design += '<div class="col-md-6">';
design += '<div class="form-group">';
design += '<label for="ch_name">Chapter Name<span class="red-color">*</span> </label>';
design += '<input type="text" class="form-control validate[required]" id="ch_name'+countmore+'" name="ch_name[]" placeholder="Enter Chapter Name" >'; 
design += '</div>';                    
design += '</div>';

design += '<div class="col-md-6">';
design += '<div class="form-group">';
design += '<label for="ch_description">Description<span class="red-color">*</span> </label>';
design += '<textarea class="form-control validate[required]" id="ch_description'+countmore+'" name="ch_description[]" placeholder="Enter Description" ></textarea>'; 
design += '</div>';                    
design += '</div>';

design += '<div class="hideremove'+countmore+' allremovehide"><a><i onclick="removediv('+countmore+');" class="fa fa-minus-circle" style="font-size: 24px;color: red; margin-left:590px;"></i></a></div>';  

design += '</div>';  

design += '</div>';  

                 
    div.html(design);    
    div.appendTo('#wrapper22');
   
    countmore = countmore + 1;

    

});


function removediv(id){
   
   $('.singleaddon'+id).html('');

  
}
</script>

@stop


