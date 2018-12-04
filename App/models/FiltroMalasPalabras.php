<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class FiltroMalasPalabras implements Crud{

    public static function getAllBadWords(){
    	
    	$mysqli = Database::getInstance();
		$query = <<<sql
SELECT word FROM bad_words
ORDER  BY bad_words_id ASC
sql;
		return $mysqli->queryAll($query);
    }
    
    
	public static function getAll(){}
	public static function getById($user){}
    public static function insert($param){}
	public static function update($param){}
    public static function delete($param){}
}