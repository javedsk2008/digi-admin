@extends('adminlte::page')

@section('title', 'Questions')

@section('content_header')
    {{-- <h1>Questions</h1> --}}
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
            <h3 class="box-title">Questions</h3>
        </div>
    </div>
                    <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                    @if(isset($_GET['id']))
                           <a href="{{Config('app.url')}}/add_mcq?chapter_id={{$_GET['id']}}"><button class="btn btn-info pull-right">Add MCQ</button></a>  
                           <a href="{{Config('app.url')}}/add_fillin_blanks?chapter_id={{$_GET['id']}}"><button class="btn btn-info pull-right">Add Fill In The Blanks</button></a>  
                           <a href="{{Config('app.url')}}/add_match_pairs?chapter_id={{$_GET['id']}}"><button class="btn btn-info pull-right">Add Match The Pairs</button></a>  
                           <a href="{{Config('app.url')}}/add_alphabet_tracing?chapter_id={{$_GET['id']}}"><button class="btn btn-info pull-right">Add Alphabet Tracing</button></a>  
                           <a href="{{Config('app.url')}}/add_truefalse?chapter_id={{$_GET['id']}}"><button class="btn btn-info pull-right">Add True False</button></a>  
                    @endif
                        </div>                                      
                    </div> 
                    </div>


<div class="searchdiv"> 
<input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Add Class/Course</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
                <div class="row"> 
                <input type="hidden" id="id" name="id" value="{{isset($_GET['id'])? $_GET['id'] : 0}}">     
                <div class="col-md-4">
                        <div class="form-group">
                            <label for="type"> Type<span class="red-color">*</span> </label>
                            <select class="form-control validate[required]" onchange="searchcode();" id="type" name="type" >    
                                <?php 
                                $typeval = isset($_GET['type'])? $_GET['type'] : '';
                                $pagename = array( 'mcq'=>'MCQ','truefalse'=>'True False','match_pairs'=>'Match Pair','fillin_blanks'=>'Filling Tha Blanks'); 
                                ?>
                                    <option value="">Select Activity Type</option>   
                                    @foreach($pagename as $key=>$value)
                                    <option value="{{$key}}" {{$typeval == $key ? 'selected':''}}>{{$value}}</option>                                
                                    @endforeach
                            </select>
                            
                        </div>                    
                    </div>       
                    
                    <div class="col-md-2 clearfix">
                        <div class="form-group">                       
               @if(isset($_GET['id']))         
                <a href="view_questions?id={{$_GET['id']}}"><button type="button" class="btn btn-info" style="margin-top:30px;">Reset</button></a>
                        @else
                <a href="view_questions"><button type="button" class="btn btn-info" style="margin-top:30px;">Reset</button></a>

                @endif
                        </div>
                                    
                    </div>               
                 
                </div>
            </div>
        
            <!-- /.box-body -->
            <!-- <div class="box-footer">
                <button type="submit" class="btn btn-primary">Add Class</button>
            </div>  -->

            </div>     
       
        
    </div>


            <table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead class="thead-light">
                    <tr>
                            <th>Sr. No</th>                   
                            <th>Subject Name</th>
                            <th>Chapter Name</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Marks</th>
                            <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                @foreach($data['tabledata'] as $row)
                <tr>    
                    <td>{{ $loop->iteration }}</td>              
                    <td>{{$row['su_name']}}</td> 
                    <td>{{$row['ch_name']}}</td>  
                     <td>{{$row['question']}}</td>  
                    <td>{{$row['answer']}}</td>  
                    <td>{{$row['marks']}}</td>  <td>            
                    <a href="{{Config('app.url')}}/edit_{{$row['pagename']}}?id={{$row['q_id']}}" ><img src="{{Config('app.url')}}/img/icon/edit.png" style="height:22px;width:25px;" alt='edit'></a>
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
                var column_name = 'q_delete';     
                var table_name = 'questions';      
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

        function searchcode(pagename){
                var id = $('#id').val();
                var type = $('#type').val();
             
 config_url = "<?php echo Config('app.url'); ?>";
      url = config_url+"/view_questions?id="+id+'&type='+type;
     //alert(url);    
      window.location = url;
           

        }

</script>

@stop


