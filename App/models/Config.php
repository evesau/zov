<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Config implements Crud{

	public static function getAll(){}
	public static function getById($user){}

    public static function insert($param){
		$mysql = Database::getInstance();
		$query =<<<sql
INSERT INTO pig_config(ctime, status, mensaje_rcs, mensaje_sms, pin_tipo, pin_longitud, pin_expiracion, pin_expiracion_tipo, pin_marca) VALUES(NOW(), 1, :mensaje_rcs, :mensaje_sms, :pin_tipo, :pin_longitud, :pin_expiracion, :pin_expiracion_tipo, :pin_marca) 
sql;
		$array = array(
			':mensaje_rcs'=>$param->_mensaje_rcs,
			':mensaje_sms'=>$param->_mensaje_sms,
			':pin_tipo'=>$param->_pin_tipo,
			':pin_longitud'=>$param->_pin_longitud,
			':pin_expiracion'=>$param->_pin_expiracion,
			':pin_expiracion_tipo'=>$param->_pin_expiracion_tipo,
			':pin_marca'=>$param->_pin_marca
		);

		$result = $mysql->insert($query, $array);
		if($result < 1)
			mail('cesar.cortes@airmovil.com', "Config/insert/", print_r($array, 1) . " - query=>\n " . $query);
		
		return $result;
    }

	public static function update($param){}
    public static function delete($param){}

    public static function getPIN(){
		$mysql = Database::getInstance();
		$query = <<<sql
SELECT * FROM pig_config ORDER BY ctime DESC LIMIT 1 
sql;
		return $mysql->queryOne($query);
    }

}