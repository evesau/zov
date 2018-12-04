<?php
/*header("Content-Type: application/xml; charset=utf-8");	
$respuesta =<<<xml
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.sky.com/SkySmsHeader" xmlns:ns2="http://www.sky.com/SkySmsSend">
   <SOAP-ENV:Body>
      <ns2:SendSmsResponse>
         <ns2:idMessage>0</ns2:idMessage>
         <ns2:success>true</ns2:success>
         <ns2:code>1</ns2:code>
         <ns2:description>Queued</ns2:description>
         <ns2:operator>Looking an carrier</ns2:operator>
      </ns2:SendSmsResponse>
   </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
xml;
echo $respuesta;
exit();*/
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
// Notificar todos los errores de PHP
error_reporting(-1);
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');	
//$soap = file_get_contents('php://input');
////mail('esau.espinoza@airmovil.com','soap server',file_get_contents('php://input'));
include 'model/ApiSmsSkyWs.php'; // Regresa Objetos
//@mail("tecnico@airmovil.com","TESTING SmsSkyWs.php","SOAP: $soap\n SERVER:".print_r($_SERVER,1));
if(!extension_loaded("soap")){
      dl("php_soap.dll");
}
 
ini_set("soap.wsdl_cache_enabled","0");
$server = new SoapServer("https://smsmkt.amovil.mx/wsdl/skysms/SmsSkyWs.wsdl");

