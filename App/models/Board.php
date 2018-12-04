<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Board implements Crud{

	public static function getAll(){
		$mysqli = Database::getInstance();
		$query=<<<sql
sql;
		return $mysqli->queryAll($query);
	}

	public static function getById($id){
		$mysqli = Database::getInstance();
		$query =<<<sql
SELECT *  FROM customer WHERE customer_id = $id 
sql;
		return $mysqli->queryOne($query);
	}
	public static function insert($data){}
	public static function update($data){}
	public static function delete($id){}

	public static function getAllListCustomersAsigned($customer_id){
		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT c.customer_id, u.user_id, c.name AS name_customer, c.img AS image_customer, u.nickname AS user_master  FROM customer_parent AS cp 
INNER JOIN customer AS c ON (c.customer_id = cp.customer_child_id) 
INNER JOIN user_customer_parent AS ucp ON (ucp.customer_id = c.customer_id) 
INNER JOIN user AS u ON (u.user_id = ucp.user_id)
WHERE cp.customer_id = :customer_id
sql;
		return $mysqli->queryAll($query, array(':customer_id'=>$customer_id));
	}

	public static function getMasterUserCustomer($customer_id, $user_id){
		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT u.user_id, c.customer_id, u.nickname, u.first_name, u.last_name, u.password, c.name AS name_customer, c.img FROM user_customer_parent AS ucp 
INNER JOIN user AS u USING (user_id)
INNER JOIN customer AS c USING(customer_id)
WHERE u.user_id = :user_id AND c.customer_id = :customer_id
sql;
		$params = array(
			':user_id'=>$user_id,
			':customer_id'=>$customer_id
		);
		return $mysqli->queryOne($query, $params);
	}

	public static function getReportCountMonth($mes, $customer_id, $section){
		$table = "";
		if($section == 1) // ATT
			$table.= "total_envios_att_customer_delivered_anual";
		if($section == 2) // MOVISTAR
			$table.= "total_envios_movistar_customer_delivered_anual";
		if($section == 3) // TELCEL
			$table.= "total_envios_telcel_customer_delivered_anual";
		
		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT * FROM $table 
WHERE mes = :mes AND customer_id = :customer_id
sql;
		$params = array(
			':mes'=>$mes,
			':customer_id'=>$customer_id
		);

		return $mysqli->queryOne($query, $params);
	}

	public static function getReportCountMonthTotal($customer_id, $section){
		$table = "";
		if($section == 1) // ATT
			$table.= "total_envios_att_customer_delivered_anual";
		if($section == 2) // MOVISTAR
			$table.= "total_envios_movistar_customer_delivered_anual";
		if($section == 3) // TELCEL
			$table.= "total_envios_telcel_customer_delivered_anual";
		
		$mysqli = Database::getInstance();
		$query=<<<sql
SELECT SUM(total) AS total
FROM $table
WHERE customer_id = :customer_id
sql;
		return $mysqli->queryOne($query, array(':customer_id'=>$customer_id));
	}

	public static function getTotalMTReport($customer_id, $mes){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *  FROM view_mt_total_anual WHERE customer_id = :customer_id AND mes = "$mes"
sql;
		return $mysqli->queryOne($query, array(':customer_id'=>$customer_id));
	}

	public static function getALlCustomers($customer_id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT * FROM customer_parent 
INNER JOIN customer USING(customer_id)
WHERE customer_id = :customer_id
sql;
		return $mysqli->queryAll($query, array(':customer_id'=>$customer_id));
	}

	



}