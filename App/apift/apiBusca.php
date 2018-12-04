<?php
$msisdn = $_GET['msisdn'];
	
	exec("/home/smsmkt/App/apift/https_ift $msisdn");
	$respuesta = exec("php parsea_carrier.php");

	$id_carrier = getParseo($respuesta);

	//echo "$msisdn\n";

	return $id_carrier;


	function getParseo($respuesta){
		    if(preg_match("/TELCEL/",$respuesta)){
    			//echo "\nTELCEL\n";
	        	return 1;
    		} elseif(preg_match("/MOVISTAR/",$respuesta) || preg_match("/SAI/",$respuesta) || preg_match("/TRUU/",$respuesta) || preg_match("/VIRGIN/",$respuesta)){
     		  //echo "\nMOVISTAR\n";
	          return 2;
	       	} elseif(preg_match("/AT*/",$respuesta)){
	       		//echo "\nATT\n";
	        	return 3;
	        } else {
	        	//echo $respuesta;      
	       		return -1;
	       	}
	}

?>
