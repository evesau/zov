<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

//include '/usr/local/bin/vendor/autoload.php';

use \Core\View;
use \Core\MasterDom;
use \App\models\ReportesmtCamp as ReportesDao;
use \App\controllers\Contenedor;
require_once '/home/smsmkt/public/Classes/PHPExcel.php';

class ReportesmtCamp{

    private $_contenedor;

    function __construct(){
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    /*metodo para hacer la busqueda de MT*/
    public function buscarMt(){
        header("Content-type: application/json; charset=utf-8");
        if (!empty($_GET)){

            $start = MasterDom::getData('start');
            $length = MasterDom::getData('length');
            $draw = (MasterDom::getData('draw') == 1) ? 1 : MasterDom::getData('draw');

            $data = new \stdClass();
            $data->customer_id = MasterDom::getSession('customer_id');
            $data->campaign_id = (MasterDom::getData('campaign_id') == 'null' ) ? '' : MasterDom::getData('campaign_id');
            $data->fecha_inicio = MasterDom::getData('datetimepicker');
            $data->fecha_fin = MasterDom::getData('datetimepicker1');
            $data->carrier = ( MasterDom::getData('carrier') == 'null' ) ? 'sincarrier' : MasterDom::getData('carrier');
            $data->destination = MasterDom::getData('destination');
            $data->source = MasterDom::getData('source');
            $data->estatus = MasterDom::getData('estatus');
            $data->loteid = MasterDom::getData('loteid');
            
            $registros = ReportesDao::getMTAllCount($data);
            //mail('esau.espinoza@airmovil.com', 'Reportes controller', json_encode($registros));
            $datosMT = array("draw"=>$draw, "recordsTotal"=>count($registros), "recordsFiltered"=>count($registros),"data"=>ReportesDao::getMTListData($data, $start, $length));
            echo json_encode($datosMT);
            exit;
        }
    }

    public function mantenimiento(){

	MasterDom::verificaUsuario();

        $id_custom = MasterDom::getSession('customer_id');

        $extraHeader=<<<html
        <!-- jQuery -->
        <!-- DataTables CSS -->
        <link href="/css/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DateTimePicker CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
        <style>
        .error{
            color: red;
        }

        </style>
html;


        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("mantenimiento");

    }

    public function index(){

        MasterDom::verificaUsuario();

        $id_custom = MasterDom::getSession('customer_id');

        $extraHeader=<<<html
        <!-- jQuery -->
        <!-- DataTables CSS -->
        <link href="/css/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DateTimePicker CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
        <style>
        .error{
            color: red;
        }

        </style>
html;

        $extraFooter=<<<html
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap.min.js"></script>
    <script src="/js/bootbox.min.js"></script>
    <script src="/js/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <script src="/js/validate/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(document).ready(function() {

            var sp = $("span.select2-selection__clear").html(''); // quita la opcion de limpiar seleccion en el select

            $("#source").change(function(){
                $("span.select2-selection__clear").html('');
            });

            // se agrego para controlar las peticiones por loteid
            $("#loteid").val("");

            $("#loteid").change(function(){

                var cloteid = $("#loteid").val();

                if(cloteid!=''){
                    $("#estatus").val("");
                    $("#estatus").attr('disabled',true);
                    $("#carrier").val("");
                    $("#carrier").attr('disabled',true);
                } else {
                    $("#estatus").attr('disabled',false);
                    $("#carrier").attr('disabled',false);
                }
            });
            // fin de loteid

            var anio = (new Date).getFullYear();
            
            $('#datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD 00:00:00',
                minDate: moment().startOf('year'),
                maxDate: moment(),
                daysOfWeekDisabled: [],
                inline: false,
                sideBySide: false
            });
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD 23:59:59',
                minDate: moment().startOf('year'),
                //maxDate: moment(),
                daysOfWeekDisabled: [],
                inline: false,
                sideBySide: false
            });

            //$("input[id=datetimepicker]").val("");
            //$("input[id=datetimepicker1]").val("");


            dataObj = {
                customer_id: $id_custom,
                campaign_id: $("#campaign_id").val(),
                datetimepicker: $("#datetimepicker").val(),
                datetimepicker1: $("#datetimepicker1").val(),
                carrier: $("#carrier").val(),
                destination: $("#destination").val(),
                source: $("#source").val(),
                estatus: $("select[name=estatus]").val(),
                loteid: $("#loteid").val()
            }

            //alert(JSON.stringify(dataObj));

            var table = $("#reporte_mt").DataTable({
                "processing": true,
                "serverSide": true,
                "bLengthChange": false,
                "searching": false,
                "ordering": false,
                "iDisplayLength": 20,
                "ajax": {
                    "url": '/ReportesmtCamp/buscarMt',
                    "dataType":'json',
                    "data": dataObj
                },
                "columns": [
                    { "data": "FECHA" },
                    { "data": "CARRIER" },
                    { "data": "DESTINATION" },
                    { "data": "SHORTCODE" },
                    { "data": "CONTENT" },
                    { "data": "ESTATUSSMS" },
                    { "data": "LOTEID"},
                    { "data": "LOTEDETALLEID"}
                ],
                "language": {
                    "emptyTable": "No hay datos disponibles",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "info": "Mostrar _START_ a _END_ de _TOTAL_ registros",
                    "infoFiltered":   "(Filtrado de _MAX_ total de registros)",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords":  "No se encontraron resultados",
                    "search": "Buscar:",
                    "processing":     "Procesando...",
                    "paginate" : {
                        "next": "Siguiente",
                        "previous" : "Anterior"
                    }
                }
            });
        });

        function actualizarDataTable(){
            $("#reporte_mt").dataTable().fnDestroy();
            cambioCampania();
        }

        function actualizarDataTableSearchReportMT(){
            $("#formulario_buscador").submit();
            $("#reporte_mt").dataTable().fnDestroy();
            cambioCampania();
        }


        $("#formulario_buscador").validate({
            rules:{
                datetimepicker:"required",
                datetimepicker1:"required"
            },
            messages:{
                datetimepicker:"Este campo es requerido",
                datetimepicker1:"Este campo es requerido"
            },
            submitHandler: function(form) {
            }
        });



        function cambioCampania(){

            if($("#campaign_id").val() == 'null'){
                $("div.div_fecha").removeClass("hide");
            }else{
                $("div.div_fecha").addClass("hide");
            }

            dataObj = {
                customer_id: $id_custom,
                campaign_id: $("#campaign_id").val(),
                datetimepicker: $("#datetimepicker").val(),
                datetimepicker1: $("#datetimepicker1").val(),
                carrier: $("#carrier").val(),
                destination: $("#destination").val(),
                source: $("#source").val(),
                estatus: $("select[name=estatus]").val(),
                loteid: $("#loteid").val()
            }

            //alert(JSON.stringify(dataObj));

            var table2 = $("#reporte_mt").DataTable({
                            "processing": true,
                            "serverSide": true,
                            "bLengthChange": false,
                            "searching": false,
                            "ordering": false,
                            "iDisplayLength": 20,
                            "ajax": {
                                        "url": '/ReportesmtCamp/buscarMt',
                                        "dataType":'json',
                                        "data": dataObj
                                    },
                            "columns": [
                                { "data": "FECHA" },
                                { "data": "CARRIER" },
                                { "data": "DESTINATION" },
                                { "data": "SHORTCODE" },
                                { "data": "CONTENT" },
                                { "data": "ESTATUSSMS" },
                                { "data": "LOTEID"},
                                { "data": "LOTEDETALLEID"}
                            ],
                            "language": {
                                "emptyTable": "No hay datos disponibles",
                                "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                                "info": "Mostrar _START_ a _END_ de _TOTAL_ entradas",
                                "infoFiltered":   "(Filtrado de _MAX_ total de entradas)",
                                "lengthMenu": "Mostrar _MENU_ entradas",
                                "zeroRecords":  "No se encontraron resultados",
                                "search": "Buscar:",
                                "processing":     "Procesando...",
                                "paginate" : {
                                    "next": "Siguiente",
                                    "previous" : "Anterior"
                                }
                            }
                         });
        }

        function actualizarDataTableCampaniaFecha(){
            $("#reporte_mt").dataTable().fnDestroy();
            muestraInfo()
        }


        $("#reporte").click(function(){            
                var carrier = $("#carrier").val();
                var destination = $("input:text[name=destination]").val();
                var source = $("#source").val();
                var estatus = $("#estatus").val();
                var id_camp = $("#id_campania").val();
                var fecha_inicio = $("#datetimepicker").val();
                var fecha_fin = $("#datetimepicker1").val();
                var customer_id = $id_custom;
                var loteid = $("#loteid").val();

                location.href = "/ReportesmtCamp/reporte_mt?customer_id="+customer_id+"&carrier="+carrier+"&destination="+destination+"&source="+source+"&estatus="+estatus+"&campaign_id="+id_camp+"&fecha_inicio="+fecha_inicio+"&fecha_fin="+fecha_fin+"&loteid="+loteid;            
        });


        $("#enviar_mail").click(function(){
                var carrier = $("#carrier").val();
                var destination = $("input:text[name=destination]").val();
                var source = $("#source").val();
                var estatus = $("#estatus").val();
                var id_camp = $("#id_campania").val();
                var fecha_inicio = $("#datetimepicker").val();
                var fecha_fin = $("#datetimepicker1").val();
                var customer_id = $id_custom;
                var loteid = $("#loteid").val();

                //location.href = "/ReportesmtCamp/reporte_mail?customer_id="+customer_id+"&carrier="+carrier+"&destination="+destination+"&source="+source+"&estatus="+estatus+"&campaign_id="+id_camp+"&fecha_inicio="+fecha_inicio+"&fecha_fin="+fecha_fin;
                location.href = "/ReportesmtCamp/secureParam?customer_id="+customer_id+"&carrier="+carrier+"&destination="+destination+"&source="+source+"&estatus="+estatus+"&campaign_id="+id_camp+"&fecha_inicio="+fecha_inicio+"&fecha_fin="+fecha_fin+"&loteid="+loteid;

            });
        

