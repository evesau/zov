<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Groupsenvios implements Crud
{

    public static function getAll(){
	   $mysqli = Database::getInstance();
	   $query=<<<sql
sql;

	   return $mysqli->queryAll($query);

    }

    public static function getById($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
sql;

        return $mysqli->queryAll($query, array(':id'=>$id));

    }

    
    public static function insert($data){
        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO groups_envios(ctime, name, status, customer_id) VALUES (NOW(),:name,1,:customer_id)
sql;
        $params = array(    
                        ':name' => $data->_name,
                        ':customer_id'  => $data->_customer_id
                    );

        return $mysqli->insert($query, $params);

    }

    public static function insertGroupUsers($user_id,$group_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO groups_user(user_id, groups_envios_id) VALUES ($user_id,$group_id)
sql;

        return $mysqli->insert($query);
    }

    public static function getGroupUsers($user_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM groups_user WHERE user_id = $user_id
sql;

        return $mysqli->queryOne($query);

    }

    public static function getGroup($data){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM groups_envios WHERE name=:name AND customer_id =:customer_id
sql;
        $params = array(    
                        ':name' => $data->_name,
                        ':customer_id'  => $data->_customer_id
                    );

        return $mysqli->queryOne($query,$params);
    }


    public static function update($data){
        $mysqli = Database::getInstance();
        $query=<<<sql
UPDATE groups_envios SET name=:name WHERE groups_envios_id=:id
sql;
        
        $params = array(    
                        ':name' => $data->_name,
                        ':id'  => $data->_groups_envios_id
                    );

        return $mysqli->update($query, $params);
    }

    
    public static function delete($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
DELETE FROM groups_envios WHERE groups_envios_id=:id
sql;
        return $mysqli->delete($query, array(':id'=>$id));	
    }

    public static function deleteUsersGroup($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
DELETE FROM groups_user WHERE groups_envios_id=:id
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

    public static function getUsersCustomer($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT user_id, nickname, first_name, last_name, name
FROM customer c
INNER JOIN user_customer uc
USING ( customer_id )
INNER JOIN user u
USING ( user_id )
WHERE c.status =1
AND u.status =1
AND c.customer_id =$customer_id
sql;
        return $mysqli->queryAll($query);
    }


    public static function getGroupsCustomer($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM groups_envios WHERE status=1 AND customer_id =$customer_id
sql;
        return $mysqli->queryAll($query);
    }


    public static function getUsersCustomerGruoup($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT *
FROM groups_envios ge
INNER JOIN groups_user gu
USING ( groups_envios_id )
INNER JOIN user u
USING ( user_id )
WHERE ge.groups_envios_id =$id
sql;

        return $mysqli->queryAll($query);
    }


    public static function getNameGroup($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * FROM groups_envios WHERE groups_envios_id =$id
sql;

        return $mysqli->queryOne($query);
    }


    public static function getUsersGroupsTotalMesActual($customer_id,$name_group){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT nickname,total FROM view_groups_envios_customer
WHERE customer_id =$customer_id
AND name LIKE "$name_group"
sql;
        //print_r($query);
        return $mysqli->queryAll($query);
    }

    public static function getUsersGroupsTotalMes($customer_id,$group,$fecha_index){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT 
IF(create_time is null, curdate(), create_time) as fecha ,
IF(customer_id is null, 0, customer_id) as customer_id ,
IF(name is null, '', name) as name ,
nickname ,
IF(sum(delivered) is null,0, sum(delivered)) as total
FROM user
LEFT JOIN groups_user gu USING (user_id)
LEFT JOIN  user_control_mt AS ucm ON (user.user_id = ucm.user_id AND MONTH(create_time) = MONTH('$fecha_index'))
LEFT JOIN  groups_envios ge ON (ge.groups_envios_id=gu.groups_envios_id)
WHERE customer_id=$customer_id
AND name LIKE '$group'
GROUP BY user.user_id
ORDER BY ge.groups_envios_id
sql;
        //mail('tecnico@airmovil.com','query mes',$query);
        return $mysqli->queryAll($query);
    }

    public static function getUserNoGroup($customer_id,$fecha_index){
        if (empty($fecha_index)) {
            $fecha_index = 'MONTH(curdate())';
        } else {
            $fecha_index =" MONTH('$fecha_index')";
        }

        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT 
IF(create_time is null, curdate(), create_time) as fecha ,
IF(ge.customer_id is null, cu.customer_id, ge.customer_id) as customer_id ,
IF(name is null, '', name) as name ,
nickname ,
IF(sum(delivered) is null,0, sum(delivered)) as total
FROM user
LEFT JOIN groups_user gu USING (user_id)
LEFT JOIN user_customer cu USING (user_id)
LEFT JOIN user_control_mt AS ucm ON (user.user_id = ucm.user_id AND MONTH(create_time) = $fecha_index)
LEFT JOIN groups_envios ge USING (groups_envios_id)
WHERE groups_envios_id is null
AND (ge.customer_id = $customer_id OR cu.customer_id = $customer_id)
GROUP BY user.user_id
sql;
        return $mysqli->queryAll($query);
    }
    
}