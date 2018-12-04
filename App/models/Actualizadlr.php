<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Actualizadlr implements Crud
{
	public static function getAll(){
		$mysqli = Database::getInstance();
		$query =<<<sql
sql;

		return $mysqli->queryAll($query);
	}

    public static function getById($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT *
FROM `sms`
WHERE `campaign_id` =:campaign_id
AND `status_dlr` = ''
AND `status` = 'delivered'
AND `direction` = 'MT'
AND MONTH( entry_time ) >= MONTH( curdate( ) )
AND entry_time <= ( now( ) - INTERVAL 1 HOUR )
ORDER BY `sms`.`entry_time` DESC
sql;
        $registros = $mysqli->queryAll($query, array(':campaign_id'=> $id));
//mail("tecnico@airmovil.com","getById actualizacarrierDao",$query."--".$id.print_r($registros,1));
        return $registros;
    }

    public static function insert($usr){}

    public static function update($data){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
sql;

		return $mysqli->update();
    }

    public static function delete($data){}

    public static function buscaMt($data){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT *
FROM `sms`
WHERE `source` LIKE :source
AND `destination` =:msisdn
AND content LIKE :content
AND status_dlr = ''
AND carrier = ''
AND entry_time <= (:entry_time - INTERVAL 5 MINUTE)
sql;
        $params = array(':source' => $data->source,
                        ':msisdn' => $data->msisdn,
                        ':content' => "%".$data->content."%",
                        ':entry_time' => $data->entry_time);

        $registro = $mysqli->queryOne($query,$params);
        //mail("tecnico@airmovil.com","buscaMt",$query.print_r($params,1), print_r($registro,1));
        return $registro;
    }


    public static function updateSms($data){
        $mysqli = Database::getInstance();
        $query =<<<sql
UPDATE sms SET status_dlr=:status_dlr, carrier=:carrier WHERE sms_id=:sms_id
sql;

        $params = array(':status_dlr' => $data->status_dlr,
                        ':carrier' => $data->carrier,
                        ':sms_id' => $data->sms_id);

        $update = $mysqli->update($query, $params);

        return $update;
    }


    public static function updateMsisdn($msisdn, $carrier_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO msisdn (msisdn, carrier_id) VALUES (:msisdn,:carrier_id)
ON DUPLICATE KEY UPDATE msisdn=:msisdn, carrier_id=:carrier_id
sql;

        $params = array(':msisdn' => $msisdn, ':carrier_id' => $carrier);

        return $mysqli->update($query,$params);
    }

}