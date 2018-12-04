<?php
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
// Notificar todos los errores de PHP
error_reporting(-1);

include 'model/codigosUnicosDao.php'; // Regresa array

echo "Inica\n";

$Base36=array(
0=>0,
1=>1,
2=>2,
3=>3,
4=>4,
5=>5,
6=>6,
7=>7,
8=>8,
9=>9,
10=>'A',
11=>'B',
12=>'C',
13=>'D',
14=>'E',
15=>'F',
16=>'G',
17=>'H',
18=>'I',
19=>'J',
20=>'K',
21=>'L',
22=>'M',
23=>'N',
24=>'O',
25=>'P',
26=>'Q',
27=>'R',
28=>'S',
29=>'T',
30=>'U',
31=>'V',
32=>'W',
33=>'X',
34=>'Y',
35=>'Z'
);

//print_r($Base36);
//for($m=0;$m<36;$m++)
  for($l=0;$l<36;$l++)
    for($k=0;$k<36;$k++)
      for($j=0;$j<36;$j++)
        for($i=0;$i<36;$i++)
        {
          	//echo /*$Base36[$m].*/$Base36[$l].$Base36[$k].$Base36[$j].$Base36[$i]."\n";
          	$unico = $Base36[$l].$Base36[$k].$Base36[$j].$Base36[$i];
          	$data = new \stdClass();
			$data->_value = $unico;
			$data->_status = 0;

			$id = codigosUnicosDao::insert($data);

			echo $unico."\n";
			echo $id."<br>\n";
        }