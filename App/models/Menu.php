<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Menu implements Crud
{

    public static function getAll()
    {
	$mysqli = Database::getInstance();
	$query=<<<sql
SELECT * FROM deferred_sms
sql;

	return $mysqli->queryAll($query);
    }

    public static function getById($id)
    {
	$mysqli = Database::getInstance();
/*	$query=<<<sql
SELECT u.user_id, u.nickname, u.img as pic, c.name as name_customer, m.name as name_module, m.type as type_module, m.img FROM user AS u
INNER JOIN `user_customer` uc USING (user_id)
INNER JOIN `customer` c ON (uc.customer_id = c.customer_id)
INNER JOIN `customer_modules` cm ON (c.customer_id = cm.customer_id)
INNER JOIN `modules` m ON (cm.modules_id = m.modules_id)
WHERE u.user_id = :id AND u.status = 1;
sql; */
    $query=<<<sql
SELECT  u.user_id, u.nickname, u.img as pic, m.name as name_module, m.type as type_module, m.img, m.modules_id FROM user u
INNER JOIN user_modules um using(user_id)
INNER JOIN modules m on (um.modules_id = m.modules_id)
where user_id = :id
ORDER BY orden
sql;

        return $mysqli->queryAll($query, array(':id'=>$id));

    }

    
    public static function insert($usr)
    {
	$mysqli = Database::getInstance();
	$query=<<<sql
INSERT INTO user (nickname,first_name,last_name,img,password,mail,created,max_mt_day,max_mt_month,status) 
VALUES (:nickname, :first_name, :last_name, :img,  MD5(:pass), :mail, NOW(),:max_dia,:max_mes, :status);
sql;

    $params = array(
            ':nickname'  =>$usr->_nickname,
            ':first_name'=>$usr->_fname,
            ':last_name' =>$usr->_lname,
            ':img'       =>$usr->_image,
            ':pass'      =>$usr->_pass1,
            ':mail'      =>$usr->_mail,
            ':status'    =>$usr->_status,
            ':max_dia'   =>$usr->_max_dia,
            ':max_mes'   =>$usr->_max_mes
            );

	return $mysqli->insert($query, $params);
    }

    public static function updatePwd($user)
    {
	    $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE user 
SET nickname = :nickname, first_name = :fname, last_name = :lname, img = :img, password = md5(:password), mail = :mail, max_mt_day = :max_dia, max_mt_month = :max_mes, status = :status WHERE user_id = :id ;
sql;
        $params = array(
            ':nickname'     => $user->_nickname,
            ':fname'    => $user->_fname,
            ':lname'    => $user->_lname,
            ':password' => $user->_pass1,
            ':mail'     => $user->_mail,
            ':status'   => $user->_status,
            ':id'       => $user->_id,
            ':img'      => $user->_img,
            ':max_dia'  => $user->_max_dia,
            ':max_mes'  => $user->_max_mes
        );

        return $mysqli->update($query, $params);
    }

    public static function update($user)
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE user 
SET nickname = :nickname, first_name = :fname, last_name = :lname, img = :img, mail = :mail, max_mt_day = :max_dia, max_mt_month = :max_mes, status = :status WHERE user_id = :id ;
sql;
        $params = array(
            ':nickname'     => $user->_nickname,
            ':fname'    => $user->_fname,
            ':lname'    => $user->_lname,
            ':mail'     => $user->_mail,
            ':status'   => $user->_status,
            ':id'       => $user->_id,
            ':img'      => $user->_img,
            ':max_dia'  => $user->_max_dia,
            ':max_mes'  => $user->_max_mes
        );

        return $mysqli->update($query, $params);
    }

    public static function updateWithoutPass($user)
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE user SET nickname = :nickname, first_name = :fname, last_name = :lname, img = :img, mail = :mail, status = :status WHERE user_id = :id ;
sql;
        $params = array(
            ':nickname'     => $user->_nickname,
            ':fname'    => $user->_fname,
            ':lname'    => $user->_lname,
            ':mail'     => $user->_mail,
            ':status'   => $user->_status,
            ':id'       => $user->_id,
            ':img'      => $user->_img
        );

        return $mysqli->update($query, $params);

    }
    
    public static function delete($id)
    {
	$mysqli = Database::getInstance();
	$query=<<<sql
UPDATE user SET status=0 WHERE user_id = :id;
sql;
	return $mysqli->update($query, array(':id'=>$id));	
    }

    public static function getUsers($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT user_id, nickname, first_name, last_name FROM user u
INNER JOIN user_customer uc USING (user_id)
INNER JOIN customer c ON(uc.customer_id = c.customer_id)
WHERE c.customer_id = :id AND u.status=1;
sql;
    return $mysqli->queryAll($query,array(':id'=>$id));  
    }

    public static function getAllUsers(){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM user WHERE status=1;
sql;
        return $mysqli->queryAll($query);  
    }

    public static function getModulesById($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT c.name AS customer_name, m.type AS type_module, m.name AS name_module, m.img AS img_module, m.modules_id FROM customer c
INNER JOIN customer_modules cm USING (customer_id)
INNER JOIN modules m ON (cm.modules_id = m.modules_id)
WHERE c.customer_id = :id 
ORDER BY m.name;
sql;
        return $mysqli->queryAll($query, array(':id'=>$id));
    }

    public static function insertUserModules($user_id,$module){
        $mysqli = Database::getInstance();
        $query = <<<sql
INSERT INTO user_modules (user_id,modules_id)
VALUES (:user_id, :modules_id);
sql;
    
        $params = array(
            ':user_id'=>$user_id,
            ':modules_id'=>$module
        );
        return $mysqli->insert($query, $params);
    }

    public static function deleteUserModules($user_id){
        $mysqli = Database::getInstance();
        $query = <<<sql
DELETE FROM user_modules WHERE user_id = :user_id;
sql;
    
        $params = array(
            ':user_id'=>$user_id,
        );

        return $mysqli->delete($query, $params);
    }

    public static function insertUserCustomer($user_id,$customer_id){
        $mysqli = Database::getInstance();
        $query = <<<sql
INSERT INTO user_customer (user_id,customer_id)
VALUES (:user_id, :customer_id);
sql;
 
        $params = array(
            ':user_id'=>$user_id,
            ':customer_id'=>$customer_id
        );
        return $mysqli->update($query, $params);
    }

    public static function getDataUser($id){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT * FROM user WHERE user_id = :id;
sql;

         return $mysqli->queryOne($query, array(':id' => $id));    
    }

    public static function deleteUserCustomer($id){
        $mysqli = Database::getInstance();
        $query = <<<sql
DELETE FROM user_customer WHERE user_id = :user_id;
sql;
        return $mysqli->delete($query, array(':user_id' => $id));
    }

    public static function getByName($nickname)
    {

    $mysqli = Database::getInstance();
    $query=<<<sql
SELECT user_id,nickname FROM user WHERE nickname = :nickname ;
sql;

    return $mysqli->queryAll($query, array(':nickname'=>$nickname->_name));
    }

