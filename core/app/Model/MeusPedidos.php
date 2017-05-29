<?php 

class MeusPedidos
{
	
	public $pedido;
	
	public function meuspedidos()
	{
	
	}

	public function meuspedidos_ajax() {
		$pedido = new Pedido();		
		$pedido->SetFkUsu($_SESSION['usuario']['usu_doc']);	
       // echo "<pre>"; print_r($pedido->adm_listar_p_ajax()); die;
		return $pedido->adm_listar_ajax();	
	}
	
	public function pendentes() {
		
		$usu = new Usuario();
	
		$res = $usu->banco->executar("SELECT usu_id, usu_usuario, usu_perna_pref, usu_doc, to_char(usu_data, 'DD/MM/YYYY') as usu_data 
				FROM public.tb_usuarios WHERE fk_status = 1 AND fk_usu = '{$_SESSION['usuario']['usu_doc']}' ORDER BY usu_id DESC");
	
		return array(
				'lista' => $res
		);
	
	}
	
	public function pendentes_ajax() {
	
		$usu = new Usuario();
	
		if($usu->banco->editar('public.tb_usuarios',array('usu_perna_pref' => $_POST['perna']),"usu_id = {$_POST['id']}"))
		{
	
		return array(
				'template' => 'null',
				'retorno' => 'sim',
				'msg' => 'Perna Alterada com Sucesso.'
		);
		}else{
			return array(
					'template' => 'null',
					'retorno' => 'nao',
					'msg' => 'Erro ao alterar a perna'
			);
		}
	
	}
	
	public function __call($metodo,$argumanto)
	{
		return 'erro';
	
	}
}