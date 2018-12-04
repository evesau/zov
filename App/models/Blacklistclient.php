<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;


class Blacklistclient implements Crud{

	public static function getByCarrierTelcel($blacklist,$customer_id){
		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT blacklist_telcel_client_id FROM blacklist_telcel_client WHERE number = $blacklist AND customer_id=$customer_id
sql;
		
		return $mysqli->queryAll($query);
	}

	public static function getByCarrierMovistar($blacklist,$customer_id){

		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT blacklist_movistar_client_id FROM blacklist_movistar_client WHERE number = :number AND customer_id=:customer_id
sql;

		$params = array(':number' => $blacklist, ':customer_id' => $customer_id);
		
		return $mysqli->queryAll($query,$params);
	}

	public static function getByCarrierAtt($blacklist,$customer_id){
		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT blacklist_att_client_id FROM blacklist_att_client WHERE number = :number AND customer_id=:customer_id
sql;

		$params = array(':number' => $blacklist, ':customer_id' => $customer_id);

		return $mysqli->queryAll($query,$params);
	}

	public static function insertTelcel($msisdn,$customer_id){
		$mysqli = Database::getInstance();
		$query = <<<sql
INSERT IGNORE INTO blacklist_telcel_client(date_entered, number, customer_id)
VALUES (NOW(),:msisdn,:customer_id)
sql;

		return $mysqli->insert($query, array(':msisdn' => '52'.$msisdn, ':customer_id' => $customer_id));
	}

	public static function insertMovistar($msisdn,$customer_id){
		$mysqli = Database::getInstance();
		$query = <<<sql
INSERT IGNORE INTO blacklist_movistar_client(date_entered, number, customer_id)
VALUES (NOW(),:msisdn,:customer_id)
sql;

		return $mysqli->insert($query, array(':msisdn' => '52'.$msisdn, ':customer_id' => $customer_id));
		
	}

	public static function insertAtt($msisdn,$customer_id){
		$mysqli = Database::getInstance();
		$query = <<<sql
INSERT IGNORE INTO blacklist_att_client(date_entered, number, customer_id)
VALUES (NOW(),:msisdn,:customer_id)
sql;

		return $mysqli->insert($query, array(':msisdn' => '52'.$msisdn, ':customer_id' => $customer_id));
	
	}

    public static function getById($param){}
	public static function getAll(){}
	public static function update($param){}
    public static function delete($param){}
    public static function insert($params){}

    public static function registroUsuario($registro)
    {
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

    public static function getBlacklistTelcel($msisdn, $customer_id){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT * FROM blacklist_telcel_client WHERE number = :msisdn AND customer_id =:customer_id
sql;

		return $mysqli->queryOne($query, array(':msisdn' => '52'.$msisdn, ':customer_id' => $customer_id));
    }

    public static function getBlacklistMovistar($msisdn, $customer_id){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT * FROM blacklist_movistar_client WHERE number = :msisdn AND customer_id =:customer_id
sql;

		return $mysqli->queryOne($query, array(':msisdn' => '52'.$msisdn, ':customer_id' => $customer_id));
    }

    public static function getBlacklistAtt($msisdn, $customer_id){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT * FROM blacklist_att_client WHERE number = :msisdn AND customer_id =:customer_id
sql;

		return $mysqli->queryOne($query, array(':msisdn' => '52'.$msisdn, ':customer_id' => $customer_id));
    }

    public static function getBlacklistTotal($customer_id){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT 
IF( bac.date_entered IS NULL , 
    IF( bmc.date_entered IS NULL , btc.date_entered, bmc.date_entered ) ,
        btc.date_entered ) AS fecha , 
IF( bac.number IS NULL ,
    IF( bmc.number IS NULL , btc.number, bmc.number) ,
        btc.number ) as msisdn
FROM blacklist_telcel_client btc
LEFT JOIN blacklist_movistar_client bmc ON ( btc.customer_id = bmc.customer_id
AND btc.number = bmc.number )
LEFT JOIN blacklist_att_client bac ON ( btc.customer_id = bac.customer_id
AND btc.number = bac.number )
WHERE bac.customer_id=$customer_id OR bmc.customer_id=$customer_id OR btc.customer_id=$customer_id
sql;
		return $mysqli->queryAll($query);
    }

    public static function deleteBlacklistTelcel($id){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
DELETE FROM blacklist_telcel_client WHERE blacklist_telcel_client_id=$id
sql;
		return $mysqli->delete($query);
    }


    public static function deleteBlacklistMovistar($id){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
DELETE FROM blacklist_movistar_client WHERE blacklist_movistar_client_id=$id
sql;
		return $mysqli->delete($query);
    }


    public static function deleteBlacklistAtt($id){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
DELETE FROM blacklist_att_client WHERE blacklist_att_client_id=$id
sql;
		return $mysqli->delete($query);
    }


}