function sendSms($params)
{
	$tecnico = 'tecnico@airmovil.com';
	//mail("$tecnico", 'SOAP sendSms', file_get_contents("php://input"). "\nparams: \n" . print_r($params,1).print_r($_SERVER,1) );

	//$customer_id 	= '';
	$proveedorId	= $params->headerRequest->proveedorId; 
	$proveedor 		= $params->headerRequest->proveedor;
	$user 			= trim($params->headerRequest->user);
	$pass 			= trim($params->headerRequest->password);
	$msisdn 		= $params->message->phoneNumber;
	$mensaje 		= $params->message->message;
	
	$passwordBD = ApiSmsSkyWs::getUserUno($user,$pass);

	$password = $passwordBD->password;
	$nickname = $passwordBD->nickname;	
	$customer_id = $passwordBD->customer_id;
	$varpass = strcmp($pass, $password);
	$varuser = strcmp($user, $nickname);
	//mail("$tecnico", "getUser ws-multi", "pass:$pass -".print_r($passwordBD,1). "var: $varpass - varuser: $varuser" );


	

	if ($varpass !=0 && $varuser !=0 ) {
		$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
	            <ns1:messageError>Authentication failed</ns1:messageError>
	        </ns2:headerResponse>
html;
	    mail("$tecnico","Error login sendSms SmsSkyWs.php",print_r($params,1).print_r($_SERVER,1));	    
	    procesoResponse($headerResponse,$messageResponse='');
	}


	if (!preg_match("/^[0-9]{2}[0-9]{10}$/",$msisdn)) {
		$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-7</ns1:codeError>
	            <ns1:messageError>Enter 12-digit phone</ns1:messageError>
	        </ns2:headerResponse>
html;
	    procesoResponse($headerResponse,$messageResponse='');
	}


	if (strlen($mensaje) > 160) {
		$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-8</ns1:codeError>
	            <ns1:messageError>Message with more 160 characters</ns1:messageError>
	        </ns2:headerResponse>
html;
	 	procesoResponse($headerResponse,$messageResponse='');      
	}

	if(!eliminarAcentos($mensaje)){
		$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-13</ns1:codeError>
	            <ns1:messageError>Invalid characters</ns1:messageError>
	        </ns2:headerResponse>
html;
		procesoResponse($headerResponse,$messageResponse='');	
	}


	/*### Proceso nuevo
	$sms_id = curl($user, $pass, $msisdn, $mensaje);

	if($sms_id>0) {
		$headerResponse='';
		$messageResponse =<<<html
	<ns2:idMessage>$sms_id</ns2:idMessage>
	<ns2:success>true</ns2:success>
	<ns2:code>1</ns2:code>
	<ns2:description>Queued</ns2:description>
	<ns2:operator>Looking an carrier</ns2:operator>
html;
		procesoResponse($headerResponse,$messageResponse);
	} else { # Fallo al insertar en sms_campaign

		$headerResponse =<<<html
<ns2:headerResponse>
	<ns1:codeError>-11</ns1:codeError>
	<ns1:messageError>Fail insert sms</ns1:messageError>
</ns2:headerResponse>
html;

		procesoResponse($headerResponse,$messageResponse='');
	}

	### Fin proceso nuevo*/





	# Verificamos bolsa de envio
	
	$bolsaSms = ApiSmsSkyWs::getBolsaMTNew($customer_id);
	if ($bolsaSms->fecha_compra == '') {
		$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-100</ns1:codeError>
	            <ns1:messageError>Error customer</ns1:messageError>
	        </ns2:headerResponse>
html;

		procesoResponse($headerResponse,$messageResponse='');
	} 

	$balanceQuery = ApiSmsSkyWs::getBolsaMTSumaNew($customer_id, $bolsaSms->fecha_compra, $bolsaSms->fecha_expira);
	$balance = $balanceQuery->suma;
	if($balance == ''){
		$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-14</ns1:codeError>
	            <ns1:messageError>Empty sms bag $balance</ns1:messageError>
	        </ns2:headerResponse>
html;

		procesoResponse($headerResponse,$messageResponse='');
	}

	$resta = ($bolsaSms->total - $balance);
	if($resta < 1){
		$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-14</ns1:codeError>
	            <ns1:messageError>Empty sms bag $balance 2 {$bolsaSms->total}</ns1:messageError>
	        </ns2:headerResponse>
html;

		procesoResponse($headerResponse,$messageResponse='');
	}
	
	
	if ($customer_id == 1) {
		$campaign_id = 344; // campaign_id de customer airmovil. 254 short 76551 , 255 short 59850 , 344 short 24766, 348, short 12345
		$ccsc_id = 23;
	} else {
		if ($user == 'skyservice') {
			$campaign_id = 404; // campaign_id solo para sky id 233 short 59850 256 short 76551, short 349 short 24766, 350 short 12345, 404 short 12345
			$ccsc_id = 24;
		} elseif ($user == 'skyccc') {
			$campaign_id = 401; // campaign_id solo para sky id 233 short 59850 256 short 76551, short 401 short 24766,
			$ccsc_id = 23;
		} elseif ($user == 'skyvetv') {
			$campaign_id = 349; // campaign_id solo para sky id 233 short 59850 256 short 76551, short 349 short 24766,
			$ccsc_id = 23;
		}
	}
			
	$sms_campaign_estatus_id_sms = 4;
	$buscaMsisdn = ApiSmsSkyWs::getMsisdnCatalogoMsisdnNew($msisdn);	
	if ($buscaMsisdn->msisdn != '') {

		$msisdnId = $buscaMsisdn->msisdn_id;
		$carrier_id = $buscaMsisdn->carrier_id;

		if ($carrier_id == 1) {
			$carrier = 'telcel';
		} elseif ($carrier_id == 2) {
			$carrier = 'movistar';
		} elseif ($carrier_id == 3 ) {
			$carrier = 'att';
		} else {
			$carrier = 'Looking an carrier';
		}
	
		$insertarSms = ApiSmsSkyWs::insertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje);
		if ($insertarSms == 0 || empty($insertarSms)) {
			$buscaID = ApiSmsSkyWs::getInsertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $mensaje, $msisdn, $customer_id);
			$insertarSms = $buscaID->sms_campaign_id;		
		}
		
	}else{

		
		$msisdnId = ApiSmsSkyWs::insertIgnoreMsisdn($msisdn, 12);
		$carrier = 'Looking an carrier';

		if ($msisdnId=='' || $msisdnId<0) {
						
			$buscaMsisdn = ApiSmsSkyWs::getMsisdnCatalogoMsisdnNew($msisdn);
			$msisdnId = $buscaMsisdn->msisdn_id;

			if ($buscaMsisdn->msisdn == '') {	
				$headerResponse =<<<html
<ns2:headerResponse>
	<ns1:codeError>-11</ns1:codeError>
	<ns1:messageError>Fail insert sms</ns1:messageError>
</ns2:headerResponse>
html;
				
				procesoResponse($headerResponse,$messageResponse='');				
			}
	
		}

		$insertarSms = ApiSmsSkyWs::insertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje);
		if ($insertarSms == 0 || empty($insertarSms)) {
			$buscaID = ApiSmsSkyWs::getInsertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $mensaje, $msisdn, $customer_id);
			$insertarSms = $buscaID->sms_campaign_id;		
		}
		
	}


	if($insertarSms>0) {
		$headerResponse='';
		$messageResponse =<<<html
	<ns2:idMessage>$insertarSms</ns2:idMessage>
	<ns2:success>true</ns2:success>
	<ns2:code>1</ns2:code>
	<ns2:description>Queued</ns2:description>
	<ns2:operator>$carrier</ns2:operator>
html;

		procesoResponse($headerResponse,$messageResponse);
	} else { # Fallo al insertar en sms_campaign

		$headerResponse =<<<html
<ns2:headerResponse>
	<ns1:codeError>-11</ns1:codeError>
	<ns1:messageError>Fail insert sms</ns1:messageError>
</ns2:headerResponse>
html;

		procesoResponse($headerResponse,$messageResponse='');
	}

}

