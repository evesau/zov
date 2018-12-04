<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Control implements Crud{

	public static function getAll(){

	$mysqli = Database::getInstance();
		$query=<<<sql
		SHOW TABLES FROM sms
sql;
		return $mysqli->queryAll($query);
    }

	public static function getById($id){}
	public static function insert($data){}
	public static function update($data){}
	public static function delete($id){}

	public static function truncate(){
		$mysqli = Database::getInstance();
		$query = <<<sql
TRUNCATE TABLE test
sql;
		return $mysqli->queryAll($query);
	}
}