<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class SendMessageLong implements Crud{

    /*****************************************************************************
    ******************************************************************************
    ****************************   JORGE MAÑON ARROYO   ***************************
    ****************************   LAS FUNCIONES DE     ***************************
    ****************************   API PARA ENVIAR      ***************************
    ****************************     MENSAJES SMS       ***************************
    ****************************      25/06/2018        ***************************
    ******************************************************************************
    *****************************************************************************/


    /**************************************/
    public static function getAll(){}
    public static function getById($id){}
    public static function insert($data){}
    public static function update($data){}
    public static function delete($id){}
    /**************************************/

    /********funcion para obtener los datos telefono desde la base*********/
    public static function getMsisdnByMsisdn($msisdn){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM msisdn
        WHERE msisdn = :msisdn
sql;
        //echo $query;
        $params = array(':msisdn'=>$msisdn);
        return $mysqli->queryOne($query, $params);
    }

    /********inserta telefono en la base *********/
    public static function insertaMsisdn($msisdn, $carrier){
        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO msisdn (msisdn, carrier_id) VALUES (:msisdn, :carrier)
ON DUPLICATE KEY UPDATE msisdn = :msisdn, carrier_id = :carrier
sql;
        //echo $query;
        $params = array(
            ':msisdn'=>$msisdn,
            ':carrier'=>$carrier
        );
        return $mysqli->insert($query, $carrier);
    }

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
        WHERE user = :usuario AND pwd = :password
sql;
        //echo $query;
        $params = array(
            ':usuario'=>$usuario,
            ':password'=>$password
        );
        return $mysqli->queryOne($query, $params);
    }

    public function getIPByApiWeb($api_web_id, $ip){
	$mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM api_web_ip WHERE api_web_id = :api_web_id AND ip = :ip
sql;
	//echo $query;
        $params = array(
            ':api_web_id'=>$api_web_id,
            ':ip'=>$ip
        );
	   return $mysqli->queryAll($query, $params);
    }

/********SACAR LOS MENSAJES ENVIADOS*******/
    public static function getTotalesCustomerMes($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
        IF( SUM( uc.delivered ) IS NULL , 0, SUM( uc.delivered ) ) AS total_customer,
        IF( c.max_mt_month IS NULL , ( SELECT cc.max_mt_month FROM customer cc WHERE cc.customer_id = :customer_id ), c.max_mt_month ) AS max_mt_month,
        IF( ( c.max_mt_month - SUM( uc.delivered ) ) IS NULL , c.max_mt_month, ( c.max_mt_month - SUM( uc.delivered ) ) ) AS resta_mes
        FROM customer c
        LEFT JOIN (
            SELECT delivered , customer_id
            FROM customer_control_mt uc
            WHERE (MONTH( uc.create_time ) = MONTH( NOW( ) )
            OR MONTH( uc.create_time ) IS NULL)) AS uc 
        ON (uc.customer_id = c.customer_id)
        WHERE c.customer_id = :customer_id
sql;
        $params = array(':customer_id'=>$customer_id);
        return $mysqli->queryOne($query, $params);
    }

    public static function getTotalesCustomerDia($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
        IF( SUM( uc.delivered ) IS NULL , 0, SUM( uc.delivered ) ) AS total_customer,
        IF( c.max_mt_day IS NULL , ( SELECT cc.max_mt_day FROM customer cc WHERE cc.customer_id = :customer_id ), c.max_mt_day ) AS max_mt_day,
        IF( ( c.max_mt_day - SUM( uc.delivered ) ) IS NULL , c.max_mt_day, ( c.max_mt_day - SUM( uc.delivered ) ) ) AS resta_dia
        FROM customer c
        LEFT JOIN (
            SELECT delivered , customer_id
            FROM customer_control_mt uc
            WHERE (DATE( uc.create_time ) = DATE( NOW( ) )
            OR DATE( uc.create_time ) IS NULL)) AS uc 
        ON (uc.customer_id = c.customer_id)
        WHERE c.customer_id = :customer_id
sql;
        $params = array(':customer_id'=>$customer_id);
        return $mysqli->queryOne($query, $params);
    }


    public static function getTotalesUserMes($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
        IF( SUM( uc.delivered ) IS NULL , 0, SUM( uc.delivered ) ) AS total_user,
        IF( u.max_mt_month IS NULL , ( SELECT uu.max_mt_month FROM user uu WHERE uu.user_id =$user_id ), u.max_mt_month ) AS max_mt_month,
        IF( ( u.max_mt_month - SUM( uc.delivered ) ) IS NULL , u.max_mt_month, ( u.max_mt_month - SUM( uc.delivered ) ) ) AS resta_mes
        FROM user u
        LEFT JOIN (
            SELECT delivered , user_id
            FROM user_control_mt uc
            WHERE (MONTH( uc.create_time ) = MONTH( NOW( ) )
            OR MONTH( uc.create_time ) IS NULL)) AS uc 
        ON (uc.user_id = u.user_id)
        WHERE u.user_id = :user_id
sql;
        $params = array(':user_id'=>$user_id);
        return $mysqli->queryOne($query, $params);
    }

    public static function getTotalesUserDia($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
        IF( SUM( uc.delivered ) IS NULL , 0, SUM( uc.delivered ) ) AS total_user,
        IF( u.max_mt_day IS NULL , ( SELECT uu.max_mt_day FROM user uu WHERE uu.user_id =$user_id ), u.max_mt_day ) AS max_mt_day,
        IF( ( u.max_mt_day - SUM( uc.delivered ) ) IS NULL , u.max_mt_day, ( u.max_mt_day - SUM( uc.delivered ) ) ) AS resta_dia
        FROM user u
        LEFT JOIN (
            SELECT delivered , user_id
            FROM user_control_mt uc
            WHERE (DATE( uc.create_time ) = DATE( NOW( ) )
            OR DATE( uc.create_time ) IS NULL)) AS uc 
        ON (uc.user_id = u.user_id)
        WHERE u.user_id = :user_id
sql;
        $params = array(':user_id'=>$user_id);
        return $mysqli->queryOne($query, $params);
    }
