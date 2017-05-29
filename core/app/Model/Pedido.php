<?php 

class Pedido extends TbPedidos 
{
	//public $banco;
	public $pagamento;
	public $carrinhoVoucher;
	public $id_ped;
	
	
	/* public function __construct($db='mmn') {
		if( $db ) {
			$this->banco = Banco::conecta('pgsql',$db);	
		}
	} */
	
	public function desconecta() {
		Banco::desconecta_pgsql();
	}
	
	public function adm_listar_p() {
      return false;
	}
	
	public function adm_listar_ajax() {
		$fkUsu = $this->GetFkUsu();
		switch( $_REQUEST['action'] ) {
			case 'cancelar':
				$this->SetPedId($_REQUEST['idPedido']);
				$cancelar = $this->CancelarPedido();
				if( $cancelar ) {
					$resPgto['msg']['action'] = 'success';
					$resPgto['msg']['textAttention'] = 'SUCESSO! - ';
					$resPgto['msg']['text'] = 'Pedido cancelado.';
				} else {
					$resPgto['msg']['action'] = 'error';
					$resPgto['msg']['textAttention'] = 'ERRO! - ';
					$resPgto['msg']['text'] = 'Pedido NÃO pode ser cancelado.';
				}
				break;
			case 'pagarManual':
				$this->pagamento = new Pagamento;
				$resPgto = $this->pagamento->PagarManual();
				break;
		}
	
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
		$filtros['fk_usu'] = ( !empty( $fkUsu ) ) ? $fkUsu : '';
	
		$this->pedidos = new TbPedidos;
		$res = $this->pedidos->Search($filtros,"('2','3')");
	
		$retorno = array('pedidos'=>$res, "template"=>"adm_listar_p_ajax", 'resPgto'=>$resPgto );
	
		return $retorno;
	}

	public function adm_listar_p_ajax() {

		$fkUsu = $this->GetFkUsu();
		switch( $_REQUEST['action'] ) {
			case 'cancelar':
					$this->SetPedId($_REQUEST['idPedido']);
					$cancelar = $this->CancelarPedido();
					if( $cancelar ) {
						$resPgto['msg']['action'] = 'success';
						$resPgto['msg']['textAttention'] = 'SUCESSO! - ';
						$resPgto['msg']['text'] = 'Pedido cancelado.';
					} else {
						$resPgto['msg']['action'] = 'error';
						$resPgto['msg']['textAttention'] = 'ERRO! - ';
						$resPgto['msg']['text'] = 'Pedido NÃO pode ser cancelado.';
					}
				break;
			case 'pagarManual':
					$this->pagamento = new Pagamento;
					$resPgto = $this->pagamento->PagarManual();
				break;
		}
		
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
		$filtros['fk_usu'] = ( !empty( $fkUsu ) ) ? $fkUsu : '';

		$this->pedidos = new TbPedidos;				
		$res = $this->pedidos->Search($filtros,"('1','2','3','4','5','6','7')");
		
		if( isset($_POST['acao'] ) == "alt_cd" ) {

		    $dados = array("fk_status_cd" => 3 );
		    $this->banco->editar("public.tb_pedidos", $dados, "ped_id = '".$_POST['id']."'");
			
			$baixa = $this->baixa_estoque_cd($_POST['id']);			
			
			$this->pedidos = new TbPedidos;				
		    $res = $this->pedidos->Search($filtros,"('1','2','3','4','5','6','7')");

			return array('pedidos'=>$res, "template"=>"adm_listar_p_ajax","baixa"=>$baixa );
		}

		$retorno = array('pedidos'=>$res, "template"=>"adm_listar_p_ajax", 'resPgto'=>$resPgto );
		
		return $retorno;
	}
   
   public function baixa_estoque_cd($id_ped){
   
   
   
   }


