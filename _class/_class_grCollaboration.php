<?php
class grC
	{
	var $erro = 0;
	var $erro_msg = '';
	var $autores = array();
	
	function __construct()
		{
			$this->autores = array();
		}
	
	function abrevia_nome($nome)
		{
			$sx = '';
			$i = 1;
			//$nome = uppercasesql($nome);
			
			for ($r=0;$r < strlen($nome);$r++)
				{
					$ch = substr($nome,$r,1);
					$ss = $ch.'-';
					if (($i == 1) and ($ch >= 'A' and $ch <= 'Z'))
						{
							$sx .= $ch;
							$i = 0;
						} else {
							if (($ch == ' ') or ($ch == '.'))
								{
									$i = 1;
								} else {
									$i = 0;
								}
						}
				}
				return($sx);
		}
	function simplificar_nome($nome)
		{
			$pos = strpos($nome,',');
			if ($pos > 0)
				{
					$sr = trim(substr($nome,$pos+1,300));
					$sr = $this->abrevia_nome($sr);
					$nome = UpperCaseSQl(substr($nome,0,$pos));
					$nome = ' '.$nome;
					$nome = troca($nome,' DE ','');
					$nome = troca($nome,' DA ','');
					$nome = troca($nome,' DOS ','');
					
					$sx = trim($nome).' '.$sr;
					if (strlen($sx) < 6) { $sx = ''; }
					return($sx);
				} else {
					$nome = UpperCaseSql(troca($nome,'. ',''));
					return($sx);
				}
		}
		
	function processCSV($s)
		{
			$ln = splitx(chr(13),$s);
			for ($r=0;$r < count($ln);$r++)
				{
					$l = $ln[$r];
					while (strpos($l,';;'))	
						{
							$l = troca($l,';;',';');
						}
					
					$ln[$r] = ($l);
				}
			return($ln);
		}
	function busca_autores($ln)
		{
			$au = $this->autores;
			$ln = $ln.';';
			$nn = splitx(';',$ln);
			for ($r=0; $r < count($nn);$r++)
				{
					$nome = trim($nn[$r]);
					if ($rx = array_search($nome,$au))	
						{
							/* Já existe */
						} else {
							/* Novo autor */
							array_push($au,$nome);
						}
				}
			
			$this->autores = $au;
		}
	function troca_autores_file($file,$de,$para)
		{
			$s = $this->openfile($file);
			$s = troca($s,$de,$para);
			$this->savefile($file,$s);
		}
	function savefile($file,$s)
		{
			$rlt = fopen($file,'w+');
			fwrite($rlt,$s);
			fclose($rlt);
			return(1);
		}
	function openCSV($file)
		{
			$s = $this->openfile($file);
			$l = $this->processCSV($s);
			
			/* Autores */
			for ($r=0;$r < count($l); $r++)
				{
					$a = $this->busca_autores($l[$r]);		
				}				
			/* Ordenar */
			$au = $this->autores;
			sort($au);
			$this->autores = $au;
			return(1);
		}
	function mostra_autores_para_troca()
		{
			$sx = '';
			$au = $this->autores;
			$s = $this->s;
			for ($r=0;$r < count($au);$r++)
				{
					$nome = $this->simplificar_nome($au[$r]);
					$link = '<A HREF="grC_troca.php?dd1='.$au[$r].'&dd2='.$nome.'" target="tela">troca</A>';
					$sx .= '<BR>'.$au[$r];
					$sx .= ' == '.$nome;
					if (strlen($nome) > 0)
						{
							$sx .= ' '.$link;
							$s = troca($s,$au[$r],$nome);
							$this->s = $s;
						} else {
							
						}
				}
			$sx .= '<BR><font class="lt0">Total '.count($au).' nos.</font>';
			return($sx);
		}		
	function mostra_autores()
		{
			$sx = '';
			$au = $this->autores;
			for ($r=0;$r < count($au);$r++)
				{
					$sx .= '<input type="checkbox" name="dda'.strzero($r,4).'">'.$au[$r].'<BR>';
					$sx .= ' == '.$this->simplificar_nome($au[$r]);
				}
			$sx .= '<BR><font class="lt0">Total '.count($au).' nos.</font>';
			return($sx);
		}
	function openfile($file)
		{
			if (file_exists($file))
				{
					$sx = '';
					$rlt = fopen($file,'r');
					while (!(feof($rlt)))
						{
							$sx .= fread($rlt,1024);		
						}
					fclose($rlt);
					$this->erro = 0;
					$this->erro_msg = '';
					$sx = htmlspecialchars_decode($sx);
					$this->s = $sx;
					return($sx);
				} else {
					$this->erro_msg = 'Erro ao abrir arquivo';
					$this->erro = 1;
					return('');
				}
		}
	
		
	}
?>
