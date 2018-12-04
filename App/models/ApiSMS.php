<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ApiSMS implements Crud{

    public static function getAll(){}
    public static function getById($data){}
    public static function insert($data){}
    public static function update($data){}
    public static function delete($data){}

    public static function getMOByDetail($input){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
    	SELECT 
            sms.*,
            sn.* 
        FROM sms
        JOIN msisdn sn
        ON sn.msisdn = sms.source
        WHERE sms.direction = 'MO'
        AND sms.campaign_id = {$input['card']['campaign']}
        AND sms.content LIKE '%{$input['card']['text']}%' 
        AND sms.source = '{$input['card']['from']}'
        AND sms.destination = '{$input['card']['to']}'
        AND sms.carrier_connection_short_code_id = {$input['card']['carrier']}
sql;
		return $mysqli->queryOne($query);
    }

    public static function getMO($input){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
        SELECT 
            sms.*,
            sn.* 
        FROM sms
        JOIN msisdn sn
        ON sn.msisdn = sms.source
        WHERE sms.direction = 'MO'
        AND sms.content LIKE '%{$input['card']['text']}%' 
        AND sms.source = '{$input['card']['from']}'
        AND sms.destination = '{$input['card']['to']}'
sql;
        return $mysqli->queryOne($query);
    }

    public static function getCampaignUser($campaign_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            *
        FROM campaign_user
        WHERE campaign_id = $campaign_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getCampaignCustomer($campaign_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            *
        FROM campaign_customer
        WHERE campaign_id = $campaign_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getCampaignByCustomerId($customer_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            *
        FROM campaign_customer
        WHERE customer_id = $customer_id
        ORDER BY campaign_customer_id DESC
sql;
        return $mysqli->queryOne($query);
    }

}