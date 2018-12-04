<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class MasterDom implements Crud{

    public static function getAll(){}
    public static function getById($suscriptor){}
    public static function insert($suscriptor){}
    public static function update($suscriptor){}
    public static function delete($id){}

    public static function getUsuario($usuario){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM api_control_user where user ='$usuario'
sql;
        return $mysqli->queryOne($query);
    }

    public static function getPermissionByUser($usuario, $customer,$url){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT
            u.user_id,
            u.user,
            a.api_id,
            a.nombre,
            a.url,
            a.status
        FROM api_control_user u
        JOIN api_control_permissions p
        ON u.user_id = p.user_id
        JOIN api_control_api a
        ON a.api_id = p.api_id
        WHERE u.user ='$usuario' 
        AND a.url = '$url'
        AND u.status = 1
        AND u.customer_id = $customer
        AND a.status = 1
sql;
        return $mysqli->queryOne($query);
    }

    public static function getIp($user, $ip){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT
            i.*
        FROM api_control_ip i
        JOIN api_control_user u
        USING(user_id)
        WHERE i.ip = '$ip'
        AND u.user = '$user'
sql;
        return $mysqli->queryAll($query);
    }

}















