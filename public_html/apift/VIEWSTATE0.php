<?php

$filename="/home/smsmkt/App/apift/httpsift0.txt";
$gestor = fopen($filename, "r");
$contenido = fread($gestor, filesize($filename));
fclose($gestor);
//$cadena=argv[1];

preg_match("/id=\"javax.faces.ViewState\" value=\"(.*)\" autocomplete=\"off\" \/>/",$contenido,$resultado);
print_r(urlencode($resultado[1]));

?>
