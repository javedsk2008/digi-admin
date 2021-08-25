@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')

    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar sticky-top" style="padding-top:0;padding-bottom:0;"> <!--dipesh change for bootstrap4-->
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo" style="height:53px;">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar sticky-top" style="padding-top:0;padding-bottom:0;" role="navigation"> <!--dipesh change for bootstrap4-->
            <!-- <nav class="navbar navbar-static-top" role="navigation"> -->
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle fa5" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <!-- <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                            @else
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                                <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                    @if(config('adminlte.logout_method'))
                                        {{ method_field(config('adminlte.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li> -->
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>



        <aside class="main-sidebar">
            <section class="sidebar">


<ul class="sidebar-menu tree" data-widget="tree" style="padding-top:20px;">
                <!-- <li class="header">MAIN NAVIGATION</li> -->
            
                
                <li class="">
                    <a href="{{Config('app.url')}}/home">
                        <i><img src="{{Config('app.url')}}/img/icon/home.png" style="height:22px;width:25px;" alt='home'></i><span>Dashboard</span>
                    </a>
                </li>

                
                    <li class="view_user  sameclass">
                            <a href="{{Config('app.url')}}/view_user" onclick="nodeLevelActivation('master','0','view_user')">
                                <i><img src="{{Config('app.url')}}/img/icon/user.png" style="height:22px;width:25px;" alt='user'></i><span> Users</span>
                            </a>
                        </li>

                        <li class="view_school sameclass">
                            <a href="{{Config('app.url')}}/view_school" onclick="nodeLevelActivation('master','0','view_school')">
                                <i><img src="{{Config('app.url')}}/img/icon/school.png" style="height:22px;width:25px;" alt='school'></i><span> Schools</span>
                            </a>
                        </li>

                        <li class="view_branch sameclass">
                            <a href="{{Config('app.url')}}/view_branch" onclick="nodeLevelActivation('master','0','view_branch')">
                                <i><img src="{{Config('app.url')}}/img/icon/branch.png" style="height:22px;width:25px;" alt='branch'></i><span> Branches</span>
                            </a>
                        </li>
                    
                        <li class="view_class sameclass">
                            <a href="{{Config('app.url')}}/view_class" onclick="nodeLevelActivation('master','0','view_class')">
                                <i><img src="{{Config('app.url')}}/img/icon/course.png" style="height:22px;width:25px;" alt='course'></i><span> Classes / Courses</span>
                            </a>
                        </li>

                        <li class="view_subject sameclass">
                            <a href="{{Config('app.url')}}/view_subject" onclick="nodeLevelActivation('master','0','view_subject')">
                                <i><img src="{{Config('app.url')}}/img/icon/book.png" style="height:22px;width:25px;" alt='book'></i><span> Books</span>
                            </a>
                        </li>

                        <li class="view_chapter sameclass">
                            <a href="{{Config('app.url')}}/view_chapter" onclick="nodeLevelActivation('master','0','view_chapter')">
                                <i><img src="{{Config('app.url')}}/img/icon/chapter.png" style="height:22px;width:25px;" alt='chapter'></i><span> Chapters</span>
                            </a>
                        </li>

                        <li class="view_audiovideo sameclass">
                            <a href="{{Config('app.url')}}/view_audiovideo" onclick="nodeLevelActivation('master','0','view_audiovideo')">
                                <i><img src="{{Config('app.url')}}/img/icon/audio_video.png" style="height:22px;width:25px;" alt='audio_video'></i><span> Audios / Videos</span>
<!-- class="far fa-fw fa-circle " -->
                            </a>
                        </li>

                        <li class="view_questions sameclass">
                            <a href="{{Config('app.url')}}/view_questions" onclick="nodeLevelActivation('master','0','view_questions')">
                                <i><img src="{{Config('app.url')}}/img/icon/activity.png" style="height:22px;width:25px;" alt='activity'></i><span> Activities</span>
                            </a>
                        </li>

                        <li class="view_codegenerators sameclass">
                            <a href="{{Config('app.url')}}/view_codegenerators" onclick="nodeLevelActivation('master','0','view_codegenerators')">
                                <i><img src="{{Config('app.url')}}/img/icon/code.png" style="height:22px;width:25px;" alt='code'></i><span>Registration Codes</span>
                            </a>
                        </li>

                        <li class="change_password sameclass">
                            <a href="{{Config('app.url')}}/change_password" onclick="nodeLevelActivation('master','0','change_password')">
                                   <i class="fas fa-fw fa-key"></i><span> Change Password</span>
                            </a>
                        </li>

                        <li class="logoutuser sameclass">
                            <a href="{{Config('app.url')}}" onclick="nodeLevelActivation('master','0','logoutuser')">
 <i class="fa fa-fw fa-power-off"></i><span>{{ trans('adminlte::adminlte.log_out') }}</span>                            </a>
                        </li>

                    <!-- <li class="">
                    <a href="{{Config('app.url')}}/change_password">
                        <i class="fas fa-fw fa-key"></i><span> Change Password</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{Config('app.url')}}" >
                         <i class="fa fa-fw fa-power-off"></i><span>{{ trans('adminlte::adminlte.log_out') }}</span>
                    </a>
                </li> -->

                        <!-- <li class="view_codegenerators sameclass">
                            <a href="{{Config('app.url')}}/view_codegenerators" onclick="nodeLevelActivation('master','0','view_codegenerators')">
                                <i class="far fa-fw fa-circle "></i><span>Registration Codes</span>
                            </a>
                        </li> -->
                  
                    
             

                <!-- <li class="treeview master">
                    <a href="#" class="master">
                        <i class="fas fa-fw fa-user "></i>
                        <span>Master</span>
                        <span class="pull-right-container"><i class="fas fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu master_class">

                    <li class="view_user  sameclass">
                            <a href="{{Config('app.url')}}/view_user" onclick="nodeLevelActivation('master','0','view_user')">
                                <i class="far fa-fw fa-circle "></i><span> Users</span>
                            </a>
                        </li>

                        <li class="view_school sameclass">
                            <a href="{{Config('app.url')}}/view_school" onclick="nodeLevelActivation('master','0','view_school')">
                                <i class="far fa-fw fa-circle "></i><span> Schools</span>
                            </a>
                        </li>

                        <li class="view_branch sameclass">
                            <a href="{{Config('app.url')}}/view_branch" onclick="nodeLevelActivation('master','0','view_branch')">
                                <i class="far fa-fw fa-circle "></i><span> Branches</span>
                            </a>
                        </li>
                    
                        <li class="view_class sameclass">
                            <a href="{{Config('app.url')}}/view_class" onclick="nodeLevelActivation('master','0','view_class')">
                                <i class="far fa-fw fa-circle "></i><span> Classes / Courses</span>
                            </a>
                        </li>

                        <li class="view_subject sameclass">
                            <a href="{{Config('app.url')}}/view_subject" onclick="nodeLevelActivation('master','0','view_subject')">
                                <i class="far fa-fw fa-circle "></i><span> Books</span>
                            </a>
                        </li>

                        <li class="view_chapter sameclass">
                            <a href="{{Config('app.url')}}/view_chapter" onclick="nodeLevelActivation('master','0','view_chapter')">
                                <i class="far fa-fw fa-circle "></i><span> Chapters</span>
                            </a>
                        </li>

                        <li class="view_audiovideo sameclass">
                            <a href="{{Config('app.url')}}/view_audiovideo" onclick="nodeLevelActivation('master','0','view_audiovideo')">
                                <i class="far fa-fw fa-circle "></i><span> Audios / Videos</span>
                            </a>
                        </li>

                        <li class="view_questions sameclass">
                            <a href="{{Config('app.url')}}/view_questions" onclick="nodeLevelActivation('master','0','view_questions')">
                                <i class="far fa-fw fa-circle "></i><span> Activities</span>
                            </a>
                        </li>

                        <li class="view_codegenerators sameclass">
                            <a href="{{Config('app.url')}}/view_codegenerators" onclick="nodeLevelActivation('master','0','view_codegenerators')">
                                <i class="far fa-fw fa-circle "></i><span>Registration Codes</span>
                            </a>
                        </li>
                  
                    </ul>
                </li>              -->
            

                <!-- <li class="header">ACCOUNT SETTINGS</li>
                <li class="">
                    <a href="{{Config('app.url')}}/change_password">
                        <i class="fas fa-fw fa-key"></i><span> Change Password</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{Config('app.url')}}" >
                         <i class="fa fa-fw fa-power-off"></i><span>{{ trans('adminlte::adminlte.log_out') }}</span>
                    </a>
                </li> -->

                 <!-- <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                            @else
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                                <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                    @if(config('adminlte.logout_method'))
                                        {{ method_field(config('adminlte.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li> -->



               


                

</ul>



            </section>

        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

        @hasSection('footer')
        <footer class="main-footer">
            @yield('footer')
        </footer>
        @endif

    </div>
    <!-- ./wrapper -->
@stop


@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

    
<!-- validationEngine JS START ============================================ -->
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validationEngine-en.js') }}"></script>
    <script src="{{ asset('js/jquery.validationEngine.js') }}"></script>
<!-- validationEngine JS END ============================================ -->

<!--Data Table-->
<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>

    <!--Export table buttons-->
    <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js" ></script>
    <script type="text/javascript"  src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>

<!--Export table button CSS-->

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

<script>
    $().ready(function(){
        $('.select2').select2();
        $('.select_course2').select2();
         //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      dateFormat: 'dd-mm-yy' 
    })

        jQuery(".form_validation").validationEngine(); // used for form validation

        $.ajax({
            type:'get',
            url:"{{Config('app.url')}}master/get_all_menu",
            dataType:'json',
            success:function(data)
            {
                var master = "";
                var wareh1 = "";
                var wareh2 = "";
                var wareh3 = "";

                for(var a=0;a<data.allmenu.length;a++)
                {
                    if(data.allmenu[a]['user_type']=='m')
                    {
                        master += ""
                    }
                }
            }
        });

        var active_first_level = localStorage.getItem('active_first_level');
        $('.'+active_first_level).addClass('active');

        var active_second_level = localStorage.getItem('active_second_level');
        $('.'+active_second_level).addClass('active');

        var active_third_level = localStorage.getItem('active_third_level');
        $('.'+active_third_level).addClass('active');

        $('#example').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                           // 'copy', 'csv', 'excel', 'pdf', 'print'
                           'excel','pdf'
                        ]
                    });
    });


    function nodeLevelActivation(firstlevel,secondlevel,thirdlevel)
    {
        localStorage.setItem('active_first_level',firstlevel);
        $('.'+firstlevel).addClass('active');

        localStorage.setItem('active_second_level',secondlevel);
        $('.'+secondlevel).addClass('active');

        localStorage.setItem('active_third_level',thirdlevel);
        $('.'+thirdlevel).addClass('active');
    }

    function removeall()
    {
        localStorage.setItem('active_first_level','sucafina');
        $('.sucafina').addClass('active');
        $('.release-order').addClass('active');
        localStorage.setItem('active_second_level','');
        localStorage.setItem('active_third_level','');
    }
</script>
    @stack('js')
    @yield('js')
@stop