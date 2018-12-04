<?php
class ApiEndpoint{

    public static function getAll(){}

    //busca si se pide mas propiedades
    public static function getByIdMasPropiedades($data){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT *
FROM  `sync_message`
WHERE  `tipo` LIKE  'SUGGESTION_RESPONSE'
AND  `postbackData` LIKE 'localidad-mas'
AND msisdn = :msisdn
AND publish_time_c >= :fecha
ORDER BY  `publish_time_c` DESC
sql;

        return $mysqli->queryAll($query, array(':msisdn'=>$data->_msisdn, ':fecha'=>$data->_fecha));
    }

    //endpoint-localidad
    public static function getByIdLocalidad($data){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * 
FROM  `sync_message` 
WHERE  `tipo` LIKE  'SUGGESTION_RESPONSE'
AND  `postbackData` LIKE 'postback%localidad'
AND msisdn = :msisdn
ORDER BY  `publish_time_c` DESC 
sql;

        return $mysqli->queryOne($query, array(':msisdn'=>$data));
    }

    //keyword
    public static function getByIdMenu($data){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM `menu`
WHERE menu_id = :menu
AND estatus = 1;
sql;

        return $mysqli->queryOne($query, array(':menu'=>$data));
    }

    //GET RESPONSE
    public static function getByOperacion($msisdn, $tipo, $orden){
        $mysqli = Database::getInstance();
        $query=<<<sql

SELECT * 
FROM  `sync_action` 
WHERE  msisdn = :msisdn
AND `menu_id` 
IN (

	SELECT menu_id
	FROM  `menu` 
	WHERE  `tipo` = :tipo
	AND  `orden` = :orden
)
ORDER BY ctime DESC
LIMIT 1;
sql;

        return $mysqli->queryOne($query, array(':msisdn'=>$msisdn, ':tipo'=>$tipo, ':orden'=>$orden));
    }

    //GET RESPONSE
    public static function getByIdResponse($tipo, $orden){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * 
FROM  `menu` 
WHERE  `tipo` = :tipo
AND  `orden` = :orden
sql;

        return $mysqli->queryAll($query, array(':tipo'=>$tipo,':orden'=>$orden));
    }

    //keyword
    public static function getById($data){
	$mysqli = Database::getInstance();	
	$query=<<<sql
SELECT * FROM `menu`
WHERE keyword LIKE :data
AND estatus = 1;
sql;

	return $mysqli->queryOne($query, array(':data'=>$data));
    }

    //postbackData
    public static function getByIdData($data){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT *  FROM `menu` WHERE `postbackData` LIKE :data
AND estatus = 1 ;
sql;

        return $mysqli->queryOne($query, array(':data'=>$data));
    }

    //getMsisdn
    public static function getByIdMsisdn($msisdn, $agent){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM `msisdn`
WHERE msisdn = :msisdn AND agent_id = :agent ;
sql;

        return $mysqli->queryOne($query, array(':msisdn'=>$msisdn,':agent'=>$agent));
    }

    public static function insert($data){

	$mysqli = Database::getInstance();
	$query=<<<sql
INSERT INTO `sync_message` (tipo, publish_time, publish_time_c, messageId, json, text, postbackData, msisdn) 
VALUES (:tipo, :publish_time, :publish_time_c, :messageId, :json, :text, :postbackData, :msisdn);
sql;

	$params = array(':tipo'=>$data->_tipo,
			':publish_time'=>$data->_publish_time,
			':publish_time_c'=>$data->_publish_time_c,
			':messageId'=>$data->_messageId,
			':json'=>$data->_json,
			':text'=>$data->_text,
			':postbackData'=>$data->_postbackData,
			':msisdn'=>$data->_msisdn);

	return $mysqli->insert($query, $params);
    }

    public static function insertMsisdn($data){

	$mysqli = Database::getInstance();
	$query=<<<sql
INSERT INTO `msisdn` (ctime, msisdn, agent_id, tester, estatus)
VALUES (NOW(), :msisdn, :agent_id, :tester, :estatus) ;
sql;
	$params = array(':msisdn'=>$data->_msisdn,
			':agent_id'=>$data->_agent_id,
			':tester'=>$data->_tester,
			':estatus'=>$data->_estatus);
	
	return $mysqli->insert($query, $params);
    }

    public static function insertAction($data){

        $mysqli = Database::getInstance();
        $query=<<<sql
INSERT INTO `sync_action` (msisdn_id, msisdn, menu_id, url)
VALUES (:msisdn_id, :msisdn, :menu_id, :url) ;
sql;
        $params = array(':msisdn_id'=>$data->_msisdn_id,
                        ':msisdn'=>$data->_msisdn,
                        ':menu_id'=>$data->_menu_id,
                        ':url'=>$data->_url);

        return $mysqli->insert($query, $params);
    }

    public static function update($data){

	$mysqli = Database::getInstance();
        $query=<<<sql
UPDATE `url_general` SET ctime = ctime , envio = :estatus WHERE url_general_id = :id ;
sql;

        $params = array(':id'=>$data->_id,
                        ':estatus'=>$data->_estatus);

        return $mysqli->update($query, $params);
    }

    public static function delete($id){}

    public static function buscaUrlredirect($id){
    	$mysqli = Database::getInstance();
    	$query =<<<sql
SELECT url_redirect FROM url_general WHERE url_general_id =$id
sql;

	return $mysqli->queryOne($query);

    }

    public static function preparaEnvio($inicio, $fin){
        $mysqli = Database::getInstance();
        $query =<<<sql
SELECT * 
FROM  `url_general` 
WHERE (url_general_id >= $inicio AND url_general_id <= $fin)
AND envio = -1 ;
sql;

echo "+++$query++<br />";
        return $mysqli->queryAll($query);
    }
}
