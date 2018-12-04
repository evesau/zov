<?php

$filename="httpsift.txt";
$gestor = fopen($filename, "r");
$contenido = fread($gestor, filesize($filename));
fclose($gestor);
//$cadena=argv[1];

preg_match("/id=\"javax.faces.ViewState\" value=\"(.*)\" autocomplete=\"off\" \/>/",$contenido,$resul$
print_r($resultado[1]);

?>

