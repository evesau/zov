<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Reportesclicks implements Crud{

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
un.value AS CODE_UNIQUE,
IF(sms.status_dlr ='', IF(sms.status is null, sce.estatus, sms.status),sms.status_dlr) AS ESTATUS
FROM campaign c
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN campaign_carrier_short_code ccsc USING (campaign_id)
LEFT JOIN sms_campaign sca ON (sca.campaign_id=c.campaign_id)
LEFT JOIN sms ON (sms.campaign_id=c.campaign_id AND sca.msisdn_log=sms.destination)
INNER JOIN sms_campaign_estatus sce ON (sca.sms_campaign_estatus_id=sce.sms_campaign_estatus_id)
INNER JOIN url ON (url.campaign_id=c.campaign_id AND sca.msisdn_log = url.msisdn)
INNER JOIN `unique` un ON (un.unique_id=url.unique_id)
INNER JOIN carrier ON (carrier.carrier_id=ccsc.carrier_id)
INNER JOIN short_code sc ON (sc.short_code_id=ccsc.short_code_id)
$data->where
GROUP BY sca.sms_campaign_id;
sql;

        //$params = array(':where' => $data->where );
        //mail('esau.espinoza@airmovil.com', 'Query Reportes url', $query,print_r($params,1));
		return $mysqli->queryAll($query);
    }

    public static function getTotalClicks($customer_id,$fecha_inicio,$fecha_fin){
        $mysqli = Database::getInstance();
        if ($fecha_inicio!='' && $fecha_fin!='') {
            $masWhere =<<<sql
AND c.created BETWEEN '$fecha_inicio' AND '$fecha_fin'
sql;
        }
        
        $query =<<<sql
SELECT 
c.created, 
c.campaign_id, 
c.name as campania, 
sc.short_code,
(SELECT count( * ) AS total FROM sms WHERE `campaign_id` =c.campaign_id) as total_enviados, 
count(us.unique_id) as clicks
FROM campaign c
INNER JOIN url USING (campaign_id)
LEFT JOIN url_sync us USING (url_id)
INNER JOIN carrier_connection_short_code_campaign ccscc ON ( url.campaign_id=ccscc.campaign_id)
INNER JOIN carrier_connection_short_code ccsc ON (ccsc.carrier_connection_short_code_id=ccscc.carrier_connection_short_code_id)
INNER JOIN short_code sc USING (short_code_id)
WHERE url.customer_id= $customer_id $masWhere
GROUP BY url.campaign_id
sql;

        //print_r($query);

        return $mysqli->queryAll($query);
    }


    public static function getDetalleClick($campaign_id){
        $mysqli = Database::getInstance();
        $query =<<< sql
SELECT
IF(us.ctime is null, url.ctime,us.ctime) as fecha,
msisdn,
sco.short_code,
IF(sms.content is null, sc.content, sms.content) as mensaje,
IF(us.unique_id is null, url.unique_id, us.unique_id) as unique_id, 
IF(us.unique_id is null, (SELECT `value` FROM `unique` WHERE unique_id=url.unique_id), un.value )as code_unique,
url.url as url_origin, 
(SELECT count(unique_id) from url_sync WHERE unique_id=us.unique_id) as click
FROM url 
LEFT JOIN url_sync us USING (url_id)
LEFT JOIN `unique` un ON (un.unique_id=us.unique_id)
LEFT JOIN sms_campaign sc ON (url.campaign_id=sc.campaign_id)
LEFT JOIN sms ON (url.campaign_id=sms.campaign_id AND url.msisdn=sms.destination)
INNER JOIN carrier_connection_short_code_campaign ccscc ON ( url.campaign_id=ccscc.campaign_id)
INNER JOIN carrier_connection_short_code ccsc ON (ccsc.carrier_connection_short_code_id=ccscc.carrier_connection_short_code_id)
INNER JOIN short_code sco USING (short_code_id)
WHERE url.campaign_id = $campaign_id
GROUP BY url.url_id
sql;

        return $mysqli->queryAll($query);
    }


    public static function getCampania($campaign_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM campaign WHERE campaign_id=:campaign_id
sql;

        return $mysqli->queryOne($query, array(':campaign_id' => $campaign_id ));
    }

}
