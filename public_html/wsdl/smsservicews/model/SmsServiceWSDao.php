<?php
include 'DatabaseDao.php';
class SmsServiceWSDao{

    public static function getAll(){}

    public static function getById($data){
	$mysqli = DatabaseDao::getInstance();	
	$query=<<<sql
sql;

	return $mysqli->queryOne($query);
    }

    public static function insert($data){
	$mysqli = DatabaseDao::getInstance();
	$query=<<<sql
sql;

	return $mysqli->insert($query);

    }

    public static function update($data){

	$mysqli = DatabaseDao::getInstance();
        $query=<<<sql
sql;

        return $mysqli->update($query);
    }

    public static function delete($id){}

    public static function getAllCampaignCustomer($customer_id,$nameCampaign){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT *
FROM campaign cam
INNER JOIN campaign_customer camc
USING ( campaign_id )
INNER JOIN customer cus
USING ( customer_id )
WHERE cus.customer_id =$customer_id
AND cus.status =1
AND cam.name = UPPER( '$nameCampaign' )
ORDER BY cam.campaign_id DESC
sql;
        //mail("esau.espinoza@airmovil.com","getAllCampaignCustomer",$query);
        return $mysqli->queryAll($query);
    }


    public static function getCarrierConnectionShortCode($customer_id,$ShortCode){
        $mysqli = DatabaseDao::getInstance();

        if (!empty($ShortCode)) {
            $short_code = "AND sc.short_code =$ShortCode";
        }

        $query =<<<sql
SELECT *
FROM carrier_connection cc
INNER JOIN carrier_connection_short_code ccsc
USING ( carrier_connection_id )
INNER JOIN custome_carrier_connection_short_code cccsc
USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc ON ( sc.short_code_id = ccsc.short_code_id )
INNER JOIN carrier ca ON ( ca.carrier_id = ccsc.carrier_id )
WHERE cc.status =1
AND cccsc.customer_id =$customer_id
$short_code
sql;
        //mail("esau.espinoza@airmovil.com","getCarrierConnectionShortCode",$query);
        return $mysqli->queryAll($query);
    }

    public static function insertaCampaniaIni($name, $modulo, $status){
        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
INSERT INTO `campaign` (name, created, modules_id, delivery_date, campaign_status_id)
VALUES (:name, NOW(), :modules_id, NOW(), :campaign_status_id);
sql;

        return $mysqli->insert($query, array(':name'=>$name, ':modules_id'=>$modulo, ':campaign_status_id'=>$status));
    }

    public static function insertCampaignUser($userId, $campaniaId){
        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
INSERT INTO `campaign_user` (user_id, campaign_id) VALUES (:user, :campaign);
sql;
        $params = array(':user'=>$userId, ':campaign'=>$campaniaId);

        return $mysqli->insert($query, $params);
    }


    public static function insertaCampaniaCustomer($customer, $campaign){

    $mysqli = DatabaseDao::getInstance();
    $query=<<<sql
INSERT INTO `campaign_customer` (customer_id, campaign_id) VALUES (:customer, :campaign);
sql;

    return $mysqli->insert($query, array(':customer'=>$customer, ':campaign'=>$campaign));
    }


    public static function insertaCampaniaCarrierShortCode($campaign, $carrier, $shortCode){

        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
INSERT INTO `campaign_carrier_short_code` (campaign_id, carrier_id, short_code_id) VALUES (:campaign, :carrier, :short_code);
sql;

        return $mysqli->insert($query, array(':campaign'=>$campaign, ':carrier'=>$carrier, ':short_code'=>$shortCode));
    }


    public static function insertaCarrierConnectionShortCodeCampaign($campaign, $shortCode){

        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
INSERT INTO `carrier_connection_short_code_campaign` (carrier_connection_short_code_id, campaign_id) VALUES (:short_code, :campaign);
sql;

        return $mysqli->insert($query, array(':campaign'=>$campaign, ':short_code'=>$shortCode));
    }

