@extends('adminlte::page')
@section('title', 'Grow')
@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@yield('css')
@stop
@section('content')
<style>
.pointer{
    cursor:pointer;
}

.di-none{
    display:none;
}

.di-block{
    dispaly:block;
}
.inner-list li a {
    margin-right: 0px;
}
.page_listing li{cursor:auto !important;}

</style>

<script>
$().ready(function(){
    var id = "<?= empty($_GET['id'])==true?0:$_GET['id']?>";
    get_roles(id);
})
function get_roles(rid)
{
    if(rid >0)
    {
        $('#roles_val').removeClass('di-none');
        $('#roles_val').addClass('di-block');
    }else{
        $('#roles_val').removeClass('di-block');
        $('#roles_val').addClass('di-none');
    }
}


function filter_value(id)
{   
    if(id == 1)
    {
        var fil_ser = $('#filterservice').val()==""?0:$('#filterservice').val();
        var fil_rol = $('#filterservice').val()>0?$('#filterrole').val():0;
        var fil_name = $('#filterflname').val();

        window.location.href="{{Config('app.url')}}view_profile?filters=10&id="+fil_ser+"&role="+fil_rol+"&name="+fil_name;
    }else{
        window.location.href="{{Config('app.url')}}view_profile";
    }
}


function filter_data(fid,id)
{
    window.location.href="<?= Config('app.url')?>view_profile?filters="+fid+"&id="+id;
}
</script>
<div class="row">
<div class="col-md-12 col-lg-12 col-xs-12 text-right mb-11">

    <!-- <a href="/add_chapter?type=chapter"></a> 
    <a href="/add_chapter?type=chapter"></a>  -->
    <?php if(Session::get('session_type')=='admin'){?>
    <a href="<?= Config('app.url')?>add_admin">
       <button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus add-icon"></i> Add Admin</button>
   </a>
    <?php }?>

   <a href="<?= Config('app.url')?>add_profile">
       <button style="margin-right: 10px;" type="button" class="btn btn-primary pull-right"><i class="fa fa-plus add-icon"></i> Add Profile</button>
   </a>
  
   <?php $urrlll = Request::fullUrl();?>
   <a href="{{str_replace("view_profile","export_profile",$urrlll)}}" >
       <button style="margin-right: 10px;" type="button" class="btn btn-primary pull-right"><i class="fa fa-plus add-icon"></i>   Export to Excel</button>
   </a>
  
   </div>      
</div>

<div class="row ">
    <div class="col-md-12">
            <div class="p1 pt-2 pb-44 border-11 search_form">
    <?php $filter_brand = array('1'=>'Grow','2'=>'Raymond','3'=>'Lego','4'=>'GlaxoSmithKline (GSK)','5'=>'Coty');?>
    <div class="col-md-3 col-lg-3 col-xs-12">
    
        <select class="form-control" onchange="get_roles(this.value)" id="filterservice">
            <option value="0">-- Active Users --</option>    
            <option value="potential" <?= empty($_GET['id'])==true?'':($_GET['id']=='potential'?'selected':'')?>>-- Potentials --</option>
            <?php foreach($data['services'] as $ser_data){?>
                <option value="{{$ser_data['id']}}" <?= empty($_GET['id'])==true?'':($_GET['id']==$ser_data['id']?'selected':'')?>>
                    <?= $filter_brand[$ser_data['fk_brand_id']]?>: <?= $ser_data['name']?>
                </option>
            <?php }?>    
        </select> 
    </div>
    <div class="col-md-3 col-lg-3 col-xs-12 di-none" id="roles_val">
        <select class="form-control"  id="filterrole">
            @foreach (trans('CommonData.umsrole') as  $key => $rdata)                
                <option value="{{$rdata}}" <?= empty($_GET['role'])==true?'':($_GET['role']==$rdata?'selected':'')?>>
                    {{str_replace("No","All",$key).'s'}}
                </option>                   
            @endforeach
        </select>
    </div>
    
    <div class="col-md-3 col-lg-3 col-xs-12">
        <input type="text" value="{{empty($_GET['name'])==true?'':$_GET['name']}}" placeholder="Type first or last name" name="filterflname" id="filterflname" class="form-control"> 
     
    </div>
    <div class="col-md-3 col-lg-3 col-xs-12">
            <button class="btn btn-default btn-sm" onclick="filter_value(1)">Filter</button>
            <button class="btn btn-default btn-sm" onclick="filter_value(0)">Reset</button>
    </div>
</div>
    </div>
