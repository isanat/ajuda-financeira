<?php
abstract class FoneRepository
{
	public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);

	}
	
	public function getFones() {
		$sql = "SELECT * FROM tb_fone WHERE ( fk_usu = '".$this->GetFkUsu()."' )";
		$res = $this->banco->executar($sql);
		
		return $res;		
	}
	
	public function Inserir() {
		
		$array['fone'] = array(
				'fone_fone'=>$this->GetFoneFone(),
				'fk_usu'=>$this->GetFkUsu(),
				'fk_tipo'=>$this->GetFkTipo()
		);
		
		
		$this->banco->inserir('tb_fone',$array['fone']);
		
		return true;
	}
	
	public function verificaFone() {
		$sql = "SELECT COUNT(fk_usu) AS total FROM tb_fone WHERE ( fk_usu = '".$this->GetFkUsu()."' )";
		$res = $this->banco->executar($sql);

		if( empty( $res[0]['total'] ) ) {
			$array['fone']['fone_fone'] = '';
			$array['fone']['fk_usu'] = $this->GetFkUsu();
			$array['fone']['fk_tipo'] = 1;
			$this->banco->inserir('tb_fone',$array['fone']);
			
			$array['fone']['fone_fone'] = '';
			$array['fone']['fk_usu'] = $this->GetFkUsu();
			$array['fone']['fk_tipo'] = 2;
			$this->banco->inserir('tb_fone',$array['fone']);

			$array['fone']['fone_fone'] = '';
			$array['fone']['fk_usu'] = $this->GetFkUsu();
			$array['fone']['fk_tipo'] = 3;
			$this->banco->inserir('tb_fone',$array['fone']);			
		}
		
		return true;
	}
}