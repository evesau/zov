<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Reportesadmin implements Crud{

	public static function insert($msisdn){}
    public static function getById($param){}
    public static function getAll(){}

/************************************** Reportes Admin General *******************************************************/
	public static function getTotalTelcel(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
WHERE ccsc.carrier_id =1
AND YEAR( sms.entry_time ) = YEAR( CURDATE( ) )
sql;

		return $mysqli->queryAll($query);
	}

	public static function getTotalMovistar(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
WHERE ccsc.carrier_id =2
AND YEAR( sms.entry_time ) = YEAR( CURDATE( ) )
sql;

		return $mysqli->queryAll($query);
	}

	public static function getTotalATT(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
WHERE ccsc.carrier_id =3
AND YEAR( sms.entry_time ) = YEAR( CURDATE( ) )
sql;

		return $mysqli->queryAll($query);
	}

	public static function getTotalMessages(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT  c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code , m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN customer cu ON (cc.customer_id = cu.customer_id)
INNER JOIN sms_campaign smsc USING (campaign_id)
INNER JOIN campaign_status cs USING (campaign_status_id)
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING (carrier_connection_short_code_id)
INNER JOIN short_code sc USING (short_code_id)
WHERE YEAR(c.delivery_date) = YEAR(CURDATE())
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesCop($start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT  c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code , m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN customer cu ON (cc.customer_id = cu.customer_id)
INNER JOIN sms_campaign smsc USING (campaign_id)
INNER JOIN campaign_status cs USING (campaign_status_id)
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING (carrier_connection_short_code_id)
INNER JOIN short_code sc USING (short_code_id)
WHERE YEAR(c.delivery_date) = YEAR(CURDATE())
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

  /*public static function getTotalCountMessages($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT count( sc.sms_campaign_id ) AS total_mensajes
FROM sms_campaign sc
WHERE sc.campaign_id = $id
sql;
		
		return $mysqli->queryAll($query);
	}*/

/************************************** Reportes Admin MT *******************************************************/

	public static function getAllCampaign(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.campaign_id, c.name AS name_campaign, sc.short_code 
FROM campaign c
INNER JOIN campaign_customer cc using(campaign_id)
INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
INNER JOIN carrier_connection_short_code_campaign ccscc using(campaign_id)
INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
INNER JOIN short_code sc on (sc.short_code_id = ccsc.short_code_id)
WHERE YEAR(c.delivery_date) = YEAR(CURDATE()) 
GROUP BY c.campaign_id;
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function reportMT($result){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :result
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':result'=>$result));
	}

	public static function reportMTCop($result, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :result
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':result'=>$result));
	}

	public static function getData($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));

	}

	public static function getDataCop($id, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
}

	public static function reportMTE($id_campania){

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status = sce.estatus , s.status, sce.estatus ) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id=$id_campania
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTDetalleCount($consulta){

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id=:id_campaign AND DAY(sc.delivery_date) between DAY(:fecha_ini) AND DAY(:fecha_fin)
GROUP BY sc.sms_campaign_id
sql;

$params = array(
			':id_campaign' => $consulta->_id_campaign,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalle($consulta, $start, $length){

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id=:id_campaign AND DAY(sc.delivery_date) between DAY(:fecha_ini) AND DAY(:fecha_fin)
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_campaign' => $consulta->_id_campaign,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCount($datos){
					// print_r($datos);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
GROUP BY sms_campaign_id
sql;

$params = array(
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}


	public static function reportMTDetalleFecha($datos, $start, $length){
					// print_r($datos);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	/*public static function getDataCampaign($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, m.name AS modulo
FROM campaign c
INNER JOIN campaign_status cs USING (campaign_status_id)
INNER JOIN modules m ON m.modules_id = c.modules_id
WHERE c.campaign_id = $id
sql;
		
		return $mysqli->queryAll($query);
	}*/

/************************************** Reportes Admin MO *******************************************************/

	public static function getDataShortCode($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT DISTINCT(c.campaign_id), sc.short_code
FROM campaign c
INNER JOIN campaign_customer cc using(campaign_id)
INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
INNER JOIN carrier_connection_short_code_campaign ccscc using(campaign_id)
INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
INNER JOIN short_code sc on (sc.short_code_id = ccsc.short_code_id)
WHERE c.campaign_id = $id
sql;
		
		return $mysqli->queryAll($query);
	}

	public static function reporteMensajes($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
select * from sms 
WHERE campaign_id = :id AND direction = 'MT' AND status = 'delivered';
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));

	}

	public static function getDataMO(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword 
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO'
GROUP BY sms.sms_id;
sql;

		return $mysqli->queryAll($query);
	}

	public static function getDataMOCop($start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword 
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO'
GROUP BY sms.sms_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query);
	}

	public static function getDataService($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword 
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
WHERE sms.service_id=:id
sql;

		return $mysqli->queryAll($query, array(':id' => $id));
	}

	public static function getDataServiceCop($id, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword 
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
WHERE sms.service_id=:id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id' => $id));
	}

	public static function consultDate($consulta){
		$mysqli = Database::getInstance();
		$query = <<<sql
select c.name, count(*) as total from sms 
inner join campaign c using(campaign_id)
where campaign_id = :id AND direction = 'MO' AND entry_time >= :fecha_ini AND entry_time <= :fecha_fin;
sql;

	$params = array(
			':id' => $consulta->_id,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}


	public static function consultDateService($consulta){
		$mysqli = Database::getInstance();
		$query = <<<sql
select c.name, count(*) as total from sms 
inner join campaign c using(campaign_id)
where service_id = :id AND entry_time >= :fecha_ini AND entry_time <= :fecha_fin;
sql;

	$params = array(
			':id' => $consulta->_id,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMO(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, 
IF(sk.keyword IS NULL, "Sin keyword", sk.keyword) AS keyword
FROM sms
LEFT JOIN campaign cam USING (campaign_id)
LEFT JOIN campaign_customer cc USING (campaign_id)
LEFT JOIN customer c on (cc.customer_id = c.customer_id)
LEFT JOIN service using (service_id)
LEFT JOIN service_keyword sk using (service_id)
WHERE sms.direction='MO' AND sms.campaign_id = 0
GROUP BY sms.sms_id
sql;
		return $mysqli->queryAll($query);
		}

	public static function reportMOCop($start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, 
IF(sk.keyword IS NULL, "Sin keyword", sk.keyword) AS keyword
FROM sms
LEFT JOIN campaign cam USING (campaign_id)
LEFT JOIN campaign_customer cc USING (campaign_id)
LEFT JOIN customer c on (cc.customer_id = c.customer_id)
LEFT JOIN service using (service_id)
LEFT JOIN service_keyword sk using (service_id)
WHERE sms.direction='MO' AND sms.campaign_id = 0
GROUP BY sms.sms_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
		}


	public static function reportMOExcel($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword 
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' AND sms.campaign_id=:id_campaign
GROUP BY sms.sms_id;
sql;

$params = array(
			':id_campaign' => $datos->_id_campaign
		);
		return $mysqli->queryAll($query, $params);
	}


	public static function reportMOExcelDetalleCount($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword 
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' AND sms.campaign_id=:id_campaign
AND sms.entry_time between :fecha_ini AND :fecha_fin
GROUP BY sms.sms_id;
sql;

$params = array(
			':id_campaign' => $datos->_id_campaign,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);
		return $mysqli->queryAll($query, $params);
	}

	public static function reportMOExcelDetalle($datos, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword 
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' AND sms.campaign_id=:id_campaign
AND sms.entry_time between :fecha_ini AND :fecha_fin
GROUP BY sms.sms_id
LIMIT $start, $length
sql;

$params = array(
			':id_campaign' => $datos->_id_campaign,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);
		return $mysqli->queryAll($query, $params);
	}


	public static function reportMOExcelDetalleFechaCount($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword 
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' AND sms.entry_time between :fecha_ini AND :fecha_fin
GROUP BY sms.sms_id;
sql;

$params = array(
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);
		return $mysqli->queryAll($query, $params);
	}

	public static function reportMOExcelDetalleFecha($datos, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword 
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' AND sms.entry_time between :fecha_ini AND :fecha_fin
GROUP BY sms.sms_id
LIMIT $start, $length
sql;

$params = array(
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);
		return $mysqli->queryAll($query, $params);
	}


	public static function getAllCampaignMO(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.campaign_id, c.name, sc.short_code
FROM campaign c
INNER JOIN campaign_customer cc USING(campaign_id)
INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
INNER JOIN carrier_connection_short_code_campaign ccscc USING(campaign_id)
INNER JOIN sms s USING (carrier_connection_short_code_id)
INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
INNER JOIN short_code sc on (sc.short_code_id = ccsc.short_code_id)
WHERE s.direction = 'MO'
GROUP BY c.campaign_id 
sql;
		return $mysqli->queryAll($query);
		}

	public static function getAllServiceMO(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT s.service_id, s.title
FROM service s
INNER JOIN campaign c USING (campaign_id)
WHERE s.status = 1;
sql;
		return $mysqli->queryAll($query);
	}


	public static function reportService(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword 
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
sql;
		return $mysqli->queryAll($query);
	}

	public static function reportServiceCop($start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword 
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
		}


		public static function reportServiceExcel($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
select entry_time, source, destination, direction, content, sms.status, keyword from service
inner join sms using (service_id)
inner join service_keyword using (service_id)
inner join customer_service cs using (service_id)
inner join customer c on (cs.customer_id = c.customer_id)
where c.customer_id=$datos->_id_customer and service.service_id=$datos->_id_service
sql;
		return $mysqli->queryAll($query);
		}


		public static function reportServiceExcelDetalleCount($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword 
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
WHERE service_id=:id_service AND entry_time between :fecha_ini AND :fecha_fin
sql;
		$params = array(
			':id_service' => $datos->_id_service,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
		}

		public static function reportServiceExcelDetalle($datos, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword 
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
WHERE service_id=:id_service AND entry_time between :fecha_ini AND :fecha_fin
LIMIT $start, $length
sql;
		$params = array(
			':id_service' => $datos->_id_service,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
		}


	public static function reportServiceExcelDetalleFechasCount($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword 
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
WHERE entry_time between :fecha_ini AND :fecha_fin
sql;
		$params = array(
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
	}

	public static function reportServiceExcelDetalleFechas($datos, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword 
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
WHERE entry_time between :fecha_ini AND :fecha_fin
LIMIT $start, $length
sql;
		$params = array(
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
		}

		public static function getAllCampaignRMT($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.campaign_id, c.name, sc.short_code FROM campaign c
INNER JOIN campaign_customer cc using(campaign_id)
INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
inner join carrier_connection_short_code_campaign ccscc using(campaign_id)
inner join carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
inner join short_code sc on (sc.short_code_id = ccsc.short_code_id)
WHERE cu.customer_id = :id;
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getAllCampania(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS campania, created, delivery_date, cs.name AS estatus
FROM campaign c
INNER JOIN campaign_status cs
USING ( campaign_status_id )
sql;

		return $mysqli->queryAll($query);
	}

	public static function getAllCampaniaCop($start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS campania, created, delivery_date, cs.name AS estatus
FROM campaign c
INNER JOIN campaign_status cs
USING ( campaign_status_id )
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query);
	}


	public static function getAllCampaniaByFechas($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS campania, created, delivery_date, cs.name AS estatus
FROM campaign c
INNER JOIN campaign_status cs
USING ( campaign_status_id )
WHERE delivery_date between :fecha_ini AND :fecha_fin
sql;
		$params = array(
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
		}

	public static function getAllCampaniaByFechasCop($datos, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS campania, created, delivery_date, cs.name AS estatus
FROM campaign c
INNER JOIN campaign_status cs
USING ( campaign_status_id )
WHERE delivery_date between :fecha_ini AND :fecha_fin
LIMIT $start, $length
sql;
		$params = array(
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
	}


	public static function update($param){}
    public static function delete($param){}

    public static function registroUsuario($registro){
                $mysqli = Database::getInstance();
                $query=<<<sql
        INSERT INTO user_registro(ctime, user_id, nickname, name_customer, script, ip, modulo,accion) VALUES (now(),:id_user,:nickname,:name_customer,:script,:ip,:modulo,:accion);
sql;
                $params = array(
                    ':id_user'          => $registro->_id_usuario,
                    ':nickname'         => $registro->_nickname,
                    ':name_customer'    => $registro->_customer,
                    ':script'           => $registro->_script,
                    ':ip'               => $registro->_ip,
                    ':modulo'           => $registro->_modulo,
                    ':accion'           => $registro->_accion
                );

                return $mysqli->insert($query, $params);

    }

##################################################### INICIO BUSQUEDA MT #############################################################

	public static function getTotalSearchReporteMT($id, $destination){ # Destination total
		$mysqli = Database::getInstance();
		$id = (int)$id;
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%"
GROUP BY sc.sms_campaign_id
sql;
	
		return $mysqli->queryAll($query);
	}

	public static function getTotalSearchReporteMTCop($id, $destination, $start, $length){ #destination data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrierTotal($id, $carrier){ # Carrier total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrier($id, $carrier, $start, $length){ # Carrier data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopEstatusTotal($id, $estatus){ # Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTEstatus($id, $estatus, $start, $length){ # Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
		//print_r($id);
	}

	public static function getTotalSearchReporteMTCopSourceTotal($id, $source){ # Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTSource($id, $source, $start, $length){ # Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopSourceEstatusTotal($id, $source, $estatus){ # Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTSourceEstatus($id, $source,$estatus, $start, $length){ # Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrierEstatusTotal($id, $carrier, $estatus){ # Carrier & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCarrierEstatus($id, $carrier,$estatus, $start, $length){ # Carrier & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrierSourceTotal($id, $carrier, $source){ # Carrier & Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCarrierSource($id, $carrier,$source, $start, $length){ # Carrier & Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopCarrierSourceEstatusTotal($id, $carrier, $source, $estatus){ # Carrier & Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCarrierSourceEstatus($id, $carrier,$source, $estatus, $start, $length){ # Carrier & Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationEstatusTotal($id, $destination, $estatus){ # Destination & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationEstatus($id, $destination, $estatus, $start, $length){ # Destination & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationSourceTotal($id, $destination, $source){ # Destination & Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationSource($id, $destination, $source, $start, $length){ # Destination & Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationSourceEstatusTotal($id, $destination, $source, $estatus){ # Destination & Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationSourceEstatus($id, $destination, $source, $estatus, $start, $length){ # Destination & Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationCarrierTotal($id, $destination, $carrier){ # Destination & Carrier total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationCarrier($id, $destination, $carrier, $start, $length){ # Destination & Carrier data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationCarrierEstatusTotal($id, $destination, $carrier, $estatus){ # Destination & Carrier & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationCarrierEstatus($id, $destination, $carrier, $estatus, $start, $length){ # Destination & Carrier & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopDestinationCarrierSourceTotal($id, $destination, $carrier, $source){ # Destination & Carrier & Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" 
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTDestinationCarrierSource($id, $destination, $carrier, $source, $start, $length){ # Destination & Carrier & Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopAllTotal($id, $destination, $carrier, $source, $estatus){ # Destination & Carrier & Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTAll($id, $destination, $carrier, $source, $estatus, $start, $length){ # Destination & Carrier & Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER", 
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

############################################################# FIN BUSQUEDA MT ##########################################################

##################################################### BUSQUEDA EN TOTALES ##############################################################

	public static function getTotalMessagesSearch($fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCop($start, $length, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampania($campania, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin' AND c.name LIKE '%$campania%' 
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaCop($campania, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin' AND c.name LIKE '%$campania%' 
GROUP BY c.campaign_id 
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcode($shortcode, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE AND MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND sc.short_code LIKE '%$shortcode%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcodeCop($shortcode, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE AND MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND sc.short_code LIKE '%$shortcode%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchStatus($status, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND cs.name LIKE '%$status%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchStatusCop($status, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND cs.name LIKE '%$status%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchDirection($direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchDirectionCop($direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCode($campania, $shortcode,$fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND sc.short_code LIKE '%$shortcode%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeCop($campania, $shortcode, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND sc.short_code LIKE '%$shortcode%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaStatus($campania, $status,$fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND cs.name LIKE '%$status%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaStatusCop($campania, $status, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND cs.name LIKE '%$status%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaDirection($campania, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaDirectionCop($campania, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcodeStatus($shortcode, $status, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND sc.short_code LIKE '%$shortcode%' 
AND cs.name LIKE '%$status%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcodeStatusCop($shortcode, $status, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND sc.short_code LIKE '%$shortcode%' 
AND cs.name LIKE '%$status%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcodeDirection($shortcode, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND sc.short_code LIKE '%$shortcode%' 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcodeDirectionCop($shortcode, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND sc.short_code LIKE '%$shortcode%' 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeStatus($campania, $shortcode, $status, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND sc.short_code LIKE '%$shortcode%' 
AND cs.name LIKE '%$status%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeStatusCop($campania, $shortcode, $status, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND sc.short_code LIKE '%$shortcode%' 
AND cs.name LIKE '%$status%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

public static function getTotalMessagesSearchCampaniaShortCodeDirection($campania, $shortcode, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND sc.short_code LIKE '%$shortcode%' 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeDirectionCop($campania, $shortcode, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND sc.short_code LIKE '%$shortcode%' 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeStatusDirection($campania, $shortcode, $status, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND sc.short_code LIKE '%$shortcode%'
AND cs.name LIKE '%$status%' 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin' 
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeStatusDirectionCop($campania, $shortcode, $status, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND c.name LIKE '%$campania%' 
AND sc.short_code LIKE '%$shortcode%' 
AND cs.name LIKE '%$status%' 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin' 
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchStatusDirection($status, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND cs.name LIKE '%$status%' 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchStatusDirectionCop($status, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND cs.name LIKE '%$status%' 
AND m.name LIKE '%$direction%' 
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShorCodeStatusDirection($shortcode, $status, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND sc.short_code LIKE '%$shortcode%' 
AND cs.name LIKE '%$status%' 
AND m.name LIKE '%$direction%' AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin' 
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

public static function getTotalMessagesSearchShortCodeStatusDirectionCop($shortcode, $status, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();	
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE MONTH( c.delivery_date ) = MONTH( CURDATE( ) ) 
AND sc.short_code LIKE '%$shortcode%' 
AND cs.name LIKE '%$status%' 
AND m.name LIKE '%$direction%' AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin' 
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}




###################################################### FIM BUSQUEDA TOTALES ############################################################



}