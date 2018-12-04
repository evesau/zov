<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ReportesApiTest implements Crud{

	public static function getAll(){}
	public static function insert($msisdn){}
	public static function update($msisdn){}
	public static function delete($msisdn){}
    public static function getById($param){}
    

    /*******OBTENCION DE CAMPAÑAS*********/
	public static function getAllCampaignApi($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
		SELECT 
			c.campaign_id, 
			c.name AS name_campaign, 
			c.delivery_date, 
			sc.short_code
		FROM campaign AS c
		INNER JOIN campaign_api_web AS caw USING (campaign_id)
		INNER JOIN campaign_customer cc using(campaign_id)
		INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
		INNER JOIN carrier_connection_short_code_campaign ccscc using(campaign_id)
		INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
		INNER JOIN short_code sc on (sc.short_code_id = ccsc.short_code_id)
		WHERE cu.customer_id = $id AND MONTH(c.delivery_date) = MONTH(CURDATE())
		GROUP BY c.campaign_id
sql;
		//mail('jorge.manon@airmovil.com','Query Reportes','Query API Reporte: '.$query);
		return $mysqli->queryAll($query);
	}

	/************OBTENCION DE LA CAMPAÑA MAS RECIENTE************/
	public static function getMaxCampaign($customer_id){
		$mysqli = Database::getInstance();
		$query = <<<sql
		SELECT 
			MAX(c.campaign_id)
		FROM campaign AS c
		INNER JOIN campaign_api_web AS caw USING (campaign_id)
		INNER JOIN campaign_customer cc using(campaign_id)
		INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
		INNER JOIN carrier_connection_short_code_campaign ccscc using(campaign_id)
		INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
		INNER JOIN short_code sc on (sc.short_code_id = ccsc.short_code_id)
		WHERE cu.customer_id = $customer_id AND MONTH(c.delivery_date) = MONTH(CURDATE())
		GROUP BY c.campaign_id
sql;
		//mail('jorge.manon@airmovil.com','Query Reportes','Query: '.$query);
		return $mysqli->queryOne($query);
	}

	/*******CONSULTA DE MENSAJES******/
	public static function getDataSMSApi($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
		SELECT ca.name AS "CARRIER",
		IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
		IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
		IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
		IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
		IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE",
		direction AS DIRECCION
		FROM sms_campaign sc
		JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
		JOIN sms s ON ( ms.msisdn = s.destination )
		JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
		JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
		JOIN short_code sco USING ( short_code_id )
		JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
		JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
		WHERE direction = 'MT' AND cc.customer_id = $datos->customer_id
		$datos->where
sql;
		//mail('jorge.manon@airmovil.com', 'Query Reportes', 'Query reportes mt api: '.$query);
		return $mysqli->queryAll($query);

	}

}










