<?php

  class Indicados extends TbUsuarios{
  
    public function indicacoes(){
	   
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
						
		 $ativo = $this->banco->executar("
						SELECT 				
						count(usu.usu_doc) as total						
						FROM 
						public.tb_usuarios as usu,
						public.tb_pedidos as ped
						WHERE
						usu.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND
						usu.usu_doc = ped.fk_usu AND
						ped.ped_nivel = 1 AND
						ped.fk_status = 3 AND
						usu.fk_status = 2 
						");	
		
		 $pendentes = $this->banco->executar("
						SELECT 
						count(usu.usu_doc) as total
						FROM 
						public.tb_usuarios as usu,
						public.tb_pedidos as ped
						WHERE
						usu.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND
						usu.usu_doc = ped.fk_usu AND
						ped.ped_nivel = 1 AND
						ped.fk_status = 1 AND
						usu.fk_status = 1 
						");	
						
		return array("inativo"=>$inativo, "ativo"=>$ativo, "pendentes"=>$pendentes);   
	
	}
	
	public function indicacoes_ajax(){
		
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
	
	$queryPag = " SELECT count(*) as total FROM public.tb_usuarios WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."'";
	
	$query = "SELECT 
	  usu_id, usu_nome, usu_usuario, fk_status, to_char( usu_data, 'DD/MM/YYYY') as usu_data, usu_doc, fk_usu, usu_email,u.status_nome
	 FROM public.tb_usuarios INNER JOIN public.tb_status_usu u ON fk_status = u.status_id WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."'";
	
	if( !empty( $filtros['busca'] ) ) {
				$queryBusca = " AND ( ( tb_usuarios.usu_usuario LIKE '%".$filtros['busca']."%' ) OR
									( to_char( tb_usuarios.usu_data, 'DD/MM/YYYY')::text LIKE '%".$filtros['busca']."%' ) OR
									( tb_usuarios.usu_email LIKE '%".$filtros['busca']."%' ))
									";
			}

	$queryPag .= $queryBusca;	

	$retornoPag = $this->SearchPaginacao( $queryPag, $filtros['pagina'], $filtros['limit'] );
	$query .= $queryBusca;	
	
	$query .= "ORDER BY tb_usuarios.usu_id DESC ";
	$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
	
	$ver = $this->banco->executar($query);
	$retorno['template'] = "indicacoes_ajax";
	$retorno['busca'] = $ver;
	$retorno['paginacao'] = $retornoPag;
	
	return $retorno;
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
				  <div class="dataTables_paginate paging_full_numbers" id="example_paginate">
					<div class="span6">';
							//botao botao anterior
							$html .= ( $pagina > 1 ) ? '<a tabindex="0" class="previous paginate_button" href="javascript:void(paginacao_ind(\''.( $pagina - 1 ).'\'));">← Anterior</a>' : '<a class="paginate_button_disabled" href="#">← Anterior</a>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<a tabindex="0" class="paginate_button" href="javascript:void(paginacao_ind(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a>' : '<a href="#">&nbsp;</a>';
							$html .= '<a tabindex="0" class="paginate_active" href="#">'.$pagina.'</a>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<a tabindex="0" class="paginate_button" href="javascript:void(paginacao_ind(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a>' : '<a href="#">&nbsp;</a>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<a tabindex="0" class="next paginate_button" href="javascript:void(paginacao_ind(\''.( $pagina + 1 ).'\'));">Próxima → </a>' : '<a href="#">Próxima → </a>';
							$html .= '					
					 </div>
			       </div>	
				</div>';

		return $html;
	}
	
  
  
  }