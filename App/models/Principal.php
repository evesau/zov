<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Principal implements Crud{

	public static function insert($data){}
	public static function update($param){}
	public static function delete($id){}
   	public static function getById($param){}
    public static function getAll(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT * FROM la_voz_mexico_participantes
sql;
		return $mysqli->queryAll($query);
    }

    public static function updateActivo($id, $activo){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
UPDATE la_voz_mexico_participantes SET activo=:activo WHERE id=:id
sql;

		$params = array(':activo' => $activo, ':id' => $id);

		return $mysqli->update($query, $params);
    }

    public static function getParticipantesActivos(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT * FROM la_voz_mexico_participantes WHERE activo=1
sql;
		return $mysqli->queryAll($query);
    }

    public static function getSmsGuillermo(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT * FROM la_voz_mexico_sms WHERE content LIKE 'g%'
sql;
		return $mysqli->queryAll($query);
    }

    public static function getSmsDulce(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT *  FROM la_voz_mexico_sms WHERE content LIKE 'du%'
sql;
		return $mysqli->queryAll($query);
    }

    public static function getSmsNacho(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT *  FROM la_voz_mexico_sms WHERE content LIKE 'n%'
sql;
		return $mysqli->queryAll($query);
    }

    public static function getSmsMorganna(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT *  FROM la_voz_mexico_sms WHERE content LIKE 'm%'
sql;
		return $mysqli->queryAll($query);
    }

    public static function getSmsLuanna(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT *  FROM la_voz_mexico_sms WHERE content LIKE 'l%'
sql;
		return $mysqli->queryAll($query);
    }

    public static function getSmsAdrianaCristian(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT *  FROM la_voz_mexico_sms WHERE content LIKE 'a%' OR content LIKE 'cr%'
sql;
		return $mysqli->queryAll($query);
    }

    public static function getSmsCindy(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT *  FROM la_voz_mexico_sms WHERE content LIKE 'c%'
sql;
		return $mysqli->queryAll($query);
    }

    public static function getSmsDiana(){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT *  FROM la_voz_mexico_sms WHERE content LIKE 'du%'
sql;
		return $mysqli->queryAll($query);
    }

}
