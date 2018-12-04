<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Service implements Crud{

    public static function getAll(){}

    public static function getCampaign($id_customer){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT c.campaign_id, c.name, c.campaign_status_id
FROM campaign c
INNER JOIN campaign_customer cc
USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
WHERE cu.customer_id = :id
AND c.campaign_status_id != 4
sql;
        return $mysqli->queryAll($query,array(':id' => $id_customer));
    }

    public static function getShortCode($service_id){
        $mysqli = Database::getInstance();
/*
select sc.short_code_id, sc.short_code  from service s
inner join campaign c using (campaign_id)
inner join carrier_connection_short_code_campaign ccscc using (campaign_id)
inner join carrier_connection_short_code ccsc on (ccsc.carrier_connection_short_code_id = ccscc.carrier_connection_short_code_id)
inner join short_code sc on (ccsc.short_code_id = sc.short_code_id)
where service_id = :id;
*/
        $query =<<<sql
SELECT sc.short_code_id, sc.short_code FROM campaign AS c
inner join carrier_connection_short_code_campaign ccscc using (campaign_id)
inner join carrier_connection_short_code ccsc on (ccsc.carrier_connection_short_code_id = ccscc.carrier_connection_short_code_id)
inner join short_code sc on (ccsc.short_code_id = sc.short_code_id)
where c.campaign_id = :id
sql;
        return $mysqli->queryAll($query,array(':id' => $service_id));
    }

    public static function getShortCodePrueba($id_campania){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT sc.short_code_id, sc.short_code
FROM  short_code sc
INNER JOIN campaign_carrier_short_code ccsc USING (short_code_id)
INNER JOIN campaign c USING (campaign_id)
WHERE  c.campaign_id = :id;
sql;
        return $mysqli->queryAll($query,array(':id' => $id_campania));
    }

    public static function insert($service){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO service (short_code_id,campaign_id,title,description,handler,configuration,status)
VALUES (:short_code_id,:campaign_id,:title,:description,:handler,:configuration,:status);
sql;
    
        $params =array(':short_code_id' => $service->_short_code,
                       ':campaign_id' => $service->_campania,
                       ':title' => $service->_title,
                       ':description' => $service->_description,
                       ':handler' => $service->_handler,
                       ':configuration' => $service->_configuration,
                       ':status' =>  $service->_status
                );

        return $mysqli->insert($query,$params);
    }

    public static function insertKeywords($keyword,$id_service,$priority){
      $mysqli = Database::getInstance();
      $query =<<<sql
INSERT INTO service_keyword (service_id, keyword, priority)
VALUES (:id_service, :keyword, $priority);
sql;
        $params = array(':id_service' => $id_service,
                        ':keyword' => $keyword
                      );

      return $mysqli->insert($query,$params);
    }

    public static function insertCustomerService($customer_id,$service_id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      INSERT INTO customer_service (customer_id, service_id) VALUES ($customer_id,$service_id)
sql;
      return $mysqli->insert($query);
    }

    public static function getService($id_custom){
      $mysqli = Database::getInstance();
      $query =<<<sql
SELECT s.title,s.service_id FROM service s
INNER JOIN campaign c USING (campaign_id)
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN customer cu ON (cc.customer_id = cu.customer_id)
WHERE cu.customer_id = :id AND s.status = 1;
sql;
      return $mysqli->queryAll($query,array(':id' => $id_custom));
    }

    public static function getServiceContent($id_service){
      $mysqli = Database::getInstance();
      $query=<<<sql
SELECT * FROM service s
INNER JOIN short_code sc USING (short_code_id)
INNER JOIN campaign c USING (campaign_id)
WHERE s.service_id = :id;
sql;
      return $mysqli->queryOne($query,array(':id' => $id_service));
    }

    public static function getServiceKeyword($id_service){
      $mysqli = Database::getInstance();
      $query =<<<sql
SELECT * FROM service_keyword
WHERE service_id = :id;
sql;
      return $mysqli->queryAll($query,array(':id' => $id_service));
    }

    public static function update($service){
      $mysqli = Database::getInstance();
      $query =<<<sql
UPDATE service SET 
short_code_id=:short_code_id,
campaign_id=:campaign_id,
title=:title,
description=:description,
handler=:handler,
configuration=:configuration,
status=:status 
WHERE service_id = :id;
sql;
      $params = array(':short_code_id' => $service->_short_code_id,
                      ':campaign_id' => $service->_campania,
                      ':title' => $service->_title,
                      ':description' => $service->_description,
                      ':handler' => $service->_handler,
                      ':configuration' => $service->_configuration,
                      ':status' => $service->_status,
                      ':id' => $service->_service_id
                );

      return $mysqli->update($query,$params); 
    }

    public static function delete($id){
      $mysqli = Database::getInstance();
      $query =<<<sql
DELETE FROM service_keyword WHERE service_id = :id;
sql;
      return $mysqli->delete($query,array(':id' => $id));
    }

    public static function deleteService($id){
      $mysqli = Database::getInstance();
//       $query =<<<sql
// DELETE FROM service WHERE service_id = :id;
// sql;
      $query =<<<sql
UPDATE service SET status = 2 WHERE service_id = :id;
sql;
      return $mysqli->delete($query,array(':id' => $id));
    }

    public static function getById($id){} 

    /**********************************Seleccion Campaña/Servicio********************************************/
        public static function insertCS($campanias){

        $mysqli = Database::getInstance();
                $query =<<<sql
INSERT INTO campaign (name, created , modules_id, delivery_date, campaign_status_id) 
VALUES (:name, NOW() , :modules_id, :delivery_date, :campaign_status_id);
sql;

         $params =array(':name' => $campanias->_name,
                        ':modules_id' => $campanias->_module_id,
                        ':delivery_date' => $campanias->_delivery_date,
                        ':campaign_status_id' => $campanias->_campaing_status_id);

         
         return $mysqli->insert($query,$params);

    }

        public static function insertCC($datos){

        $mysqli = Database::getInstance();
                $query =<<<sql
INSERT INTO campaign_customer (customer_id, campaign_id) 
VALUES (:customer_id, :campaign_id);
sql;

         $params =array(':customer_id' => $datos->_customer_id,
                        ':campaign_id' => $datos->_campaign_id);
         
         return $mysqli->insert($query,$params);
    }

    public static function insertaCCSC($dateccsc){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `campaign_carrier_short_code` (campaign_id, carrier_id, short_code_id)
VALUES (:campaign_id, :carrier_id, :short_code_id);
sql;
        $params=array(':campaign_id'=> $dateccsc->_campaign_id, 
                      ':carrier_id'=> $dateccsc->_carrier_id, 
                      ':short_code_id'=> $dateccsc->_short_code_id);

        return $mysqli->insert($query, $params);
    }

    public static function insertaCCSCC($dateccscc){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `carrier_connection_short_code_campaign` (carrier_connection_short_code_id, campaign_id)
VALUES (:carrier_connection_short_code_id, :campaign_id);
sql;
        $params=array(':carrier_connection_short_code_id'=>$dateccscc->_carrier_connection_short_code_id,
                      ':campaign_id'=>$dateccscc->_campaign_id);

        return $mysqli->insert($query, $params);
    }

        public static function findCarriersP($in){
    
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
}