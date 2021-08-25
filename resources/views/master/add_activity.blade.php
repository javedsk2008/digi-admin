@extends('adminlte::page')
@section('title', 'Add Audio / Video')
@section('content_header')
    {{-- <h1>Add Audio / Video</h1> --}}
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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/add_activity" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Add Audio / Video</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
                <div class="row">             
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
                 
                </div>

                <div class="row">             
                <div class="addmorecode">

                                                    
                    <input type="hidden" id="lastcount" value="0">
                    <section id="wrapper22"></section>
                    <button style="margin-left:15px;" class="btn btn-info" type="button" id="myBtn">Add Addos</button>
                    </div>                 
                 
                </div>

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">                       
                        <button type="submit" class="btn btn-success typesubmit" style="margin-top:30px;">Submit</button>
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
    function edit(su_id,su_name,fk_class_id,fk_type_id){
            $('#su_id').val(su_id);
            $('#su_name').val(su_name);
            $('#fk_class_id').val(fk_class_id);      
            $('#fk_type_id').val(fk_type_id);             
            $('.typesubmit').text('Update');
    }

function corseclass(datalistoptionid){
 var fk_type_id = $('.corseclass'+datalistoptionid).attr('data_id'); 
 $('#fk_type_id').val(fk_type_id);


 
}


var countmore = 1;
$('#myBtn').click(function(){
//alert();
    
   var lastcount =  $('#lastcount').val();
   
   $('.allremovehide').html('');


    $('#lastcount').val(countmore)
    var div = $('<div></div>');
    var design = '';
  
design += '<div class="row singleaddon'+countmore+'">';  
design += '<div class="row" style="margin-left:15px;">';             
design += '<div class="col-md-12">';
design += '<div class="form-group">';
design += '<label for="fk_class_id"> Class Name<span class="red-color">*</span> </label>';
design += '<select class="form-control validate[required]" onchange="ques_type(this.value);" id="ques_type'+countmore+'" name="ques_type[]">';    
design += '<option value="">Select</option>';
design += '<option value="1">MCQ</option> '; 
design += '<option value="2">Fill In The Blanks</option>';                            
design += '<option value="3">Match The Pairs</option> '; 
design += '<option value="4">Alpbhabet Tracing</option>'; 
design += '</select>';
design += '</div>';                    
design += '</div>';
design += '</div>'; 
design += '<div class="row  addhtmlusing_questype'+countmore+'" style="margin-left:15px;"  ></div>'; 
design += '<div class="hideremove'+countmore+' allremovehide"><a><i onclick="removediv('+countmore+');" class="fa fa-minus-circle" style="font-size: 24px;color: red; margin-left:25px;"></i></a></div>';  
design += '</div>';  

                 
    div.html(design);    
    div.appendTo('#wrapper22');
   
    countmore = countmore + 1;

    

});

function removediv(id){
   
   $('.singleaddon'+id).html('');

 var id_minus_one = parseInt(id) - 1;
  $('#lastcount').val(id_minus_one);
  var rembutton = '<a><i onclick="removediv('+id_minus_one+');" class="fa fa-minus-circle" style="font-size: 24px;color: red; margin-left:25px;"></i></a>';
  $('.hideremove'+id_minus_one).html(rembutton);
  
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


