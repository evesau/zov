<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\models\Menu as MenuDao;

class Contenedor{

    public function header($extra = ''){

        MasterDom::verificaUsuario();

        if ($_SESSION['img'] == '') { $_SESSION['img'] = 'placeholder_logo.png'; }

$html=<<<html
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>: SMS : La Voz M&eacute;xico :</title>

        <link href="/css/bootstrap.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="/css/sb-admin-2.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="/css/metisMenu.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="/css/timeline.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="/css/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Select2 -->
        <link href="/css/select2.min.css" rel="stylesheet">

         <!-- Switchery -->
        <link href="/css/switchery.min.css" rel="stylesheet">

        <!-- iCheck -->
        <link href="/css/green.css" rel="stylesheet">

        <!-- dropzone -->
        <link href="/css/dropzone.min.css" rel="stylesheet">


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link href="/css/nprogress.css" rel="stylesheet"/>
        <link href="/css/green.css" rel="stylesheet"/>
        <link href="/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <link href="/css/jqvmap.min.css" rel="stylesheet">
        <link href="/css/custom.min.css" rel="stylesheet">

        <link href="/css/alertify/alertify.css" rel="stylesheet">
        <link href="/css/alertify/alertify.min.css" rel="stylesheet">
        <link href="/css/alertify/alertify.rtl.css" rel="stylesheet">
        <link href="/css/alertify/alertify.rtl.min.css" rel="stylesheet">

        <link href="/css/alertify/themes/bootstrap.rtl.css" rel="stylesheet">
        <link href="/css/alertify/themes/bootstrap.rtl.min.css" rel="stylesheet">
        <link href="/css/alertify/themes/default.css" rel="stylesheet">
        <link href="/css/alertify/themes/default.min.css" rel="stylesheet">
        <link href="/css/alertify/themes/default.rtl.css" rel="stylesheet">
        <link href="/css/alertify/themes/default.rtl.min.css" rel="stylesheet">
        <link href="/css/alertify/themes/semantic.css" rel="stylesheet">
        <link href="/css/alertify/themes/semantic.min.css" rel="stylesheet">
        <link href="/css/alertify/themes/semantic.rtl.css" rel="stylesheet">
        <link href="/css/alertify/themes/semantic.rtl.min.css" rel="stylesheet">

        $extra

    </head>
html;

$html_default = <<<html
    <body class="nav-md footer_fixed">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="/Principal" class="site_title"><i class="glyphicon glyphicon-comment"></i> <span>SMS</span></a>
                        </div>
                        <div class="navbar nav_title"   >
                            <img class="center-block img-responsive" src="/img/customer/voz.png" style="max-height: 90px; width: auto" />
                        </div>
                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                <img src="/img/usr/user.png" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span><strong>Bienvenido,</strong></span>
                                <h2>{$_SESSION['usuario']}</h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                            	<br><br>
                                <center><h3>MENÚ</h3></center>
                                <ul class="nav side-menu">
                                    
                                    <li><a><i class="fa fa-home"></i> Dashboard <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/Principal">Principal</a></li>
                                        </ul>
                                    </li>

                                    <li><a><i class="fa fa-table"></i> Reportes <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/Reporte">Reporte General</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="/user"><i class="fa fa-expeditedssl"></i>Profile</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--/sidebar menu-->
                    </div>
                </div>

                <!-- /menu footer buttons -->
                <!--
                <div class="sidebar-footer hidden-small">
                    Botón "Settings"
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>

                    <a data-toggle="tooltip" data-placement="top" title="FullScreen" onclick="launchFullScreen(document.documentElement);">
                    <input type="button" onclick="launchFullScreen(document.documentElement);">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </input>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout" href="/Login/logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                -->
                <!-- /menu footer buttons -->

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="#" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="/img/usr/user.png" alt=""> <strong>{$_SESSION['name']} {$_SESSION['last_name']} </strong>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="/user"><i class="fa fa-expeditedssl pull-right"></i> Profile</a></li>
                                        <li><a href="/Login/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            <!-- page content -->
            <div class="right_col" role="main">
html;
        return $html.$html_default;
}

