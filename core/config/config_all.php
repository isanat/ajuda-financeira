<?php

switch ($_SERVER['HTTP_HOST']) {
	
	case 'www.escritorio.g3money10.com.br':
		$cliente_all = 'g3money';
		$template = 'template_mmn';
		break;		
	case 'escritorio.g3money10.com.br':
		$cliente_all = 'g3money';
		$template = 'template_mmn';		
		break;	
    default:	
	break;
        
}

include_once('config/config_'.$cliente_all.'.php');

global $array_db;

global $config;

global $template;

if(isset($_SESSION['usuario']))
{
	$user = $_SESSION['usuario']['usu_doc'];

	include_once('module/'.$cliente_all.'/config/'.$user.'.php');
	
	global $array_global;

}
