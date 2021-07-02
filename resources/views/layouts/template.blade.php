<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="description" content="Miminium Admin Template v.1">
    <meta name="author" content="Isna Nur Azis">
    <meta name="keyword" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>LVQ</title>
    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}">

    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/datatables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/animate.min.css')}}"/>
    <link href="{{asset('asset/css/style.css')}}" rel="stylesheet">
    <!-- end: Css -->

    <link rel="shortcut icon" href="{{asset('asset/img/logo.png')}}">

</head>
<SCRIPT language=Javascript>
    function err(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode != 46 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</SCRIPT>
<body id="mimin" class="dashboard">
    <nav class="navbar navbar-default header navbar-fixed-top">
        <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
                <div class="opener-left-menu is-open">
                    <span class="top"></span>
                    <span class="middle"></span>
                    <span class="bottom"></span>
                </div>
                <a href="index.html" class="navbar-brand"> 
                    <b>LVQ</b>
                </a>
                <ul class="nav navbar-nav navbar-right user-nav">
                    <li class="user-name"><span>Gilang Tri Wijaya</span></li>
                    <li class="dropdown avatar-dropdown">
                    <img style="cursor: pointer" src="asset/img/avatar.jpg" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
                        <ul class="dropdown-menu user-dropdown">
                            <li><a href="#" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><span class="fa fa-sign-out"></span> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div> 
    </nav>
    <form id="logout-form" action="" method="POST" style="display: none;">
        @csrf
    </form>
    <!-- end: Header -->
    <div class="container-fluid mimin-wrapper">
        <div id="left-menu">
            <div class="sub-left-menu scroll">
                <ul class="nav nav-list">
                    <li class="{{Request::path() === '/' ? 'active': ''}} ripple"><a href="{{route('home')}}"><span class="fa fa-home"></span>Dashboard</a></li>
                    <li class="{{Request::path() === 'list-data' ? 'active': ''}} ripple"><a href="{{route('dataset.index')}}"><span class="fa fa-database"></span>Dataset</a></li>
                    <li class="{{Request::path() === 'training' ? 'active': ''}} ripple"><a href="{{route('data.training')}}"><span class="fa fa-calculator"></span>Data Training</a></li>
                    <li class="{{Request::path() === 'testing' ? 'active': ''}} ripple"><a href="{{route('data.testing')}}"><span class="fa fa-laptop"></span>Data Testing</a></li>

                </ul>
            </div>
        </div>
        <div id="content" class="article-v1">
            <div class="panel box-shadow-none content-header">
                <div class="panel-body">
                    <div class="col-md-12">
                        @yield('breadcrumb')
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end: Content -->
<!-- start: Javascript -->
<script src="{{asset('asset/js/jquery.min.js')}}"></script>
<script src="{{asset('asset/js/jquery.ui.min.js')}}"></script>
<script src="{{asset('asset/js/bootstrap.min.js')}}"></script>


<!-- plugins -->
<script src="{{asset('asset/js/plugins/moment.min.js')}}"></script>
<script src="{{asset('asset/js/plugins/jquery.nicescroll.js')}}"></script>
<script src="{{asset('asset/js/plugins/jquery.datatables.min.js')}}"></script>
<script src="{{asset('asset/js/plugins/datatables.bootstrap.min.js')}}"></script>
<script src="{{asset('js/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{asset('asset/js/plugins/jquery.validate.min.js')}}"></script>


<!-- custom -->
<script src="{{asset('asset/js/main.js')}}"></script>
<!-- end: Javascript -->

@yield('js')
</body>
</html>