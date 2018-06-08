<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <title>Inversiones OSA | Panel Administrativo</title>
    <!-- Css Files -->
    <link href="/css/root.css" rel="stylesheet">
</head>
<body ng-app="InvosaApp">
    <!-- Start Page Loading -->
    <div class="loading"><img src="img/loading.gif" alt="loading-img"></div>
    <!-- End Page Loading --> 
    <!-- Start Top -->
    <div id="top" class="clearfix"> 
        <!-- Start App Logo -->
        <div class="applogo"> <a href="index.html" class="logo">Invosa</a> </div>
        <!-- End App Logo --> 
        <!-- Start Sidebar Show Hide Button --> 
        <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a> <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a> 
        <!-- End Sidebar Show Hide Button --> 
        <!-- Start Top Right -->
        <ul class="top-right">
            <li class="dropdown link"> <a href="#" data-toggle="dropdown" class="dropdown-toggle profilebox"><img src="{{ Auth::user()->avatar }}" alt="img"><b>{{ Auth::user()->fullname }}</b><span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
                    <li><a href="#"><i class="fa falist fa-power-off"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
        <!-- End Top Right --> 
    </div>
    <!-- End Top --> 
    <!-- Start Sidabar -->
    <div class="sidebar clearfix">
        <ul class="sidebar-panel nav metismenu" id="side-menu" data-plugin="metismenu">
            <li>
                <a href="#!dashboard">
                    <span class="icon color7"><i class="fa fa-home" aria-hidden="true"></i></span>Dashboard
                </a>
            </li>
            <li>
                <a href="#!rutas">
                    <span class="icon color7"><i class="fa fa-arrows-h" aria-hidden="true"></i></span>Rutas
                </a>
            </li>
        </ul>
    </div>
    <!-- End Sidabar --> 
    <!-- Start Content -->
    <div id="page-wrapper" class="content"> 
        <!-- Start Container -->
        <div class="container-default animated fadeInRight"> <br>
            <ui-view></ui-view>
        </div>
        <!-- End Container --> 
        <!-- Start Footer -->
        <div class="row footer">
            <div class="col-md-12 text-right"> Copyright &copy; {{ \Carbon\Carbon::now()->year }} Inversiones OSA. </div>
        </div>
        <!-- End Footer --> 
    </div>
    <!-- End Content -->
    <!-- jQuery Library --> 
    <script type="text/javascript" src="js/jquery.min.js"></script> 
    <!-- Bootstrap Core JavaScript File -->
    <!--
    <script src="js/bootstrap/tether.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    -->
    <!-- AngularJS -->
    <script src="js/angularjs/angular.min.js"></script>
    <script src="js/angularjs/angular-sanitize.min.js"></script>
    <script src="js/angularjs/angular-animate.min.js"></script>
    <script src="js/angularjs/angular-ui-router.min.js"></script>
    <script src="js/angularjs/ocLazyLoad.min.js"></script>
    <script src="js/angularjs/ui-bootstrap-tpls.min.js"></script>
    <script src="js/toastr/toastr.min.js"></script>
    
    <script src="js/app.js"></script>

    <!--<script src="js/angularjs/router-module.js"></script>-->


    <!-- Plugin.js - Some Specific JS codes for Plugin Settings --> 
    <script type="text/javascript" src="js/plugins.js"></script>
    <!-- MetisMenu --> 
    <script type="text/javascript" src="js/metismenu/metisMenu.min.js"></script>
    <script type="text/javascript">
        var troncales = {!! App\Models\Trunk::all() !!};
    </script>
</body>
</html>