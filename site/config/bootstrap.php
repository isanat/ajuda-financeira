<?php

function appModel($classe) 
{
    $arquivo = "core/app/Model/$classe.php";

    if(file_exists($arquivo)) {
        require_once($arquivo);
       return true;
    }
}

function appModelCli($classe)
{
	global $cliente_all;
	$arquivo = "module/" .$cliente_all. "/Model/$classe.php";
	if(file_exists($arquivo)) {
		require_once($arquivo);
		return true;
	}
}

function appController($classe) 
{
    $arquivo = "core/app/Controller/$classe.php";

    if(file_exists($arquivo)) {
        require_once($arquivo);
       return true;
    }
}

function coreConfig($classe)
{
	$arquivo = "core/config/$classe.php";

	if(file_exists($arquivo)) {
		require_once($arquivo);
		return true;
	}
}

function Entity($classe)
{
	$arquivo = "core/app/Model/Entity/$classe.php";

	if(file_exists($arquivo)) {
		require_once($arquivo);
		return true;
	}
}


function Repository($classe)
{
	$arquivo = "core/app/Model/Repository/$classe.php";

	if(file_exists($arquivo)) {
		require_once($arquivo);
		return true;
	}
}

spl_autoload_register('appModel');
spl_autoload_register('appModelCli');
spl_autoload_register('appController');
spl_autoload_register('coreConfig');
spl_autoload_register('Entity');
spl_autoload_register('Repository');
