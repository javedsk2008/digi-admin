@extends('adminlte::page')
@section('title', 'Grow')
@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@yield('css')
@stop
@section('content')
<script>
function change_access_value()
{
    var id = $('#user_id').val();
    if(id != 0)
    {
        window.location.href="{{Config('app.url')}}change_access?id="+id;
    }
}

function change_user(id)
{
    window.location.href="{{Config('app.url')}}revert_role_type?id="+id;
}
$(document).ready(function(){
 
 // Initialize select2
 $("#user_id").select2();

});
</script>

<div class="row">
    <div class="col-md-12">
    <div class="box box-info">

    <form id="formid" action="{{ Config('app.url')}}change_access" method="post" class="add-service m-20 formID" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}"><fieldset>
    <fieldset>
    <legend>Add Admin</legend>
    <div class="col-md-12">
    
    </div>       
       
        <div class="col-md-6">
            <div class="form-group search-label">
             <label for="gender">Select User</label>
             <select class="form-control validate[required]" name="id" id="user_id">
                <option value="0"> Select User </option>
                <?php foreach($data['alluser'] as $al_us){?>
                        <option value="{{$al_us['id']}}">{{ $al_us['fname'] }} {{ $al_us['lname'] }} ( {{$al_us['email']}} )</option>
                <?php  }?>             
             </select>
            </div>
        </div>



        <div class="clearfix"></div>  
 

        <div class="col-md-6">
        <div class="d-inline mb-3">
        <a href="view_profile"><button type="button" class="btn btn-default">Cancel</button></a>
            <button type="button" onclick="change_access_value()" name="submit"  class="btn btn-primary">Update</button>
        </div>
    </div> 
        
    </fieldset>     
   
    </form>
    <?php if(count($data['admin_user'])>0){?>
    <div class="row">

        <div class="col-md-12 col-lg-12 col-xs-12">
            <table id="table_id" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>Sr no : </th>
                        <th>Name </th>
                        <th>Revert </th>
                    </tr>
                </thead>
                <tbody>
                <?php $cnter =1; foreach($data['admin_user'] as $au){?>
                    <tr>
                        <td>{{$cnter}}</td>
                        <td>{{$au['fname']}}</td>
                        <td><a onclick="change_user({{$au['id']}})">Change Admin To User</a></td>
                    </tr>
                <?php $cnter++; }?>
                </tbody>
            </table>
        </div>

    </div>
    <?php }?>
    

    </div>
    </div>
</div>
@stop


@section('js')

@stop