   public function modal_pedido_carrinho(){	
	
	if( $_POST['acao'] == "resCar" ) {
			
		$query = $this->banco->executar("
			SELECT 
				prod.pro_nome as nome,
				SUM(car.cart_qtd * car.cart_valor) as total,
				car.fk_prod as codigo,
				car.cart_qtd as qtd
			FROM 
				public.tb_pedidos as ped,
				public.tb_carrinho as car,
				public.tb_produtos as prod
			WHERE
				ped.ped_id = '".$_POST['valor']."' AND
				car.fk_sessao = ped.ped_sessao AND
				prod.pro_id::text = car.fk_prod::text
			GROUP BY
				prod.pro_nome,
				car.cart_qtd,
				car.cart_valor,
				car.fk_prod"); 
	      
		  
		  //echo "<pre>"; print_r($query); die;
		  
		  
	return array("template"=>"ajax/modal_pedido_carrinho", 'res'=>$query );
	
	} 
   }

	public function alterar_status_cd() {
		
	if( $_POST['acao'] == "alt_cd" ) {
			
		$fkUsu = $this->GetFkUsu();
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
		$filtros['fk_usu'] = ( !empty( $fkUsu ) ) ? $fkUsu : '';
		
		//echo "<pre>"; print_r( $filtros ); die;
		
		$this->pedidos = new TbPedidos;				
		$res = $this->pedidos->Search($filtros,"('2','3','4','5','6','7')");
		
		$dados = array("fk_status_cd" => 3 );
		$this->banco->editar("public.tb_pedidos", $dados, "ped_id = '".$_POST['id']."'");
	
		return array('pedidos'=>$res, "template"=>"adm_listar_p_ajax");
			
		}	
		
	}
	
	
	public function adm_listar_c() {
		return false;
	}
	
	public function adm_listar_c_ajax() {
		$fkUsu = $this->GetFkUsu();
		switch( $_REQUEST['action'] ) {
			case 'cancelar':
					$this->SetPedId($_REQUEST['idPedido']);
					$cancelar = $this->CancelarPedido();
					if( $cancelar ) {
						$resPgto['msg']['action'] = 'success';
						$resPgto['msg']['textAttention'] = 'SUCESSO! - ';
						$resPgto['msg']['text'] = 'Pedido cancelado.';
					} else {
						$resPgto['msg']['action'] = 'error';
						$resPgto['msg']['textAttention'] = 'ERRO! - ';
						$resPgto['msg']['text'] = 'Pedido NÃO pode ser cancelado.';
					}
				break;
			case 'pagarManual':
					$this->pagamento = new Pagamento;
					$resPgto = $this->pagamento->PagarManual();
				break;
		}
		
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
		$filtros['fk_usu'] = ( !empty( $fkUsu ) ) ? $fkUsu : '';

		$this->pedidos = new TbPedidos;				
		$res = $this->pedidos->Search($filtros,"('1')");
		
		$retorno = array('pedidos'=>$res, 'template'=>'adm_listar_c_ajax', 'resPgto'=>$resPgto );
		
		return $retorno;
	}
	
	public function adm_listar_v() {
		return false;
	}

	public function adm_listar_v_ajax() {
		$this->carrinhoVoucher = new TbCarrinhoVoucher;
		
		//echo "<pre>"; print_r( $_REQUEST ); echo "</pre>";
		switch( $_REQUEST['action'] ) {
			case 'cancelar':
					$this->carrinhoVoucher->SetVoucherId($_REQUEST['idPedido']);
					$cancelar = $this->carrinhoVoucher->CancelarVoucher();
					if( $cancelar ) {
						$resPgto['msg']['action'] = 'success';
						$resPgto['msg']['textAttention'] = 'SUCESSO! - ';
						$resPgto['msg']['text'] = 'Voucher cancelado.';
					} else {
						$resPgto['msg']['action'] = 'error';
						$resPgto['msg']['textAttention'] = 'ERRO! - ';
						$resPgto['msg']['text'] = 'Voucher NÃO pode ser cancelado.';
					}
				break;
			case 'pagarManual':
					$this->pagamento = new Pagamento;
					$resPgto = $this->pagamento->PagarManual();
				break;
		}
		
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

		$res = $this->carrinhoVoucher->Search($filtros);
		$retorno = array('voucher'=>$res,"template"=>"adm_listar_v_ajax", 'resPgto'=>$resPgto );
		
		return $retorno;
	}
	
	/** 
		BUSCA OS DADOS DE UM PEDIDO DE UM DETERMINADO USUÁRIO
		$idUsu é o id do usuario
		$status, se NULL busca todos pedidos, ou o status definido no parâmetro
		$transId, se NULL busca todos pedidos, ou o pedido selecionado
		retorna um array com os dados do pedido
	 */
	public function getPedido( $idUsu, $status=NULL, $transId=NULL ) {
		if( $idUsu ) {
			$sql = "SELECT * 
						FROM tb_pedidos 
						WHERE( tb_pedidos.fk_usu = '".$idUsu."' ) ";
			if( $status ) {
				$sql .= " AND ( tb_pedidos.fk_status = '".$status."' )";
			}
			
			if( $transId ) {
				$sql .= " AND ( tb_pedidos.ped_transid = '".$transId."' )";
			}
			
			$ver = $this->banco->conexao->prepare($sql);
			$ver->execute();
			$res = $ver->fetchAll(PDO::FETCH_ASSOC);
				
			return $res;		
		} else {
			return false;	
		}
	}
	
	public function admGetProcessarArquivo($dados) {
		$sql = "SELECT * 
					FROM tb_retorno 
					WHERE( ret_nome_cliente = '".$dados['nome_cliente']."') AND 
							( ret_processado = '1' )";
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	}
						
	public function admUploadArquivoRetorno($dados) {
		
		//$this->banco = Banco::conecta('pgsql',$db);
		
		$sql = "INSERT INTO tb_retorno ( ret_path, ret_file_name, ret_data_upload, ret_nome_cliente, ret_total_linhas )
						VALUES( '".$dados['targetPath']."', '".$dados['file_name']."', '".$dados['data_upload']."', '".$dados['cliente']."', ".$dados['total_linhas']."  )";
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
	}
	
	public function gravaProcessamentoBoleto($id, $count) {
		$sql = 'UPDATE tb_retorno SET ret_linhas_processadas = '.$count.' WHERE ( ret_id = '.$id.' )';
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$sql = 'SELECT ret_total_linhas, 
						ret_linhas_processadas 
					FROM tb_retorno  
					WHERE ( ret_id = '.$id.' )';
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);
		if( $res[0]['ret_total_linhas'] == $count ) {
			$sql = "UPDATE tb_retorno SET ret_processado = '2', ret_data_processamento = '".date('Y-m-d H:i:s')."' WHERE ( ret_id = ".$id." )";
			$ver = $this->banco->conexao->prepare($sql);
			$ver->execute();
		}
	}
	
