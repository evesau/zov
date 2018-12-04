<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class TestGraphs implements Crud{
    
    public static function getTotalTelcel(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT * 
FROM sms 
INNER JOIN carrier_connection_short_code ccsc using (carrier_connection_short_code_id)
INNER JOIN carrier c on (ccsc.carrier_id = c.carrier_id)
WHERE c.carrier_id = 1 AND MONTH(sms.entry_time) = MONTH(CURDATE());
sql;

		return $mysqli->queryAll($query);
	}

	public static function getTotalMovistar(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT * 
FROM sms 
INNER JOIN carrier_connection_short_code ccsc using (carrier_connection_short_code_id)
INNER JOIN carrier c on (ccsc.carrier_id = c.carrier_id)
WHERE c.carrier_id = 2 AND MONTH(sms.entry_time) = MONTH(CURDATE());
sql;

		return $mysqli->queryAll($query);
	}

	public static function getTotalATT(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT * 
FROM sms 
INNER JOIN carrier_connection_short_code ccsc using (carrier_connection_short_code_id)
INNER JOIN carrier c on (ccsc.carrier_id = c.carrier_id)
WHERE c.carrier_id = 3 AND MONTH(sms.entry_time) = MONTH(CURDATE());
sql;

		return $mysqli->queryAll($query);
	}

    public static function getAllMT_Telcel(){
    	$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time as FECHA, ca.name AS CARRIER, sms.direction as DIRECTION, sms.destination as DESTINATION, sc.short_code as SHORTCODE, sms.content as CONTENT, sms.status as "ESTATUSSMS"
FROM campaign c
INNER JOIN modules m USING (modules_id)
INNER JOIN campaign_status cs USING (campaign_status_id)
INNER JOIN carrier_connection_short_code_campaign ccscc USING (campaign_id)
INNER JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = ccscc.carrier_connection_short_code_id
INNER JOIN carrier_connection cc ON cc.carrier_connection_id = ccsc.carrier_connection_id
INNER JOIN short_code sc ON sc.short_code_id = ccsc.short_code_id
INNER JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
INNER JOIN sms_campaign smsca USING (campaign_id)
INNER JOIN sms_campaign_estatus smscaes ON smscaes.sms_campaign_estatus_id = smsca.sms_campaign_estatus_id
INNER JOIN sms USING (campaign_id)
INNER JOIN service ser USING (campaign_id)
WHERE ca.carrier_id= 1 AND sms.direction="MT" AND MONTH(sms.entry_time) = MONTH(CURDATE());
GROUP BY sms.sms_id
sql;
		return $mysqli->queryAll($query);
    }

    public static function getAllMO_Telcel(){
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
INNER JOIN carrier_connection_short_code ccsc on (ccsc.carrier_connection_short_code_id = sms.carrier_connection_short_code_id)
INNER JOIN carrier ca on (ca.carrier_id = ccsc.carrier_id)
WHERE sms.direction='MO' AND ca.carrier_id = 1 AND MONTH(sms.entry_time) = MONTH(CURDATE());
GROUP BY sms.sms_id
sql;
		return $mysqli->queryAll($query);
    }

    public static function getAllMT_Movistar(){
    	$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time as FECHA, ca.name AS CARRIER, sms.direction as DIRECTION, sms.destination as DESTINATION, sc.short_code as SHORTCODE, sms.content as CONTENT, sms.status as "ESTATUSSMS"
FROM campaign c
INNER JOIN modules m USING (modules_id)
INNER JOIN campaign_status cs USING (campaign_status_id)
INNER JOIN carrier_connection_short_code_campaign ccscc USING (campaign_id)
INNER JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = ccscc.carrier_connection_short_code_id
INNER JOIN carrier_connection cc ON cc.carrier_connection_id = ccsc.carrier_connection_id
INNER JOIN short_code sc ON sc.short_code_id = ccsc.short_code_id
INNER JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
INNER JOIN sms_campaign smsca USING (campaign_id)
INNER JOIN sms_campaign_estatus smscaes ON smscaes.sms_campaign_estatus_id = smsca.sms_campaign_estatus_id
INNER JOIN sms USING (campaign_id)
INNER JOIN service ser USING (campaign_id)
WHERE ca.carrier_id= 2 AND sms.direction="MT" AND MONTH(sms.entry_time) = MONTH(CURDATE());
GROUP BY sms.sms_id
sql;
		return $mysqli->queryAll($query);
    }
    
    public static function getAllMO_Movistar(){
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
INNER JOIN carrier_connection_short_code ccsc on (ccsc.carrier_connection_short_code_id = sms.carrier_connection_short_code_id)
INNER JOIN carrier ca on (ca.carrier_id = ccsc.carrier_id)
WHERE sms.direction='MO' AND ca.carrier_id = 2 AND MONTH(sms.entry_time) = MONTH(CURDATE());
GROUP BY sms.sms_id
sql;
		return $mysqli->queryAll($query);	
    }

    public static function getAllMT_Att(){
    	$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time as FECHA, ca.name AS CARRIER, sms.direction as DIRECTION, sms.destination as DESTINATION, sc.short_code as SHORTCODE, sms.content as CONTENT, sms.status as "ESTATUSSMS"
FROM campaign c
INNER JOIN modules m USING (modules_id)
INNER JOIN campaign_status cs USING (campaign_status_id)
INNER JOIN carrier_connection_short_code_campaign ccscc USING (campaign_id)
INNER JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = ccscc.carrier_connection_short_code_id
INNER JOIN carrier_connection cc ON cc.carrier_connection_id = ccsc.carrier_connection_id
INNER JOIN short_code sc ON sc.short_code_id = ccsc.short_code_id
INNER JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
INNER JOIN sms_campaign smsca USING (campaign_id)
INNER JOIN sms_campaign_estatus smscaes ON smscaes.sms_campaign_estatus_id = smsca.sms_campaign_estatus_id
INNER JOIN sms USING (campaign_id)
INNER JOIN service ser USING (campaign_id)
WHERE ca.carrier_id= 3 AND sms.direction="MT" AND MONTH(sms.entry_time) = MONTH(CURDATE());
GROUP BY sms.sms_id
sql;
		return $mysqli->queryAll($query);
    }

    public static function getAllMO_Att(){
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
INNER JOIN carrier_connection_short_code ccsc on (ccsc.carrier_connection_short_code_id = sms.carrier_connection_short_code_id)
INNER JOIN carrier ca on (ca.carrier_id = ccsc.carrier_id)
WHERE sms.direction='MO' AND ca.carrier_id = 3 AND MONTH(sms.entry_time) = MONTH(CURDATE());
GROUP BY sms.sms_id
sql;
		return $mysqli->queryAll($query);
    }

	public static function getAll(){}
	public static function getById($user){}
    public static function insert($param){}
	public static function update($param){}
    public static function delete($param){}
}