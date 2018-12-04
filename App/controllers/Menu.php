<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\models\Menu as MenuDao;
use \App\models\CampaignBuscaCarrier as CampaignDao;
use \App\controllers\Contenedor;

class Menu
{

private $_contenedor;

    function __construct() { 
	$this->_contenedor = new Contenedor;
	View::set('header',$this->_contenedor->header());
	View::set('footer',$this->_contenedor->footer());
    }

    /**
     * [metodo default para la vista]
     * @return [View render]
     * @see interface
     */
    public function index() {
        MasterDom::verificaUsuario();

        $id_customer = MasterDom::getSession('customer_id');
        $fecha = date('Y-m-01');

        $dataMt = new \stdClass();
        $dataMt->fecha = $fecha;
        $dataMt->customer_id = $id_customer;
        //print_r($dataMt);

        /*********************Total MT Messages***************************/
        //if($id_customer == 1){

          $mts = MenuDao::getMtMonthCustomer($dataMt);
          $noarray =  count($mts);
          //echo "$noarray";
          if ($noarray > 0) {
            foreach ($mts as $key => $value) {
              
              if ($value['carriers'] == 'telcel') {
                $resultado_total_MT_Telcel = $value['total'];
              }

              if ($value['carriers'] == 'movistar') {
                $resultado_total_MT_Movistar = $value['total'];
              }

              if ($value['carriers'] == 'att') {
                $resultado_total_MT_Att = $value['total'];
              }

            }
            
          } else {
            $resultado_total_MT_Telcel = 0;
            $resultado_total_MT_Movistar =0;
            $resultado_total_MT_Att =0;

          }

        /*} else {

          $total_MT_Telcel =  MenuDao::getAllMT_Telcel($id_customer);
          //print_r($total_MT_Telcel);
          if (!empty($total_MT_Telcel)) {
            $resultado_total_MT_Telcel = $total_MT_Telcel['total'];
          } else {
            $resultado_total_MT_Telcel = 0;
          }
          

          $total_MT_Movistar =  MenuDao::getAllMT_Movistar($id_customer);
          if (!empty($total_MT_Movistar)) {
            $resultado_total_MT_Movistar = $total_MT_Movistar['total'];
          } else {
            $resultado_total_MT_Movistar =0;
          }
          

          $total_MT_Att =  MenuDao::getAllMT_Att($id_customer);
          if (!empty($total_MT_Att)) {
            $resultado_total_MT_Att = $total_MT_Att['total'];
          } else {
            $resultado_total_MT_Att =0;
          }

        }*/
        
        
      /***************************************************************/

      $mes = date('n');
      $meses = array (1 =>  'Enero',
                      2 =>  'Febrero',
                      3 =>  'Marzo',
                      4 =>  'Abril',
                      5 =>  'Mayo',
                      6 =>  'Junio',
                      7 =>  'Julio',
                      8 =>  'Agosto',
                      9 =>  'Septiembre',
                      10  =>  'Octubre',
                      11  =>  'Noviembre',
                      12  =>  'Diciembre');

      foreach ($meses as $key => $value) {
        if ($mes == $key) {
          $mes_actual = $value.' '.date('Y');
        }
      }


        $extraHeader = <<<html
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <link href="/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

            <script type="text/javascript">

                // Load chart and the corechar package - Draw the pie char for the Total Campaign Messages and MT-MO Chart
                 google.charts.load('current', {'packages':['corechart']});

                //Draw the pie chart for Total Campaign Messages and MT-MO Chart
                 google.charts.setOnLoadCallback(drawTotalMTMessagesChart);
                 //google.charts.setOnLoadCallback(drawMTMOTelcelChart);
                 //google.charts.setOnLoadCallback(drawMTMOMovistarChart);
                 //google.charts.setOnLoadCallback(drawMTMOAttChart);
                 //google.charts.setOnLoadCallback(drawTotalMOMessagesChart);

               // *******************************************************************************************

               //Callback that draws the pie chart for Total Messages
              function drawTotalMTMessagesChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Carrier', 'Total MT Messages', { role: 'style' } ],
                    ['Telcel', $resultado_total_MT_Telcel, 'stroke-color: #0C1B7C; stroke-opacity: 0.6; stroke-width: 7; fill-color: #0C1B7C; fill-opacity: 0.2'],
                    ['Movistar', $resultado_total_MT_Movistar, 'stroke-color: #1B7C0C; stroke-opacity: 0.6; stroke-width: 7; fill-color: #1B7C0C; fill-opacity: 0.2'],
                    ['AT&T', $resultado_total_MT_Att, 'stroke-color: #DF8D23; stroke-opacity: 0.6; stroke-width: 7; fill-color: #DF8D23; fill-opacity: 0.2']
                  ]);

                  var view = new google.visualization.DataView(data);
                  view.setColumns([0, 1,
                                   { calc: "stringify",
                                     sourceColumn: 1,
                                     type: "string",
                                     role: "annotation" },
                                   2]);

                  var options = {
                    title: "Total MT Messages    .: $mes_actual :.",
                    height: 400,
                    fontName: 'Arial',
                    bar: {groupWidth: "95%"},
                    legend: { position: "none" },
                    hAxis: { minValue: 6, format: '0'}

                  };
                  var chart = new google.visualization.BarChart(document.getElementById('TotalMTM'));
                                chart.draw(data, options);
                }

                // Añadimos esta linea para refrescar grafica Esaú 07/11/2017
                setInterval(drawTotalMTMessagesChart, 1000);

              // ******************************************************************************************** 

               //Callback that draws the column chart for MT & MO Messages for Telcel 

               /*function drawMTMOTelcelChart() {
                  
                    var data = google.visualization.arrayToDataTable([
                      ['Total', 'Total Messages'],
                      ['MT', $resultado_MT_Telcel],
                      ['MO', $resultado_MO_Telcel]
                    ]);

                    var options = {
                      title: 'Telcel',
                      backgroundColor: { fill:'transparent' },
                      is3D: true,
                      colors : ['#2A8690','#C67C0E'],
                      fontName: 'Arial'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('MT/MO_Telcel'));
                    chart.draw(data, options);
                  }*/

             // ********************************************************************************************

              //Callback that draws the column chart for MT & MO Messages for Movistar

              /*function drawMTMOMovistarChart() {
                var data = google.visualization.arrayToDataTable([
                      ['Total', 'Total Messages'],
                      ['MT', $resultado_MT_Movistar],
                      ['MO', $resultado_MO_Movistar]
                    ]);

                    var options = {
                      title: 'Movistar',
                      backgroundColor: { fill:'transparent' },
                      pieHole: 0.3,
                      //is3D: true,
                      colors : ['#2A8690','#C67C0E'],
                      fontName: 'Arial'
                    }

                    var chart = new google.visualization.PieChart(document.getElementById('MT/MO_Movistar'));
                    chart.draw(data, options);
                  }*/

            // *********************************************************************************************

              //Callback that draws the column chart for MT & MO Messages for At&t

              /*function drawMTMOAttChart() {
                var data = google.visualization.arrayToDataTable([
                      ['Total', 'Total Messages'],
                      ['MT', $resultado_MT_Att],
                      ['MO', $resultado_MO_Att]
                    ]);

                    var options = {
                      title: 'AT&T',
                      backgroundColor: { fill:'transparent' },
                      is3D: true,
                      colors : ['#2A8690','#C67C0E'],
                      fontName: 'Arial'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('MT/MO_Att'));
                    chart.draw(data, options);
                  }*/

            // *******************************************************************************************
               //Callback that draws the pie chart for Total Messages
              /*function drawTotalMOMessagesChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Carrier', 'Total MO Messages', { role: 'style' } ],
                    ['Telcel', $resultado_total_MO_Telcel, 'stroke-color: #0C1B7C; stroke-opacity: 0.6; stroke-width: 7; fill-color: #0C1B7C; fill-opacity: 0.2'],
                    ['Movistar', $resultado_total_MO_Movistar, 'stroke-color: #1B7C0C; stroke-opacity: 0.6; stroke-width: 7; fill-color: #1B7C0C; fill-opacity: 0.2'],
                    ['AT&T', $resultado_total_MO_Att, 'stroke-color: #DF8D23; stroke-opacity: 0.6; stroke-width: 7; fill-color: #DF8D23; fill-opacity: 0.2']
                  ]);

                  var view = new google.visualization.DataView(data);
                  view.setColumns([0, 1,
                                   { calc: "stringify",
                                     sourceColumn: 1,
                                     type: "string",
                                     role: "annotation" },
                                   2]);

                  var options = {
                    title: "Total MO Messages",

                    fontName: 'Arial',
                    bar: {groupWidth: "95%"},
                    legend: { position: "none" },
                    hAxis: { minValue: 6, format: '0'}

                  };
                  var chart = new google.visualization.BarChart(document.getElementById('TotalMOM'));
                                chart.draw(data, options);
                }*/

        </script>
