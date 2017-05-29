<?php

set_time_limit(0);
ini_set('display_erros',0);
session_start();
session_name(md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));

ob_start("ob_gzhandler");

/* if($_SERVER['REMOTE_ADDR'] == '179.228.175.62')
{ */

define('PATH_ROOT', 	__DIR__);

$includepaths = '.:'.
		PATH_ROOT.'/core/config:'.
		PATH_ROOT.'/core/lib:'.
		PATH_ROOT.'/core/app:';

ini_set("include_path", $includepaths);


include('bootstrap.php');

include_once('config_all.php');

new Controller();

/* }else{

echo 'SISTEMA EM DESENVOLVIMENTO';

} */
?>