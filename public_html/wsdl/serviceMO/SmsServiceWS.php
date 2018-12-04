<?php
error_reporting(E_ALL);
error_reporting(-1);
include 'model/SmsServiceWSDao.php';

if(!extension_loaded("soap")){
      dl("php_soap.dll");
}
 
ini_set("soap.wsdl_cache_enabled","0");
$server = new SoapServer("https://smsmkt.amovil.mx/wsdl/serviceMO/SmsSkyWs.wsdl");

function balanceSms($params){
	$wsse =  'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
	$wsu = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';
	
	$email = 'jorge.manon@airmovil.com';
	mail($email, 'Test Jorge SOAP', print_r($params,1));

	$msisdn = $params->headerRequest->msisdn;
	$source = $params->headerRequest->source;
	$content = $params->headerRequest->content;
	$customerId = $params->headerRequest->customerId;
	$date = $params->headerRequest->date;

	if($error){
		$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError>1</ns1:codeError>
	            <ns1:messageError>Sin Error</ns1:messageError>
	        </ns2:headerResponse>
html;
	}

	$messageResponse =<<<html
<ns2:msisdn>$msisdn</ns2:msisdn>
				<ns2:source>$source</ns2:source>
				<ns2:content>$content</ns2:content>
				<ns2:date>$date</ns2:date>
html;

	header("Content-Type: application/xml; charset=utf-8");
	$response =<<<html
	<SOAP-ENV:Envelope
		xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
		xmlns:ns1="http://www.sky.com/SkySmsHeader"
		xmlns:ns2="http://www.sky.com/SkySmsBalance">
		<SOAP-ENV:Body>
			<ns2:BalanceSmsResponse>
				$headerResponse
				$messageResponse
			</ns2:BalanceSmsResponse>
		</SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;
	echo $response;
	exit;
}


public function endPointClient($params){
	$wsse =  'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
	$wsu = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';
	
	$email = 'jorge.manon@airmovil.com';
	mail($email, 'TEST END POINT CLIENT Jorge SOAP', print_r($params,1));

	$msisdn = $params->headerRequest->msisdn;
	$source = $params->headerRequest->source;
	$content = $params->headerRequest->content;
	$customerId = $params->headerRequest->customerId;
	$date = $params->headerRequest->date;

	header("Content-Type: application/xml; charset=utf-8");
	$response =<<<html
	<SOAP-ENV:Envelope
		xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
		xmlns:ns1="http://www.sky.com/SkySmsHeader"
		xmlns:ns2="http://www.sky.com/EndPointClient">
		<SOAP-ENV:Body>
			<ns2:EndPointClientResponse>
				<ns2:status>1</ns2:status>
				<ns2:description>Recibido OK</ns2:description>
			</ns2:EndPointClientResponse>
		</SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;
	echo $response;
	exit;
}

$server->addFunction("balanceSms");
//$server->addFunction("endPointClient");
$server->handle();



