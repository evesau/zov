<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Apimail2sms implements Crud{

    public static function getAll(){}

    public static function insert($datos){}

    public static function update($datos){}

    public static function delete($id){}

    public static function getById($id){}

    public static function buscaMail($mail){
        $mysqli = Database::getInstance(true, true);
        $query =<<<sql
SELECT * FROM mail2sms WHERE `mail`= :mail AND status=1;
sql;
//mail("esau.espinoza@airmovil.com", "entre a models", "mail:+".$mail."+query:".$query);

        return $mysqli->queryOne($query,array(':mail' => trim($mail)));
    }

    public static function insertCampaign($datosCampania){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO campaign (name, created, modules_id, delivery_date, campaign_status_id) VALUES (:name, NOW(), 18, NOW(),2)
sql;

        $params = array(
            ':name'     => $datosCampania->_name);


        return $mysqli->insert($query,$params);
    }

    public static function insertCampaignUser($userId, $campaniaId){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `campaign_user` (user_id, campaign_id)
VALUES (:user, :campaign);
sql;
        $params = array(':user'=>$userId,
                        ':campaign'=>$campaniaId);

    return $mysqli->insert($query, $params);
    }

    public static function insertaCampaniaCustomer($customer, $campaign){

    $mysqli = Database::getInstance();
    $query=<<<sql
INSERT INTO `campaign_customer` (customer_id, campaign_id)
VALUES (:customer, :campaign);
sql;

    return $mysqli->insert($query, array(':customer'=>$customer, ':campaign'=>$campaign));
    }

    public static function insertaCampaniaCarrierShortCode($campaign, $carrier, $shortCode){
        //mail("exa.vill87@gmail.com", "insert", "campaign_id:".$campaign." carrier:".$carrier." short_code_id:".$shortCode);

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `campaign_carrier_short_code` (campaign_id, carrier_id, short_code_id)
VALUES (:campaign, :carrier, :short_code);
sql;

        return $mysqli->insert($query, array(':campaign'=>$campaign, ':carrier'=>$carrier, ':short_code'=>$shortCode));
    }

    public static function insertMailcampaign($datosMailcamp){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO mail2sms_campaign (content, total, mail2sms_id, campaign_id) VALUES (:mensaje, :total, :mail_id, :campaign_id)
sql;

        $params = array(
            ':mensaje'      => $datosMailcamp->_mensaje,
            ':total'        => $datosMailcamp->_total,
            ':mail_id'      => $datosMailcamp->_mail_id,
            ':campaign_id'  => $datosMailcamp->_campaign_id);


        return $mysqli->insert($query,$params);
    }

    public static function insertMsisdn($msisdn, $carrier_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO msisdn (msisdn, carrier_id) VALUES ($msisdn, $carrier_id)
sql;
        return $mysqli->insert($query);
    }

    public static function buscaCCSC($mail_id){
        $mysqli = Database::getInstance();
/*
        $query =<<<sql
SELECT * FROM mail2sms_carrier_connection_short_code WHERE mail2sms_id=$mail_id ORDER BY mail2sms_carrier_connection_short_code_id DESC
sql;
*/
	$query=<<<sql
SELECT * 
FROM mail2sms_carrier_connection_short_code
INNER JOIN carrier_connection_short_code AS ccsc
USING ( carrier_connection_short_code_id ) 
INNER JOIN carrier AS c
USING ( carrier_id ) 
WHERE mail2sms_id = $mail_id
sql;

        return $mysqli->queryAll($query);
    }

    public static function insertCCSCC($datosCCSCC){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO carrier_connection_short_code_campaign (carrier_connection_short_code_id, campaign_id) VALUES (:ccsc_id, :campaign_id)
sql;

        $params = array(
            ':ccsc_id'      => $datosCCSCC->_ccsc_id,
            ':campaign_id'  => $datosCCSCC->_campaign_id);

        return $mysqli->insert($query,$params);
    }

    public static function insertSmsCampaign($datosSmscampaign){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO sms_campaign (campaign_id, ctime,delivery_date, msisdn_id, content, carrier_connection_short_code_id, sms_campaign_estatus_id, modules_id) VALUES (:campaign_id, NOW(), NOW(), :msisdn_id, :mensaje, :ccsc_id, :sce_id, 18)
sql;

    $params = array(
        ':campaign_id'      => $datosSmscampaign->_campaign_id,
        ':msisdn_id'        => $datosSmscampaign->_msisdn_id,
        ':mensaje'          => $datosSmscampaign->_mensaje,
        ':ccsc_id'          => $datosSmscampaign->_ccsc_id,
        ':sce_id'           => $datosSmscampaign->_sce_id);

    return $mysqli->insert($query, $params);

    }

    public static function buscaCarrier($carrier){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT carrier_id FROM carrier WHERE name='$carrier'
sql;

        return $mysqli->queryOne($query);
    }

    public static function buscaMsisdnId($msisdn,$carrier_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * , m.msisdn_id AS msisdnId
FROM msisdn AS m
LEFT JOIN msisdn_white_list
USING ( msisdn_id ) 
WHERE msisdn = $msisdn
AND carrier_id = $carrier_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function insertaWhiteList($msisdnId, $carrier){

	$mysqli = Database::getInstance();
	$query=<<<sql
INSERT INTO `msisdn_white_list` (msisdn_id, carrier_connection_id) VALUES ($msisdnId, $carrier);
sql;

	return $mysqli->insert($query);
    }

    public static function buscaShortCode($id){
    
    $mysqli = Database::getInstance();
    $query=<<<sql
SELECT * FROM `carrier_connection_short_code` AS ccsc 
INNER JOIN carrier_connection AS cci USING (carrier_connection_id)
INNER JOIN short_code AS sc USING (short_code_id)
INNER JOIN carrier AS c USING (carrier_id)
WHERE carrier_connection_short_code_id IN ($id)
sql;

    return $mysqli->queryAll($query);
    }

    public static function registroUsuario($registro){
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

    public static function buscaCarrierMsisdn($msisdn){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM `msisdn` WHERE `msisdn` =$msisdn AND carrier_id NOT IN ( -1, 0 ) ORDER BY `msisdn`.`msisdn_id` DESC LIMIT 1 
sql;
        
        return $mysqli->queryOne($query);
    }

}
