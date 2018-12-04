<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \App\models\Principal as principalDao;

class Principal{
	private $_contenedor;

    function __construct(){
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    public function index(){

    	$customer = MasterDom::getSession('name_customer');
    	$usuario = MasterDom::getSession('usuario');

        $extraHeader =<<<html
    <!-- iCheck -->
    <link href="master/content/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <!--link href="master/content/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet"-->

    <!-- bootstrap-daterangepicker -->
    <link href="master/content/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

html;

        $extraFooter =<<<html
    <!-- FastClick -->
    <script src="master/content/vendors/fastclick/lib/fastclick.js"></script>
    <!-- Chart.js -->
    <script src="master/content/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="master/content/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="master/content/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="master/content/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="master/content/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="master/content/vendors/Flot/jquery.flot.js"></script>
    <script src="master/content/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="master/content/vendors/Flot/jquery.flot.time.js"></script>
    <script src="master/content/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="master/content/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="master/content/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="master/content/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="master/content/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="master/content/vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="master/content/vendors/moment/min/moment.min.js"></script>
    <script src="master/content/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>
    $(document).ready(function() {
    });

    $("input:checkbox").click(function(){
        var arrayValues = [];

        $("input:checkbox:not(:checked)").each(function(i){
            var valores = $(this).val();
            console.log(valores);
            arrayValues.push(valores);
        });

        $.ajax({
            method: "POST",
            url: "/Principal/desactivaPartipante",
            data: {id_partipante: arrayValues}
            })
            .done(function( msg ) {
                console.log( "Save: " + msg );
                location.reload();
        });

        console.log(arrayValues);
    });
    </script>
html;
        $datos =<<<html
    <h1> La Voz M&eacute;xico</h1>
    <h2> Bienvenido $usuario</h2>
html;

        $participantes = principalDao::getAll();
        $tsms = 0;
        $sumaSms = 0;
        foreach ($participantes as $key => $value) {
            $checked = ($value['activo']==1) ? 'checked' : '';
            $listaParticipantes .=<<<html
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-check-square-o"></i></div>
html;
            if ($value['activo']==1) {
                if(preg_match("/GUILLERMO/", strtoupper($value['nombre']))){
                    $tsms = count(principalDao::getSmsGuillermo());
                    $sumaSms = $sumaSms + $tsms;
                    $listaParticipantes .=<<<html
                    <h1>$tsms</h1>
html;
                } elseif (preg_match("/DULCE/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsDulce());
                    $sumaSms = $sumaSms + $tsms;
                    $listaParticipantes .=<<<html
                    <h1>$tsms</h1>
html;
                } elseif (preg_match("/NACHO/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsNacho());
                    $sumaSms = $sumaSms + $tsms;
                    $listaParticipantes .=<<<html
                    <h1>$tsms</h1>
html;
                } elseif (preg_match("/MORGANNA/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsMorganna());
                    $sumaSms = $sumaSms + $tsms;
                    $listaParticipantes .=<<<html
                    <h1>$tsms</h1>
html;
                } elseif (preg_match("/LUANNA/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsLuanna());
                    $sumaSms = $sumaSms + $tsms;
                    $listaParticipantes .=<<<html
                    <h1>$tsms</h1>
html;
                } elseif (preg_match("/ADRIANA/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsAdrianaCristian());
                    $sumaSms = $sumaSms + $tsms;
                    $listaParticipantes .=<<<html
                    <h1>$tsms</h1>
html;
                } elseif (preg_match("/CINDY/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsCindy());
                    $sumaSms = $sumaSms + $tsms;
                    $listaParticipantes .=<<<html
                    <h1>$tsms</h1>
html;
                } elseif (preg_match("/DIANA/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsDiana());
                    $sumaSms = $sumaSms + $tsms;
                    $listaParticipantes .=<<<html
                    <h1>$tsms</h1>
html;
                } else {
                    $listaParticipantes .=<<<html
                    <h1>0</h1>
html;
                }
            } else {
                $listaParticipantes .=<<<html
                    <h1>0</h1>
html;
            }
            $listaParticipantes .=<<<html
                <h3>{$value['nombre']}</h3>
                <input class="count" type="checkbox" id="chkBox{$value['id']}" name="chkBoxParticipante[]" value="{$value['id']}" $checked/><span> Clic para mostrar en el Top</span>
            </div>
        </div>
html;
        }
        

        $htmlExtra =<<<html
    <div class="row top_tiles">
        $listaParticipantes
    </div>
html;

        $participantesActivos = principalDao::getParticipantesActivos();

        foreach ($participantesActivos as $key => $value) {

            $nombreParticipante .=<<<html
                        <div>
                            <p>{$value['nombre']}</p>
                            <div class="progress">
html;

            if(preg_match("/GUILLERMO/", strtoupper($value['nombre']))){
                    $tsms = count(principalDao::getSmsGuillermo());
                    $porcentaje = round(((100/$sumaSms)*$tsms), 2);
                    $nombreParticipante .=<<<html
                                <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: $porcentaje%;" aria-valuenow="$porcentaje" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="$porcentaje%">
                                    <b style="color:black;">$porcentaje%</b>
                                </div>
html;
                } elseif (preg_match("/DULCE/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsDulce());
                    $porcentaje = round(((100/$sumaSms)*$tsms), 2);
                    $nombreParticipante .=<<<html
                                <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: $porcentaje%;" aria-valuenow="$porcentaje" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="$porcentaje%">
                                    <b style="color:black">$porcentaje%</b>
                                </div>
html;
                } elseif (preg_match("/NACHO/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsNacho());
                    $porcentaje = round(((100/$sumaSms)*$tsms), 2);
                    $nombreParticipante .=<<<html
                                <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: $porcentaje%;" aria-valuenow="$porcentaje" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="$porcentaje%">
                                    <b style="color:black">$porcentaje%</b>
                                </div>
html;
                } elseif (preg_match("/MORGANNA/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsMorganna());
                    $porcentaje = round(((100/$sumaSms)*$tsms), 2);
                    $nombreParticipante .=<<<html
                                <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: $porcentaje%;" aria-valuenow="$porcentaje" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="$porcentaje%">
                                    <b style="color:black">$porcentaje%</b>
                                </div>
html;
                } elseif (preg_match("/LUANNA/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsLuanna());
                    $porcentaje = round(((100/$sumaSms)*$tsms), 2);
                    $nombreParticipante .=<<<html
                                <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: $porcentaje%;" aria-valuenow="$porcentaje" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="$porcentaje%">
                                    <b style="color:black">$porcentaje%</b>
                                </div>
html;
                } elseif (preg_match("/ADRIANA/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsAdrianaCristian());
                    $porcentaje = round(((100/$sumaSms)*$tsms), 2);
                    $nombreParticipante .=<<<html
                                <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: $porcentaje%;" aria-valuenow="$porcentaje" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="$porcentaje%">
                                    <b style="color:black">$porcentaje%</b>
                                </div>
html;
                } elseif (preg_match("/CINDY/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsCindy());
                    $porcentaje = round(((100/$sumaSms)*$tsms), 2);
                    $nombreParticipante .=<<<html
                                <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: $porcentaje%;" aria-valuenow="$porcentaje" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="$porcentaje%">
                                    <b style="color:black">$porcentaje%</b>
                                </div>
html;
                } elseif (preg_match("/DIANA/", strtoupper($value['nombre']))) {
                    $tsms = count(principalDao::getSmsDiana());
                    $porcentaje = round(((100/$sumaSms)*$tsms), 2);
                    $nombreParticipante .=<<<html
                                <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: $porcentaje%;" aria-valuenow="$porcentaje" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="$porcentaje%">
                                    <b style="color:black">$porcentaje%</b>
                                </div>
                                <div>$tsms</div>
html;
                } else {
                    
                }
            $nombreParticipante .=<<<html
                            </div>
                        </div>
html;
        }

        $htmlExtra .=<<<html
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_title">
                        <h2>Top Participantes</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        $nombreParticipante
                </div>                

                <div class="clearfix"></div>
            </div>
        </div>

    </div>
    <br />
html;

    	View::set('datosCustomer', $datos);
        View::set('htmlExtra',$htmlExtra);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("principal");
    }

    public function desactivaPartipante(){
        $participantes = principalDao::getAll();
        $ids = MasterDom::getDataAll('id_partipante');
        $desctivables = array();
        $activados = array();
        foreach ($participantes as $key => $value) {
            array_push($activados, $value['id']);
            foreach ($ids as $key => $val) {
                if ($val == $value['id']) {
                    array_push($desctivables, $val);
                }
            }
        }

        $diff = array_diff($activados, $desctivables);

        foreach ($desctivables as $key => $value) {
            @principalDao::updateActivo($value,0);
        }

        foreach ($diff as $key => $value) {
            @principalDao::updateActivo($value,1);
        }
        //mail("esau.espinoza@airmovil.com", "desactivaPartipante diff", print_r($desctivables,1) . print_r($diff,1));
        echo "success";
        exit;
    }

}