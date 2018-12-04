<?php
namespace App\models;
//defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Consultasoap implements Crud
{
	public static function getAll(){}

    public static function getById($id){}

    public static function insert($usr){}

    public static function update($data){}

    public static function delete($data){}

    public static function buscaMt($data){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM `sms_campaign` WHERE `campaign_id` = 349 AND `ctime` >= '2018-08-31 00:00:00' AND ctime < '2018-09-01 00:00:00' AND `msisdn_log` = :msisdn ORDER BY sms_campaign_id ASC
sql;
        $params = array(':msisdn' => $data->msisdn);
        $registro = $mysqli->queryAll($query,$params);
        return $registro;
    }

    public static function getStatusSms($sms_campaign_id){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT
IF( s.status_dlr ='',
    IF (s.status IS NULL, sce.estatus, s.status ), s.status_dlr) AS sms_estatus,
IF( c.name IS NULL,  'sin carrier', c.name ) AS carrier,
sce.estatus,
sc.campaign_id,
sc.msisdn_log
FROM sms_campaign sc
LEFT JOIN sms s ON ( s.campaign_id = sc.campaign_id
AND sc.msisdn_log = s.destination )
LEFT JOIN sms_campaign_estatus sce ON ( sc.sms_campaign_estatus_id = sce.sms_campaign_estatus_id )
LEFT JOIN msisdn m ON ( sc.msisdn_id = m.msisdn_id )
LEFT JOIN carrier c ON ( c.carrier_id = m.carrier_id )
WHERE sc.sms_campaign_id =$sms_campaign_id
GROUP BY sc.sms_campaign_id
sql;
        return $mysqli->queryOne($query);
    }

}