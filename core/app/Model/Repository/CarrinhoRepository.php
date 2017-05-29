<?php 

abstract class CarrinhoRepository
{

	public $banco;
	
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function inserirCarrinhoConsultor() {
		echo "inseriu carrinho consultor<br>";
	}
}