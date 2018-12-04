<?php

$filename="/home/smsmkt/App/apift/httpsift0.txt";
$gestor = fopen($filename, "r");
$contenido = fread($gestor, filesize($filename));
fclose($gestor);
//$cadena=argv[1];

preg_match("/Set-Cookie: FRONTAPPID=(.*); path=\/; secure; HttpOnly/",$contenido,$resultado);
print_r($resultado[1]);

?>
