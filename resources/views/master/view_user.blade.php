@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    {{-- <h1>Users</h1> --}}
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
            <h3 class="box-title">Users</h3>
    </div>
                   
    </div>
    <a href="add_user"><button type="button" class="btn btn-success" style="margin-bottom:30px;"><img src="{{Config('app.url')}}/img/icon/add_user.png" style="height:22px;width:25px;" alt='add_user'>&nbsp;Add Users</button></a>
    <table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead class="thead-light">
                    <tr>
                    <th>Sr. No</th>
                    <th>Role</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>                    
                    <th>Action</th>                       
                    </tr>
                </thead>
                <tbody>
                @foreach($data['tabledata'] as $row)
                <tr>                   
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$row['ro_name']}}</td>  
                    <td>{{$row['full_name']}}</td>  
                    <td>{{$row['email']}}</td>  
                    <td>{{$row['phone_number']}}</td>  
                    <td> 
                        <a href="{{Config('app.url').'/'.'view_user_details?id='.$row['id']}}" ><img src="{{Config('app.url')}}/img/icon/view.png" style="height:22px;width:25px;" alt='view'></a>
                        <a href="{{Config('app.url').'/'.'edit_user?id='.$row['id']}}" ><img src="{{Config('app.url')}}/img/icon/edit.png" style="height:22px;width:25px;" alt='edit'></a>
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
  

        function deleterow(slug){
        if(confirm('Are you sure you want to delete this data ?') == true)
          {
                var column_name = 'ma_delete';     
                var table_name = 'users';      
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