function curl($user, $pwd, $destination, $text){
	$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://10.186.188.188:8000/send/fastTrack/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "user=$user&pwd=$pwd&destination=$destination&text=$text",
			CURLOPT_HTTPHEADER => array(
			    "content-type: application/x-www-form-urlencoded",
				),
			)
		);

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  return $response;
		}


}


function procesoResponse($headerResponse = '', $messageResponse = ''){

	header("Content-Type: application/xml; charset=utf-8");	
	$response =<<<html
	<SOAP-ENV:Envelope 
	xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
	xmlns:ns1="http://www.sky.com/SkySmsHeader" 
	xmlns:ns2="http://www.sky.com/SkySmsSend">
	   <SOAP-ENV:Body>
	      <ns2:SendSmsResponse>
	         $headerResponse
	         $messageResponse
	      </ns2:SendSmsResponse>
	   </SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;

	echo $response;
	//mail("$tecnico","Response sendSms",print_r($response,1));	
	exit;
}


function statusSms($params)
{
	$esau = 'esau.espinoza@airmovil.com';
	$tecnico = 'tecnico@airmovil.com';
	//mail("$tecnico", 'SOAP statusSms', file_get_contents("php://input"). "params: \n" . print_r($params,1).print_r($_SERVER,1));

	//$customer_id 	= $params->headerRequest->proveedorId;
	$user 			= trim($params->headerRequest->user);
	$pass 			= trim($params->headerRequest->password);
	$idMessage		= $params->idMessage;

	$passwordBD = (array) ApiSmsSkyWs::getUserUno($user,$pass);

	$password = $passwordBD['password'];
	$nickname = $passwordBD['nickname'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];
	$varpass = strcmp($pass, $password);
	$varuser = strcmp($user, $nickname);
	//mail("$tecnico", "getUser ws-multi", "pass:$pass -".print_r($passwordBD,1). "var: $varpass - varuser: $varuser" );

	if ($varpass !=0 && $varuser !=0 ) {
		$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
	            <ns1:messageError>Authentication failed</ns1:messageError>
	        </ns2:headerResponse>
html;
	    mail("$tecnico","Error login statusSms SmsSkyWs.php",print_r($params,1).print_r($_SERVER,1));
	} else {

		$userDB = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);
		//mail("$esau",'userDB', print_r($userDB,1));

		$userMaster = $userDB['nickname'];
		$passMaster = $userDB['password'];



		$userData = new \stdClass();
		$userData->_name = trim($userMaster);
		$userData->_pass = trim($passMaster);

		$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

		$messageResponse = '';

		$login = ApiSmsSkyWs::getByIdLoginWs($userData);
		//mail("$esau",'login statusSms', print_r($login,1));
	
		if (!empty($login)) {

			$statusSms = ApiSmsSkyWs::getStatusSms($idMessage);
			//mail("$esau","statusSms",print_r($statusSms,1));
			$headerResponse = '';

			$messageResponse = '';

		
			if (!empty($statusSms)) { # sms encontrado
				$sms_estatus = (string) $statusSms->sms_estatus;
				$carrier = (string) $statusSms->carrier;
				$campaign_id = $statusSms->campaign_id;
				# buscamos que el sms encontrado pertenecas a una campaña del usuario
				$campaignUser = ApiSmsSkyWs::getCampaignId($campaign_id);
				$messageResponse=<<<html
			<ns2:status></ns2:status>
			<ns2:description></ns2:description>
			<ns2:operator></ns2:operator>
			<ns2:pais></ns2:pais>
			<ns2:estado></ns2:estado>
			<ns2:municipio></ns2:municipio>
			<ns2:poblacion></ns2:poblacion>
html;
				if (!empty($campaignUser)) { 
					////mail("$esau","campaignUser",print_r($campaignUser,1).md5($pass));
					# Verificamos si la campania le pertenece al usuario
					if ($campaignUser->password == $userData->_pass) {

						$bl=0; // cuando se buscaba en blackllist de telcel

						if ($bl == 1) {
							$Status = 4;
							$Description = 'Blacklist';
						} else {

							$arrayStatus = array(
												0 => array('sms_campaign_estatus_id'=>0,'estatus'=>'delivered'),
												1 => array('sms_campaign_estatus_id'=>20,'estatus'=>'ACCEPTD'),
												2 => array('sms_campaign_estatus_id'=>21,'estatus'=>'REJECTD'));
							$arrayStatus1 = ApiSmsSkyWs::getStatusSmsCampaing();
							foreach ($arrayStatus1 as $key => $value) {
								$arrayStatus2[] = (array)$value;
							}
							foreach ($arrayStatus as $k => $val) {
								$arrayStatus2[] = (array)$val;
							}
							//$arrayStatus2[] = $arrayStatus;
							////mail("$esau","arrayStatus1",print_r($arrayStatus2,1));
							foreach ($arrayStatus2 as $key => $value) {
								if (preg_match("/$sms_estatus/", $value['estatus'])) {
									$sms_estatus_fin = $value['estatus'];
								}
								//if ($sms_estatus == $value['estatus']) {
									////mail("$esau","foreach value",print_r($value,1));
									//$sms_estatus = $value['estatus'];
									
								//}
							}

							if ($sms_estatus_fin=='preparado para envio'||$sms_estatus_fin=='encolado'||$sms_estatus_fin=='en proceso por ser encolado') {
								$Status = 0;
								$Description = 'Pending';
							}
							elseif ($sms_estatus_fin=='envio white list'||$sms_estatus_fin=='proceso white list'||$sms_estatus_fin=='busca carrier'||$sms_estatus_fin=='buscando carrier') {
								$Status = 1;
								$Description = 'Processing';
							}
							elseif ($sms_estatus_fin=='sin carrier'||$sms_estatus_fin=='error'||$sms_estatus_fin=='error white list'||$sms_estatus_fin=='cancelado'||$sms_estatus_fin=='no telcel'||$sms_estatus_fin=='REJECTD') {
								$Status = 2;
								$Description = 'Failed';
							}
							elseif ($sms_estatus_fin=='delivered' || $sms_estatus_fin=='ACCEPTD') {
								$Status = 3;
								$Description = 'Delivered';
							}
							elseif ($sms_estatus_fin=='blacklist') {
								$Status = 4;
								$Description = 'Blacklist';
							}
						}

						$messageResponse=<<<html
			<ns2:status>$Status</ns2:status>
			<ns2:description>$Description</ns2:description>
			<ns2:operator>$carrier</ns2:operator>
			<ns2:pais></ns2:pais>
			<ns2:estado></ns2:estado>
			<ns2:municipio></ns2:municipio>
			<ns2:poblacion></ns2:poblacion>
html;
					}
					else{ # no se encontro campaña correspondiente al usuario
						$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
	            <ns1:messageError>Message not found</ns1:messageError>
	        </ns2:headerResponse>
html;
					}
				}
				else{ # no se encontro campaña
					$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
	            <ns1:messageError>Message not found</ns1:messageError>
	        </ns2:headerResponse>
html;
				}

			}
			else{ # no se encontro sms
				$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
	            <ns1:messageError>Message not found</ns1:messageError>
	        </ns2:headerResponse>
html;
			}

		} # Fin de if login
		else{ # En caso de login failed
			$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
	            <ns1:messageError>Authentication failed</ns1:messageError>
	        </ns2:headerResponse>
html;
		}

	}

	header("Content-Type: application/xml; charset=utf-8");	
	$response =<<<html
