<?php
$include = '../';
require("cab.php");
require("_class/_class_grCollaboration.php");
$grc = new grC;

$file = 'temp/REDE.net';
$grc->openfile($file);

$a = array(2, 292, 304, 315, 336, 403, 642, 668, 745, 963, 995, 1117, 1248, 1353, 1930, 2421, 2471, 2540, 2550, 2666);

$ln = split(chr(13),$grc->s);

$i = 0;
$sv = '';
$se = '';
for ($r=0;$r < count($ln);$r++)
	{
		if ($i == 1)
			{
			$lx = trim($ln[$r]);
			$lx = troca($lx,' ',';');
			$lx = splitx(';',$lx);
			
			$v1 = $lx[0];
			$v2 = $lx[1];
			$ok = 0;
			if (in_array($v1, $a)) { $ok = 1; }
			if (in_array($v2, $a)) { $ok = 1; }
			if ($ok == 1)
				{
					$sa .= $ln[$r].chr(13).chr(10).'<BR>';					
				}
			
			} else {
				$se .= $ln[$r].chr(13).chr(10).'<BR>';
			}
		
		if (trim($ln[$r])=='*Edges') { $i = 1; }
	}
echo $se;
echo $sa;	
?>
