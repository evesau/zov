<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Campania implements Crud{

	public static function getAllCampaign($id){
		$mysqli = Database::getInstance();
		$query =<<<sql
SELECT c.campaign_id, c.name, c.delivery_date, cs.name as status_campaign, cs.campaign_status_id FROM campaign c
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN customer cu ON (cc.customer_id = cu.customer_id)
INNER JOIN campaign_status cs USING (campaign_status_id)
WHERE cu.customer_id = :id 
AND cs.campaign_status_id != 5
ORDER BY c.campaign_id ASC
sql;
		return $mysqli->queryAll($query,array(':id' => $id));
	}

	public static function getAll(){}

    public static function getById($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT campaign_id, name, created, modules_id, DATE_FORMAT( delivery_date, '%m/%d/%Y %H:%i' ) AS 'delivery_date', campaign_status_id
FROM campaign
WHERE campaign_id = :id;
sql;
        return $mysqli->queryOne($query,array(':id' => $id));   
    }

    public static function insert($campanias){

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


	public static function update($datos){
		$mysqli = Database::getInstance();
		$query =<<<sql
UPDATE campaign SET name=:name, delivery_date=:fecha, campaign_status_id = :status
WHERE campaign_id=:campaign_id;
sql;

 		$params =array(	':name' => $datos->_name,
 						':fecha' => $datos->_delivery_date,
		 				':campaign_id' => $datos->_campaign_id,
                        ':status' => $datos->_status);
		 
		return $mysqli->update($query,$params);
	}

        public static function updateSMSC($datos){
        // echo "model: ";
        // print_r($datos);
        $mysqli = Database::getInstance();
        $query =<<<sql
UPDATE sms.sms_campaign SET delivery_date = :delivery_date,
sms_campaign_estatus_id = $datos->_sms_campaign_estatus_id WHERE sms_campaign.campaign_id = :campaign_id;
sql;

        $params =array( ':campaign_id' => $datos->_campaign_id,
                        ':delivery_date' => $datos->_delivery_date
			);
         
        return $mysqli->update($query,$params);

    }
    
    public static function delete($id){ // se hizo el cambio para updetear a estatus borrado
        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE campaign SET campaign_status_id= 5 WHERE campaign_id = :id;
sql;
        return $mysqli->delete($query, array(':id'=>$id));
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

    public static function getCampaignStatus(){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM campaign_status WHERE campaign_status_id = 4
sql;
        return $mysqli->queryAll($query);
    }

    public static function getShortCode(){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM short_code
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
        SELECT
            cccs.carrier_connection_short_code_id,
            c.name
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

    public static function insertCcsc($registro){
            $mysqli = Database::getInstance();
            $query=<<<sql
            INSERT INTO carrier_connection_short_code_campaign(carrier_connection_short_code_id, campaign_id) VALUES (:carrier_connection_short_code_id,:campaign_id)
sql;
            $params = array(
                ':campaign_id' => $registro->_campaign_id,
                ':carrier_connection_short_code_id' => $registro->_carrier_connection_short_code_id
            );
            return $mysqli->insert($query, $params);
    }

    public static function insertCampaignCarrierShortCode($datos){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO campaign_carrier_short_code 
        VALUES(NULL, $datos->_campaign_id, $datos->_carrier_connection_short_code_id, $datos->_short_code_id)
sql;
        return $mysqli->insert($query);
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

}
