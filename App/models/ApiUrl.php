<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ApiUrl implements Crud{

    public static function getAll(){}

    public static function getByIdBack($data){
	$mysqli = Database::getInstance();	
	$query=<<<sql
SELECT * FROM `url_general` WHERE identificador LIKE
BINARY :identificador ;
sql;

	return $mysqli->queryOne($query, array(':identificador'=>$data));
    }

    public static function insert($data){

	$mysqli = Database::getInstance();
	$query=<<<sql
INSERT INTO `url_general` (customer_id, msisdn, identificador, url_redirect, carrier, ctime, mtime) VALUES (:customer, :msisdn, :identificador, :url_redirect, :carrier, NOW(), NOW());
sql;

	$params = array(':msisdn'=>$data->_msisdn,
			':identificador'=>$data->_identificador,
			':url_redirect'=>$data->_url_redirect,
			':customer'=>$data->_customer,
			':carrier'=>$data->_carrier);

	return $mysqli->insert($query, $params);
    }

    public static function insertSeguimientoBack($data){

	$mysqli = Database::getInstance();
	$query=<<<sql
INSERT INTO `url_general_sync` (url_general_id, ctime, url) VALUES (:id, NOW(), :url);
sql;
	$params = array(':id'=>$data->_id,
			':url'=>$data->_url);
	
	return $mysqli->insert($query, $params);
    }

    public static function update($data){

	$mysqli = Database::getInstance();
        $query=<<<sql
UPDATE `url_general` SET ctime = ctime , envio = :estatus WHERE url_general_id = :id ;
sql;

        $params = array(':id'=>$data->_id,
                        ':estatus'=>$data->_estatus);

        return $mysqli->update($query, $params);
    }

    public static function delete($id){}

    public static function buscaUrlredirectBack($id){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT url_redirect FROM url_general WHERE url_general_id =$id
sql;

	return $mysqli->queryOne($query);

    }

    public static function preparaEnvio($inicio, $fin){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * 
FROM  `url_general` 
WHERE (url_general_id >= $inicio AND url_general_id <= $fin)
AND envio = -1 ;
sql;

echo "+++$query++<br />";
        return $mysqli->queryAll($query);
    }
################ Esau 2018-06-18 ##############

    public static function getById($data){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT *
FROM `url`
INNER JOIN `unique` un
USING ( unique_id )
WHERE `un`.`value` LIKE '$data'
AND `un`.`status` =1
sql;
        
        return $mysqli->queryOne($query);
    }


    public static function buscaUrlredirect($url_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM `url` WHERE `url_id` =$url_id
sql;
        
        return $mysqli->queryOne($query);
    }


    public static function insertSeguimiento($data){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO `url_sync`(`ctime`, `unique_id`, `url_id`, `ip`, `http_user_agent`) VALUES (now(), $data->_unique_id, $data->_url_id, '$data->_ip', "$data->_http_user_agent")
sql;

        /*$params = array(':unique_id'        => $data->_unique_id,
                        ':url_id'           => $data->_url_id,
                        ':ip'               => $data->_ip,
                        ':http_user_agent'  => $data->_http_user_agent);*/

        //mail("tecnico@airmovil.com","query insertSeguimiento",$query);

        return $mysqli->insert($query);
    }


}
