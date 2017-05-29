<?php
abstract class RelatoriosRepository{
  
  public $banco;
	
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function listarDispachos($filtros) {		
		$queryPt = "SELECT COUNT(*) AS total FROM public.tb_pedidos WHERE fk_status = 3 AND ped_tipo = '2'";	

		$query =  "
			SELECT DISTINCT
			    usu.usu_usuario as usu_usuario,
                usu.usu_doc as usu_doc,
				ped.ped_id as ped_id,
				ped.fk_usu as fk_usu,
				ped.fk_status as fk_status,
				ped.ped_total as ped_total,
				ped.fk_status_trans as fk_status_trans,
				to_char( ped.ped_data_pag, 'DD/MM/YYYY') AS ped_data_pag, 
				ped.ped_cod_trans as ped_cod_trans,
				ped.fk_trans as fk_trans,	
				tran.trans_id as trans_id,
				tran.trans_nome as trans_nome,
				stran.tr_id as tr_id,
				stran.tr_nome as tr_nome
			FROM 
			    public.tb_usuarios as usu,
				public.tb_pedidos as ped,
				public.tb_fornecedor as forn,
				public.tb_transporte as tran,
				public.tb_status_transporte as stran
			";
	
		if( !empty( $filtros['busca'] ) ) {
			$queryBusca = "WHERE 
								ped.fk_usu = usu.usu_doc AND
								usu.fk_status = 2 AND
								ped.fk_status = 3 AND
								ped.ped_tipo = '2' AND
								stran.tr_id = ped.fk_status_trans AND       
								tran.trans_id = ped.fk_trans AND			
								to_char( ped.ped_data_pag, 'DD/MM/YYYY') LIKE '%".$filtros['busca']."%'";
								
								
		} else {
			$queryBusca = "
			WHERE
				ped.fk_usu = usu.usu_doc AND
				usu.fk_status = 2 AND
				ped.fk_status = 3 AND
				ped.ped_tipo = '2' AND
				stran.tr_id = ped.fk_status_trans AND       
				tran.trans_id = ped.fk_trans";	
		}
	
		
		
		$retornoPt = $this->ListarDispachosPaginacao( $queryPt, $filtros['pagina'], $filtros['limit'] );
				
		$query .= $queryBusca;
       
		

		$query .= " ORDER BY ped.ped_id ASC ";
		$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];			

		$result = $this->banco->conexao->prepare($query);
		$result->execute();
		$ret = $result->fetchAll(PDO::FETCH_ASSOC);
		
