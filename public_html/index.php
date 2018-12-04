<?php
/*show errors*/
ini_set('memory_limit', '10000M'); // or you could use 1G
//ini_set('max_execution_time', '120'); // or you could use 1G
session_start();
//print_r($_SESSION);
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');	

/*show errors*/
//directorio del proyecto
define("PROJECTPATH", dirname(__DIR__));
//directorio app
define("APPPATH", PROJECTPATH . '/App');

/*print_r(APPPATH);
echo "<br>";*/

//autoload con namespaces
function autoload_classes($class_name)
{
    $filename = PROJECTPATH . '/' . str_replace('\\', '/', $class_name) .'.php';
    /*print_r($filename);
    echo "<br>";*/

    if(is_file($filename))
    {
        include_once $filename;
    }
}

//registramos el autoload autoload_classes
spl_autoload_register("autoload_classes");

//instancia de la app
$app = new \Core\App;

//lanzamos la app
$app->render();
