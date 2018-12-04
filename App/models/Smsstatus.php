<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Smsstatus implements Crud{

	public static function insert($data){}
    public static function getById($data){}
    public static function getAll(){}
    public static function update($data){}
    public static function delete($delete){}

    public static function login($data){
    	$mysqli = Database::getInstance();

    	$query =<<<sql
SELECT *
FROM api_web aw
INNER JOIN api_web_ip awip
USING ( api_web_id )
WHERE user = :user
AND pwd = :password
sql;
		$params = array(':user' => $data->_user, ':password' => $data->_password);

		return $mysqli->queryAll($query, $params);
    }

    public static function statusSms($data){
    	$mysqli = Database::getInstance();
    	
    	$query =<<<sql
SELECT
sc.delivery_date,
sms.delivery_time,
CASE
    WHEN sms.status_dlr!='' THEN sms.status_dlr
    WHEN sms.status!='' THEN sms.status
    ELSE sce.estatus
END AS 'estatus'
FROM sms_campaign sc
LEFT JOIN sms ON (sc.campaign_id=sms.campaign_id AND sc.msisdn_log=sms.destination AND sc.content=sms.content AND sms.entry_time>=sc.ctime)
LEFT JOIN sms_campaign_estatus sce ON (sc.sms_campaign_estatus_id=sce.sms_campaign_estatus_id)
LEFT JOIN campaign_customer cc ON (sc.campaign_id=cc.campaign_id)
WHERE sc.sms_campaign_id = :sms_campaign_id AND cc.customer_id = :customer_id
GROUP BY sc.sms_campaign_id
ORDER BY sms.delivery_time
sql;
	
		$params = array(':sms_campaign_id' => $data->_sms_campaign_id, ':customer_id' => $data->_customer_id);

		return $mysqli->queryOne($query,$params);
    }

}