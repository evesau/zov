<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Login implements Crud{

    public static function getById($user){
    	$mysqli = Database::getInstance();
		  $query = <<<sql
 SELECT * FROM la_voz_mexico_user WHERE nickname LIKE BINARY :nickname AND password=MD5(:password)
sql;

		$params = array(	':nickname' => $user->_name,
                      ':password' => $user->_pass
					           );

		return $mysqli->queryOne($query, $params);
    }


    public static function getAll(){}
    public static function insert($param){}
    public static function update($param){}
    public static function delete($param){}

}
