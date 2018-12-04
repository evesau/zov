<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Query implements Crud{

    public static function getAll(){
		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT * FROM deferred_sms
sql;
		return $mysqli->queryAll($query);
    }

    public static function getData(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT * FROM `deferred_sms` AS ds 
INNER JOIN carrier_connection_short_code AS ccsc USING ( carrier_connection_short_code_id ) 
INNER JOIN carrier_connection AS cc USING ( carrier_connection_id ) 
INNER JOIN short_code AS sc USING ( short_code_id ) 
INNER JOIN campaign_customer AS cac ON ( ds.campaign_id = cac.campaign_id AND ds.customer_id = cac.customer_id ) 
INNER JOIN customer_modules AS cm ON ( ds.customer_id = cm.customer_id AND ds.modules_id = cm.modules_id ) 
INNER JOIN customer AS c ON ( ds.customer_id = c.customer_id ) 
WHERE ds.modules_id = 5
sql;
		return $mysqli->queryAll($query);
    }


    public static function getById($param){}
    public static function insert($param){}
	public static function update($param){}
    public static function delete($param){}

}
