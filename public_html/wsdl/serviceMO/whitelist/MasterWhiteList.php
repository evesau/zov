<?php

class MasterWhiteList{

const URI_WS = "https://smsmkt.telcel.com/servicesSMSBulk/subscriber.jws";
static $_USER = "GK_TRX_55000083";
static $_PWD = "5GLulXb5";

public static function generalSend($params){

        $data = '';
        $data = self::prepareParams($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URI_WS);
        curl_setopt($ch, CURLOPT_USERPWD, self::$_USER.':'.self::$_PWD);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));
        $result = curl_exec($ch);

        if ( curl_errno($ch) ) {
            $result = 'ERROR -> ' . curl_errno($ch) . ': ' . curl_error($ch);
        } else {
            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch($returnCode){
                case 200:
                    break;
                default:
                    $result = 'HTTP ERROR -> ' . $returnCode;
                    break;
            }
        }

        curl_close($ch);
        return $result;
    }

    public static function prepareParams($params){

        $fields = '';
        foreach($params as $key => $value)
            $fields .= $key . '=' . $value . '&';

        return rtrim($fields, '&');
    }
}

?>
