<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Bolsasms implements Crud
{

    public static function insert($data){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO sms_bag(fecha_compra, fecha_expira, cantidad, customer_id, estatus) VALUES (:fecha_compra,:fecha_expira,:cantidad,:customer_id,1)
sql;
        $params = array(
                        ':fecha_compra' => $data->_fecha_ini,
                        ':fecha_expira' => $data->_fecha_limit,
                        ':cantidad' => $data->_bolsa_sms,
                        ':customer_id' => $data->_customer_id
                    );

        return $mysqli->insert($query,$params);
    }

    public static function getById($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM sms_bag WHERE sms_bag_id =$id
sql;
        return $mysqli->queryOne($query);
    }
    
    public static function update($data){
        $mysqli = Database::getInstance();
        $query =<<<sql
UPDATE sms_bag SET fecha_compra=:fecha_compra,fecha_expira=:fecha_expira,cantidad=:cantidad,customer_id=:customer_id WHERE sms_bag_id=:sms_bag_id
sql;
        $params = array(
                        ':fecha_compra' => $data->_fecha_ini,
                        ':fecha_expira' => $data->_fecha_limit,
                        ':cantidad' => $data->_bolsa_sms,
                        ':customer_id' => $data->_customer_id,
                        ':sms_bag_id' => $data->_sms_bag_id
                    );

        return $mysqli->update($query,$params);
    }

    public static function delete($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
DELETE FROM sms_bag WHERE sms_bag_id=$id
sql;

        return $mysqli->delete($query);
    }

    public static function getAll(){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM sms_bag
sql;
        return $mysqli->queryAll($query);
    }

    public static function getcustomers()
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT customer_id, name FROM customer WHERE STATUS =1
sql;
        return $mysqli->queryAll($query);
    }

    public static function registroUsuario($registro)
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO user_registro(ctime, user_id, nickname, name_customer, script, ip, modulo,accion) VALUES (now(),:id_user,:nickname,:name_customer,:script,:ip,:modulo,:accion);
sql;
        $params = array(
            ':id_user'          => $registro->_id_usuario,
            ':nickname'         => $registro->_nickname,
            ':name_customer'    => $registro->_customer,
            ':script'           => $registro->_script,
            ':ip'               => $registro->_ip,
            ':modulo'           => $registro->_modulo,
            ':accion'           => $registro->_accion
        );

        return $mysqli->insert($query, $params);
    }

}







