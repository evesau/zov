
<?php
require_once '/home/smsmkt/public/wsdl/skysms/whitelist/model/MasterWhiteListDao.php';
require '/home/smsmkt/public/wsdl/skysms/whitelist/MasterWhiteList.php';

Class WhiteListApi extends MasterWhiteListDao{

private $_limit = "900"; //VARIBLE DE LIMIT DE BUSQUEDA
const SLEEP = 0; //VARIABLE PARA TPS


    function __construct(){
        parent::__construct();
        $this->inicio();
    }

    public function inicio(){

    	$msisdn = $_GET['msisdn'];
        $result = MasterWhiteList::generalSend(array('method'=>'activateMobile','subscriber'=>$msisdn));
        echo "msisdn : {$msisdn} - RESULT : $result\n";
        usleep(self::SLEEP);
        //echo "inicia";
        exit();
    }

}

$app = new WhiteListApi();

?>