    public static function getAllCampaign($id)
    {
	$mysqli = DatabaseDao::getInstance();
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
WHERE customer_id =$id
sql;

	return $mysqli->queryAll($query);
    }

    public static function getByIdLogin($user){
    	$mysqli = DatabaseDao::getInstance();
	$query = <<<sql
SELECT u.user_id, u.nickname, u.first_name, u.last_name, c.name AS name_customer, c.img AS img_customer, c.customer_id, m.name, m.type
FROM user AS u
INNER JOIN user_customer AS uc
USING ( user_id )
INNER JOIN user_modules AS um
USING ( user_id )
INNER JOIN modules AS m ON ( m.modules_id = um.modules_id )
INNER JOIN customer AS c ON ( c.customer_id = uc.customer_id )
INNER JOIN customer_modules AS cm ON ( cm.customer_id = c.customer_id
AND cm.modules_id = m.modules_id )
WHERE u.nickname = :nickname
AND u.password = :password
AND u.status =1
AND m.modules_id =4
AND c.status =1
sql;
		$params = array(':nickname' => $user->_name,':password' => $user->_pass	);

		return $mysqli->queryOne($query, $params);
    }

    public static function getMsisdnCatalogoMsisdn($msisdn){
        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
SELECT *
FROM msisdn
INNER JOIN carrier
USING ( carrier_id )
WHERE msisdn =$msisdn
sql;

        return $mysqli->queryOne($query);
    }

    public static function getMsisdnCatalogoMsisdnNew($msisdn){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT * FROM msisdn WHERE msisdn =$msisdn
sql;

        return $mysqli->queryOne($query);
    }

        public static function updateCatalogoMsisdn($msisdn,$carrier_id){
        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
UPDATE msisdn SET  carrier_id=$carrier_id WHERE msisdn =$msisdn
sql;

        return $mysqli->update($query);
    }

