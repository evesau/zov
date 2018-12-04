<?php
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
// Notificar todos los errores de PHP
error_reporting(-1);

include 'model/ApiSmsSkyWs.php'; // Regresa Objetos

if(!extension_loaded("soap")){
      dl("php_soap.dll");
}
 
ini_set("soap.wsdl_cache_enabled","0");
$server = new SoapServer("https://smsmkt.amovil.mx/wsdl/skysms/SmsSkyWSMulti.wsdl");


$server->AddFunction("changePasswordSms");
$server->addFunction("sendSms");
$server->addFunction("statusSms");
$server->addFunction("incomingSms");
$server->addFunction("balanceSms");
$server->addFunction("exchangeSms");
$server->addFunction("Security");
$server->handle();

$security = Security($server->Security);

mail("tecnico@airmovil.com","security1",print_r($security,1));

function sendSms($params) // Funcionando OK
{
	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico", 'SOAP sendSms ws-multi', $input. "\nparams: \n" . print_r($params,1) ."--". print_r($_SERVER,1));
	
	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);
	/*
	$PasswordDigest = '';
	preg_match("/PasswordDigest\">(.*)<\/wsse:Password>/",$input, $PassS);
	if ($PassS[1] == '') {
		preg_match("/PasswordText\">(.*)<\/wsse:Password>/",$input, $PassS1);
		if ($PassS1[1] != '') {
			$PasswordDigest = $PassS1[1];
		}
	} else
		$PasswordDigest = $PassS[1];

	$nonce = '';
	preg_match("/<wsse:Nonce>(.*)<\/wsse:Nonce>/",$input, $Noncee);
	if($Noncee[1] == ''){
		preg_match("/Base64Binary\">(.*)<\/wsse:Nonce>/",$input, $Nonceee);
		if($Nonceee[1] != '')
			$nonce = $Nonceee[1];
	}else
		$nonce = $Noncee[1];

	preg_match("/<wsu:Created>(.*)<\\/wsu:Created>/",$input, $Createdd);*/

	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));

	$Username 			= trim($userr[1]);/*
	$PasswordDigest 	= trim($PasswordDigest);
	$nonce 				= trim($nonce);
	$created 			= trim($Createdd[1]);

	$dataFecha = dateTimeOk($created);
	*/

	$passwordBD = (array) ApiSmsSkyWs::getUser($Username);
	//mail("$tecnico", "getUser ws-multi", print_r($passwordBD,1));
	$password = $passwordBD['password'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];

	#### almacena objeto para login
	$datosLoginBD = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);
	mail("$tecnico", 'datos para login usuario', print_r($datosLoginBD,1));
	$userData = new \stdClass();
	$userData->_name = $datosLoginBD['nickname']; //$Username;
	$userData->_pass = $datosLoginBD['password']; //$password;
	//mail('$tecnico','userData',print_r($userData,1));
	#####################
	/*
	$password = $nonce.$created.utf8_encode($password);
	$password = base64_encode(sha1($password,true));

	$inicio = false;

	$fechaConsulta = date('Y-m-d h:i:s');
	$expired = (array) ApiSmsSkyWs::getExpiredDate($Username, $fechaConsulta);
	//mail("$tecnico", "expired", print_r($expired,1));

	$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);
	//mail("$tecnico", "timeLoked", print_r($timeLoked,1));
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
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		$continiaProceso = false;
	}

	if ($password == $PasswordDigest && !empty($expired) && $continiaProceso && $dataFecha ) {
		
		$inicio = true;	
		//mail("$tecnico", "ws security sendSms", "Password y PasswordDigest son correctos..."."\nUsername: $Username, PasswordDigest: $PasswordDigest, password: $password, nonce: $nonce, created: $created");
		# updetear intento a 0 y desbloquear
		$loked = 0;
		$intentos = 0;
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
	} else {
		# Conteo de intentos
		$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);

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
				$insertIntento = ApiSmsSkyWs::insertIntento($user, $user_ws_id, $intentos, $loked);
			} else {
				$loked = 0;
				$insertIntento = ApiSmsSkyWs::insertIntento($user, $user_ws_id, $intentos, $loked);
			}

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
	mail("$tecnico", "Response error sendSms multi", print_r($response,1));
	exit;

	}*/


	$customer_id 	= '';
	$msisdn 		= $params->message->phoneNumber;
	$mensaje 		= $params->message->message;
	
	$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

	$login = ApiSmsSkyWs::getByIdLoginWs($userData); // pass in MD5
	//mail("$tecnico", 'login sendSms multi', print_r($login,1));
	
	if (!empty($login)) {

		$messageResponse="";

		$customer_id = ApiSmsSkyWs::getCustomer($login->user_id);
		$customer_id = $customer_id->customer_id;

		if ($customer_id == 1) {
			$campaign_id = 215; // campaign_id de customer airmovil.
		} else {
			$campaign_id = 256; // campaign_id solo para sky 76551
		}

		if (!empty($campaign_id)) {
			# Verificamos bolsa de envio
			$getTotalesCustomerMes = ApiSmsSkyWs::getTotalesCustomerMes($customer_id);
			$getTotalesCustomerDia = ApiSmsSkyWs::getTotalesCustomerDia($customer_id);
			$getTotalesuserMes = ApiSmsSkyWs::getTotalesUserMes($login->user_id);
			$getTotalesuserDia = ApiSmsSkyWs::getTotalesUserDia($login->user_id);
			//mail("$tecnico","totales",print_r($getTotalesCustomerMes,1).print_r($getTotalesCustomerDia,1).print_r($getTotalesuserMes,1).print_r($getTotalesuserDia,1));
			$totalMesCustomer = number_format($getTotalesCustomerMes->max_mt_month);
			$totalMesRestaCustomer = number_format($getTotalesCustomerMes->resta_mes);
			$totalDiaCustomer = number_format($getTotalesCustomerDia->max_mt_day);
			$totalDiaRestaCustomer = number_format($getTotalesCustomerDia->resta_dia);

			$totalMesUser = number_format($getTotalesuserMes->max_mt_month);
			$totalMesRestaUser = number_format($getTotalesuserMes->resta_mes);
			$totalDiaUser = number_format($getTotalesuserDia->max_mt_day);
			$totalDiaRestaUser = number_format($getTotalesuserDia->resta_dia);

			if ($totalDiaRestaUser>=1) {

				if ($totalMesRestaUser>=1) {

					if ($totalDiaRestaCustomer>=1) {

						if ($totalMesRestaCustomer>=1) {

							if (preg_match("/^[0-9]{2}[0-9]{10}$/",$msisdn)) {	

								if (strlen($mensaje) <=160) {
									# Buscamos en blacklist
									$msisdnBlack = ApiSmsSkyWs::getMsisdnInBlackList(substr($msisdn, -12),$customer_id);
									$batt = $msisdnBlack->att;
									$bmov = $msisdnBlack->movistar;
									$btel = $msisdnBlack->telcel;
									$blOk = false;
									if ($batt == $msisdn || $bmov == $msisdn || $btel == $msisdn) {
										$blOk = false;
									} else {
										$blOk = true;
									}

									if ($blOk) {
										$acentos = eliminarAcentos($mensaje);

										if ($acentos) {
											# Buscamos msisdn
											$buscaMsisdn = ApiSmsSkyWs::getMsisdnCatalogoMsisdnNew(substr($msisdn,-12));
											mail("$tecnico",'msisdn & carrier',print_r($buscaMsisdn,1));
											# si encontramos msisdn y carrier
											if (!empty($buscaMsisdn)) {
										
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
												# Encolamos el sms
												$ccsc_id = 22;
												$sms_campaign_estatus_id_sms = 4;

												$insertarSms = ApiSmsSkyWs::insertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje);
												if ($insertarSms == 0 || empty($insertarSms)) {
													$buscaID = ApiSmsSkyWs::getInsertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $mensaje);

													$insertarSms = $buscaID['sms_campaign_id'];

													mail("$tecnico","no devolvio sms_campaign_id multi","buscamos($campaign_id, $msisdnId, $ccsc_id, $mensaje) - id insertado:$insertarSms");
												}
												mail("$tecnico","insertSmsCampaign multi","$insertarSms: params:($campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje)");
												if((int) $insertarSms > 0) {
													$idMessage = (string) $insertarSms;
													$operador = (string) $carrier;
													$headerResponse='';
													$messageResponse="
													<ns2:idMessage>$idMessage</ns2:idMessage>
													<ns2:success>true</ns2:success>
													<ns2:code>1</ns2:code>
													<ns2:description>Queued</ns2:description>
													<ns2:operator>$operador</ns2:operator>";					
												} else { # Fallo al insertar en sms_campaign
														$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-11</ns1:codeError>
		            <ns1:messageError>Fail insert sms</ns1:messageError>
		        </ns2:headerResponse>
html;
													}

											} else { # Insertamos el nuevo msisdn a bd para buscar carrier

												$msisdnId = ApiSmsSkyWs::insertIgnoreMsisdn(substr($msisdn, -12), 12);
												$ccsc_id = 22;
												$sms_campaign_estatus_id_sms = 4;
												$carrier = 'Looking an carrier';

												if ((int) $msisdnId>0) {
												# Encolamos sms
													$insertarSms = ApiSmsSkyWs::insertSmsCampaign($campaign_id, $msisdnId,$ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje);// se cambia busca carrier
													if ($insertarSms == 0 || empty($insertarSms)) {
														$buscaID = ApiSmsSkyWs::getInsertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $mensaje);

														$insertarSms = $buscaID['sms_campaign_id'];

														mail("$tecnico","no devolvio sms_campaign_id new msisdn multi","buscamos($campaign_id, $msisdnId, $ccsc_id, $mensaje) - id insertado:$insertarSms");
													}
													mail("$tecnico","insertSmsCampaign msisdn new multi","$insertarSms: msisdn:$msisdn params:($campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje)");
													if ((int) $insertarSms > 0) {
														$idMessage = (string) $insertarSms;
														$operador = (string) $carrier;
														$headerResponse='';
														$messageResponse="
														<ns2:idMessage>$idMessage</ns2:idMessage>
														<ns2:success>true</ns2:success>
														<ns2:code>1</ns2:code>
														<ns2:description>Queued</ns2:description>
														<ns2:operator>$operador</ns2:operator>";
												
													} else { # Fallo al insertar en sms_campaign
														$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-10</ns1:codeError>
		            <ns1:messageError>Fail looking an carrier</ns1:messageError>
		        </ns2:headerResponse>
html;
													}

												} else { # Fallo al insertar msisdn

													$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-9</ns1:codeError>
		            <ns1:messageError>Fail insert msisdn</ns1:messageError>
		        </ns2:headerResponse>
html;
												}

											} # Fin else buscar carrier e insert msisdn

										} else { #acentos

											$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-13</ns1:codeError>
		            <ns1:messageError>Invalid characters</ns1:messageError>
		        </ns2:headerResponse>
html;

										}

									} else { # Fin de Blacklist

										$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-12</ns1:codeError>
		            <ns1:messageError>Msisdn in Blacklist</ns1:messageError>
		        </ns2:headerResponse>
html;

									}								

								} # Fin de longitud de mensaje
								else {
									$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-8</ns1:codeError>
		            <ns1:messageError>Message with more 160 characters</ns1:messageError>
		        </ns2:headerResponse>
html;
								}

							} # Fin de verififcar msisdn 12 digitos
							else {
								$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-7</ns1:codeError>
		            <ns1:messageError>Enter 12-digit phone</ns1:messageError>
		        </ns2:headerResponse>
html;
							}

						} # Fin de conteo de bolsa mes customer
						else {
							$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-6</ns1:codeError>
	            <ns1:messageError>Monthly customer sms exceeded</ns1:messageError>
	        </ns2:headerResponse>
html;
						}
					} # fin de conteo de bolsa diario customer
					else {
						$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-5</ns1:codeError>
	            <ns1:messageError>Daily customer sms exceeded</ns1:messageError>
	        </ns2:headerResponse>
html;
					}
				} # fin de conteo de bolsa mes usuario
				else {
					$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-4</ns1:codeError>
	            <ns1:messageError>Monthly user sms exceeded</ns1:messageError>
	        </ns2:headerResponse>
html;
				}
			} # fin de conteo de bolsa diario usuario
			else {
				//mail("$esau","mts diario usuario", "totalDiaRestaUser:$totalDiaRestaUser no se envio mt");
				$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-3</ns1:codeError>
	            <ns1:messageError>Daily user sms exceeded</ns1:messageError>
	        </ns2:headerResponse>
html;
			}
			
			
		} # Fin de campania existe
		else{ # encaso de campania no existe
			$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-2</ns1:codeError>
		            <ns1:messageError>Campaign not assigned at WebService</ns1:messageError>
		        </ns2:headerResponse>
html;
		}

	} # Fin de login
	else{ # Encaso de que login failed
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
	mail("$tecnico","Response sendSms multi",print_r($response,1));
	exit;
}


