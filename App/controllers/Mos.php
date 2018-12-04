<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

//include '/usr/local/bin/vendor/autoload.php';

use \Core\View;
use \Core\MasterDom;
use \App\models\Mos as mosDao;


class Mos{

    public function index(){
	header("HTTP/1.0 404 Not Found");
	//mail("esau.espinoza@airmovil.com","mos la voz mx", print_r($_GET,1));
	$msisdn = MasterDom::getData('from');
	$content = MasterDom::getData('text');
	$source = MasterDom::getData('to');
	$carrier = MasterDom::getData('carrier');

	$insertData = new \stdClass();
	$insertData->_msisdn = $msisdn;
	$insertData->_content = $content;
	$insertData->_source = $source;
	$insertData->_carrier = $carrier;

	$insertMo = mosDao::insert($insertData);

	if($insertMo > 0){
	} else {
		mail("esau.espinoza@airmovil.com","mos la voz mx", "ERROR al insertar" . print_r($_GET,1));
	}
	
	exit();
	
    }

}
