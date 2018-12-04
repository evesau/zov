<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ResponseMo implements Crud{
    /**************************************/
    public static function getAll(){}

    public static function getWebHook($data){
	   $mysqli = Database::getInstance();
       $query=<<<sql
SELECT * 
FROM  `campaign_customer` 
INNER JOIN webhook
USING ( customer_id ) 
WHERE campaign_id = $data->_campaign_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getWebHookTest($data){

    $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * 
FROM  `campaign_customer` 
INNER JOIN webhook
USING ( customer_id ) 
WHERE campaign_id = :campaign_id
sql;
        return $mysqli->queryOne($query, array(':campaign_id'=>$data->_campaign_id));
    }


    public static function getById($data){
	$mysqli = Database::getInstance();
        $query=<<<sql
SELECT *  FROM `sms` 
WHERE `destination` = '$data->_from'
AND entry_time > DATE_SUB( '2018-02-13 09:00:03' , INTERVAL 24 HOUR )
AND source = '$data->_to'
ORDER BY entry_time DESC 
LIMIT 1;
sql;
        return $mysqli->queryOne($query);
    }

    public static function getByIdTest($data){
    $mysqli = Database::getInstance();
        $query=<<<sql
SELECT *  FROM `sms` 
WHERE `destination` = '$data->_from'
AND entry_time > DATE_SUB( NOW() , INTERVAL 24 HOUR )
AND source = '$data->_to'
ORDER BY entry_time DESC 
LIMIT 1;
sql;
        return $mysqli->queryOne($query);
    }

    public static function insert($data){

	$mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `sms` (entry_time, campaign_id, service_id, source, destination, content, direction, status, message_id, carrier_connection_short_code_id, carrier)
VALUES (
NOW(),
:campaign_id,
:service_id,
:source,
:destination,
:content,
:direction,
:status,
-1,
:carrier_connection_short_code_id,
:carrier
)
sql;

	$params = array(':campaign_id'=>$data->_campaign_id,
		':service_id'=>-1,
		':source'=>$data->_from,
		':destination'=>$data->_to,
		':content'=>$data->_text,
		':direction'=>'MO',
		':status'=>'received',
		':carrier_connection_short_code_id'=>$data->_carrier_connection_short_code_id,
		':carrier'=>$data->_carrier
	);

      return $mysqli->insert($query, $params);
    }

    public static function update($data){}
    public static function delete($id){}
    /**************************************/
}
