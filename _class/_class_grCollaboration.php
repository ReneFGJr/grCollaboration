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
	
	function processCSV($s)
		{
			$ln = splitx(chr(13),$s);
			for ($r=0;$r < count($ln);$r++)
				{
					$l = $ln[$r];
					$l = troca($l,'-',' ');
					while (strpos($l,';;'))	
						{
							$l = troca($l,';;',';');
						}
					$l = troca($l,'. ','');
					$l = troca($l,'.','');
					
					$ln[$r] = UpperCaseSql($l);
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
	function mostra_autores()
		{
			$sx = '';
			$au = $this->autores;
			for ($r=0;$r < count($au);$r++)
				{
					$sx .= '<input type="checkbox" name="dda'.strzero($r,4).'">'.$au[$r].'<BR>';
				}
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
					return($sx);
				} else {
					$this->erro_msg = 'Erro ao abrir arquivo';
					$this->erro = 1;
					return('');
				}
		}
	
		
	}
?>