/****************************************************************************/
    public static function getAllMT_Telcel($id){
        $mysqli = Database::getInstance();
        $queryBack = <<<sql
SELECT *  FROM campaign c
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN sms USING (campaign_id)
INNER JOIN msisdn m ON (m.msisdn = sms.destination)
WHERE MONTH( sms.delivery_time ) = MONTH( NOW( ) )
AND cc.customer_id = $id
AND sms.direction = "MT"
AND m.carrier_id=1
sql;
        $query =<<<sql
SELECT * FROM total_envios_telcel_customer_delivered WHERE customer_id =$id
sql;
        //mail('esau.espinoza@airmovil.com','Query',$query);
        return $mysqli->queryOne($query);
    }

    public static function getAllMO_Telcel($id){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT *
FROM sms
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
WHERE ccsc.carrier_id =1
AND MONTH( sms.entry_time ) = MONTH( CURDATE( ) )
AND cc.customer_id =$id AND sms.direction="MO"
sql;
        return $mysqli->queryAll($query);
    }

    public static function getAllMT_Movistar($id){
        $mysqli = Database::getInstance();
        $queryBack = <<<sql
SELECT *  FROM campaign c
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN sms USING (campaign_id)
INNER JOIN msisdn m ON (m.msisdn = sms.destination)
WHERE MONTH( sms.delivery_time ) = MONTH( NOW( ) )
AND cc.customer_id = $id
AND sms.direction = "MT"
AND m.carrier_id=2
sql;
        $query =<<<sql
SELECT * FROM total_envios_movistar_customer_delivered WHERE customer_id =$id
sql;
        return $mysqli->queryOne($query);
    }
    
    public static function getAllMO_Movistar($id){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT *
FROM sms
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
WHERE ccsc.carrier_id =2
AND MONTH( sms.entry_time ) = MONTH( CURDATE( ) )
AND cc.customer_id =$id AND sms.direction="MO"
sql;
        return $mysqli->queryAll($query);   
    }

    public static function getAllMT_Att($id){
        $mysqli = Database::getInstance();
        $queryBack = <<<sql
SELECT *  FROM campaign c
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN sms USING (campaign_id)
INNER JOIN msisdn m ON (m.msisdn = sms.destination)
WHERE MONTH( sms.delivery_time ) = MONTH( NOW( ) )
AND cc.customer_id = $id
AND sms.direction = "MT"
AND m.carrier_id=3
sql;
        $query =<<<sql
SELECT * FROM total_envios_att_customer_delivered WHERE customer_id =$id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getAllMO_Att($id){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT *
FROM sms
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
WHERE ccsc.carrier_id =3
AND MONTH( sms.entry_time ) = MONTH( CURDATE( ) )
AND cc.customer_id =$id AND sms.direction="MO"
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

    public static function getTypeCustomerParent($customer_id){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT count(*) AS total FROM customer_parent WHERE customer_id = $customer_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getMtMonthCustomer($data){
        $mysqli = Database::getInstance(1,1);
        $query =<<<sql
SELECT 
entry_time, 
(SELECT name FROM customer WHERE customer_id=sms.customer_id) AS customer, 
customer_id, 
IF(carrier!='', 
   carrier,(
       SELECT 
       CASE
       WHEN carrier_id=1 THEN 'telcel'
       WHEN carrier_id=2 THEN 'movistar'
       WHEN carrier_id=3 THEN 'att'
       ELSE 'telcel'
       END
       FROM msisdn
       WHERE msisdn=sms.destination
       GROUP BY msisdn)
) AS carriers, 
status, 
status_dlr, 
COUNT(*) AS total 
FROM sms 
WHERE entry_time >= :fecha AND entry_time < DATE_ADD(:fecha, INTERVAL 1 MONTH)  
AND direction = 'MT' AND status LIKE 'delivered' AND status_dlr LIKE 'ACCEPTD' AND customer_id = :customer_id 
GROUP BY month(entry_time), customer_id, carriers, status, status_dlr
sql;
        $params = array(':fecha' => $data->fecha, ':customer_id' => $data->customer_id);
        //mail("esau.espinoza@airmovil.com", "getMtMonthCustomer", print_r($params,1), $query);

        return $mysqli->queryAll($query, $params);
    }
    
}