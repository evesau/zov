<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ApiStatusSms implements Crud{

    /*****************************************************************************
    ******************************************************************************
    ****************************   JORGE MAÑON ARROYO   **************************
    ****************************   LAS FUNCIONES DE     **************************
    ****************************   API PARA ENVIAR      **************************
    ****************************     MENSAJES SMS       **************************
    ****************************      23/04/1993        **************************
    ******************************************************************************
    *****************************************************************************/


    /****************************************************************************/
    public static function getAll(){}
    public static function getById($id){}
    public static function insert($data){}
    public static function update($data){}
    public static function delete($id){}
    /****************************************************************************/

    /********Se obtiene la informacion del customer a partir del usuario*********/
    public static function getCustomerByUser($usuario, $password){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            api_web_id,
            user,
            pwd,
            customer_id
        FROM api_web
        WHERE user = '$usuario' AND pwd = '$password'
sql;
        return $mysqli->queryOne($query);
    }

    public static function getSms($sms_id){
        $mysqli = Database::getInstance();
/*
        $query =<<<sql
        SELECT
            IF( sce.sms_campaign_estatus_id != 5, sce.estatus, IF( sce.sms_campaign_estatus_id != 5, sce.estatus, s.status)) AS estatus_sms_definitivo, 
            IF( sce.sms_campaign_estatus_id != 5, sce.estatus, s.status) AS estatus_sms,
            IF( s.status_dlr = '', s.status, s.status_dlr) AS estatus_sms_oficial,
            sce.sms_campaign_estatus_id,
            sc.campaign_id,
            sc.delivery_date,
            s.source,
            s.status,
            s.status_dlr,
            sce.estatus
        FROM sms_campaign sc
        left join sms s on (sc.msisdn_log = s.destination)
        left join sms_campaign_estatus sce USING (sms_campaign_estatus_id)
        WHERE s.direction = 'MT' AND sc.sms_campaign_id = $sms_id
        GROUP BY sc.sms_campaign_id
sql;
*/
        $query =<<<sql
        SELECT IF( s.status IS NULL , sce.estatus, s.status ) AS estatus_sms_definitivo, 
        IF( c.name IS NULL , sce.estatus, c.name ) AS carrier, sc.campaign_id
        FROM sms_campaign sc
        LEFT JOIN sms s ON ( s.campaign_id = sc.campaign_id
        AND sc.msisdn_log = s.destination )
        LEFT JOIN sms_campaign_estatus sce ON ( sc.sms_campaign_estatus_id = sce.sms_campaign_estatus_id )
        LEFT JOIN msisdn m ON ( sc.msisdn_id = m.msisdn_id )
        LEFT JOIN carrier c ON ( c.carrier_id = m.carrier_id )
        WHERE sc.sms_campaign_id = $sms_id
        GROUP BY sc.sms_campaign_id
sql;
        //echo $query;
        return $mysqli->queryOne($query);
    }

/********SACAR LOS MENSAJES ENVIADOS*******/
    public static function getTotalesCustomerMes($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
        IF( SUM( uc.count ) IS NULL , 0, SUM( uc.count ) ) AS total_customer,
        IF( c.max_mt_month IS NULL , ( SELECT cc.max_mt_month FROM customer cc WHERE cc.customer_id =$customer_id ), c.max_mt_month ) AS max_mt_month,
        IF( ( c.max_mt_month - SUM( uc.count ) ) IS NULL , c.max_mt_month, ( c.max_mt_month - SUM( uc.count ) ) ) AS resta_mes
        FROM customer c
        LEFT JOIN (
            SELECT count , customer_id
            FROM customer_control_mt uc
            WHERE (MONTH( uc.create_time ) = MONTH( NOW( ) )
            OR MONTH( uc.create_time ) IS NULL)) AS uc 
        ON (uc.customer_id = c.customer_id)
        WHERE c.customer_id = $customer_id
sql;

        return $mysqli->queryOne($query);
    }

    public static function getTotalesCustomerDia($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
        IF( SUM( uc.count ) IS NULL , 0, SUM( uc.count ) ) AS total_customer,
        IF( c.max_mt_day IS NULL , ( SELECT cc.max_mt_day FROM customer cc WHERE cc.customer_id =$customer_id ), c.max_mt_day ) AS max_mt_day,
        IF( ( c.max_mt_day - SUM( uc.count ) ) IS NULL , c.max_mt_day, ( c.max_mt_day - SUM( uc.count ) ) ) AS resta_dia
        FROM customer c
        LEFT JOIN (
            SELECT count , customer_id
            FROM customer_control_mt uc
            WHERE (DATE( uc.create_time ) = DATE( NOW( ) )
            OR DATE( uc.create_time ) IS NULL)) AS uc 
        ON (uc.customer_id = c.customer_id)
        WHERE c.customer_id = $customer_id
sql;
        return $mysqli->queryOne($query);
    }


    public static function getTotalesUserMes($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
        IF( SUM( uc.count ) IS NULL , 0, SUM( uc.count ) ) AS total_user,
        IF( u.max_mt_month IS NULL , ( SELECT uu.max_mt_month FROM user uu WHERE uu.user_id =$user_id ), u.max_mt_month ) AS max_mt_month,
        IF( ( u.max_mt_month - SUM( uc.count ) ) IS NULL , u.max_mt_month, ( u.max_mt_month - SUM( uc.count ) ) ) AS resta_mes
        FROM user u
        LEFT JOIN (
            SELECT count , user_id
            FROM user_control_mt uc
            WHERE (MONTH( uc.create_time ) = MONTH( NOW( ) )
            OR MONTH( uc.create_time ) IS NULL)) AS uc 
        ON (uc.user_id = u.user_id)
        WHERE u.user_id = $user_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getTotalesUserDia($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
        IF( SUM( uc.count ) IS NULL , 0, SUM( uc.count ) ) AS total_user,
        IF( u.max_mt_day IS NULL , ( SELECT uu.max_mt_day FROM user uu WHERE uu.user_id =$user_id ), u.max_mt_day ) AS max_mt_day,
        IF( ( u.max_mt_day - SUM( uc.count ) ) IS NULL , u.max_mt_day, ( u.max_mt_day - SUM( uc.count ) ) ) AS resta_dia
        FROM user u
        LEFT JOIN (
            SELECT count , user_id
            FROM user_control_mt uc
            WHERE (DATE( uc.create_time ) = DATE( NOW( ) )
            OR DATE( uc.create_time ) IS NULL)) AS uc 
        ON (uc.user_id = u.user_id)
        WHERE u.user_id = $user_id
sql;
        return $mysqli->queryOne($query);
    }
/*******************SACAR LOS MENSAJES ENVIADOS POR EL CUSTOMER Y USUARIO******************/

    public static function getMensajesEnviadosCustomer($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT SUM(count) NUM_ENVIOS
        FROM customer_control_mt 
        WHERE customer_id = $customer_id
sql;
        return $mysqli->queryOne($query);
    }

    /********funcion que inserta un nuevo mensaje en colado*********/
    public static function insertSmsCampaign($campaign, $delivery, $msisdnId, $carrier_connection_short_code_id, $smsCampaignStatusId, $modulesId, $mensaje){
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO `sms_campaign` (campaign_id, ctime, delivery_date, msisdn_id, carrier_connection_short_code_id, sms_campaign_estatus_id, modules_id, content)
        VALUES ($campaign, NOW(), '$delivery', $msisdnId, $carrier_connection_short_code_id, $smsCampaignStatusId, $modulesId, '$mensaje');
sql;
        //echo $query;
        return $mysqli->insert($query);
    }

     public static function getMesCustomer($customer, $fecha){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT SUM( count ) AS suma
        FROM `customer_control_mt`
        WHERE MONTH( :fecha ) = MONTH( customer_control_mt.create_time )
        AND customer_id = :customer
sql;
        return $mysqli->queryOne($query, array(':customer'=>$customer, ':fecha'=>$fecha));
    }

    public static function getDiaCustomer($customer, $fecha){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT count AS suma
        FROM `customer_control_mt`
        WHERE DAY( :fecha ) = DAY( customer_control_mt.create_time )
        AND customer_id = :customer
sql;
        return $mysqli->queryOne($query, array(':customer'=>$customer, ':fecha'=>$fecha));
    }

    public static function getCustomerMt($customer){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM `customer` 
        WHERE customer_id = :customer
        AND status = 1
sql;
        return $mysqli->queryOne($query, array(':customer'=>$customer));
    }

    public static function getCarrierConnectionShortCode($customer_id, $api_web_id, $source, $campaign_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            c.campaign_id,
            caw.api_web_type_id,
            u.user_id,
            cc.customer_id,
            aw.user,
            aw.pwd,
            ccsc.carrier_id,
            ccsc.short_code_id,
            sc.short_code,
            ccscc.carrier_connection_short_code_id,
            c.modules_id
        FROM campaign c
        JOIN campaign_api_web caw USING(campaign_id)
        JOIN carrier_connection_short_code_campaign ccscc USING(campaign_id)
        JOIN campaign_customer cc USING(campaign_id)
        JOIN campaign_user cu USING(campaign_id)
        JOIN user u ON cu.user_id = u.user_id
        JOIN api_web aw ON caw.api_web_id = aw.api_web_id
        JOIN campaign_carrier_short_code ccsc ON ccsc.campaign_carrier_short_code = caw.campaign_carrier_short_code_id
        JOIN short_code sc ON sc.short_code_id = ccsc.short_code_id  
        WHERE cc.customer_id = $customer_id 
        AND sc.short_code = $source
        AND aw.api_web_id = $api_web_id
        AND c.campaign_id = $campaign_id
sql;
        //echo $query;
        return $mysqli->queryOne($query);
    }

}
