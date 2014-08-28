<?php
    /**
     * DB
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2014 - sisDOC.com.br
	 * @access public
     * @version v0.14.17
	 * @package System
	 * @subpackage Database connection
    */
    
	/* Noshow Errors */
	$debug = 1;
	date_default_timezone_set('Etc/GMT+2');
	if (file_exists('debug.txt')) { $debug1 = 0; $debug2 = 255; } 	
	
	ini_set('display_errors', $debug1);
	ini_set('error_reporting', $debug2);
	    
    if (!isset($include)) { $include = '_include/'; }
	else { $include .= '_include/'; }
	if (!isset($include_db)) { $include_db = '_db/'; }
	else { $include_db .= '_db/'; }

    ob_start();
	session_start();

	/* Path Directory */
	$path_info = trim($_SERVER['PATH_INFO']);
	
	/* Set header param */
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);	

    $ip = $_SERVER['SERVER_ADDR'];
	if ($ip == '::1') { $ip = '127.0.0.1'; }
	
	$charset = 'utf-8';
	header('Content-Type: text/html; charset='.$charset);
	/* Include */
	require($include.'sisdoc_sql.php');	
	require($include.'sisdoc_debug.php');
	require($include.'_class_msg.php');
	require($include.'_class_char.php');		


	global $cnn,$conn;
	//echo '<br><br>'.$cnn;
	//echo '<br><br>'.$conn;
	/* Leituras das Variaveis dd0 a dd99 (POST/GET) */
	$vars = array_merge($_GET, $_POST);
	$acao = troca($vars['acao'],"'",'Â´');
	for ($k=0;$k < 100;$k++)
		{
		$varf='dd'.$k;
		$varf=$vars[$varf];
		$dd[$k] = post_security($varf);
		}	
	
	/* Data base */
	$filename = $include_db."db_mysql_".$ip.".php";
	if (!(file_exists($filename))) { $filename = '../'.$include_db."db_mysql_".$ip.".php"; }
	if (file_exists($filename))
		{
			require($filename);

		} else {		
			if ($install != 1) 
				{
					echo $filename.' not found';
					exit;
				redireciona('__install/index.php');				
		}	
	}	

function post_security($s)
	{
		$s = troca($s,'<','&lt;');
		$s = troca($s,'>','&gt;');
		$s = troca($s,'"','&quot;');
		//$s = troca($s,'/','&#x27;');
		$s = troca($s,"'",'&#x2F;');
		return($s);		
	}    
?>
	