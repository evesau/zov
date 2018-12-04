<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\models\Login as LoginDao;
use \App\controllers\Contenedor;

class Login{

    private $_contenedor;

    function __construct(){
        $this->_contenedor = new Contenedor;
        //View::set('header',$this->_contenedor->header());
        //View::set('footer',$this->_contenedor->footer());
    }

    public function index(){
        if(($login = isset($_GET['login'])) != ''){
            if ($login=='usrerror') {
                $extraHeader = <<<html
<script>alert('Los datos son incorrectos...');</script>
html;
            }
        }

        View::set('showmessage',$message);
        View::set('header',$this->_contenedor->headerLogin($extraHeader));
        View::set('footer',$this->_contenedor->footerLogin());
        View::render("login");
    }

    public function validaUser(){

        $user = new \stdClass();
        $user->_name = MasterDom::getData('username');
        $user->_pass = MasterDom::getData('password');
        $validauser = LoginDao::getById($user);

        if(empty($validauser))
            header('location:/login?login=usrerror');
        else {

            session_start();
            $_SESSION['usuario'] = $validauser['nickname'];
            $_SESSION['name'] = $validauser['first_name'];
            $_SESSION['last_name'] = $validauser['last_name'];
            $_SESSION['img'] = $validauser['img'];
            $_SESSION['user_id'] = $validauser['user_id'];
            $_SESSION['customer_id'] = $validauser['customer_id'];
            
            $registro = $this->registroUsuario("Inicio sesion");
            //LoginDao::registroUsuario($registro);

            if ($validauser['customer_id']==1) {
              header('location:/principal');
            } else {
              header('location:/menu');
            }

            
        }

    }

    public function logout(){
        session_start();
        session_unset();
        session_destroy();
        header("Location:/login");
    }


    function registroUsuario($accion){
      $id_usuario = $_SESSION['id_user'];
      $nickname = $_SESSION['usuario'];
      $customer = $_SESSION['name_customer'];
      $script = explode("/", $_SERVER["REQUEST_URI"]);
      $ip = $_SERVER['REMOTE_ADDR'];
      $modulo = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

      $registro = new \stdClass;
      $registro->_id_usuario = $id_usuario;
      $registro->_nickname = $nickname;
      $registro->_customer = $customer;
      $registro->_script = $script[1];
      $registro->_ip = $ip;
      $registro->_modulo = $modulo;
      $registro->_accion = $accion;
      return $registro;
    }

}