/*******************SACAR LOS MENSAJES ENVIADOS POR EL CUSTOMER Y USUARIO******************/

    public static function getMensajesEnviadosCustomer($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT SUM(delivered) NUM_ENVIOS
        FROM customer_control_mt 
        WHERE customer_id = :customer_id
sql;
        $params = array(':customer_id'=>$customer_id);
        return $mysqli->queryOne($query, $params);
    }

    /********funcion que inserta un nuevo mensaje en colado*********/
    public static function insertSmsCampaign($campaign, $delivery, $msisdnId, $carrier_connection_short_code_id, $smsCampaignStatusId, $modulesId, $mensaje, $secuencia){
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO `sms_campaign` (campaign_id, ctime, delivery_date, msisdn_id, carrier_connection_short_code_id, sms_campaign_estatus_id, modules_id, content, secuencia)
        VALUES (:campaign, NOW(), :delivery, :msisdnId, :carrier_connection_short_code_id, :smsCampaignStatusId, :modulesId, :mensaje, :secuencia);
sql;
        //echo $query;
        $params = array(
            ':campaign'=>$campaign,
            ':delivery'=>$delivery,
            ':msisdnId'=>$msisdnId,
            ':carrier_connection_short_code_id'=>$carrier_connection_short_code_id,
            ':smsCampaignStatusId'=>$smsCampaignStatusId,
            ':modulesId'=>$modulesId,
            ':mensaje'=>$mensaje,
            ':secuencia'=>$secuencia
        );
        return $mysqli->insert($query, $params);
    }

    public static function getInsertSmsCampaign($campaign_id, $msisdnId, $ccsc_id, $mensaje){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM sms_campaign  WHERE campaign_id=:campaign AND msisdn_id=:msisdn_id AND carrier_connection_short_code_id=:carrier AND content=:content AND ctime <= NOW()
sql;
        $params = array(':campaign'=>$campaign_id,
                    ':msisdn_id'=>$msisdnId,
                    ':carrier'=>$ccsc_id,
                    ':content'=>$mensaje);
        //mail("tecnico@airmovil.com","getInsertSmsCampaign", print_r($params,1).$query);
        return $mysqli->queryOne($query,$params);
    }

    
    public static function getMesCustomer($customer, $fecha){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT SUM( delivered ) AS suma
        FROM `customer_control_mt`
        WHERE MONTH( :fecha ) = MONTH( customer_control_mt.create_time )
        AND customer_id = :customer
sql;
        return $mysqli->queryOne($query, array(':customer'=>$customer, ':fecha'=>$fecha));
    }

    public static function getDiaCustomer($customer, $fecha){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT delivered AS suma
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
        WHERE cc.customer_id = :customer_id 
        AND sc.short_code = :source
        AND aw.api_web_id = :api_web_id
        AND c.campaign_id = :campaign_id
sql;
        //echo $query;
        $params = array(
            ':customer_id'=>$customer_id,
            ':source'=>$source,
            ':api_web_id'=>$api_web_id,
            ':campaign_id'=>$campaign_id
        );
        return $mysqli->queryOne($query, $params);
    }

    public static function getMsisdnBlackList($msisdn, $customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            bt.number,
            ba.number,
            bm.number,
            IF(bt.customer_id IS NULL, IF(ba.customer_id IS NULL, bm.customer_id, ba.customer_id), bt.customer_id) customer_id
        FROM blacklist_telcel_client bt
        LEFT JOIN blacklist_att_client ba USING(number)
        LEFT JOIN blacklist_movistar_client bm USING(number)
        WHERE number = :msisdn AND :customer_id IN (bt.customer_id,ba.customer_id,bm.customer_id)
sql;
        //echo $query;
        $params = array(
            ':customer_id'=>$customer_id,
            ':msisdn'=>$msisdn
        );
        return $mysqli->queryAll($query, $params);
    }

    public static function getBadwords($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM bad_words WHERE customer_id IN(1, :customer_id)
sql;
        //mail('jorge.manon@airmovil.com', 'Query badword', "Query : $query");
        $params = array(':customer_id'=>$customer_id);
        return $mysqli->queryAll($query, $params);
    }

    public static function getBolsaMT($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT
IF( fecha_compra IS NULL , now( ) , fecha_compra ) AS fecha_compra, 
IF( fecha_expira IS NULL , now( ) , fecha_expira ) AS fecha_expira, 
now( ) AS fecha_actual,
IF( (SELECT sum(delivered) FROM customer_control_mt WHERE customer_id= :customer_id AND create_time >= sb.fecha_compra AND create_time <= sb.fecha_expira) is null,
    0,
    (SELECT sum(delivered) FROM customer_control_mt WHERE customer_id= :customer_id AND create_time >= sb.fecha_compra AND create_time <= sb.fecha_expira) 
    ) as delivered,
IF( (SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id= :customer_id AND estatus=1) is null,
    0,
    (
        (SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id= :customer_id AND estatus=1) - IF( 
            (SELECT sum(delivered) FROM customer_control_mt WHERE customer_id= :customer_id AND create_time >= sb.fecha_compra AND create_time <= sb.fecha_expira) is null,
            0,
            (SELECT sum(delivered) FROM customer_control_mt WHERE customer_id= :customer_id AND create_time >= sb.fecha_compra AND create_time <= sb.fecha_expira)
        ) 
    )
    ) AS resta_bolsa,
IF( (SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id= :customer_id AND estatus=1) is null, 
    0,
    (
        SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id= :customer_id AND estatus=1
    ) ) AS bolsa_sms
FROM customer_control_mt cmt
LEFT JOIN sms_bag sb USING ( customer_id )
WHERE sb.estatus =1
AND sb.customer_id= :customer_id
AND sb.fecha_expira >= NOW( )
GROUP BY bolsa_sms
ORDER BY fecha_expira DESC
sql;
        //mail("tecnico@airmovil.com","query bolsa", $query);
        $params = array(':customer_id'=>$customer_id);

        return $mysqli->queryAll($query, $params);

    }

    public static function getPercenTolerancia($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT tolerance FROM customer WHERE customer_id= :customer_id
sql;
        $params = array(':customer_id'=>$customer_id);
        return $mysqli->queryOne($query, $params);
    }

}