html;

$extraFooter =<<<html
  <script src="/js/bootbox.min.js"></script>
  <script src="/js/bootstrap-progressbar.min.js"></script>
<!-- tool tip -->
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
html;

      $id_user = $_SESSION['id_user'];
      $customer_id_index = MasterDom::getData('customer_id_index');
      $customer = MasterDom::getSession('customer_id');
      $getTotalesCustomerMes = CampaignDao::getTotalesCustomerMes($customer);
      $getTotalesCustomerDia = CampaignDao::getTotalesCustomerDia($customer);
      $getTotalesuserMes = CampaignDao::getTotalesUserMes($id_user);
      $getTotalesuserDia = CampaignDao::getTotalesUserDia($id_user);

      $dataUser = CampaignDao::getDataUser($id_user);
      $dataCustomer = CampaignDao::getDataCustomer($customer);

      $totalMesCustomer = number_format($getTotalesCustomerMes['max_mt_month']);
      $totalMesRestaCustomer = number_format($getTotalesCustomerMes['resta_mes']);
      $totalDiaCustomer = number_format($getTotalesCustomerDia['max_mt_day']);
      $totalDiaRestaCustomer = number_format($getTotalesCustomerDia['resta_dia']);
      $totalMesUser = number_format($getTotalesuserMes['max_mt_month']);
      $totalMesRestaUser = number_format($getTotalesuserMes['resta_mes']);
      $totalDiaUser = number_format($getTotalesuserDia['max_mt_day']);
      $totalDiaRestaUser = number_format($getTotalesuserDia['resta_dia']);

      $procentajeTotalCustomerMes = $getTotalesCustomerMes['resta_mes'] * 100 / $getTotalesCustomerMes['max_mt_month'];
      $procentajeTotalCustomerDia = $getTotalesCustomerDia['resta_dia'] * 100 / $getTotalesCustomerDia['max_mt_day'];
      $procentajeTotalUserMes = $getTotalesuserMes['resta_mes'] * 100 / $getTotalesuserMes['max_mt_month'];
      $procentajeTotalUserDia = $getTotalesuserDia['resta_dia'] * 100 / $getTotalesuserDia['max_mt_day'];


      $classProMC = Menu::progresBarclass($procentajeTotalCustomerMes);
      $classProDC = Menu::progresBarclass($procentajeTotalCustomerDia);
      $classProUM = Menu::progresBarclass($procentajeTotalUserMes);
      $classProUD = Menu::progresBarclass($procentajeTotalUserDia);

      $html=<<<html
        <div class="x_panel">
          <div class="x_title">
            <h2>Reporte de l&iacute;mite de sms MES y D&Iacute;A </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <h2>L&iacute;mite sms customer {$dataCustomer['name']}</h2>
                </div>
                <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6" style="padding:10px;">
                  <li>L&iacute;mite de mensajes por mes {$dataCustomer['name']}: <b>{$totalMesCustomer} </b></li>
                  <li><span class="pull-right">Cantidad de sms restantes al mes: <b> {$totalMesRestaCustomer} </b></span></li>
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-$classProMC active" role="progressbar" style="width: {$procentajeTotalCustomerMes}%;" aria-valuenow="$procentajeTotalCustomerMes" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="{$procentajeTotalCustomerMes}%">
                      <b style="color:black">{$procentajeTotalCustomerMes}%</b>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6" style="padding:10px;">
                  <li>L&iacute;mite de mensajes por dia {$dataCustomer['name']}: <b>{$totalDiaCustomer} </b></li>
                  <li><span class="pull-right">Cantidad de sms restantes al d&iacute;a: <b> {$totalDiaRestaCustomer} </b></span></li>
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-$classProDC active" role="progressbar" style="width: {$procentajeTotalCustomerDia}%;" aria-valuenow="$procentajeTotalCustomerDia" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="{$procentajeTotalCustomerDia}%"><b style="color:black">{$procentajeTotalCustomerDia}%</b></div>
                  </div>
                </div>

                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <h2>L&iacute;mite de sms {$dataUser['first_name']} {$dataUser['last_name']} </h2>
                </div>

                <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6" style="padding:10px;">
                  <li>L&iacute;mite de mensajes por mes {$dataUser['first_name']} {$dataUser['last_name']}: <b>{$totalMesUser} </b></li>
                  <li><span class="pull-right">Cantidad de sms restantes al mes: <b> {$totalMesRestaUser} </b></span></li>
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-$classProUM active" role="progressbar" style="width: {$procentajeTotalUserMes}%;" aria-valuenow="$procentajeTotalUserMes" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="{$procentajeTotalUserMes}%">
                      <b style="color:black">{$procentajeTotalUserMes}%</b>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6" style="padding:10px;">
                  <li>L&iacute;mite de mensajes por dia {$dataUser['first_name']} {$dataUser['last_name']}: <b>{$totalDiaUser} </b></li>
                  <li><span class="pull-right">Cantidad de sms restantes al d&iacute;a: <b> {$totalDiaRestaUser} </b></span></li>
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-$classProUD active" role="progressbar" style="width: {$procentajeTotalUserDia}%;" aria-valuenow="$procentajeTotalUserDia" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="{$procentajeTotalUserDia}%">
                      <b style="color:black">{$procentajeTotalUserDia}%</b>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
