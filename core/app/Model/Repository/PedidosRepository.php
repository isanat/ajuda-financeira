<?php 

abstract class PedidosRepository
{

	public $banco;
	public $meiopg;
	
	public function __construct() {
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function Transid($cpf)
	{
		usleep(1);
		$seg 		= explode('.', microtime(true));
		$transid	= $cpf.date('YmdHis').$seg[1];
	
		return $transid;
	}
	
	public function Search($filtros, $tipo=null) {

		try{				
			$queryPag = "SELECT COUNT(*) AS total
							FROM tb_pedidos 
								INNER JOIN tb_usuarios ON tb_usuarios.usu_doc = tb_pedidos.fk_usu 
								INNER JOIN tb_status_pedido ON tb_status_pedido.status_id = tb_pedidos.fk_status 
						    WHERE tb_pedidos.ped_tipo in {$tipo} AND tb_pedidos.fk_status = '3'";

$query = "
SELECT
        tb_pedidos.ped_id, 
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
		bl.bl_link,
		tb_pedidos.fk_status_cd,
		tr.tr_nome
FROM tb_pedidos 
		INNER JOIN tb_usuarios          ON tb_usuarios.usu_doc        = tb_pedidos.fk_usu 
		INNER JOIN tb_status_pedido     ON tb_status_pedido.status_id = tb_pedidos.fk_status 
		LEFT JOIN tb_status_transporte tr ON tr.tr_id::text = tb_pedidos.fk_status_cd::text
		LEFT JOIN banco.tb_boletos bl   ON bl.fk_pedido = tb_pedidos.ped_transid
		LEFT JOIN public.tb_carrinho ca ON public.tb_pedidos.ped_sessao = ca.fk_sessao
WHERE 
	    tb_pedidos.ped_tipo in {$tipo} AND 
		tb_pedidos.fk_status  = '3' AND 
		tb_pedidos.fk_status_cd  != 3 AND
		tb_pedidos.fk_cd      = '".$_SESSION['usuario']['cd_doc']."'::text  
GROUP BY 
        tb_pedidos.ped_id, 
		tb_pedidos.ped_transid, 
		tb_usuarios.usu_nome, 
		tb_usuarios.usu_usuario, 
		tb_pedidos.ord_date, 
		tb_pedidos.ped_total,
		tb_pedidos.ped_valor_frete,
		tb_pedidos.fk_status, 
		tb_pedidos.ped_tipo, 
		tb_status_pedido.status_nome, 
		bl.bl_ativo, 
		bl.bl_link,
		tb_pedidos.fk_status_cd,
		tr.tr_nome
";

 
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
			
			if( !empty( $filtros['fk_usu'] ) ) {
				if( !empty( $queryBusca ) ) {
					$queryBusca .= " AND ( tb_pedidos.fk_usu = '".$filtros['fk_usu']."' ) ";	
				} else {
					$queryBusca .= "AND ( tb_pedidos.fk_usu = '".$filtros['fk_usu']."' ) ";	
				}
			}
					
			
			$queryPag .= $queryBusca;	
					
			$retornoPag = $this->SearchPaginacao( $queryPag, $filtros['pagina'], $filtros['limit'] );
			$query .= $queryBusca;	
				
			$query .= "ORDER BY tb_pedidos.ped_id DESC ";
			$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
						
			$ver = $this->banco->executar($query);

			$retorno['busca'] = $ver;
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
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(adm_paginacao_p(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(adm_paginacao_p(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(adm_paginacao_p(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(adm_paginacao_p(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>';

		return $html;
	}
	
	public function PagarPedido()
	{
		$id 		= $this->GetPedId();
		$status 	= $this->GetFkStatus();
		$forma 		= $this->GetFkForma();
		$pag 		= $this->GetFkPag();
		$datapag 	= $this->GetPedDataPag();
		$valor_pago = $this->GetPedValorPago();

		$campo = array(
				'fk_status'=>$status,
				'fk_forma'=>$forma,
				'fk_pag'=>$pag,
				'ped_data_pag'=>$datapag,
				'ped_valor_pago'=>$valor_pago
		);
		
		return $this->banco->editar('public.tb_pedidos',$campo, "ped_id = {$id}");
	}
	
	public function CancelarPedido() {
		$idPedido = $this->GetPedId();
		$dados    = $this->GetDadosPedido();
		
		if( ( $dados[0]['fk_status'] == '1' ) or ( $dados[0]['fk_status'] == '2' ) ) {
			$fk_status 	= 5;		
			$campo = array(
						'fk_status' => $fk_status 
						);
		
			return $this->banco->editar('public.tb_pedidos',$campo, "ped_id = '{$idPedido}'");
			return true;
		} else {
			return false;
		}
	}

	public function ValorTotal() {
		$id  = $this->GetPedId();
		$sql = "SELECT tb_pedidos.ped_total+tb_pedidos.ped_valor_frete as ped_total 
					FROM tb_pedidos 
					WHERE( tb_pedidos.ped_id = '".$id."' )";
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	}
	
	public function GetDadosPedido() {
		$id  = $this->GetPedId(); 
		$sql = "SELECT p.fk_usu, 
						p.fk_status, 
						p.ped_total,
						p.ped_valor_frete,
						s.status_nome,
						pro.pro_id
					FROM tb_pedidos p
					INNER JOIN tb_status_pedido s ON s.status_id = p.fk_status 
					INNER JOIN public.tb_carrinho c ON c.fk_sessao = p.ped_sessao
					INNER JOIN public.tb_produtos pro ON pro.pro_id = c.fk_prod
					WHERE( p.ped_id::text = '".$id."'::text )";
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	}

	public function GetDadosPedidoTransId() {
		$transid  = $this->GetPedTransId(); 
		$sql = "SELECT tb_pedidos.fk_usu, 
						tb_pedidos.ped_id, 
						tb_pedidos.fk_status, 
						tb_pedidos.ped_tipo, 
						tb_pedidos.ped_transid, 
						TO_CHAR( tb_pedidos.ord_date, 'DD/MM/YYYY HH:MI' ) as ord_date, 
						tb_pedidos.ped_total,
						tb_pedidos.ped_valor_frete,
						tb_status_pedido.status_nome, 
						tb_usuarios.usu_nome, 
						tb_usuarios.usu_usuario 
					FROM tb_pedidos 
					INNER JOIN tb_status_pedido ON tb_status_pedido.status_id = tb_pedidos.fk_status 
					INNER JOIN tb_usuarios ON usu_doc = tb_pedidos.fk_usu 
					WHERE( tb_pedidos.ped_transid::text = '".$transid."'::text )";
		//echo $sql;
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	}

	public function selecionaPedidos() {
		$sql = "SELECT tb_pedidos.ped_id, 
						tb_pedidos.fk_usu, 
						tb_pedidos.ped_transid, 
						tb_usuarios.usu_nome, 
						tb_usuarios.usu_usuario 
					FROM tb_pedidos 
					INNER JOIN tb_usuarios ON tb_usuarios.usu_doc = tb_pedidos.fk_usu 
					ORDER BY ped_id ASC";
		
		$res = $this->banco->executar( $sql );
		
		return $res;	
	}
	
	public function inserePedidoConsultor() {
		session_regenerate_id();
		
		//echo "<pre>"; print_r( $_SESSION ); echo "</pre>"; die;
		ksort( $_SESSION['carrinho'] );
		$usu 		= $_SESSION['usuario']['usu_doc'];		
		//$cod 		= $dados['pedido']['fk_bonus'];
		
		$transid	= $this->Transid($usu);
		
		$ip = Controller::$ip;
		$browser = Controller::$browser;
		
		$valorTotal = 0;
        foreach( $_SESSION['carrinho'] as $key => $valorCarrinho ) {
			$valorTotal += ( $valorCarrinho['qtd'] * $valorCarrinho['carac_valor'] );
		}
		
		$endereco = array( 'end_cep' 		=> str_replace( '-', '', $_POST['cep'] ),
				'end_end' 		=> $_POST['endereco'],
				'end_n' 		=> $_POST['numero'],
				'end_comp' 		=> $_POST['complemento'],
				'end_bairro' 	=> $_POST['bairro'],
				'end_cidade' 	=> $_POST['cidade'],
				'end_uf' 		=> $_POST['estado'],
				'fk_sessao' 	=> session_id() );
		
		$idEndereco = $this->banco->inserir('public.tb_endereco_pedido',$endereco,'tb_endereco_pedido_end_id_seq');
		
		$pedido = array('fk_usu'=>$usu,
						'ped_transid'=>$transid, 
						'ped_sessao'=>session_id(),
						'ped_ip'=>$ip,
						'fk_status'=>2,
						'ped_total'=>$valorTotal,
						'ped_browser'=>$browser, 
						'ped_tipo'=>$valorCarrinho['fk_tipo'], 
						'ped_valor_frete'	=> $_SESSION['freteCarrinho'] 
						);
	
		$npedido = $this->banco->inserir('public.tb_pedidos',$pedido,'tb_pedidos_ped_id_seq');
		
		$ped = array(
						'valor' => $valorTotal+$_SESSION['freteCarrinho'],
						'transid' => $transid
			);
			
		//Registra no Meio de Pagamento para gerar o boleto	
		$this->meiopg = new MeioPagamento;
		$this->meiopg->gera_boleto($ped);
		
        foreach( $_SESSION['carrinho'] as $key => $valorCarrinho ) {
        	
			$valorTotal += ( $valorCarrinho['qtd'] * $valorCarrinho['carac_valor'] );
			
			$carrinho = array('fk_prod'=>$valorCarrinho['pro_id'],
					'cart_valor'=>$valorCarrinho['carac_valor'], 
					'cart_qtd'=>$valorCarrinho['qtd'], 
					'fk_sessao'=>session_id(), 
					'cart_pontos'=> $valorCarrinho['bn_pontos'],
					'fk_carac'=> $valorCarrinho['carac_id']
					);
			
			unset( $_SESSION['carrinho'][$key] );
			
			$this->banco->inserir('tb_carrinho',$carrinho);
			
			
		}
	
		session_regenerate_id();
		
		return $npedido;
	}
}
