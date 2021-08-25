@extends('adminlte::page')

@section('title', 'Audios / Videos')

@section('content_header')
    {{-- <h1>Audios / Videos</h1> --}}
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
            <h3 class="box-title">Audios / Videos</h3>
        </div>
    </div>
                    <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                           <!-- <a href="{{Config('app.url')}}/add_audiovideo"><button class="btn btn-info pull-right">Add Activity</button></a>   -->
                        </div>  
                                                             
                    </div> 
                    </div> 

            <table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead class="thead-light">
                    <tr>
                            <th>Sr. No</th>
                           <th>Subject Name</th>
                            <th>Chapter Name</th>
                            <th>Short Name</th>
                            <th>Download</th>
                            <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                @foreach($data['tabledata'] as $row)
                <tr>    
                    <td>{{ $loop->iteration }}</td>                  
                    <td>{{$row['su_name']}}</td>  
                    <td>{{$row['ch_name']}}</td>  
                    <td>{{$row['av_name']}}</td>  
                    <td><a href="{{Config('app.url').'/'.$row['av_url']}}" target="_blank" download>Download</a></td>  
                    <td>            
                    <a href="{{Config('app.url').'/'.'edit_audiovideo?id='.$row['av_id']}}" ><img src="{{Config('app.url')}}/img/icon/edit.png" style="height:22px;width:25px;" alt='edit'></a>
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

        function deleterow(slug){
        if(confirm('Are you sure you want to delete this data ?') == true)
          {
                var column_name = 'av_delete';     
                var table_name = 'audiovideo';      
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


