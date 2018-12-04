<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class WebhookSky implements Crud{

	public static function getAll(){}

	public static function getById($data){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT rcs_msisdn_id FROM rcs_msisdn WHERE msisdn_log = :msisdn_log
sql;
		$array = array(
			':msisdn_log'=>$data
		);
		return $mysqli->queryOne($query,$array);
	}
    public static function insert($param){
    	$mysqli = Database::getInstance();
		$query = <<<sql
INSERT INTO rcs_webhook(rcs_msisdn_id, message_id, data, attributes_type, attribites_event_type, publish_time) VALUES(:rcs_msisdn_id, :message_id, :data, :attributes_type, :attribites_event_type, :publish_time)
sql;
		$array = array(
			':rcs_msisdn_id'=>$param->_rcs_msisdn_id,
			':message_id'=>$param->_message_id,
			':data'=>$param->_data,
			':attributes_type'=>$param->_attributes_type,
			':attribites_event_type'=>$param->_attribites_event_type,
			':publish_time'=>$param->_publish_time
		);
		return $mysqli->insert($query,$array);
    }
	public static function update($param){}
    public static function delete($param){}
}