function statusSms($params) // Funcionando OK
{
	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico", 'SOAP statusSms multi', $input. "\nparams: \n" . print_r($params,1). "\n" .print_r($_SERVER,1) );

	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);
	/*	
	$PasswordDigest = '';
	preg_match("/PasswordDigest\">(.*)<\/wsse:Password>/",$input, $PassS);
	if ($PassS[1] == '') {
		preg_match("/PasswordText\">(.*)<\/wsse:Password>/",$input, $PassS1);
		if ($PassS1[1] != '') {
			$PasswordDigest = $PassS1[1];
		}
	} else
		$PasswordDigest = $PassS[1];

	$nonce = '';
	preg_match("/<wsse:Nonce>(.*)<\/wsse:Nonce>/",$input, $Noncee);
	if($Noncee[1] == ''){
		preg_match("/Base64Binary\">(.*)<\/wsse:Nonce>/",$input, $Nonceee);
		if($Nonceee[1] != '')
			$nonce = $Nonceee[1];
	}else
		$nonce = $Noncee[1];

	preg_match("/<wsu:Created>(.*)<\\/wsu:Created>/",$input, $Createdd);
	*/

	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));

	$Username 			= trim($userr[1]);
	/*
	$PasswordDigest 	= trim($PasswordDigest);
	$nonce 				= trim($nonce);
	$created 			= trim($Createdd[1]);

	$dataFecha = dateTimeOk($created);
	*/

	$passwordBD = (array) ApiSmsSkyWs::getUser($Username);
	//mail("$tecnico", "getUser", print_r($passwordBD,1));
	$password = $passwordBD['password'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];

	#### almacena objeto para login
	$datosLoginBD = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);
	//mail("$tecnico", 'datos para login usuario', print_r($datosLoginBD,1));
	$userData = new \stdClass();
	$userData->_name = $datosLoginBD['nickname']; //$Username;
	$userData->_pass = $datosLoginBD['password']; //$password;
	//mail('$tecnico','userData',print_r($userData,1));
	#####################
	/*
	$password = $nonce.$created.utf8_encode($password);
	$password = base64_encode(sha1($password,true));

	$inicio = false;

	$fechaConsulta = date('Y-m-d h:i:s');
	$expired = (array) ApiSmsSkyWs::getExpiredDate($Username, $fechaConsulta);
	//mail("$tecnico", "expired", print_r($expired,1));

	$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);
	//mail("$tecnico", "timeLoked", print_r($timeLoked,1));
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
	} elseif ($limiteIntento == 5 && $tiempoBloqueo >= 3) {
		$continiaProceso = true;

		# updetear intento a 0 y desbloquear
		$loked = 0;
		$intentos = 0;
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		$continiaProceso = false;
	}

	if ($password == $PasswordDigest && !empty($expired) && $continiaProceso && $dataFecha ) {
		
		$inicio = true;		
		//mail("$tecnico", "ws security statusSms", "Password y PasswordDigest son correctos..."."\nUsername: $Username, PasswordDigest: $PasswordDigest, password: $password, nonce: $nonce, created: $created");
		# updetear intento a 0 y desbloquear
		$loked = 0;
		$intentos = 0;
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		# Conteo de intentos
		$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);

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
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
			} else {
				$loked = 0;
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
			}

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
	      	<ns2:StatusSmsResponse>
	        	$headerResponse    	
	    	</ns2:StatusSmsResponse>
	   </SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;
	
	mail("$tecnico","Response error statusSms multi",print_r($response,1));
	echo $response;
	exit;

	}
	*/


	$idMessage		= $params->idMessage;


	$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLoginWs($userData);
	//mail("$tecnico", 'login statusSms multi', print_r($login,1));
	
	if (!empty($login)) {

		$user_id = $login->user_id;
		$statusSms = ApiSmsSkyWs::getStatusSms($idMessage);
		//mail("$tecnico","statusSms multi",print_r($statusSms,1));
		$headerResponse = '';

		$messageResponse = '';

		
		if (!empty($statusSms)) { # sms encontrado
			$sms_estatusBD = (string) $statusSms->sms_estatus;
			$carrier = (string) $statusSms->carrier;
			$campaign_id = $statusSms->campaign_id;
			# buscamos que el sms encontrado pertenecas a una campaña del usuario
			$campaignUser = ApiSmsSkyWs::getCampaignId($campaign_id);
			//mail("$tecnico", 'campaignUser statusSms multi', print_r($campaignUser,1));

			$user_id_campaign = $campaignUser->user_id;

			if (!empty($campaignUser)) {

				if ($user_id == $user_id_campaign) {
					// blacklist solo telcel
					if ($carrier == 'telcel') {
						// obtener msisdn de sms_campaign
						$msisdn = ApiSmsSkyWs::getMsisdnSmsCampaign($idMessage);
						//mail("$tecnico","msisdn_log",print_r($msisdn,1));
						$msisdn = substr($msisdn->msisdn_log,-10);

						$bl = file_get_contents("http://smpp.amovil.mx/shortcodeblacklist/consultablacklist.php?from=$msisdn");
						mail("$tecnico","api blacklist multi",$bl."-- http://smpp.amovil.mx/shortcodeblacklist/consultablacklist.php?from=$msisdn");
					}

					if ($bl == 1) {
						$Status = 4;
						$Description = 'Blacklist';
					} else {

						$arrayStatus = array('sms_campaign_estatus_id'=>0,'estatus'=>"$sms_estatusBD");
						$arrayStatus1 = ApiSmsSkyWs::getStatusSmsCampaing();
						foreach ($arrayStatus1 as $key => $value) {
							$arrayStatus2[] = (array)$value;
						}
						$arrayStatus2[] = $arrayStatus;
						//mail("$tecnico","arrayStatus1",print_r($arrayStatus2,1));
						foreach ($arrayStatus2 as $key => $value) {
							if ($sms_estatusBD == $value['estatus']) {
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
								elseif ($sms_estatus=='sin carrier'||$sms_estatus=='error'||$sms_estatus=='error white list'||$sms_estatus=='cancelado'||$sms_estatus=='no telcel'|| $sms_estatus=='REJECTD') {
									$Status = 2;
									$Description = 'Failed';
								}
								elseif ($sms_estatus=='delivered' || $sms_estatus=='ACCEPTD') {
									$Status = 3;
									$Description = 'Delivered';
								}
								elseif ($sms_estatus=='blacklist') {
									$Status = 4;
									$Description = 'Blacklist';
								}elseif ($sms_estatus=='ACCEPTD') {
									$Status = 5;
									$Description = 'ACCEPTD';
								}elseif ($sms_estatus=='REJECTD') {
									$Status = 6;
									$Description = 'REJECTD';
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

				} else { # el usuario que consulta no le pertenece la campaña
					$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
	            <ns1:messageError>Message not found</ns1:messageError>
	        </ns2:headerResponse>
html;

				}					
				
			} else { # no se encontro campaña
				$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
	            <ns1:messageError>Message not found</ns1:messageError>
	        </ns2:headerResponse>
html;
			}

		} else { # no se encontro sms
			$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
	            <ns1:messageError>Message not found</ns1:messageError>
	        </ns2:headerResponse>
html;
		}

	} else { # En caso de login failed
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
	mail("$tecnico","Response statusSms multi",print_r($response,1));
	exit;
	
}

 
function changePasswordSms($params) // Funcionando OK
{
	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico", 'SOAP ChangePasswordSms multi', $input. "\nparams: \n" . print_r($params,1)."\n".print_r($_SERVER,1) );

	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);

	/*	
	$PasswordDigest = '';
	preg_match("/PasswordDigest\">(.*)<\/wsse:Password>/",$input, $PassS);
	if ($PassS[1] == '') {
		preg_match("/PasswordText\">(.*)<\/wsse:Password>/",$input, $PassS1);
		if ($PassS1[1] != '') {
			$PasswordDigest = $PassS1[1];
		}
	} else
		$PasswordDigest = $PassS[1];

	$nonce = '';
	preg_match("/<wsse:Nonce>(.*)<\/wsse:Nonce>/",$input, $Noncee);
	if($Noncee[1] == ''){
		preg_match("/Base64Binary\">(.*)<\/wsse:Nonce>/",$input, $Nonceee);
		if($Nonceee[1] != '')
			$nonce = $Nonceee[1];
	}else
		$nonce = $Noncee[1];

	preg_match("/<wsu:Created>(.*)<\\/wsu:Created>/",$input, $Createdd);
	*/

	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));

	$Username 			= trim($userr[1]);
	/*
	$PasswordDigest 	= trim($PasswordDigest);
	$nonce 				= trim($nonce);
	$created 			= trim($Createdd[1]);

	## Fin matcher header security

	$dataFecha = dateTimeOk($created);
	*/

	$passwordBD = (array) ApiSmsSkyWs::getUser($Username);
	//mail("$tecnico", "getUser ws-multi", print_r($passwordBD,1));
	$password = $passwordBD['password'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];

	#### almacena objeto para login
	$datosLoginBD = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);
	//mail("$tecnico", 'datos para login usuario', print_r($datosLoginBD,1));
	$userData = new \stdClass();
	$userData->_name = $datosLoginBD['nickname']; //$Username;
	$userData->_pass = $datosLoginBD['password']; //$password;
	//mail('$tecnico','userData',print_r($userData,1));
	#####################

	/*
	$password = $nonce.$created.utf8_encode($password);
	$password = base64_encode(sha1($password,true));

	$inicio = false;

	$fechaConsulta = date('Y-m-d h:i:s');
	$expired = (array) ApiSmsSkyWs::getExpiredDate($Username, $fechaConsulta);
	//mail("$tecnico", "expired", print_r($expired,1));

	$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);
	//mail("$tecnico", "timeLoked", print_r($timeLoked,1));
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
	} elseif ($limiteIntento == 5 && $tiempoBloqueo >= 3) {
		$continiaProceso = true;

		# updetear intento a 0 y desbloquear
		$loked = 0;
		$intentos = 0;
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		$continiaProceso = false;
	}

	if ($password == $PasswordDigest && !empty($expired) && $continiaProceso && $dataFecha ) {
		
		$inicio = true;
		//mail("$tecnico", "ws security ChangePasswordSms", "Password y PasswordDigest son correctos..."."\nUsername: $Username, PasswordDigest: $PasswordDigest, password: $password, nonce: $nonce, created: $created");
		# updetear intento a 0 y desbloquear
		$loked = 0;
		$intentos = 0;
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		# Conteo de intentos
		//$conteo = (array) ApiSmsSkyWs::getIntento($user,$user_ws_id);

		$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);

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
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
			} else {
				$loked = 0;
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
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
	xmlns:ns2="http://www.sky.com/SkySmsChangePassword">
		<SOAP-ENV:Body>	   	
	      	<ns2:ChangePasswordSmsResponse>
	        	$headerResponse    	
	    	</ns2:ChangePasswordSmsResponse>
	   </SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;
	
	mail("$tecnico","Response error ChangePasswordSms",print_r($response,1));
	echo $response;
	exit;

	}
	*/

	#############
	
	$newPassword	= $params->newPassword;

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
		mail("$tecnico"," datos changePasswordSms multi","user_ws_id:".$user_ws_id." newPassword:".$newPassword);
		$headerResponse = '';
		$messageResponse = '';
		if (strlen($newPassword)>=8) {

			if (strlen($newPassword)<=32) {

				if (preg_match("/(?=^[^\s]{8,32}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/",$newPassword)) {

					$updatePass = ApiSmsSkyWs::getUpdatePass($user_ws_id,$newPassword);

					if ($updatePass!==FALSE) {

						$messageResponse = '
			<ns2:code>1</ns2:code>
			<ns2:description>Password updated successful</ns2:description>
		';

					} else {

						$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-4</ns1:codeError>
	            <ns1:messageError>Password update failed</ns1:messageError>
	        </ns2:headerResponse>
html;

					}
				
				} else {
					$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-3</ns1:codeError>
	            <ns1:messageError>Enter a Number or a letter Uppercase</ns1:messageError>
	        </ns2:headerResponse>
html;
				}

			} else {

				$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-5</ns1:codeError>
	            <ns1:messageError>Maximum entry 32 characters</ns1:messageError>
	        </ns2:headerResponse>
html;

			}

			
		} else {
			$headerResponse =<<<html
			<ns2:headerResponse>
				<ns1:codeError>-2</ns1:codeError>
	            <ns1:messageError>Minimum entry 8 characters</ns1:messageError>
	        </ns2:headerResponse>
html;
		}
	} else { # En caso de login failed

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
	mail("$tecnico","Response changePasswordSms multi",print_r($response,1));
	exit;
}


