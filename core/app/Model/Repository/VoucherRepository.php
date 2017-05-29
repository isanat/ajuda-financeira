<?php 

abstract class VoucherRepository
{

	public $banco;
	
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function VerStatusCarrinho()
	{
		$voucher = $this->GetVoucherHash();
	
		try{
			$res = $this->banco->executar( "SELECT c.fk_status
												FROM public.tb_voucher v
												INNER JOIN public.tb_carrinho_voucher c ON v.fk_ped = c.voucher_id
												WHERE v.voucher_hash = '{$voucher}'" ) ;
			return $res[0];
		}
		catch( PDOException $e ) {
			$msg = 'Erro ao selecionar categoria de produto: ' . $e->getMessage();
			$this->banco->log( $msg );
		}
	}
	
	public function VerStatusVoucher()
	{
		$voucher = $this->GetVoucherHash();
	
		try{
			$res = $this->banco->executar( "SELECT v.fk_status_voucher
					FROM public.tb_voucher v
					INNER JOIN public.tb_carrinho_voucher c ON v.fk_ped = c.voucher_id
					WHERE v.voucher_hash = '{$voucher}'" ) ;
					return $res[0];
		}
		catch( PDOException $e ) {
		$msg = 'Erro ao selecionar categoria de produto: ' . $e->getMessage();
		$this->banco->log( $msg );
		}
	}
	
	public function AtivarVoucher()
	{
		$voucher 	= $this->GetVoucherHash();
		$usu 		= $this->GetFkUsuVoucher();
		$status 	= $this->GetFkStatusVoucher();
		$data_usu 	= $this->GetVoucherDataUsu();
		
		$campo = array(
					'fk_status_voucher'=>$status,
					'voucher_data_usu'=>'NOW()',
					'fk_usu_voucher'=>$usu
					);
// 	echo '<pre>';print_r($campo);die;
		return $this->banco->editar('public.tb_voucher',$campo, "voucher_hash = '{$voucher}'");
	}
	
	public function Add_Voucher()
	{
		try{
		
		$voucher = array(
					'fk_ped'=>$this->GetVoucherId(),
					'voucher_valor'=>$this->GetVoucherValor(),
					'fk_usu'=>$this->GetFkUsu(),
					'fk_prod'=>$this->GetFkProd(),
					'fk_bonus'=>$this->GetFkBonus(),
					'voucher_hash'=>$this->GetVoucherHash(),
					"voucher_session" => session_id()
				);
// 		echo '<pre>';print_r($voucher);die;
		
		$this->banco->inserir('tb_voucher',$voucher);
		
		}catch( PDOException $e ) {
			$msg = 'Erro ao selecionar categoria de produto: ' . $e->getMessage();
// 			echo $msg; die;
			$this->banco->log( $msg );
		}
		
	}
	
	public function ProdutosCadastros() {
	
		try{
			$res = $this->banco->executar( "SELECT * FROM tb_produtos WHERE fk_tipo in (1,3)" ) ;
			return $res ;
		}
		catch( PDOException $e ) {
			$msg = 'Erro ao selecionar categoria de produto: ' . $e->getMessage();
			$this->banco->log( $msg );
		}
	
	}
	
	public function AddCarrinho( $id = null , $fk_bonus = null , $valor = null) {
		
		$dados = array(
				"voucher_pro_id" => $id ,
				"voucher_fk_bonus" => $fk_bonus ,
				"voucher_session" => session_id(),
				'fk_usu'=>$this->GetFkUsu(),
				"voucher_valor" => $valor
		);
// 	echo '<pre>';print_r($dados);die;
	try{
		$this->banco->inserir("public.tb_carrinho_voucher" , $dados) ;
		$this->SelectCarrinho();
		return $sql;
	}catch( PDOException $e ) {
		$msg = 'Erro ao selecionar produto do carrinho: ' . $e->getMessage() ;
		
		$this->banco->log( $msg ) ;
	}
	}
	
	public function SelectCarrinho( $parm = null ) {
		try{
			$sessao = session_id();
			 
			$sql    = $this->banco->executar(
					" SELECT
					tb_p.pro_cod AS pro_id,
					tb_p.fk_bonus AS fk_bonus, 
					tb_p.pro_nome AS pro_nome ,
					tb_p.pro_valor AS pro_valor ,
					tb_car.voucher_id AS voucher_id ,
					tb_car.voucher_pro_id AS voucher_pro_id ,
					tb_car.voucher_qtd AS voucher_qtd ,
					tb_car.voucher_valor AS voucher_valor
					FROM
					tb_produtos AS tb_p , tb_carrinho_voucher AS tb_car
					WHERE
					tb_car.voucher_pro_id::text = tb_p.pro_id::text AND tb_car.voucher_session::text = '{$sessao}'::text ORDER BY voucher_id DESC") ;
					return $sql;
		}
		catch( PDOException $e ) {
			$msg = 'Erro ao selecionar produto do carrinho: ' . $e->getMessage() ;
			$this->banco->log( $msg ) ;
			}
		
			}

	public function UpdateCar( $voucher_id , $qtd_voucher ){
			$this->voucher_id  = $voucher_id;
			$this->qtd_voucher = $qtd_voucher;
			 
			$dados = array(
					"voucher_qtd" => $this->qtd_voucher
			);
			$sql = $this->banco->editar("tb_carrinho_voucher" , $dados , "voucher_id = $this->voucher_id") ;
			$this->SelectCarrinho();
			return $sql;
	
		}
	
	public function DelProdutos( $del_pro ){
			$this->del_pro  = $del_pro;
		
			$sql = $this->banco->excluir("tb_carrinho_voucher" , "voucher_id = $this->del_pro") ;
			$this->SelectCarrinho();
			return $sql;
	
		}
		
		public function ValidaVoucherPendente()
		{
			
		}
		
		public function ValidaUsuVoucher()
		{
			try{
			
				$voucher = $this->GetVoucherHash();
				$pro 	 = $this->GetFkProd();
				
				$where = (empty($pro))?"v.voucher_hash::text = '{$voucher}'::text AND v.fk_status_voucher = 2":"v.voucher_hash::text = '{$voucher}'::text AND v.fk_bonus = {$pro} AND v.fk_status_voucher = 2";
				
				/* echo "SELECT
						v.fk_usu,
						u.usu_nome
						FROM
						public.tb_voucher v
						INNER JOIN public.tb_usuarios u ON u.usu_doc = v.fk_usu
						WHERE
						{$where}";die; */
				
				$sql    = $this->banco->executar(
										"SELECT
										v.fk_usu,
										u.usu_nome
										FROM
										public.tb_voucher v
										INNER JOIN public.tb_usuarios u ON u.usu_doc = v.fk_usu
										WHERE
										{$where}");
					
				return $sql[0];
			}
			catch( PDOException $e ) {
				$msg = 'Erro ao selecionar usuario voucher: ' . $e->getMessage() ;
				$this->banco->log( $msg ) ;
			}
				
		}

		public function SelectVoucher($filtros) {
			$queryPag = "SELECT COUNT(*) AS total  
					FROM tb_voucher 
					INNER JOIN tb_produtos ON tb_produtos.pro_id = tb_voucher.fk_prod 
					INNER JOIN tb_status_voucher ON tb_status_voucher.status_id = tb_voucher.fk_status_voucher 
					INNER JOIN tb_bonus ON tb_bonus.bn_id = tb_voucher.fk_bonus 
					LEFT JOIN tb_usuarios ON tb_usuarios.usu_doc = tb_voucher.fk_usu_voucher 
					WHERE( tb_voucher.fk_usu = '".$filtros['fk_usu']."' )";
					
			$query = "SELECT tb_produtos.pro_nome, 
							tb_voucher.voucher_valor, 
							to_char( tb_voucher.voucher_data, 'DD/MM/YYYY' ) as voucher_data, 
							to_char( tb_voucher.voucher_data_usu, 'DD/MM/YYYY' ) as voucher_data_usu, 
							tb_usuarios.usu_usuario, 
							tb_voucher.fk_status_voucher, 
							tb_status_voucher.status, 
							tb_voucher.voucher_hash, 
							tb_bonus.bn_nome 
					FROM tb_voucher 
					INNER JOIN tb_produtos ON tb_produtos.pro_id = tb_voucher.fk_prod 
					INNER JOIN tb_status_voucher ON tb_status_voucher.status_id = tb_voucher.fk_status_voucher 
					INNER JOIN tb_bonus ON tb_bonus.bn_id = tb_voucher.fk_bonus 
					LEFT JOIN tb_usuarios ON tb_usuarios.usu_doc = tb_voucher.fk_usu_voucher 
					WHERE( tb_voucher.fk_usu = '".$filtros['fk_usu']."' )";

			if( !empty( $filtros['busca'] ) ) {
					$queryBusca = " AND ( ( tb_produtos.pro_nome ILIKE '%".$filtros['busca']."%' ) OR
									( tb_voucher.voucher_valor::text = '".$filtros['busca']."' ) OR
									( to_char( tb_voucher.voucher_data, 'DD/MM/YYYY' )::text ILIKE '%".$filtros['busca']."%' ) OR
									( to_char( tb_voucher.voucher_data_usu, 'DD/MM/YYYY' )::text ILIKE '%".$filtros['busca']."%' ) OR
									( tb_usuarios.usu_usuario::text ILIKE '%".$filtros['busca']."%' ) OR
									( tb_status_voucher.status::text ILIKE '%".$filtros['busca']."%' ) OR
									( tb_voucher.voucher_hash::text ILIKE '%".$filtros['busca']."%' ) )";
			} else {
				$queryBusca = '';	
			}
			
			//echo $queryBusca;
			$queryPag .= $queryBusca;			
			$retornoPag = $this->SearchPaginacao( $queryPag, $filtros['pagina'], $filtros['limit'] );
			
			$query .= $queryBusca;
			$query .= "ORDER BY tb_voucher.voucher_id DESC ";
			$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
			
			$res = $this->banco->executar( $query );
			
			$retorno['busca'] = $res;
			$retorno['paginacao'] = $retornoPag;
			
			return $retorno;
			
			/*
			try{
			$sql    = $this->banco->executar(
					" SELECT DISTINCT
						usu.usu_id AS usu_id ,
						usu.usu_nome AS usu_nome ,
						usu.usu_doc AS usu_doc ,
						pro.pro_id AS pro_id ,
						pro.pro_nome AS pro_nome ,
						voucher.voucher_valor AS voucher_valor ,
						voucher.fk_usu AS fk_usu ,
						voucher.fk_status_voucher AS fk_status_voucher,
						voucher.voucher_data AS voucher_data ,
						voucher.fk_prod AS fk_prod ,
						voucher.voucher_hash AS voucher_hash ,
						tb_carrinho.fk_status AS fk_status
					 FROM 
					    tb_usuarios AS usu ,
					    tb_produtos AS pro ,
					    tb_voucher AS voucher ,
					    tb_carrinho_voucher AS tb_carrinho
					 WHERE 
			            voucher.fk_usu::text = usu.usu_doc::text AND voucher.fk_prod::text = pro.pro_id::text ORDER BY voucher_data ASC");
					return $sql;
		}
		catch( PDOException $e ) {
			$msg = 'Erro ao selecionar produto do carrinho: ' . $e->getMessage() ;
			$this->banco->log( $msg ) ;
		}
		
		*/
		
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
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(paginacao_v(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(paginacao_v(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(paginacao_v(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(paginacao_v(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>';

		return $html;
	}
}
