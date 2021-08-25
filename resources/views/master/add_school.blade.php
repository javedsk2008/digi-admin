@extends('adminlte::page')
@section('title', 'Add School')
@section('content_header')
    {{-- <h1>Add Audio / Video</h1> --}}
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
<form class="form_validation" method="POST" action ="{{Config('app.url')}}/add_school" enctype="multipart/form-data">
                
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Add School</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="box-body">
                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sc_name"> School Name<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="sc_name" name="sc_name" placeholder="Enter School Name"  > 
                                
                            
                        </div>                    
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sc_location"> Branch / Locality<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="sc_location" name="sc_location" placeholder="Enter School Location"  > 
                            
                        </div>                    
                    </div> 
                </div>

                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sc_city"> City<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="sc_city" name="sc_city" placeholder="Enter City"  > 
                            
                        </div>                    
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sc_baord_affilation"> Board Affiliation<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="sc_baord_affilation" name="sc_baord_affilation" placeholder="Enter  Board Affiliation"  > 
                            
                        </div>                    
                    </div>  
                </div>

                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sc_contact_person"> Contact Person Name<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required]" id="sc_contact_person" name="sc_contact_person" placeholder="Enter Contact Person Name"  > 
                            
                        </div>                    
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sc_contact_number"> Contact Number<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required,custom[number],minSize[10],maxSize[10]]" id="sc_contact_number" name="sc_contact_number" placeholder="Enter Contact Number"  > 
                            
                        </div>                    
                    </div>  
                    
                </div>

                <div class="row">             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sc_email_id"> Email-Id<span class="red-color">*</span> </label>
                            <input type="text" class="form-control validate[required,custom[email]]" id="sc_email_id" name="sc_email_id" placeholder="Enter Email-Id"  > 
                            
                        </div>                    
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sc_website">Website<span class="red-color"></span> </label>
                            <input type="text" class="form-control " id="sc_website" name="sc_website" placeholder="Enter Website"  > 
                            
                        </div>                    
                    </div>  
                    
                </div>


                <div class="row">             
                   
                    <div class="col-md-4 clearfix"></div>
                </div>

              
                

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">                       
                        <button type="submit" class="btn btn-success typesubmit pull-right float-right" style="margin-top:3px;">Submit</button>
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


