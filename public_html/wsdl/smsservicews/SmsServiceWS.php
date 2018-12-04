<?php
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
// Notificar todos los errores de PHP
error_reporting(-1);

//mail('tecnico@airmovil.com','soap server smsservice',file_get_contents('php://input'));
include 'model/SmsServiceWSDao.php';

if(!extension_loaded("soap")){
      dl("php_soap.dll");
}
 
ini_set("soap.wsdl_cache_enabled","0");
$server = new SoapServer("https://smsmkt.amovil.mx/wsdl/smsservicews/SmsServiceWs.wsdl");

function sendSms($params)
{
	$input = file_get_contents("php://input");
	$wsse =  'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
	$wsu = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';
	$doc = new \DOMDocument();
	$doc->loadXML($input);
	# capturar elementos
	$arrayElement = explode("\n", trim($doc->documentElement->firstChild->lastChild->nodeValue));
	$Username 			= trim($arrayElement[0]);
	$PasswordDigest 	= trim($arrayElement[1]);
	$nonce 				= trim($arrayElement[2]);
	$created 			= trim($arrayElement[3]);

	$dataFecha = dateTimeOk($created);

	$passwordBD = SmsServiceWSDao::getUser($Username);
	//enviarMail('getUser', '', '',$passwordBD);
	$password = $passwordBD['password'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id = $passwordBD['user_id'];

	$obtieneDatosUser = SmsServiceWSDao::obtieneDatosUser($user_id);
	//enviarMail('obtieneDatosUser','','',$obtieneDatosUser);

	#### almacena objeto para login
	$userData = new \stdClass();
	$userData->_name = $obtieneDatosUser['nickname'];
	$userData->_pass = $obtieneDatosUser['password'];
	//enviarMail('userData','','',$userData);
	#####################

	$password = $nonce.$created.utf8_encode($password);
	$password = base64_encode(sha1($password,true));

	$inicio = false;

	$fechaConsulta = date('Y-m-d h:i:s');
	$expired = SmsServiceWSDao::getExpiredDate($Username, $fechaConsulta);
	//enviarMail('expired','','',$expired);
	
	$timeLoked = SmsServiceWSDao::getTimeLoked($Username,$user_ws_id);
	//enviarMail('timeLoked','','',$timeLoked);
	if (!empty($timeLoked)) {
		$tiempoBloqueo = $timeLoked['resta_tiempo'];
		$limiteIntento = $timeLoked['intento'];
	} else {
		$tiempoBloqueo = 0;
		$limiteIntento = 0;
	}

	$continiaProceso = false;
	if ($limiteIntento < 5) {
		$continiaProceso = true;
	} elseif ($limiteIntento == 5 && $tiempoBloqueo >= 30) {
		$continiaProceso = true;

		# updetear intento a 0 y desbloquear
		$loked = 0;
		$intentos = 0;
		$insertIntento = SmsServiceWSDao::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		$continiaProceso = false;
	}

	if ($password == $PasswordDigest && !empty($expired) && $continiaProceso && $dataFecha ) {
		
		$inicio = true;
		//mail("$tecnico", "ws security sendSms", "Password y PasswordDigest son correctos..."."\nUsername: $Username, PasswordDigest: $PasswordDigest, password: $password, nonce: $nonce, created: $created");
		//enviarMail('entro e inicia proceso','','',"Password y PasswordDigest son correctos..."."\nUsername: $Username, PasswordDigest: $PasswordDigest, password: $password, nonce: $nonce, created: $created");
	} else {
		# Conteo de intentos
		//$conteo = (array) SmsServiceWSDao::getIntento($user,$user_ws_id);

		$timeLoked = SmsServiceWSDao::getTimeLoked($Username,$user_ws_id);

		$bloqueado = $timeLoked['loked'];

		$intentos = $timeLoked['intento'] + 1;

		if ($bloqueado == 1) {
			
			$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError>-11</ns1:codeError>
	            <ns1:messageError>User blocked, wait 30 minutes</ns1:messageError>
	        </ns2:headerResponse>
html;

		} else {

			if ($intentos == 5) {
				$loked = 1;
				$insertIntento = SmsServiceWSDao::insertIntento($Username, $user_ws_id, $intentos, $loked);
			} else {
				$loked = 0;
				$insertIntento = SmsServiceWSDao::insertIntento($Username, $user_ws_id, $intentos, $loked);
			}
			//mail('$tecnico','inserta intento',print_r($insertIntento,1));

			$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError>-1</ns1:codeError>
	            <ns1:messageError>Authentication failed</ns1:messageError>
	        </ns2:headerResponse>
html;

		}

	    header("Content-Type: application/xml; charset=utf-8");	
		$response =<<<html
	<SOAP-ENV:Envelope 
	xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
	xmlns:ns1="http://www.sky.com/SkySmsHeader" 
	xmlns:ns2="http://www.sky.com/SkySmsSend">
		<SOAP-ENV:Body>	   	
	      	<ns2:SendSmsResponse>
	        	$headerResponse    	
	    	</ns2:SendSmsResponse>
	   </SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;
	
	echo $response;
	exit;

	}
	###### Fin de header security
//$request = file_get_contents("php://input");

###### Inicia proceso de envío, obtenemos todas las ultimas 10 camapañas del customer, sacamos campaig_id y nombre de la campaña SMSSERVICEWS
$msisdn = trim($params->message->phoneNumber);
$mensaje = trim($params->message->message);

#### Opcional si trae marcación
$ShortCode = trim($params->headerRequest->proveedorId);

$loginUser = SmsServiceWSDao::getByIdLogin($userData);
//enviarMail('sendSms loginUser',$input, $response, $loginUser);
if (!empty($loginUser)) { // Login user con permiso de envio_mt
	
	$customer_id = $loginUser['customer_id'];
	$user_id = $loginUser['user_id'];

	if (!empty($ShortCode)) { // Buscamos carrier_connection_short_code_id mediante el shortcode enviado
		$ccscArray = SmsServiceWSDao::getCarrierConnectionShortCode($customer_id,$ShortCode);
	} else {
		$ccscArray = SmsServiceWSDao::getCarrierConnectionShortCode($customer_id);
	}

	//enviarMail('carrier_connection_short_code_id','','',$ccscArray);

	$scid1 = $ccscArray[0]['short_code'];
	if (!empty($ShortCode)) {
		if ($ShortCode == $scid1) {
			$marcacion = true;
			$ccsc_id = $ccscArray[0]['carrier_connection_short_code_id'];
		}else{
			$marcacion = false;
		}
	}

	foreach ($ccscArray as $key => $value) {
		if ($scid1 != $value['short_code']) {
			$scid = $value['short_code'];
			$marcacion = false;
			break;
		}		
	}

	//enviarMail('valueShortCode','',$scid1,$scid);

	if (!empty($ccscArray) && $marcacion) {
		
		$nameCampaign = 'CampaniatestSoap';//'SmsServiceWS';
		$campanias = SmsServiceWSDao::getAllCampaignCustomer($customer_id,$nameCampaign); // Buscamos id_campania si encontramos, continuiamos; si no creamos la campania

		if (!empty($campanias)) {
			
			$campaign_id = $campanias[0]['campaign_id'];
			//enviarMail('sendSms Campanias', $campaign_id, $customer_id, $campanias);

		} else {

			//$deliveri_date = "NOW()";
			$campaign_id = SmsServiceWSDao::insertaCampaniaIni($nameCampaign,4,3); // insertamos campania y sus respectivas relaciones
			$campUser = SmsServiceWSDao::insertCampaignUser($user_id, $campaign_id);
			$campCustomer = SmsServiceWSDao::insertaCampaniaCustomer($customer_id, $campaign_id);
			//enviarMail('sendSms sin campania',$campaign_id,$customer_id,"creamos campania id_campania:$campaign_id, campUser: $campUser, campCustomer: $campCustomer");

			foreach ($ccscArray as $key => $value) {
					
					@SmsServiceWSDao::insertaCampaniaCarrierShortCode($campaign_id, $value['carrier_id'], $value['short_code_id']);

					@SmsServiceWSDao::insertaCarrierConnectionShortCodeCampaign($campaign_id, $value['carrier_connection_short_code_id']);

			}

		}

		# Verificamos bolsa de envio
		$getTotalesCustomerMes = SmsServiceWSDao::getTotalesCustomerMes($customer_id);
		$getTotalesCustomerDia = SmsServiceWSDao::getTotalesCustomerDia($customer_id);
		$getTotalesuserMes = SmsServiceWSDao::getTotalesUserMes($user_id);
		$getTotalesuserDia = SmsServiceWSDao::getTotalesUserDia($user_id);
		
		//enviarMail("totales customer",'',$getTotalesCustomerMes,$getTotalesCustomerDia);
		//enviarMail('totales user','',$getTotalesuserMes,$getTotalesuserDia);
		
		$totalMesCustomer = number_format($getTotalesCustomerMes['max_mt_month']);
		$totalMesRestaCustomer = number_format($getTotalesCustomerMes['resta_mes']);
		$totalDiaCustomer = number_format($getTotalesCustomerDia['max_mt_day']);
		$totalDiaRestaCustomer = number_format($getTotalesCustomerDia['resta_dia']);

		$totalMesUser = number_format($getTotalesuserMes['max_mt_month']);
		$totalMesRestaUser = number_format($getTotalesuserMes['resta_mes']);
		$totalDiaUser = number_format($getTotalesuserDia['max_mt_day']);
		$totalDiaRestaUser = number_format($getTotalesuserDia['resta_dia']);

		# Verifica bolsa de sms
		if ($totalDiaRestaUser>=1) {
			
			if ($totalMesRestaUser>=1) {

				if ($totalDiaRestaCustomer>=1) {
					
					if ($totalMesRestaCustomer>=1) {
						
						# Verifica msisdn a 12 digitos
						if (preg_match("/^[0-9]{2}[0-9]{10}$/",$msisdn)) {
							
							# Verifica longitud de mensaje
							if (strlen($mensaje) <= 160) {
								$text = eliminarAcentos($mensaje);// verifica si encuetra acentos.
								if ($text) { // entra si no vienen acentos
									# Buscar msisd_id si ya esta obtener carrier_id, si no lo insertamos como busca carrier.
									$msisd_id = SmsServiceWSDao::getMsisdnCatalogoMsisdnNew($msisdn);
									//enviarMail('msisdn',print_r($msisd_id,1));
									if (!empty($msisd_id)) {
										$msisdnId = $msisd_id['msisdn_id'];
										$carrier_id = $msisd_id['carrier_id'];
										$sms_campaign_estatus_id_sms = 4;
										foreach ($ccscArray as $key => $value) {
											if ($carrier_id == $value['carrier_id']) {
												$ccsc_id = $value['carrier_connection_short_code_id'];
											}
										}
									} else {
										$msisdnId = SmsServiceWSDao::insertaMsisdn($msisdn, 0);
										$ccsc_id = -1;
										$sms_campaign_estatus_id_sms = 10;
									}
									
									enviarMail('insertSmsCampaign',"$text",'',"$campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje");
									# insertar en sms_campaign
									//$insertarSms = SmsServiceWSDao::insertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje);

									if ($ccsc_id > 0) {
										if ($carrier_id==1) {
											$operador = 'telcel';
										}elseif ($carrier_id==2) {
											$operador = 'movistar';
										}else{
											$operador = 'at&t';
										}
									}else{
										$operador = 'Looking an carrier';
									}

									$messageResponse =<<<html
					<ns2:idMessage>{$insertarSms}</ns2:idMessage>
					<ns2:success>true</ns2:success>
					<ns2:code>1</ns2:code>
					<ns2:description>Queued</ns2:description>
					<ns2:operator>{$operador}</ns2:operator>
html;
								} else {

									$headerResponse =<<<html
					<ns2:headerResponse>
						<ns1:codeError>-9</ns1:codeError>
			            <ns1:messageError>Message text with invalid characters</ns1:messageError>
			        </ns2:headerResponse>
html;


								}
								


							} else {

								$headerResponse =<<<html
					<ns2:headerResponse>
						<ns1:codeError>-8</ns1:codeError>
			            <ns1:messageError>Message with more 160 characters</ns1:messageError>
			        </ns2:headerResponse>
html;

							}

						} else {

							$headerResponse =<<<html
					<ns2:headerResponse>
						<ns1:codeError>-7</ns1:codeError>
			            <ns1:messageError>Enter 12-digit phone</ns1:messageError>
			        </ns2:headerResponse>
html;

						}


					} else {

						$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-6</ns1:codeError>
		            <ns1:messageError>Monthly customer sms exceeded</ns1:messageError>
		        </ns2:headerResponse>
html;

					}

				} else {

					$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-5</ns1:codeError>
		            <ns1:messageError>Daily customer sms exceeded</ns1:messageError>
		        </ns2:headerResponse>
html;

				}

			} else {

				$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-4</ns1:codeError>
		            <ns1:messageError>Monthly user sms exceeded</ns1:messageError>
		        </ns2:headerResponse>
html;

			}
			
		} else {

			$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-3</ns1:codeError>
		            <ns1:messageError>Daily user sms exceeded</ns1:messageError>
		        </ns2:headerResponse>
html;

		}

	} else {

		$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-2</ns1:codeError>
					<ns1:messageError>Fail short code</ns1:messageError>
		        </ns2:headerResponse>
html;

	}
	
} else {

	$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-1</ns1:codeError>
					<ns1:messageError>Authentication failed</ns1:messageError>
		        </ns2:headerResponse>
html;

}


header("Content-Type: application/xml; charset=utf-8");
$response =<<<html
	<SOAP-ENV:Envelope 
	xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
	xmlns:ns1="http://airmovil.com/AirmovilSmsHeader" 
	xmlns:ns2="http://airmovil.com/AirmovilSmsSend">
		<SOAP-ENV:Body>
			<ns2:SendSmsResponse>
				$headerResponse
				$messageResponse
			</ns2:SendSmsResponse>
		</SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;
	
	enviarMail('sendSms Response', $response);
	echo $response;
	exit;
#############################################################################################################	
}


function statusSms($params)
{
	$esau = 'esau.espinoza@airmovil.com';
	$tecnico = 'tecnico@airmovil.com';
	mail("$esau", 'SOAP statusSms', file_get_contents("php://input"). "params: \n" . print_r($params,1).file_get_contents("php://output"));

	//$customer_id 	= $params->headerRequest->proveedorId;
	$user 			= $params->headerRequest->user;
	$pass 			= $params->headerRequest->password;
	$idMessage		= $params->idMessage;

	$userData = new \stdClass();
	$userData->_name = $user;
	$userData->_pass = $pass;

	$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLogin($userData);
	
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
				//mail("$esau","campaignUser",print_r($campaignUser,1).md5($pass));
				# Verificamos si la campania le pertenece al usuario
				if ($campaignUser->password == md5($pass)) {

					// blacklist solo telcel
					if ($carrier == 'telcel') {
						// obtener msisdn de sms_campaign
						$msisdn = ApiSmsSkyWs::getMsisdnSmsCampaign($idMessage);
						mail("$esau","msisdn_log",print_r($msisdn,1));
						$msisdn = substr($msisdn->msisdn_log,-10);

						$bl = file_get_contents("http://smpp.amovil.mx/shortcodeblacklist/consultablacklist.php?from=$msisdn");
						mail("$esau","api blacklist",$bl."-- http://smpp.amovil.mx/shortcodeblacklist/consultablacklist.php?from=$msisdn");
					}

					if ($bl == 1) {
						$Status = 4;
						$Description = 'Blacklist';
					} else {

						$arrayStatus = array('sms_campaign_estatus_id'=>0,'estatus'=>'delivered');
						$arrayStatus1 = ApiSmsSkyWs::getStatusSmsCampaing();
						foreach ($arrayStatus1 as $key => $value) {
							$arrayStatus2[] = (array)$value;
						}
						$arrayStatus2[] = $arrayStatus;
						mail("$esau","arrayStatus1",print_r($arrayStatus2,1));
						foreach ($arrayStatus2 as $key => $value) {
							if ($sms_estatus == $value['estatus']) {
								//mail("$esau","foreach value",print_r($value,1));
								$sms_estatus = $value['estatus'];
								if ($sms_estatus=='preparado para envio'||$sms_estatus=='encolado'||$sms_estatus=='en proceso por ser encolado') {
									$Status = 0;
									$Description = 'Pending';
								}
								elseif ($sms_estatus=='envio white list'||$sms_estatus=='proceso white list'||$sms_estatus=='busca carrier'||$sms_estatus=='buscando carrier') {
									$Status = 1;
									$Description = 'Processing';
								}
								elseif ($sms_estatus=='sin carrier'||$sms_estatus=='error'||$sms_estatus=='error white list'||$sms_estatus=='cancelado'||$sms_estatus=='no telcel') {
									$Status = 2;
									$Description = 'Failed';
								}
								elseif ($sms_estatus=='delivered') {
									$Status = 3;
									$Description = 'Delivered';
								}
								elseif ($sms_estatus=='blacklist') {
									$Status = 4;
									$Description = 'Blacklist';
								}
							}
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
	mail("$tecnico","Response statusSms",print_r($response,1));
	exit;
	
}

 
function changePasswordSms($params)
{
	$esau = 'esau.espinoza@airmovil.com';
	mail("$esau", 'SOAP changePasswordSms', file_get_contents("php://input"). "params: \n" . print_r($params,1).file_get_contents("php://output"));
	$customer_id 	= $params->headerRequest->proveedorId;
	$user 			= $params->headerRequest->user;
	$pass 			= $params->headerRequest->password;
	$newPassword	= $params->newPassword;

	$userData = new \stdClass();
	$userData->_name = trim($user);
	$userData->_pass = trim($pass);

	$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLogin($userData);
	
	if (!empty($login)) {
		$user_id = $login->user_id;
		mail("$esau"," changePasswordSms","user_id:".$user_id." newPassword:".$newPassword);
		$headerResponse = '';
		$messageResponse = '';
		if (strlen($newPassword)>=8) {

			if (preg_match("/(?=^[^\s]{8,128}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/",$newPassword)) {

				$updatePass = ApiSmsSkyWs::getUpdatePass($user_id,$newPassword);

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
	mail("$tecnico","Response changePasswordSms",print_r($response,1));
	exit;
}


function balanceSms($params)
{
	## Inicio captura de header SOAP

	## Fin Validadcion header security SOAP
	$esau = "esau.espinoza@airmovil.com";
	$tecnico = "tecnico@airmovil.com";
	mail("$tecnico","balanceSms","params: \n". print_r($params,1)."\n soap \n".file_get_contents("php://input"));
	$customer_id 	= '';/*$params->headerRequest->proveedorId;*/
	$user 			= $params->headerRequest->user;
	$pass 			= $params->headerRequest->password;

	$userData = new \stdClass();
	$userData->_name = trim($user);
	$userData->_pass = trim($pass);

	$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLogin($userData);
	//mail("$esau","login balanceSms", print_r($login,1)."user:".trim($user)."_ & pass:".trim($pass)."_");
	enviarMail('login balanceSms', $login);
	if (!empty($login)) {
		
		if ($customer_id =='') {
			$customer_id = $login->customer_id;
		}
		# Verificamos bolsa de envio
		//$getTotalesCustomerMes = ApiSmsSkyWs::getTotalesCustomerMes($customer_id);
		$bolsaSms = ApiSmsSkyWs::getBolsasms($customer_id);
		#$getTotalesCustomerDia = ApiSmsSkyWs::getTotalesCustomerDia($customer_id);
		//$getTotalesuserMes = ApiSmsSkyWs::getTotalesUserMes($login->user_id);
		#$getTotalesuserDia = ApiSmsSkyWs::getTotalesUserDia($login->user_id);
		//mail("$esau","totales",print_r($bolsaSms,1));
		enviarMail('totales Mts',$bolsaSms);
		$netBalance = $bolsaSms->bolsa_sms;
		$balance = $bolsaSms->resta_bolsa_sms;
		$usedBalance = $bolsaSms->total_mts_customer;
		#$totalDiaCustomer = number_format($getTotalesCustomerDia->max_mt_day);
		#$totalDiaRestaCustomer = number_format($getTotalesCustomerDia->resta_dia);
		#$totalDiaUser = number_format($getTotalesuserDia->max_mt_day);
		#$totalDiaRestaUser = number_format($getTotalesuserDia->resta_dia);
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
	enviarMail('Response balanceSms', $response);
	exit;
}

function exchangeSms($params)
{
	$esau = 'esau.espinoza@airmovil.com';
	mail("$esau","exchangeSms", file_get_contents("php://input"). "params: \n" . print_r($params,1));

	$customer_id 	= '';//$params->headerRequest->proveedorId;
	$user 			= $params->headerRequest->user;
	$pass 			= $params->headerRequest->password;

	$userData = new \stdClass();
	$userData->_name = $user;
	$userData->_pass = $pass;

	$headerResponse = '';
	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLogin($userData);
	if (!empty($login)) {
		mail("$esau","login exchangeSms",print_r($login,1));
		$user_id = $login->user_id;
		$customer_id = ($login->customer_id=='') ? $login->customer_id : $login->customer_id;
		$bolsa = ApiSmsSkyWs::getBolsa($customer_id);
		mail("$esau","bolsa exchangeSms", print_r($bolsa,1));
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
	mail("$tecnico","Response exchangeSms",print_r($response,1));
	exit;
}


function incomingSms($params)
{
	$esau = 'esau.espinoza@airmovil.com';
	mail("$esau", "incomingSms", file_get_contents("php://input"). "params: \n" . print_r($params,1));

	$customer_id 	= '';//$params->headerRequest->proveedorId;
	$user 			= $params->headerRequest->user;
	$pass 			= $params->headerRequest->password;
	$idMessage		= $params->idMessage;
	$fechaI			= $params->from;
	$fechaF			= $params->to;

	$userData = new \stdClass();
	$userData->_name = $user;
	$userData->_pass = $pass;

	$headerResponse = '';
	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLogin($userData);
	if (!empty($login)) {
		//mail("$esau","login incomingSms",print_r($login,1));
		$user_id = $login->user_id;
		$customer_id = ($customer_id=='') ? $login->customer_id : $login->customer_id;
		##
		if (!empty($idMessage) && empty($fechaI) && empty($fechaF)) {
			$mos = ApiSmsSkyWs::getIncomming($idMessage);
			if (!empty($mos)) {
				//mail("$esau","mos id sin fecha",print_r($mos,1));
				$campaign_id = $mos[0]->campaign_id;
				$campaignUser = ApiSmsSkyWs::getCampaignId($campaign_id);
				mail("$esau","campanias","respuesta de idMessage".print_r($campaignUser,1)."login user_id:".$user_id);
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
			//mail("$esau","ids campaignCustomer", trim($ids,","));
			$mosDate = ApiSmsSkyWs::getIncommingDate(trim($ids,","),fechaInicial($fechaI), fechaFinal($fechaF));
			if (!empty($mosDate)) {
				mail("$esau","mos de solo fechas",print_r($mosDate,1));
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
				mail("$esau","mos full data request",print_r($mos,1));
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
	mail("$tecnico","Response incomingSms",print_r($response,1));
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

function enviarMail($accion='',$request,$response,$extraData){
	$destinatario = "tecnico@airmovil.com"; 
	$asunto = "$accion"; 
	if (!empty($response)) {
		$response = print_r($response,1);
	} else {
		$response = '';
	}

	if (!empty($extraData)) {
		$extraData = print_r($extraData,1);
	} else {
		$extraData = '';
	}

	if (!empty($request)) {
		$request = print_r($request,1);
	} else {
		$request = '';
	}

	$cuerpo = '	request:	

				'.$request.'

				response:

				'.$response.' 
				
				extraData:

				'.$extraData;

	//para el envío en formato HTML 
	//$headers = "MIME-Version: 1.0\r\n"; 
	//$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	//dirección del remitente 
	$headers = "From: Esau Espinoza Villarreal <esau.espinoza@airmovil.com>\r\n";
	//dirección de respuesta, si queremos que sea distinta que la del remitente 
	$headers .= "Reply-To: tecnico@airmovil.com\r\n"; 
	//ruta del mensaje desde origen a destino 
	$headers .= "Return-path: tecnico@airmovil.com\r\n"; 
	//direcciones que recibián copia 
	//$headers .= "Cc: juan.medina@airmovil.com\r\n";
	//direcciones que recibirán copia oculta 
	//$headers .= "Bcc: jaime.ramirez@airmovil.com\r\n"; 

	mail($destinatario,$asunto,$cuerpo,$headers);
	
}

function dateTimeOk($created) {

	date_default_timezone_set('UTC');

	$fechaSistema = date('Y-m-d')."T".date('H:i:s')."Z";

	$fechaUno = strtotime($fechaSistema);
	$fechaDos = strtotime($created);

	$dif = $fechaUno - $fechaDos;
	if ($dif <= 121) {
		return true;
	}
	else {
		return false;
	}

}

function eliminarAcentos($text){
 
    $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);

        enviarMail('eliminarAcentos html', $text);

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
 
            // Agregar aqui mas caracteres si es necesario
 
        );
 
        $texto = preg_replace(array_keys($patron),array_values($patron),$text);
        enviarMail('eliminarAcentos', $texto);
        if ($texto != $text) {
        	return false;
        } else {
        	return true;
        }
        //return $text;

}
 
$server->AddFunction("changePasswordSms");
$server->addFunction("sendSms");
$server->addFunction("statusSms");
$server->addFunction("incomingSms");
$server->addFunction("balanceSms");
$server->addFunction("exchangeSms");
$server->handle();

//print_r($server);

//print_r($server->getFunctions());