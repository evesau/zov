<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ControlCustomerMt implements Crud
{

    public static function getAll(){
	   $mysqli = Database::getInstance();
	   $query=<<<sql
sql;

	   return $mysqli->queryAll($query);

    }

    public static function getAllCustomer(){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM customer WHERE STATUS =1
sql;
        return $mysqli->queryAll($query);
    }

    public static function getRowMt($fecha,$customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM customer_control_mt WHERE create_time >= '$fecha' AND customer_id =$customer_id
sql;

        return $mysqli->queryOne($query);
    }

    public static function getById($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
sql;

        return $mysqli->queryAll($query, array(':id'=>$id));

    }

    
    public static function insert($customer_id){
        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO customer_control_mt(customer_id, create_time, update_time, count, delivered) VALUES ($customer_id,NOW(),NOW(),0,0)
sql;

        return $mysqli->insert($query);

    }


    public static function update($data){
        $mysqli = Database::getInstance();
        $query=<<<sql
sql;

        return $mysqli->update($query);
    }

    
    public static function delete($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
sql;
        return $mysqli->delete($query, array(':id'=>$id));	
    }
    
}