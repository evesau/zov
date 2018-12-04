<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Reportes implements Crud{

	public static function insert($param){}
	public static function update($param){}
	public static function delete($id){}
    public static function getById($param){}
    public static function getAll(){}

    public static function getTotalMessages($data){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT *  FROM la_voz_mexico_sms WHERE entry_time >= :fecha_inicial AND entry_time <= :fecha_final AND content NOT LIKE 'id:%' AND direction = 'MO'
sql;

		$params = array(
						':fecha_inicial' => $data->fecha_inicial,
						':fecha_final' => $data->fecha_final
		);

		return $mysqli->queryAll($query, $params);

    }

    public static function getTotalMessagesList($data, $start, $length){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT entry_time, source, destination, content FROM la_voz_mexico_sms WHERE entry_time >= :fecha_inicial AND entry_time <= :fecha_final AND content NOT LIKE 'id:%' AND direction = 'MO'
ORDER BY entry_time DESC
LIMIT $start, $length
sql;

		$params = array(
						':fecha_inicial' => $data->fecha_inicial,
						':fecha_final' => $data->fecha_final
		);

		return $mysqli->queryAll($query, $params);

    }

}