		$retorno['busca'] = $ret;
		$retorno['paginacao'] = $retornoPt;
		return $retorno;
	}
	
	public function ListarDispachosPaginacao($sql, $pagina, $regpag ) {
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		$totalRegistros = $res[0]['total'];
		if( $totalRegistros > 0 ) {
			$totalPaginas = ceil( $totalRegistros / $regpag );
			$totalPagina = ( $pagina * $regpag );
			$totalPagina = ( $totalPagina < $totalRegistros ) ? $totalPagina : $totalRegistros;

			if( $pagina > 1 ) {
				$offset = ( ( $pagina * $regpag ) - $regpag );
			} else {
				$offset = 0;
			} 
			
			$offsetMaisUm = $offset + 1;
		} else {
			$offset = 0;
			$offsetMaisUm = 0;
			$totalPaginas = 0;
			$totalPagina = 0;
		}
		
		$html = '<div class="row-fluid">
					<div class="span6">
						<div class="dataTables_info" id="editable_info">Mostrando '.$offsetMaisUm.' até '.$totalPagina.' de '.$totalRegistros.' registros</div>
					</div>
					<div class="span6">
						<div class="dataTables_paginate paging_bootstrap pagination">
							<ul>';
							//botao botao anterior
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(paginacao(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(paginacao(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(paginacao(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(paginacao(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>';

		return $html;
	}
  
  
  	public function status_transporte(){	  
		$result = $this->banco->executar("SELECT * FROM public.tb_status_transporte");		
		return $result;	
	}
  
  public function updateIdPedRastre(){
	  $dados = array(
	  "fk_status_trans"=>Relatorios::$idRastre);	  
      $this->banco->editar('public.tb_pedidos', $dados ,"ped_id = '".Relatorios::$idPed."'"); 
   } 
   
    public function updateCodRastre(){
	  $dados = array(
	  "ped_cod_trans"=>Relatorios::$valorCod);	  
      $this->banco->editar('public.tb_pedidos', $dados ,"ped_id = '".Relatorios::$idCod."'");    
   }
   
   public function selectPedidoCompleto(){	  
		$result = $this->banco->executar("
SELECT DISTINCT
	prod.pro_nome as pro_nome,
	forn.fn_nome as fn_nome,
	tran.trans_nome as trans_nome,
	tran.trans_nome as trans_nome,
	to_char( ped.ped_data_pag, 'DD/MM/YYYY') AS ped_data_pag, 
	car.cart_qtd as cart_qtd,
	car.cart_valor as cart_valor

FROM 
	public.tb_pedidos as ped,
	public.tb_carrinho as car, 
	public.tb_produtos as prod,
	public.tb_fornecedor as forn,
	public.tb_transporte as tran
WHERE
	ped.ped_id = '".Relatorios::$idPedModal."' AND
	ped.fk_status = 3 AND
	ped.ped_tipo = '2' AND     
	prod.pro_cod = car.fk_prod::text AND
	prod.fk_fornecedor = forn.fn_id AND
	ped.ped_sessao = car.fk_sessao AND
	tran.trans_id = ped.fk_trans");		
return $result;	
	}
	
	 public function selectInfoPedUsu(){	  
		$result = $this->banco->executar("
SELECT DISTINCT
	usu.usu_nome as usu_nome,
	usu.usu_usuario as usu_usuario,
	ende.end_cep as end_cep,
	ende.end_end as end_end,
	ende.end_n as end_n,
	ende.end_comp as end_comp,
	ende.end_bairro as end_bairro,
	ende.end_cidade as end_cidade,
	ende.end_uf as end_uf,
	fone.fone_fone as fone_fone,
	usu.usu_email as usu_email,
	carr.ca_nome as ca_nome
FROM 
	public.tb_usuarios as usu,
	public.tb_fone as fone,
	public.tb_endereco as ende,
	public.tb_pedidos as ped,
	public.tb_carreira as carr
WHERE
	ped.ped_id = '".Relatorios::$idPedModal."' AND
	carr.ca_id = usu.fk_carreira AND  
	usu.usu_doc = ped.fk_usu AND
	usu.usu_doc = ende.fk_usu AND
	usu.usu_doc = fone.fk_usu");		
return $result;	
	}
	
	
	public function selectInfoPedUsuPreferencial(){	  
		$result = $this->banco->executar("
			SELECT DISTINCT
				usu.usu_nome as usu_nome,
				usu.usu_usuario as usu_usuario,
				endped.end_cep as end_cep,
				endped.end_end as end_end,
				endped.end_n as end_n,
				endped.end_comp as end_comp,
				endped.end_bairro as end_bairro,
				endped.end_cidade as end_cidade,
				endped.end_uf as end_uf
			FROM 
				public.tb_usuarios as usu,
				public.tb_endereco_pedido as endped,
				public.tb_pedidos as ped
			WHERE
				ped.ped_id = '".Relatorios::$idPedModal."' AND
				ped.ped_sessao = endped.fk_sessao");		
         return $result;	
	}
   
   public function Search($filtros, $tipo=null) {
      
	  try{				
			$queryPag = "SELECT COUNT(*) AS total FROM tb_pedidos WHERE fk_cd = '".$_SESSION['usuario']['cd_doc']."'::text AND ped_tipo in {$tipo} ";
	        
			$query = "SELECT tb_pedidos.ped_id, 
				tb_pedidos.ped_transid, 
				tb_usuarios.usu_nome, 
				tb_usuarios.usu_usuario, 
				to_char( tb_pedidos.ord_date, 'DD/MM/YYYY') as ord_date, 
				tb_pedidos.ped_total,
				tb_pedidos.ped_valor_frete,
				tb_pedidos.fk_status, 
				tb_pedidos.ped_tipo, 
				tb_status_pedido.status_nome, 
				bl.bl_ativo, 
				bl.bl_link 
			FROM tb_pedidos 
				INNER JOIN tb_usuarios ON tb_usuarios.usu_doc = tb_pedidos.fk_usu 
				INNER JOIN tb_status_pedido ON tb_status_pedido.status_id = tb_pedidos.fk_status 
				LEFT JOIN banco.tb_boletos bl ON bl.fk_pedido = tb_pedidos.ped_transid
			WHERE tb_pedidos.ped_tipo in {$tipo} AND tb_pedidos.fk_cd = '".$_SESSION['usuario']['cd_doc']."'::text ";

			if( !empty( $filtros['busca'] ) ) {
				$queryBusca = "AND ( ( tb_usuarios.usu_usuario ILIKE '%".$filtros['busca']."%' ) OR
								( tb_pedidos.ped_id::text = '".$filtros['busca']."' ) OR
								( tb_pedidos.ped_transid ILIKE '%".$filtros['busca']."%' ) OR
								( to_char( tb_pedidos.ord_date, 'DD/MM/YYYY')::text ILIKE '%".$filtros['busca']."%' ) OR
								( tb_pedidos.ped_total::text ILIKE '%".$filtros['busca']."%' ) OR
								( tb_status_pedido.status_nome ILIKE '%".$filtros['busca']."%' ) )";
			} else {
				$queryBusca = "";	
			}

			$queryPag .= $queryBusca;	
					
			$retornoPag = $this->SearchPaginacao( $queryPag, $filtros['pagina'], $filtros['limit'] );
		
			$query .= $queryBusca;
			
			$query .= "ORDER BY tb_pedidos.ped_id DESC ";
			$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
			$ver = $this->banco->conexao->prepare($query);
			$ver->execute();
			$ret = $ver->fetchAll(PDO::FETCH_ASSOC);
			$retorno['busca'] = $ret;
			$retorno['paginacao'] = $retornoPag;
			return $retorno;
							
		} catch (PDOException $e){
			$msg = 'Erro ao consultar pedidos: ' . $e->getMessage();
			$this->banco->log($msg);
		}	
	}
	
	
	public function buscarSaida($filtros, $tipo=null) {
 
	  try{				
			$queryPag = "SELECT COUNT(*) AS total FROM tb_pedidos 
			                WHERE 
			            fk_cd = '".$_SESSION['usuario']['cd_doc']."'::text
					AND ped_tipo in {$tipo} AND fk_status = '3'
			";
	        
			$query = "SELECT tb_pedidos.ped_id, 
				tb_pedidos.ped_transid, 
				tb_usuarios.usu_nome, 
				tb_usuarios.usu_usuario, 
				to_char( tb_pedidos.ord_date, 'DD/MM/YYYY') as ord_date, 
				tb_pedidos.ped_total,
				tb_pedidos.ped_valor_frete,
				tb_pedidos.fk_status, 
				tb_pedidos.ped_tipo, 
				tb_status_pedido.status_nome, 
				bl.bl_ativo, 
				bl.bl_link 
			FROM tb_pedidos 
				INNER JOIN tb_usuarios ON tb_usuarios.usu_doc = tb_pedidos.fk_usu 
				INNER JOIN tb_status_pedido ON tb_status_pedido.status_id = tb_pedidos.fk_status 
				LEFT JOIN banco.tb_boletos bl ON bl.fk_pedido = tb_pedidos.ped_transid
				LEFT JOIN tb_status_transporte tr ON tr.tr_id::text = tb_pedidos.fk_status_cd::text
			WHERE tb_pedidos.ped_tipo in {$tipo} AND tb_pedidos.fk_status = '3' AND tb_pedidos.fk_status_cd = 3 AND tb_pedidos.fk_cd = '".$_SESSION['usuario']['cd_doc']."'::text ";

			if( !empty( $filtros['busca'] ) ) {
				$queryBusca = "AND ( ( tb_usuarios.usu_usuario ILIKE '%".$filtros['busca']."%' ) OR
								( tb_pedidos.ped_id::text = '".$filtros['busca']."' ) OR
								( tb_pedidos.ped_transid ILIKE '%".$filtros['busca']."%' ) OR
								( to_char( tb_pedidos.ord_date, 'DD/MM/YYYY')::text ILIKE '%".$filtros['busca']."%' ) OR
								( tb_pedidos.ped_total::text ILIKE '%".$filtros['busca']."%' ) OR
								( tb_status_pedido.status_nome ILIKE '%".$filtros['busca']."%' ) )";
			} else {
				$queryBusca = "";	
			}

			$queryPag .= $queryBusca;	
					
			$retornoPag = $this->SearchPaginacao( $queryPag, $filtros['pagina'], $filtros['limit'] );
		
			$query .= $queryBusca;
			
			//echo "<pre>"; print_r($query); die;
			
			$query .= "ORDER BY tb_pedidos.ped_id DESC ";
			$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
			$ver = $this->banco->conexao->prepare($query);
			$ver->execute();
			$ret = $ver->fetchAll(PDO::FETCH_ASSOC);
			$retorno['busca'] = $ret;
			$retorno['paginacao'] = $retornoPag;
			return $retorno;
							
		} catch (PDOException $e){
			$msg = 'Erro ao consultar pedidos: ' . $e->getMessage();
			$this->banco->log($msg);
		}	
	}
	
	
	public function SearchPaginacao($sql, $pagina, $regpag ) {
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		$totalRegistros = $res[0]['total'];
		if( $totalRegistros > 0 ) {
			$totalPaginas = ceil( $totalRegistros / $regpag );
			$totalPagina = ( $pagina * $regpag );
			$totalPagina = ( $totalPagina < $totalRegistros ) ? $totalPagina : $totalRegistros;

			if( $pagina > 1 ) {
				$offset = ( ( $pagina * $regpag ) - $regpag );
			} else {
				$offset = 0;
			} 
			
			$offsetMaisUm = $offset + 1;
		} else {
			$offset = 0;
			$offsetMaisUm = 0;
			$totalPaginas = 0;
			$totalPagina = 0;
		}
		
		$html = '<div class="row-fluid">
					<div class="span6">
						<div class="dataTables_info" id="editable_info">Mostrando '.$offsetMaisUm.' até '.$totalPagina.' de '.$totalRegistros.' registros</div>
					</div>
					<div class="span6">
						<div class="dataTables_paginate paging_bootstrap pagination">
							<ul>';
							//botao botao anterior
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(adm_paginacao_cd(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(adm_paginacao_cd(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(adm_paginacao_cd(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(adm_paginacao_cd(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>';

		return $html;
	}
   
	
}