<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class User implements Crud
{
    public static function getAll()
    {
	return 'HOLA';
    }

    public static function getById($id)
    {

        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT *  FROM user WHERE user_id=:id
sql;

        return $mysqli->queryAll($query, array(':id'=>$id));
    }

    public static function insert($user)
    {

    }

    public static function update($datos)
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE user 
SET img = :img, password = md5(:password) 
WHERE user_id = :id ;
sql;
        $params = array(
            ':password' => $datos->_passNueva,
            ':id'       => $datos->_id_user,
            ':img'      => $datos->_imgNew
        );

        return $mysqli->update($query, $params);
    }


    public static function updateImg($datos)
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE user 
SET img = :img 
WHERE user_id = :id ;
sql;
        $params = array(
            ':id'       => $datos->_id_user,
            ':img'      => $datos->_imgNew
        );

        return $mysqli->update($query, $params);
    }

    public static function updatePassword($datos)
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE user 
SET password = md5(:password)
WHERE user_id = :id ;
sql;
        $params = array(
            ':id'       => $datos->_id_user,
            ':password' => $datos->_passNueva
        );

        return $mysqli->update($query, $params);
    }

    public static function delete($id)
    {

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
