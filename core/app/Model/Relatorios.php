<?php
class Relatorios extends TbRelatorios {
	
   public static $idPed;
   public static $idRastre;
   public static $idCod;
   public static $valorCod;
   public static $idPedModal;
   
   	
   public function dispachos(){
	   return false;
   }
    
    public function dispachos_ajax(){
		
if(isset($_POST['id'])){	
 self::$idPed = strip_tags(trim($_POST['id']));
 self::$idRastre = strip_tags(trim($_POST['idRastreio']));	
 return array(" template"=>"dispachos_ajax",$res,"trans"=>$this->status_transporte(),$this->updateIdPedRastre());
}
 
if(isset($_POST['idCod'])){	
 self::$idCod = strip_tags(trim($_POST['idCod']));
 self::$valorCod = strip_tags(trim($_POST['valor'])); 
 return array(" template"=>"dispachos_ajax",$res,"trans"=>$this->status_transporte(),$this->updateIdPedRastre(),$this->updateCodRastre());
}


		
		$filtros['limit'] = $_REQUEST['regpag'];
		
		if( $_REQUEST['pagina'] > 1 ) {
		$filtros['offset'] = ( ( $_REQUEST['pagina'] * $_REQUEST['regpag'] ) - $_REQUEST['regpag'] );
		} else {
		$filtros['offset'] = 0;
		}
		
		if( !empty( $_REQUEST['busca'] ) ) {
		$filtros['busca'] = $_REQUEST['busca'];
		} else {
		$filtros['busca'] = "";
		}
		$filtros['pagina'] = $_REQUEST['pagina'];
		
		$res = $this->listarDispachos($filtros);        
		//echo "<pre>"; print_r( $res ); die;		
	    return array("template"=>"dispachos_ajax", $res, "trans"=>$this->status_transporte());
	  
	}	
	
	public function infoPed(){
	  if(isset($_POST['pedId'])){	
	   self::$idPedModal = $_POST['pedId'];	
	   return array("template"=>"ajax/modal_info_pedido", "selectPedidoCompleto"=>$this->selectPedidoCompleto());  
	 } 
	}
	
	public function infoPedUsu(){
	  if(isset($_POST['pedId'])){	
	   self::$idPedModal = $_POST['pedId'];	
 	   return array("template"=>"ajax/modal_info_pedido_usu", "infPedUsu"=>$this->selectInfoPedUsu(),"preferencial"=>$this->selectInfoPedUsuPreferencial());
	 
	  }
	} 
	
	public function rel_saque()
	{
// 		echo '<pre>'; print_r($_POST);die;
		if(isset($_POST['status']))
		{
			$this->banco->editar('financeiro.tb_saque', array('fk_status' => $_POST['status']),"sc_id = {$_POST['id']}");
			
		}
		$rel = $this->banco->executar("SELECT s.sc_id, s.sc_valor, sc_data, data_pag, u.usu_usuario, ss.st_nome, s.fk_status  FROM financeiro.tb_saque s
										INNER JOIN public.tb_usuarios u ON s.fk_usu = u.usu_doc
										INNER JOIN financeiro.tb_status_saque ss ON s.fk_status = ss.st_id
										WHERE s.fk_status != 3 AND s.fk_status != 4
										ORDER BY s.sc_id DESC");
										
		return array(
				'lista' => $rel
		);
		
	}
	
	public function rel_saque_ajax()
	{
// 				echo '<pre>'; print_r($_POST);die;
		if(isset($_POST['status']))
		{
			$this->banco->editar('financeiro.tb_saque', array('fk_status' => $_POST['status']),"sc_id = {$_POST['id']}");
				
		}
		$rel = $this->banco->executar("SELECT s.sc_id, s.sc_valor, sc_data, data_pag, u.usu_usuario, ss.st_nome, s.fk_status  FROM financeiro.tb_saque s
				INNER JOIN public.tb_usuarios u ON s.fk_usu = u.usu_doc
				INNER JOIN financeiro.tb_status_saque ss ON s.fk_status = ss.st_id
				WHERE s.fk_status != 3 AND s.fk_status != 4
				ORDER BY s.sc_id DESC");
	
		return array(
				'template' => 'ajax/rel_saque_ajax',
				'lista' => $rel
		);
	
	}
  
 
    public function entrada(){
	   return false;
	}
	
    public function entrada_ajax(){
		
		$filtros = array();
		
		$filtros['limit'] = $_REQUEST['regpag'];
		
		if( $_REQUEST['pagina'] > 1 ) {
			$filtros['offset'] = ( ( $_REQUEST['pagina'] * $_REQUEST['regpag'] ) - $_REQUEST['regpag'] );
		} else {
			$filtros['offset'] = 0;
		}
	
		if( !empty( $_REQUEST['busca'] ) ) {
			$filtros['busca'] = $_REQUEST['busca'];
		} else {
			$filtros['busca'] = "";
		}
		
		$filtros['pagina'] = $_REQUEST['pagina'];
		
		$res = $this->Search($filtros,"('2','3','4','5','6','7')");
		
		return array('entrada'=>$res, "template"=>"entrada_ajax" );

	 }
	
	public function saida(){
	  return false;
	}
	
	public function saida_ajax(){
	  
		$filtros = array();
		
		$filtros['limit'] = $_REQUEST['regpag'];
		
		if( $_REQUEST['pagina'] > 1 ) {
			$filtros['offset'] = ( ( $_REQUEST['pagina'] * $_REQUEST['regpag'] ) - $_REQUEST['regpag'] );
		} else {
			$filtros['offset'] = 0;
		}
	
		if( !empty( $_REQUEST['busca'] ) ) {
			$filtros['busca'] = $_REQUEST['busca'];
		} else {
			$filtros['busca'] = "";
		}
		
		$filtros['pagina'] = $_REQUEST['pagina'];
		
		$res = $this->buscarSaida($filtros,"('1','2')");
		
		return array('entrada'=>$res, "template"=>"saida_ajax" );

	
	
	}


}
