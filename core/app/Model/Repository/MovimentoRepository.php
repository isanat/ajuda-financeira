<?php
abstract class MovimentoRepository
{
	public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function insereMovimento( $dados ) {
		$this->banco->inserir('banco.tb_movimento',$dados);	
	}

	public function getMovimentoContaDia() {
		$sql = "SELECT DISTINCT fk_conta_corrente 
				FROM banco.tb_movimento 
				WHERE( to_char( tb_movimento.mvm_data, 'YYYY-MM-DD')::text ILIKE '".$this->GetMvmData()."%' )";
		$res = $this->banco->executar( $sql );
		
		return $res;
	}
}