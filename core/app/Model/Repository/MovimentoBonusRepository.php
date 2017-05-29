<?php
abstract class MovimentoBonusRepository
{
	public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);

	}
	
	public function insereMovimento( $dados ) {
		$this->banco->inserir('banco.tb_movimento_bonus',$dados);	
	}
	
	public function getMovimentoContaDiaBonus() {
		$sql = "SELECT DISTINCT fk_conta_corrente 
				FROM banco.tb_movimento_bonus 
				WHERE( to_char( tb_movimento_bonus.mvm_data, 'YYYY-MM-DD')::text ILIKE '".$this->GetMvmData()."%' )";
		$res = $this->banco->executar( $sql );
		
		return $res;
	}
}