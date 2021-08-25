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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/add_audiovideo" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Add Audio / Video</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
                <div class="row">             
              

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_class_id"> Subject Name<span class="red-color">*</span> </label>
                            <input type="text" class="form-control" value="{{$data['rowsu']['su_name']}}" > 
                            
                        </div>                    
                    </div>  

                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="fk_class_id"> Chapter Name<span class="red-color">*</span> </label>
                            <input type="text" class="form-control" value="{{$data['rowch']['ch_name']}}" > 
                            
                        </div>                    
                    </div>                            
                 
                </div>


                <div class="row">             
                    <div class="addmorecode">                                                   
                    <input type="hidden" id="lastcount" value="0">
                    <section id="wrapper22"></section>
                    <button style="margin-left:15px;margin-top:30px;" class="btn btn-info" type="button" id="myBtn">Add Audio/Video</button>
                    </div>
                 
                </div>

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">          
                        <input type="hidden" id="fk_subject_id" name="fk_subject_id" value="{{$data['rowsu']['su_id']}}">       
                        <input type="hidden" id="fk_chapter_id" name="fk_chapter_id" value="{{$data['rowch']['ch_id']}}">                    
                        <button type="submit" class="btn btn-success typesubmit float-right" style="">Submit</button>
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
design += '<label for="av_name'+countmore+'">Short Name<span class="red-color">*</span> </label>';
design += '<input type="text" class="form-control validate[required]" id="av_name'+countmore+'" placeholder="Enter Short name" name="av_name[]" >';                            
design += '</div>';                    
design += '</div>';



design += '<div class="col-md-6">';
design += '<div class="form-group">';
design += '<label for="video_type'+countmore+'">Select Video Type<span class="red-color">*</span> </label>';
design += '<select class="form-control validate[required]" id="video_type'+countmore+'" name="video_type[]" >';          
design += '<option value="Explanation">Explanation</option><option value="Conversation">Conversation</option>';       
design += '</select>';                 
design += '</div>';                    
design += '</div>'; 

design += '<div class="col-md-6">';
design += '<div class="form-group">';
design += '<label for="video_type_url_file'+countmore+'">Select Url Type<span class="red-color">*</span> </label>';
design += '<select class="form-control validate[required]" id="video_type_url_file'+countmore+'" onchange="urltype('+countmore+');" name="video_type_url_file[]" >';          
design += '<option value="file">File</option><option value="url">Url</option>';       
design += '</select>';                 
design += '</div>';                    
design += '</div>';

design += '<div class="col-md-6">';
design += '<div class="form-group">';
design += '<label for="av_url'+countmore+'">Attach File<span class="red-color">*</span> </label>';
design += '<input type="file" class="form-control validate[required]" id="av_url'+countmore+'" name="av_url'+countmore+'" >';                    
design += '</div>';                    
design += '</div>';  


design += '<div class="col-md-6" hidden>';
design += '<div class="form-group">';
design += '<label for="countmore'+countmore+'">countmore<span class="red-color">*</span> </label>';
design += '<input type="text" class="form-control validate[required]" value="'+countmore+'" id="countmore'+countmore+'" name="countmore[]" >';                    
design += '</div>';                    
design += '</div>';  

// design += '<div class="col-md-12">';                    
// design += '<div>';
// design += '<label for="opradio1'+countmore+'">';
// design += '<input type="radio" name="video_type[]" id="opradio1'+countmore+'" value="Explanation" checked="">Explanation</label>';
// design += '<label  for="opradio2'+countmore+'" style="margin-left:30px;">';
// design += '<input type="radio" name="video_type[]" id="opradio2'+countmore+'" value="Conversation">Conversation</label>';
// design += '</div>';                                                   
// design += '</div>';

design += '<div class="hideremove'+countmore+' allremovehide"><a><i onclick="removediv('+countmore+');" class="fa fa-minus-circle" style="font-size: 24px;color: red; margin-left:590px;"></i></a></div>';  

design += '</div>';  

design += '</div>';  

                 
    div.html(design);    
    div.appendTo('#wrapper22');
   
    countmore = countmore + 1;

    

});

    function urltype(id){
      // alert(id);
        if($("#video_type_url_file"+id).val() == 'url'){
            $("#av_url"+id).prop('type','text');
        }else{
             $("#av_url"+id).prop('type','file');
        } 
    }

function removediv(id){
   
   $('.singleaddon'+id).html('');

  
}
</script>

@stop




