<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ApiUnique implements Crud{

    public static function getAll(){}
    public static function getById($id){}
    
    public static function insert($data){
        $mysqli = Database::getInstance();
        $query =<<<sql
INSERT INTO `unique`(`ctime`, `mtime`, `value`, `status`) VALUES (NOW(),NOW(),'$data->_value',$data->_status)
sql;
        //mail("tecnico@airmovil.com","query insert",$query.print_r($params,1),print_r($data,1));
        return $mysqli->insert($query);
    }

    public static function update($data){}
    public static function delete($id){}

    public static function getUnico($status){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT *  FROM `unique` 
WHERE `status` = $status
ORDER BY unique_id ASC
LIMIT 1
sql;
        return $mysqli->queryOne($query);
    }

    public static function insertUrl($url,$unique_id,$customer_id,$msisdn){
        $mysqli = Database::getInstance();
        if (strlen($msisdn)==10) {
            $msisdn = '52'.$msisdn;
        }
        $query =<<<sql
INSERT INTO `url`(`ctime`, `mtime`, `url`, `unique_id`, `customer_id`,`msisdn`,`campaign_id`) VALUES (NOW(),NOW(),'$url',$unique_id,$customer_id,'$msisdn',0);
sql;
        return $mysqli->insert($query);
    }

    public static function updateStatus($status,$unique_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
UPDATE `unique` SET `status`=$status WHERE `unique_id`=$unique_id
sql;
        return $mysqli->update($query);
    }

    public static function updateUIrlByIdDao($campaniaId,$url_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
UPDATE `url` SET `campaign_id` =$campaniaId WHERE `url_id` =$url_id
sql;
        //mail("tecnico@airmovil.com","query updateUIrlByIdDao",$query);
        return $mysqli->update($query);
    }

}
