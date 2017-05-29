<?php 

abstract class CarreiraRepository
{
	public $banco;
	
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function getCarreira() {
		$sql = "SELECT * 
				FROM tb_carreira 
				WHERE( ca_pontos > 0 ) 
				ORDER BY ca_pontos ASC";
		$res = $this->banco->executar( $sql );
		
		return $res;
	}
}
