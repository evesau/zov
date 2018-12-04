<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Reporteglobal implements Crud
{

    public static function insert($client){}

    public static function getById($id){}

    public static function delete($id){}

    public static function update($id){}

    public static function getAllCampaignSms(){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT s.campaign_id, c.name
FROM sms s
INNER JOIN campaign c
USING ( campaign_id )
GROUP BY s.campaign_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getAll(){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE MONTH( s.entry_time ) = MONTH( CURDATE( ) )
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
sql;
        return $mysqli->queryAll($query);
    }

    public static function getAllPart($start, $length){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE MONTH( s.entry_time ) = MONTH( CURDATE( ) )
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
LIMIT $start,$length
sql;
		
		return $mysqli->queryAll($query);
    }
    ##### Busqueda por parametros #####
    public static function getAllParams($fecha_inicial,$fecha_final,$key_santander,$msisdn,$campania){ // todos los parametros muestra total
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND cl.key_santander = '$key_santander'
AND s.destination = $msisdn
AND c.campaign_id IN ( $campania )
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
sql;

        return $mysqli->queryAll($query);
    }

    public static function getAllPartParams($fecha_inicial,$fecha_final,$key_santander,$msisdn,$campania,$start,$length){ // todos los parametros muestra datos
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND cl.key_santander = '$key_santander'
AND s.destination = $msisdn
AND c.campaign_id IN ( $campania )
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
LIMIT $start,$length
sql;
       
       return $mysqli->queryAll($query);
    }

    public static function getAllParamsKeyMsisdn($fecha_inicial,$fecha_final,$key_santander,$msisdn){ // todos los parametros muestra total KEY y MSISND
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND cl.key_santander = '$key_santander'
AND s.destination = $msisdn
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
sql;

        return $mysqli->queryAll($query);
    }

    public static function getAllPartParamsKeyMsisdn($fecha_inicial,$fecha_final,$key_santander,$msisdn,$start,$length){ // todos los parametros muestra datos KEY y MSISDN
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND cl.key_santander = '$key_santander'
AND s.destination = $msisdn
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
LIMIT $start,$length
sql;
       
       return $mysqli->queryAll($query);
    }

    public static function getAllParamsKeyCampaign($fecha_inicial,$fecha_final,$key_santander,$campania){ // todos los parametros muestra total KEY, CAMPAIGN
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND cl.key_santander = '$key_santander'
AND c.campaign_id IN ( $campania )
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
sql;

        return $mysqli->queryAll($query);
    }

    public static function getAllPartParamsKeyCampaign($fecha_inicial,$fecha_final,$key_santander,$campania,$start,$length){ // todos los parametros muestra datos KEY, CAMPAIGN
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND cl.key_santander = '$key_santander'
AND c.campaign_id IN ( $campania )
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
LIMIT $start,$length
sql;
       
       return $mysqli->queryAll($query);
    }

    public static function getAllParamsKey($fecha_inicial,$fecha_final,$key_santander){ // todos los parametros muestra total KEY
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND cl.key_santander = '$key_santander'
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
sql;

        return $mysqli->queryAll($query);
    }

    public static function getAllPartParamsKey($fecha_inicial,$fecha_final,$key_santander,$start,$length){ // todos los parametros muestra datos KEY
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND cl.key_santander = '$key_santander'
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
LIMIT $start,$length
sql;
       
       return $mysqli->queryAll($query);
    }

    public static function getAllParamsMsisdnCampaign($fecha_inicial,$fecha_final,$msisdn,$campania){ // todos los parametros muestra total MSISDN, CAMPAIGN
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND s.destination = $msisdn
AND c.campaign_id IN ( $campania )
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
sql;

        return $mysqli->queryAll($query);
    }

    public static function getAllPartParamsMsisdnCampaign($fecha_inicial,$fecha_final,$msisdn,$campania,$start,$length){ // todos los parametros muestra datos MSISDN, CAMPAIGN
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND s.destination = $msisdn
AND c.campaign_id IN ( $campania )
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
LIMIT $start,$length
sql;
       
       return $mysqli->queryAll($query);
    }

    public static function getAllParamsMsisdn($fecha_inicial,$fecha_final,$msisdn){ // todos los parametros muestra total MSISDN
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND s.destination = $msisdn
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
sql;

        return $mysqli->queryAll($query);
    }

    public static function getAllPartParamsMsisdn($fecha_inicial,$fecha_final,$msisdn,$start,$length){ // todos los parametros muestra datos MSISDN
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND s.destination = $msisdn
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
LIMIT $start,$length
sql;
       
       return $mysqli->queryAll($query);
    }

    public static function getAllParamsCampaign($fecha_inicial,$fecha_final,$campania){ // todos los parametros muestra total CAMPAIGN
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND c.campaign_id IN ( $campania )
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
sql;

        return $mysqli->queryAll($query);
    }

    public static function getAllPartParamsCampaign($fecha_inicial,$fecha_final,$campania,$start,$length){ // todos los parametros muestra datos CAMPAIGN
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
AND c.campaign_id IN ( $campania )
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
LIMIT $start,$length
sql;
    
       return $mysqli->queryAll($query);
    }

     public static function getAllParamsDates($fecha_inicial,$fecha_final){ // todos los parametros muestra total FECHAS
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
sql;

        return $mysqli->queryAll($query);
    }

    public static function getAllPartParamsDates($fecha_inicial,$fecha_final,$start,$length){ // todos los parametros muestra datos FECHAS
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT GROUP_CONCAT( s.entry_time SEPARATOR '<br>' ) AS fecha,
cl.key_santander,
s.destination AS msisdn,
GROUP_CONCAT( c.name SEPARATOR '<br>' ) AS campania,
count( s.content ) AS mensaje,
s.direction
FROM client_list cl
INNER JOIN sms s ON ( cl.msisdn = s.destination
OR cl.msisdn = s.source )
INNER JOIN campaign c
USING ( campaign_id )
WHERE s.entry_time BETWEEN '$fecha_inicial' AND '$fecha_final'
GROUP BY key_santander
ORDER BY s.destination, c.campaign_id
LIMIT $start,$length
sql;
  
       return $mysqli->queryAll($query);
    }

}







