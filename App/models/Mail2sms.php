<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Mail2sms implements Crud{

    public static function getAll(){
      $mysqli = Database::getInstance();
      $query =<<<sql
      select * from mail2sms WHERE status=1
sql;

      return $mysqli->queryAll($query);
    }

    public static function getCampaign($id_customer){
        $mysqli = Database::getInstance();
        $query =<<<sql
select c.campaign_id, c.name from campaign c
inner join campaign_customer cc using (campaign_id)
inner join customer cu on (cc.customer_id = cu.customer_id)
where cu.customer_id = :id;
sql;
        return $mysqli->queryAll($query,array(':id' => $id_customer));
    }

    public static function getShortCode($id_campania){
        $mysqli = Database::getInstance();
        $query =<<<sql
select sc.short_code_id, sc.short_code  from service s
inner join campaign c using (campaign_id)
inner join carrier_connection_short_code_campaign ccscc using (campaign_id)
inner join carrier_connection_short_code ccsc on (ccsc.carrier_connection_short_code_id = ccscc.carrier_connection_short_code_id)
inner join short_code sc on (ccsc.short_code_id = sc.short_code_id)
where campaign_id = :id;
sql;
        return $mysqli->queryAll($query,array(':id' => $id_campania));
    }

    public static function insert($datos){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO mail2sms (mail, created,  status, detalle, user_id, customer_id)
VALUES (:mail, NOW(), :status, :detalle, :user_id, :customer_id);
sql;

    
        $params =array( ':mail'         => $datos->_mail,
                        ':status'       => $datos->_status,
                        ':detalle'      => $datos->_detalle,
                        ':user_id'      => $datos->_user_id,
                        ':customer_id'  => $datos->_customer_id
                      );

        return $mysqli->insert($query,$params);
    }


    public static function update($datos){
      $mysqli = Database::getInstance();
      $query=<<<sql
  UPDATE mail2sms SET mail=:mail, status=:status, detalle=:detalle WHERE mail2sms_id = :id;
sql;
      $params = array(':mail'       => $datos->_mail,
                      ':status'     => $datos->_status,
                      ':detalle'    => $datos->_detalle,
                      ':id'         => $datos->_mail2sms_id
                      );

      return $mysqli->update($query,$params);
    }

    public static function  insertCCSC($datos){
      $mysqli = Database::getInstance();
      $query=<<<sql
      INSERT INTO `mail2sms_carrier_connection_short_code`(`mail2sms_id`, `carrier_connection_short_code_id`) VALUES (:mail2sms_id,:ccsc_id)
sql;
      $params = array(':mail2sms_id'  =>  $datos->_mail2sms_id,
                      ':ccsc_id'      =>  $datos->_ccsc_id);

      return $mysqli->queryAll($query,$params);
    }

    public static function deleteCCSC($mail2sms_id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      DELETE FROM `mail2sms_carrier_connection_short_code` WHERE mail2sms_id=$mail2sms_id
sql;

      return $mysqli->queryAll($query);
    }

    public static function delete($id){
    // echo "id: $id";
      $mysqli = Database::getInstance();
      $query =<<<sql
UPDATE mail2sms SET status=0 WHERE mail2sms_id = :id;
sql;
// print_r($query);
      return $mysqli->update($query,array(':id' => $id));
    }

    public static function getById($id){
      $mysqli = Database::getInstance();
      $query =<<<sql
SELECT * FROM mail2sms WHERE mail2sms_id =$id
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
            ':img'       =>$usr->_img,
            ':pass'      =>$usr->_password,
            ':mail'      =>$usr->_mail,
            ':status'    =>$usr->_status,
            ':max_dia'   =>$usr->_max_mt_day,
            ':max_mes'   =>$usr->_max_mt_month
            );

  return $mysqli->insert($query, $params);
    }

    public static function updateUser($user)
    {
      $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE user 
SET nickname = :nickname, first_name = :fname, last_name = :lname, img = :img, password = md5(:password), mail = :mail, max_mt_day = :max_dia, max_mt_month = :max_mes, status = :status WHERE user_id = :id ;
sql;
        $params = array(
            ':nickname' => $user->_nickname,
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

    public static function deleteUser($id)
    {
  $mysqli = Database::getInstance();
  $query=<<<sql
UPDATE user SET status=0 WHERE user_id = :id;
sql;
  return $mysqli->update($query, array(':id'=>$id));  
    }

  public static function shortCodeAll(){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT * FROM short_code
sql;

    return $mysqli->queryAll($query);
  }

  public static function shortCodeOne($id){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT * FROM short_code WHERE short_code_id=$id
sql;

    return $mysqli->queryOne($query);
  }

    public static function getShortCodeAndCarrier(){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT sc.short_code, c.name, ccsc.carrier_connection_short_code_id
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

    public static function getMCCSC($id){

      $mysqli = Database::getInstance(true);
      $query = <<<sql
SELECT *
FROM mail2sms_carrier_connection_short_code 
WHERE mail2sms_id= $id
ORDER BY mail2sms_carrier_connection_short_code_id DESC
sql;

      return $mysqli->queryAll($query);
    }

    public static function getShortCodeAndCarrierId($id){
        $mysqli = Database::getInstance();
        $query = <<<sql
SELECT sc.short_code, c.name, ccsc.carrier_connection_short_code_id
FROM carrier_connection_short_code AS ccsc
INNER JOIN carrier_connection AS cc
USING ( carrier_connection_id )
INNER JOIN short_code AS sc
USING ( short_code_id )
INNER JOIN carrier AS c
USING ( carrier_id )
WHERE ccsc.carrier_connection_short_code_id=$id
GROUP BY carrier_connection_id
sql;

    return $mysqli->queryAll($query);
    }

    public static function getCCSC($id){
      $mysqli = Database::getInstance();
      $query = <<<sql
      SELECT * from `mail2sms_carrier_connection_short_code` WHERE mail2sms_id=$id
sql;
      return $mysqli->queryAll($query);
    }

}