<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ApiDoppler implements Crud{

    public static function getAll(){}
    public static function getById($suscriptor){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM doppler_campaing_suscriptor WHERE campaing_id = '$suscriptor->campaignId' AND suscriptor_email = '$suscriptor->suscriptorEmail'
sql;
        return $mysqli->queryOne($query);
    }

    public static function insert($suscriptor){
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO doppler_campaing_suscriptor VALUES(NULL, :campaignId, :suscriptorEmail, :deliveryStatus)
sql;
        $params = array(
            ':campaignId' => $suscriptor->campaignId,
            ':suscriptorEmail' => $suscriptor->suscriptorEmail,
            ':deliveryStatus' => $suscriptor->deliveryStatus
        );
        return $mysqli->insert($query,$params);
    }

    public static function update($suscriptor){
        $mysqli = Database::getInstance();
        $query=<<<sql
        UPDATE doppler_campaing_suscriptor SET
            delivery_status = '$suscriptor->deliveryStatus'
        WHERE campaing_id = $suscriptor->campaignId AND suscriptor_email = '$suscriptor->suscriptorEmail'

sql;
        return $mysqli->update($query);
    }

    public static function delete($id){}

    public static function getCampaignIdExist($campaignId){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM doppler_campaing_suscriptor WHERE campaing_id = $campaignId
sql;
        return $mysqli->queryAll($query);
    }

    public static function getCarrierConectionShortCodeId($datos){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            cc.carrier_connection_short_code_id,
            cc.campaign_id,
            c.carrier_connection_id,
            c.carrier_id
        FROM carrier_connection_short_code_campaign cc
        JOIN carrier_connection_short_code c 
        USING(carrier_connection_short_code_id)
        WHERE cc.campaign_id = $datos->campaign_id
        AND c.carrier_id = $datos->carrier_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function insertGroup($grupo){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO doppler_group_campaign VALUES(NULL, $grupo->_group_id, '$grupo->_name', $grupo->_campaign_id)
sql;
        return $mysqli->insert($query);
    }

    public static function insertCampaign($campaign){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO doppler_campaign VALUES(
            $campaign->_campaignId,
            $campaign->_shippingId,
            '$campaign->_type',
            '$campaign->_name',
            '$campaign->_fecha_envio',
            '$campaign->_fromName',
            '$campaign->_fromEmail',
            '$campaign->_subject',
            '$campaign->_status',
            $campaign->_uniqueClicks,
            $campaign->_totalClicks,
            $campaign->_uniqueOpens,
            $campaign->_totalUnopened,
            $campaign->_totalHardBounces,
            $campaign->_totalSoftBounces,
            $campaign->_totalRecipients,
	        $campaign->_successFullDeliveries,
           $campaign->_doppler_campaign_parent_id
        )
sql;


        $params = array(
            ':campaignId' => $campaign->_campaignId,
            ':shippingId' => $campaign->_shippingId,
            ':type' => $campaign->_type,
            ':fecha_envio' => $campaign->_fecha_envio,
            ':name' => $campaign->_name,
            ':fromName' => $campaign->_fromName,
            ':fromEmail' => $campaign->_fromEmail,
            ':subject' => $campaign->_subject,
            ':status' => $campaign->_status,
            ':uniqueClicks' => $campaign->_uniqueClicks,
            ':totalClicks' => $campaign->_totalClicks,
            ':uniqueOpens' => $campaign->_uniqueOpens,
            ':totalUnopened' => $campaign->_totalUnopened,
            ':totalHardBounces' => $campaign->_totalHardBounces,
            ':totalSoftBounces' => $campaign->_totalSoftBounces,
            ':totalRecipients' => $campaign->_totalRecipients,
           ':successFullDeliveries' => $campaign->_successFullDeliveries,
	       ':doppler_campaign_parent_id' => $campaign->_doppler_campaign_parent_id
        );
        return $mysqli->insert($query, $params);
    }

    public static function updateCampaign($campaign){
        $mysqli = Database::getInstance();
        $status = ($campaign->_status != '')? " status = '$campaign->_status'," : '';
	$query =<<<sql
        UPDATE doppler_campaign SET
            $status
            uniqueClicks = $campaign->_uniqueClicks,
            totalClicks = $campaign->_totalClicks,
            shippingId = $campaign->_shippingId,
            uniqueOpens = $campaign->_uniqueOpens,
            totalUnopened = $campaign->_totalUnopened,
            totalHardBounces = $campaign->_totalHardBounces,
            totalSoftBounces = $campaign->_totalSoftBounces,
            totalRecipients = $campaign->_totalRecipients,
	       successFullDeliveries = $campaign->_successFullDeliveries
        WHERE doppler_campaign_id = $campaign->_campaignId
sql;
        return $mysqli->update($query);
    }

    public static function updateShippingId($campaign){
        $mysqli = Database::getInstance();
        $query =<<<sql
        UPDATE doppler_campaign SET
            shippingId = $campaign->_shippingId
        WHERE doppler_campaign_id = $campaign->_campaignId
sql;
        return $mysqli->update($query);
    }

    public static function getGroupId(){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT IFNULL(max(doppler_group_id)+1, 0) AS id FROM doppler_group_campaign
sql;
        return $mysqli->queryOne($query);
    }

    public static function getCampaigns(){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM doppler_campaign ORDER BY send_date DESC
sql;
        return $mysqli->queryAll($query);
    }

    public static function getCampaignById($campaign_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM doppler_campaign WHERE doppler_campaign_id = $campaign_id
sql;
        return $mysqli->queryOne($query);
    }

    public static function getCampaign($campaign_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM doppler_campaign WHERE doppler_campaign_id = $campaign_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getGroups(){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            dgc.*,
            dc.nombre AS nombre_campaign
        FROM doppler_group_campaign dgc 
        JOIN doppler_campaign dc
        ON dc.doppler_campaign_id = dgc.doppler_campaign_id
        ORDER BY dgc.doppler_group_id DESC
sql;
        return $mysqli->queryAll($query);
    }

    public static function getGroup($doppler_group_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            dgc.*,
            dc.nombre AS nombre_campaign
        FROM doppler_group_campaign dgc 
        JOIN doppler_campaign dc
        ON dc.doppler_campaign_id = dgc.doppler_campaign_id
        WHERE dgc.doppler_group_id = $doppler_group_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getDays(){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT * FROM doppler_day
sql;
        return $mysqli->queryAll($query);
    }

    public static function insertDopplerAutomatedDay($campaign){
        $mysqli = Database::getInstance();
        $query =<<<sql
        INSERT INTO doppler_automated_day VALUES($campaign->_campaignId,$campaign->_day,'$campaign->_type_automated', '$campaign->_hour_automated' )
sql;
        return $mysqli->insert($query);
    }

    public static function getDayCampaignAutomated($campaign_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            da.doppler_campaign_id,
            da.doppler_day_id,
            da.type,
            da.hour,
            dd.nombre
        FROM doppler_automated_day da
        JOIN doppler_day dd
        USING(doppler_day_id)
        WHERE da.doppler_campaign_id = $campaign_id
        ORDER BY dd.doppler_day_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getDayCampaignAutomatedMensual($campaign_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            da.doppler_campaign_id,
            da.doppler_day_id,
            da.type,
            da.hour,
            dd.nombre
        FROM doppler_automated_day da
        JOIN doppler_day dd
        USING(doppler_day_id)
        WHERE da.doppler_campaign_id = $campaign_id
        ORDER BY dd.doppler_day_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getCampaignAutomated(){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            DISTINCT
            c.doppler_campaign_id,
            c.nombre,
            c.type,
            c.name_sender,
            c.email_sender,
            c.subject,
            dc.type AS automated_type,
            dc.hour
        FROM doppler_campaign c
        JOIN doppler_automated_day dc
        ON c.doppler_campaign_id = dc.doppler_campaign_id
        WHERE c.type = 'automated'
        AND status ='shipped'
sql;
        return $mysqli->queryAll($query);
    }

    public static function getCampaignsParentById($campaign_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT 
            dc.*
        FROM doppler_campaign dc
        WHERE dc.doppler_campaign_parent_id = $campaign_id
        AND dc.status ='scheduled'
sql;

        echo $query.'<br>';
        return $mysqli->queryAll($query);
    }

    public static function deleteCampaign($campaign_id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        DELETE FROM doppler_automated_day WHERE doppler_campaign_id = $campaign_id;
        DELETE FROM doppler_campaign WHERE doppler_campaign_id = $campaign_id;

sql;
        return $mysqli->update($query);
    }

}















