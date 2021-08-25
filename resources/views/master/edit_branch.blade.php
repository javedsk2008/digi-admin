@extends('adminlte::page')
@section('title', 'Edit Branch')
@section('content_header')
    {{-- <h1>Edit Audio / Video</h1> --}}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/validationEngine.jquery.css') }}">
<style>
.optioncls{width:572px !important;}
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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/edit_branch" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Edit Branch</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
                <div class="row">             
                <div class="col-md-6">
                        <div class="form-group">
                            <label for="sb_name"> School Name<span class="red-color">*</span> </label>
                            <input type="text" class="form-control"  value="{{$data['schooltable']['sc_name']}}" readonly placeholder="Enter Branch Name"  > 
                                
                            
                        </div>                    
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sb_location"> Branch / Locality<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="sb_location" name="sb_location" value="{{$data['row']['sb_location']}}" placeholder="Enter Branch Location"  > 
                            
                        </div>                    
                    </div> 
                </div>

                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sb_city"> City<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="sb_city" name="sb_city"  value="{{$data['row']['sb_city']}}"  placeholder="Enter City"  > 
                            
                        </div>                    
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sb_baord_affilation"> Board Affiliation<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="sb_baord_affilation" name="sb_baord_affilation"  value="{{$data['row']['sb_baord_affilation']}}"  placeholder="Enter  Board Affiliation"  > 
                            
                        </div>                    
                    </div>  
                </div>

                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sb_contact_person"> Contact Person Name<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="sb_contact_person" name="sb_contact_person"  value="{{$data['row']['sb_contact_person']}}"  placeholder="Enter Contact Person Name"  > 
                            
                        </div>                    
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sb_contact_number"> Contact Number<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="sb_contact_number" name="sb_contact_number"  value="{{$data['row']['sb_contact_number']}}"  placeholder="Enter Contact Number"  > 
                            
                        </div>                    
                    </div>  
                    
                </div>

                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sb_email_id"> Email-Id<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required,custom[email]]" id="sb_email_id" name="sb_email_id"  value="{{$data['row']['sb_email_id']}}" placeholder="Enter Email-Id"  > 
                            
                        </div>                    
                    </div>  
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="sb_website">Website<span class="red-color">*</span> </label>
                            <input type="text" class="form-control " id="sb_website" name="sb_website"  value="{{$data['row']['sb_website']}}"  placeholder="Enter Website"  > 
                            
                        </div>                    
                    </div>   -->

                    <div class="col-md-6 clearfix"></div>
                    
                </div>


              
                

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group"> 
                        <input type="hidden" name="slug" id="slug"  value="{{$data['row']['slug']}}">                      
                        <button type="submit" class="btn btn-success typesubmit pull-right float-right" style="margin-top:3px;">Update</button>
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

<script>

</script>
@stop


