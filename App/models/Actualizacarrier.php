<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Actualizacarrier implements Crud
{
	public static function getAll(){
		$mysql = Database::getInstance();
		$query =<<<sql
SELECT * FROM msisdn WHERE carrier_id NOT IN ( 1, 2, 3 , -1 ) AND mtime < curdate() limit 50
sql;

		return $mysql->queryAll($query);
	}

    public static function getById($id){}

    public static function insert($usr){}

    public static function update($data){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
UPDATE msisdn SET carrier_id=:carrier_id WHERE msisdn_id=:msisdn_id
sql;

		return $mysqli->update($query,array(':carrier_id' => $data->_carrier_id, ':msisdn_id' => $data->_msisdn_id));
    }

    public static function delete($data){}

}