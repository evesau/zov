<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class AdminReporte implements Crud{

	public static function insert($msisdn){}
    public static function getById($param){}
    public static function getAll(){}

	public static function getAllCampaign(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.campaign_id, c.name AS name_campaign, c.delivery_date, sc.short_code
FROM campaign c
INNER JOIN campaign_customer cc using(campaign_id)
INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
INNER JOIN carrier_connection_short_code_campaign ccscc using(campaign_id)
INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
INNER JOIN short_code sc on (sc.short_code_id = ccsc.short_code_id)
GROUP BY c.campaign_id;
sql;

		return $mysqli->queryAll($query);
	}

	public static function getTotalMessages(){
		$mysqli = Database::getInstance();
		$id = (int)$id;
		$query = <<<sql
SELECT *
FROM campaign c
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN customer cu ON (cc.customer_id = cu.customer_id)
INNER JOIN sms_campaign smsc USING (campaign_id)
INNER JOIN campaign_status cs USING (campaign_status_id)
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING (carrier_connection_short_code_id)
INNER JOIN short_code sc USING (short_code_id)
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesCop($start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
		SELECT  c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code , m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
		FROM campaign c
		INNER JOIN campaign_customer cc USING (campaign_id)
		INNER JOIN customer cu ON (cc.customer_id = cu.customer_id)
		INNER JOIN sms_campaign smsc USING (campaign_id)
		INNER JOIN campaign_status cs USING (campaign_status_id)
		INNER JOIN modules m ON m.modules_id = c.modules_id
		INNER JOIN carrier_connection_short_code ccsc USING (carrier_connection_short_code_id)
		INNER JOIN short_code sc USING (short_code_id)
		WHERE YEAR(c.delivery_date) = YEAR(CURDATE())
		GROUP BY c.campaign_id
		
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearch($id, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCop($id, $start, $length, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchStatus($id, $status, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE cs.name LIKE '%$status%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchStatusCop($id, $status, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE cs.name LIKE '%$status%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchDirection($id, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE m.name LIKE '%$direction%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchDirectionCop($id, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE m.name LIKE '%$direction%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcode($id, $shortcode, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE sc.short_code LIKE '%$shortcode%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcodeCop($id, $shortcode, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE sc.short_code LIKE '%$shortcode%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampania($id, $campania, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin' AND c.name LIKE '%$campania%'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaCop($id, $campania, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin' AND c.name LIKE '%$campania%'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCode($id, $campania, $shortcode,$fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%'
AND sc.short_code LIKE '%$shortcode%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeCop($id, $campania, $shortcode, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%'
AND sc.short_code LIKE '%$shortcode%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaStatus($id, $campania, $status,$fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%'
AND cs.name LIKE '%$status%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaStatusCop($id, $campania, $status, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%'
AND cs.name LIKE '%$status%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

		public static function getTotalMessagesSearchCampaniaDirection($id, $campania, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%'
AND m.name LIKE '%$direction%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaDirectionCop($id, $campania, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%'
AND m.name LIKE '%$direction%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcodeStatus($id, $shortcode, $status, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE sc.short_code LIKE '%$shortcode%'
AND cs.name LIKE '%$status%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcodeStatusCop($id, $shortcode, $status, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE sc.short_code LIKE '%$shortcode%'
AND cs.name LIKE '%$status%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcodeDirection($id, $shortcode, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE sc.short_code LIKE '%$shortcode%'
AND m.name LIKE '%$direction%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShortcodeDirectionCop($id, $shortcode, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE sc.short_code LIKE '%$shortcode%'
AND m.name LIKE '%$direction%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchStatusDirection($id, $status, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE cs.name LIKE '%$status%'
AND m.name LIKE '%$direction%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchStatusDirectionCop($id, $status, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE cs.name LIKE '%$status%'
AND m.name LIKE '%$direction%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeStatus($id, $campania, $shortcode, $status, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%'
AND sc.short_code LIKE '%$shortcode%'
AND cs.name LIKE '%$status%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeStatusCop($id, $campania, $shortcode, $status, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%'
AND sc.short_code LIKE '%$shortcode%'
AND cs.name LIKE '%$status%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeDirection($id, $campania, $shortcode, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%'
AND sc.short_code LIKE '%$shortcode%'
AND m.name LIKE '%$direction%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeDirectionCop($id, $campania, $shortcode, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%'
AND sc.short_code LIKE '%$shortcode%'
AND m.name LIKE '%$direction%'
AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeStatusDirection($id, $campania, $shortcode, $status, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%' AND sc.short_code LIKE '%$shortcode%' AND cs.name LIKE '%$status%' AND m.name LIKE '%$direction%' AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchCampaniaShortCodeStatusDirectionCop($id, $campania, $shortcode, $status, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE c.name LIKE '%$campania%' AND sc.short_code LIKE '%$shortcode%' AND cs.name LIKE '%$status%' AND m.name LIKE '%$direction%' AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function getTotalMessagesSearchShorCodeStatusDirection($id, $shortcode, $status, $direction, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE sc.short_code LIKE '%$shortcode%'
AND cs.name LIKE '%$status%'
AND m.name LIKE '%$direction%' AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
sql;
		return $mysqli->queryAll($query);
	}

public static function getTotalMessagesSearchShortCodeStatusDirectionCop($id, $shortcode, $status, $direction, $fecha_ini, $fecha_fin, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, sc.short_code, m.name AS modulo, count( smsc.sms_campaign_id ) AS total_mensajes
FROM campaign c
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN customer cu ON ( cc.customer_id = cu.customer_id )
INNER JOIN sms_campaign smsc USING ( campaign_id )
INNER JOIN campaign_status cs USING ( campaign_status_id )
INNER JOIN modules m ON m.modules_id = c.modules_id
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
INNER JOIN short_code sc USING ( short_code_id )
WHERE sc.short_code LIKE '%$shortcode%'
AND cs.name LIKE '%$status%'
AND m.name LIKE '%$direction%' AND c.delivery_date BETWEEN '$fecha_ini' AND '$fecha_fin'
GROUP BY c.campaign_id
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
	}

	public static function SearchReportMT($id, $result, $destination){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id = :result AND sc.msisdn_id LIKE "%$destination%"
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query,array(':id'=>$id, ':result'=>$result));
	}

	public static function SearchReportMTCop($id,$result, $destination, $start,$length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id = :result AND (sc.msisdn_id LIKE "%$destination%" OR s.destination LIKE "%$destination%")
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query,array(':id'=>$id, ':result'=>$result));
	}

############################################ INICIO BUSQUEDA MT CAMPANIA & PARAMETROS ######################################################

	public static function getTotalSearchReporteMT($id, $destination){ # Destination total
		$mysqli = Database::getInstance();
		$id = (int)$id;
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function getTotalSearchReporteMTCop($id, $destination, $start, $length){ #destination data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrierTotal($id, $carrier){ # Carrier total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrier($id, $carrier, $start, $length){ # Carrier data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopEstatusTotal($id, $estatus){ # Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTEstatus($id, $estatus, $start, $length){ # Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
		//print_r($id);
	}

	public static function getTotalSearchReporteMTCopSourceTotal($id, $source){ # Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTSource($id, $source, $start, $length){ # Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopSourceEstatusTotal($id, $source, $estatus){ # Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTSourceEstatus($id, $source,$estatus, $start, $length){ # Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrierEstatusTotal($id, $carrier, $estatus){ # Carrier & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCarrierEstatus($id, $carrier,$estatus, $start, $length){ # Carrier & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrierSourceTotal($id, $carrier, $source){ # Carrier & Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCarrierSource($id, $carrier,$source, $start, $length){ # Carrier & Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopCarrierSourceEstatusTotal($id, $carrier, $source, $estatus){ # Carrier & Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCarrierSourceEstatus($id, $carrier,$source, $estatus, $start, $length){ # Carrier & Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationEstatusTotal($id, $destination, $estatus){ # Destination & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationEstatus($id, $destination, $estatus, $start, $length){ # Destination & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationSourceTotal($id, $destination, $source){ # Destination & Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationSource($id, $destination, $source, $start, $length){ # Destination & Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationSourceEstatusTotal($id, $destination, $source, $estatus){ # Destination & Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationSourceEstatus($id, $destination, $source, $estatus, $start, $length){ # Destination & Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationCarrierTotal($id, $destination, $carrier){ # Destination & Carrier total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationCarrier($id, $destination, $carrier, $start, $length){ # Destination & Carrier data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationCarrierEstatusTotal($id, $destination, $carrier, $estatus){ # Destination & Carrier & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationCarrierEstatus($id, $destination, $carrier, $estatus, $start, $length){ # Destination & Carrier & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopDestinationCarrierSourceTotal($id, $destination, $carrier, $source){ # Destination & Carrier & Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTDestinationCarrierSource($id, $destination, $carrier, $source, $start, $length){ # Destination & Carrier & Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopAllTotal($id, $destination, $carrier, $source, $estatus){ # Destination & Carrier & Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTAll($id, $destination, $carrier, $source, $estatus, $start, $length){ # Destination & Carrier & Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

################################################### FIN BUSQUEDA MT CAMPANIA & PARAMETROS ###################################################

	public static function getTotalCountMessages($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT count( sc.sms_campaign_id ) AS total_mensajes
FROM sms_campaign sc
WHERE sc.campaign_id = $id
sql;

		return $mysqli->queryAll($query);
	}

	public static function getDataCampaign($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS name_campaign, c.delivery_date, cs.name, m.name AS modulo
FROM campaign c
INNER JOIN campaign_status cs USING (campaign_status_id)
INNER JOIN modules m ON m.modules_id = c.modules_id
WHERE c.campaign_id = $id
sql;

		return $mysqli->queryAll($query);
	}

	public static function getDataShortCode($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT DISTINCT(c.campaign_id), sc.short_code
FROM campaign c
INNER JOIN campaign_customer cc using(campaign_id)
INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
INNER JOIN carrier_connection_short_code_campaign ccscc using(campaign_id)
INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
INNER JOIN short_code sc on (sc.short_code_id = ccsc.short_code_id)
WHERE c.campaign_id = $id
sql;

		return $mysqli->queryAll($query);
	}

	public static function getData($id){
		$mysqli = Database::getInstance();
		$id = (int)$id;
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query);

	}

	public static function getDataCop($id, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));

	}

	public static function reporteMensajes($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms
WHERE campaign_id = :id AND direction = 'MT' AND status = 'delivered';
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));

	}

	public static function getDataMO($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO'
GROUP BY sms.sms_id;
sql;

		return $mysqli->queryAll($query, array(':id' => $id));
	}

	public static function getDataMOCop($id, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO'
GROUP BY sms.sms_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id' => $id));
	}

	public static function getDataService($id, $customer){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
WHERE sms.service_id=:id
sql;

		return $mysqli->queryAll($query, array(':id' => $id));
	}

	public static function getDataServiceCop($id, $customer, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
WHERE sms.service_id=:id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id' => $id));
	}

	public static function getTotalTelcel($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
WHERE ccsc.carrier_id =1
sql;

		return $mysqli->queryAll($query);
	}

	public static function getTotalMovistar($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
WHERE ccsc.carrier_id =2

sql;

		return $mysqli->queryAll($query);
	}

	public static function getTotalATT($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms
INNER JOIN campaign_customer cc USING ( campaign_id )
INNER JOIN carrier_connection_short_code ccsc USING ( carrier_connection_short_code_id )
WHERE ccsc.carrier_id =3
sql;

		return $mysqli->queryAll($query);
	}

	public static function consultDate($consulta){
		$mysqli = Database::getInstance();
		$query = <<<sql
select c.name, count(*) as total from sms
inner join campaign c using(campaign_id)
where campaign_id = :id AND direction = 'MO' AND entry_time >= :fecha_ini AND entry_time <= :fecha_fin;
sql;

	$params = array(
			':id' => $consulta->_id,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}


	public static function consultDateService($consulta){
		$mysqli = Database::getInstance();
		$query = <<<sql
select c.name, count(*) as total from sms
inner join campaign c using(campaign_id)
where service_id = :id AND entry_time >= :fecha_ini AND entry_time <= :fecha_fin;
sql;

	$params = array(
			':id' => $consulta->_id,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

####################################### BUSQUEDA ID CAMPANIA Y PARAMETROS #############################################

	public static function reportMT($result){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id = :result
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query,array(':result'=>$result));
	}

	public static function reportMTCop($result, $start,$length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $result )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id = :result
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query,array(':result'=>$result));
	}
####################################### FIN BUSQUEDA ID CAMPANIA Y PARAMETROS #############################################

####################################### REPORTE EXCEL CON PARAMETROS ######################################################
	public static function reportMTE($id_customer, $id_campania){

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTEEstatus($id_customer, $id_campania, $estatus){ # Estatus reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND (s.status LIKE '%$estatus%' OR sce.estatus LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTESource($id_customer, $id_campania, $source){ # Source reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTESourceEstatus($id_customer, $id_campania, $source, $estatus){ # Source & Estatus reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND sco.short_code LIKE '%$source%'
AND (s.status LIKE '%$estatus%' OR sce.estatus LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}


	public static function reportMTECarrier($id_customer, $id_campania, $carrier){ # Carrier reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND ca.name LIKE'%$carrier%'
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTECarrierEstatus($id_customer, $id_campania, $carrier, $estatus){ # Carrier & Estatus reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND ca.name LIKE'%$carrier%'
AND (s.status LIKE '%$estatus%' OR sce.estatus LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTECarrierSource($id_customer, $id_campania, $carrier, $source){ # Carrier & Source reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND ca.name LIKE'%$carrier%'
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTECarrierSourceEstatus($id_customer, $id_campania, $carrier, $source, $estatus){ # Carrier & Source & Estatus reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND ca.name LIKE'%$carrier%'
AND sco.short_code LIKE '%$source%'
AND (s.status LIKE '%$estatus%' OR sce.estatus LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTEDestination($id_customer, $id_campania, $destination){ # Destination reporte Excel
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE'%$destination%')
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTEDestinationEstatus($id_customer, $id_campania, $destination, $estatus){ # Destination & Estatus reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE'%$destination%')
AND (s.status LIKE '%$estatus%' OR sce.estatus LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTEDestinationSource($id_customer, $id_campania, $destination, $source){ # Destination & Source reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE'%$destination%')
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTEDestinationSourceEstatus($id_customer, $id_campania, $destination, $source, $estatus){ # Destination & Source & Estatus reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE'%$destination%')
AND sco.short_code LIKE '%$source%'
AND (s.status LIKE '%$estatus%' OR sce.estatus LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTEDestinationCarrier($id_customer, $id_campania, $destination, $carrier){ # Destination & Carrier reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE'%$destination%')
AND ca.name LIKE'%$carrier%'
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTEDestinationCarrierEstatus($id_customer, $id_campania, $destination, $carrier, $estatus){ # Destination & Carrier & Estatus reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE'%$destination%')
AND ca.name LIKE'%$carrier%'
AND (s.status LIKE '%$estatus%' OR sce.estatus LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTEDestinationCarrierSource($id_customer, $id_campania, $destination, $carrier, $source){ # Destination & Carrier & Source reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE'%$destination%')
AND ca.name LIKE'%$carrier%'
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function reportMTEAllSources($id_customer, $id_campania, $destination, $carrier, $source, $estatus){ # Destination & Carrier & Source & Estatus reporte Excel

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = $id_campania )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id=$id_campania
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE'%$destination%')
AND ca.name LIKE'%$carrier%'
AND sco.short_code LIKE '%$source%'
AND (s.status LIKE '%$estatus%' OR sce.estatus LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

############################################################################################

	public static function reportMTDetalleCount($consulta){
		$mysqli = Database::getInstance();
		$query = <<<sql
			SELECT ca.name AS "CARRIER",
			IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
			IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
			IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
			IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
			IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
			FROM sms_campaign sc
			LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
			LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = :id_campaign )
			LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
			LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
			LEFT JOIN short_code sco USING ( short_code_id )
			LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
			LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
			WHERE sc.campaign_id= :id_campaign and DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
			GROUP BY sc.sms_campaign_id
sql;
		$params = array(
			':id_campaign' => $consulta->_id_campaign,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);
		return $mysqli->queryAll($query,$params);
	}


	public static function reportMTDetalle($consulta, $start, $length){

		$mysqli = Database::getInstance();
		$query = <<<sql
			SELECT ca.name AS "CARRIER",
			IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
			IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
			IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
			IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
			IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
			FROM sms_campaign sc
			LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
			LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id = :id_campaign )
			LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
			LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
			LEFT JOIN short_code sco USING ( short_code_id )
			LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
			LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
			WHERE sc.campaign_id= :id_campaign and DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
			GROUP BY sc.sms_campaign_id
			LIMIT $start, $length
sql;

$params = array(
			':id_campaign' => $consulta->_id_campaign,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

######################################## CONSULTAR SOLO POR FECHAS ########################################
	public static function reportMTDetalleFechaCount($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $datos->_id_customer,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}


	public static function reportMTDetalleFecha($datos, $start, $length){
					// print_r($datos);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $datos->_id_customer,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}
######################################## FIN CONSULTAR SOLO POR FECHAS ########################################


####################################### BUSQUEDA POR FECHAS Y PARAMETROS MT ###################################

	public static function reportMTDetalleFechaCountEstatus($consulta, $estatus){ # Estastus total
					// print_r($datos);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaEstatus($consulta, $estatus, $start, $length){ # Estatus data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountSource($consulta, $source){ # Source total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaSource($consulta, $source, $start, $length){ # Source data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountSourceEstatus($consulta, $source, $estatus){ # Source & Estatus total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND sco.short_code LIKE '%$source%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaSourceEstatus($consulta, $source, $estatus, $start, $length){ # Source & Estatus data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND sco.short_code LIKE '%$source%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountCarrier($consulta, $carrier){ # Carrier total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND ca.name LIKE '%$carrier%'
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCarrier($consulta, $carrier, $start, $length){ # Carrier data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND ca.name LIKE '%$carrier%'
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountCarrierEstatus($consulta, $carrier, $estatus){ # Carrier & Estatus total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND ca.name LIKE '%$carrier%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCarrierEstatus($consulta, $carrier, $estatus, $start, $length){ # Carrier & Estatus data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND ca.name LIKE '%$carrier%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountCarrierSource($consulta, $carrier, $source){ # Carrier & Source total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND ca.name LIKE '%$carrier%'
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCarrierSource($consulta, $carrier, $source, $start, $length){ # Carrier & Source data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND ca.name LIKE '%$carrier%'
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountCarrierSourceEstatus($consulta, $carrier, $source, $estatus){ # Carrier & Source & Estatus total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND ca.name LIKE '%$carrier%'
AND sco.short_code LIKE '%$source%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCarrierSourceEstatus($consulta, $carrier, $source, $estatus, $start, $length){ # Carrier & Source & Estatus data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND ca.name LIKE '%$carrier%'
AND sco.short_code LIKE '%$source%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountDestination($consulta, $destination){ # Destination total
					//print_r($consulta);

		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);
//print_r($mysqli->queryAll($query,$params));

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaDestination($consulta, $destination, $start, $length){ # Destination data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountDestinationEstatus($consulta, $destination, $estatus){ # Destination & Estatus total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaDestinationEstatus($consulta, $destination, $estatus, $start, $length){ # Destination & Estatus data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountDestinationSource($consulta, $destination, $source){ # Destination & Source total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaDestinationSource($consulta, $destination, $source, $start, $length){ # Destination & Source data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountDestinationSourceEstatus($consulta, $destination, $source, $estatus){ # Destination & Source & Estatus total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND sco.short_code LIKE '%$source%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaDestinationSourceEstatus($consulta, $destination, $source, $estatus, $start, $length){ # Destination & Source & Estatus data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND sco.short_code LIKE '%$source%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountDestinationCarrier($consulta, $destination, $carrier){ # Destination & Carrier total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND ca.name LIKE '%$carrier%'
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaDestinationCarrier($consulta, $destination, $carrier, $start, $length){ # Destination & Carrier data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND ca.name LIKE '%$carrier%'
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountDestinationCarrierEstatus($consulta, $destination, $carrier, $estatus){ # Destination & Carrier & Estatus total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND ca.name LIKE '%$carrier%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaDestinationCarrierEstatus($consulta, $destination, $carrier, $estatus, $start, $length){ # Destination & Carrier & Estatus data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND ca.name LIKE '%$carrier%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountDestinationCarrierSource($consulta, $destination, $carrier, $source){ # Destination & Carrier & Source total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND ca.name LIKE '%$carrier%'
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaDestinationCarrierSource($consulta, $destination, $carrier, $source, $start, $length){ # Destination & Carrier & Source data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND ca.name LIKE '%$carrier%'
AND sco.short_code LIKE '%$source%'
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaCountAllSources($consulta, $destination, $carrier, $source, $estatus){ # Destination & Carrier & Source & Estatus total
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND ca.name LIKE '%$carrier%'
AND sco.short_code LIKE '%$source%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

	public static function reportMTDetalleFechaAllSources($consulta, $destination, $carrier, $source, $estatus, $start, $length){ # Destination & Carrier & Source & Estatus data
					// print_r($consulta);
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE DAY(sc.delivery_date) between DAY(:fecha_ini) and DAY(:fecha_fin)
AND (ms.msisdn LIKE '%$destination%' OR s.destination LIKE '%$destination%')
AND ca.name LIKE '%$carrier%'
AND sco.short_code LIKE '%$source%'
AND (sce.estatus LIKE '%$estatus%' OR s.status LIKE '%$estatus%')
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $consulta->_id_customer,
			':fecha_ini' => $consulta->_fecha_ini,
			':fecha_fin' => $consulta->_fecha_fin
		);

		return $mysqli->queryAll($query,$params);
	}

####################################### FIN BUSQUEDA POR FECHAS Y PARAMETROS MT ###############################

	public static function reportMO($result){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, 
IF(sk.keyword IS NULL, "Sin keyword", sk.keyword) AS keyword
FROM sms
LEFT JOIN campaign cam USING (campaign_id)
LEFT JOIN campaign_customer cc USING (campaign_id)
LEFT JOIN customer c on (cc.customer_id = c.customer_id)
LEFT JOIN service using (service_id)
LEFT JOIN service_keyword sk using (service_id)
WHERE sms.direction='MO' AND sms.campaign_id=$result
GROUP BY sms.sms_id
sql;
		return $mysqli->queryAll($query);
		}

/*SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' AND c.customer_id= $id_custom AND sc.campaign_id = $result
GROUP BY sms.sms_id;*/

	public static function reportMOCop($result, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, 
IF(sk.keyword IS NULL, "Sin keyword", sk.keyword) AS keyword
FROM sms
LEFT JOIN campaign cam USING (campaign_id)
LEFT JOIN campaign_customer cc USING (campaign_id)
LEFT JOIN customer c on (cc.customer_id = c.customer_id)
LEFT JOIN service using (service_id)
LEFT JOIN service_keyword sk using (service_id)
WHERE sms.direction='MO' AND sms.campaign_id=$result
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
		}

/*SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' AND c.customer_id= $id_custom AND sc.campaign_id = $result
GROUP BY sms.sms_id
LIMIT $start, $length*/

	public static function reportMOTotal(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, 
IF(sk.keyword IS NULL, "Sin keyword", sk.keyword) AS keyword
FROM sms
LEFT JOIN campaign cam USING (campaign_id)
LEFT JOIN campaign_customer cc USING (campaign_id)
LEFT JOIN customer c on (cc.customer_id = c.customer_id)
LEFT JOIN service using (service_id)
LEFT JOIN service_keyword sk using (service_id)
WHERE sms.direction='MO'
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
sql;
		return $mysqli->queryAll($query);
		}

	public static function reportMOCopTotal($start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, 
IF(sk.keyword IS NULL, "Sin keyword", sk.keyword) AS keyword
FROM sms
LEFT JOIN campaign cam USING (campaign_id)
LEFT JOIN campaign_customer cc USING (campaign_id)
LEFT JOIN customer c on (cc.customer_id = c.customer_id)
LEFT JOIN service using (service_id)
LEFT JOIN service_keyword sk using (service_id)
WHERE sms.direction='MO'
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
		}


	public static function reportMOExcel($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' AND sms.campaign_id=:id_campaign
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
sql;

$params = array(
			':id_customer' => $datos->_id_customer,
			':id_campaign' => $datos->_id_campaign
		);
		return $mysqli->queryAll($query, $params);
	}


	public static function reportMOExcelDetalleCount($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' AND sms.campaign_id=:id_campaign
AND sms.entry_time between :fecha_ini AND :fecha_fin
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
sql;

$params = array(
			':id_customer' => $datos->_id_customer,
			':id_campaign' => $datos->_id_campaign,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);
		return $mysqli->queryAll($query, $params);
	}

	public static function reportMOExcelDetalle($datos, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' AND sms.campaign_id=:id_campaign
AND sms.entry_time between :fecha_ini AND :fecha_fin
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $datos->_id_customer,
			':id_campaign' => $datos->_id_campaign,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);
		return $mysqli->queryAll($query, $params);
	}

	public static function reportMOExcelDetalleFechaCount($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO'
AND sms.entry_time between :fecha_ini AND :fecha_fin
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
sql;

$params = array(
			':id_customer' => $datos->_id_customer,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);
		return $mysqli->queryAll($query, $params);
	}

	public static function reportMOExcelDetalleFecha($datos, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT sms.entry_time, sms.source, sms.destination, sms.content, sms.status, sk.keyword
FROM service s
INNER JOIN service_keyword sk using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
INNER JOIN campaign_customer cc on (cc.customer_id = c.customer_id)
INNER JOIN campaign cam on (cam.campaign_id = cc.campaign_id)
INNER JOIN sms_campaign sc on (sc.campaign_id = cam.campaign_id)
INNER JOIN sms on (sms.campaign_id = sc.campaign_id)
WHERE sms.direction='MO' 
AND sms.entry_time between :fecha_ini AND :fecha_fin
GROUP BY sms.sms_id
ORDER BY sms.entry_time DESC
LIMIT $start, $length
sql;

$params = array(
			':id_customer' => $datos->_id_customer,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);
		return $mysqli->queryAll($query, $params);
	}


	public static function getAllCampaignMO(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.campaign_id, c.name, sc.short_code
FROM campaign c
INNER JOIN campaign_customer cc USING(campaign_id)
INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
INNER JOIN carrier_connection_short_code_campaign ccscc USING(campaign_id)
INNER JOIN sms s USING (carrier_connection_short_code_id)
INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
INNER JOIN short_code sc on (sc.short_code_id = ccsc.short_code_id)
WHERE s.direction = 'MO'
GROUP BY c.campaign_id;
sql;
/*		$query = <<<sql
SELECT s.service_id, s.title
FROM service s
INNER JOIN campaign c USING (campaign_id)
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN customer cu ON (cc.customer_id = cu.customer_id)
WHERE cu.customer_id = :id AND s.status = 1;
sql;
*/
		return $mysqli->queryAll($query);
		}

	public static function getAllServiceMO($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT s.service_id, s.title
FROM service s
INNER JOIN campaign c USING (campaign_id)
INNER JOIN campaign_customer cc USING (campaign_id)
INNER JOIN customer cu ON (cc.customer_id = cu.customer_id)
WHERE AND s.status = 1;
sql;
		return $mysqli->queryAll($query,array(':id' => $id));
	}


	public static function reportService($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
sql;
		return $mysqli->queryAll($query);
	}

	public static function reportServiceCop($id, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
LIMIT $start, $length
sql;
		return $mysqli->queryAll($query);
		}


		public static function reportServiceExcel($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
WHERE service.service_id=$datos->_id_service
sql;
		return $mysqli->queryAll($query);
		}


		public static function reportServiceExcelDetalleCount($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
WHERE service_id=:id_service AND entry_time between :fecha_ini AND :fecha_fin
sql;
		$params = array(
			':id_customer' => $datos->_id_customer,
			':id_service' => $datos->_id_service,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
		}

		public static function reportServiceExcelDetalle($datos, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
WHERE service_id=:id_service AND entry_time between :fecha_ini AND :fecha_fin
LIMIT $start, $length
sql;
		$params = array(
			':id_customer' => $datos->_id_customer,
			':id_service' => $datos->_id_service,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
		}


	public static function reportServiceExcelDetalleFechasCount($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
WHERE entry_time between :fecha_ini AND :fecha_fin
sql;
		$params = array(
			':id_customer' => $datos->_id_customer,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
	}

	public static function reportServiceExcelDetalleFechas($datos, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT entry_time, source, destination, direction, content, sms.status, keyword
FROM service
INNER JOIN sms using (service_id)
INNER JOIN service_keyword using (service_id)
INNER JOIN customer_service cs using (service_id)
INNER JOIN customer c on (cs.customer_id = c.customer_id)
WHERE entry_time between :fecha_ini AND :fecha_fin
LIMIT $start, $length
sql;
		$params = array(
			':id_customer' => $datos->_id_customer,
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
		}

		public static function getAllCampaignRMT($id){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.campaign_id, c.name, sc.short_code
FROM campaign c
INNER JOIN campaign_customer cc using(campaign_id)
INNER JOIN customer cu on (cc.customer_id = cu.customer_id)
INNER JOIN carrier_connection_short_code_campaign ccscc using(campaign_id)
INNER JOIN carrier_connection_short_code ccsc on (ccscc.carrier_connection_short_code_id = ccsc.carrier_connection_short_code_id)
INNER JOIN short_code sc on (sc.short_code_id = ccsc.short_code_id)
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getAllCampaniaByCustomer(){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS campania, created, delivery_date, cs.name AS estatus, cus.name AS customer
FROM campaign c
INNER JOIN campaign_status cs
USING ( campaign_status_id )
INNER JOIN campaign_customer ccus
USING ( campaign_id )
INNER JOIN customer cus
USING ( customer_id );
sql;

		return $mysqli->queryAll($query);
	}

	public static function getAllCampaniaByCustomerCop($start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT 
c.name AS campania, 
created, 
delivery_date, 
cs.name AS estatus, 
cus.name AS customer
FROM campaign c
INNER JOIN campaign_status cs
USING ( campaign_status_id )
INNER JOIN campaign_customer ccus
USING ( campaign_id )
INNER JOIN customer cus
USING ( customer_id )
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query);
	}

	public static function getAllCampaniaByCustomerFechas($datos){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS campania, created, delivery_date, cs.name AS estatus, cus.name AS customer
FROM campaign c
INNER JOIN campaign_status cs
USING ( campaign_status_id )
INNER JOIN campaign_customer ccus
USING ( campaign_id )
INNER JOIN customer cus
USING ( customer_id )
AND delivery_date between :fecha_ini AND :fecha_fin
sql;
		$params = array(
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
		}

	public static function getAllCampaniaByCustomerFechasCop($datos, $start, $length){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT c.name AS campania, created, delivery_date, cs.name AS estatus, cus.name AS customer
FROM campaign c
INNER JOIN campaign_status cs
USING ( campaign_status_id )
INNER JOIN campaign_customer ccus
USING ( campaign_id )
INNER JOIN customer cus
USING ( customer_id )
AND delivery_date between :fecha_ini AND :fecha_fin
LIMIT $start, $length
sql;
		$params = array(
			':fecha_ini' => $datos->_fecha_ini,
			':fecha_fin' => $datos->_fecha_fin
		);

		return $mysqli->queryAll($query, $params);
	}

	public static function update($param){}
    public static function delete($param){}

######################################## INICIO BUSQUEDA MT CAMPANIA & PARAMETROS &FECHAS ##############################################

	public static function reportMTCFechas($id, $result, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id = :result
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sms_campaign_id
sql;

		return $mysqli->queryAll($query,array(':id'=>$id, ':result'=>$result));
	}

	public static function reportMTCopCFechas($id,$result, $start,$length, $fecha_ini, $fecha_fin){
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$result )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
LEFT JOIN campaign_customer cc ON cc.campaign_id = sc.campaign_id
WHERE sc.campaign_id = :result
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query,array(':id'=>$id, ':result'=>$result));
	}

	public static function getTotalSearchReporteMTCFechas($id, $destination, $fecha_ini, $fecha_fin){ # Destination total
		$mysqli = Database::getInstance();
		$id = (int)$id;
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query);
	}

	public static function getTotalSearchReporteMTCopCFechas($id, $destination, $start, $length, $fecha_ini, $fecha_fin){ #destination data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%")
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrierTotalCFechas($id, $carrier, $fecha_ini, $fecha_fin){ # Carrier total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%"
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrierCFechas($id, $carrier, $start, $length, $fecha_ini, $fecha_fin){ # Carrier data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopEstatusTotalCFechas($id, $estatus, $fecha_ini, $fecha_fin){ # Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTEstatusCFechas($id, $estatus, $start, $length, $fecha_ini, $fecha_fin){ # Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
		//print_r($id);
	}

	public static function getTotalSearchReporteMTCopSourceTotalCFechas($id, $source, $fecha_ini, $fecha_fin){ # Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND sco.short_code LIKE "%$source%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTSourceCFechas($id, $source, $start, $length, $fecha_ini, $fecha_fin){ # Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND sco.short_code LIKE "%$source%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopSourceEstatusTotalCFechas($id, $source, $estatus, $fecha_ini, $fecha_fin){ # Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTSourceEstatusCFechas($id, $source,$estatus, $start, $length, $fecha_ini, $fecha_fin){ # Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrierEstatusTotalCFechas($id, $carrier, $estatus, $fecha_ini, $fecha_fin){ # Carrier & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCarrierEstatusCFechas($id, $carrier,$estatus, $start, $length, $fecha_ini, $fecha_fin){ # Carrier & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopCarrierSourceTotalCFechas($id, $carrier, $source, $fecha_ini, $fecha_fin){ # Carrier & Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCarrierSourceCFechas($id, $carrier,$source, $start, $length, $fecha_ini, $fecha_fin){ # Carrier & Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopCarrierSourceEstatusTotalCFechas($id, $carrier, $source, $estatus, $fecha_ini, $fecha_fin){ # Carrier & Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCarrierSourceEstatusCFechas($id, $carrier,$source, $estatus, $start, $length, $fecha_ini, $fecha_fin){ # Carrier & Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationEstatusTotalCFechas($id, $destination, $estatus, $fecha_ini, $fecha_fin){ # Destination & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationEstatusCFechas($id, $destination, $estatus, $start, $length, $fecha_ini, $fecha_fin){ # Destination & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationSourceTotalCFechas($id, $destination, $source, $fecha_ini, $fecha_fin){ # Destination & Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND sco.short_code LIKE "%$source%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationSourceCFechas($id, $destination, $source, $start, $length, $fecha_ini, $fecha_fin){ # Destination & Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND sco.short_code LIKE "%$source%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationSourceEstatusTotalCFechas($id, $destination, $source, $estatus, $fecha_ini, $fecha_fin){ # Destination & Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationSourceEstatusCFechas($id, $destination, $source, $estatus, $start, $length, $fecha_ini, $fecha_fin){ # Destination & Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationCarrierTotalCFechas($id, $destination, $carrier, $fecha_ini, $fecha_fin){ # Destination & Carrier total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationCarrierCFechas($id, $destination, $carrier, $start, $length, $fecha_ini, $fecha_fin){ # Destination & Carrier data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTCopDestinationCarrierEstatusTotalCFechas($id, $destination, $carrier, $estatus, $fecha_ini, $fecha_fin){ # Destination & Carrier & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}


	public static function getTotalSearchReporteMTDestinationCarrierEstatusCFechas($id, $destination, $carrier, $estatus, $start, $length, $fecha_ini, $fecha_fin){ # Destination & Carrier & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopDestinationCarrierSourceTotalCFechas($id, $destination, $carrier, $source, $fecha_ini, $fecha_fin){ # Destination & Carrier & Source total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTDestinationCarrierSourceCFechas($id, $destination, $carrier, $source, $start, $length, $fecha_ini, $fecha_fin){ # Destination & Carrier & Source data
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT ca.name AS "CARRIER",
IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%"
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTCopAllTotalCFechas($id, $destination, $carrier, $source, $estatus, $fecha_ini, $fecha_fin){ # Destination & Carrier & Source & Estatus total
		$mysqli = Database::getInstance();
		$query = <<<sql
SELECT *
FROM sms_campaign sc
LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
LEFT JOIN sms s ON ( ms.msisdn = s.destination )
LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
LEFT JOIN short_code sco USING ( short_code_id )
LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
WHERE sc.campaign_id = $id AND ms.msisdn LIKE "%$destination%" AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (s.status LIKE "%$estatus%" OR sce.estatus LIKE '%$estatus%')
AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
GROUP BY sc.sms_campaign_id
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

	public static function getTotalSearchReporteMTAllCFechas($id, $destination, $carrier, $source, $estatus, $start, $length, $fecha_ini, $fecha_fin){ # Destination & Carrier & Source & Estatus data
		$mysqli = Database::getInstance();
		$query = <<<sql
			SELECT ca.name AS "CARRIER",
			IF(s.status IS NULL , sce.estatus, s.status) AS "ESTATUSSMS",
			IF(s.entry_time = sc.delivery_date, s.entry_time, sc.delivery_date) AS "FECHA",
			IF(s.content=sc.content, s.content, sc.content) AS "CONTENT",
			IF(ms.msisdn_id = sc.msisdn_id, ms.msisdn,s.destination) AS "DESTINATION",
			IF(ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id, sco.short_code, "Sin carrier") AS "SHORTCODE"
			FROM sms_campaign sc
			LEFT JOIN msisdn ms ON ms.msisdn_id = sc.msisdn_id
			LEFT JOIN sms s ON ( ms.msisdn = s.destination AND s.campaign_id =$id )
			LEFT JOIN carrier_connection_short_code ccsc ON ccsc.carrier_connection_short_code_id = sc.carrier_connection_short_code_id
			LEFT JOIN carrier ca ON ca.carrier_id = ccsc.carrier_id
			LEFT JOIN short_code sco USING ( short_code_id )
			LEFT JOIN sms_campaign_estatus sce USING ( sms_campaign_estatus_id )
			WHERE sc.campaign_id = :id AND (ms.msisdn LIKE "%$destination%" OR s.destination LIKE "%$destination%") AND ca.name LIKE "%$carrier%" AND sco.short_code LIKE "%$source%" AND (sce.estatus LIKE "%$estatus%" OR  s.status LIKE "%$estatus%")
			AND DAY(sc.delivery_date) BETWEEN DAY('$fecha_ini') and DAY('$fecha_fin')
			GROUP BY sc.sms_campaign_id
			LIMIT $start, $length
sql;

		return $mysqli->queryAll($query, array(':id'=>$id));
	}

############################################### FIN BUSQUEDA MT CAMPANIA & PARAMETROS & FECHAS ###############################################


    public static function registroUsuario($registro){
        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO user_registro(ctime, user_id, nickname, name_customer, script, ip, modulo,accion) VALUES (now(), :id_user, :nickname, :name_customer, :script, :ip, :modulo, :accion);
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

    public static function getSmsPush($start,$length, $where){
		$mysqli = Database::getInstance();
		$query = <<<sql
			SELECT * FROM push_campania $where LIMIT $start, $length 
sql;
		return $mysqli->queryAll($query);
	}

	public static function getCampaignStatus(){
		$mysqli = Database::getInstance();
		$query =<<<sql
		SELECT * FROM campaign_status
sql;
		return $mysqli->queryAll($query);
	}
}
























