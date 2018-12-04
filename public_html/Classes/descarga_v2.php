<?php

//include '/usr/local/bin/vendor/autoload.php';
require_once 'PHPExcel.php';

class DescargaExcel{

	public function creaExcel($title, $name_sheet, $data_sheet, $cols){
		// Establecer propiedades
		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->getProperties()
		->setCreator("Cattivo")
		->setLastModifiedBy("Cattivo")
		->setTitle($title)
		->setSubject($title)
		->setDescription("Reporte de los mensajes")
		->setKeywords("Excel Office 2007 openxml php")
		->setCategory("Pruebas de Excel");

		$columnas = 65 + $cols;

		for ($i = 65; $i < $columnas ; $i ++){
			foreach ($data_sheet as $key => $value) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue(chr($i).($key+1), $value[0].$i)
				->setCellValue(chr($i+1).($key+1), $value[1].$i)
				->setCellValue(chr($i+2).($key+1), $value[2].$i);
			}
		}
			

		// Renombrar Hoja
		$objPHPExcel->getActiveSheet()->setTitle('Reporte');

		// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
		$objPHPExcel->setActiveSheetIndex(0);

		self::descarga($objPHPExcel);
	}

	public static function descarga($objPHPExcel){
		// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="pruebaReal.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}

}

$array = array(array(9,8,7), array(6,5,4), array(3,2,1), array(0,1,2), array(6,4,2), array(0,9,7), array(4,2,3), array(0,0,0), array(10,10,10), array(0,0,0));

$dE = new DescargaExcel();
$dE->creaExcel('prueba','nombre', $array, 3); 
?>