<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ApiControl implements Crud{

    public static function getAll(){}
    public static function getById($suscriptor){}
    public static function insert($suscriptor){}
    public static function update($suscriptor){}
    public static function delete($id){}


    /******************** FUNCIONES PARA CONSULTA DE INFORMACION DESDE LA BASE DE DATOS******************* */
    public static function getApisAll(){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM api_control_api
sql;
        return $mysqli->queryAll($query);
    }

    public static function getApiById($api_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM api_control_api WHERE api_id = $api_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getUserAll($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM api_control_user WHERE customer_id = $customer_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getIpByUser($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM api_control_ip WHERE user_id = $user_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getApiAll(){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM api_control_api
sql;
        return $mysqli->queryAll($query);
    }

    public static function getUserById($api_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM api_control_user WHERE user_id = $api_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getApiByUserId($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            a.*
        FROM api_control_api a
        JOIN api_control_permissions p
        ON a.api_id = p.api_id
        WHERE p.user_id = $user_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getUserIp($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM api_control_ip WHERE user_id = $user_id
sql;
        return $mysqli->queryAll($query);
    }

    /******************** FUNCIONES PARA INSERTAR INFORMACION EN LA BASE DE DATOS******************* */
    public static function insertUser($user){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO api_control_user VALUES(null, $user->_customer, '$user->_user', '$user->_password', $user->_status)
sql;
        return $mysqli->insert($query);
    }

    public static function insertApi($api){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO api_control_api VALUES(null, '$api->_nombre', '$api->_url', $api->_status)
sql;
        return $mysqli->insert($query);
    }

    public static function insertUserApi($user_id, $api_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO api_control_permissions VALUES($user_id, $api_id)
sql;
        return $mysqli->insert($query);
    }

    public static function insertIp($user_id, $ip){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO api_control_ip VALUES($user_id, '$ip')
sql;
        return $mysqli->insert($query);
    }

    /******************** FUNCIONES PARA ACTUALIZAR INFORMACION EN LA BASE DE DATOS******************* */
    public static function updateUser($user){
        $mysqli = Database::getInstance();
        $query =<<<sql
        UPDATE api_control_user SET 
            user = '$user->_user',
            customer_id = $user->_customer,
            status = '$user->_status'
        WHERE user_id = $user->_user_id
sql;
        return $mysqli->update($query);
    }

    public static function updateUserPassword($user){
        $mysqli = Database::getInstance();
        $query =<<<sql
        UPDATE api_control_user SET 
            password = MD5('$user->_password')
        WHERE user_id = $user->_user_id
sql;
        return $mysqli->update($query);
    }

    public static function updateApi($api){
        $mysqli = Database::getInstance();
        $query =<<<sql
        UPDATE api_control_api SET 
            nombre = '$api->_nombre',
            url = '$api->_url',
            status = $api->_status
        WHERE api_id = $api->_api_id
sql;
        return $mysqli->update($query);
    }

    /******************** FUNCIONES PARA ELIMINAR INFORMACION EN LA BASE DE DATOS******************* */
    public static function deleteApisByUser($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        DELETE FROM api_control_permissions
        WHERE user_id = $user_id
sql;
        return $mysqli->update($query);
    }

    public static function deleteUser($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        UPDATE api_control_user 
        SET status = 2 
        WHERE user_id = $user_id
sql;
        return $mysqli->update($query);
    }

    public static function deleteApi($api_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        UPDATE api_control_api 
        SET status = 2 
        WHERE api_id = $api_id
sql;
        return $mysqli->update($query);
    }

    public static function deleteUserIp($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        DELETE FROM api_control_ip 
        WHERE user_id = $user_id
sql;
        return $mysqli->update($query);
    }
}