    public static function getCarrierCustomerGroup($customer){
        $mysqli = DatabaseDao::getInstance();
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

    public static function getCarrierCustomer($customer, $shortCode){	
	$mysqli = DatabaseDao::getInstance();
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

    public static function insertSmsCampaign($campaign, $msisdnId, $carrier, $smsCampaign, $modulesId, $mensaje){

    $mysqli = DatabaseDao::getInstance();
    $query=<<<sql
INSERT INTO sms_campaign (campaign_id, ctime, delivery_date, msisdn_id, carrier_connection_short_code_id, sms_campaign_estatus_id, modules_id, content)
VALUES (:campaign, NOW(), NOW(), :msisdn_id, :carrier, :sms_campaign, :modules_id, :content);
sql;
    
    $params = array(':campaign'=>$campaign,
                    ':msisdn_id'=>$msisdnId,
                    ':carrier'=>$carrier,
                    ':sms_campaign'=>$smsCampaign,
                    ':modules_id'=>$modulesId,
                    ':content'=>$mensaje);
    //mail("esau.espinoza@airmovil.com","params insertSmsCampaign", print_r($params,1));
    
    return $mysqli->insert($query, $params);
    }


     public static function insertaMsisdn($msisdn, $carrier){
        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
INSERT INTO msisdn (msisdn, carrier_id) VALUES (:msisdn, :carrier_id);
sql;

        return $mysqli->insert($query, array(':msisdn'=>$msisdn, ':carrier_id'=>$carrier));
    }

    public static function getStatusSms($sms_campaign_id){
        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
SELECT IF( s.status IS NULL , sce.estatus, s.status ) AS sms_estatus, IF( c.name IS NULL , sce.estatus, c.name ) AS carrier, sc.campaign_id
FROM sms_campaign sc
LEFT JOIN sms s ON ( s.campaign_id = sc.campaign_id
AND sc.msisdn_log = s.destination )
LEFT JOIN sms_campaign_estatus sce ON ( sc.sms_campaign_estatus_id = sce.sms_campaign_estatus_id )
LEFT JOIN msisdn m ON ( sc.msisdn_id = m.msisdn_id )
LEFT JOIN carrier c ON ( c.carrier_id = m.carrier_id )
WHERE sc.sms_campaign_id =$sms_campaign_id
GROUP BY sc.sms_campaign_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getCampaignId($campaign_id){
        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
SELECT * FROM campaign_user cu 
INNER JOIN user u USING (user_id)
WHERE campaign_id IN ($campaign_id)
sql;
        return $mysqli->queryOne($query);
    }

    public static function getStatusSmsCampaing(){
        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
SELECT * FROM sms_campaign_estatus
sql;
        return $mysqli->queryAll($query);
    }

    public static function getCustomer($user_id){
        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
SELECT customer_id FROM user_customer WHERE user_id =$user_id
sql;
    
        return $mysqli->queryOne($query);
    }

    public static function getTotalesCustomerMes($customer_id){
        $mysqli = DatabaseDao::getInstance();
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
        $mysqli = DatabaseDao::getInstance();
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
        $mysqli = DatabaseDao::getInstance();
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
        $mysqli = DatabaseDao::getInstance();
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

    public static function getUpdatePass($user_id,$newPassword){
        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
UPDATE user SET password = MD5('$newPassword') WHERE status=1 AND user_id =$user_id;
sql;
        return $mysqli->update($query);
    }

    public static function getBolsasms($customer_id){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT
IF( SUM( uc.count ) IS NULL , 0, SUM( uc.count ) ) AS total_mts_customer,
IF( c.max_mt_month IS NULL , ( SELECT cc.max_mt_month FROM customer cc WHERE cc.customer_id =$customer_id), c.max_mt_month ) AS max_mt_month,
IF( ( c.max_mt_month - SUM( uc.count ) ) IS NULL , c.max_mt_month, ( c.max_mt_month - SUM( uc.count ) ) ) AS resta_mes_mt,
IF( sb.cantidad IS NULL,0, sb.cantidad )as bolsa_sms, 
IF( sb.cantidad IS NULL,0, (sb.cantidad - SUM(uc.count) ) ) as resta_bolsa_sms
FROM customer c
LEFT JOIN (
    SELECT count , customer_id
    FROM customer_control_mt uc
    WHERE (MONTH( uc.create_time ) = MONTH( NOW( ) )
    OR MONTH( uc.create_time ) IS NULL)) AS uc 
ON (uc.customer_id = c.customer_id)
LEFT JOIN (
    SELECT customer_id, SUM( cantidad ) as cantidad
    FROM sms_bag
    WHERE customer_id =$customer_id
    AND estatus =1
    AND MONTH( fecha_expira ) = MONTH( NOW( ) ) ) as sb 
ON (c.customer_id=sb.customer_id)
WHERE c.customer_id = $customer_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getBolsa($customer_id){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT *
FROM sms_bag
WHERE customer_id =$customer_id
AND estatus =1
AND MONTH( fecha_expira ) = MONTH( NOW( ) )
sql;
        return $mysqli->queryAll($query);
    }

    public static function getIncomming($sms_campaign_id){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT sc.campaign_id, s.entry_time, s.source, s.content
FROM sms_campaign sc
LEFT JOIN sms s ON ( sc.msisdn_log = s.destination
OR sc.msisdn_log = s.source )
LEFT JOIN sms_campaign_estatus sce ON ( sce.sms_campaign_estatus_id = sc.sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON ( cc.campaign_id = sc.campaign_id )
WHERE sc.sms_campaign_id =$sms_campaign_id
AND direction = 'MO'
sql;

        return $mysqli->queryAll($query);
    }

    public static function getCampaignIds($customer_id){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT * FROM campaign_customer WHERE customer_id =$customer_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getIncommingDate($ids, $fechaI, $fechaF){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT sc.campaign_id, s.entry_time, s.source, s.content
FROM sms_campaign sc
LEFT JOIN sms s ON ( sc.msisdn_log = s.destination
OR sc.msisdn_log = s.source )
LEFT JOIN sms_campaign_estatus sce ON ( sce.sms_campaign_estatus_id = sc.sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON ( cc.campaign_id = sc.campaign_id )
WHERE direction = 'MO'
AND sc.campaign_id
IN ( $ids )
AND s.entry_time >= '$fechaI'
AND s.entry_time <= '$fechaF'
GROUP BY s.sms_id
sql;
        //mail("esau.espinoza@airmovil.com","getIncommingDate", $query);
        return $mysqli->queryAll($query);
    }

    public static function getIncommingFull($sms_campaign_id, $fechaI, $fechaF){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT sc.campaign_id, s.entry_time, s.source, s.content
FROM sms_campaign sc
LEFT JOIN sms s ON ( sc.msisdn_log = s.destination
OR sc.msisdn_log = s.source )
LEFT JOIN sms_campaign_estatus sce ON ( sce.sms_campaign_estatus_id = sc.sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON ( cc.campaign_id = sc.campaign_id )
WHERE sc.sms_campaign_id =$sms_campaign_id
AND direction = 'MO'
AND s.entry_time >= '$fechaI'
AND s.entry_time <= '$fechaF'
sql;
        //mail("esau.espinoza@airmovil.com","getIncommingFull", $query);
        return $mysqli->queryAll($query);
    }

    public static function getWhiteList($msisdn){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT *
FROM white_list
WHERE msisdn =$msisdn
sql;
        return $mysqli->queryAll($query);
    }

    public static function insertWLS($celular,$statusWL,$operationId){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
INSERT INTO white_list_sky(ctime, msisdn, estatus, operationId) VALUES (NOW(),$celular,$statusWL,$operationId)
sql;
        return $mysqli->insert($query);
    }

    public static function insertIgnoreMsisdn($msisdn,$carrier_id){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
INSERT IGNORE INTO msisdn (msisdn,carrier_id) VALUES ($msisdn,:carrier) ON DUPLICATE KEY UPDATE carrier_id=$carrier_id
sql;
//mail("esau.espinoza@airmovil.com","insert",$query);

        return $mysqli->insert($query, array(':carrier'=>$carrier_id));
    }

    public static function getMsisdnSmsCampaign($sms_campaign_id){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT msisdn_log FROM sms_campaign WHERE sms_campaign_id =$sms_campaign_id
sql;

        return $mysqli->queryOne($query);
    }


    public static function getUser($username){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT * FROM user_ws WHERE nickname LIKE '$username'
sql;
        return $mysqli->queryOne($query);
    }


    public static function obtieneDatosUser($id){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT * FROM user WHERE user_id =$id
sql;

        return $mysqli->queryOne($query);
    }

    public static function getExpiredDate($user, $fecha){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT * FROM user_ws WHERE nickname LIKE '$user' AND expired >= '$fecha'
sql;
        return $mysqli->queryOne($query);
    }


    public static function getTimeLoked($user,$user_ws_id){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT
NOW() as actual,
date_time, 
intento, 
loked,
TIMESTAMPDIFF( MINUTE , date_time , NOW( ) ) AS resta_tiempo
FROM login_ws
WHERE nickname LIKE "$user"
AND user_ws_id =$user_ws_id
sql;
        return $mysqli->queryOne($query);
    }


    public static function insertIntento($user, $user_ws_id, $intento, $loked){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
INSERT INTO login_ws( date_time, intento, nickname, user_ws_id, loked )
VALUES ( NOW( ) , $intento, '$user', $user_ws_id, $loked ) 
ON DUPLICATE KEY UPDATE date_time = NOW( ) , intento =$intento, loked=$loked
sql;
        return $mysqli->insert($query);
    }


    public static function getBuscaLoginWS($user){
        $mysqli = DatabaseDao::getInstance();
        $query =<<<sql
SELECT * FROM login_ws WHERE nickname LIKE "$user"
sql;

        return $mysqli->queryOne($query);
    }


}
