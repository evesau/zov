<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");
use \Core\Database;
use \App\interfaces\Crud;

class Sembrados implements Crud{

    public static function getAll(){
        $mysqli = Database::getInstance();
        $query=<<<sql

sql;
        return $mysqli->queryAll($query);
    }

    public static function getMsisdnSembrados($customer_id){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * , IF( c.name = 'multicarrier', 'buscando carrier', IF( c.name IS NULL , 0, c.name ) ) AS nombre_carrier
FROM msisdn_sembrados s
INNER JOIN msisdn m
USING ( msisdn_id )
LEFT JOIN carrier c
USING ( carrier_id )
WHERE customer_id =$customer_id
AND estatus =1
sql;
        return $mysqli->queryAll($query);
    }

    public static function getCountTelcel($customer){
        $mysqli = Database::getInstance();
    }

    public static function getMsisdn($msisdn){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT * FROM msisdn WHERE msisdn = $msisdn
sql;
        return $mysqli->queryOne($query);
    }

    public static function getAnMsisdnSembrado($data){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM msisdn_sembrados 
WHERE msisdn_log LIKE '$data->_msisdn_log'  
AND customer_id = $data->_customer_id
sql;
        //mail("tecnico@airmovil.com", "query", $query);
        return $mysqli->queryOne($query);
    }

    public static function getCarrier($name){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT carrier_id FROM carrier WHERE name = "$name";
sql;
        return $mysqli->queryOne($query);
    }

    public static function getDatosParaWhiteList($datos){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT *
            FROM carrier_connection cc
            INNER JOIN carrier_connection_short_code ccsc
            USING ( carrier_connection_id )
            INNER JOIN custome_carrier_connection_short_code cccsc
            USING ( carrier_connection_short_code_id )
            INNER JOIN carrier c ON ( c.carrier_id = ccsc.carrier_id )
            INNER JOIN msisdn m ON ( m.carrier_id = ccsc.carrier_id )
            WHERE cccsc.customer_id = :customer_id
            AND m.msisdn_id = :msisdn_id
sql;
        $parametros = array(
            ':customer_id'=>$datos->_customer_id,
            ':msisdn_id'=>$datos->_msisdn_id
        );

        return $mysqli->queryAll($query, $parametros);

    }

    public static function getById($id){}
    public static function insert($data){}

    public static function insertMsisdnNuevo($data){
        $mysqli = Database::getInstance();
        $query = <<<sql
INSERT INTO msisdn (msisdn,carrier_id) VALUES($data->_msisdn,$data->_carrier_id)
ON DUPLICATE KEY UPDATE msisdn=$data->_msisdn, carrier_id=$data->_carrier_id
sql;
        $parametros = array(
            ':msisdn'=>$data->_msisdn,
            ':carrier_id'=>$data->_carrier_id
        );
        $id = $mysqli->insert($query); 
        // se agrego ON DUPLICATE KEY UPDATE para que retorne id siempre
        //mail('esau.espinoza@airmovil.com','Query',$query."---id---".$id);
        return $id;
    }

    public static function insertMsisdnSembradoNuevo($data){
        $mysqli = Database::getInstance();
        $query = <<<sql
            INSERT INTO msisdn_sembrados (
                msisdn_id,msisdn_log,identificador,estatus,customer_id
            )VALUES(
                :msisdn_id,:msisdn_log,:identificador,:estatus,:customer_id
            )
sql;
        $parametros = array(
            ':msisdn_id'=>$data->_msisdn_id,
            ':msisdn_log'=>$data->_msisdn_log,
            ':identificador'=>$data->_identificador,
            ':estatus'=>$data->_estatus,
            ':customer_id'=>$data->_customer_id
        );

        //mail("tecnico@airmovil.com", "query 2", $query,print_r($parametros,1));

        $id = $mysqli->insert($query, $parametros);
        return $id;
    }

    public static function insertWhiteList($data){
        $mysqli = Database::getInstance();
        $query = <<<sql
        INSERT INTO msisdn_white_list(
            msisdn_id, carrier_connection_id
        ) VALUES (
            :msisdn_id, :carrier_connection_id
        )
sql;
        $parametros = array(
            ":msisdn_id"=>$data->_msisdn_id,
            ":carrier_connection_id"=>$data->_carrier_connection_id
        );

        return $mysqli->insert($query, $parametros);
    }

    public static function update($data){}

    public static function delete($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        DELETE FROM msisdn_sembrados WHERE msisdn_sembrados_id = '$id'
sql;
        return $mysqli->update($query);
    }

    public static function updateMsisdnById($data){
        $mysqli = Database::getInstance();
        $query =<<<sql
        UPDATE msisdn_sembrados SET msisdn_log = "$data->_msisdn_log", identificador = "$data->_identificador", msisdn_id=$data->_msisdn_id  WHERE msisdn_sembrados.msisdn_sembrados_id = "$data->_msisdn_sembrados_id"
sql;
        return $mysqli->update($query);
    }

    public static function getMsisdnById($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM msisdn_sembrados WHERE msisdn_sembrados_id = $id
sql;
        return $mysqli->queryOne($query);
    }


    ########################  cambios en sembrados ##########################


}
    