function balanceSms($params) // Funcionando OK
{
	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico", 'SOAP balanceSms ws-multi', $input. "\nparams: \n" . print_r($params,1) ."--\n". print_r($_SERVER,1));
	
	## Obtención de parametrtos de login header security
	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);
	/*
	$PasswordDigest = '';
	preg_match("/PasswordDigest\">(.*)<\/wsse:Password>/",$input, $PassS);
	if ($PassS[1] == '') {
		preg_match("/PasswordText\">(.*)<\/wsse:Password>/",$input, $PassS1);
		if ($PassS1[1] != '') {
			$PasswordDigest = $PassS1[1];
		}
	} else
		$PasswordDigest = $PassS[1];

	$nonce = '';
	preg_match("/<wsse:Nonce>(.*)<\/wsse:Nonce>/",$input, $Noncee);
	if($Noncee[1] == ''){
		preg_match("/Base64Binary\">(.*)<\/wsse:Nonce>/",$input, $Nonceee);
		if($Nonceee[1] != '')
			$nonce = $Nonceee[1];
	}else
		$nonce = $Noncee[1];

	preg_match("/<wsu:Created>(.*)<\\/wsu:Created>/",$input, $Createdd);*/

	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));
	
	$Username 			= trim($userr[1]);
	/*$PasswordDigest 	= trim($PasswordDigest);
	$nonce 				= trim($nonce);
	$created 			= trim($Createdd[1]);
	*/
	## Fin matcher header security

	//$dataFecha = dateTimeOk($created);

	$passwordBD = (array) ApiSmsSkyWs::getUser($Username);
	//mail("$tecnico", "getUser ws-multi", print_r($passwordBD,1));
	$password = $passwordBD['password'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];

	#### almacena objeto para login
	$datosLoginBD = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);
	//mail("$tecnico", 'datos para login usuario', print_r($datosLoginBD,1));
	$userData = new \stdClass();
	$userData->_name = $datosLoginBD['nickname']; //$Username;
	$userData->_pass = $datosLoginBD['password']; //$password;
	//mail('$tecnico','userData',print_r($userData,1));
	#####################
	/*
	$password = $nonce.$created.utf8_encode($password);
	$password = base64_encode(sha1($password,true));

	$inicio = false;

	$fechaConsulta = date('Y-m-d h:i:s');
	$expired = (array) ApiSmsSkyWs::getExpiredDate($Username, $fechaConsulta);
	//mail("$tecnico", "expired", print_r($expired,1));

	$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);
	//mail("$tecnico", "timeLoked", print_r($timeLoked,1));
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
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		$continiaProceso = false;
	}

	if ($password == $PasswordDigest && !empty($expired) && $continiaProceso && $dataFecha ) {
		
		$inicio = true;
		//mail("$tecnico", "ws security balanceSms", "Password y PasswordDigest son correctos..."."\nUsername: $Username, PasswordDigest: $PasswordDigest, password: $password, nonce: $nonce, created: $created");
		# updetear intento a 0 y desbloquear
		$loked = 0;
		$intentos = 0;
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		# Conteo de intentos
		//$conteo = (array) ApiSmsSkyWs::getIntento($user,$user_ws_id);

		$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);

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
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
			} else {
				$loked = 0;
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
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
	xmlns:ns2="http://www.sky.com/SkySmsBalance">
		<SOAP-ENV:Body>	   	
	      	<ns2:BalanceSmsResponse>
	        	$headerResponse    	
	    	</ns2:BalanceSmsResponse>
	   </SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;

	mail("$tecnico", "Response error balanceSms", print_r($response,1));
	
	echo $response;
	exit;

	}*/

	$customer_id ='';

	$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

	$messageResponse = '';

	//$login = ApiSmsSkyWs::getByIdLogin($userData);
	$login = ApiSmsSkyWs::getByIdLoginWs($userData); //
	//mail("$tecnico","login balanceSms", print_r($login,1));
	if (!empty($login)) {
		
		if ($customer_id =='') {
			$customer_id = $login->customer_id;
		}
		# Verificamos bolsa de envio
		$getTotalesCustomerMes = ApiSmsSkyWs::getTotalesCustomerMes($customer_id);
		//mail("$tecnico", 'total customer mes', print_r($getTotalesCustomerMes,1));
		#$bolsaSms = ApiSmsSkyWs::getBolsasms($customer_id);
		#$getTotalesCustomerDia = ApiSmsSkyWs::getTotalesCustomerDia($customer_id);
		#$getTotalesuserMes = ApiSmsSkyWs::getTotalesUserMes($login->user_id);
		#$getTotalesuserDia = ApiSmsSkyWs::getTotalesUserDia($login->user_id);
		#mail("$tecnico","totales",print_r($bolsaSms,1));
		#$netBalance = $bolsaSms->bolsa_sms;
		#$balance = ($bolsaSms->resta_bolsa_sms == '') ? $netBalance : $bolsaSms->resta_bolsa_sms;
		#$usedBalance = ($bolsaSms->total_mts_customer == '') ? 0 : $bolsaSms->total_mts_customer;
		#$totalDiaCustomer = number_format($getTotalesCustomerDia->max_mt_day);
		#$totalDiaRestaCustomer = number_format($getTotalesCustomerDia->resta_dia);
		#$totalDiaUser = number_format($getTotalesuserDia->max_mt_day);
		#$totalDiaRestaUser = number_format($getTotalesuserDia->resta_dia);
		$netBalance = $getTotalesCustomerMes->max_mt_month;
		$usedBalance = $getTotalesCustomerMes->total_customer;
		$balance = $getTotalesCustomerMes->resta_mes;
		if ($balance > 0) {//GMT-6
			
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
	mail("$tecnico","Response balanceSms multi",print_r($response,1));
	exit;
}

function exchangeSms($params)
{

	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico", 'SOAP exchangeSms ws-multi', $input. "\nparams: \n" . print_r($params,1) ."--\n". print_r($_SERVER,1));
	## Obtención de parametrtos de login header security
	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);

	/*
	$PasswordDigest = '';
	preg_match("/PasswordDigest\">(.*)<\/wsse:Password>/",$input, $PassS);
	if ($PassS[1] == '') {
		preg_match("/PasswordText\">(.*)<\/wsse:Password>/",$input, $PassS1);
		if ($PassS1[1] != '') {
			$PasswordDigest = $PassS1[1];
		}
	} else
		$PasswordDigest = $PassS[1];

	$nonce = '';
	preg_match("/<wsse:Nonce>(.*)<\/wsse:Nonce>/",$input, $Noncee);
	if($Noncee[1] == ''){
		preg_match("/Base64Binary\">(.*)<\/wsse:Nonce>/",$input, $Nonceee);
		if($Nonceee[1] != '')
			$nonce = $Nonceee[1];
	}else
		$nonce = $Noncee[1];

	preg_match("/<wsu:Created>(.*)<\\/wsu:Created>/",$input, $Createdd);
	*/
	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));

	$Username 			= trim($userr[1]);
	/*
	$PasswordDigest 	= trim($PasswordDigest);
	$nonce 				= trim($nonce);
	$created 			= trim($Createdd[1]);

	## Fin matcher header security

	$dataFecha = dateTimeOk($created);
	*/

	$passwordBD = (array) ApiSmsSkyWs::getUser($Username);
	//mail("$tecnico", "getUser ws-multi", print_r($passwordBD,1));
	$password = $passwordBD['password'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];

	#### almacena objeto para login
	$datosLoginBD = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);
	//mail("$tecnico", 'datos para login usuario', print_r($datosLoginBD,1));
	$userData = new \stdClass();
	$userData->_name = $datosLoginBD['nickname']; //$Username;
	$userData->_pass = $datosLoginBD['password']; //$password;
	//mail('$tecnico','userData',print_r($userData,1));
	#####################

	/*
	$password = $nonce.$created.utf8_encode($password);
	$password = base64_encode(sha1($password,true));

	$inicio = false;

	$fechaConsulta = date('Y-m-d h:i:s');
	$expired = (array) ApiSmsSkyWs::getExpiredDate($Username, $fechaConsulta);
	//mail("$tecnico", "expired", print_r($expired,1));

	$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);
	//mail("$tecnico", "timeLoked", print_r($timeLoked,1));
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
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		$continiaProceso = false;
	}

	if ($password == $PasswordDigest && !empty($expired) && $continiaProceso && $dataFecha ) {
		
		$inicio = true;
		//mail("$tecnico", "ws security balanceSms", "Password y PasswordDigest son correctos..."."\nUsername: $Username, PasswordDigest: $PasswordDigest, password: $password, nonce: $nonce, created: $created");
		# updetear intento a 0 y desbloquear
		$loked = 0;
		$intentos = 0;
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		# Conteo de intentos
		//$conteo = (array) ApiSmsSkyWs::getIntento($user,$user_ws_id);

		$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);

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
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
			} else {
				$loked = 0;
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
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
	xmlns:ns2="http://www.sky.com/SkySmsBalance">
		<SOAP-ENV:Body>	   	
	      	<ns2:ExchangeSmsResponse>
	        	$headerResponse    	
	    	</ns2:ExchangeSmsResponse>
	   </SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;

	mail("$tecnico", "Response error exchangeSms multi", print_r($response,1));
	
	echo $response;
	exit;

	}
	*/

	$customer_id ='';

	$headerResponse = '';
	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLoginWs($userData);
	if (!empty($login)) {
		//mail("$tecnico","login exchangeSms multi",print_r($login,1));
		$user_id = $login->user_id;
		$customer_id = $login->customer_id;
		$bolsa = ApiSmsSkyWs::getBolsa($customer_id);
		//mail("$tecnico","bolsa exchangeSms multi", print_r($bolsa,1));
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
	mail("$tecnico","Response exchangeSms multi",print_r($response,1));
	exit;
}


