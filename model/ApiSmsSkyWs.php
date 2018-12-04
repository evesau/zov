<?php
class ApiSmsSkyWs{

    public static function getAll(){}

    public static function getById($data){
	$mysqli = Database::getInstance();	
	$query=<<<sql
sql;

	return $mysqli->queryOne($query);
    }

    public static function insert($data){
	$mysqli = Database::getInstance();
	$query=<<<sql
sql;

	return $mysqli->insert($query);

    }

    public static function update($data){

	$mysqli = Database::getInstance();
        $query=<<<sql
sql;

        return $mysqli->update($query);
    }

    public static function delete($id){}

    public static function getAllCampaign($id)
    {
	$mysqli = Database::getInstance();
	$query=<<<sql
SELECT * , c.name AS nombre, cs.name AS
status , m.name AS modulo
FROM `campaign` AS c
INNER JOIN campaign_status AS cs
USING ( campaign_status_id )
INNER JOIN modules AS m
USING ( modules_id )
INNER JOIN campaign_customer AS cc
USING ( campaign_id )
WHERE customer_id =$id
sql;

	return $mysqli->queryAll($query);
    }

}
