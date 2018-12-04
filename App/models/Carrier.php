<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Carrier implements Crud
{

    public static function getAll()
    {
	$mysqli = Database::getInstance();
	$query=<<<sql
SELECT * FROM `carrier_connection_short_code` 
INNER JOIN carrier_connection USING (carrier_connection_id)
sql;

	return $mysqli->queryAll($query);
    }

    public static function getShortCodeAll()
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT *
FROM `short_code` 
sql;

        return $mysqli->queryAll($query);
    }

    public static function getCarrierAll()
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT *
FROM `carrier` 
sql;

        return $mysqli->queryAll($query);
    }

    public static function getById($id)
    {
	$mysqli = Database::getInstance();

    $query=<<<sql
SELECT *
FROM `carrier_connection_short_code` AS ccsc
INNER JOIN carrier_connection AS cc
USING ( carrier_connection_id )
INNER JOIN short_code AS sc
USING ( short_code_id )
INNER JOIN carrier AS c
USING ( carrier_id )
WHERE ccsc.carrier_connection_short_code_id = :id
sql;

        return $mysqli->queryOne($query, array(':id'=>$id));

    }

    
    public static function insert($obj)
    {

	$mysqli = Database::getInstance();
	$query=<<<sql
INSERT INTO `carrier_connection` (`carrier_name`, `created`, `host`, `port`, `system_id`, `password`, `system_type`, `source_ton`, `source_npi`,
                                 `destination_ton`,`destination_npi`, `addr_ton`, `addr_npi`, `supports_wap_push`, `mode`, `status`, `tps_submit_one`,
                                 `tps_submit_multi`, `submit_multi_size`, `white_list`, `white_list_user`, `white_list_pwd`, `country_code`)
VALUES ( :nombre, NOW(), :host, :puerto, :system_id, :password, :system_type, :source_ton, :source_npi, 
	:destination_ton, :destination_npi, :addr_ton, :addr_npi, :supports_wap_push, :mode, :status, :tps_submit_one, 
	:tps_submit_multi, :submit_multi_size, :white_list, :white_list_user, :white_list_pwd, :country_code) ;
sql;

    $params = array(
		':nombre'=>$obj->_nombre,
		':host'=>$obj->_host,
		':puerto'=>$obj->_puerto,
		':system_id'=>$obj->_system_id,
		':password'=>$obj->_password,
		':system_type'=>$obj->_system_type,
		':source_ton'=>$obj->_source_ton,
		':source_npi'=>$obj->_source_npi,
		':destination_ton'=>$obj->_destination_ton,
		':destination_npi'=>$obj->_destination_npi,
		':addr_ton'=>$obj->_addr_ton,
		':addr_npi'=>$obj->_addr_npi,
		':supports_wap_push'=>$obj->_supports_wap_push,
		':mode'=>$obj->_mode,
		':status'=>$obj->_status,
		':tps_submit_one'=>$obj->_tps_submit_one,
		':tps_submit_multi'=>$obj->_tps_submit_multi,
		':submit_multi_size'=>$obj->_submit_multi_size,
		':white_list'=>$obj->_white_list,
		':white_list_user'=>$obj->_white_list_user,
		':white_list_pwd'=>$obj->_white_list_pwd,
		':country_code'=>$obj->_country_code
            );

	return $mysqli->insert($query, $params);
    }

    public static function insertCarrierShortCode($carrierConn, $shortCode, $carrier){

	$mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `carrier_connection_short_code` (carrier_connection_id, short_code_id, carrier_id)
VALUES (:carrierConn, :shortCode, :carrier ) ;
sql;

	$params = array(
		':carrierConn'=>$carrierConn,
		':shortCode'=>$shortCode,
		':carrier'=>$carrier
	);

	return $mysqli->insert($query, $params);
    }

    public static function update($obj)
    {
    	$mysqli = Database::getInstance(true, true);

	$query=<<<sql
UPDATE `carrier_connection` SET `carrier_name` = :nombre, `created` = created, `host` = :host, `port` = :puerto, `system_id` = :system_id, `password` = :password, `system_type` = :system_type, 
				 source_ton = :source_ton, `source_npi` = :source_npi,
                                 `destination_ton` = :destination_ton, `destination_npi` = :destination_npi, `addr_ton` = :addr_ton, `addr_npi` = :addr_npi, `supports_wap_push` = :supports_wap_push, `mode` = :mode, 
				`status` = :status, `tps_submit_one` = :tps_submit_one,
                                 `tps_submit_multi` = :tps_submit_multi, `submit_multi_size` = :submit_multi_size, 
				`white_list` = :white_list, `white_list_user` = :white_list_user, `white_list_pwd` = :white_list_pwd, `country_code` = :country_code, last_update = NOW()
				WHERE carrier_connection_id = :carrier_connection_id
sql;

    $params = array(
                ':nombre'=>$obj->_nombre,
                ':host'=>$obj->_host,
                ':puerto'=>$obj->_puerto,
                ':system_id'=>$obj->_system_id,
                ':password'=>$obj->_password,
                ':system_type'=>$obj->_system_type,
                ':source_ton'=>$obj->_source_ton,
                ':source_npi'=>$obj->_source_npi,
                ':destination_ton'=>$obj->_destination_ton,
                ':destination_npi'=>$obj->_destination_npi,
                ':addr_ton'=>$obj->_addr_ton,
                ':addr_npi'=>$obj->_addr_npi,
                ':supports_wap_push'=>$obj->_supports_wap_push,
                ':mode'=>$obj->_mode,
                ':status'=>$obj->_status,
                ':tps_submit_one'=>$obj->_tps_submit_one,
                ':tps_submit_multi'=>$obj->_tps_submit_multi,
                ':submit_multi_size'=>$obj->_submit_multi_size,
                ':white_list'=>$obj->_white_list,
                ':white_list_user'=>$obj->_white_list_user,
                ':white_list_pwd'=>$obj->_white_list_pwd,
                ':country_code'=>$obj->_country_code,
		':carrier_connection_id'=>$obj->_carrier_connection_id
            );

        return $mysqli->update($query, $params);
    }

    public static function updateRelation($id, $shortCode, $carrierId){

	$mysqli = Database::getInstance(true,true);
	$query=<<<sql
UPDATE `carrier_connection_short_code` SET short_code_id = :shortCode, carrier_id = :carrierId
WHERE carrier_connection_short_code_id = :id ;
sql;
	$params = array(
		':shortCode'=>$shortCode,
		':carrierId'=>$carrierId,
		':id'=>$id
	);

	return $mysqli->update($query, $params);
    }
    
    public static function delete($id)
    {
	$mysqli = Database::getInstance();
	$query=<<<sql
UPDATE `carrier_connection` SET status = 0, last_update = NOW(), deleted = NOW(), created = created
WHERE carrier_connection_id = :id ;
sql;
	return $mysqli->update($query, array(':id'=>$id));	
    }

    public static function getByName($nombre)
    {

    $mysqli = Database::getInstance();
    $query=<<<sql
SELECT *
FROM `carrier_connection`
WHERE `carrier_name` = :nickname
sql;

        return $mysqli->queryAll($query, array(':nickname'=>$nombre));
    }

    public static function getIdCompany($id)
    {

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT *
FROM `carrier`
WHERE `carrier_id` = :id
sql;

        return $mysqli->queryOne($query, array(':id'=>$id));
    }

    public static function getIdShortCode($id)
    {

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT *
FROM `short_code`
WHERE `short_code_id` = :id
sql;

        return $mysqli->queryOne($query, array(':id'=>$id));
    }

    public static function updateCompany($id, $name)
    {

        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE `carrier` SET name = :name
WHERE carrier_id = :id
sql;

        return $mysqli->update($query, array(':id'=>$id, ':name'=>$name));
    }

    public static function updateShortCode($id, $name)
    {

        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE `short_code` SET short_code = :name
WHERE short_code_id = :id
sql;

        return $mysqli->update($query, array(':id'=>$id, ':name'=>$name));
    }

    public static function getByNameCompany($nombre)
    {

    $mysqli = Database::getInstance();
    $query=<<<sql
SELECT * FROM `carrier`
WHERE name = :nickname
sql;

    return $mysqli->queryAll($query, array(':nickname'=>$nombre));
    }

    public static function getByNameShortCode($nombre)
    {

    $mysqli = Database::getInstance();
    $query=<<<sql
SELECT *
FROM `short_code`
WHERE `short_code` = :nombre
sql;

    return $mysqli->queryAll($query, array(':nombre'=>$nombre));
    }

    public static function insertCompany($nombre){

	$mysqli = Database::getInstance();
	$query=<<<sql
INSERT INTO `carrier` (name) VALUES (:nombre) ;
sql;

	return $mysqli->insert($query,array(':nombre'=>$nombre));
    }

    public static function insertShortCode($nombre){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `short_code` (short_code) VALUES (:nombre) ;
sql;

        return $mysqli->insert($query,array(':nombre'=>$nombre));
    }

    public static function getAllCompany(){

	$mysqli = Database::getInstance();
    	$query=<<<sql
SELECT *
FROM `carrier`
ORDER BY name ASC 
sql;

	return $mysqli->queryAll($query);
    }

    public static function getAllShortCode(){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT *
FROM `short_code`
ORDER BY short_code
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
