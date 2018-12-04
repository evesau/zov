<?php
require_once "IDao.php";
/* Clase encargada de gestionar las conexiones a la base de datos */
Class Conexion implements IDao{

   private $_host;
   private $_user;
   private $_pwd;
   private $_bd;
   private $_mail = 'tecnico@airmovil.com';
   private $_debug = false;

   static $_instance;
   private $_mysqli;

    /*La función construct es privada para evitar que el objeto pueda ser creado mediante new*/
    private function __construct($host,$user,$pwd,$bd){
        $this->_host = $host;
        $this->_user = $user;
        $this->_pwd = $pwd;
        $this->_bd = $bd;

        $this->conectar();
    }

    /*Evitamos el clonaje del objeto. Patrón Singleton*/
    private function __clone(){ }

    /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fua de la clase para instanciar el objeto, y así, poder utilizar suu
s método*/
    /*La instancia ya tienes parametros por DEFAULT si se quiere otra BD solo cuando se llame la instancia dar los parametros de conexion*/
    public static function getInstance($host='10.186.188.188',$user='smsmkt',$pwd='231mktsms',$bd='sms'){

        if (!(self::$_instance instanceof self)){
            self::$_instance=new self($host,$user,$pwd,$bd);
        }
        return self::$_instance;
    }

    /*Realiza la conexion a la base de datos.*/
    private function conectar(){
        $this->_mysqli = new mysqli($this->_host, $this->_user, $this->_pwd, $this->_bd);

        if($this->_mysqli->connect_errno){
            echo "Error: " . $this->_mysqli->connect_errno;
            mail($this->_mail,"error en conexion BD smsmkt",$this->_mysqli->connect_errno);
            exit;
        }
    }

    public function insert($sql){

        if($this->_mysqli->query($sql))
            return $this->_mysqli->insert_id;
        else{
            if($this->_debug == true)
                printf("Error: %s\n", $this->_mysqli->error);
            mail($this->_mail,"error en insertar smsmkt","sentencia : $sql \n {$this->_mysqli->error}");
            return false;
        }
    }

    public function update($sql){

        if($this->_mysqli->query($sql))
            return $this->_mysqli->affected_rows;
        else{
            if($this->_debug == true)
                printf("Error: %s\n", $this->_mysqli->error);
            mail($this->_mail,"error en update smsmkt","sentencia : $sql \n {$this->_mysqli->error}");
            return false;
        }
    }

    public function delete($sql){

        if($this->_mysqli->query($sql))
            return $this->_mysqli->affected_rows;
        else{
            if($this->_debug == true)
                printf("Error: %s\n", $this->_mysqli->error);
            mail($this->_mail,"error en delete smsmkt","sentencia : $sql \n {$this->_mysqli->error}");
            return false;
        }
    }

    public function queryOne($sql){

        if($resultado = $this->_mysqli->query($sql))
            return $resultado->fetch_array();
        else{
            if($this->_debug == true)
                printf("Error: %s\n", $this->_mysqli->error);
            return false;
        }
    }

    public function queryAll($sql){

        if($resultado = $this->_mysqli->query($sql)){
            $respuesta = array();
            while($res = $resultado->fetch_array()){
                array_push($respuesta,$res);
            }
            return $respuesta;
        }else{
            if($this->_debug == true)
                printf("Error: %s\n", $this->_mysqli->error);
            return false;
        }
    }
}

?>
          
