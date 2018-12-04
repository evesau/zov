<?php

$filename="/home/smsmkt/App/apift/httpsift2.txt";
$gestor = fopen($filename, "r");
$contenido = fread($gestor, filesize($filename));
fclose($gestor);
//$cadena=argv[1];

if(preg_match("/TELCEL/",$contenido,$resultado))
  print_r("TELCEL\n");
elseif(preg_match("/AT&amp;T/",$contenido,$resultado))
  print_r("AT&T\n");
elseif(preg_match("/MOVISTAR/",$contenido,$resultado))
  print_r("MOVISTAR\n");
elseif(preg_match("/TRUU/",$contenido,$resultado))
  print_r("TRUU\n");
elseif(preg_match("/VIRGIN/",$contenido,$resultado))
  print_r("VIRGIN\n");
elseif(preg_match("/SAI/",$contenido,$resultado))
  print_r("SAI\n");
else
  print_r("NO CARRIER\n");
exit();
?>
