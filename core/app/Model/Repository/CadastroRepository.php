<?php 

abstract class CadastroRepository
{

	public $banco;
		
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}

	
	public function getUsuRede5x5($usuario = NULL){	  		
	
	 //$doc = ( $usuario != NULL ) ? $usuario : '00000000001';	

	  $usu = $this->banco->executar("
		WITH RECURSIVE familia (usu_id, usu_doc, fk_status, fk_usu_rede, nivel) AS
		(
		SELECT 
			u1.usu_id, u1.usu_doc, u1.fk_status, u1.fk_usu_rede, 1 AS nivel
		FROM tb_usuarios AS u1
		WHERE
			u1.usu_doc = '00000000001' AND u1.fk_status = 2
		UNION ALL
		SELECT 
			u2.usu_id, u2.usu_doc, u2.fk_status, u2.fk_usu_rede, f.nivel + 1 AS nivel
		FROM tb_usuarios AS u2
		INNER JOIN familia AS f ON f.usu_doc = u2.fk_usu_rede
		WHERE u2.fk_status = 2
		)
		SELECT 
		f.usu_id, f.usu_doc, f.fk_status, f.fk_usu_rede, (SELECT count(usu_id) FROM public.tb_usuarios WHERE fk_usu_rede = f.usu_doc) as total
		FROM 
		familia as f
		WHERE (SELECT count(usu_id) FROM public.tb_usuarios WHERE fk_usu_rede = f.usu_doc) < 3
		ORDER BY f.nivel,f.usu_id ASC LIMIT 1");
				   
	   return array("redeFilhos"=>$usu);	   
	   
	}
    
	
}