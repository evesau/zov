<?php
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
// Notificar todos los errores de PHP
error_reporting(-1);

//mail('tecnico.espinoza@airmovil.com','soap server',file_get_contents('php://input'));
include 'model/ApiSmsSkyWs.php'; // Regresa Objetos

if(!extension_loaded("soap")){
      dl("php_soap.dll");
}
 
ini_set("soap.wsdl_cache_enabled","0");
$server = new SoapServer("https://smsmkt.amovil.mx/wsdl/skysms/SmsSkyWs.wsdl");

$server->addFunction("Security");
$server->addFunction("sendSms");
$server->addFunction("statusSms");
$server->addFunction("balanceSms");
$server->AddFunction("changePasswordSms");
$server->addFunction("incomingSms");
$server->addFunction("exchangeSms");
$server->handle();


$valida = false;

//print_r($server->getFunctions());

function sendSms($params)
{
	global $valida;

	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico", 'SOAP sendSms', $input . print_r($params,1). print_r($_SERVER,1). "\n---VALIDA: ---$valida---" );

	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);

	mail("$tecnico", "preg_match_all", print_r($userr,1));

	$Username 			= trim($userr[1]);

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


	$msisdn 		= $params->message->phoneNumber;
	$mensaje 		= $params->message->message;
	
	$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

	$login = ApiSmsSkyWs::getByIdLoginWs($userData);
	
	if ($valida) {

		$messageResponse="";
		$campaign_id = 167;

		$customer_id = ApiSmsSkyWs::getCustomer($login->user_id);
		$customer_id = $customer_id->customer_id;

		if ($campaign_id == 167) {
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
								# buscar en white list sky e insertar si no esta
								$buscaWLS = ApiSmsSkyWs::getWhiteListSky(substr($msisdn, -10));
								$esTelcel = false;
								if (!empty($buscaWLS)) {
									# buscamos si es telcel
									mail("$tecnico","busca WLS", "llega vacio si no esta white list estatus:".$buscaWLS[0]->estatus);
									$estatusWL = $buscaWLS[0]->estatus;
									if ($estatusWL == 1) {
										$esTelcel = true;
									}else {
										$esTelcel = false;
									}									

								}else{
									# insertamos en wls
									$celular = substr($msisdn, -10);
									$responseApiWl = file_get_contents("https://smsmkt.amovil.mx/wsdl/skysms/whitelist/WhiteListApi.php?msisdn=$celular");
									mail("$tecnico","responseApiWl 1",print_r($responseApiWl,1));
									$timeout = false;
									if (empty($responseApiWl)) {
										$responseApiWl = file_get_contents("https://smsmkt.amovil.mx/wsdl/skysms/whitelist/WhiteListApi.php?msisdn=$celular");
										mail("$tecnico","responseApiWl 2",print_r($responseApiWl,1));
										if (empty($responseApiWl)) {
											$timeout = true;
										}
									} else {
										if ($timeout) {
											//break;
											mail("$tecnico","responseApiWl time out","WhiteListApi no responde");
										} else {
											$resp = explode("=",$responseApiWl);
											mail("$tecnico","responseApiWl",print_r($resp,1));
											# verificamos si es telcel
											$resultCode = trim($resp[1],"&operationId");
											$operationId = $resp[2];
											if ($resultCode != 500) {
												$statusWL = 1;
												$esTelcel = true;
												#insertamos wls cuando es telcel
												@ApiSmsSkyWs::insertWLS($celular,$statusWL,$operationId);
											}else{
												# no es telcel
												$statusWL = 2;
												$operationId = trim($resp[1],"&operationId");
												@ApiSmsSkyWs::insertWLS($celular,$statusWL,$operationId);
											}

										}

									}

								}
								//exit;
								if (strlen($mensaje) <=160) {
									# Validado por white list
									if ($esTelcel) {
										$carrier_id = 1;
										$msisdnId = ApiSmsSkyWs::insertIgnoreMsisdn(substr($msisdn, -12), $carrier_id);
										if (empty($msisdnId)) {
											$buscaMsisdn = ApiSmsSkyWs::getMsisdnCatalogoMsisdnNew(substr($msisdn,-12));
											$msisdnId = $buscaMsisdn->msisdn_id;
											//mail("$tecnico","msisdnId",$msisdnId);
										}
										# Buscamos short_code
										$buscaShortCode = ApiSmsSkyWs::getCarrierCustomerGroup($customer_id);
										$shortcode_id = $buscaShortCode[0]->short_code_id;
										# Buscamos Carrier Connection Short Code
										$buscaCCSC = ApiSmsSkyWs::getCarrierCustomer($customer_id,$shortcode_id);
										# Obtenemos carrier_connection_short_code_id para poder insertar en sms_campaign
										$ccsc_id ='';
										foreach ($buscaCCSC as $key => $value) {
											if ($carrier_id == $value->carrier_id) {
												$ccsc_id = $value->carrier_connection_short_code_id;
												break;
											}			
										}
										# Encolamos el sms
										if ($ccsc_id=='') {
											$ccsc_id = -1;
											$sms_campaign_estatus_id_sms = 10;
										}else{
											$sms_campaign_estatus_id_sms = 4;
										}
										$insertarSms = ApiSmsSkyWs::insertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje);
										mail("$tecnico","insertSmsCampaign whitelist",print_r($insertarSms,1). " -$insertarSms: params:($campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje)");
										if((int) $insertarSms > 0) {
											$idMessage = (string) $insertarSms;
											$operador = 'telcel';
											$headerResponse='';
											$messageResponse="
												<ns2:idMessage>$idMessage</ns2:idMessage>
												<ns2:success>true</ns2:success>
												<ns2:code>1</ns2:code>
												<ns2:description>Queued</ns2:description>
												<ns2:operator>$operador</ns2:operator>";					
										}
										else {
											//mail("$tecnico","error test|","WhiteListApi no responde");
											$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-11</ns1:codeError>
		            <ns1:messageError>Fail insert sms</ns1:messageError>
		        </ns2:headerResponse>
html;
										}

									} # Fin if es Telcel de white list
									else {
										# Buscamos carrier de msisdn
									$buscaMsisdn = ApiSmsSkyWs::getMsisdnCatalogoMsisdn(substr($msisdn,-12));
									mail("$tecnico",'msisdn & carrier',print_r($buscaMsisdn,1));
									# si encontramos msisdn y carrier
									if (!empty($buscaMsisdn)) {

										# Validado por white list
										if ($esTelcel) {
											$carrier_id = 1;
											$carrier = 'telcel';
										} else {
											$carrier_id = $buscaMsisdn->carrier_id;
											$carrier = $buscaMsisdn->name;
										}
										
										@ApiSmsSkyWs::updateCatalogoMsisdn(substr($msisdn,-12),$carrier_id);
										//$carrier_id = $buscaMsisdn->carrier_id;
										$msisdnId = $buscaMsisdn->msisdn_id;
										
										# Buscamos short_code
										$buscaShortCode = ApiSmsSkyWs::getCarrierCustomerGroup($customer_id);
										$shortcode_id = $buscaShortCode[0]->short_code_id;
										# Buscamos Carrier Connection Short Code
										$buscaCCSC = ApiSmsSkyWs::getCarrierCustomer($customer_id,$shortcode_id);
										# Obtenemos carrier_connection_short_code_id para poder insertar en sms_campaign
										$ccsc_id ='';
										foreach ($buscaCCSC as $key => $value) {
											if ($carrier_id == $value->carrier_id) {
												$ccsc_id = $value->carrier_connection_short_code_id;
												break;
											}		
										}
										# Encolamos el sms
										if ($ccsc_id=='') {
											$ccsc_id = -1;
											$sms_campaign_estatus_id_sms = 10;
										}else{
											$sms_campaign_estatus_id_sms = 4;
										}
										$insertarSms = ApiSmsSkyWs::insertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje);
										mail("$tecnico","insertSmsCampaign","$insertarSms: params:($campaign_id, $msisdnId, $ccsc_id, $sms_campaign_estatus_id_sms, 4, $mensaje)");
										if((int) $insertarSms>0) {
											$idMessage = (string) $insertarSms;
											$operador = (string) $carrier;
											$headerResponse='';
											$messageResponse="
												<ns2:idMessage>$idMessage</ns2:idMessage>
												<ns2:success>true</ns2:success>
												<ns2:code>1</ns2:code>
												<ns2:description>Queued</ns2:description>
												<ns2:operator>$operador</ns2:operator>";					
										}

									} # Fin del if busca msisdn encontrado
									else { # Insertamos el nuevo msisdn a bd para buscar carrier
										# Validado por white list
										if ($esTelcel) {
											$carrier_id = 1;
											$carrier = 'telcel';
										} else {
											/*if ($proveedorId == 1 || $proveedorId == 2 || $proveedorId == 3) {
													$carrier_id = $proveedorId;
											}else {
													$carrier_id = 0;
											}*/
											$carrier_id = 0;
											$carrier = 'Looking an carrier';

										}

										//$msisdnId = ApiSmsSkyWs::insertaMsisdn(substr($msisdn,-12), $carrier_id); // se cambia 0 por proveedorId para insertar como lo mandan
										
										$buscaMsisdn = ApiSmsSkyWs::getMsisdnCatalogoMsisdnNew(substr($msisdn,-12));
										mail("$tecnico","msisdn busca carrier 1",$msisdn."-".print_r($buscaMsisdn,1));
										if (empty($buscaMsisdn)) {
											$msisdnId = ApiSmsSkyWs::insertIgnoreMsisdn(substr($msisdn, -12), $carrier_id);
										}else{									
											$msisdnId = $buscaMsisdn->msisdn_id;
											mail("$tecnico","insert msisdn busca carrier 3","m: $msisdn - msisdnId:".$msisdnId);
										}

										if ((int) $msisdnId>0) {
											# Encolamos sms
											$insertarSms = ApiSmsSkyWs::insertSmsCampaign($campaign_id, $msisdnId, -1, 10, 4, $mensaje);// se cambia busca carrier
											mail("$tecnico","insertSmsCampaign busca carrier","$insertarSms: msisdn:$msisdn params:($campaign_id, $msisdnId, -1, 10, 4, $mensaje)");
											if ((int) $insertarSms>0) {
												//$carrier = 'Looking an carrier';

												$idMessage = (string) $insertarSms;
												$operador = (string) $carrier;
												$headerResponse='';
												$messageResponse="
													<ns2:idMessage>$idMessage</ns2:idMessage>
													<ns2:success>true</ns2:success>
													<ns2:code>1</ns2:code>
													<ns2:description>Queued</ns2:description>
													<ns2:operator>$operador</ns2:operator>";
											} # Fin insert sms busca carrier
											else {
												$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-10</ns1:codeError>
		            <ns1:messageError>Fail looking an carrier</ns1:messageError>
		        </ns2:headerResponse>
html;
											}

										} # Fin if insert msisdn sin carrier
										else {
											$headerResponse =<<<html
				<ns2:headerResponse>
					<ns1:codeError>-9</ns1:codeError>
		            <ns1:messageError>Fail insert msisdn</ns1:messageError>
		        </ns2:headerResponse>
html;
										}
									} # Fin else buscar carrier

									} # Fin else white list
							
									

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
				//mail("$tecnico","mts diario usuario", "totalDiaRestaUser:$totalDiaRestaUser no se envio mt");
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
	mail("$tecnico","Response sendSms",print_r($response,1));
	exit;
}


