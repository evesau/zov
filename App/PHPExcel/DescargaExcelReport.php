<?php

 include '/usr/local/bin/vendor/autoload.php';
//require_once 'PHPExcel.php';

class DescargaExcelReport
{

	public static function creaExcel($title, $name, $data_sheet, $cols){
		// Establecer propiedades
		// echo "\n\n\nimprime++++++++++++++++++++";
		// print_r(urldecode($data_sheet));
		// echo "\n\n\nunserialize\n\n\n";
		$desifrado = urldecode($data_sheet);
		// print_r(trim($desifrado,"[]"));
		$ar = trim($desifrado,"[]");
		$arr = explode("{", $ar);
		// echo "array new ++++++++++++++++++++\n\n\n";
		// print_r($arr);
		foreach ($arr as $key => $value) {
			$fila = trim($value,"\:");
			$newfila = explode(",", $value);

			// echo "\n++++++++++++++++++fila: $key \n\n";
			// print_r($newfila);
			if($value != ""){
				$arreglo [] = $newfila;
			}
		}
		// echo "\nnew fila\n\n";
		// print_r($arreglo);
		// exit;
		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->getProperties()
		->setCreator($name)
		->setLastModifiedBy($name)
		->setTitle($title)
		->setSubject($title)
		->setDescription("Reporte de los mensajes")
		->setKeywords("Excel Office 2007 openxml php")
		->setCategory("Pruebas de Excel");

		// print_r(count($data_sheet));
		$columnas = 0 + $cols;

		for ($i=0; $i < $columnas; $i++) { 
			foreach ($arreglo as $key => $value) {
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.($key+1), $value[0])
				->setCellValue('B'.($key+1), $value[1])
				->setCellValue('C'.($key+1), $value[2])
				->setCellValue('D'.($key+1), $value[3])
				->setCellValue('E'.($key+1), $value[4])
				->setCellValue('F'.($key+1), $value[5])
				->setCellValue('G'.($key+1), $value[6]);
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
		header('Content-Disposition: attachment;filename="Mensajes_Enviados.xlsx"');
		// header("Expires: 0");
        // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        // header("Cache-Control: private",false);
        header("Cache-Control: max-age=0");
                //echo "pase las cabeceras\n\n";
        // header('Cache-Control: max-age=1');

		// header("Content-Transfer-Encoding: Binary");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//echo "\n\nestuve a punto de crear el archivo\n\n";
		// ob_end_clean();
		$objWriter->save('php://output');
		//echo "\n\nCree el archivo de Excel\n\n";
		exit;
	}

}

// $array = array(
// 			array('2016-09-05 08:51:56','telcel','MT',substr('525510123937', -10),3636,'test desde inicio','queued'),
// 			array('2016-09-05 08:51:56','movistar','MT',substr('525510123937', -10),3636,'test desde inicio','queued'),
// 			array('2016-09-05 08:51:56','AT&T','MT',substr('525510123937', -10),3636,'test desde inicio','queued')
// 			);
// $data_sheet = $array;
// $dE = new DescargaExcelReport();
// $dE->creaExcel('Reporte','Airmovil', $array, 7); 

?>
