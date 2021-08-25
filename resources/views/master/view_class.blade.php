@extends('adminlte::page')

@section('title', 'Classes/Courses')

@section('content_header')
    {{-- <h1>Add Class</h1> --}}
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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/view_class" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Classes/Courses</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
                <div class="row">      
                <div class="col-md-2">
                        <div class="form-group">
                            <label for="type"> Type<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" id="type" name="type" >    
                                    <option value="1">Class</option>   
                                    <option value="2">Course</option>                                
                                  
                            </select>
                            
                        </div>                    
                    </div>       
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="bags"> Class/Course<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="cl_name" placeholder="Enter Class/Course name" onkeyup="checkclassname(this.value);" name="cl_name" >
                            <p id="cl_name_msg" style="color:red;display:none;" >Already Added</p>
                            <input type="hidden" class="form-control " id="cl_id"  name="cl_id" value='0' >
                        </div>                    
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cl_logo"> Class/Course Logo<span class="red-color"></span> </label>
                                <input type="file"  id="cl_logo"  name="cl_logo" class="form-control "  tabindex="3">
                                <input type="hidden" name="bk_cl_logo" id="bk_cl_logo">
                     </div>                    
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="cl_description"> Description<span class="red-color"></span> </label>
                                <textarea  id="cl_description"  name="cl_description" class="form-control " placeholder="Enter Description"  tabindex="4"></textarea>
                              
                     </div>                    
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cl_price"> Price<span class="red-color"></span> </label>
                            <input type="text" class="form-control validate[optional,custom[number]]" id="cl_price" placeholder="Enter Price"  name="cl_price" >
                            
                        </div>                    
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">                       
                        <button type="submit" class="btn btn-success typesubmit" style="margin-top:30px;">Submit</button>
                        <a href="view_class"><button type="button" class="btn btn-info" style="margin-top:30px;">Reset</button></a>
                        
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


            <table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead class="thead-light">
                    <tr>
                            <th>Sr. No</th>
                            <th>Type</th>
                            <th>Class/Course</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                @foreach($data['tabledata'] as $row)
                <tr>                   
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$row['type'] == '1'?'Class':'Course'}}</td>
                    <td>{{$row['cl_name']}}</td> 
                    <td>{{$row['cl_price']}}</td> 
                    <td>{{$row['cl_description']}}</td> 
                    <td><a href="{{$row['cl_logo']}}" target="_blank">View Image</a></td> 
                    <td  style="width:100px;">            
                    <a onclick="edit({{$row['cl_id']}},'{{$row['cl_name']}}',{{$row['type']}},'{{$row['cl_logo']}}','{{$row['cl_description']}}','{{$row['cl_price']}}');"><img src="{{Config('app.url')}}/img/icon/edit.png" style="height:22px;width:25px;" alt='edit'></a>
                    <a onclick="deleterow('{{$row['slug']}}');"><img src="{{Config('app.url')}}/img/icon/delete.png" style="height:22px;width:25px;" alt='delete'></a>
                    </td>     
                </tr>       
                @endforeach
            </tbody>
        </table>
        

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

<script>
    function edit(cl_id,cl_name,type,cl_logo,cl_description,cl_price){
             $('#cl_name_msg').hide(); 
            $('#cl_id').val(cl_id);
            $('#cl_name').val(cl_name);
            $('#cl_description').val(cl_description);
            $('#cl_price').val(cl_price);
            $('#type').val(type);
            $('#bk_cl_logo').val(cl_logo);
            $('.typesubmit').text('Update');
    }

    function deleterow(slug){
        if(confirm('Are you sure you want to delete this data ?') == true)
          {
                var column_name = 'cl_delete';     
                var table_name = 'classtable';      
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "get",
                    url:"deleterow",
                    data: {slug:slug,column_name:column_name,table_name:table_name},
                    datatype: "text",
                    success: function(data){                
                            window.location.reload()            
                    }
                });
            }
        }




      function checkclassname(cl_name){
       
                var type = $('#type').val();
                var cl_id = $('#cl_id').val();     
           //   alert(cl_name+type);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "get",
                    url:"checkclassname",
                    data: {type:type,cl_name:cl_name,cl_id:cl_id},
                    datatype: "text",
                    success: function(data){
        //    alert(data);                
                            if(data == 'success'){
                                   $('#cl_name_msg').show(); 
                                   $('.typesubmit').prop("disabled",true);
   
                                }else{
                                   $('#cl_name_msg').hide(); 
                                    $('.typesubmit').prop("disabled",false);
                            }           
                    }
                });
            
        }


$('#cl_logo').on("change",function () {

                var fileExtension = ['jpeg', 'jpg','png','PNG'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                     alert("Only '.jpeg','.jpg' formats are allowed.");
                        $('#cl_logo').val('');
                    // $('#spanFileName').html(this.value);
                    // $('#spanFileName').html("Only 'jpeg', 'jpg','png','PNG' formats are allowed.");
                
                    }
               
 }) 

</script>

@stop