	public function adm_baixaboleto() {
		return false;
	}

	public function adm_baixaboleto_ajax() {
		
		switch( $_REQUEST['action'] ) {
			case 'processar':
					$execajax = $this->admProcessarArquivo($_REQUEST['id']);
				break;
			case 'cancelar':
					$execajax = $this->admCancelarProcessamento($_REQUEST['id']);
				break;
			case 'excluir':
					$execajax = $this->admExcluirArquivo($_REQUEST['id']);
				break;			
			default:
					$execajax = false;
				break;
		}
		
		if( $_REQUEST['pagina'] > 1 ) {
			$offset = ( ( $_REQUEST['pagina'] * $_REQUEST['regpag'] ) - $_REQUEST['regpag'] );
		} else {
			$offset = 0;
		}
		
		$sql = "SELECT tb_retorno.ret_id, 
						to_char(tb_retorno.ret_data_upload, 'DD/MM/YYYY') AS data_upload, 
						to_char(tb_retorno.ret_data_processamento, 'DD/MM/YYYY HH:MM:SS') AS data_processamento, 
						tb_retorno.ret_linhas_processadas, 
						tb_retorno.ret_total_linhas,  
						tb_retorno.ret_processado 
				FROM tb_retorno ";
		
		$sql .=	"ORDER BY tb_retorno.ret_id DESC";
		$limitOffset = "LIMIT ".$_REQUEST['regpag']." OFFSET ".$offset;

		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);		
		
