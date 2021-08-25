@extends('adminlte::page')
@section('title', 'Add True False')
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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/add_truefalse" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Add True False</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
                <!-- <div class="row">             
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fk_class_id"> Class Name<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" onchange="get_class_from_type(this.value);" id="fk_type_id" name="fk_type_id">    
                                    <option value="">Select</option>
                                    <option value="1">Class</option>   
                                    <option value="2">Course</option>                                
                                  
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
                            <label for="fk_class_id"> Subject Name<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="fk_subject_id" name="fk_subject_id"  > 
                                
                            </select> 
                            
                        </div>                    
                    </div>  
                </div> -->
                <div class="row">   
                    <div class="col-md-4">
                            <div class="form-group">
                                <label for="fk_class_id"> Subject Name<span class="red-color">*</span> </label>
                                <input type="text" class="form-control" value="{{$data['row']['su_name']}}" > 
                                <input type="hidden" name="fk_subject_id" value="{{$data['row']['fk_subject_id']}}" > 

                            </div>                    
                    </div> 
                    <div class="col-md-4">
                    <div class="form-group">
                                <label for="fk_class_id"> Chapter Name<span class="red-color">*</span> </label>
                                <input type="text" class="form-control" value="{{$data['row']['ch_name']}}" > 
                                <input type="hidden" name="fk_chapter_id" value="{{$data['row']['ch_id']}}" > 
                            </div>                   
                    </div> 
                </div>
              
                <div class="row">             
                    <div class="addmorecode">                                                   
                    <input type="hidden" id="lastcount" value="0">
                    <section id="wrapper22"></section>
                    <button style="margin-left:15px;margin-top:30px;" class="btn btn-info" type="button" id="myBtn">Add Question</button>
                    </div>
                 
                </div>

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">                       
                        <button type="submit" class="btn btn-success typesubmit pull-right float-right" style="margin-top:-75px;">Submit</button>
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

design += '<div class="col-md-12">';
design += '<div class="form-group">';
design += '<label for="question'+countmore+'">Question<span class="red-color">*</span> </label>';
design += '<textarea class="form-control  validate[required]" id="question'+countmore+'" name="question[]" placeholder="Enter Question"  ></textarea>';                          
design += '</div>';                    
design += '</div>';

design += '<div class="col-md-6">';
design += '<div class="form-group">';
design += '<label for="answer'+countmore+'">Answer<span class="red-color">*</span> </label>';
design += '<select class="form-control optioncls  validate[required]" id="answer'+countmore+'" name="answer[]">';
design += '<option value="true">True</option>';
design += '<option value="false">False</option>';
design += '</select>';                            
design += '</div>';                    
design += '</div>'; 

design += '<div class="col-md-6">';
design += '<div class="form-group">';
design += '<label for="marks'+countmore+'">Marks<span class="red-color">*</span> </label>';
design += '<input type="text" class="form-control optioncls validate[required]" id="marks'+countmore+'" name="marks[]"  placeholder="Enter Marks" >';                          
design += '</div>';                    
design += '</div>';

design += '<div class="col-md-6 clearfix">';
design += '<div class="form-group">';
design += '<label for="q_audio'+countmore+'">Audio<span class="red-color">*</span> </label>';
design += '<input type="file" class="form-control optioncls validate[required]" id="q_audio'+countmore+'" name="q_audio[]"  >';                          
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

function ques_type(id){
alert(id);
var design = '';
design += '<div class="row">';             
design += '<div class="col-md-4">';
design += '<div class="form-group">';
design += '<label for="fk_class_id"> Class Name<span class="red-color">*</span> </label>';
design += '<select class="form-control validate[required]" onchange="ques_type(this.value);" id="ques_type" name="ques_type[]">';    
design += '<option value="">Select</option>';
design += '<option value="1">MCQ</option> '; 
design += '<option value="2">Fill In The Blanks</option>';                            
design += '<option value="3">Match The Pairs</option> '; 
design += '<option value="4">Alpbhabet Tracing</option>'; 
design += '</select>';
design += '</div>';                    
design += '</div>';
design += '</div>';

}
</script>

@stop


