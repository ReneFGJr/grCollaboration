<?php
$include = '../';
require("cab.php");
require("_class/_class_grCollaboration.php");
$grc = new grC;

$file = 'temp/REDE.csv';
$s = $grc->openCSV($file);
$grc->mostra_autores_para_troca($s);
$grc->s = troca($grc->s,'.','');
$grc->savefile($file,$grc->s);
echo 'FIM';
?>