		$sqlPag = "SELECT COUNT(*) AS total 
				FROM tb_retorno";
		
		//$paginacao = $this->baixaboleto_paginacao($sqlPag, $_REQUEST['pagina'], $_REQUEST['regpag']);

		$res = array('arquivos'=>$res, 'paginacao'=>$paginacao, 'sql'=>$sql, 'msg'=>$execajax );

		return $res;
	}
	
	function adm_baixaboleto_paginacao($sql=null,$pagina=1, $regpag=10) {

		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);
		
		$totalRegistros = $res[0]['total'];
		if( $totalRegistros > 0 ) {
			$totalPaginas = ceil( $totalRegistros / $regpag );
			$totalPagina = ( $pagina * $regpag );
			$totalPagina = ( $totalPagina < $totalRegistros ) ? $totalPagina : $totalRegistros;

			if( $_REQUEST['pagina'] > 1 ) {
				$offset = ( ( $_REQUEST['pagina'] * $_REQUEST['regpag'] ) - $_REQUEST['regpag'] );
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

	public function admCancelarProcessamento($id=null) {
		if( !empty( $id ) ) {
			if( $id == 'all' ) {
				$sql = "SELECT * FROM tb_retorno 
						WHERE( tb_retorno.ret_processado = '1' ) AND 
								( tb_retorno.ret_linhas_processadas = '0' )
						ORDER BY tb_retorno.ret_id DESC";
	
				$ver = $this->banco->conexao->prepare($sql);
				$ver->execute();
				$res = $ver->fetchAll(PDO::FETCH_ASSOC);
				
				foreach( $res AS $retorno ) {
					$tabela = 'tb_retorno';
					$where = "( ret_id = '".$retorno['ret_id']."' ) AND ( ret_processado = '1' ) AND ( tb_retorno.ret_linhas_processadas = '0' )";
					$update['tb_retorno']['ret_processado'] = '0';
					$this->banco->editar($tabela,$update['tb_retorno'],$where);
				}
			}
		} else {
			$retorno['action'] = 'error';
			$retorno['textAttention'] = 'ERRO! - ';
			$retorno['text'] = 'Solicitação NÃO efetuada.';
		}
		
		return $retorno;
	}

	public function admProcessarArquivo($id=null) {
		if( !empty( $id ) ) {
			if( $id == 'all' ) {
				$sql = "SELECT * FROM tb_retorno 
						WHERE( tb_retorno.ret_processado = '0' )
						ORDER BY tb_retorno.ret_id DESC";
	
				$ver = $this->banco->conexao->prepare($sql);
				$ver->execute();
				$res = $ver->fetchAll(PDO::FETCH_ASSOC);
				
				foreach( $res AS $retorno ) {
					if( file_exists( $_SERVER['DOCUMENT_ROOT'].'/'.$retorno['ret_path'].'/'.$retorno['ret_file_name'] ) ) {
						$tabela = 'tb_retorno';
						$where = "( ret_id = '".$retorno['ret_id']."' ) AND ( ret_processado = '0' )";
						$update['tb_retorno']['ret_processado'] = '1';
						$this->banco->editar($tabela,$update['tb_retorno'],$where);
					}
				}
			} else {
				$sql = "SELECT * FROM tb_retorno 
						WHERE( tb_retorno.ret_id = '".$id."' )";
	
				$ver = $this->banco->conexao->prepare($sql);
				$ver->execute();
				$res = $ver->fetchAll(PDO::FETCH_ASSOC);
				
				if( file_exists( $_SERVER['DOCUMENT_ROOT'].'/'.$res[0]['ret_path'].'/'.$res[0]['ret_file_name'] ) ) {
					$tabela = 'tb_retorno';
					$where = "( ret_id = '{$id}' ) AND ( ret_processado = '0' )";
					$update['tb_retorno']['ret_processado'] = '1';
					if($this->banco->editar($tabela,$update['tb_retorno'],$where)) {
						$retorno['action'] = 'success';
						$retorno['textAttention'] = 'SUCESSO! - ';
						$retorno['text'] = 'Processando arquivo.';
					} else {
						$retorno['action'] = 'error';
						$retorno['textAttention'] = 'ERRO! - ';
						$retorno['text'] = 'Erro no processando do arquivo.';
					}
				} else {
					$retorno['action'] = 'error';
					$retorno['textAttention'] = 'ERRO! - ';
					$retorno['text'] = 'Arquivo NÃO encontrado.';
				}				
			}
		} else {
			$retorno['action'] = 'error';
			$retorno['textAttention'] = 'ERRO! - ';
			$retorno['text'] = 'Solicitação NÃO efetuada.';
		}
		
		return $retorno;
	}
	
	public function admExcluirArquivo($id=null) {
		if( !empty( $id ) ) {
			if( $id == 'all' ) {
				$sql = "SELECT * FROM tb_retorno 
						WHERE( tb_retorno.ret_processado = '0' ) 
						ORDER BY tb_retorno.ret_id DESC";
	
				$ver = $this->banco->conexao->prepare($sql);
				$ver->execute();
				$res = $ver->fetchAll(PDO::FETCH_ASSOC);
				
				foreach( $res AS $retorno ) {					
					if( file_exists( $_SERVER['DOCUMENT_ROOT'].'/'.$retorno['ret_path'].'/'.$retorno['ret_file_name'] ) ) {
						unlink( $_SERVER['DOCUMENT_ROOT'].'/'.$retorno['ret_path'].'/'.$retorno['ret_file_name'] );
					}
					
					$sql = "DELETE FROM tb_retorno 
							WHERE( tb_retorno.ret_id = '".$retorno['ret_id']."' )";
		
					$ver = $this->banco->conexao->prepare($sql);
					$ver->execute();
				}
			} else {
					$sql = "SELECT * FROM tb_retorno 
							WHERE( tb_retorno.ret_id = '".$id."' )";
		
					$ver = $this->banco->conexao->prepare($sql);
					$ver->execute();
					$res = $ver->fetchAll(PDO::FETCH_ASSOC);
					
					if( file_exists( $_SERVER['DOCUMENT_ROOT'].'/'.$res[0]['ret_path'].'/'.$res[0]['ret_file_name'] ) ) {
						unlink( $_SERVER['DOCUMENT_ROOT'].'/'.$res[0]['ret_path'].'/'.$res[0]['ret_file_name'] );
					}
					
					$sql = "DELETE FROM tb_retorno 
							WHERE( tb_retorno.ret_id = '".$id."' )";
		
					$ver = $this->banco->conexao->prepare($sql);
					$ver->execute();
		
					$retorno['action'] = 'success';
					$retorno['textAttention'] = 'SUCESSO! - ';
					$retorno['text'] = 'Arquivo de retorno excluído.';
			}
		} else {
			$retorno['action'] = 'error';
			$retorno['textAttention'] = 'ERRO! - ';
			$retorno['text'] = 'Erro no processamento.';
		}

		return $retorno;
	}
	
	public function inserirPedConsultor() {
		return $this->inserePedidoConsultor();	
	}
    
	
}