<SOAP-ENV:Envelope
	xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
	xmlns:ns1="http://www.sky.com/SkySmsHeader"
	xmlns:ns2="http://www.sky.com/SkySmsStatus">
	<SOAP-ENV:Body>
		<ns2:StatusSmsResponse>
			$headerResponse
			$messageResponse
		</ns2:StatusSmsResponse>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>
html;

	echo $response;
	//mail("$tecnico","Response statusSms",print_r($response,1));
	exit;
	
}

 
function changePasswordSms($params)
{
	$esau = 'esau.espinoza@airmovil.com';
	//mail("$esau", 'SOAP changePasswordSms', file_get_contents("php://input"). "params: \n" . print_r($params,1).file_get_contents("php://output"));
	$customer_id 	= $params->headerRequest->proveedorId;
	$user 			= trim($params->headerRequest->user);
	$pass 			= trim($params->headerRequest->password);
	$newPassword	= $params->newPassword;

	$passwordBD = (array) ApiSmsSkyWs::getUserUno($user,$pass);

	$password = $passwordBD['password'];
	$nickname = $passwordBD['nickname'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];
	$varpass = strcmp($pass, $password);
	$varuser = strcmp($user, $nickname);
	//mail("$tecnico", "getUser ws-multi", "pass:$pass -".print_r($passwordBD,1). "var: $varpass - varuser: $varuser" );

	if ($varpass !=0 && $varuser !=0 ) {
		$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
	            <ns1:messageError>Authentication failed</ns1:messageError>
	        </ns2:headerResponse>
html;
		mail("$tecnico","Error login changePasswordSms SmsSkyWs.php",print_r($params,1).print_r($_SERVER,1));
	} else {

		$userDB = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);

		$userMaster = $userDB['nickname'];
		$passMaster = $userDB['password'];



		$userData = new \stdClass();
		$userData->_name = trim($userMaster);
		$userData->_pass = trim($passMaster);

		$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

		$messageResponse = '';

		$login = ApiSmsSkyWs::getByIdLoginWs($userData);
	
		if (!empty($login)) {
			$user_id = $login->user_id;
			//mail("$esau"," changePasswordSms","user_id:".$user_id." newPassword:".$newPassword);
			$headerResponse = '';
			$messageResponse = '';
			if (strlen($newPassword)>=8) {

				if (preg_match("/(?=^[^\s]{8,128}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/",$newPassword)) {

					$updatePass = ApiSmsSkyWs::getUpdatePass($user_ws_id,$newPassword);

					if ($updated!==FALSE) {
						$messageResponse = '
			<ns2:code>1</ns2:code>
			<ns2:description>Password updated successful</ns2:description>
		';
					}
					else{
						$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-4</ns1:codeError>
	            <ns1:messageError>Password update failed</ns1:messageError>
	        </ns2:headerResponse>
html;
					}
				
				}
				else{
					$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-3</ns1:codeError>
	            <ns1:messageError>Enter a Number or a letter Uppercase</ns1:messageError>
	        </ns2:headerResponse>
html;
				}
			}
			else{
				$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
	            <ns1:messageError>Minimum entry 8 characters</ns1:messageError>
	        </ns2:headerResponse>
html;
			}
		}
		else{ # En caso de login failed
			$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
	            <ns1:messageError>Authentication failed</ns1:messageError>
	        </ns2:headerResponse>
html;
		}
	}


