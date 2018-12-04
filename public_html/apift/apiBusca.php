<?php
dbconnect();
//$client =$_GET['client'];
$query ="
	SELECT * FROM client_msisdn c
    INNER JOIN msisdn m USING ( msisdn_id )
    WHERE c.client_id =1
";

$consulta = mysql_query($query);

while($row = mysql_fetch_array($consulta)){

		$msisdn = substr($row['msisdn'], -10);

		exec("/home/smsmkt/public/apift/https_ift $msisdn", $respuesta);

		print_r($respuesta);
	

		$respuesta = exec("php parsea_carrier.php");

		$id_carrier = getParseo($respuesta);

		$query1 = "
UPDATE msisdn 
SET carrier_id = ".$id_carrier ."
WHERE msisdn_id = ".$row['msisdn_id']." AND msisdn=52".$msisdn;

		echo "\n".$query1."\n";

		$ejecutar = mysql_query($query1);
		

    }


	function getParseo($respuesta){
		    if(preg_match("/TELCEL/",$respuesta)){
    			echo "\nTELCEL<br>";
	        	return 1;
    		} elseif(preg_match("/MOVISTAR/",$respuesta) || preg_match("/SAI/",$respuesta) || preg_match("/TRUU/",$respuesta) || preg_match("/VIRGIN/",$respuesta)){
     		  echo "\nMOVISTAR<br>";
	          return 2;
	       	} elseif(preg_match("/AT*/",$respuesta)){
	       		echo "\nATT<br>";
	        	return 3;
	        } else {
	        	echo $respuesta;      
	       		return -1;
	       	}
	}

	function dbconnect($dbname="sms",$user="smsmkt",$password="231mktsms",$server="smppfuenf.amovil.mx") {
  
        if (!($mylink = mysql_connect($server,$user,$password))) {
            print "could not connect to database\n";
            exit;
        }

        mysql_select_db($dbname);
	}


?>
