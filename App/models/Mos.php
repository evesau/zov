<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Mos implements Crud{

	public static function insert($data){
		$mysqli = Database::getInstance(1,1);
		$query =<<<sql
INSERT INTO la_voz_mexico_sms(entry_time, source, destination, content, direction, status, gateway_message_id) 
VALUES (NOW(), :source, :destination, :content, 'MO', 'delivered', :carrier)
sql;
		$params = array(
				':source' => $data->_source,
				':destination' => $data->_msisdn,
				':content' => $data->_content,
				':carrier' => $data->_carrier
				);
		return $mysqli->insert($query, $params);
	}

	public static function update($param){}
	public static function delete($id){}
   	public static function getById($param){}
    	public static function getAll(){}

}
