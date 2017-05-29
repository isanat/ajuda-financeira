<?php

class Publi extends TbUsuarios{
	
	public function publicidade(){

	}
	
	public function video(){
		
		$inativo = $this->banco->executar("
						SELECT 
						usu.usu_usuario,
						usu.usu_doc,
						to_char(ped.ped_data_expira, 'DD/MM/YYYY' ) as ped_data_expira
						FROM 
						public.tb_usuarios as usu,
						public.tb_pedidos as ped
						WHERE
						usu.usu_doc = '{$_SESSION['usuario']['usu_doc']}' AND
						usu.usu_doc = ped.fk_usu AND
						ped.ped_nivel = 1 AND
						ped.fk_status = 1 AND
						usu.fk_status = 1 
						");	
	   
	   $res['inativo'] = $inativo;
	   return $res;

	}
	
}