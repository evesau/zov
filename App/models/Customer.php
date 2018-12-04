<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Customer implements Crud{

    public static function getById($id){
    	
    	$mysqli = Database::getInstance();
		$query=<<<sql
SELECT c.name AS customer_name, m.type AS type_module, m.name AS name_module, m.modules_id FROM customer c
INNER JOIN customer_modules cm USING (customer_id)
INNER JOIN modules m ON (cm.modules_id = m.modules_id)
WHERE c.customer_id = :id 
ORDER BY m.name;
sql;
		return $mysqli->queryAll($query, array(':id'=>$id));
    }
    
    public static function insert($custom){
       $mysqli = Database::getInstance();
       $query = <<<sql
INSERT INTO customer (name, max_mt_day, max_mt_month, img, status,tolerance)
VALUES (:name, :mtday, :mtmonth, :img, :status,:tolerance)
sql;
        $params= array (':name' => $custom->_name,
                        ':mtday' => $custom->_mtday,
                        ':mtmonth' => $custom->_mtmonth,
                        ':tolerance' =>$custom->_tolerance,
                        ':img' =>   $custom->_image,
                        ':status' => $custom->_status
                    );

        return $mysqli->insert($query, $params);
    }

 public static function insertUser($usr)
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

    public static function insertCustomModules($custom_id,$module){
        $mysqli = Database::getInstance();
        $query = <<<sql
INSERT INTO customer_modules (customer_id,modules_id)
VALUES (:custom_id, :modules_id);
sql;
    
        $params = array(
            ':custom_id'=>$custom_id,
            ':modules_id'=>$module
        );
        return $mysqli->insert($query, $params);
    }

    public static function getDataCustomer($id){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT * FROM customer WHERE customer_id = :id;
sql;
        return $mysqli->queryOne($query, array(':id' => $id));
    }

    public static function getAllModules(){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT * FROM modules;
sql;
        return $mysqli->queryAll($query);
    }

    public static function getAll(){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT * FROM customer WHERE status = 0 OR status = 1
sql;
        return $mysqli->queryAll($query);
    }

    public static function deleteCustomerModules($id){
        $mysqli = Database::getInstance();
        $query = <<<sql
DELETE FROM customer_modules WHERE customer_id = :id;
sql;
        return $mysqli->delete($query, array(':id' => $id));
    }

    public static function insertCustomerModules($id,$module){
        $mysqli = Database::getInstance();
        $query = <<<sql
INSERT INTO customer_modules (customer_id,modules_id)
VALUES (:id, :modules_id);
sql;
    
        $params = array(
            ':id'=>$id,
            ':modules_id'=>$module
        );
        return $mysqli->insert($query, $params);
    }

    public static function update($customer){

        $mysqli = Database::getInstance();
        $query = <<<sql
UPDATE customer SET name = :name, max_mt_day = :max_mt_day, max_mt_month = :max_mt_month, img = :img, status = :status, tolerance = :tolerance
WHERE customer_id = :id;
sql;
        $params = array(
                ':id'   => $customer->_id,
                ':name' => $customer->_customer,
                ':max_mt_day' => $customer->_maxmtday,
                ':max_mt_month' => $customer->_maxmtmonth,
                ':img' => $customer->_img,
                ':status' => $customer->_status,
                ':tolerance' => $customer->_tolerance
            );

        return $mysqli->update($query, $params);

    }

    public static function delete($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE customer SET status = -1 WHERE customer_id = :id;
sql;
//DELETE FROM customer WHERE customer_id = :id;
    return $mysqli->delete($query, array(':id'=>$id));

    }

    public static function getShortCodeAndCarrier(){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT sc.short_code, c.name, ccsc.carrier_connection_short_code_id, cc.carrier_name
FROM carrier_connection_short_code AS ccsc
INNER JOIN carrier_connection AS cc
USING ( carrier_connection_id )
INNER JOIN short_code AS sc
USING ( short_code_id )
INNER JOIN carrier AS c
USING ( carrier_id )
GROUP BY carrier_connection_id
sql;

    return $mysqli->queryAll($query);
    }

    public static function insertCustomCCSC($addCustom,$value){
        $mysqli = Database::getInstance();
        $query = <<<sql
INSERT INTO custome_carrier_connection_short_code (customer_id, carrier_connection_short_code_id)
VALUES (:id, :ccsc_id);
sql;
        $params = array(
                ':id' => $addCustom,
                ':ccsc_id' => $value
            );
        return $mysqli->insert($query,$params);
    }

    public static function getShortCodeById($id){
        $mysqli = Database::getInstance();
        $query= <<<sql
SELECT c.name,ccsc.carrier_connection_short_code_id FROM carrier_connection_short_code ccsc
INNER JOIN custome_carrier_connection_short_code cccsc USING(carrier_connection_short_code_id)
INNER JOIN customer c ON (c.customer_id = cccsc.customer_id)
WHERE c.customer_id = :id;
sql;
        return $mysqli->queryAll($query,array( ':id' => $id));

    }

    public static function deleteCustomSCCC($id){
        $mysqli = Database::getInstance();
        $query = <<<sql
DELETE FROM custome_carrier_connection_short_code WHERE customer_id = :id;
sql;

        return $mysqli->delete($query, array(':id' => $id));
    }

    public static function getUsers($id)
    {
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT user_id, nickname, first_name, last_name FROM user u
INNER JOIN user_customer uc USING (user_id)
INNER JOIN customer c ON(uc.customer_id = c.customer_id)
WHERE c.customer_id = :id;
sql;
    return $mysqli->queryAll($query,array(':id'=>$id));  
    }

    public static function getModulesUser($id_user){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM user_modules
WHERE user_id = :id;
sql;
    return $mysqli->queryAll($query,array(':id' => $id_user));
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
    
}