<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Dinamicweb implements Crud
{

    public static function insert($client){ 
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO client_list (key_santander, msisdn, mail, so_device, token_device, estatus) VALUES (:key_santander,:msisdn,:mail,:so_device,:token_device,:estatus)
sql;
    $params = array(':key_santander'    => $client->_key_santander,
                    ':msisdn'           => $client->_msisdn,
                    ':mail'             => $client->_mail,
                    ':so_device'        => $client->_so_device,
                    ':token_device'     => $client->_token_device,
                    ':estatus'          => $client->_estatus
                    );

    return $mysqli->insert($query,$params);

    }

    public static function getById($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT *
FROM client_list
WHERE client_list_id = $id
sql;

        return $mysqli->queryOne($query);
        
    }
    
    public static function update($client){
        $mysqli = Database::getInstance();
        $query =<<<sql
UPDATE client_list SET key_santander = :key_santander, msisdn = :msisdn, mail = :mail, so_device = :so_device, token_device = :token_device, estatus = :estatus WHERE client_list_id = :client_list_id
sql;

        $params = array(':key_santander'    => $client->_key_santander,
                        ':msisdn'           => $client->_msisdn,
                        ':mail'             => $client->_mail,
                        ':so_device'        => $client->_so_device,
                        ':token_device'     => $client->_token_device,
                        ':estatus'          => $client->_estatus,
                        ':client_list_id'   => $client->_client_list_id);

        return $mysqli->update($query,$params);

    }

    public static function delete($id){
       
    }

    public static function getAll(){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT *
FROM client_list
WHERE estatus != -1
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

    public static function buscaKey($key_santa)
    {

        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT *
FROM client_list
WHERE key_santander = :key_santa
sql;
    
    $params = array(':key_santa' => $key_santa);
        
        return $mysqli->queryAll($query,$params);
    }

    public static function insertClients($dataClients)
    {

        $mysqli = Database::getInstance();
        $query =<<< sql
INSERT INTO client_list (key_santander, msisdn, mail, so_device, token_device, estatus) VALUES (:key_santander,:msisdn,:mail,:so_device,:token_device,:estatus)
ON DUPLICATE KEY UPDATE
msisdn = :msisdn2, mail = :mail2, so_device = :so_device2, token_device = :token_device2, estatus = :estatus2
sql;
        $params = array(':key_santander'    => $dataClients->_key_santander,
                        ':msisdn'           => $dataClients->_msisdn,
                        ':mail'             => $dataClients->_mail,
                        ':so_device'        => $dataClients->_os_device,
                        ':token_device'     => $dataClients->_token_device,
                        ':estatus'          => $dataClients->_estatus,
                        ':msisdn2'          => $dataClients->_msisdn,
                        ':mail2'            => $dataClients->_mail,
                        ':so_device2'       => $dataClients->_os_device,
                        ':token_device2'    => $dataClients->_token_device,
                        ':estatus2'         => $dataClients->_estatus
                    );

        return $mysqli->insert($query, $params);
    }

}