html;
        $sms_bag = CampaignDao::getBolsaMT($customer);
        //print_r($sms_bag);
        foreach ($sms_bag as $key => $value) {
          $bolsaSms = $value['bolsa_sms'];
          $restaBolsa = $value['resta_bolsa'];
          $delivered = $value['delivered'];

          $filaCompras .=<<<html
          <tr>
            <td>{$value['fecha_compra']}</td>
            <td>{$value['fecha_expira']}</td>
            <td>{$value['delivered']}</td>
            <td>{$value['resta_bolsa']}</td>
            <td>{$value['bolsa_sms']}</td>
          </tr>
html;
        }

        $porcen = ($restaBolsa * 100) / $bolsaSms;

        $classPro = Menu::progresBarclass($porcen);

        $html .= <<<html
    <div class="row">
      <div class="col-md-12 col-xs-12 col-sm-6 col-lg-6 panel panel-default" id="bolsa_sms" >
      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
        <ul class="list-group">
          <li>Bolsa sms {$dataCustomer['name']} : <b> {$bolsaSms} </b></li>
          <li><span class="pull-right">Cantidad de sms restantes: <b> {$restaBolsa} </b></span></li>
          
        </ul>
        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-$classPro active" role="progressbar" style="width: {$porcen}%; " aria-valuenow="{$porcen}" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" title="{$porcen}%">
            <b style="color:black">{$porcen}%</b>
          </div>
        </div>
      </div>
      </div>
      <div class="col-md-12 col-xs-12 col-sm-6 col-lg-6">
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Bolsa sms: {$dataCustomer['name']}</strong></div>
          <div class="panel-body">
            <div class="col-md-12 col-xs-12 col-sm-10 col-lg-10 dataTable_wrapper">
              <table class="table table-striped table-bordered table-hover" id="table_{$dataCustomer['name']}">
                <thead>
                  <tr>
                    <th>Fecha compra</th>
                    <th>Fecha expira</th>
                    <th>Delivered</th>
                    <th>Restantes</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  $filaCompras
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
html;

        View::set('contenido',$html);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("menu");
    }

    public function add(){

        $extraHeader=<<<html
        <link href="/css/magicsuggest-min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/validate/screen.css">
html;

        $extraFooter=<<<html
        <script src="/js/magicsuggest-min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
        <script>
        $(document).ready(function(){

	    jQuery.validator.addMethod("pwdVal", function(value, element) {
        	return this.optional(element) || /(?=^[^\s]{8,128}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/.test(value);
     	    });

            jQuery.validator.addMethod("ExisteUsuario",function(value,element)
            {
                var inputElem = $('#add input[name="nickname"]');
                    data = {"nombre" : inputElem.val()},
                    eReport = '';

                var val = 0;

                $.ajax(
                {
                   type: "POST",
                   url: "/Menu/validaNombre",
                   dataType: "json",
                   data: data,
                   async:false,    
                   success: function(data)
                   {
                    console.debug(data);
                    console.debug("ok success");
                        if(data == true){
                           console.debug("ok success true");
                           val = 1;
                           //return false;               
                        }
                        else{
                        console.debug("ok success false");
                        //return false;
                        //return true;
                        }
                   },

                   error: function(xhr, textStatus, errorThrown){
                    console.debug("no success");
                        return false;
                   }
                });
                
                console.debug("final script: " + val);
                return this.optional(element) || 0 != val;
            }, jQuery.validator.format("Existe un usuario registrado con este Nickname"));



            $("#add").validate(
                {
                    rules: {
                        nombre: {
                            required: true,
                            maxlength: 20,
                            minlength: 3
                        },

                        apellido: {
                            required: true,
                            maxlength: 20,
                            minlength: 3
                        },

                        mail: {
                            required: true,
                            email: true
                        },
                        
                        nickname: {
                            required: true,
                            maxlength: 20,
                            minlength: 3,
                            ExisteUsuario: true
                        },

                        pass1: {
			   required: true,
			   minlength: 8,
			   pwdVal: true
                        }, pass2: {
                            equalTo: "#pass1"
                        },

                        img: {
                            extension: "jpg|png"
                        },

                        'modules[]': {
                            required: true
                        },

                        max_dia: {
                            required: true,
                            digits: true,
                            number: true
                        },

                        max_mes: {
                            required: true,
                            digits: true,
                            number: true
                        }

                    },

                    messages: {
                        nombre: {
                            required: "Este campo es obligatorio",
                            minlength: "El nombre deber de tener al menos 3 caracteres",
                            maxlength: "El nombre deber de tener máximo 20 caracteres"
                        },

                        apellido: {
                            required: "Este campo es obligatorio",
                            minlength: "El apellido deber de tener al menos 3 caracteres",
                            maxlength: "El apellido deber de tener máximo 20 caracteres"
                        },

                        mail: {
                            required: "Este campo es obligatorio",
                            email: 'Se necesita una dirección de correo válida'
                        },

                        nickname: {
                            required: "Este campo es obligatorio",
                            minlength: "El nombre del jugador deber de tener al menos 3 caracteres",
                            maxlength: "El nombre del jugador deber de tener máximo 20 caracteres",
                            ExisteUsuario: "Este usuario ya existe"
                        },

                        pass1: {
                            required: "Este campo es obligatorio",
			    minlength: "Minimo 8 caracteres",
			    pwdVal: "Debe de contener minimo una letra mayuscula y un numero"
                        },

                        pass2: {
                            equalTo: 'Este campo debe ser el mismo que el campo anterior'
                        },

                        img: {                           
                            accept: 'Se necesita un archivo con extensión jpg o png'
                        },
                        'modules[]' : {
                            required: "Este campo es obligatorio"
                        },
                        max_dia: {
                            required: "Este campo es obligatorio",
                            digits: "Solo se aceptan valores númericos positivos",
                            number: "Solo ingresa valores númericos"
                        },
                        max_mes: {
                            required: "Este campo es obligatorio",
                            digits: "Solo se aceptan valores númericos positivos",
                            number: "Solo ingresa valores númericos"
                        }
                    },
                    
                }
            );
        });
        </script>
html;

        $this->showAllModules();

        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("usersadd");
    }

    public function edit(){

        $extraHeader=<<<html
        <link href="/css/magicsuggest-min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/validate/screen.css">
html;

        $extraFooter=<<<html
        <script src="/js/magicsuggest-min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
        <script>
        $(document).ready(function() {

            $( "#usuarios" ).change(function() {
                $.ajax({
                    type:'POST',
                    url:'/Menu/datosUserBD',
                    dataType:'json',
                    data: {id_user : $(this).val()},
                    async: false,
                    success:function(data){
                        console.debug(data);
                        $('input:checkbox').removeAttr('checked');
                        $('#id').val(data._id);
                        $('#nombre').val(data._name);
                        $('#apellido').val(data._lastname);
                        $('#mail').val(data._mail);
                        $('#nickname').val(data._nickname);
                        $('#nickname_hidden').val(data._nickname);
                        $('#img_hidden').val(data._img);
                        var stat = data._status;                     
                        if(stat == 1){
                            $("#status").prop('checked', true);
                        }else{
                            $("#status").prop('checked', false);
                        }
                        $('#max_dia').val(data._maxmtday);
                        $('#max_mes').val(data._maxmtmonth);

                        //console.log(data._modules);

                        $.each(data._modules,function(i,v){
                                $("input[name='modules[]']").each(function( index ) {
                                    //console.log(index+':'+$( this ).val() );
                                    if($( this ).val() == v){
                                        //console.log('ok');
                                        $(this).prop('checked',true)
                                    }
                                });
                        });
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.debug("no success");
                        return false;
                    }
                });
            });

	    jQuery.validator.addMethod("pwdVal", function(value, element) {
                return this.optional(element) || /(?=^[^\s]{8,128}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/.test(value);
            });

            jQuery.validator.addMethod("ExisteUsuario",function(value,element)
            {
                var inputElem = $('#edit input[name="nickname"]');
                    data = {"nombre" : inputElem.val()},
                    eReport = '';
                var hidden =  $('#nickname_hidden').val();
                var val = 0;

                $.ajax(
                {
                   type: "POST",
                   url: "/Menu/validaNombre",
                   dataType: "json",
                   data: data,
                   async:false,    
                   success: function(data)
                   {
                    console.debug(data);
                    console.debug("ok success");
                        if(data == true){
                           console.debug("ok success true");
                           val = 1;
                           //return false;               
                        }
                        else{
                        console.debug("ok success false");
                        //return false;
                        //return true;
                        }
                   },

                   error: function(xhr, textStatus, errorThrown){
                    console.debug("no success");
                        return false;
                   }
                });
                
                if(value == hidden){
                    val = 1;

                }

                console.debug("final script: " + val);
                return this.optional(element) || 0 != val;
            }, jQuery.validator.format("Existe un usuario registrado con este Nickname"));


            $("#edit").validate(
                {
                    rules: {
                        nombre: {
                            required: true,
                            maxlength: 20,
                            minlength: 3
                        },

                        apellido: {
                            required: true,
                            maxlength: 20,
                            minlength: 3
                        },

                        mail: {
                            required: true,
                            email: true
                        },
                        
                        nickname: {
                            required: true,
                            maxlength: 20,
                            minlength: 3,
                            ExisteUsuario: true
                        },
			pass1: {
                           minlength: 8,
                           pwdVal: true
                        },
                        pass2: {
                            equalTo: "#pass1"
                        },

                        img: {
                            accept: "image/*"
                        },

                        'modules[]': {
                            required: true
                        },

                        max_dia: {
                            required: true,
                            digits: true,
                            number: true
                        },

                        max_mes: {
                            required: true,
                            digits: true,
                            number: true
                        }

                    },

                    messages: {
                        nombre: {
                            required: "Este campo es obligatorio",
                            minlength: "El nombre deber de tener al menos 3 caracteres",
                            maxlength: "El nombre deber de tener máximo 20 caracteres"
                        },

                        apellido: {
                            required: "Este campo es obligatorio",
                            minlength: "El apellido deber de tener al menos 3 caracteres",
                            maxlength: "El apellido deber de tener máximo 20 caracteres"
                        },

                        mail: {
                            required: "Este campo es obligatorio",
                            email: 'Se necesita una dirección de correo válida'
                        },

                        nickname: {
                            required: "Este campo es obligatorio",
                            minlength: "El nombre del jugador deber de tener al menos 3 caracteres",
                            maxlength: "El nombre del jugador deber de tener máximo 20 caracteres",
                            ExisteUsuario: "Este usuario ya existe"
                        },

                        pass1: {
			    minlength: "Minimo 8 caracteres",
                            pwdVal: "Debe de contener minimo una letra mayuscula y un numero"
                        },

                        pass2: {
                            equalTo: 'Este campo debe ser el mismo que el campo anterior'
                        },

                        img: {                           
                            accept: 'Se necesita un archivo con extensión jpg o png'
                        },
                        'modules[]' : {
                            required: "Este campo es obligatorio"
                        },

                        max_dia: {
                            required: "Este campo es obligatorio",
                            digits: "Solo se aceptan valores númericos positivos",
                            number: "Solo ingresa valores númericos"
                        },
                        max_mes: {
                            required: "Este campo es obligatorio",
                            digits: "Solo se aceptan valores númericos positivos",
                            number: "Solo ingresa valores númericos"
                        }
                    }
                    
                }
            );


        });

        </script> 
html;
    
        $allModules = MenuDao::getModulesById($_SESSION['customer_id']);
        $modulesop = '<ul>';
        foreach ($allModules as $key => $value) {
            $modules = $value['name_module'];
            $modules_id = $value['modules_id'];
            //$modulesop .= "<li><input type='checkbox' name='modules[]' cheked='checked' id='modules' value=".$modules_id." />".$modules."</li>";
            $modulesop .= "<label class='checkbox-inline'><input type='checkbox' name='modules[]' cheked='checked' value=".$modules_id.">".$modules." |</label>";
        }

        $this->showAllUsers();
        print_r($this->showAllUsers());

        View::set('showmodules',$modulesop);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("usersedit");
    }

    private function showAllModules(){
        $allModules = MenuDao::getModulesById($_SESSION['customer_id']);
        $modulesop = '<ul>';
        foreach ($allModules as $key => $value) {
            $modules = $value['name_module'];
            $modules_id = $value['modules_id'];
            //$modulesop .= "<li><input type='checkbox' name='modules[]' cheked='checked' id='modules' value=".$modules_id." /><label>".$modules."</label></li>";
            $modulesop .= "<label class='checkbox-inline'><input type='checkbox' name='modules[]' cheked='checked' value=".$modules_id.">".$modules." | </label>";
        }

        View::set('showmodules',$modulesop);  
    }


    private function showAllUsers(){

        if ($_SESSION['customer_id'] == 1) 
            $allUser = MenuDao::getAllUsers();
        else
            $allUser = MenuDao::getUsers($_SESSION['customer_id']);

        $userop = '';
        foreach ($allUser as $key => $value) {
            $nickname = $value['nickname'];
            $first_name = $value['first_name'];
            $last_name =  $value['last_name'];
            $userop .= '<option value="'.$value['user_id'].'">'.$nickname.' - '.$first_name.' '.$last_name.'</option>';
        }

        View::set('showuser',$userop);
    }

    public function delete(){
       $extraHeader=<<<html
        <link href="/css/magicsuggest-min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/validate/screen.css">
html;
        $extraFooter =<<<html
        <!--jQuery validate -->
        <script src="/js/magicsuggest-min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script>
            $("#form").validate({
                rules: {
                    usuarios: {
                        required: true
                    }
                },
                messages: {
                    usuarios: "Este campo es requerido"
                }
            });
        </script>
html;
        $this->showAllUsers();
        View::render("usersdelete");
    }

    public function addUser(){

        if(!$_POST OR !MasterDom::whiteListeIp())
            return $this->alertas('error_general');

        /*------ sacar datos del formulario ---------------*/

//      $ruta_servidor='C:\xampp\htdocs\public\img\usr'; //Ruta localhost Windows
	    $ruta_servidor='/home/smsmkt/public/img/usr';
        $nombreImagen=$_FILES['img']['name'];
        $rutaTemporal=$_FILES['img']['tmp_name'];
        $nombreImagen = uniqid().$nombreImagen;
        $rutaDestino=$ruta_servidor."/".$nombreImagen; //en localhost W es "\\"
        move_uploaded_file($rutaTemporal, $rutaDestino);

        $user = new \stdClass();

        if (isset($_POST['modules'])) $user->modules = MasterDom::getDataAll('modules'); //$modules = $_POST['modules'];
        else {header('location:/Menu/add');} //echo 'modules vacios';
        
        $user->_fname  = MasterDom::getData('nombre');
        $user->_lname  = MasterDom::getData('apellido');
        $user->_pass1 = MasterDom::getData('pass1');
        $user->_pass2 = MasterDom::getData('pass2');
        $user->_mail = MasterDom::getData('mail');
        $user->_nickname  = MasterDom::getData('nickname');
        $user->_image = $nombreImagen;
        $user->_idcustom  = $_SESSION['customer_id'];
        $user->_max_dia = MasterDom::getData('max_dia');
        $user->_max_mes = MasterDom::getData('max_mes');
       
        if ( MasterDom::getData('status') == '') $user->_status  = 0;
        else $user->_status = 1;

        $this->insert($user);

                       
     }

    public function insert($user){

        /*------- insertar datos en tabla user --------------*/
        if ($user->_pass1 == $user->_pass2){ 
          $addUser = MenuDao::insert($user);
          if (!empty($addUser)) {
            /**************************** Registro *************************/
            $registro = $this->registroUsuario("Agrego usuario {$addUser}");
            //print_r($registro);
            MenuDao::registroUsuario($registro);
            /***************************************************************/
          }
        }
        else{header('location:/Menu/add');}// echo 'error, passwords diferentes';}

        /* ------ insertar datos en tabla user_modules-------*/
        foreach ($user->modules as $key => $value) {
            MenuDao::insertUserModules($addUser,$value);   
        }

        /*------- insertar datos en tabla user_customer -----*/
        if(MenuDao::insertUserCustomer($addUser, $user->_idcustom)) { header('location:/Menu/index'); } //echo 'se agrego con exito';
        else {header('location:/Menu/add');} //echo 'algo salio mal';

    }

    public function editUser(){

        if(!$_POST OR !MasterDom::whiteListeIp())
            return $this->alertas('error_general');

        $user = new \stdClass();

        if (isset($_POST['modules'])){ $user->modules = MasterDom::getDataAll('modules'); }
        else {
            return $this->alertas('error_general');
            //header('location:/Menu/edit');
        }   //echo 'modules vacios';

//      $ruta_servidor='C:\xampp\htdocs\public\img\usr';
        $ruta_servidor='/home/smsmkt/public/img/usr';

        if (!empty($_FILES['img']['tmp_name'])) {
          
          $nombreImagen=$_FILES['img']['name'];
          $rutaTemporal=$_FILES['img']['tmp_name'];
          $nombreImagen = uniqid().$nombreImagen;
          $rutaDestino=$ruta_servidor."/".$nombreImagen;
          move_uploaded_file($rutaTemporal, $rutaDestino);

        } else {
          $nombreImagen = '';
        }
        
        $user->_id     = MasterDom::getData('usuarios');
        $user->_fname  = MasterDom::getData('nombre');
        $user->_lname  = MasterDom::getData('apellido');
        $user->_mail   = MasterDom::getData('mail');
        $user->_nickname  = MasterDom::getData('nickname');
        $user->_max_dia = MasterDom::getData('max_dia');
        $user->_max_mes = MasterDom::getData('max_mes');

        if ( MasterDom::getData('status') == '') $user->_status  = 0;
        else $user->_status = 1;

        $flag = false;
        if ($_POST['pass1'] != '' && $_POST['pass2'] != '') {
            if (MasterDom::getData('pass1') == MasterDom::getData('pass2')){ 
              $user->_pass1  = MasterDom::getData('pass1'); 
              $flag = true;
            }
            else{ /*header('location:/Menu/edit')*/return $this->alertas('error_general'); }// echo 'error, passwords diferentes';
        }else{
          $flag = false;
        }

        if ($nombreImagen == '') $user->_img = MasterDom::getData('img_hidden');
        else $user->_img = $nombreImagen;

        if($flag){
          MenuDao::updatePwd($user);
        }else{
          MenuDao::update($user);
        }
        

        /*-----Actualizar datos de la tabla user_modules------*/
        MenuDao::deleteUserModules($user->_id);

        foreach ($user->modules as $key => $value) {
            MenuDao::insertUserModules($user->_id,$value);
        }

        if (!empty($user)) {
          /**************************** Registro *************************/
          $registro = $this->registroUsuario("Actualizo usuario {$user->_id}");
          //print_r($registro);
          MenuDao::registroUsuario($registro);
          /***************************************************************/
        }

        return $this->alertas('success_add');
        //header('location:/Menu/edit');
        exit;
        

        if ( MasterDom::getData('status') == '') $user->_status  = 0;
        else $user->_status = 1;

        

        /*----------Actualizar Datos de la tabla user---------*/

        //caso 1: cuando escribió password
        if ($_POST['pass1'] != '' && $_POST['pass2'] != '') {
            $user->_pass1  = MasterDom::getData('pass1');
            $user->_pass2  = MasterDom::getData('pass2');

            if ($user->_pass1 == $user->_pass2){ $editUser = MenuDao::update($user); }
            else{ /*header('location:/Menu/edit')*/return $this->alertas('error_general'); }// echo 'error, passwords diferentes';

        } else {
        //caso 2: cuando no escribió password
            $editUser = MenuDao::updateWithoutPass($user);
        }

        

    }

    public function datosUserBD(){

        $id   = MasterDom::getData('id_user');        
        $data = MenuDao::getDataUser($id);

        $modules = array();
        $data_modules = MenuDao::getById($id);
        foreach ($data_modules as $key => $value) {
            $modules[] = $value['modules_id'];
        }
        
        $user = new \stdClass();
        $user->_nickname = $data['nickname'];
        $user->_name = $data['first_name'];
        $user->_lastname = $data['last_name'];
        $user->_mail = $data['mail'];
        $user->_pass = $data['password'];
        $user->_status = $data['status'];
        $user->_maxmtday = $data['max_mt_day'];
        $user->_maxmtmonth = $data['max_mt_month'];
        $user->_img =$data['img'];
        $user->_modules= $modules;

        $json = json_encode($user);
        echo $json;
    }

    public function deleteUser(){

        if(!$_POST OR !MasterDom::whiteListeIp())
            return $this->alertas('error_general');
        
        $id = MasterDom::getData('usuarios');
        $id_user = MasterDom::getSession('id_user');
        if ($id==$id_user) {
          return $this->alertas('error_general');
        }


        if (MenuDao::delete($id)) {
          /**************************** Registro *************************/
          $registro = $this->registroUsuario("Eliminio usuario {$id}");
          //print_r($registro);
          MenuDao::registroUsuario($registro);
          /***************************************************************/
        }

        /*MenuDao::delete($id);
        MenuDao::deleteUserModules($id);
        MenuDao::deleteUserCustomer($id);*/

        //header('location:/Menu');
         return $this->alertas('success_add');

    }

    public function validaNombre (){

        if(!empty($_POST['nombre'])){

            $nickname = new \stdClass();
            $nickname->_name = MasterDom::procesoAcentos('nombre');

            $row = MenuDao::getByName($nickname);

            if(empty($row)) {
                echo "true";
                return true;
               //puede registrarse
            } else{
                echo "no puede";
                return false;
                //echo "ya hay alguien con ese nombre";
            }
        } else{
            echo "no puedes registrarte por que no hay nada";
        }
    }

    public function hola(){
        echo 'hola';
    }

    private function alertas($caso = 'error_general'){

        $class = 'danger';
        $mensaje = '';
        if($caso == 'success_add'){
            $mensaje = 'Success.';
            $class = 'success';
        }elseif($caso == 'error_general')
            $mensaje = 'Lo sentimos ocurrio un error.';
        elseif($caso == 'error_producto')
            $mensaje = 'Ocurrio un error al insertar los productos.';
        else
            $mensaje = 'Ocurrio algo inesperado.';

        View::set('regreso','/Menu');
        View::set('class', $class);
        View::set('titulo','Usuarios');
        View::set('mensaje', $mensaje);
        View::render("mensaje");
    }

    function registroUsuario($accion){
      $id_usuario = $_SESSION['id_user'];
      $nickname = $_SESSION['usuario'];
      $customer = $_SESSION['name_customer'];
      $script = explode("/", $_SERVER["REQUEST_URI"]);
      $ip = $_SERVER['REMOTE_ADDR'];
      $modulo = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

      $registro = new \stdClass;
      $registro->_id_usuario = $id_usuario;
      $registro->_nickname = $nickname;
      $registro->_customer = $customer;
      $registro->_script = $script[1];
      $registro->_ip = $ip;
      $registro->_modulo = $modulo;
      $registro->_accion = $accion;
      return $registro;
    }


    function progresBarclass($percent) {

      if ($percent > 60) {
        $class = 'success';
      } elseif ($percent <= 60 && $percent >= 30) {
        $class = 'warning';
      } elseif ($percent < 30) {
        $class = 'danger';
      }

      return $class;

    }

}
