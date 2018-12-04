<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Reportesurl implements Crud{

    public static function getById($param){}
    public static function getAll(){}
    public static function insert($data){}
    public static function update($data){}
    public static function delete($data){}

    public static function getAllCampaignUrl($customer_id){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT campaign_id, name, short_code
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN campaign_carrier_short_code ccsc USING ( campaign_id )
INNER JOIN url USING ( campaign_id )
INNER JOIN short_code sc ON ( ccsc.short_code_id = sc.short_code_id )
WHERE cc.customer_id =:customer_id
GROUP BY campaign_id;
sql;
        $params = array(':customer_id' => $customer_id );
		return $mysqli->queryAll($query,$params);
    }

    public static function getReporteGeneral($data){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT
IF(sms.delivery_time is null, sca.delivery_date, sms.delivery_time) AS FECHA,
carrier.name AS CARRIER,
IF(sms.destination is null, sca.msisdn_log, sms.destination) AS DESTINATION,
sc.short_code AS SHORT_CODE,
IF(sms.content is null, sca.content, sms.content) AS CONTENT,
url.url AS URL,
IF(un.unique_id=url.unique_id,un.value,url.unique_id) AS CODE_UNIQUE,
IF(sms.status_dlr ='', IF(sms.status is null, sce.estatus, sms.status),sms.status_dlr) AS ESTATUS
FROM campaign c
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN campaign_carrier_short_code ccsc USING (campaign_id)
LEFT JOIN sms_campaign sca ON (sca.campaign_id=c.campaign_id)
LEFT JOIN sms ON (sms.campaign_id=c.campaign_id AND sca.msisdn_log=sms.destination AND sca.content=sms.content)
INNER JOIN sms_campaign_estatus sce ON (sca.sms_campaign_estatus_id=sce.sms_campaign_estatus_id)
INNER JOIN url ON (url.campaign_id=sca.campaign_id AND sca.msisdn_log = url.msisdn)
INNER JOIN `unique` un ON (un.unique_id=url.unique_id)
INNER JOIN carrier ON (carrier.carrier_id=ccsc.carrier_id)
INNER JOIN short_code sc ON (sc.short_code_id=ccsc.short_code_id)
$data->where
GROUP BY sca.sms_campaign_id
sql;
//sca.sms_campaign_id
        //$params = array(':where' => $data->where );
        //mail('esau.espinoza@airmovil.com', 'Query Reportes url', $query,print_r($params,1));
		return $mysqli->queryAll($query);
    }

}