function incomingSms($params)
{
	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico", 'SOAP exchangeSms ws-multi', $input. "\nparams: \n" . print_r($params,1) ."--\n". print_r($_SERVER,1));
	## Obtención de parametrtos de login header security
	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);

	/*
	$PasswordDigest = '';
	preg_match("/PasswordDigest\">(.*)<\/wsse:Password>/",$input, $PassS);
	if ($PassS[1] == '') {
		preg_match("/PasswordText\">(.*)<\/wsse:Password>/",$input, $PassS1);
		if ($PassS1[1] != '') {
			$PasswordDigest = $PassS1[1];
		}
	} else
		$PasswordDigest = $PassS[1];

	$nonce = '';
	preg_match("/<wsse:Nonce>(.*)<\/wsse:Nonce>/",$input, $Noncee);
	if($Noncee[1] == ''){
		preg_match("/Base64Binary\">(.*)<\/wsse:Nonce>/",$input, $Nonceee);
		if($Nonceee[1] != '')
			$nonce = $Nonceee[1];
	}else
		$nonce = $Noncee[1];

	preg_match("/<wsu:Created>(.*)<\\/wsu:Created>/",$input, $Createdd);
	*/

	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));

	$Username 			= trim($userr[1]);
	/*
	$PasswordDigest 	= trim($PasswordDigest);
	$nonce 				= trim($nonce);
	$created 			= trim($Createdd[1]);

	## Fin matcher header security

	$dataFecha = dateTimeOk($created);
	*/

	$passwordBD = (array) ApiSmsSkyWs::getUser($Username);
	//mail("$tecnico", "getUser ws-multi", print_r($passwordBD,1));
	$password = $passwordBD['password'];
	$user_ws_id = $passwordBD['user_ws_id'];
	$user_id_customer = $passwordBD['user_id'];

	#### almacena objeto para login
	$datosLoginBD = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);
	//mail("$tecnico", 'datos para login usuario', print_r($datosLoginBD,1));
	$userData = new \stdClass();
	$userData->_name = $datosLoginBD['nickname']; //$Username;
	$userData->_pass = $datosLoginBD['password']; //$password;
	//mail('$tecnico','userData',print_r($userData,1));
	#####################

	/*
	$password = $nonce.$created.utf8_encode($password);
	$password = base64_encode(sha1($password,true));

	$inicio = false;

	$fechaConsulta = date('Y-m-d h:i:s');
	$expired = (array) ApiSmsSkyWs::getExpiredDate($Username, $fechaConsulta);
	//mail("$tecnico", "expired", print_r($expired,1));

	$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);
	//mail("$tecnico", "timeLoked", print_r($timeLoked,1));
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
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		$continiaProceso = false;
	}

	if ($password == $PasswordDigest && !empty($expired) && $continiaProceso && $dataFecha ) {
		
		$inicio = true;
		//mail("$tecnico", "ws security balanceSms", "Password y PasswordDigest son correctos..."."\nUsername: $Username, PasswordDigest: $PasswordDigest, password: $password, nonce: $nonce, created: $created");
		# updetear intento a 0 y desbloquear
		$loked = 0;
		$intentos = 0;
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		# Conteo de intentos
		//$conteo = (array) ApiSmsSkyWs::getIntento($user,$user_ws_id);

		$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);

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
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
			} else {
				$loked = 0;
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
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
	xmlns:ns2="http://www.sky.com/SkySmsBalance">
		<SOAP-ENV:Body>	   	
	      	<ns2:IncomingSmsResponse>
	        	$headerResponse    	
	    	</ns2:IncomingSmsResponse>
	   </SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;

	mail("$tecnico", "Response error incomingSms multi", print_r($response,1));
	
	echo $response;
	exit;

	}
	*/
	
	$idMessage		= $params->idMessage;
	$fechaI			= $params->from;
	$fechaF			= $params->to;

	$headerResponse = '';
	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLoginWs($userData);
	if (!empty($login)) {
		//mail("$tecnico","login incomingSms multi",print_r($login,1));
		$user_id = $login->user_id;
		$customer_id = $login->customer_id;
		##
		if (!empty($idMessage) && empty($fechaI) && empty($fechaF)) {
			$mos = ApiSmsSkyWs::getIncomming($idMessage);
			if (!empty($mos)) {
				//mail("$tecnico","mos id sin fecha",print_r($mos,1));
				$campaign_id = $mos[0]->campaign_id;
				$campaignUser = ApiSmsSkyWs::getCampaignId($campaign_id);
				//mail("$tecnico","campanias multi","respuesta de idMessage".print_r($campaignUser,1)."login user_id:".$user_id);
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
			$campaniasC = ApiSmsSkyWs::getCampaignIds($customer_id,$fechaI,$fechaF);
			$ids = '';
			foreach ($campaniasC as $key => $value) {
				$ids .= $value->campaign_id.",";
			}
			//mail("$esau","ids campaignCustomer", trim($ids,","));
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
				//mail("$tecnico","mos full data request multi",print_r($mos,1));
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
	mail("$tecnico","Response incomingSms multi",print_r($response,1));
	exit;
}


function getFecha()
{
	date_default_timezone_set('America/Mexico_City');
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


function dateTimeOk($created) {

	date_default_timezone_set('UTC');

	$fechaSistema = date('Y-m-d')."T".date('H:i:s')."Z";

	//$fecha = strtotime('2018-05-08T23:38:30Z');

	$fechaUno = strtotime($fechaSistema);
	$fechaDos = strtotime($created);

	$dif = $fechaUno - $fechaDos;
	mail("tecnico@airmovil.com", "Diferencia de horarios en server multi", "Hora smppvier: $fechaSistema --- Hora peticion recibida: $created ---$fechaUno-$fechaDos-->$dif");
	if (abs($dif) <= 121 ) {
		return true;
	}
	else {
		return false;
	}
	//return true;
	//mail("$tecnico", "fecha...", "fechaRequest: u: $fechaUno, d: $fechaDos ");

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
        	mail("tecnico@airmovil.com", "acentos y caracteres invalidos ws-multi", "mensaje new: ".$texto ."\nmensaje recibido: ". $text);
        	return false;
        } else {
        	return true;
        }

}

function Security($data){

	$input = file_get_contents("php://input");

	$tecnico ='tecnico@airmovil.com';
	mail("$tecnico","security login",print_r($data,1).print_r($_SERVER,1).print_r($input,1));

	$Username 			= trim($data->UsernameToken->Username);
	$PasswordDigest 	= trim($data->UsernameToken->Password);
	$nonce 				= trim($data->UsernameToken->Nonce);
	$created 			= trim($data->UsernameToken->Created);

	## Fin matcher header security

	$dataFecha = dateTimeOk($created);

	$passwordBD = (array) ApiSmsSkyWs::getUser($Username);
	//mail("$tecnico", "getUser ws-multi", print_r($passwordBD,1));
	$password = $passwordBD['password'];
	$user_ws_id = $passwordBD['user_ws_id'];
	//$user_id_customer = $passwordBD['user_id'];

	#### almacena objeto para login
	/*$datosLoginBD = (array) ApiSmsSkyWs::getDataUserBD($user_id_customer);
	//mail("$tecnico", 'datos para login usuario', print_r($datosLoginBD,1));
	$userData = new \stdClass();
	$userData->_name = $datosLoginBD['nickname']; //$Username;
	$userData->_pass = $datosLoginBD['password']; //$password;*/
	//mail('$tecnico','userData',print_r($userData,1));
	#####################

	/*$password = $nonce.$created.utf8_encode($password);
	$password = base64_encode(sha1($password,true));*/

	$inicio = false;

	$fechaConsulta = date('Y-m-d h:i:s');
	$expired = (array) ApiSmsSkyWs::getExpiredDate($Username, $fechaConsulta);
	//mail("$tecnico", "expired", print_r($expired,1));

	$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);
	//mail("$tecnico", "timeLoked", print_r($timeLoked,1));
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
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);

	} else {
		$continiaProceso = false;
	}

	if ($password == $PasswordDigest && !empty($expired) && $continiaProceso && $dataFecha ) {
		
		$inicio = true;
		mail("$tecnico", "ws multi security login", "Password y PasswordDigest son correctos..."."\nUsername: $Username, PasswordDigest: $PasswordDigest, password: $password, nonce: $nonce, created: $created");
		# updetear intento a 0 y desbloquear
		$loked = 0;
		$intentos = 0;
		$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
		//exit;

	} else {
		# Conteo de intentos
		//$conteo = (array) ApiSmsSkyWs::getIntento($user,$user_ws_id);

		$timeLoked = (array) ApiSmsSkyWs::getTimeLoked($Username,$user_ws_id);

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
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
			} else {
				$loked = 0;
				$insertIntento = ApiSmsSkyWs::insertIntento($Username, $user_ws_id, $intentos, $loked);
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
	xmlns:ns2="http://www.sky.com/SkySmsBalance">
		<SOAP-ENV:Body>	   	
	      	<ns2:UsernameToken>
	        	$headerResponse    	
	    	</ns2:UsernameToken>
	   </SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
html;

	mail("$tecnico", "Response error login", print_r($response,1));
	
	echo $response;
	exit;	   	

	}

}

 


