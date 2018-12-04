<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ApiMail implements Crud{

    public static function getAll(){}
    public static function getById($suscriptor){}
    public static function insert($suscriptor){}
    public static function update($suscriptor){}
    public static function delete($id){}

    //agregar una campaña nueva con la lista
    public static function insertCampaignList($request){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO doppler_campaign_relay VALUES ($request->_campaign, '$request->_createdResourceId', '', $request->_list, $request->_customer, '$request->_plantilla', now())
sql;
        return $mysqli->insert($query);
    }

    //agregar un reporte para descarga
    public static function insertReport($request){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO doppler_report VALUES ($request->_reportId, '$request->_start_date', '$request->_end_date', $request->_customer)
sql;
        return $mysqli->insert($query);
    }

    //agregar un archivo adjunto de una campaña con lista
    public static function insertCampaignAttachment($request){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO doppler_attachment VALUES (null, $request->_campaign, '$request->_content_type', '$request->_base64_content', '$request->_filename')
sql;
        return $mysqli->insert($query);
    }

    //agrgear una lista nueva
    public static function insertList($request){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO doppler_list VALUES(null,'$request->_name', '$request->_customer')
sql;
        return $mysqli->insert($query);
    }

    //insertar suscriptor
    public static function insertSuscriptor($suscriptor){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO doppler_suscriptor VALUES(null, '$suscriptor->_email', '$suscriptor->_nombre')
sql;
        return $mysqli->insert($query);
    }

    //asignar un suscriptor a una lista
    public static function addSuscriptorList($datos){
        $mysqli = Database::getInstance();
        $query = <<<sql
        INSERT INTO doppler_list_suscriptor VALUES($datos->_doppler_list_id, $datos->_doppler_suscriptor_id)
sql;
        return $mysqli->insert($query);
    }

    //insertar una campaña relay
    public static function insertCampaignRelay($campaign){
        $mysqli = Database::getInstance();
        $query = <<<sql
        INSERT INTO doppler_campaign_relay VALUES(null, '$campaign->_nombre', $campaign->_doppler_list_id, '$campaign->_fecha_envio')
sql;
        return $mysqli->insert($query);
    }

    //insertar un envio
    public static function insertCampaignSend($request){
        $mysqli = Database::getInstance();
        $query = <<<sql
        INSERT INTO doppler_campaign_send VALUES(null, $request->_campaign, $request->_customer, $request->_suscriptor_id)
sql;
        return $mysqli->insert($query);
    }

    /*
    * METODOS PARA CONSULTAR INFORMACION DE LAS 
    * LISTAS, SUSCRIPTORES, CAMPÀÑAS.
    */

    public static function getSuscriptorByListId($list_id){
        $mysqli = Database::getinstance();
        $query = <<<sql
        SELECT 
            s.* 
        FROM doppler_suscriptor s
        JOIN doppler_list_suscriptor ls
        ON ls.doppler_suscriptor_id = s.doppler_suscriptor_id
        WHERE ls.doppler_list_id = $list_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getListByCustomer($customer_id){
        $mysqli = Database::getinstance();
        $query = <<<sql
        SELECT 
            l.doppler_list_id,
            l.nombre,
            l.customer_id,
            (select count(*) AS count from doppler_list_suscriptor where doppler_list_id = l.doppler_list_id ) AS count
        FROM doppler_list l 
        WHERE l.customer_id = $customer_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getSuscriptors($datos){
        $mysqli = Database::getinstance();
        $query = <<<sql
        SELECT 
            *
        FROM doppler_suscriptor ds
        JOIN doppler_list_suscriptor dls
        USING(doppler_suscriptor_id)
        JOIN doppler_list dl
        ON dl.doppler_list_id = dls.doppler_list_id
        WHERE dl.doppler_list_id = $datos->_id
        AND dl.customer_id = $datos->_customer
sql;
        return $mysqli->queryAll($query);
    }

    public static function getCountListById($list_id){
        $mysqli = Database::getinstance();
        $query = <<<sql
        SELECT 
            count(*) AS count
        FROM doppler_list_suscriptor WHERE doppler_list_id = $list_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getSuscriptorByEmail($email){
        $mysqli = Database::getinstance();
        $query = <<<sql
        SELECT 
            *
        FROM doppler_suscriptor WHERE email = '$email'
sql;
        return $mysqli->queryAll($query);
    }

    public static function getListById($list_id){
        $mysqli = Database::getinstance();
        $query = <<<sql
        SELECT 
            *
        FROM doppler_list WHERE doppler_list_id = $list_id
sql;
        return $mysqli->queryAll($query);
    }

}