</script>

html;
        
        $row = ReportesDao::getAllCampaignMT($id_custom);  
        $row = array_reverse($row);
        $select = "";
        foreach ($row as $key => $value) {
            $select .= "<option value=".$value['campaign_id'].">".$value['campaign_id'].' :: '.$value['name_campaign']." -- ".$value['short_code']."</option>";
        }

        $dataSource = new \stdClass();
        $dataSource->customer_id = $id_custom;

        $filasource = ReportesDao::getShortCodes($dataSource);

        $selectSource ="";
        foreach ($filasource as $key => $value) {
            $selectSource .= "<option value=".$value['short_code'].">".$value['short_code']."</option>";
        }

        //echo "<pre>Esau mmaskjdskjdaskjdgkjasgkjdgskjagdkjasgkj</pre>";
        View::set('ver',MasterDom::getSession('MasterDomCustomer'));
        View::set('select',$select);
        View::set('selectSource',$selectSource);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("reportes_mt_camp_e");
    }

    public function secureParam(){

        $customer_id = MasterDom::setParamSecure(MasterDom::getData('customer_id'));
        $campaign_id = (MasterDom::getData('campaign_id') == 'null' || MasterDom::getData('campaign_id') == 'undefined' ) ? '' : MasterDom::getData('campaign_id');
        $fecha_inicio = MasterDom::getData('fecha_inicio');
        $fecha_fin = MasterDom::getData('fecha_fin');
        $carrier = (MasterDom::getData('carrier') == 'null') ? 'sincarrier' : MasterDom::getData('carrier');
        $destination = MasterDom::getData('destination');
        $source = MasterDom::getData('source');
        $estatus = MasterDom::getData('estatus');
        $loteid = MasterDom::getData('loteid');

        header("Location: reporte_mail?customer_id=$customer_id&carrier=$carrier&destination=$destination&source=$source&estatus=$estatus&campaign_id=$campaign_id&fecha_inicio=$fecha_inicio&fecha_fin=$fecha_fin&loteid=$loteid");


    }

    public function reporte_mail(){

        MasterDom::verificaUsuario();
        $id_custom = MasterDom::getSession('customer_id');

        $extraHeader=<<<html
        <!-- jQuery -->
        <!-- DataTables CSS -->
        <link href="/css/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DateTimePicker CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
        <style>
        .error{
            color: red;
        }

        </style>
html;

        $extraFooter=<<<html
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap.min.js"></script>
    <script src="/js/bootbox.min.js"></script>
    <script src="/js/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <script src="/js/validate/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>

        //custom validation rule
        $.validator.addMethod("customemail", 
            function(value, element) {
                return /^\w+([-+.']\w+)*@sky*/.test(value);
            }, 
            "Lo sentimos, ingrese un correo valido @sky"
        );

        $("#formulario_enviar_mail").validate({
            rules:{
                correo: {
                    required: true,
                    email: true,
                    customemail: true
                }
            },
            messages:{
                correo: {
                    required: "Este campo es requerido",
                    email: "Ingrese una cuenta validad"
                }
            },
            submitHandler: function(form) {
                $("#enviar").click(function(){
                    var correo = $("#correo").val();            
                    var carrier = $("#carrier").val();
                    var destination = $("input:text[name=destination]").val();
                    var source = $("#source").val();
                    var estatus = $("#estatus").val();
                    var id_camp = $("#id_campania").val();
                    var fecha_inicio = $("#fecha_inicio").val();
                    var fecha_fin = $("#fecha_fin").val();
                    var customer_id = $id_custom;
                    var loteid = $("#loteid").val();

                    location.href = "/Reportemail?correo="+correo+"&customer_id="+customer_id+"&carrier="+carrier+"&destination="+destination+"&source="+source+"&estatus="+estatus+"&campaign_id="+id_camp+"&fecha_inicio="+fecha_inicio+"&fecha_fin="+fecha_fin+"&loteid="+loteid;
                });
            }
        });
        
</script>
html;

/*//custom validation rule
$.validator.addMethod("customemail", 
    function(value, element) {
        return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
    }, 
    "Sorry, I've enabled very strict email validation"
);*/

        if (!empty($_GET)){

            $data = new \stdClass();
            $data->customer_id = MasterDom::getParamSecure(MasterDom::getData('customer_id'));
            $data->campaign_id = (MasterDom::getData('campaign_id') == 'null' || MasterDom::getData('campaign_id') == 'undefined' ) ? '' : MasterDom::getData('campaign_id');
            $data->fecha_inicio = MasterDom::getData('fecha_inicio');
            $data->fecha_fin = MasterDom::getData('fecha_fin');
            $data->carrier = (MasterDom::getData('carrier') == 'null') ? 'sincarrier' : MasterDom::getData('carrier');
            $data->destination = MasterDom::getData('destination');
            $data->source = MasterDom::getData('source');
            $data->estatus = MasterDom::getData('estatus');
            $data->loteid = MasterDom::getData('loteid');


            View::set('data',$data);
            View::set('header',$this->_contenedor->header($extraHeader));
            View::set('footer',$this->_contenedor->footer($extraFooter));
            View::render("reporte_mt_camp_mail");
            
        }
    }

    public function reporte_mt(){
        mail('esau.espinoza@airmovil.com','Query Reportes excel ws.amovil.mx','Data: '.json_encode($_GET));
        if (!empty($_GET)){

            $data = new \stdClass();
            $data->customer_id = MasterDom::getData('customer_id');
            $data->campaign_id = (MasterDom::getData('campaign_id') == 'null' || MasterDom::getData('campaign_id') == 'undefined' ) ? '' : MasterDom::getData('campaign_id');
            $data->fecha_inicio = MasterDom::getData('fecha_inicio');
            $data->fecha_fin = MasterDom::getData('fecha_fin');
            $data->carrier = (MasterDom::getData('carrier') == 'null') ? 'sincarrier' : MasterDom::getData('carrier');
            $data->destination = MasterDom::getData('destination');
            $data->source = MasterDom::getData('source');
            $data->estatus = MasterDom::getData('estatus');
            $data->loteid = MasterDom::getData('loteid');

            $start='';
            $length='';
            
            $registros = ReportesDao::getMTListData($data, $start, $length);

            $this->crearExcel($registros);
        }
        exit;
    }

    public static function crearExcel($mensajes){
        $encabezado = array('FECHA','CARRIER','DESTINATION','SHORTCODE','CONTENT','ESTATUSSMS','LOTEID', 'LOTEDETALLEID');
        $abc = array('A','B','C','D','E','F','G','H','I','J','K','L');
        $title = "Reporte mts";
        $name_sheet = "Reporte";
        $objPHPExcel = new \PHPExcel(); 
        $objPHPExcel->getProperties()
        ->setCreator("Esau")
        ->setLastModifiedBy("Esau")
        ->setTitle($title)
        ->setSubject($title)
        ->setDescription("Reporte de los mensajes")
        ->setKeywords("Excel Office 2007 openxml php")
        ->setCategory("Mts sms");

	//mail("esau.espinoza@airmovil.com","mensajes crear excel", print_r($mensajes,1));

        $num_cols = count($encabezado);   
        $fila = 1;

        foreach ($encabezado as $key => $value) {
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($abc[$key].$fila, $value);
        }

        $fila++;

        foreach ($mensajes as $key => $value) {
            for( $i = 0; $i < $num_cols; $i++) {
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($abc[$i].$fila, $value[$encabezado[$i]]);
            }
            $fila++;
        }


        $objPHPExcel->getActiveSheet()->setTitle('Reporte');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reportesmt.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }
}
