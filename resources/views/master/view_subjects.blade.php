@extends('adminlte::page')

@section('title', 'Books')

@section('content_header')
    {{-- <h1>View Audio / Video</h1> --}}
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

 <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Books</h3>
            </div>
</div>     
       
        
  
    <a href="add_subjects"><button type="button" class="btn btn-success" style="margin-bottom:30px;"><img src="{{Config('app.url')}}/img/icon/add_book.png" style="height:22px;width:25px;" alt='add_book'>&nbsp;Add Books</button></a>
    

            <table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead class="thead-light">
                    <tr>
                            <th>Sr. No</th>
                            <th>Class / Course</th>
                            <th>Book Name</th>
                            <th>Price</th>
                            <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                @foreach($data['tabledata'] as $row)
                <tr>                   
                <td>{{ $loop->iteration }}</td>               
                    <td>{{$row['all_cl_name']}}</td>  
                    <td>{{$row['su_name']}}</td>  
                    <td>{{$row['su_price']}}</td>  
                    <td>      
                    <a href="add_chapter?id={{$row['su_id']}}"><button class="actionbtn"><img src="{{Config('app.url')}}/img/icon/add_chapter.png" style="height:22px;width:25px;" alt='add_chapter'>&nbsp;Add Chapters</button></a>
                    <a href="view_subjects_details?id={{$row['su_id']}}"><img src="{{Config('app.url')}}/img/icon/view.png" style="height:22px;width:25px;" alt='view'></a>
                            
                    <a href="edit_subjects?id={{$row['su_id']}}"><img src="{{Config('app.url')}}/img/icon/edit.png" style="height:22px;width:25px;" alt='edit'></a>
<a onclick="deleterow('{{$row['slug']}}');"><img src="{{Config('app.url')}}/img/icon/delete.png" style="height:22px;width:25px;" alt='delete'></a>                    </td>     
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
 alert(fk_type_id);

 
}

function deleterow(slug){
        if(confirm('Are you sure you want to delete this data ?') == true)
          {
                var column_name = 'su_delete';     
                var table_name = 'subjects';      
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
</script>

@stop


