<?php

abstract class Core
{
	public $View;
	public $Usuario;
	public $Instancia;
	public $classe;
	public $metodo;
	public $dados;
	public $template = null;
	
	public static $cliente;
	public static $ip;
	public static $browser;
	public static $page;
	public static $referer = null;
	public static $parametros;
	public static $dados_usu;
	public static $config = null;
	
	public function Template()
	{
		
		$cliente 	= self::$cliente;
		$template 	= 'module/' . $cliente . '/View/' .$this->template. '.php';

		if($this->FileExists($template)){
			return $template;
		}else{
			return 'core/View/' .$this->template . '.php';
		}
	}
	
	public function Caminho()
	{
		
		$cliente 	= self::$cliente;
		$template 	= 'module/' . $cliente . '/View/' .$this->metodo. '.php';
		
		if($this->FileExists($template))
		{
			return 'module/' . $cliente . '/View/';
		}else{
			return 'core/View/';
		}
	}
	
	public function Cliente()
	{
		$this->dados['host'] = $_SERVER['HTTP_HOST'];

		global $cliente_all;

		$lingua = "ptbr";
		$this->dados['cliente']['usuario'] = $cliente_all;
		$_SESSION['cliente']['usu_usuario'] = $cliente_all;
		$this->dados['linguagem'] = $this->linguagem($lingua);
		
		return $cliente_all;
	}
	
	public function FileExists($file)
	{
		if(file_exists($file))
		{
			return true;
		} else {
			return false;
		}
	}
	
	public  function getClasseMetodo()
	{
		$cliente 	= self::$cliente;
		$key = explode('/',$_REQUEST['key']);
		$model_c = 'module/' . $cliente . '/Model/' . $key[0] . '_' . $cliente . '.php';
		$model_b = 'core/app/Model/' . $key[0] . '.php';
		
		if(!isset($_REQUEST['key']) or $_REQUEST['key'] ==  '')
		{
			
			switch ($_SERVER['HTTP_HOST']) {
				
				case 'www.escritorio.g3money10.com.br':
						$this->classe = 'Backoffice';
						$this->metodo = 'login';
					break;
				case 'escritorio.g3money10.com.br':
						$this->classe = 'Backoffice';
						$this->metodo = 'login';
						break;	
				default:
	
					break;
			}
			
			return array( 
					'classe' => $this->classe,
					'metodo' => $this->metodo 
					);
		} elseif ($this->FileExists($model_c)){
			
			$key = explode('/',$_REQUEST['key']);
			
			$this->classe = $key[0];
			$this->metodo = $key[1];
				
			return array(
					'classe' => $this->classe,
					'metodo' => $this->metodo
			);
			
		} elseif ($this->FileExists($model_b)){
			
			$key = explode('/',$_REQUEST['key']);
			
			$this->classe = $key[0];
			$this->metodo = $key[1];
				
			return array(
					'classe' => $this->classe,
					'metodo' => $this->metodo
			);
			
		} else {
			
			$this->classe = 'Erro';
			$this->metodo = 'NaoEncontrada';
			
			return array(
					'classe' => 'Erro',
					'metodo' => 'NaoEncontrada'
			);
		}
	}
	
	public  function GetModel($metodo)
	{
		$cliente 	= self::$cliente;
		$model_c = 'module/' . $cliente . '/Model/' . $this->classe . '_' . $cliente . '.php';
		$model_b = 'core/app/Model/' . $this->classe . '.php';

		if($this->FileExists($model_c))
		{
			$model_cli = $this->classe . '_' . $cliente;		
			$this->Instancia = new $model_cli;
			$res = $this->Instancia->$metodo();
			return $res;
		} elseif ($this->FileExists($model_b)){
			$this->Instancia = new $this->classe;
			$res = $this->Instancia->$metodo();
			return $res;
		} else {
			$this->Instancia = new Erro;
			$res = $this->Instancia->NaoEncontrada();
			return $res;
			
		}
	}
	
	public function parametros()
	{
// 		$_REQUEST['key'] = 'Backoffice/home/id/1/nome/Marcos';
		$key = explode('/',$_REQUEST['key']);
		unset($key[0]);
		unset($key[1]);
		
		$param = array();
		$chave = null;
		$valor = null;
		
		foreach ($key as $id)
		{
			if(array_key_exists($chave,$param))
			{
				$param[$chave] = $id;
				$chave = $id;
			} else {
			$param[$id] = $id;
			$chave = $id;
			}
		}
		
		self::$parametros = $param;
		$this->dados['param'] = $param;
		return true;
	}
	
	public  function linguagem($lingua)
	{	
	  if(empty($lingua)){
		  $ini = parse_ini_file('/var/www/g3money/public_html/core/config/language/ptbr.ini', true);		
			return $ini;
	  }
	  elseif(!empty($lingua)){
		  if( file_exists( '/var/www/g3money/public_html/core/config/language/'.$lingua.'.ini' ) ) {
				$ini = parse_ini_file('/var/www/g3money/public_html/core/config/language/'.$lingua.'.ini', true);		
				return $ini;
			} else {
				return false;	
			}
	  }
	}
	
	public function getJs()
	{
		$cliente 	= self::$cliente;
		$js_c = 'module/' . $cliente . '/View/js/' . $this->classe . '_' . $cliente . '.js';
		$js_b = 'core/View/js/' . $this->classe . '.js';
		
		//return $js_c." | ".$js_b;
		
		if($this->FileExists($js_c)){
			return $js_c;
		} elseif ($this->FileExists($js_b)){
			return $js_b;
		} else {
			return false;
		}
		
		return false;
	}
	
	public  function Vazio($dados)
	{
		if( !strlen( $dados ) ) {
	
			return false;
	
		} else {
			return true;
		}
	}
}