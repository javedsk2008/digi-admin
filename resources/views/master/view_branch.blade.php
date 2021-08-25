@extends('adminlte::page')

@section('title', 'Branches')

@section('content_header')
    {{-- <h1>Branches</h1> --}}
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
            <h3 class="box-title">Branches</h3>
        </div>
                   
    </div>
    <!-- <a href="add_branch"><button type="button" class="btn btn-info" style="margin-bottom:30px;">Add Branch</button></a>
         -->
    <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sb_name"> School Name<span class="red-color">*</span> </label>
                            <?php $fk_school_slug = isset($_GET['fk_school_slug'])?$_GET['fk_school_slug']:"";?>
                            <select class="form-control" id="fk_school_slug"  name="fk_school_slug" onchange="filterform();">
                        <option value="">Select All</option>
                          @foreach($data['schooltable'] as $cls)                        
                          <option value="{{$cls['slug']}}" {{$cls['slug'] == $fk_school_slug?'selected':''}} >{{$cls['sc_name']}}  </option>       
                            <!-- ({{$cls['sc_location']}}, {{$cls['sc_city']}})                   -->
                          @endforeach  
                    </select>  
                            
                        </div>                    
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                        <a href="view_branch"><button type="button" class="btn btn-info" style="margin-top:30px;">Reset</button></a>
                        </div>                    
                    </div> 
    </div>

    <table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead class="thead-light">
                    <tr>
                    <th>Sr. No</th>
                            <th>School Name</th>
                            <th>Branch / Locality</th>
                            <th>Contact Person</th>
                            <th>Contact Person Number</th>
                           <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                @foreach($data['tabledata'] as $row)
                <tr>                   
                    <td>{{ $loop->iteration }}</td>
                  
                    <td>{{$row['sc_name']}}</td>  
                    <td>{{$row['sb_location']}}</td>  
                    <td>{{$row['sb_contact_person']}}</td>  
                    <td>{{$row['sb_contact_number']}}</td>  
                    <td>            
                            <a href="{{Config('app.url').'/'.'edit_branch?id='.$row['sb_id']}}" ><img src="{{Config('app.url')}}/img/icon/edit.png" style="height:22px;width:25px;" alt='edit'></a>
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
                var column_name = 'sb_delete';     
                var table_name = 'schoolbranch';      
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


        function filterform(){                   
            var fk_school_slug = $('#fk_school_slug').val();
            window.location.href="view_branch?fk_school_slug="+fk_school_slug;
        }

</script>

@stop


