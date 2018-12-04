<?php
include 'DatabaseDao.php';
class codigosUnicosDao{

    public static function getAll(){}

    public static function getById($data){
	$mysqli = DatabaseDao::getInstance();	
	$query=<<<sql
sql;

	return $mysqli->queryOne($query);
    }

    public static function insert($data){
	   $mysqli = DatabaseDao::getInstance();
	   $query=<<<sql
INSERT INTO `unique`(`ctime`, `mtime`, `value`, `status`) VALUES (NOW(),NOW(),'$data->_value',$data->_status)
sql;

	   return $mysqli->insert($query);

    }

    public static function update($data){

        $mysqli = DatabaseDao::getInstance();
        $query=<<<sql
sql;

        return $mysqli->update($query);
    }

    public static function delete($id){}

    

}
