<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Webapis implements Crud{

    public static function getAll(){
      $mysqli = Database::getInstance();
      $query=<<<sql
SELECT * FROM api_web
sql;
      return $mysqli->queryAll($query);
    }

    public static function getAllByCustomer($customer_id){
      $mysqli = Database::getInstance();
      $query=<<<sql
SELECT * FROM api_web WHERE customer_id = $customer_id
sql;
      return $mysqli->queryAll($query);
    }

    public static function getById($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
SELECT * FROM api_web WHERE api_web_id=$id
sql;

      return $mysqli->queryAll($query);
    }

    public static function getIps($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
SELECT * FROM api_web_ip WHERE api_web_id=$id
sql;

      return $mysqli->queryAll($query);
    }

    public static function insert($datos){
      $mysqli = Database::getInstance();
      $query =<<<sql
      INSERT INTO api_web(user, pwd, customer_id) VALUES ('$datos->_usuario','$datos->_pass', $datos->_customer)
sql;
      return $mysqli->insert($query);
    }



    public static function insertIp($datos){
      $mysqli = Database::getInstance();
      $query=<<<sql
      INSERT INTO api_web_ip(api_web_id, ip) VALUES ($datos->_api_web_id, '$datos->_ip')
sql;
      return $mysqli->insert($query);
    }

    public static function getUpdate($id){}

    public static function delete($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
DELETE FROM api_web where api_web_id=$id
sql;
      return $mysqli->delete($query);
    }

    public static function update($datos){
      $mysqli = Database::getInstance();
      $query=<<<sql
UPDATE api_web SET user=:usuario, pwd=:password WHERE api_web_id=:api_id
sql;
      $params = array(':usuario'  =>  $datos->_usuario,
                      ':password' =>  $datos->_pass,
                      ':api_id'   =>  $datos->_api_web_id);
      return $mysqli->update($query,$params);
    }

    public static function deleteIp($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
DELETE FROM `api_web_ip` WHERE api_web_id=$id
sql;
      return $mysqli->delete($query);
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

    public static function getCampaignById($customer_id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT 
        c.campaign_id, 
        c.name AS name_campaign, 
        c.delivery_date
      FROM campaign c
      INNER JOIN campaign_customer cc using(campaign_id)
      WHERE cc.customer_id = $customer_id
      GROUP BY c.campaign_id;
sql;
      return $mysqli->queryAll($query);
    }

    /*

    public static function getCampaignById($customer_id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT 
        c.campaign_id, 
        c.name AS name_campaign, 
        c.delivery_date, 
        sc.short_code_id ,
        sc.short_code
      FROM campaign c
      INNER JOIN campaign_customer cc using(campaign_id)
      INNER JOIN customer cu ON (cc.customer_id = cu.customer_id)
      INNER JOIN carrier_connection_short_code_campaign ccscc using(campaign_id)
      INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
      INNER JOIN short_code sc ON (sc.short_code_id = ccsc.short_code_id)
      WHERE cu.customer_id = $customer_id AND MONTH(c.delivery_date) = MONTH(CURDATE())
      GROUP BY c.campaign_id;
sql;
      return $mysqli->queryAll($query);
    }

    */


    
    public static function getWebApiType(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM api_web_type 
sql;
      return $mysqli->queryAll($query);
    }

    public static function getCampaignCarrierShortCode($campaign_id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM campaign_carrier_short_code WHERE campaign_id = $campaign_id
sql;
      return $mysqli->queryAll($query);
    } 

    public static function insertApiWebType($datos){
      $mysqli = Database::getInstance();
      $query =<<<sql
      INSERT INTO campaign_api_web VALUES(NULL, :campaign_id,  :api_web_id, :type, :campaign_carrier_short_code_id);
sql;
      $params = array(
        ':campaign_id' =>$datos->campaign_id, 
        ':api_web_id' =>$datos->api_web_id, 
        ':type' =>$datos->type, 
        ':campaign_carrier_short_code_id' =>$datos->campaign_carrier_short_code_id
      );
      return $mysqli->insert($query, $params);
    }

    public static function getCampaignCarrierShortCodeById($id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT 
        DISTINCT caw.campaign_id, api_web_type_id 
      FROM campaign_api_web caw
      JOIN campaign_customer cc
      ON caw.campaign_id = cc.campaign_id
      WHERE cc.customer_id = $id
sql;
      return $mysqli->queryAll($query);
    }

    public static function deleteCampaignId($id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      DELETE FROM campaign_api_web
      WHERE campaign_id = $id
sql;
      return $mysqli->update($query);
    }

    public static function getCarrierConnectionShortCodeById($campaign_id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT 
        ccscc.carrier_connection_short_code_id,
        ccscc.campaign_id,
        ccsc.carrier_connection_id,
        ccsc.carrier_id,
        c.name,
        sc.short_code
      FROM carrier_connection_short_code_campaign ccscc
      JOIN carrier_connection_short_code ccsc 
      USING(carrier_connection_short_code_id)
      JOIN carrier c
      USING (carrier_id)
      JOIN short_code sc
      USING(short_code_id)
      WHERE ccscc.campaign_id = $campaign_id
sql;
      return $mysqli->queryAll($query);
    }


    /*FUNCIONES PARA WEBHOOK APIS*/
    public static function getWebHookByCustomer($customer_id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT 
        *
      FROM webhook WHERE customer_id = $customer_id
sql;
      return $mysqli->queryAll($query);
    }

    public static function getWebHookById($webhook_id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT 
        *
      FROM webhook WHERE webhook_id = $webhook_id
sql;
      return $mysqli->queryOne($query);
    }

    public static function insertWebHook($datos){
      $mysqli = Database::getInstance();
      $query =<<<sql
      INSERT INTO webhook(customer_id, user, password, url, type) VALUES ($datos->_customer, '$datos->_usuario','$datos->_pass', '$datos->_url', '$datos->_type')
sql;
      return $mysqli->insert($query);
    }

    public static function updateWebHook($datos){
      $mysqli = Database::getInstance();
      $query=<<<sql
      UPDATE webhook SET user='$datos->_usuario', password='$datos->_password', url='$datos->_url', type='$datos->_type'  WHERE webhook_id = $datos->_webhook_id
sql;
      echo $query;
      return $mysqli->update($query,$params);
    }

}