header("Content-Type: application/xml; charset=utf-8");
$response =<<<html
	<SOAP-ENV:Envelope 
	xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
	xmlns:ns1="http://www.sky.com/SkySmsHeader" 
	xmlns:ns2="http://www.sky.com/SkySmsChangePassword">
	   <SOAP-ENV:Body>
	      <ns2:ChangePasswordSmsResponse>
	         $headerResponse
	         $messageResponse
	      </ns2:ChangePasswordSmsResponse>
	   </SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;
	
	echo $response;
	//mail("$tecnico","Response changePasswordSms",print_r($response,1));
	exit;
}


function balanceSms($params)
{

	//$input = file_get_contents("php://input");
	/*$tecnico = 'tecnico@airmovil.com';
	header("Content-Type: application/xml; charset=utf-8");
	$response =<<<html
	<SOAP-ENV:Envelope
		xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
		xmlns:ns1="http://www.sky.com/SkySmsHeader"
		xmlns:ns2="http://www.sky.com/SkySmsBalance">
		<SOAP-ENV:Body>
			<ns2:BalanceSmsResponse>
				<ns2:netBalance>10</ns2:netBalance>
				<ns2:usedBalance>10</ns2:usedBalance>
				<ns2:balance>0</ns2:balance>
				<ns2:dateQuery>2018-08-23 01:00:00</ns2:dateQuery>
				<ns2:description>Balance sms ok</ns2:description>
				<ns2:code>1</ns2:code>
			</ns2:BalanceSmsResponse>
		</SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;

	echo $response;
	exit;*/

		
	$esau = "esau.espinoza@airmovil.com";
	$tecnico = "tecnico@airmovil.com";
	//mail("$tecnico","balanceSms","params: \n". print_r($params,1)."\n soap \n".file_get_contents("php://input").print_r($_SERVER,1));
	//$customer_id 	= '';/*$params->headerRequest->proveedorId;
	$user 			= trim($params->headerRequest->user);
	$pass 			= trim($params->headerRequest->password);

	$passwordBD = (array) ApiSmsSkyWs::getUserUno($user,$pass);

	$password = $passwordBD['password'];
	$nickname = $passwordBD['nickname'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];
	$varpass = strcmp($pass, $password);
	$varuser = strcmp($user, $nickname);
	//mail("$tecnico", "getUser ws-multi", "pass:$pass -".print_r($passwordBD,1). "var: $varpass - varuser: $varuser" );

	if ($varpass !=0 && $varuser !=0 ) {
		$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
	            <ns1:messageError>Authentication failed</ns1:messageError>
	        </ns2:headerResponse>
html;
		mail("$tecnico","Error login balanceSms SmsSkyWs.php",print_r($params,1).print_r($_SERVER,1));
	} else {

		$userDB = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);

		$userMaster = $userDB['nickname'];
		$passMaster = $userDB['password'];



		$userData = new \stdClass();
		$userData->_name = trim($userMaster);
		$userData->_pass = trim($passMaster);

		$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

		$messageResponse = '';

		$login = ApiSmsSkyWs::getByIdLoginWs($userData);
		////mail("$esau","login balanceSms", print_r($login,1)."user:".trim($user)."_ & pass:".trim($pass)."_");
		if (!empty($login)) {
		
			$customer_id = $login->customer_id;

			# Verificamos bolsa de envio
			$getTotalesCustomerMes = ApiSmsSkyWs::getBolsaMT($customer_id);
			if (!empty($getTotalesCustomerMes)) {
				////mail("$tecnico", 'total bolsaSms', print_r($getTotalesCustomerMes,1));
				$netBalance = $getTotalesCustomerMes->bolsa_sms;
				$usedBalance = $getTotalesCustomerMes->delivered;
				$balance = $getTotalesCustomerMes->resta_bolsa;
			} else {
				$balance = 0;
			}
			if ((int)$balance > 0) {
			
				$fecha = getFecha();
				$headerResponse = '';

				$messageResponse =<<<html
				<ns2:netBalance>$netBalance</ns2:netBalance>
				<ns2:usedBalance>$usedBalance</ns2:usedBalance>
				<ns2:balance>$balance</ns2:balance>
				<ns2:dateQuery>$fecha</ns2:dateQuery>
				<ns2:description>Balance sms ok</ns2:description>
				<ns2:code>1</ns2:code>
html;
			}
			else{
				$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
	            <ns1:messageError>Empty balance</ns1:messageError>
	        </ns2:headerResponse>
html;
			}
		}
		else{
			$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
	            <ns1:messageError>Authentication failed</ns1:messageError>
	        </ns2:headerResponse>
html;
		}

	}


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
	//mail("$tecnico","Response balanceSms",print_r($response,1));
	exit;
	
}

