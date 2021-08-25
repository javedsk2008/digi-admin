@extends('adminlte::page')
@section('title', 'View Unit')
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
            <h3 class="box-title">View Unit</h3>
            </div>
</div>     
<a href="{{Config('app.url')}}/add_units"><button type="button" class="btn btn-info" style="margin-bottom:30px;">Add Unit</button></a>


            <table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead class="thead-light">
                    <tr>
                            <th>Sr. No</th>                            
                            <th>Unit Name</th>     
                                            
                            <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                @foreach($data['tabledata'] as $row)
                <tr>                   
                <td>{{ $loop->iteration }}</td>
                    <td>{{$row['un_name']}}</td>          
                    <!-- <td>{{$row['country_name']}}</td>            -->
                    <td>      
                    <a href="edit_units?slug={{$row['slug']}}"><img src="{{Config('app.url')}}/img/icon/edit.png" style="height:22px;width:25px;" alt='edit'></a>
                    <button type="button" class="actionbtn" onclick="deleterow('{{$row['slug']}}');">Delete</button>
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
  
function deleterow(slug){
        if(confirm('Are you sure you want to delete this data ?') == true)
          {
                var column_name = 'un_delete';     
                var table_name = 'units';      
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


