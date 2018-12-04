<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Client implements Crud
{

    public static function getAllClients($custom){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM client c
INNER JOIN customer_client cc USING (client_id)
WHERE cc.customer_id = :id;
sql;

    return $mysqli->queryAll($query,array(':id' => $custom));
    }

    public static function insert($client){ 
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO client (name, status)
VALUES (:name, :status);
sql;
        $params = array(':name' =>  $client->_nombre,
                        ':status' => $client->_status
                        );

        return $mysqli->insert($query,$params);
    }

    public static function insertClientCustomer($client,$client_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO customer_client (customer_id, client_id)
VALUES (:custom, :client_id);
sql;
        $params = array(':custom' => $client->_customer_id,
                        ':client_id' => $client_id);
        
        return $mysqli->insert($query,$params);
    }

    public static function getById($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM client
WHERE client_id = :id;
sql;
        return $mysqli->queryOne($query,array(':id' => $id));   
    }
    
    public static function update($client){
        $mysqli = Database::getInstance();
        $query =<<<sql
UPDATE client SET name = :name, status = :status 
WHERE client_id = :id;
sql;
        $params = array(':name' => $client->_nombre,
                        ':status' => $client->_status,
                        ':id' => $client->_customer_id
                        );

        return $mysqli->update($query,$params);
    }

    public static function delete($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
DELETE FROM client WHERE client_id = :id;
sql;
        return $mysqli->delete($query, array(':id'=>$id));
    }

    public static function getMsisdn($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM client_msisdn c
INNER JOIN msisdn m USING (msisdn_id)
INNER JOIN carrier ca ON (ca.carrier_id = m.carrier_id)
WHERE c.client_id = :id;
sql;

        return $mysqli->queryAll($query, array(':id' => $id));
    }

    public static function getMsisdnBusca($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT m.msisdn_id, m.msisdn, m.carrier_id
        FROM msisdn m
        INNER JOIN client_msisdn cm
        USING ( msisdn_id )
        WHERE cm.client_id =$id
sql;
        return $mysqli->queryAll($query);
    }

    public static function busca_msisdn_bd($msisdn){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT *
        FROM msisdn
        WHERE msisdn =52{$msisdn}
        ORDER BY msisdn_id DESC

sql;

        return $mysqli->queryOne($query);

    }

    public static function busca_msisdn_carrier_bd($msisdn, $carrier){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT *
        FROM msisdn
        WHERE msisdn =52{$msisdn}
        AND carrier_id = $carrier
sql;

        return $mysqli->queryOne($query);

    }

    public static function getMsisdnTelcel($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT m.msisdn_id, m.msisdn, m.carrier_id
        FROM msisdn m
        INNER JOIN client_msisdn cm
        USING ( msisdn_id )
        WHERE cm.client_id =$id
        AND m.carrier_id =1
sql;
        return $mysqli->queryAll($query);
    }

    public static function getMsisdnMovistar($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT m.msisdn_id, m.msisdn, m.carrier_id
        FROM msisdn m
        INNER JOIN client_msisdn cm
        USING ( msisdn_id )
        WHERE cm.client_id =$id
        AND m.carrier_id =2
sql;
        return $mysqli->queryAll($query);
    }

    public static function getMsisdnAtt($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT m.msisdn_id, m.msisdn, m.carrier_id
        FROM msisdn m
        INNER JOIN client_msisdn cm
        USING ( msisdn_id )
        WHERE cm.client_id =$id
        AND m.carrier_id =3
sql;
        return $mysqli->queryAll($query);
    }

        public static function getMsisdnProceso($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT m.msisdn_id, m.msisdn, m.carrier_id
        FROM msisdn m
        INNER JOIN client_msisdn cm
        USING ( msisdn_id )
        WHERE cm.client_id =$id
        AND m.carrier_id IN (-2,0)
sql;
        return $mysqli->queryAll($query);
    }

    public static function getMsisdnCarrier($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT *
        FROM client_msisdn c
        INNER JOIN msisdn m
        USING ( msisdn_id )
        WHERE c.client_id =$id
sql;
        return $mysqli->queryAll($query);
    }

    public static function updateMsisdnCarrier($msisdn_id,$newCarrier){
        $mysqli = Database::getInstance();
        $query =<<<sql
        UPDATE msisdn SET carrier_id=$newCarrier WHERE  msisdn_id=$msisdn_id
sql;
        
        return $mysqli->update($query);
    }

    public static function getCarrier(){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM carrier;
sql;
        return $mysqli->queryAll($query);
    }

    public static function insert_msisdn($msisdn){
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO msisdn (msisdn, carrier_id)
        VALUES (:msisdn,:carrier_id)
sql;
        $params = array(':msisdn' => '52'.$msisdn->_msisdn,
                        ':carrier_id' => $msisdn->_carrier
                        );

        return $mysqli->insert($query,$params);
    }

    public static function insertClientMsisdn($msisdn,$addmsisdn){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO client_msisdn (client_id,msisdn_id)
        VALUES ($msisdn->_client, $addmsisdn);
sql;
        $params = array(':client_id' => $msisdn->_client,
                        ':msisdn_id' => $addmsisdn
                        );

        return $mysqli->insert($query,$params);
    }

    public static function delete_msisdn($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        DELETE FROM msisdn WHERE msisdn_id = :id;
sql;
        $mysqli->delete($query,array(':id' => $id));

        $query1=<<<sql
        DELETE FROM client_msisdn WHERE msisdn_id = :id;
sql;
        return $mysqli->delete($query1,array(':id' => $id));
    }

    public static function getById_Msisdn($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM msisdn WHERE msisdn_id = :id;
sql;
        return $mysqli->queryOne($query,array(':id'=> $id));
    }

    public static function update_msisdn($msisdn){
        $mysqli = Database::getInstance();
        $query =<<<sql
        UPDATE msisdn SET msisdn = :msisdn, carrier_id = :carrier_id 
        WHERE msisdn_id = :msisdn_id;       
sql;
        $params= array(':msisdn' => $msisdn->_msisdn,
                       ':carrier_id' => $msisdn->_carrier,
                       ':msisdn_id' => $msisdn->_msisdn_id
                       );

        return $mysqli->update($query,$params);
    }

    public static function insert_msisdn_excel($msisdn,$carrier){
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO msisdn (msisdn, carrier_id)
        VALUES (:msisdn,:carrier_id)
sql;
        $params = array(':msisdn' => '52'.$msisdn,
                        ':carrier_id' => $carrier
                        );

        return $mysqli->insert($query,$params);
    }

    public static function insertClientMsisdn_excel($id_cliente,$addmsisdn){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO client_msisdn (client_id,msisdn_id)
        VALUES (:client_id, :msisdn_id);
sql;
        $params = array(':client_id' => $id_cliente,
                        ':msisdn_id' => $addmsisdn
                        );

        return $mysqli->insert($query,$params);
    }

    public static function isBlackListTelcel($msisdn){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * 
        FROM blacklist_telcel
        WHERE number = :msisdn
sql;
        return $mysqli->queryOne($query,array(':msisdn' => $msisdn));
    }

    public static function isBlackListMovi($msisdn){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * 
        FROM blacklist_movistar
        WHERE number = :msisdn
sql;
        return $mysqli->queryOne($query,array(':msisdn' => $msisdn));
    }

    public static function isBlackListATT($msisdn){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * 
        FROM blacklist_att
        WHERE number = :msisdn
sql;
        return $mysqli->queryOne($query,array(':msisdn' => $msisdn));
    }

    public static function getAll(){}

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

    public static function buscarMsisdn($msisdn){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * from msisdn 
        WHERE msisdn = $msisdn 
        ORDER BY msisdn_id DESC
sql;
        return $mysqli->queryOne($query);
    }

}







