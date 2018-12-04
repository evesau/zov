<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class CampaignBuscaCarrier implements Crud
{

    /*public static function getControlMtCustomer($customer){

        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT customer
sql;

        return $mysqli->queryOne($query);
    }*/

     public static function getTotalesCustomerMes($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT 
IF( SUM( uc.delivered ) IS NULL , 0, SUM( uc.delivered ) ) AS total_customer,
IF( c.max_mt_month IS NULL , ( SELECT cc.max_mt_month FROM customer cc WHERE cc.customer_id =$customer_id ), c.max_mt_month ) AS max_mt_month,
IF( ( c.max_mt_month - SUM( uc.delivered ) ) IS NULL , c.max_mt_month, ( c.max_mt_month - SUM( uc.delivered ) ) ) AS resta_mes
FROM customer c
LEFT JOIN (
    SELECT delivered , customer_id
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
IF( SUM( uc.delivered ) IS NULL , 0, SUM( uc.delivered ) ) AS total_customer,
IF( c.max_mt_day IS NULL , ( SELECT cc.max_mt_day FROM customer cc WHERE cc.customer_id =$customer_id ), c.max_mt_day ) AS max_mt_day,
IF( ( c.max_mt_day - SUM( uc.delivered ) ) IS NULL , c.max_mt_day, ( c.max_mt_day - SUM( uc.delivered ) ) ) AS resta_dia
FROM customer c
LEFT JOIN (
    SELECT delivered , customer_id
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
WHERE u.user_id =$user_id
sql;

        return $mysqli->queryOne($query);
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
WHERE u.user_id = $user_id
sql;

        return $mysqli->queryOne($query);
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

    public static function getViewUserDia($customer, $fecha){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT user.user_id AS user_id, user.nickname AS Usuario,
customer.max_mt_day AS Max_Mt_Day_Customer,
IF((customer.max_mt_day - sum(ucmt.count)) is NULL, customer.max_mt_day, (customer.max_mt_day - sum(ucmt.count))) AS No_Mensajes_Faltantes_Day_Customer,
user.max_mt_day AS Max_Mt_Day_Usuario,
IF((user.max_mt_day - sum(ucmt.count)) is NULL, user.max_mt_day, (user.max_mt_day - sum(ucmt.count))) AS No_Mensajes_Faltantes_Day_Usuario,
month(now()) AS Mes_Actual
FROM user
LEFT JOIN (
    SELECT user_id, count 
    FROM user_control_mt AS ucmt 
    WHERE cast(:fecha AS DATE) = cast(ucmt.create_time AS DATE)) ucmt ON (ucmt.user_id = user.user_id)
LEFT JOIN user_customer ON (user.user_id = user_customer.user_id) 
LEFT JOIN customer ON (user_customer.customer_id = customer.customer_id)
WHERE user.status = 1 AND customer.status = 1 AND user.user_id = :id
sql;
    /*   $query=<<<sql
SELECT user.user_id AS "user_id", user.nickname AS "Usuario", customer.max_mt_day AS "Max_Mt_Day_Customer", 
IF((customer.max_mt_day - (SELECT SUM(count) FROM customer_control_mt WHERE CAST(NOW() AS DATE) = CAST(update_time AS DATE))) IS NULL, 
    customer.max_mt_day, (customer.max_mt_day -(SELECT SUM(count) FROM customer_control_mt WHERE CAST(NOW() AS DATE) = CAST(update_time AS DATE)))) AS "No_Mensajes_Faltantes_Day_Customer", 
user.max_mt_day AS "Max_Mt_Day_Usuario",
IF((user.max_mt_day - SUM(user_control_mt.count)) IS NULL, user.max_mt_day, (user.max_mt_day - SUM(user_control_mt.count))) AS "No_Mensajes_Faltantes_Day_Usuario", 
MONTH(NOW()) AS "Mes_Actual" 
FROM user_control_mt 
JOIN user ON (user_control_mt.user_id = user.user_id) 
JOIN user_customer ON (user_control_mt.user_id = user_customer.user_id) 
JOIN customer ON (user_customer.customer_id = customer.customer_id) 
WHERE CAST(:fecha AS DATE) = CAST(user_control_mt.create_time AS DATE) 
AND user.status = 1 
AND customer.status = 1 
AND user.user_id = :id
sql;*/

        return $mysqli->queryOne($query, array(':id'=>$customer, ':fecha'=>$fecha));
    }    

    public static function getViewUserMes($customer, $fecha){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT user.user_id AS id, user.nickname AS Usuario,
customer.max_mt_month AS Max_Mt_Month_Customer,
IF((customer.max_mt_month - sum(ucmt.count)) is NULL, customer.max_mt_month, (customer.max_mt_month - sum(ucmt.count))) AS No_Mensajes_Faltantes_Month_Customer,
user.max_mt_month AS Max_Mt_Month_Usuario,
IF((user.max_mt_month - sum(ucmt.count)) is NULL, user.max_mt_month, (user.max_mt_month - sum(ucmt.count))) AS No_Mensajes_Faltantes_Month_Usuario,
MONTH(now()) AS Mes_Actual
FROM user
LEFT JOIN (
    SELECT user_id, count 
    FROM user_control_mt AS ucmt 
    WHERE MONTH( :fecha ) = MONTH( ucmt.create_time )) ucmt ON (ucmt.user_id = user.user_id)
LEFT JOIN user_customer ON (user.user_id = user_customer.user_id) 
LEFT JOIN customer ON (user_customer.customer_id = customer.customer_id)
WHERE user.status = 1 AND customer.status = 1 AND user.user_id = :id
sql;

    /*$query=<<<sql
SELECT user.user_id AS "user_id", user.nickname AS "Usuario", 
customer.max_mt_month AS "Max_Mt_Month_Customer", 
IF((customer.max_mt_month - (SELECT SUM(count) FROM customer_control_mt)) IS NULL, customer.max_mt_month, (customer.max_mt_month - (SELECT SUM(count) FROM customer_control_mt))) AS "No_Mensajes_Faltantes_Month_Customer", 
user.max_mt_month AS "Max_Mt_Month_Usuario", 
IF((user.max_mt_month - SUM(user_control_mt.count)) IS NULL, user.max_mt_day, (user.max_mt_month - SUM(user_control_mt.count))) AS "No_Mensajes_Faltantes_Month_Usuario", 
MONTH( NOW( ) ) AS "Mes_Actual" 
FROM user_control_mt 
JOIN user ON ( user_control_mt.user_id = user.user_id ) 
JOIN user_customer ON ( user_control_mt.user_id = user_customer.user_id ) 
JOIN customer ON ( user_customer.customer_id = customer.customer_id ) 
WHERE MONTH( :fecha ) = MONTH( user_control_mt.create_time ) 
AND user.status =1 
AND customer.status =1 
AND user.user_id = :id
sql; */

        return $mysqli->queryOne($query, array(':id'=>$customer, ':fecha'=>$fecha));
    }


    public static function getClientesCustomer($customer){
	
	$mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM `client`
INNER JOIN customer_client USING (client_id)
WHERE customer_id = :id
AND status = 1
ORDER BY name ASC
sql;

        return $mysqli->queryAll($query, array(':id'=>$customer));	
    }

    public static function getAll()
    {
	$mysqli = Database::getInstance();
	$query=<<<sql
sql;

	return $mysqli->queryAll($query);
    }

    public static function getAllCampaign($id)
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * , c.name AS nombre, cs.name AS
status , m.name AS modulo
FROM `campaign` AS c
INNER JOIN campaign_status AS cs
USING ( campaign_status_id )
INNER JOIN modules AS m
USING ( modules_id )
INNER JOIN campaign_customer AS cc
USING ( campaign_id )
WHERE customer_id = :id ;
sql;

        return $mysqli->queryAll($query, array(':id'=>$id));
    }

    public static function getCarrier($customer){

	$mysqli = Database::getInstance();
	$query=<<<sql
SELECT *
FROM `custome_carrier_connection_short_code` AS cccs
INNER JOIN carrier_connection_short_code AS ccsc
USING ( carrier_connection_short_code_id )
INNER JOIN carrier_connection AS cc
USING ( carrier_connection_id )
INNER JOIN short_code AS sc
USING ( short_code_id )
INNER JOIN carrier AS c
USING ( carrier_id )
WHERE status = 1
AND customer_id = :customer 
GROUP BY short_code_id;
sql;

	return $mysqli->queryAll($query, array(':customer'=>$customer));
    }

    public static function getCarrierCustomer($customer, $shortCode){
	
	$mysqli = Database::getInstance();
        $query=<<<sql
SELECT *
FROM `custome_carrier_connection_short_code` AS cccs
INNER JOIN carrier_connection_short_code AS ccsc
USING ( carrier_connection_short_code_id )
INNER JOIN carrier_connection AS cc
USING ( carrier_connection_id )
INNER JOIN short_code AS sc
USING ( short_code_id )
INNER JOIN carrier AS c
USING ( carrier_id )
WHERE status = 1
AND customer_id = :customer 
AND short_code_id = :shortCode
sql;
	   return $mysqli->queryAll($query, array(':customer'=>$customer, ':shortCode'=>$shortCode));
    }
  
     public static function getCarrierCustomerGroup($customer){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT short_code_id, short_code 
FROM `custome_carrier_connection_short_code` AS cccs
INNER JOIN carrier_connection_short_code AS ccsc
USING ( carrier_connection_short_code_id )
INNER JOIN carrier_connection AS cc
USING ( carrier_connection_id )
INNER JOIN short_code AS sc
USING ( short_code_id )
INNER JOIN carrier AS c
USING ( carrier_id )
WHERE status = 1
AND customer_id = :customer
GROUP BY short_code_id
sql;

        return $mysqli->queryAll($query, array(':customer'=>$customer));
    }

    public static function getById($id)
    {
	$mysqli = Database::getInstance();

    $query=<<<sql
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

    public static function update($obj)
    {
    	$mysqli = Database::getInstance();

	$query=<<<sql
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

    public static function delete($id)
    {
	$mysqli = Database::getInstance();
	$query=<<<sql
UPDATE `carrier_connection` SET status = 0, last_update = NOW(), deleted = NOW(), created = created
WHERE carrier_connection_id = :id ;
sql;
	return $mysqli->update($query, array(':id'=>$id));	
    }

    public static function findCarriers($in){
	
	$mysqli = Database::getInstance();
	$query=<<<sql
SELECT * FROM `carrier_connection_short_code` AS ccsc 
INNER JOIN carrier_connection AS cci USING (carrier_connection_id)
INNER JOIN short_code AS sc USING (short_code_id)
INNER JOIN carrier AS c USING (carrier_id)
WHERE carrier_connection_short_code_id IN ($in)
sql;

	return $mysqli->queryAll($query);
    }
 
    public static function findBlackList($msisdn, $carrier = 'telcel'){

    	$mysqli = Database::getInstance();
    	$query=<<<sql
SELECT * FROM blacklist_$carrier
WHERE number = :msisdn
sql;
       return $mysqli->queryOne($query, array(':msisdn'=>$msisdn));
	
    }

    public static function findBlackListMulti($msisdn, $customer_id){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT
IF(bt.number='$msisdn', bt.number,'') as telcel,
IF(ba.number='$msisdn', ba.number,'') as att,
IF(bm.number='$msisdn', bm.number,'') as movistar
FROM blacklist_telcel_client bt
LEFT JOIN blacklist_att_client ba USING (customer_id)
LEFT JOIN blacklist_movistar_client bm USING (customer_id)
INNER JOIN customer USING (customer_id)
WHERE customer_id = $customer_id
AND '$msisdn' IN (bt.number,ba.number,bm.number)
GROUP BY '$msisdn'
        
sql;
       //mail('esau.espinoza@airmovil.com','Query BlackList','Query: '.$query);
       return $mysqli->queryAll($query);
    
    }

    public static function getMesUser($user){

    $mysqli = Database::getInstance();
    $query=<<<sql
SELECT *
FROM `vista_control_usuario_mes`
WHERE user_id = :user
sql;

        return $mysqli->queryOne($query, array(':user'=>$user));
    }

    public static function getDiaUser($user){

    $mysqli = Database::getInstance();
    $query=<<<sql
SELECT  *
FROM `vista_control_usuario_dia`
WHERE user_id = :user
sql;

    return $mysqli->queryOne($query, array(':user'=>$user));
    }

    public static function getUserMt($user){

    $mysqli = Database::getInstance();
    $query=<<<sql
SELECT * FROM `user` 
WHERE user_id = :user
AND status = 1 
sql;

    return $mysqli->queryOne($query, array(':user'=>$user));
    }

    public static function getMsisdnCatalogo($msisdn, $carrier){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM `msisdn`
WHERE msisdn = :msisdn
AND carrier_id = :carrier_id ;
sql;

        return $mysqli->queryOne($query, array(':msisdn'=>$msisdn, ':carrier_id'=>$carrier));
    }

    public static function getMsisdnCatalogoMsisdn($msisdn){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM `msisdn`
WHERE msisdn = $msisdn
sql;

        return $mysqli->queryOne($query);
    }

    public static function getMsisdnCatalogoBuscaCarrier($msisdn){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM `msisdn`
WHERE msisdn = :msisdn
sql;

        return $mysqli->queryOne($query, array(':msisdn'=>$msisdn));
    }

    public static function insertaCampaniaIni($name, $modulo, $fecha, $status){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `campaign` (name, created, modules_id, delivery_date, campaign_status_id)
VALUES (:name, NOW(), :modules_id, :delivery_date, :campaign_status_id);
sql;

        return $mysqli->insert($query, array(':name'=>$name, ':modules_id'=>$modulo, ':delivery_date'=>$fecha, ':campaign_status_id'=>$status));
    }

    public static function insertaCampaniaCustomer($customer, $campaign){

	$mysqli = Database::getInstance();
	$query=<<<sql
INSERT INTO `campaign_customer` (customer_id, campaign_id)
VALUES (:customer, :campaign);
sql;

	return $mysqli->insert($query, array(':customer'=>$customer, ':campaign'=>$campaign));
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

    public static function insertaCampaniaCarrierShortCode($campaign, $carrier, $shortCode){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `campaign_carrier_short_code` (campaign_id, carrier_id, short_code_id)
VALUES (:campaign, :carrier, :short_code);
sql;

        return $mysqli->insert($query, array(':campaign'=>$campaign, ':carrier'=>$carrier, ':short_code'=>$shortCode));
    }

    public static function insertaCarrierConnectionShortCodeCampaign($campaign, $shortCode){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `carrier_connection_short_code_campaign` (carrier_connection_short_code_id, campaign_id)
VALUES (:short_code, :campaign);
sql;

        return $mysqli->insert($query, array(':campaign'=>$campaign, ':short_code'=>$shortCode));
    }


    public static function insertaMsisdn($msisdn, $carrier){
        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `msisdn` (msisdn, carrier_id)
VALUES (:msisdn, :carrier_id);
sql;

        return $mysqli->insert($query, array(':msisdn'=>$msisdn, ':carrier_id'=>$carrier));
    }

    public static function updateMsisdnBuscaCarrier($msisdn){
        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE `msisdn` SET carrier_id = 0 
WHERE msisdn_id = :msisdn ;
sql;

        return $mysqli->insert($query, array(':msisdn'=>$msisdn));
    }

    public static function updateMsisdnCarrier($msisdn, $carrier){
        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE `msisdn` SET carrier_id = $carrier
WHERE msisdn_id = :msisdn ;
sql;

        return $mysqli->insert($query, array(':msisdn'=>$msisdn));
    }

    public static function insertaClient($name, $status){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `client` (name, status)
VALUES (:name, :status);
sql;

        return $mysqli->insert($query, array(':name'=>$name, ':status'=>$status));
    }

    public static function insertaCustomerClient($customer, $client){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `customer_client` (customer_id, client_id)
VALUES (:customer, :client);
sql;

        return $mysqli->insert($query, array(':customer'=>$customer, ':client'=>$client));
    }

    public static function insertaClientMsisdn($client, $msisdn){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT IGNORE INTO `client_msisdn` (client_id, msisdn_id) 
VALUES (:client, :msisdn);
sql;

        return $mysqli->insert($query, array(':client'=>$client, ':msisdn'=>$msisdn));
    }

    public static function insertSmsCampaign($campaign, $delivery, $msisdnId, $carrier, $smsCampaign, $modulesId, $mensaje){

	$mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `sms_campaign` (campaign_id, ctime, delivery_date, msisdn_id, carrier_connection_short_code_id, sms_campaign_estatus_id, modules_id, content)
VALUES (:campaign, NOW(), :delivery, :msisdn_id, :carrier, :sms_campaign, :modules_id, :content);
sql;

        return $mysqli->insert($query, array(':campaign'=>$campaign, ':delivery'=>$delivery,
					':msisdn_id'=>$msisdnId, ':carrier'=>$carrier, 
					':sms_campaign'=>$smsCampaign, ':modules_id'=>$modulesId, ':content'=>$mensaje));
    }

    public static function getCampaignApiWeb($campaign_id, $tipo_envio){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM
        campaign_api_web
        WHERE campaign_id=$campaign_id
        AND api_web_type_id = $tipo_envio
sql;
        return $mysqli->queryAll($query);
    }

    public static function insertSmsCampaignSecuencia($campaign, $delivery, $msisdnId, $carrier, $smsCampaign, $modulesId, $mensaje, $secuencia){

    $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `sms_campaign` (campaign_id, ctime, delivery_date, msisdn_id, carrier_connection_short_code_id, sms_campaign_estatus_id, modules_id, content, secuencia)
VALUES (:campaign, NOW(), :delivery, :msisdn_id, :carrier, :sms_campaign, :modules_id, :content, :secuencia);
sql;

        return $mysqli->insert($query, array(':campaign'=>$campaign, ':delivery'=>$delivery,
                    ':msisdn_id'=>$msisdnId, ':carrier'=>$carrier, 
                    ':sms_campaign'=>$smsCampaign, ':modules_id'=>$modulesId, ':content'=>$mensaje, ':secuencia' => $secuencia));
    }

    /*public static function getCampaignApiWeb($campaign_id, $tipo_envio){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM
        campaign_api_web
        WHERE campaign_id=$campaign_id
        AND api_web_type_id = $tipo_envio
sql;
        return $mysqli->queryAll($query);
    }*/

    public static function estatusCampaign($campaign, $estatus){

        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE `campaign` SET campaign_status_id = :estatus
WHERE campaign_id = :campaign
sql;

        return $mysqli->update($query, array(':campaign'=>$campaign, ':estatus'=>$estatus));
    }

    public static function insertMsisdnWhiteList($msisdnId, $carrier, $status){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT IGNORE INTO `msisdn_white_list` (msisdn_id, carrier_connection_id, status)
VALUES (:msisdn_id, :carrier_connection_id, :status);
sql;

        return $mysqli->insert($query, array(':msisdn_id'=>$msisdnId, ':carrier_connection_id'=>$carrier,
                                        ':status'=>$status));
    }

    public static function getMsisdnWhiteList($msisdn, $carrier){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM `msisdn_white_list`
WHERE msisdn_id = :msisdn 
AND carrier_connection_id = :carrier
sql;

        return $mysqli->queryOne($query, array(':msisdn'=>$msisdn, ':carrier'=>$carrier));
    }

    public static function campaignCustomerEstatus($customer, $campaign){

	$mysqli = Database::getInstance();
	$query=<<<sql
SELECT * FROM `campaign_customer` AS cc
INNER JOIN campaign AS c USING (campaign_id)
INNER JOIN campaign_status AS cs USING (campaign_status_id)
WHERE customer_id = :customer AND campaign_id = :campaign
sql;

	return $mysqli->queryOne($query, array(':customer'=>$customer, ':campaign'=>$campaign));
    }

    public static function campaignCustomerEstatusMts($campaign){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT estatus, count( * ) AS marcadores
FROM `sms_campaign` AS sc
INNER JOIN sms_campaign_estatus AS sce
USING ( sms_campaign_estatus_id )
WHERE campaign_id = :campaign
GROUP BY sms_campaign_estatus_id
sql;

        return $mysqli->queryAll($query, array(':campaign'=>$campaign));
    }

    public static function validateCustomerCliente($customer, $baseExistente){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT *
FROM `customer_client` AS cc
INNER JOIN client AS c
USING ( client_id )
WHERE STATUS = 1
AND customer_client_id = $baseExistente
AND customer_id = $customer
sql;

        return $mysqli->queryOne($query);
    }

    public static function clientMsisdnCarrier($customer, $client){

	$mysqli = Database::getInstance();
	$query=<<<sql
SELECT * FROM `customer` AS c
INNER JOIN customer_client AS cc USING (customer_id)
INNER JOIN client AS cli USING (client_id)
INNER JOIN client_msisdn AS cm USING (client_id)
INNER JOIN msisdn AS m USING (msisdn_id)
WHERE cli.status = 1
AND client_id = :client
AND customer_id = :customer
sql;
	return $mysqli->queryAll($query, array(':customer'=>$customer, ':client'=>$client));
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

    public static function getSembrados($customer_id){
        $mysqli = Database::getInstance();
        $query =<<< sql
SELECT m.msisdn, cc.carrier_connection_id, mwl.status as white_list,c.carrier_id,sc.short_code_id, ccsc.carrier_connection_short_code_id, m.msisdn_id, c.name,ms.msisdn_log,ms.identificador
FROM msisdn_sembrados ms
INNER JOIN msisdn m USING (msisdn_id)
INNER JOIN carrier c USING (carrier_id)
INNER JOIN carrier_connection_short_code ccsc USING (carrier_id)
INNER JOIN carrier_connection cc USING (carrier_connection_id)
INNER JOIN short_code sc ON (sc.short_code_id=ccsc.short_code_id)
INNER JOIN custome_carrier_connection_short_code cccsc ON (cccsc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
LEFT JOIN msisdn_white_list mwl ON (mwl.msisdn_id=ms.msisdn_id)
WHERE estatus = 1 AND ms.customer_id = $customer_id
GROUP BY msisdn_id
sql;

        return $mysqli->queryAll($query);
    }

        public static function getDataUser($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT first_name, last_name FROM user WHERE user_id = "$id"
sql;
        return $mysqli->queryOne($query);
    }

    public static function getDataCustomer($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT name FROM customer WHERE customer_id = "$id"
sql;
        return $mysqli->queryOne($query);
    }


    public static function getBolsaMT($customer_id){
        $mysqli = Database::getInstance();
        $queryBack =<<<sql
SELECT
IF( fecha_compra IS NULL , now( ) , fecha_compra ) AS fecha_compra, 
IF( fecha_expira IS NULL , now( ) , fecha_expira ) AS fecha_expira, 
now( ) AS fecha_actual, 
IF( sum( delivered ) IS NULL , 0, sum( delivered ) ) AS delivered, 
IF( (SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id =$customer_id AND estatus=1) is null,
    0,
    ((SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id =$customer_id AND estatus=1) - IF( sum( delivered ) IS NULL , 0, sum( delivered ) ) )
    ) AS resta_bolsa,
IF( (SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id =$customer_id AND estatus=1) is null, 
    0,
    (SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id =$customer_id AND estatus=1)
    ) AS bolsa_sms
FROM customer_control_mt cmt
LEFT JOIN sms_bag sb USING ( customer_id )
WHERE create_time <= fecha_expira
AND create_time >= fecha_compra
AND estatus =1
AND customer_id =$customer_id
AND fecha_expira >= NOW( )
ORDER BY fecha_expira DESC
sql;

        $query =<<<sql
SELECT
IF( sb.fecha_compra IS NULL , now( ) , sb.fecha_compra ) AS fecha_compra, 
IF( sb.fecha_expira IS NULL , now( ) , sb.fecha_expira ) AS fecha_expira, 
now( ) AS fecha_actual,
IF( (SELECT sum(delivered) FROM customer_control_mt WHERE customer_id=$customer_id AND create_time >= sb.fecha_compra AND create_time <= sb.fecha_expira) is null,
    0,
    (SELECT sum(delivered) FROM customer_control_mt WHERE customer_id=$customer_id AND create_time >= sb.fecha_compra AND create_time <= sb.fecha_expira) 
    ) as delivered,
IF( (SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id=$customer_id AND estatus=1) is null,
    0,
    (
        (SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id=$customer_id AND estatus=1) - IF( 
            (SELECT sum(delivered) FROM customer_control_mt WHERE customer_id=$customer_id AND create_time >= sb.fecha_compra AND create_time <= sb.fecha_expira) is null,
            0,
            (SELECT sum(delivered) FROM customer_control_mt WHERE customer_id=$customer_id AND create_time >= sb.fecha_compra AND create_time <= sb.fecha_expira)
        ) 
    )
    ) AS resta_bolsa,
IF( (SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id=$customer_id AND estatus=1) is null, 
    0,
    (
        SELECT sum(cantidad) FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id=$customer_id AND estatus=1
    ) ) AS bolsa_sms
FROM customer_control_mt cmt
LEFT JOIN sms_bag sb USING ( customer_id )
WHERE sb.estatus =1
AND sb.customer_id=$customer_id
AND sb.fecha_expira >= NOW( )
GROUP BY bolsa_sms
ORDER BY sb.fecha_expira DESC
sql;
        //mail("tecnico@airmovil.com","query bolsa", $query);

        return $mysqli->queryAll($query);

    }


    public static function getCompraSms($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM sms_bag WHERE fecha_expira >= NOW() AND customer_id =$customer_id AND estatus=1
sql;
        return $mysqli->queryAll($query);
    }


    public static function getPercenTolerancia($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT tolerance FROM customer WHERE customer_id=$customer_id
sql;
        return $mysqli->queryOne($query);
    }


    public static function getInsertSmsCampaign($campaign, $delivery, $msisdnId, $carrier, $modulesId, $mensaje){

    $mysqli = Database::getInstance();
        $query=<<<sql
SELECT sms_campaign_id FROM `sms_campaign` WHERE campaign_id=:campaign AND ctime>=NOW() AND delivery_date=:delivery AND msisdn_id=:msisdn_id AND carrier_connection_short_code_id=:carrier AND modules_id=:modules_id AND content=:content
sql;

        return $mysqli->queryOne($query, array( ':campaign'=>$campaign, 
                                                ':delivery'=>$delivery,
                                                ':msisdn_id'=>$msisdnId, 
                                                ':carrier'=>$carrier, 
                                                ':modules_id'=>$modulesId, 
                                                ':content'=>$mensaje)
                );
    }

}