function exchangeSms($params)
{
	$esau = 'esau.espinoza@airmovil.com';
	$tecnico ="tecnico@airmovil.com";
	//mail("$esau","exchangeSms", file_get_contents("php://input"). "params: \n" . print_r($params,1));

	$customer_id 	= '';//$params->headerRequest->proveedorId;
	$user 			= trim($params->headerRequest->user);
	$pass 			= trim($params->headerRequest->password);

	$passwordBD = (array) ApiSmsSkyWs::getUserUno($user,$pass);

	$password = $passwordBD['password'];
	$nickname = $passwordBD['nickname'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];
	$varpass = strcmp($pass, $password);
	$varuser = strcmp($user, $nickname);
	//mail("$tecnico", "getUser ws-multi", "pass:$pass -".print_r($passwordBD,1). "var: $varpass - varuser: $varuser" );

	if ($varpass !=0 && $varuser !=0 ) {
		$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
	            <ns1:messageError>Authentication failed</ns1:messageError>
	        </ns2:headerResponse>
html;
		mail("$tecnico","Error login exchangeSms SmsSkyWs.php",print_r($params,1).print_r($_SERVER,1));
	} else {

		$userDB = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);

		$userMaster = $userDB['nickname'];
		$passMaster = $userDB['password'];



		$userData = new \stdClass();
		$userData->_name = trim($userMaster);
		$userData->_pass = trim($passMaster);

		$headerResponse = '';
		$messageResponse = '';

		$login = ApiSmsSkyWs::getByIdLoginWs($userData);
		if (!empty($login)) {
			//mail("$esau","login exchangeSms",print_r($login,1));
			$user_id = $login->user_id;
			$customer_id = ($login->customer_id=='') ? $login->customer_id : $login->customer_id;
			$bolsa = ApiSmsSkyWs::getBolsa($customer_id);
			//mail("$esau","bolsa exchangeSms", print_r($bolsa,1));
			if (!empty($bolsa)) {
				$messageResponse =<<<html
			<ns2:code>1</ns2:code>
			<ns2:description>Purchase list sms ok</ns2:description>
html;
				$messageResponse .=<<<html
			<ns2:listOrders>
html;
			
				foreach ($bolsa as $key => $value) {
					$messageResponse .=<<<html
				<ns2:order>
					<ns2:idPurchase>{$value->sms_bag_id}</ns2:idPurchase>
					<ns2:purchaseDate>{$value->fecha_compra}</ns2:purchaseDate>
					<ns2:amountMessages>{$value->cantidad}</ns2:amountMessages>
				</ns2:order>
html;
				}
			
				$messageResponse .=<<<html
			</ns2:listOrders>
html;
			}
			else{
				$messageResponse =<<<html
			<ns2:code>-2</ns2:code>
			<ns2:description>Empty purchase list sms</ns2:description>
html;
			}
		}
		else{
			$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
				<ns1:messageError>Authentication failed</ns1:messageError>
			</ns2:headerResponse>
html;
		}
	}

		$response =<<<html
<SOAP-ENV:Envelope 
	xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
	xmlns:ns1="http://www.sky.com/SkySmsHeader" 
	xmlns:ns2="http://www.sky.com/SkySmsExchange">
	<SOAP-ENV:Body>
		<ns2:ExchangeSmsResponse>
			$headerResponse
			$messageResponse			
      </ns2:ExchangeSmsResponse>
   </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
html;

	header("Content-Type: application/xml; charset=utf-8");
	echo $response;
	//mail("$tecnico","Response exchangeSms",print_r($response,1));
	exit;
}


