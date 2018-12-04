<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Santander implements Crud{
    
    public static function getAll(){}
	public static function getById($user){}
    public static function insert($param){}
	public static function update($param){}
    public static function delete($param){}
}