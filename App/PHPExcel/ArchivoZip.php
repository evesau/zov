<?php 
	include '/usr/local/bin/vendor/autoload.php';

	class ArchivoZip{
		public static function descomprimir($zip_name,$zip_ruta){
			$zip = new ZipArchive();
            $nombre_archivos = array();

			if ($zip->open($zip_name) === TRUE){
				chmod($zip_name, 0777);						
			    $zip->extractTo($zip_ruta);						
			    $z = zip_open($zip_name);						
			    while ($entry = zip_read($z)){
					$nombre_archivos[] = zip_entry_name($entry);
				}
				foreach ($nombre_archivos as $key => $value) {
					chmod($zip_ruta.$value, 0777);				
				}
				unlink($zip_name);			
				foreach ($nombre_archivos as $key => $value) {
					echo $value."{";
				}						
			    $zip->close();								
			} else {
			    return '<br><b>Error al descomprimir archivo ZIP</b><br>';
			}
		}
	}