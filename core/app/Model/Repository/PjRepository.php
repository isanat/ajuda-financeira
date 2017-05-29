<?php
abstract class PjRepository
{
	public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);

	}
	
	public function Inserir() {
		
		$array['pj'] = array(
				'pj_cnpj'=>$this->GetPjCnpj(),
				'fk_usu'=>$this->GetFkUsu()
		);
		
		
		$this->banco->inserir('tb_pj',$array['pj']);
		
		return true;
	}
	
}