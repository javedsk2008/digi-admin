@extends('adminlte::page')
@section('title', 'Add Book')
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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/add_subjects" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Add Book</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">            
            <div class="box-body">              

            <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label>Class Name</label>
                  <div class="select2-purple">
                    <select class="select2 all_course_class all_class" name="subcourse[]" multiple="multiple" onchange="all_course_class();" data-placeholder="Select a Class" data-dropdown-css-class="select2-purple" style="width: 100%;">
                          @foreach($data['classtable'] as $cls)
                          @if($cls->type == '1')
                          <option value="{{$cls['cl_id']}}" >{{$cls['cl_name']}}</option> 
                          @endif
                          @endforeach  
                    </select>
                  </div>
                </div>              
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Course Name</label>
                  <div class="select2-purple">
                    <select class="select_course2 all_course_class all_course" name="subcourse[]" multiple="multiple" onchange="all_course_class();" data-placeholder="Select a Course" data-dropdown-css-class="select2-purple" style="width: 100%;">
                          @foreach($data['classtable'] as $cls)
                          @if($cls->type == '2')
                          <option value="{{$cls['cl_id']}}">{{$cls['cl_name']}}</option> 
                          @endif
                          @endforeach  
                    </select>
                  </div>
                </div>              
              </div>
              </div>

              <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="su_name">Book Name<span class="red-color">*</span> </label>
                      <input type="text" class="form-control validate[required]" id="su_name" name="su_name" placeholder="Enter Subject Name" > 
                  </div>                    
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="auther_name">Author Name<span class="red-color">*</span> </label>
                      <input type="text" class="form-control validate[required]" id="auther_name" name="auther_name" placeholder="Enter Author Name" > 
                  </div>                    
              </div>
              </div>

              <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="book_image">Image<span class="red-color">*</span> </label>
                      <input type="file" class="form-control validate[required]" id="book_image" name="book_image" > 
                  </div>                    
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="description">Description<span class="red-color">*</span> </label>
                      <textarea class="form-control validate[required]" id="description" name="description" placeholder="Enter Description" ></textarea> 
                  </div>                    
              </div>
              </div>

                <div class="row">
              <div class="col-md-6 clearfix">
                  <div class="form-group">
                      <label for="su_price">Price<span class="red-color">*</span> </label>
                      <input type="text" class="form-control validate[required,custom[number]]"  placeholder="Enter Price" id="su_price" name="su_price" > 
                  </div>                    
              </div>
              
              </div>

              
                <!-- <div class="row">             
                    <div class="addmorecode">                                                   
                    <input type="hidden" id="lastcount" value="0">
                    <section id="wrapper22"></section>
                    <button style="margin-left:15px;margin-top:30px;" class="btn btn-info" type="button" id="myBtn">Add Subject</button>
                    </div>
                 
                </div> -->

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">    
                        <input type="hidden" id="str_fk_class_id" name="str_fk_class_id" value="">                   
                        <button type="submit" class="btn btn-success typesubmit pull-right float-right float-right" style="margin-top:05px;">Submit</button>
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

function all_course_class(id){
  
allcourse = [];var allcourse_count = 0;
var couse1 = $('.all_course').map(function (_, el) {
  allcourse[allcourse_count] = $(el).val();
  allcourse_count++;
}).get();

allclass = [];var allclass_count = 0;
var couse2 = $('.all_class').map(function (_, el) {
  allclass[allclass_count] = $(el).val();
  allclass_count++;
}).get(); 
var alldata  = allclass.concat(allcourse);
var alldataconcat = allclass.concat(allcourse)
var alldata = alldataconcat.filter((item, pos) => alldataconcat.indexOf(item) === pos);
var post_commaseprated_id = alldata.join();
$("#str_fk_class_id").val(post_commaseprated_id);
//console.log(alldata.join()); // d is [1, 2, 3, 101, 10]


    //  $.ajax({
    //      headers: {
    //              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //      },
    //      type: "post",
    //      url:"view_all_array_in",
    //      data: 'post_commaseprated_id=' + post_commaseprated_id,
    //      datatype: "text",
    //      async: false,
    //      success: function (data) {
             
    //         var selOpts = "<option value=''>Select</option>";
    //         $.each(data, function(k, v)
    //         {
    //                 selOpts += "<option value='"+v['cl_id']+"'>"+v['cl_name']+"</option>";
    //         });
    //         //$("#fk_class_id").html(selOpts);
    //         alert(selOpts);
 
    //      }
    //  });
 

}



$('#book_image').on("change",function () {

                var fileExtension = ['jpeg', 'jpg','png','PNG'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                     alert("Only '.jpeg','.jpg' formats are allowed.");
                        $('#book_image').val('');
                    // $('#spanFileName').html(this.value);
                    // $('#spanFileName').html("Only 'jpeg', 'jpg','png','PNG' formats are allowed.");
                
                    }
               
 }) 
</script>

@stop


