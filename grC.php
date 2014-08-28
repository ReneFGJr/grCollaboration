<?php
$include = '../';
require("cab.php");
require("_class/_class_grCollaboration.php");
$grc = new grC;

$file = 'temp/REDE.csv';
$grc->openCSV($file);


echo $grc->mostra_autores();
?>
