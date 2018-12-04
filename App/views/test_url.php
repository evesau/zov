<?php
header('Content-Type: application/json; charset=utf-8');
$proceso_retencion_cliente = new stdClass();

$nombre_cliente = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

$proceso_retencion_cliente->Cliente = array(array("id_cliente" => "120",
													"nombre_cliente" => "Cliente prueba",
												    "num_cuenta" => "02835024539",
												    "hora_dispositivo" => "13:10"
											)); 

for ($i=0; $i < 2; $i++) { 
	$proceso_retencion_cliente->Cliente[$i]["id_cliente"] =  rand(1,100);
	$proceso_retencion_cliente->Cliente[$i]["nombre_cliente"] = "érnesto";//substr($nombre_cliente,rand(1,strlen($nombre_cliente)),7);
	$proceso_retencion_cliente->Cliente[$i]["num_cuenta"] = rand(20000000000,45000000000);
	$proceso_retencion_cliente->Cliente[$i]["hora_dispositivo"] = rand(1,19).":".rand(0,59);
}

$proceso_retencion_cliente->filas_total = 10;

$json = json_encode($proceso_retencion_cliente);
echo $json;
//echo "Mundo";
?>