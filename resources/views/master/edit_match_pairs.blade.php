@extends('adminlte::page')
@section('title', 'Add Match The Pairs')
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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/add_match_pairs" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Add Match The Pairs</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
           

         
                <div class="row singleaddon{{$i}}">  


<div class="row" style="margin-left:30px;border:1px solid black;width:1209px;padding-top:5px;">  

<div class="row">                     
                    <div class="col-md-12">
                    <div class="form-group">
                    <label for="question">Question<span class="red-color">*</span> </label>
                    <textarea class="form-control  validate[required]" id="question" name="question" placeholder="Enter Question"  >{{$data['rowques']['question']}}</textarea>                          
                    </div>                    
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                    <label for="marks">Marks<span class="red-color">*</span> </label>
                    <input type="text" class="form-control optioncls validate[required]" value="{{$data['rowques']['marks']}}"  id="marks" name="marks"  placeholder="Enter Marks" >                          
                    </div>                    
                    </div>
 
<div class="col-md-6">
<div class="form-group">
<label for="noof_pairs{{$i}}">No. Of Pairs<span class="red-color">*</span> </label>
<select class="form-control optioncls  validate[required]"  id="noof_pairs{{$i}}" name="noof_pairs[]">
<option value="">Select No. Of Pairs</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
</select>                            
</div>                    
</div> 

<div class="col-md-6">
<div class="form-group">
<label for="mtp_type{{$i}}">Type<span class="red-color">*</span> </label>
<select class="form-control optioncls  validate[required]" onchange="noofpairs(this.value,{{$i}});" id="mtp_type{{$i}}" name="mtp_type[]">
<option value="">Select Type</option>
<option value="text">Text</option>
<option value="file">Image</option>
</select>                            
</div>                    
</div> 



<div class="col-md-12 attach_pairs{{$i}}">
@for ($i =1; $i <= $data['rowques']['noof_pairs']; $i++)

@endfor
</div> 
<div class="col-md-12 attach_pairs_ans{{$i}}"></div> 


<div class="hideremove{{$i}} allremovehide"><a><i onclick="removediv({{$i}});" class="fa fa-minus-circle" style="font-size: 24px;color: red; margin-left:590px;"></i></a></div>  

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
   
   $('#lastcount').val(countmore)
    var div = $('<div></div>');
    var design = '';
  
design += '<div class="row singleaddon'+countmore+'">';  


design += '<div class="row" style="margin-left:30px;border:1px solid black;width:1209px;padding-top:5px;">';  

design += '<div class="col-md-12">';
design += '<div class="form-group">';
design += '<label for="question'+countmore+'">Question<span class="red-color">*</span> </label>';
design += '<textarea class="form-control  validate[required]" id="question'+countmore+'" name="question[]" placeholder="Enter Question"  ></textarea>';                          
design += '<input type="hidden" id="checkid'+countmore+'" name="checkid[]"  value="'+countmore+'"  >'; 

design += '</div>';                    
design += '</div>';
 
design += '<div class="col-md-6">';
design += '<div class="form-group">';
design += '<label for="noof_pairs'+countmore+'">No. Of Pairs<span class="red-color">*</span> </label>';
design += '<select class="form-control optioncls  validate[required]"  id="noof_pairs'+countmore+'" name="noof_pairs[]">';
design += '<option value="">Select No. Of Pairs</option>';
design += '<option value="1">1</option>';
design += '<option value="2">2</option>';
design += '<option value="3">3</option>';
design += '<option value="4">4</option>';
design += '<option value="5">5</option>';
design += '<option value="6">6</option>';
design += '<option value="7">7</option>';
design += '</select>';                            
design += '</div>';                    
design += '</div>'; 

design += '<div class="col-md-6">';
design += '<div class="form-group">';
design += '<label for="mtp_type'+countmore+'">Type<span class="red-color">*</span> </label>';
design += '<select class="form-control optioncls  validate[required]" onchange="noofpairs(this.value,'+countmore+');" id="mtp_type'+countmore+'" name="mtp_type[]">';
design += '<option value="">Select Type</option>';
design += '<option value="text">Text</option>';
design += '<option value="file">Image</option>';
design += '</select>';                            
design += '</div>';                    
design += '</div>'; 

design += '<div class="col-md-12">';
design += '<div class="form-group">';
design += '<label for="marks'+countmore+'">Marks<span class="red-color">*</span> </label>';
design += '<input type="text" class="form-control optioncls validate[required]" id="marks'+countmore+'" name="marks[]"  placeholder="Enter Marks" >';                          
design += '</div>';                    
design += '</div>';

design += '<div class="col-md-12 attach_pairs'+countmore+'"></div>'; 
design += '<div class="col-md-12 attach_pairs_ans'+countmore+'"></div>'; 


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

function noofpairs(mtp_type,countmore){

   var noof_pairs = $('#noof_pairs'+countmore).val();
   $("#attach_pairs"+countmore).html();

 
   var design = '';
   for (i = 0; i < noof_pairs; i++) {
   
            var uniqueid = countmore+'_'+i;
            var mtp_option_name = 'mtp_option_'+countmore+'[]';
            var option = i + 1;
            design += '<div class="row">';
            design += '<div class="col-md-6">';
            design += '<div class="form-group">';
            design += '<label for="mtp_option'+uniqueid+'">Option '+option+'<span class="red-color">*</span> </label>';
            design += '<input type="text" class="form-control validate[required]"  id="mtp_option'+uniqueid+'" name="'+mtp_option_name+'">';
            design += '</div>';                    
            design += '</div>'; 

            var mtp_answer_name = 'mtp_answer_'+countmore+'[]';
            design += '<div class="col-md-6">';
            design += '<div class="form-group">';
            design += '<label for="mtp_answer'+uniqueid+'">Answer '+option+'<span class="red-color">*</span> </label>';
            design += '<input type="'+mtp_type+'" class="form-control validate[required]"  id="mtp_answer'+uniqueid+'" name="'+mtp_answer_name+'">';
            design += '</div>';                    
            design += '</div>'; 
            design += '</div>'; 
    }

    var designans = '';
    for (i = 0; i < noof_pairs; i++) {
   
   var uniqueidans = countmore+'_'+i;
   var mtp_option_name_ans = 'mtp_option_ans_'+countmore+'[]';
   var ans = i + 1;
   designans += '<div class="row">';
   designans += '<div class="col-md-2">';
   designans += '<div class="form-group">';
   designans += '<label for="mtp_option_ans'+uniqueidans+'">Option '+ans+'<span class="red-color">*</span> </label>';
   designans += '<input type="text" class="form-control validate[required]"  id="mtp_option_ans'+uniqueidans+'" readonly name="'+mtp_option_name_ans+'" value="'+ans+'">';
   designans += '</div>';                    
   designans += '</div>'; 

   var mtp_answer_name_ans = 'mtp_answer_ans_'+countmore+'[]';
   designans += '<div class="col-md-2">';
   designans += '<div class="form-group">';
   designans += '<label for="mtp_answer_ans'+uniqueidans+'">Answer '+ans+'<span class="red-color">*</span> </label>';
   designans += '<input type="text" class="form-control validate[required]"  id="mtp_answer_ans'+uniqueidans+'" name="'+mtp_answer_name_ans+'">';
   designans += '</div>';                    
   designans += '</div>'; 
   designans += '</div>'; 
}
  
    $(".attach_pairs"+countmore).html(design);
    $(".attach_pairs_ans"+countmore).html(designans);

}
</script>

@stop


