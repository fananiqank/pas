<?php
session_start();
require_once"webclass.php";
$db = new kelas();

include_once"apps/layouts/page.php";

if(empty($_SESSION['ID_PEG'])){
include"login.php";  
} else {

//stok minimum
$tablenst = "(select b.id_barang, nama_barang,IFNULL(b.min_stock,0) as min_stock,IFNULL(b.max_stock,0) as max_stock,IFNULL(stok,0) stok,IFNULL((stok-min_stock),0) balance from m_barang b left join (select IFNULL(sum(masukmutasi)-sum(keluarmutasi),0) as stok,id_barang from tx_mutasi GROUP BY id_barang) a on b.id_barang=a.id_barang) as asi";
$selnst = $db->select($tablenst,"*","balance <= 0");
$jmlnst = $db->selectcount($tablenst,"nama_barang","balance <= 0");

?>


<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>DASH</title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">
        <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/validation/form-validation.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->
    
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern vertical-collapsed-menu 2-columns fixed-navbar pace-done menu-expanded" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item mr-auto"><a class="navbar-brand" href="index.html"><img class="brand-logo" alt="modern admin logo" src="app-assets/images/logo/logo.png">
                            <h3 class="brand-text">Dash TI</h3>
                        </a></li>
                    <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i></a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                        
                        
                    </ul>
                    <ul class="nav navbar-nav float-right">
                         <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                                <!-- <i class="ficon ft-bell"></i> -->
                                <i class="ficon ft-alert-triangle"></i>
                                Min. Stock
                                <span class="badge badge-pill badge-danger badge-up badge-glow"><?=$jmlnst;?></span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">

                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Minimum Stock</span></h6>
                                    <span class="notification-tag badge badge-danger float-right m-0">
                                        <a href="index.php?x=lapminstock">Check</a>
                                    </span>
                                </li>
                                <li class="scrollable-container media-list w-100">
                                <?php foreach($selnst as $nst){ ?>
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <!-- <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan mr-0"></i></div> -->
                                            <div class="media-body">
                                                <h6 class="media-heading"><?=$nst['nama_barang']?><span style="float:right"><?=$nst['stok']?></span></h6>
                                                <!-- <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time></small> -->
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                                </li>
                            
                                <!-- <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li> -->
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700"><?php echo $_SESSION[NAMA_PEG]?></span><span class="avatar avatar-online"><!-- <img src="../../../app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"> --><i></i></span></a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="user-profile.html"><i class="ft-user"></i> Edit Profile</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="apps/layouts/logout.php"><i class="ft-power"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->  
    <?php require_once("apps/layouts/sidebar_db.php"); ?>
    <!-- END: Main Menu-->
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="row">
                        <div class="col">
                            <?php
                                // echo "salkslakls ".$content;
                                include $_SESSION['CONTENT'][$_GET[x]]['FCONTENT'];
                            ?>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2021 <a class="text-bold-800 grey darken-2" href="javascript:void(0)" target="_blank">DASH TI</a></span><span class="float-md-right d-none d-lg-block">ModernAdmin<i class="ft-heart pink"></i><span id="scroll-top"></span></span></p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/charts/chart.min.js"></script>
    <script src="app-assets/vendors/js/charts/raphael-min.js"></script>
    <script src="app-assets/vendors/js/charts/morris.min.js"></script>
    <script src="app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js"></script>
    <script src="app-assets/data/jvector/visitor-data.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.js"></script>
    <script src="app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script src="app-assets/js/scripts/pages/dashboard-sales.js"></script>
    <script src="app-assets/js/scripts/extensions/ex-component-sweet-alerts.js"></script>
    <!-- END: Page JS-->
    <script type="text/javascript">
        (function ($) {
            $.fn.serializeFormJSON = function () {

                var o = {};
                var a = this.serializeArray();
                $.each(a, function () {
                    if (o[this.name]) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });
                return o;
            };
        })(jQuery);
    </script>
    <?php 
        include $_SESSION['CONTENT'][$_GET[x]]['FJS'];
    ?>

</body>
<!-- END: Body-->

</html>
<?php } ?>