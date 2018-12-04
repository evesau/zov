<?php

include '/usr/local/bin/vendor/autoload.php';

class DescargaExcel{

	public static function creaExcel(){
		// Establecer propiedades
		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->getProperties()
		->setCreator("Cattivo")
		->setLastModifiedBy("Cattivo")
		->setTitle("Documento Excel de Prueba")
		->setSubject("Documento Excel de Prueba")
		->setDescription("Demostracion sobre como crear archivos de Excel desde PHP.")
		->setKeywords("Excel Office 2007 openxml php")
		->setCategory("Pruebas de Excel");

		// Agregar Informacion
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'Numero')
		->setCellValue('B1', 'Mensaje')
		->setCellValue('C1', 'Status')
		->setCellValue('A2', '5545682704')
		->setCellValue('B2', 'hola')
		->setCellValue('C2', 'delivered');

		// Renombrar Hoja
		$objPHPExcel->getActiveSheet()->setTitle('Reporte');

		// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
		$objPHPExcel->setActiveSheetIndex(0);

		self::descarga($objPHPExcel);
	}

	public static function descarga($objPHPExcel){
		// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Mensajes_Enviados.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}

}

$dE = new DescargaExcel();
$dE->creaExcel(); 

?>