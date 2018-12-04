<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class ReportesmtCampMail implements Crud{

	public static function insert($msisdn){}
    public static function getById($param){}
    public static function getAll(){}
    public static function update($param){}
    public static function delete($param){}

    public static function getMTAllCount($data){

      $mysqli = Database::getInstance();

      $params = array(  ':customer_id' => $data->customer_id,
                        ':fecha_inicio' => $data->fecha_inicio,
                        ':fecha_fin' => $data->fecha_fin,
                        ':source' => $data->source
                );

      $where ="";

      if ($data->estatus == 'ACCEPTD' || $data->estatus == 'REJECTD' || $data->estatus == 'failed') {
        $_estatus = " AND sms.status_dlr LIKE :estatus ";
      } else {
        $_estatus = " AND (sms.status LIKE :estatus AND sms.status_dlr LIKE '') ";
      }

      if ($data->carrier == 'sincarrier') {
        $_carrier = " AND ( sms.carrier LIKE :carrier AND sms.status_dlr LIKE :carrier ) ";
      } else {
        $_carrier = " AND sms.carrier LIKE :carrier ";
      }

      if ( empty($data->carrier) && empty($data->destination) && empty($data->estatus) ) {

        $consulta = 1;

      } elseif ( empty($data->carrier) && empty($data->destination) && !empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':estatus'] .= $data->estatus;
        $where .= " $_estatus ";

      } elseif ( empty($data->carrier) && !empty($data->destination) && empty($data->estatus) ) {
        
        $consulta = 1;
        $params[':destination'] .= $data->destination;
        $where .= " AND sc.msisdn_log = :destination ";

      } elseif ( empty($data->carrier) && !empty($data->destination) && !empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':destination'] .= $data->destination;
        $params[':estatus'] .= $data->estatus;
        $where .= " AND sms.destination = :destination $_estatus ";

      } elseif ( !empty($data->carrier) && empty($data->destination) && empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':carrier'] .= ($data->carrier == 'sincarrier') ? '' : $data->carrier;
        $where .= " $_carrier ";

      } elseif ( !empty($data->carrier) && empty($data->destination) && !empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':carrier'] .= ($data->carrier == 'sincarrier') ? '' : $data->carrier;
        $params[':estatus'] .= $data->estatus;
        $where = " $_carrier $_estatus ";

      } elseif ( !empty($data->carrier) && !empty($data->destination) && empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':carrier'] .= ($data->carrier == 'sincarrier') ? '' : $data->carrier;
        $params[':destination'] .= $data->destination;
        $where = " $_carrier AND sms.destination = :destination ";

      } elseif ( !empty($data->carrier) && !empty($data->destination) && !empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':carrier'] .= ($data->carrier == 'sincarrier') ? '' : $data->carrier;
        $params[':destination'] .= $data->destination;
        $params[':estatus'] .= $data->estatus;
        $where = " $_carrier AND sms.destination = :destination $_estatus ";

      }

      

      if ($consulta == 1) {

        if ( !empty($data->campaign_id) ) {

          $params[':campaign_id'] .= $data->campaign_id;
          $campaign_id = " AND sc.campaign_id = :campaign_id ";

        }
        
        $query =<<<sql
SELECT 
    *
FROM sms_campaign AS sc
WHERE (sc.ctime >= :fecha_inicio AND sc.ctime <= :fecha_fin )
AND sc.short_code_log LIKE :source
AND sc.customer_id = :customer_id
$campaign_id
$where
sql;

      } else {

        if ( !empty($data->campaign_id) ) {

          $params[':campaign_id'] .= $data->campaign_id;
          $campaign_id = " AND sms.campaign_id = :campaign_id ";

        }

        $query =<<<sql
SELECT 
    *
FROM sms AS sms
WHERE (sms.entry_time >= :fecha_inicio AND sms.entry_time <= :fecha_fin )
AND sms.source LIKE :source
AND sms.customer_id = :customer_id
$campaign_id
$where
sql;

      }
      

      return $mysqli->queryAll($query, $params);

    }

    public static function getMTListData($data, $start, $length){
      mail("esau.espinoza@airmovil.com", "ejecuta mail", print_r($data,1));

      $mysqli = Database::getInstance(1,1);

      $params = array(  ':customer_id' => $data->customer_id,
                        ':fecha_inicio' => $data->fecha_inicio,
                        ':fecha_fin' => $data->fecha_fin,
                        ':source' => $data->source
                );

      $where ="";
      $LIMIT ='';
      if ($data->estatus == 'ACCEPTD' || $data->estatus == 'REJECTD' || $data->estatus == 'failed') {
        $_estatus = " AND sms.status_dlr LIKE :estatus ";
      } else {
        $_estatus = " AND (sms.status LIKE :estatus AND sms.status_dlr LIKE '') ";
      }

      if ($data->carrier == 'sincarrier') {
        $_carrier = " AND ( sms.carrier LIKE :carrier AND sms.status_dlr LIKE :carrier ) ";
      } else {
        $_carrier = " AND sms.carrier LIKE :carrier ";
      }

      if ( empty($data->carrier) && empty($data->destination) && empty($data->estatus) ) {

        $consulta = 1;

      } elseif ( empty($data->carrier) && empty($data->destination) && !empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':estatus'] .= $data->estatus;
        $where .= " $_estatus ";

      } elseif ( empty($data->carrier) && !empty($data->destination) && empty($data->estatus) ) {
        
        $consulta = 1;
        $params[':destination'] .= $data->destination;
        $where .= " AND sc.msisdn_log = :destination ";

      } elseif ( empty($data->carrier) && !empty($data->destination) && !empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':destination'] .= $data->destination;
        $params[':estatus'] .= $data->estatus;
        $where .= " AND sms.destination = :destination $_estatus ";

      } elseif ( !empty($data->carrier) && empty($data->destination) && empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':carrier'] .= ($data->carrier == 'sincarrier') ? '' : $data->carrier;
        $where .= " $_carrier ";

      } elseif ( !empty($data->carrier) && empty($data->destination) && !empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':carrier'] .= ($data->carrier == 'sincarrier') ? '' : $data->carrier;
        $params[':estatus'] .= $data->estatus;
        $where = " $_carrier $_estatus ";

      } elseif ( !empty($data->carrier) && !empty($data->destination) && empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':carrier'] .= ($data->carrier == 'sincarrier') ? '' : $data->carrier;
        $params[':destination'] .= $data->destination;
        $where = " $_carrier AND sms.destination = :destination ";

      } elseif ( !empty($data->carrier) && !empty($data->destination) && !empty($data->estatus) ) {
        
        $consulta = 2;
        $params[':carrier'] .= ($data->carrier == 'sincarrier') ? '' : $data->carrier;
        $params[':destination'] .= $data->destination;
        $params[':estatus'] .= $data->estatus;
        $where = " $_carrier AND sms.destination = :destination $_estatus ";

      }


      if ($start !='' && $length !='' ) {
        $LIMIT = "LIMIT $start, $length ";
      }

      

      if ($consulta == 1) {

        if ( !empty($data->campaign_id) ) {

          $params[':campaign_id'] .= $data->campaign_id;
          $campaign_id = " AND sc.campaign_id = :campaign_id ";

        }
        
        $query =<<<sql
SELECT 
  (
      SELECT 
      (
          CASE
          WHEN sms.entry_time IS NULL THEN sc.ctime
          WHEN sms.entry_time !='' THEN sms.delivery_time
          ELSE sms.entry_time
          END
      ) AS time
      FROM sms
      WHERE sms.customer_id = :customer_id
      AND sms.content = sc.content
      AND (sms.entry_time >= :fecha_inicio AND sms.entry_time <= :fecha_fin )
      AND sms.source LIKE :source
      AND sms.destination = sc.msisdn_log
      AND sms.delivery_time >= sc.ctime
      GROUP BY sms.destination
  ) AS FECHA,
  (
      SELECT
      (
          CASE
          WHEN m.carrier_id = 1 THEN 'telcel'
          WHEN m.carrier_id = 2 THEN 'movistar'
          WHEN m.carrier_id = 3 THEN 'att'
          ELSE 'multicarrier'
          END
      ) AS carriers
      FROM msisdn AS m
      WHERE m.msisdn = sc.msisdn_log
  ) AS CARRIER,
  sc.msisdn_log AS DESTINATION,
  sc.short_code_log AS SHORTCODE,
  sc.content AS CONTENT,
  (
      SELECT
      (
          IF(sms.status_dlr='','delivered', sms.status_dlr)
      ) AS statussms
      FROM sms
      WHERE sms.customer_id = :customer_id
      AND sms.content = sc.content
      AND (sms.entry_time >= :fecha_inicio AND sms.entry_time <= :fecha_fin)
      AND sms.source LIKE :source
      AND sms.destination = sc.msisdn_log
      AND sms.delivery_time >= sc.ctime
      GROUP BY sms.destination
  ) AS ESTATUSSMS,
  IF(sc.loteId=' ',0, sc.loteId) AS LOTEID,
  IF(sc.loteDetalleId=' ',0,sc.loteDetalleId) AS LOTEDETALLEID
FROM sms_campaign AS sc
WHERE (sc.ctime >= :fecha_inicio AND sc.ctime <= :fecha_fin )
AND sc.short_code_log LIKE :source
AND sc.customer_id = :customer_id
$campaign_id
$where
$LIMIT
sql;

      } else {

        if ( !empty($data->campaign_id) ) {

          $params[':campaign_id'] .= $data->campaign_id;
          $campaign_id = " AND sms.campaign_id = :campaign_id ";

        }

        $query =<<<sql
SELECT 
  sms.delivery_time AS FECHA,
  (
      IF(sms.carrier='',
         (
             SELECT 
                (
                    CASE
                    WHEN carrier_id = 1 THEN 'telcel'
                    WHEN carrier_id = 2 THEN 'movistar'
                    WHEN carrier_id = 3 THEN 'att'
                    ELSE 'multicarrier'
                    END
                ) AS carriers
             FROM msisdn 
             WHERE msisdn = sms.destination
	     GROUP BY msisdn
         )
         ,sms.carrier)
  ) AS CARRIER,
  sms.destination AS DESTINATION,
  sms.source AS SHORTCODE,
  sms.content AS CONTENT,
  (
      IF(sms.status_dlr='',sms.status, sms.status_dlr)
  ) AS ESTATUSSMS,
  (
      SELECT
          IF(sc.loteId=' ',0,sc.loteId)
      FROM sms_campaign AS sc
      WHERE (sc.ctime >= :fecha_inicio AND sc.ctime <= :fecha_fin)
      AND sc.customer_id = :customer_id
      AND sc.campaign_id = sms.campaign_id
      AND sc.content = sms.content
      AND sc.short_code_log = sms.source
      AND sc.msisdn_log = sms.destination
      AND sc.ctime <= sms.delivery_time
      GROUP BY sc.msisdn_log
  ) AS LOTEID,
  (
      SELECT
      IF(sc.loteDetalleId=' ',0,sc.loteDetalleId)
      FROM sms_campaign AS sc
      WHERE sc.customer_id = :customer_id
      AND sc.content = sms.content
      AND (sc.ctime >= :fecha_inicio AND sc.ctime <= :fecha_fin)
      AND sc.campaign_id = sms.campaign_id
      AND sc.short_code_log = sms.source
      AND sc.msisdn_log = sms.destination
      AND sc.ctime <= sms.delivery_time
      GROUP BY sc.msisdn_log
  ) AS LOTEDETALLEID
FROM sms AS sms
WHERE (sms.entry_time >= :fecha_inicio AND sms.entry_time <= :fecha_fin )
AND sms.source LIKE :source
AND sms.customer_id = :customer_id
$campaign_id
$where
$LIMIT
sql;

      }

      //mail("esau.espinoza@airmovil.com","Query filtro limit", print_r($params, 1) . $query . " \nstart: $start - length: $length" );
      

      return $mysqli->queryAll($query, $params);

    }

    


	public static function getAllCampaignMT($id){
		$mysqli = Database::getInstance();
		$query =<<<sql
SELECT c.campaign_id, c.name AS name_campaign, c.delivery_date, sc.short_code
FROM campaign c
LEFT JOIN campaign_api_web
USING ( campaign_id )
INNER JOIN campaign_customer cc
USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN carrier_connection_short_code_campaign ccscc
USING ( campaign_id )
INNER JOIN carrier_connection_short_code ccsc ON ( ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id )
INNER JOIN short_code sc ON ( sc.short_code_id = ccsc.short_code_id )
INNER JOIN campaign_status cs ON ( cs.campaign_status_id = c.campaign_status_id )
WHERE cu.customer_id = $id


AND cs.campaign_status_id NOT
IN ( 4, 5 )
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);

		//AND MONTH( c.delivery_date ) = MONTH( CURDATE( ) )
		// AND campaign_api_web_id IS NULL
	}


  public static function getShortCodes($data){
    $mysqli = Database::getInstance();
    $query =<<<sql
SELECT DISTINCT(sc.short_code)  FROM custome_carrier_connection_short_code AS cccsc
INNER JOIN carrier_connection_short_code AS ccsc ON (ccsc.carrier_connection_short_code_id=cccsc.carrier_connection_short_code_id)
INNER JOIN short_code AS sc ON(sc.short_code_id=ccsc.short_code_id)
WHERE cccsc.customer_id =:customer_id
sql;

    $params = array(':customer_id' => $data->customer_id);

    return $mysqli->queryAll($query, $params);

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

