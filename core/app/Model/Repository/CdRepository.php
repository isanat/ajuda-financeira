<?php 

abstract class CdRepository
{

	public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);

	}
	
	public  function listar($cd=null)
	{
		if($cd == null)
		{
		$query = $this->banco->conexao->prepare("
				SELECT * FROM cd.tb_cd");
			
		$campos = array();
		
		}else{
			
			$query = $this->banco->conexao->prepare("
					SELECT * FROM cd.tb_cd WHERE cd_id = ? ORDER BY cd_id ASC");
				
			$campos = array($cd);
			
		}
			
			
		$query->execute($campos);
			
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $res;
	}
	
	public function Password($password)
	{
	
		$hash = hash('sha512', '&u*i$r#').$password;
	
		return md5($hash);
	}
	
	
	
}