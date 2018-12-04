<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Blacklist implements Crud{

	public static function getByCarrierTelcel($blacklist){

		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT blacklist_telcel_id FROM blacklist_telcel WHERE number = :number;
sql;

		$params = array(':number' => $blacklist);
		return $mysqli->queryAll($query,$params);
	}

	public static function getByCarrierMovistar($blacklist){

		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT blacklist_telcel_id FROM blacklist_movistar WHERE number = :number;
sql;

		$params = array(':number' => $blacklist);
		return $mysqli->queryAll($query,$params);
	}

	public static function getByCarrierAtt($blacklist){
		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT blacklist_telcel_id FROM blacklist_att WHERE number = :number;
sql;

		$params = array(':number' => $blacklist);
		return $mysqli->queryAll($query,$params);
	}

	public static function insert($msisdn){
		$mysqli = Database::getInstance();
		$query = <<<sql
INSERT IGNORE INTO blacklist_telcel(date_entered, number)
VALUES (NOW(),:msisdn);
sql;

		return $mysqli->insert($query, array(':msisdn' => '52'.$msisdn));
	}

	public static function insertMovistar($msisdn){
		$mysqli = Database::getInstance();
		$query = <<<sql
INSERT IGNORE INTO blacklist_movistar(date_entered, number)
VALUES (NOW(),:msisdn);
sql;

		return $mysqli->insert($query, array(':msisdn' => '52'.$msisdn));
		
	}

	public static function insertAtt($msisdn){
		$mysqli = Database::getInstance();
		$query = <<<sql
INSERT IGNORE INTO blacklist_att(date_entered, number)
VALUES (NOW(),:msisdn);
sql;

		return $mysqli->insert($query, array(':msisdn' => '52'.$msisdn));
	
	}

    public static function getById($param){}
	public static function getAll(){}
	public static function update($param){}
    public static function delete($param){}

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
}