    public function footer($extra = ''){
    $html=<<<html
            </div>
            <!-- /page content /-->
        </div>
        <!-- /#page-wrapper -->
    <!-- FIN CONTENEDOR -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/js/sb-admin-2.js"></script>

    <!-- Switchery -->
    <script src="/js/switchery.min.js"></script>

     <!-- iCheck -->
    <script src="/js/icheck.min.js"></script>

    <script src="/js/extras/modernizr-custom.js"></script>

    <!-- polyfiller file to detect and load polyfills -->
    <script src="/js/polyfiller.js"></script>

    <!-- tags1 -->
    <script src="/js/jquery.tagsinput.js"></script>

    <!-- dropzone -->
    <script src="/js/dropzone.min.js"></script>

    <script>
      webshims.setOptions('waitReady', false);
      webshims.setOptions('forms-ext', {types: 'date'});
      webshims.polyfill('forms forms-ext');
    </script>

    <script src="/js/nprogress.js"></script>
    <script src="/js/custom.min.js"></script>
    <script src="/js/select2.full.min.js"></script>
    <script src="/js/alertify/alertify.min.js"></script>
    <script src="/js/alertify/alertify.js"></script>

    <!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Elija uno de la lista...",
          allowClear: true
        });
        $(".select2_multiple").select2({
          //maximumSelectionLength: 4,
          placeholder: "Elija una o varias opciones...",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->

    <!-- <script>
        var fullscreen = function(e){
          if (e.webkitRequestFullScreen) {
            e.webkitRequestFullScreen();
          } else if(e.mozRequestFullScreen) {
            e.mozRequestFullScreen();
          } else if(e.requestFullScreen) {
            e.requestFullScreen();
          }
      }
    document.getElementById('fullscreen').onclick = function(){
        fullscreen(document.getElementById('content'));
    }
    </script> -->

    <script language="javascript">
    // buscamos el metodo para los tipos de navegadores
    function launchFullScreen(element) {
      if(element.requestFullScreen) {
        element.requestFullScreen();
      } else if(element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
      } else if(element.webkitRequestFullScreen) {
        element.webkitRequestFullScreen();
      }
    }
    </script>


    $extra

</body>
</html>
html;

    return $html;
    }

    public function headerLogin($extra = ''){
        $html=<<<html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>: SMS : La Voz M&eacute;xico :</title>
    <!-- styles -->
    <link href="/css/style-login.css" rel="stylesheet">

    $extra

</head>
<body>
html;
        return $html;
    }

    public function footerLogin($extra = ''){
       $html=<<<html
<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
<script>
    $(document).ready(function (){

        $('.virtual-signin').click(function(){
            var username = $('#username').val();
            var password = $('#password').val();

            if(username == '' && password == '') {
                $(".form").addClass('animated bounce');
                $(".form").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                    $(this).removeClass('animated bounce');
                });
            }else if(username == ''){
                $("#username").addClass('animated shake');
                $("#username").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                    $(this).removeClass('animated shake');
                });
            }else if(password == ''){
                $("#password").addClass('animated shake');
                $("#password").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                    $(this).removeClass('animated shake');
                });
            }else{
                setTimeout(function(){
                    $('.virtual-signin').html('<i id="gear"></i>')
                }, 0000);
                /* Check User-Data with Database and Display Result */
                setTimeout(function(){
                    $('.virtual-signin').html('<span class="fontawesome-unlock unlock"></span>')
                }, 5000);
                /* Sign-in successful Message */
                setTimeout(function(){
                    $('.signin-form').addClass('animated fadeOut');
                    $(".signin-form").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                        $(this).removeClass('animated fadeOut');
                    });
                    $('.signin-form').html('<h2 class="Successful">Sign-In Successful</h2>');
                }, 7000);
            }
        });
    });
</script>

</body>
</html>
html;
       return $html;
    }

}