function incomingSms($params)
{
	$esau = 'esau.espinoza@airmovil.com';
	$tecnico = "tecnico@airmovil.com";
	//mail("$esau", "incomingSms", file_get_contents("php://input"). "params: \n" . print_r($params,1));

	$customer_id 	= '';//$params->headerRequest->proveedorId;
	$user 			= $params->headerRequest->user;
	$pass 			= $params->headerRequest->password;
	$idMessage		= $params->idMessage;
	$fechaI			= $params->from;
	$fechaF			= $params->to;

	$passwordBD = (array) ApiSmsSkyWs::getUserUno($user,$pass);

	$password = $passwordBD['password'];
	$nickname = $passwordBD['nickname'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];
	$varpass = strcmp($pass, $password);
	$varuser = strcmp($user, $nickname);
	//mail("$tecnico", "getUser ws-multi", "pass:$pass -".print_r($passwordBD,1). "var: $varpass - varuser: $varuser" );

	if ($varpass !=0 && $varuser !=0 ) {
		$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
	            <ns1:messageError>Authentication failed</ns1:messageError>
	        </ns2:headerResponse>
html;
		mail("$tecnico","Error login incomingSms SmsSkyWs.php",print_r($params,1).print_r($_SERVER,1));
	} else {

		$userDB = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);

		$userMaster = $userDB['nickname'];
		$passMaster = $userDB['password'];



		$userData = new \stdClass();
		$userData->_name = trim($userMaster);
		$userData->_pass = trim($passMaster);

		$headerResponse = '';
		$messageResponse = '';

		$login = ApiSmsSkyWs::getByIdLoginWs($userData);
		if (!empty($login)) {
			////mail("$esau","login incomingSms",print_r($login,1));
			$user_id = $login->user_id;
			$customer_id = ($customer_id=='') ? $login->customer_id : $login->customer_id;
		##
			if (!empty($idMessage) && empty($fechaI) && empty($fechaF)) {
				$mos = ApiSmsSkyWs::getIncomming($idMessage);
				if (!empty($mos)) {
					////mail("$esau","mos id sin fecha",print_r($mos,1));
					$campaign_id = $mos[0]->campaign_id;
					$campaignUser = ApiSmsSkyWs::getCampaignId($campaign_id);
					//mail("$esau","campanias","respuesta de idMessage".print_r($campaignUser,1)."login user_id:".$user_id);
					if ($user_id == $campaignUser->user_id) {
						$totalM = count($mos);
						$messageResponse =<<<html
				<ns2:status>1</ns2:status>
				<ns2:description>Messages received</ns2:description>
				<ns2:messages>{$totalM}</ns2:messages>
				<ns2:listMessages>
html;
						foreach ($mos as $key => $value) {
							$messageResponse .=<<<html
					<ns2:message>
						<ns2:answerDate>{$value->entry_time}</ns2:answerDate>
						<ns2:phoneNumber>{$value->source}</ns2:phoneNumber>
						<ns2:message>{$value->content}</ns2:message>
					</ns2:message>
html;
						}
						$messageResponse .=<<<html
				</ns2:listMessages>
html;
					}
					else{
						$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
				<ns1:messageError>Empty data idMessage</ns1:messageError>
			</ns2:headerResponse>
html;

					}
				} # fin de mos
				else{
					$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
				<ns1:messageError>Empty data idMessage</ns1:messageError>
			</ns2:headerResponse>
html;
				}

			} # fin de solo IdMessage
			elseif (empty($idMessage) && !empty($fechaI) && !empty($fechaF)) {
				# obtenemos las campañas del costumer
				$campaniasC = ApiSmsSkyWs::getCampaignIds($customer_id);
				$id = '';
				foreach ($campaniasC as $key => $value) {
					$ids .= $value->campaign_id.",";
				}
				////mail("$esau","ids campaignCustomer", trim($ids,","));
				$mosDate = ApiSmsSkyWs::getIncommingDate(trim($ids,","),fechaInicial($fechaI), fechaFinal($fechaF));
				if (!empty($mosDate)) {
					//mail("$esau","mos de solo fechas",print_r($mosDate,1));
					$totalM = count($mosDate);
					$messageResponse =<<<html
				<ns2:status>1</ns2:status>
				<ns2:description>Messages received</ns2:description>
				<ns2:messages>{$totalM}</ns2:messages>
				<ns2:listMessages>
html;
					foreach ($mosDate as $key => $value) {
						$messageResponse .=<<<html
					<ns2:message>
						<ns2:answerDate>{$value->entry_time}</ns2:answerDate>
						<ns2:phoneNumber>{$value->source}</ns2:phoneNumber>
						<ns2:message>{$value->content}</ns2:message>
					</ns2:message>
html;
					}
					$messageResponse .=<<<html
				</ns2:listMessages>
html;

				}
				else{
					$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-3</ns1:codeError>
				<ns1:messageError>Empty data with dates</ns1:messageError>
			</ns2:headerResponse>
html;
				}
			
			} # fin de solo fechas
			else{ # idMessage y fechas
				$mos = ApiSmsSkyWs::getIncommingFull($idMessage, fechaInicial($fechaI), fechaFinal($fechaF));
				if (!empty($mos)) {
					//mail("$esau","mos full data request",print_r($mos,1));
					$totalM = count($mos);
					$messageResponse =<<<html
				<ns2:status>1</ns2:status>
				<ns2:description>Messages received</ns2:description>
				<ns2:messages>{$totalM}</ns2:messages>
				<ns2:listMessages>
html;
					foreach ($mos as $key => $value) {
						$messageResponse .=<<<html
					<ns2:message>
						<ns2:answerDate>{$value->entry_time}</ns2:answerDate>
						<ns2:phoneNumber>{$value->source}</ns2:phoneNumber>
						<ns2:message>{$value->content}</ns2:message>
					</ns2:message>
html;
					}
					$messageResponse .=<<<html
				</ns2:listMessages>
html;

				}
				else{
					$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-4</ns1:codeError>
				<ns1:messageError>Empty data with IdMessage and dates</ns1:messageError>
			</ns2:headerResponse>
html;
				}
			
			}
		
		}else{
			$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
				<ns1:messageError>Authentication failed</ns1:messageError>
			</ns2:headerResponse>
html;
		}
	}

	$response =<<<html
