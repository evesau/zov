<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Device implements Crud{


    public static function getAll(){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM push_device WHERE estatus IN(0,1) AND customer_id = 1
sql;
      return $mysqli->queryAll($query);
    }

    public static function getAllDevice($customer_id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM push_device WHERE estatus IN(0,1) AND customer_id = $customer_id
sql;
      return $mysqli->queryAll($query);
    }

    public static function getById($id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM push_device WHERE push_device = :id
sql;
      return $mysqli->queryOne($query, array(':id'=>$id));

    }

    public static function insert($device){
      $mysqli = Database::getInstance();
      $query =<<<sql
      INSERT INTO push_device
      VALUES(
        null,
        :token,
        :msisdn,
        :estatus,
        :sistema_operativo,
        :nombre,
        :apellido,
        :cuenta,
        :sexo
      )
sql;

      $params = array(
        ':token' => $device->_token,
        ':msisdn' => $device->_msisdn,
        ':estatus' => $device->_estatus,
        ':sistema_operativo' => $device->_sistema_operativo,
        ':nombre' => $device->_nombre,
        ':apellido' => $device->_apellido,
        ':cuenta' => $device->_cuenta,
        ':sexo' => $device->_sexo
      );
      return $mysqli->insert($query, $params);
    }

    public static function update($device){
      $mysqli = Database::getInstance();
      $query =<<<sql
      UPDATE push_device SET
        token= :token,
        msisdn= :msisdn,
        estatus= :estatus,
        sistema_operativo= :sistema_operativo,
        nombre= :nombre,
        apellido= :apellido,
        cuenta= :cuenta,
        sexo= :sexo
      WHERE push_device = :push_device
sql;
      $params = array(
        ':push_device' => $device->_push_device,
        ':token' => $device->_token,
        ':msisdn' => $device->_msisdn,
        ':estatus' => $device->_estatus,
        ':sistema_operativo' => $device->_sistema_operativo,
        ':nombre' => $device->_nombre,
        ':apellido' => $device->_apellido,
        ':cuenta' => $device->_cuenta,
        ':sexo' => $device->_sexo
      );
      return $mysqli->update($query, $params);
    }

    public static function delete($id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      UPDATE push_device SET
        estatus = 2
      WHERE push_device = :id
sql;
    	return $mysqli->update($query, array(':id'=>$id));
    }

}
