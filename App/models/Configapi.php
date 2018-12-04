<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Configapi implements Crud
{

    public static function getAll(){}

    public static function getById($id){
    	$mysql = Database::getInstance();
    	$query =<<<sql
SELECT * FROM user_soap_rcs WHERE user_soap_rcs_id = :id
sql;
    	return $mysql->queryOne($query,array(':id' => $id));
    }

    public static function getByName($data){
    	$mysql = Database::getInstance();
    	$query =<<<sql
SELECT user_soap_rcs_id, nickname FROM user_soap_rcs WHERE nickname = :nickname
sql;
		$params = array(':nickname' => $data->usuario);

		return $mysql->queryOne($query, $params);
    }
    
    public static function insert($data){
    	$mysql = Database::getInstance();
    	$query =<<<sql
INSERT INTO user_soap_rcs(nickname, password, descripcion, created, user_id, customer_id) VALUES (:nickname, :password, :descripcion, NOW(), :user_id, :customer_id)
sql;
    	$params = array(
    				':nickname' => $data->usuario,
    				':password' => $data->password,
    				':descripcion' => $data->descripcion,
    				':user_id' => $data->user_id,
    				':customer_id' => $data->customer_id
    			);

    	return $mysql->insert($query, $params);
    }

    public static function update($data){
    	$mysql = Database::getInstance();
    	$query =<<<sql
UPDATE user_soap_rcs SET nickname=:nickname , password=:password, descripcion=:descripcion WHERE user_soap_rcs_id = :id
sql;
		$params = array(
			':id' => $data->id,
			':nickname' => $data->usuario,
			':password' => $data->password,
			':descripcion' => $data->descripcion
		);

    	return $mysql->update($query, $params);
    }

    public static function delete($id){
    	$mysql = Database::getInstance();
    	$query =<<<sql
DELETE FROM user_soap_rcs WHERE user_soap_rcs_id = :id
sql;
		return $mysql->delete($query, array(':id' => $id));
    }

    public static function getAllUserCount($data){
    	$mysql = Database::getInstance();
    	$query =<<<sql
SELECT * FROM user_soap_rcs WHERE user_id=:user_id AND customer_id=:customer_id
sql;
    	$params = array(':customer_id' => $data->customer_id, ':user_id' => $data->user_id);

    	return $mysql->queryAll($query, $params);
    }

    public static function getListUser($data, $start, $length){
    	$mysql = Database::getInstance();
    	$query =<<<sql
SELECT 
created AS Fecha, 
nickname AS Usuario, 
password AS Password, 
descripcion AS Descripcion,
(SELECT name from campaign WHERE campaign_id=user_soap_rcs.campaign_id) as Campania,
CONCAT(
    CONCAT(
        CONCAT('<div>
		            <a href="/Configapi/editar/',user_soap_rcs_id),'" class="btn btn-info" role="button" ><span class="glyphicon glyphicon-edit"><span></a>
		            <a href="/Configapi/borrar/',user_soap_rcs_id),'" class="btn btn-danger" role="button" ><span class="glyphicon glyphicon-remove-sign"><span></a>
                </div>') AS Accion
FROM user_soap_rcs WHERE user_id=:user_id AND customer_id=:customer_id
LIMIT $start, $length
sql;
    	$params = array(':customer_id' => $data->customer_id, ':user_id' => $data->user_id);

    	return $mysql->queryAll($query, $params);
    }

    public static function getCampaignName($customer_id){
        $mysql = Database::getInstance();
        $query =<<<sql
SELECT * FROM campaign AS c INNER JOIN campaign_customer AS cc ON (cc.campaign_id=c.campaign_id) INNER JOIN carrier_connection_short_code_campaign AS ccsc ON (cc.campaign_id=ccsc.campaign_id) WHERE cc.customer_id=:customer_id
sql;

        return $mysql->queryAll($query,array(':customer_id' => $customer_id));
    }
    
}