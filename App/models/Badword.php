<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Badword implements Crud{

    public static function getAll(){
      $mysqli = Database::getInstance();
      $query =<<<sql
      select * from bad_words
sql;

      return $mysqli->queryAll($query);
    }

    public static function getAllByCustomer($customer_id){
      $mysqli = Database::getInstance();
      $query =<<<sql
      select * from bad_words WHERE customer_id = $customer_id
sql;
      //mail('jorge.manon@airmovil.com', 'Query Reportes', 'Query: '.$query);
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
INSERT INTO bad_words
VALUES (null, '$datos->_word', $datos->_customer_id);
sql;
        return $mysqli->insert($query);
    }


    public static function update($datos){
      $mysqli = Database::getInstance();
      $query =<<<sql
UPDATE bad_words SET 
word=:word 
WHERE bad_words_id = :id;
sql;
      $params = array(':word' => $datos->_word,
                      ':id' => $datos->_bad_words_id
                      );

      return $mysqli->update($query,$params); 
    }

    public static function delete($id){
    // echo "id: $id";
      $mysqli = Database::getInstance();
      $query =<<<sql
DELETE FROM bad_words WHERE bad_words_id = :id;
sql;
// print_r($query);
      return $mysqli->delete($query,array(':id' => $id));
    }

    public static function getById($id){}

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