<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

//include '/usr/local/bin/vendor/autoload.php';

use \Core\View;
use \Core\MasterDom;
use \App\models\Reportes as ReportesDao;
use \App\controllers\Contenedor;

require_once '/home/smsmkt/public/Classes/PHPExcel.php';

class Reporte{

    private $_contenedor;

    function __construct(){
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    public function index(){
        $extraHeader=<<<html
        <!-- DataTables CSS -->
        <link href="../css/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DateTimePicker CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
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

            dataObj = {
                fecha_inicial: $("#datetimepicker").val(),
                fecha_final: $("#datetimepicker1").val()
            }
            var table = $('#reportes').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "bLengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "iDisplayLength": 20,
                        "ajax": {
                                    "url": '/Reporte/datosMo',
                                    "dataType":'json',
                                    "data": dataObj
                                },
                        "columns": [
                            { "data": "entry_time" },
                            { "data": "source" },
                            { "data": "destination" },
                            { "data": "content" }
                        ],
                        "language": {
                            "emptyTable": "No hay datos disponibles",
                            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                            "info": "Mostrar _START_ a _END_ de _TOTAL_ registros",
                            "infoFiltered":   "(Filtrado de _MAX_ total de registros)",
                            "lengthMenu": "Mostrar _MENU_ registros",
                            "zeroRecords":  "No se encontraron resultados",
                            "search": "Buscar:",
                            "processing": "Procesando...",
                            "paginate" : {
                                "next": "Siguiente",
                                "previous" : "Anterior"
                            }
                        }
                     });
            
            });

            $("#btnBuscar").click(function() {
                $("#reportes").dataTable().fnDestroy();

                dataBuscar = {
                    fecha_inicial: $("#datetimepicker").val(),
                    fecha_final: $("#datetimepicker1").val()
                }

                var table = $('#reportes').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "bLengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "iDisplayLength": 20,
                    "ajax": {
                            "url": '/Reporte/datosMo',
                            "dataType":'json',
                            "data": dataBuscar
                        },
                    "columns": [
                            { "data": "entry_time" },
                            { "data": "source" },
                            { "data": "destination" },
                            { "data": "content" }
                        ],
                    "language": {
                            "emptyTable": "No hay datos disponibles",
                            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                            "info": "Mostrar _START_ a _END_ de _TOTAL_ registros",
                            "infoFiltered":   "(Filtrado de _MAX_ total de registros)",
                            "lengthMenu": "Mostrar _MENU_ registros",
                            "zeroRecords":  "No se encontraron resultados",
                            "search": "Buscar:",
                            "processing": "Procesando...",
                            "paginate" : {
                                "next": "Siguiente",
                                "previous" : "Anterior"
                            }
                        }
                    });

                }
            );
        </script>
html;
        MasterDom::verificaUsuario();
        
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("reportes");
    }

    public function datosMo(){
        header("Content-type: application/json; charset=utf-8");

        $start = MasterDom::getData('start');
        $length = MasterDom::getData('length');
        $draw = (MasterDom::getData('draw') == 1) ? 1 : MasterDom::getData('draw');
        $fecha_inicial = MasterDom::getData('fecha_inicial');
        $fecha_final = MasterDom::getData('fecha_final');

        $dataBusca = new \stdClass();
        $dataBusca->fecha_inicial = $fecha_inicial;
        $dataBusca->fecha_final = $fecha_final;

        $row = ReportesDao::getTotalMessages($dataBusca);
        $r = ReportesDao::getTotalMessagesList($dataBusca, $start, $length);
        

        $recordsTotal = count($row);

        $mos = array("draw"=>$draw, "recordsTotal"=>$recordsTotal, "recordsFiltered"=>$recordsTotal,"data"=>$r);
        echo json_encode($mos);
        exit();
    }

    public static function crearExcel($mensajes){
        $encabezado = array('FECHA','CARRIER','DESTINATION','SHORTCODE','CONTENT','ESTATUSSMS');
        $abc = array('A','B','C','D','E','F','G','H','I','J','K','L');
        $title = "Titulo Reporte";
        $name_sheet = "Reporte";
        $objPHPExcel = new \PHPExcel(); 
        $objPHPExcel->getProperties()
        ->setCreator("Cattivo")
        ->setLastModifiedBy("Cattivo")
        ->setTitle($title)
        ->setSubject($title)
        ->setDescription("Reporte de los mensajes")
        ->setKeywords("Excel Office 2007 openxml php")
        ->setCategory("Pruebas de Excel");



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
                ->setCellValue($abc[$i].$fila, $value[$i]);
            }
            $fila++;
        }


        $objPHPExcel->getActiveSheet()->setTitle('Reporte');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="pruebaReal.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }
}
