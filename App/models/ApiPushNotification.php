<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ApiPushNotification implements Crud{

    public static function getAll(){}
    public static function getById($id){}
    public static function insert($data){}
    public static function update($data){}
    public static function delete($id){}

    public static function searchToken($customer_id, $token, $msisdn){
        $mysqli = Database::getInstance();
        $query = <<<html
        SELECT * FROM push_device WHERE token = "$token" AND customer_id = "$customer_id"
html;
        return $mysqli->queryOne($query);
    }

    public static function insertToken($data){
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO push_device(token, msisdn, estatus, sistema_operativo, nombre, apellido, cuenta, sexo, customer_id) 
        VALUES (:token, :msisdn, 1, :sistema_operativo, :nombre, :apellido, :cuenta, :sexo, :customer_id)
sql;
        $params = array(
            ':customer_id'=>$data->_customer_id,
            ':sistema_operativo'=>$data->_sistema_operativo,
            ':token'=>$data->_token,
            ':msisdn'=>$data->_msisdn,
            ':nombre'=>$data->_nombre,
            ':apellido'=>$data->_apellido,
            ':cuenta'=>$data->_cuenta,
            ':sexo'=>$data->_sexo
        );
        return $mysqli->insert($query, $params);
    }

    public static function updateRegisterToken($data){
        $mysqli = Database::getInstance();
        $query=<<<sql
        UPDATE push_device SET 
            msisdn = "$data->_msisdn", 
            nombre = "$data->_nombre", 
            apellido = "$data->_apellido", 
            cuenta = "$data->_cuenta", 
            sexo = "$data->_sexo" 
        WHERE push_device = {$data->_push_device}
sql;
        return $mysqli->update($query);

    }

    public static function insertCampaignReport($customer_id, $user_id, $api, $total_envio){
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO push_campaign_reports VALUES($customer_id, $user_id, now(), '$api', $total_envio)
sql;
        return $mysqli->insert($query);
    }

    public static function getUser($user){
        $mysqli = Database::getInstance();
        $query = <<<html
        SELECT user_id, customer_id FROM api_control_user WHERE user = "$user"
html;
        return $mysqli->queryOne($query);
    }

}
