#!/usr/bin/php -q
<?php
  $link = dbconnect();
/////////////////////////// 300000 este valor depende de las bolsas que PAyjoy ha comprado a Airmovil. Actualmente 3x100k!!!! 9 agosto 2018
  $consulta=<<<sql
SELECT 300000-SUM(delivered) FROM customer_control_mt WHERE customer_id = 41
sql;

  $resultado=mysqli_query($link,$consulta );
  list($restantes)=mysqli_fetch_array($resultado);

if($restantes< 30000 and $restantes > 15000) //informativo para Airmovil!!!!
{
mail("tecnico@airmovil.com","ATTENTION!. FEW SMS AIRMOVIL PAYJOY","Important!\n\nPAYJOY,\n This is an automatic notification to inform you about your SMS Service in Airmovil.\n\nNow you have less than $restantes sms since your last purchase to Airmovil!\n\nRegards\nAirmovil\n");
}
if($restantes< 15000) //Notificando a PAYJOY!!!!
{
mail("iker@payjoy.com,eric.lopez@payjoy.com,logan@payjoy.com,mauricio@payjoy.com,tecnico@airmovil.com","ATTENTION!. FEW SMS AIRMOVIL PAYJOY","Important!\n\nPAYJOY,\n This is an automatic notification to inform you about your sms service in Airmovil.\n\nNow you have less than $restantes sms since your last Purchase!\n\nRegards\nAirmovil\n");
}

echo date("Y/m/d")." ATTENTION!. FEW SMS AIRMOVIL PAYJOY","Important!\n\nPAYJOY,\n This is an automatic notification to inform you about your SMS Service in Airmovil.\n\nNow you have less than $restantes sms since your last purchase to Airmovil!\n\nRegards\nAirmovil\n";


function dbconnect($dbname="sms",$user="reportes",$password="1qBs@re",$server="localhost")
{
  if(!($mylink = mysqli_connect($server,$user,$password,$dbname)))
  {
	mail("tecnico@airmovil.com","Error en conexion reportes", "Error en conexion dbname: $dbname server: $server user: $user");
  }
  //mysql_select_db($dbname);
  return $mylink;
}


?>
