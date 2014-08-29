<?php
$include = '../';
require("cab.php");
require("_class/_class_grCollaboration.php");
$grc = new grC;

$file = 'temp/REDE.csv';
$s = $grc->openfile($file);
$s = troca($s,$dd[1],$dd[2]);
$s = $grc->savefile($file,$s);
?>