<SOAP-ENV:Envelope
	xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
	xmlns:ns1="http://www.sky.com/SkySmsHeader"
	xmlns:ns2="http://www.sky.com/SkySmsIncoming">
	<SOAP-ENV:Body>
		<ns2:IncomingSmsResponse>
			$headerResponse
			$messageResponse			
		</ns2:IncomingSmsResponse>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>
html;

	header("Content-Type: application/xml; charset=utf-8");
	echo $response;
	//mail("$tecnico","Response incomingSms",print_r($response,1));
	exit;
}


function getFecha()
{
	$fechaA = getdate();
	if (strlen($fechaA['mon'])>1) {
		$mes = $fechaA['mon'];
	}else{
		$mes = "0".$fechaA['mon'];
	}

	if (strlen($fechaA['seconds'])>1) {
		$segundos = $fechaA['seconds'];
	}else{
		$segundos = "0".$fechaA['seconds'];
	}

	$fecha = $fechaA['year']."-".$mes."-".$fechaA['mday']." ".$fechaA['hours'].":".$fechaA['minutes'].":".$segundos;

	return $fecha;
}

function fechaInicial($fechaI){
	$fecha = $fechaI." 00:00:00";
	return $fecha;
}

function fechaFinal($fechaF){
	$fecha = $fechaF." 23:59:59";
	return $fecha;
}

function eliminarAcentos($text){
 
    $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);

        $patron = array (
            // Espacios, puntos y comas por guion
            //'/[\., ]+/' => ' ',
 
            // Vocales
            '/\+/' => '',
            '/&agrave;/' => 'a',
            '/&egrave;/' => 'e',
            '/&igrave;/' => 'i',
            '/&ograve;/' => 'o',
            '/&ugrave;/' => 'u',
 
            '/&aacute;/' => 'a',
            '/&eacute;/' => 'e',
            '/&iacute;/' => 'i',
            '/&oacute;/' => 'o',
            '/&uacute;/' => 'u',
 
            '/&acirc;/' => 'a',
            '/&ecirc;/' => 'e',
            '/&icirc;/' => 'i',
            '/&ocirc;/' => 'o',
            '/&ucirc;/' => 'u',
 
            '/&atilde;/' => 'a',
            '/&etilde;/' => 'e',
            '/&itilde;/' => 'i',
            '/&otilde;/' => 'o',
            '/&utilde;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            // Otras letras y caracteres especiales
            '/&aring;/' => 'a',
            '/&ntilde;/' => 'n',
            '/&iexcl;/'	=> '',
 
            // Agregar aqui mas caracteres si es necesario
 
        );
 
        $texto = preg_replace(array_keys($patron),array_values($patron),$text);

        if ($texto != $text) {
        	//mail("tecnico@airmovil.com", "acentos y caracteres invalidos ws-multi", "mensaje new: ".$texto ."\nmensaje recibido: ". $text);
        	return false;
        } else {
        	return true;
        }


}


function Security($data){
	////mail("esau.espinoza@airmovil.com","Security",print_r($data,1));
}
 
$server->AddFunction("changePasswordSms");
$server->addFunction("sendSms");
$server->addFunction("statusSms");
$server->addFunction("incomingSms");
$server->addFunction("balanceSms");
$server->addFunction("exchangeSms");
$server->addFunction("Security");
$server->handle();

