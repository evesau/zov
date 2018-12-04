<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class SmsPush{

    //get ibs
    public static function getAll(){

	$mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM push_device
sql;

        return $mysqli->queryAll($query);
    }

    //get ibs
    public static function getAllCampania(){

        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * 
FROM push_campania
WHERE NOW( ) > delivery_date
AND estatus =0
sql;
             
        return $mysqli->queryAll($query);
    }

    public static function getMsisdn($msisdn){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM push_device WHERE msisdn = :msisdn
sql;
        return $mysqli->queryAll($query, array(':msisdn'=>$msisdn));
    }

    //get ibs
    public static function getAllCampaniaTabla(){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM push_campania
sql;

        return $mysqli->queryAll($query);
    }

    //get campania by id
    public static function getById($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM push_campania
WHERE push_campania_id = :push_campania_id;
sql;

        return $mysqli->queryOne($query, array(':push_campania_id'=>$id));
    }

    public static function insert($data){
	$mysqli = Database::getInstance(true);
	$query=<<<sql
INSERT INTO `push_device` (token, msisdn) VALUES (:token, :msisdn)
sql;

        return $mysqli->insert($query,array(':token'=>$data->_token, ':msisdn'=>$data->_msisdn));
    }

    public static function updateToken($data){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
UPDATE `push_device` SET estatus = :estatus, sistema_operativo = :sistema_operativo, 
nombre = :nombre, apellido = :apellido, cuenta = :cuenta, sexo = :sexo
WHERE push_device = :push_device
sql;

	$params = array(':estatus'=>$data->_estatus,
			':sistema_operativo'=>$data->_sistema_operativo,
			':nombre'=>$data->_nombre,
			':apellido'=>$data->_apellido,
			':cuenta'=>$data->_cuenta,
			':sexo'=>$data->_sexo,
			'push_device'=>$data->_push_device);

        return $mysqli->update($query,$params);
    }

    public static function insertCampania($data){

	$mysqli= Database::getInstance();
	$query=<<<sql
INSERT INTO `push_campania` (campania, titulo, mensaje, tipo_mensaje, estatus, delivery_date, total)
VALUES (:campania, :titulo, :mensaje, :tipo_mensaje, :estatus, :delivery_date, :total);
sql;
	
	$params = array(':campania'=>$data->_campania,
			':titulo'=>$data->_titulo,
			':mensaje'=>$data->_mensaje,
			':tipo_mensaje'=>$data->_tipo_mensaje,
			':estatus'=>$data->_estatus,
			':delivery_date'=>$data->_delivery_date,
			':total'=>$data->_total);

	return $mysqli->insert($query,$params);
    }

    public static function updateCampaniaEstatus($data){

	$mysqli = Database::getInstance(true);
        $query =<<<sql
UPDATE `push_campania` SET estatus = :estatus
WHERE push_campania_id IN ( $data->_push_campania_id )
sql;

        $params = array(':estatus'=>$data->_estatus
		);

        return $mysqli->update($query,$params);
    }

    //update campania total
    public static function update($data){
	$mysqli = Database::getInstance(true);
        $query =<<<sql
UPDATE push_campania SET total = :total
WHERE push_campania_id = :push_campania_id
sql;

	$params = array(':total'=>$data->_total,
                        ':push_campania_id'=>$data->_push_campania_id
                );

        return $mysqli->update($query,$params);
    }


    //update campania total
    public static function updateRowCampania($data){
    $mysqli = Database::getInstance(true);
        $query =<<<sql
UPDATE push_campania SET campania = :campania, titulo = :titulo, mensaje = :mensaje, tipo_mensaje = :tipo_mensaje, delivery_date = :delivery_date WHERE push_campania_id = :id
sql;

    $params = array(':id'=>$data->_id,
                    ':campania'=>$data->_campania,
                    ':titulo'=>$data->_titulo,
                    ':mensaje'=>$data->_mensaje,
                    ':tipo_mensaje'=>$data->_tipo_mensaje,
                    ':delivery_date'=>$data->_delivery_date
                );

        return $mysqli->update($query,$params);
    }

    public static function delete($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
DELETE FROM push_campania WHERE push_campania_id = :id;
sql;
        return $mysqli->delete($query, array(':id'=>$id));
    }

}
