<?php 

abstract class CarrinhoVoucherRepository
{

	public $banco;
	
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}

	public function Search($filtros) {
		try{				
			$queryPag = "SELECT COUNT(*) AS total
							FROM tb_carrinho_voucher 
								INNER JOIN tb_usuarios ON tb_usuarios.usu_doc = tb_carrinho_voucher.fk_usu 
								INNER JOIN tb_status_voucher ON tb_status_voucher.status_id = tb_carrinho_voucher.fk_status ";

			$query = "SELECT tb_carrinho_voucher.voucher_id, 
							tb_carrinho_voucher.voucher_qtd, 
							tb_usuarios.usu_nome, 
							to_char( tb_carrinho_voucher.voucher_data, 'DD/MM/YYYY') as voucher_data, 
							tb_carrinho_voucher.voucher_valor, 
							( tb_carrinho_voucher.voucher_valor * tb_carrinho_voucher.voucher_qtd ) AS voucher_total, 
							tb_status_voucher.status_id, 
							tb_status_voucher.status 
						FROM tb_carrinho_voucher 
							INNER JOIN tb_usuarios ON tb_usuarios.usu_doc = tb_carrinho_voucher.fk_usu 
							INNER JOIN tb_status_voucher ON tb_status_voucher.status_id = tb_carrinho_voucher.fk_status ";
			if( !empty( $filtros['busca'] ) ) {
				$queryBusca = "WHERE( tb_usuarios.usu_nome ILIKE '%".$filtros['busca']."%' ) OR
								( tb_carrinho_voucher.voucher_id::text = '".$filtros['busca']."' ) OR
								( to_char( tb_carrinho_voucher.voucher_data, 'DD/MM/YYYY')::text ILIKE '%".$filtros['busca']."%' ) OR
								( tb_carrinho_voucher.voucher_valor::text ILIKE '%".$filtros['busca']."%' ) OR
								( tb_status_voucher.status ILIKE '%".$filtros['busca']."%' ) ";
			} else {
				$queryBusca = '';	
			}
			
			$queryPag .= $queryBusca;
			$retornoPag = $this->SearchPaginacao( $queryPag, $filtros['pagina'], $filtros['limit'] );
			
			
			$query .= $queryBusca;
			$query .= "ORDER BY tb_carrinho_voucher.voucher_id DESC ";
			$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
// 			die($query);
			$result = $this->banco->conexao->prepare($query);
			$result->execute();
			$ret = $result->fetchAll(PDO::FETCH_ASSOC);

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
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(adm_paginacao_v(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(adm_paginacao_v(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(adm_paginacao_v(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(adm_paginacao_v(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>';

		return $html;
	}
	
	public function MinhaCompra()
	{
		$sessao = session_id();
		
		$query = $this->banco->conexao->prepare("
				SELECT * FROM public.tb_carrinho_voucher
				where (voucher_session)::text = (?)::text");
			
			
		$campos = array($sessao);
			
			
		$query->execute($campos);
		
		return $query->fetchAll(PDO::FETCH_ASSOC);
		
		
	}
	
	public function GetStatusVoucher() {
		$id  = $this->GetVoucherId();
		$sql = "SELECT tb_carrinho_voucher.fk_status, 
						tb_status_voucher.status, 
						tb_carrinho_voucher.voucher_session 
					FROM tb_carrinho_voucher 
					INNER JOIN tb_status_voucher ON tb_status_voucher.status_id = tb_carrinho_voucher.fk_status 
					WHERE( tb_carrinho_voucher.voucher_id = '".$id."' )";
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	}
	
	public function AtivarVoucher()
	{
		$voucher_id	= $this->GetVoucherId();
		$status 	= $this->GetFkStatus();

		$campo = array(
					'fk_status'=>$status 
					);
	
		$this->banco->editar('public.tb_carrinho_voucher',$campo, "voucher_id = '{$voucher_id}'");
		
		$status = $this->GetStatusVoucher();

		$campo = array(
					'fk_status_voucher'=>2 
					);		

		return $this->banco->editar('public.tb_voucher',$campo, "voucher_session = '".$status[0]['voucher_session']."'");
	}
	
	public function CancelarVoucher() {
		$idVoucher = $this->GetVoucherId();
		$dados     = $this->GetStatusVoucher();
		
		if( ( $dados[0]['fk_status'] == '1' ) ) {
			$fk_status 	= 5;		
			$campo = array(
						'fk_status' => $fk_status 
						);
		
			return $this->banco->editar('public.tb_carrinho_voucher',$campo, "voucher_id = '{$idVoucher}'");
			return true;
		} else {
			return false;
		}	
	}
	
	public function inserirCarrinhoConsultor() {
		echo "inseriu carrinho consultor<br>";
	}
}