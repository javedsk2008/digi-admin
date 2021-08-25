@extends('adminlte::page')

@section('title', 'Chapters')

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
            <h3 class="box-title">Chapters</h3>
            </div>
</div>     
<!--   
    <a href="add_subjects"><button type="button" class="btn btn-info" style="margin-bottom:30px;">Add Subject</button></a>
     -->

            <table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead class="thead-light">
                    <tr>
                            <th>Sr. No</th>
                            <th>Subjet Name</th>
                            <th>Chapter Name</th>
                            <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                @foreach($data['tabledata'] as $row)
                <tr>                   
                <td>{{ $loop->iteration }}</td>
                    <td>{{$row['su_name']}}</td>  
                    <td>{{$row['ch_name']}}</td>  
                    <td>      
                    <a href="add_audiovideo?id={{$row['ch_id']}}"><button class="actionbtn"><img src="{{Config('app.url')}}/img/icon/add_audio_video.png" style="height:22px;width:25px;" alt='add_audio_video'>&nbsp;Add Audios/Videos</button></a>
                    <a href="view_questions?id={{$row['ch_id']}}"><button class="actionbtn"><img src="{{Config('app.url')}}/img/icon/add_activity.png" style="height:22px;width:25px;" alt='add_activity'>&nbsp;Add Activities</button></a>
                    <a href="view_chapter_details?slug={{$row['slug']}}&su_name={{$row['su_name']}}"><img src="{{Config('app.url')}}/img/icon/view.png" style="height:22px;width:25px;" alt='view'></a>
                          
                    <a href="edit_chapter?slug={{$row['slug']}}"><img src="{{Config('app.url')}}/img/icon/edit.png" style="height:22px;width:25px;" alt='edit'></a>
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
                var column_name = 'ch_delete';     
                var table_name = 'chapter';      
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


