<?php
/**
* Server SOAP Esau envio de mts Sky
* 2017-Feb-09
**/
$ips = array(	1=>"74.86.122.51",
				2=>"189.207.165.130"
			);
//print_r($_SERVER);
$acceso = true;
foreach ($ips as $key => $value) {
	if (preg_match("/$value/",$_SERVER['REMOTE_ADDR'])) {
		$acceso = true;
	}
}
if ($acceso) {
	if(!extension_loaded("soap")){
	      dl("php_soap.dll");
	}
	 
	ini_set("soap.wsdl_cache_enabled","0");

	$server = new SoapServer("https://smsmkt.amovil.mx/wsdl/skysms/SmsSkyWs.wsdl");
	 
	$server->AddFunction("sendSms");
	$server->AddFunction("statusSms");
	$server->AddFunction("incomingSms");
	$server->AddFunction("balanceSms");
	$server->AddFunction("exchangeSms");
	$server->AddFunction("changePasswordSms");
	$server->handle();

	//print_r($server);

}else{
	error('Sin acceso');
}



function sendSms($params)
{
	return $params;
	//print_r($params)
}

function statusSms($params)
{
	return "statusSms";
}

function incomingSms($params)
{
	return "incomingSms";
}

function balanceSms($params)
{
	return "balanceSms";
}

function exchangeSms($params)
{
	return "exchangeSms";
}

function changePasswordSms($params)
{
	return $params;
}


function error($mensaje){
	echo "Error: $mensaje";
	exit();
}

?>