function statusSms($params)
{
	global $valida;

	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico", 'SOAP statusSms', $input . print_r($params,1). print_r($_SERVER,1) . "--VALIDA: ---$valida---" );

	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);
	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));

	$Username 			= trim($userr[1]);

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


	$idMessage		= $params->idMessage;


	$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLoginWs($userData);
	
	if ($valida) {

		$user_id = $login->user_id;
		$statusSms = ApiSmsSkyWs::getStatusSms($idMessage);
		//mail("$tecnico","statusSms",print_r($statusSms,1));
		$headerResponse = '';

		$messageResponse = '';

		
		if (!empty($statusSms)) { # sms encontrado
			$sms_estatus = (string) $statusSms->sms_estatus;
			$carrier = (string) $statusSms->carrier;
			$campaign_id = $statusSms->campaign_id;
			# buscamos que el sms encontrado pertenecas a una campaña del usuario
			$campaignUser = ApiSmsSkyWs::getCampaignId($campaign_id);

			$user_id_campaign = $campaignUser->user_id;
			/*$messageResponse=<<<html
			<ns2:status></ns2:status>
			<ns2:description></ns2:description>
			<ns2:operator></ns2:operator>
			<ns2:pais></ns2:pais>
			<ns2:estado></ns2:estado>
			<ns2:municipio></ns2:municipio>
			<ns2:poblacion></ns2:poblacion>
html;*/
			if (!empty($campaignUser)) { 
				//mail("$tecnico","campaignUser",print_r($campaignUser,1).md5($pass));
				# Verificamos si la campania le pertenece al usuario
				if ($user_id == $user_id_campaign) {

					// blacklist solo telcel
					if ($carrier == 'telcel') {
						// obtener msisdn de sms_campaign
						$msisdn = ApiSmsSkyWs::getMsisdnSmsCampaign($idMessage);
						mail("$tecnico","msisdn_log",print_r($msisdn,1));
						$msisdn = substr($msisdn->msisdn_log,-10);

						$bl = file_get_contents("http://smpp.amovil.mx/shortcodeblacklist/consultablacklist.php?from=$msisdn");
						mail("$tecnico","api blacklist",$bl."-- http://smpp.amovil.mx/shortcodeblacklist/consultablacklist.php?from=$msisdn");
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
						mail("$tecnico","arrayStatus1",print_r($arrayStatus2,1));
						foreach ($arrayStatus2 as $key => $value) {
							//if ($sms_estatus == $value['estatus']) {
								//mail("$tecnico","foreach value",print_r($value,1));
								$sms_estatus = $value['estatus'];
								if ($sms_estatus=='preparado para envio'||$sms_estatus=='encolado'||$sms_estatus=='en proceso por ser encolado') {
									$Status = 0;
									$Description = 'Pending';
								}
								elseif ($sms_estatus=='envio white list'||$sms_estatus=='proceso white list'||$sms_estatus=='busca carrier'||$sms_estatus=='buscando carrier') {
									$Status = 1;
									$Description = 'Processing';
								}
								elseif ($sms_estatus=='sin carrier'||$sms_estatus=='error'||$sms_estatus=='error white list'||$sms_estatus=='cancelado'||$sms_estatus=='no telcel' || $sms_estatus=='REJECTD' ) {
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
								}
							//}
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
	global $valida;

	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico", 'SOAP changePasswordSms', $input . print_r($params,1). print_r($_SERVER,1) . "--VALIDA: ---$valida---" );

	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);

	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));

	$Username 			= trim($userr[1]);

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
	
	$newPassword	= $params->newPassword;

	$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLoginWs($userData);
	
	if ($valida) {
		$user_id = $login->user_id;
		mail("$tecnico"," changePasswordSms","user_id:".$user_id." newPassword:".$newPassword);
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
	global $valida;

	
	$input = file_get_contents("php://input");
	$tecnico = "tecnico@airmovil.com";
	mail("$tecnico","balanceSms", $input . print_r($params,1) . print_r($_SERVER,1) . "--VALIDA: ---$valida---");
	## Obtención de parametrtos de login header security
	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);
	
	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));
	
	$Username 			= trim($userr[1]);

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

	$headerResponse = <<<html
			<ns2:headerResponse>
				<ns1:codeError></ns1:codeError>
	            <ns1:messageError></ns1:messageError>
	        </ns2:headerResponse>
html;

	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLoginWs($userData);
	//mail("$tecnico","login balanceSms", print_r($login,1)."user:".trim($user)."_ & pass:".trim($pass)."_");
	if ($valida) {
		
		$customer_id = $login->customer_id;
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

		if ($balance > 0) {
			
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
	mail("$tecnico","Response balanceSms",print_r($response,1));
	exit;
}

function exchangeSms($params)
{
	global $valida;

	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico","SOAP exchangeSms", $input . print_r($params,1) . print_r($_SERVER,1) . "--VALIDA: ---$valida---" );

	## Obtención de parametrtos de login header security
	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);

	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));

	$Username 			= trim($userr[1]);

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

	$headerResponse = '';
	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLoginWs($userData);
	if ($valida) {
		//mail("$tecnico","login exchangeSms",print_r($login,1));
		$user_id = $login->user_id;
		$customer_id = ($login->customer_id=='') ? $login->customer_id : $login->customer_id;
		$bolsa = ApiSmsSkyWs::getBolsa($customer_id);
		mail("$tecnico","bolsa exchangeSms", print_r($bolsa,1));
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
	global $valida;

	$input = file_get_contents("php://input");
	$tecnico = 'tecnico@airmovil.com';
	mail("$tecnico", "SOAP incomingSms", $input . print_r($params,1). print_r($_SERVER,1). "--VALIDA: ---$valida---" );

	## Obtención de parametrtos de login header security
	preg_match('/<wsse:Username>(.*)<\\/wsse:Username/',$input, $userr);
	//mail("$tecnico", "preg_match_all", print_r($PassS,1).print_r($userr,1).print_r($Noncee,1).print_r($Createdd,1).print_r($Nonceee,1));

	$Username 			= trim($userr[1]);

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
	
	$idMessage		= $params->idMessage;
	$fechaI			= $params->from;
	$fechaF			= $params->to;


	$headerResponse = '';
	$messageResponse = '';

	$login = ApiSmsSkyWs::getByIdLoginWs($userData);
	if ($valida) {
		//mail("$tecnico","login incomingSms",print_r($login,1));
		$user_id = $login->user_id;
		$customer_id = $login->customer_id;
		##
		if (!empty($idMessage) && empty($fechaI) && empty($fechaF)) {
			$mos = ApiSmsSkyWs::getIncomming($idMessage);
			if (!empty($mos)) {
				//mail("$tecnico","mos id sin fecha",print_r($mos,1));
				$campaign_id = $mos[0]->campaign_id;
				$campaignUser = ApiSmsSkyWs::getCampaignId($campaign_id);
				mail("$tecnico","campanias","respuesta de idMessage".print_r($campaignUser,1)."login user_id:".$user_id);
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
			//mail("$tecnico","ids campaignCustomer", trim($ids,","));
			$mosDate = ApiSmsSkyWs::getIncommingDate(trim($ids,","),fechaInicial($fechaI), fechaFinal($fechaF));
			if (!empty($mosDate)) {
				mail("$tecnico","mos de solo fechas",print_r($mosDate,1));
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
				mail("$tecnico","mos full data request",print_r($mos,1));
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
	mail("tecnico@airmovil.com", "Diferencia de horarios en server", "Hora smppvier: $fechaSistema --- Hora peticion recibida: $created ---$fechaUno-$fechaDos-->$dif");
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

	global $valida;

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
		
		$valida = true;
		mail("$tecnico", "ws security login OK", "Password y PasswordDigest son correctos..."."\nUsername: $Username, PasswordDigest: $PasswordDigest, password: $password, nonce: $nonce, created: $created");
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
 

