<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ReportesmoCamp implements Crud{

	public static function insert($data){}
    public static function getById($data){}
    public static function getAll(){}
    public static function update($data){}
    public static function delete($delete){}

######## 2018-07-20  Esaú ###############

	public static function getAllCampaignMO($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.campaign_id, c.name, sc.short_code
FROM campaign c
INNER JOIN campaign_customer cc USING(campaign_id)
INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
INNER JOIN carrier_connection_short_code_campaign ccscc USING(campaign_id)
INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
INNER JOIN short_code sc on (sc.short_code_id = ccsc.short_code_id)
WHERE cu.customer_id = :id
GROUP BY c.campaign_id
ORDER BY c.campaign_id DESC
sql;
		return $mysqli->queryAll($query, array(':id' => $id));
	}

	
	public static function getShortCode($customer_id){
		$mysqli = Database::getInstance();
		$query =<<<sql
SELECT short_code
FROM short_code
INNER JOIN carrier_connection_short_code ccsc
USING ( short_code_id )
INNER JOIN custome_carrier_connection_short_code cccsc
USING ( carrier_connection_short_code_id )
WHERE customer_id = :customer_id
GROUP BY short_code
ORDER BY LENGTH( short_code ) ASC
sql;
		return $mysqli->queryAll($query, array(':customer_id'=>$customer_id));
	}



	public static function reportMOTotal($data){
		$params = array(':customer_id' => $data->_customer_id,
						':fecha_inicial' => $data->_fecha_inicial,
						':fecha_fin' => $data->_fecha_fin);

		if (empty($data->_source) && empty($data->_shortcode) && !empty($data->_content)) {
			$params[':content'].= $data->_content;
			$where = " AND sms.content = :content";
		} elseif (empty($data->_source) && !empty($data->_shortcode) && empty($data->_content)) {
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.destination = :destination";
		} elseif (empty($data->_source) && !empty($data->_shortcode) && !empty($data->_content)) {
			$params[':content'].= $data->_content;
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.content = :content AND sms.destination = :destination";
		} elseif (!empty($data->_source) && empty($data->_shortcode) && empty($data->_content)) {
			$params[':source'].= $data->_source;
			$where = " AND sms.source = :source";
		} elseif (!empty($data->_source) && empty($data->_shortcode) && !empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':content'].= $data->_content;
			$where = " AND sms.source = :source AND sms.content = :content";
		} elseif (!empty($data->_source) && !empty($data->_shortcode) && empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.source = :source AND sms.destination = :destination";
		} elseif (!empty($data->_source) && !empty($data->_shortcode) && !empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':destination'].= $data->_shortcode;
			$params[':content'].= $data->_content;
			$where = " AND sms.source = :source AND sms.destination = :destination AND sms.content = :content";
		}

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
WHERE sms.direction='MO' AND c.customer_id = :customer_id
AND sms.entry_time >= :fecha_inicial AND  sms.entry_time <= :fecha_fin
$where
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
sql;

		return $mysqli->queryAll($query, $params);
	}


	public static function reportMOCopTotal($data, $start, $length){
		$params = array(':customer_id' => $data->_customer_id,
						':fecha_inicial' => $data->_fecha_inicial,
						':fecha_fin' => $data->_fecha_fin);

		if (empty($data->_source) && empty($data->_shortcode) && !empty($data->_content)) {
			$params[':content'].= $data->_content;
			$where = " AND sms.content = :content";
		} elseif (empty($data->_source) && !empty($data->_shortcode) && empty($data->_content)) {
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.destination = :destination";
		} elseif (empty($data->_source) && !empty($data->_shortcode) && !empty($data->_content)) {
			$params[':content'].= $data->_content;
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.content = :content AND sms.destination = :destination";
		} elseif (!empty($data->_source) && empty($data->_shortcode) && empty($data->_content)) {
			$params[':source'].= $data->_source;
			$where = " AND sms.source = :source";
		} elseif (!empty($data->_source) && empty($data->_shortcode) && !empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':content'].= $data->_content;
			$where = " AND sms.source = :source AND sms.content = :content";
		} elseif (!empty($data->_source) && !empty($data->_shortcode) && empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.source = :source AND sms.destination = :destination";
		} elseif (!empty($data->_source) && !empty($data->_shortcode) && !empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':destination'].= $data->_shortcode;
			$params[':content'].= $data->_content;
			$where = " AND sms.source = :source AND sms.destination = :destination AND sms.content = :content";
		}

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
WHERE sms.direction='MO' AND c.customer_id = :customer_id
AND sms.entry_time >= :fecha_inicial AND  sms.entry_time <= :fecha_fin
$where
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
LIMIT $start, $length
sql;
	//mail("tecnico@airmovil.com","query mo", $query . print_r($params,1));
		return $mysqli->queryAll($query,$params);
	}


	public static function reportMO($data){
		$params = array(':customer_id' => $data->_customer_id,
						':fecha_inicial' => $data->_fecha_inicial,
						':fecha_fin' => $data->_fecha_fin,
						':campaign_id' => $data->_campaign_id);

		if (empty($data->_source) && empty($data->_shortcode) && !empty($data->_content)) {
			$params[':content'].= $data->_content;
			$where = " AND sms.content = :content";
		} elseif (empty($data->_source) && !empty($data->_shortcode) && empty($data->_content)) {
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.destination = :destination";
		} elseif (empty($data->_source) && !empty($data->_shortcode) && !empty($data->_content)) {
			$params[':content'].= $data->_content;
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.content = :content AND sms.destination = :destination";
		} elseif (!empty($data->_source) && empty($data->_shortcode) && empty($data->_content)) {
			$params[':source'].= $data->_source;
			$where = " AND sms.source = :source";
		} elseif (!empty($data->_source) && empty($data->_shortcode) && !empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':content'].= $data->_content;
			$where = " AND sms.source = :source AND sms.content = :content";
		} elseif (!empty($data->_source) && !empty($data->_shortcode) && empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.source = :source AND sms.destination = :destination";
		} elseif (!empty($data->_source) && !empty($data->_shortcode) && !empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':destination'].= $data->_shortcode;
			$params[':content'].= $data->_content;
			$where = " AND sms.source = :source AND sms.destination = :destination AND sms.content = :content";
		}

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
WHERE sms.direction='MO' AND c.customer_id = :customer_id AND sms.campaign_id = :campaign_id
AND sms.entry_time >= :fecha_inicial AND  sms.entry_time <= :fecha_fin
$where
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
sql;
		return $mysqli->queryAll($query, $params);
	}



	public static function reportMOCop($data, $start, $length){
		$params = array(':customer_id' => $data->_customer_id,
						':fecha_inicial' => $data->_fecha_inicial,
						':fecha_fin' => $data->_fecha_fin,
						':campaign_id' => $data->_campaign_id);

		if (empty($data->_source) && empty($data->_shortcode) && !empty($data->_content)) {
			$params[':content'].= $data->_content;
			$where = " AND sms.content = :content";
		} elseif (empty($data->_source) && !empty($data->_shortcode) && empty($data->_content)) {
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.destination = :destination";
		} elseif (empty($data->_source) && !empty($data->_shortcode) && !empty($data->_content)) {
			$params[':content'].= $data->_content;
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.content = :content AND sms.destination = :destination";
		} elseif (!empty($data->_source) && empty($data->_shortcode) && empty($data->_content)) {
			$params[':source'].= $data->_source;
			$where = " AND sms.source = :source";
		} elseif (!empty($data->_source) && empty($data->_shortcode) && !empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':content'].= $data->_content;
			$where = " AND sms.source = :source AND sms.content = :content";
		} elseif (!empty($data->_source) && !empty($data->_shortcode) && empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':destination'].= $data->_shortcode;
			$where = " AND sms.source = :source AND sms.destination = :destination";
		} elseif (!empty($data->_source) && !empty($data->_shortcode) && !empty($data->_content)) {
			$params[':source'].= $data->_source;
			$params[':destination'].= $data->_shortcode;
			$params[':content'].= $data->_content;
			$where = " AND sms.source = :source AND sms.destination = :destination AND sms.content = :content";
		}

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
WHERE sms.direction='MO' AND c.customer_id = :customer_id AND sms.campaign_id = :campaign_id
AND sms.entry_time >= :fecha_inicial AND  sms.entry_time <= :fecha_fin
$where
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
LIMIT $start, $length
sql;
		//mail("tecnico@airmovil.com","query mo x campaign_id", $query . print_r($params,1));
		return $mysqli->queryAll($query, $params);
	}



######### 2018-07-20 Esaú #################
} // fin de clase.