</div>
@include('common.ViewSession')  
<div class="box-1" id="diverefresh">

    <div class="row filter-div">
        <div class="col-md-3 col-lg-3 col-xs-3">
            <select class="form-control" onchange="filter_data(this.value,'{{ $_GET['id'] }}')">
                <option value="10" <?= $_GET['filters']==10?'selected':''?>>10</option>
                <option value="15" <?= $_GET['filters']==15?'selected':''?>>15</option>
                <option value="50" <?= $_GET['filters']==50?'selected':''?>>50</option>
            </select>   
        </div>
        <div class="col-md-9 col-lg-9 col-xs-9 pull" align="right">
            <a href="{{Config('app.url')}}import_profile">Add students to a program by importing an Excel file</a>
        </div>
    </div>
    <div class="row" style="font-weight: bold;">{{count($data['tabledata'])}} Records</div>
   <ul class="list-unstyled page_listing mt-1" id="">
   <?php  foreach($data['tabledata'] as $row) { ?>   
    <li id="" class="profiledelete{{$row->id}}">   
    <div class="row">
    <div class="col-md-12">

         <div class="row p3">
           <ul class="list-unstyled inner-list">
           <li>
           <div class="row d-flex">                                   
           <div>
           <div class="row d-flex">
           <div>
<div class="d-flex">
 
           <a class="pointer" onclick="profile_delete({{$row->id}})" title="Delete"><img src="{{ asset('img/dustbin2.png') }}" alt="dustbin"  class="icon-width mr-11" ></a>  
                           <a href="{{Config('app.url')}}edit_profile?id={{$row->id}}&rtype=view" title="Edit"><img src="{{ asset('img/pen.png') }}"alt="pen" class="icon-width mr-11" >  </a>  
                       
                        </div>
                        </div>
                        <div>
           <img src="{{Config('app.url').'storage/profile_img/resize_'.$row->overview_image}}" class="img-responsive profile-details">
           </div>
           </div>
           </div>
           
           <div class=" profile">
           <a href="{{Config('app.url')}}profile_details?id={{$row->id}}" class="d-flex"><h4><u>{{$row->fname}}   {{$row->lname}} </u></h4>
        <!-- <img src="{{ asset('img/male.png') }}" alt="male"> -->
        <!-- <p>(any device)</p> -->
        </a>
           <h5>{{$row->name}} <span style="font-weight:100"> (current company)</span></h5>
        <p>Username: <a href="mailto:{{$row->email}}"class="blue"> {{$row->email}}</a></p>
        <p>Tel: {{$row->mobile}}</p>
        @if($row->account_status == 1)
        <p class="green"><em>Account is enabled</em></p>
        @else
        <p class="red"><em>Account is disabled</em></p>
       
        @endif
        @if($row->has_received_email_check == 0)
        <p class="red"><em>Person has not received credentials</em></p>
        @endif
           
        @if($row->login_datetime != 0)<p class="green"><em>Last sign in: {{date('D, M d, Y', strtotime($row->login_datetime))}} <img src="{{ asset('img/clock.png') }}" alt="clock">  {{date('H:i', strtotime($row->login_datetime))}} (UTC+{{$row->europian_time}} W. Europe Standard Time) </em> </p>@endif
        @foreach($row['profilerole_data'] as $prdata)
        <?php 
        //echo 'service'.  
        $wheretime = array('ut_type'=>'service','ut_typeid'=>$prdata->fk_service_id,'ut_userid'=>$row->id);
        $updatedtime =  \DB::table('user_track')->where($wheretime)->get();
        //print_r($updatedtime);
         $uptime = count($updatedtime)==0?'-' : $updatedtime[0]->ut_updatedtime;
         $classnamestatus = array('0'=>'red','1'=>'green','10'=>'blue');
        ?>
        
        <p class="mt-1"><strong>{{ $prdata->bname}}: </strong>  {{ $prdata->sname}} (<span class="{{$classnamestatus[$prdata->service_status]}}">{{array_search($prdata->service_status, trans('CommonData.statusdata'))}}</span>, <span class="BB">{{array_search($prdata->role, trans('CommonData.umsrole'))}}</span>)</p>
        <!-- <p>Last visited: Tue, Dec 4, 2018time11:05 (UTC+01:00:00 W. Europe Standard Time) </p> -->
       
        <!-- @if($uptime == '-')
            {{ $uptime}}
        @else
        <p>Last visited : {{date('D',strtotime($uptime))}}, {{date('M',strtotime($uptime))}} {{date('d',strtotime($uptime))}}, {{date('Y',strtotime($uptime))}}  time {{date('H:i',strtotime($uptime))}}  (UTC+01:00:00 W. Europe Standard Time) </p>
        @endif -->
        @if($prdata->role != 0)
        @if($prdata->ps_datetime != 0)<p>Last visited:  {{date('D, M d, Y', strtotime($prdata->ps_datetime))}} <img src="{{ asset('img/clock.png') }}" alt="clock"> {{date('H:i', strtotime($prdata->ps_datetime))}}  (UTC+{{$prdata->europian_time_service}} W. Europe Standard Time) </p>@endif
        @endif
        @endforeach

        @if(count($row['profilerole_data']) == 0)<span style="font-weight:bold;">No Programs Found</span>@endif
           </div>
        
           </div>
           </li>
          
           </ul>

         </div>
     </div>   
   
    </div>  
   
    </li>  
  <?php } ?>
   </ul>


   <?= $data['tabledata']->appends(['filters'=>$_GET['filters'],'id'=>isset($_GET['id'])==true?$_GET['id']:0,'role'=>isset($_GET['role'])==true?$_GET['role']:0,'name'=>isset($_GET['name'])==true?$_GET['name']:''])->links()?>
   <input type="hidden" name="page_order_list" id="page_order_list" />
    </div>


@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script type="text/javascript">

function profile_delete(id)
{
    if(confirm("Are you sure you want to delete this service record ? ") == true)
  {
    $.ajax({
        type:'get',
        url:"{{Config('app.url')}}delete_profile?id="+id+"&status=0",
        dataType:'json',
        success:function(data){
           // alert(data);
            $('.profiledelete'+id).hide();
        }
    });
  }
}

$(document).ready(function(){
  
 $("#page_list").sortable({
   
  placeholder : "ui-state-highlight",
  update  : function(event, ui)
  {      
   var page_id_array = new Array();
   $('#page_list li').each(function(){    
    page_id_array.push($(this).attr("id"));
   });
  
   var all_ids = page_id_array.join(); 
   var all_id = all_ids.replace('%2','');   
   var table_name = 'master_admin';
   var table_id = 'id';
   //  alert(all_id);
   $.ajax({
    url:"{{Config('app.url')}}updateorder",
    method:"GET",
    data:{all_id:all_id,table_name:table_name,table_id:table_id},
    dataType:'json',
       success:function(data)
    {        
       //  alert(data.message);
    }
   });
  }
 });

});
</script>
@stop