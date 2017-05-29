<?php

class ContaCorrente extends TbContaCorrente {
	
	public $usuario;
    public static $usu;
    public static $usu_seguranca; 
    public static $usuTransf_valid;
    public static $valTransf_valid;


	public function __construct() {
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function contacorrente() {
		$this->SetFkUsuDoc( $_SESSION['usuario']['usu_doc'] );
		$res['contacorrente'] = $this->verificaContaUsuExiste();
		return $res;
	}
	
	public function search($filtros) {
		return $this->ListarHistorico($filtros);
	}

	public function searchBonus($filtros) {
		return $this->ListarHistoricoBonus($filtros);
	}
	
	public function historico()
	{
		return false;
	}
	
	public function saque()
	{
		$usu = $_SESSION['usuario']['usu_doc'];
		$this->SetFkUsuDoc( $usu );
		$conta = $this->verificaContaUsuExiste();
		
		$card = ($this->banco->ValidaRegistro('public.tb_card','card_id',"fk_usu = '{$usu}'"))?'sim':'nao';
		//echo '<pre>';print_r($conta);die;
		
		return array(
					'card' => $card,
					'dados' => $conta
					);
	}
	
	public function saque_ajax()
	{
		$this->usuario = new Usuario;
		
		$usu = $_SESSION['usuario']['usu_doc'];
		$senha = $this->usuario->Password($_POST['senha']);

		if($this->banco->ValidaRegistro('public.tb_usuarios','usu_id',"usu_doc = '{$usu}' AND usu_seguranca = '{$senha}'"))
		{
			$this->SetFkUsuDoc( $usu );
			$conta = $this->verificaContaUsuExiste();
			
			if($conta['saldo']['disponivel'] >= $_POST['valor'])
			{
			
				$valor = $_POST['valor']-3;
			
				$this->banco->inserir('banco.tb_movimento',array(
															'fk_conta_corrente' => $conta['numero'],
															'fk_tipo_movimento' => 8,
															'fk_status_movimento' => 2,
															'mvm_valor' =>$valor,
															'fk_usu' => $usu
																));
																
											
				//$query = "UPDATE banco.tb_saldo SET sld_valor_debito = ".$valor." WHERE fk_conta_corrente = '{$conta['numero']}'";
				
				$this->saldo_atual($conta['numero']);
				
				$this->AddTaxaAdm($conta['numero'],$usu);
				$this->DebTaxaAdm($conta['numero'],$usu);
				
				//echo $query;die;
									
				//$this->banco->executar($query);
				
				$res = array();
				
				$saque = array(
							'fk_usu' => $usu,
							'sc_valor' =>$valor
								);
				
				$id = $this->banco->inserir('financeiro.tb_saque', $saque, 'financeiro.tb_saque_sc_id_seq');
				
				$this->SetFkUsuDoc( $usu );
				$conta_res = $this->verificaContaUsuExiste();
				
				
				
				return array('template' => 'null',
						'saldo' => $conta_res['saldo']['disponivelReal'],
						'msg' =>'Sua solicitação de Saque foi executada com sucesso. <br><strong>ID de Solicitação:'.$id.'<strong>',
						'retorno' => 'sim'
						);
					
			}else{
				
				return array('template' => 'null',
					'msg' =>'Sua solicitação de saque é maior que o valor disponível.',
					'retorno' => 'nao'
					);
				
			}
			
		}else{
		
	
		return array('template' => 'null',
					'msg' =>'Senha de Segurança incorreta.',
					'retorno' => 'nao'
					);
					
		}
	}

	public function historico_ajax()
	{
		$this->SetFkUsuDoc( $_SESSION['usuario']['usu_doc'] );
		$conta = $this->verificaContaUsuExiste();
		$filtros['contacorrente'] = $conta['numero'];
		$filtros['dataInicio'] = $_REQUEST['dataInicio'];
		$filtros['dataFim'] = $_REQUEST['dataFim'];
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
		
		$res = $this->search($filtros);
		
		$ret['historico'] = $res;
		//echo "<pre>"; print_r($ret['historico']); die;
		return $ret;
	}
	
	public function historico_bonus()
	{
		
	}

	public function historico_bonus_ajax()
	{
		$this->SetFkUsuDoc( $_SESSION['usuario']['usu_doc'] );
		$conta = $this->verificaContaUsuExiste();
		$filtros['contacorrente'] = $conta['numero'];
	
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

		$res = $this->searchBonus($filtros);
		
		$ret['historicoBonus'] = $res;
		
		return $ret;
	}
	
	public function pagarpedidos() {
		if( isset( $_POST['pagar'] ) and !empty( $_POST['pagar'] ) ) {
			$dados = array();
			$pedido = new Pedido;
			$pedido->SetPedTransId($_POST['transid']);
			$res = $pedido->GetDadosPedidoTransId();
			
			$dados['pedido'] = $res;
			
			$valor_real = $dados['pedido']['0']['ped_total']+$dados['pedido']['0']['ped_valor_frete'];
							
			$conta = $this->contacorrente();
			
			$saldo = new Saldo;
			$saldo->SetFkContaCorrente($conta['contacorrente']['numero']);
			$res = $saldo->getSaldo();
	
			$dados['saldo']['disponivel'] = $res['disponivel'];
			$dados['saldo']['disponivelReal'] = $res['disponivelReal'];
			
			$saldoBonus = new SaldoBonus;
			$saldoBonus->SetFkContaCorrente($conta['contacorrente']['numero']);
			$res = $saldoBonus->getSaldoBonus();
			
			$dados['saldoBonus']['disponivel'] = $res['disponivel'];
			$dados['saldoBonus']['disponivelReal'] = $res['disponivelReal'];
			
			if( !empty( $dados['pedido'] ) ) {
				if( ( $dados['pedido']['0']['fk_status'] == '1' ) or ( $dados['pedido']['0']['fk_status'] == '2' ) ) {
					if( ( $dados['saldo']['disponivel'] + $dados['saldoBonus']['disponivel'] ) >= $valor_real ) {
						$pagamento = new Pagamento;
						$pagamento->PagarManual();
						
						if( $dados['saldoBonus']['disponivel'] == 0 ) {
							$saldoBonus = $dados['saldoBonus']['disponivel'];
							$valorDebitoSaldoBonus = 0;
							$saldo = $dados['saldo']['disponivel'] - $valor_real;
							$valorDebitoSaldo = $valor_real;
						} elseif( $valor_real > $dados['saldoBonus']['disponivel'] ) {
							$saldoBonus = 0;
							$valorDebitoSaldoBonus = $dados['saldoBonus']['disponivel'];
							$diferenca = $valor_real - $valorDebitoSaldoBonus;
							$saldo = $dados['saldo']['disponivel'] - $diferenca;
							$valorDebitoSaldo = $diferenca;
						} else {
							$saldoBonus = $dados['saldoBonus']['disponivel'] - $valor_real;
							$valorDebitoSaldoBonus = $valor_real;
							$saldo = $dados['saldo']['disponivel'];
							$valorDebitoSaldo = 0;
						}
						
						if( $valorDebitoSaldoBonus > 0 ) {
							$movimentoBonus = new MovimentoBonus;
							$dadosBonus = array( 'fk_conta_corrente' => $conta['contacorrente']['numero'], 
													'fk_tipo_movimento' => '16', 
													'fk_status_movimento' => '2', 
													'mvm_data' => 'now()', 
													'mvm_valor' => $valorDebitoSaldoBonus );
							$movimentoBonus->insereMovimento( $dadosBonus );
							
							$saldoBonus = new SaldoBonus;
							$saldoBonus->SetFkContaCorrente( $conta['contacorrente']['numero'] );
							$saldoBonus->SetSldValorDebito( $valorDebitoSaldoBonus );
							$saldoBonus->insereSaldoDebito();
						}
						
						if( $valorDebitoSaldo > 0 ) {
							$movimento = new Movimento;
							$dadosSaldo = array( 'fk_conta_corrente' => $conta['contacorrente']['numero'], 
													'fk_tipo_movimento' => '4', 
													'fk_status_movimento' => '2', 
													'mvm_data' => 'now()', 
													'mvm_valor' => $valorDebitoSaldo,
													'fk_ped' => $dados['pedido']['0']['ped_id'],
													'fk_usu' => $dados['pedido']['0']['fk_usu'] );
							$movimento->insereMovimento( $dadosSaldo );

							
				
						}
						
						$this->banco->editar('public.tb_pedidos',array('fk_forma' => 2), "ped_transid = '{$pedido->GetPedTransId()}'");
						
						//$this->AddTaxaAdm($conta['contacorrente']['numero']);
						//$this->DebTaxaAdm($conta['contacorrente']['numero']);
						
						$this->saldo_atual($conta['contacorrente']['numero']);
						$this->saldo_atual_bonus($conta['contacorrente']['numero']);
						
						
						$dados['pagou'] = true;
					} else {
						$dados['pagou'] = false;
					}
				} else {
					$dados['pagou'] = false;
				}
			} else {
				$dados['pagou'] = false;
			}			

			return $dados;
		}
	}
	
	public function pagarpedidos_ajax() {
		
		$this->usuario = new Usuario;
		$senha = $this->usuario->Password($_REQUEST['senha']);
		$usuario = $_REQUEST['usuario'];
		
		//echo 'senha: '.$_REQUEST['senha'];die;
		
		if($this->banco->ValidaRegistro('tb_usuarios', 'usu_id', "usu_seguranca = '{$senha}' AND usu_usuario = '{$usuario}'"))
		{
			
		
		$dados = array();
		$pedido = new Pedido;
		$pedido->SetPedTransId($_REQUEST['transid']);
		$res = $pedido->GetDadosPedidoTransId();
		
		
		$dados['pedido'] = $res;
			
		$conta = $this->contacorrente();
			
		$saldo = new Saldo;
		$saldo->SetFkContaCorrente($conta['contacorrente']['numero']);
		$res = $saldo->getSaldo();
			
		$dados['saldo']['disponivel'] = $res['disponivel'];
		$dados['saldo']['disponivelReal'] = $res['disponivelReal'];
			
		$saldoBonus = new SaldoBonus;
		$saldoBonus->SetFkContaCorrente($conta['contacorrente']['numero']);
		$res = $saldoBonus->getSaldoBonus();
			
		$dados['saldoBonus']['disponivel'] = $res['disponivel'];
		$dados['saldoBonus']['disponivelReal'] = $res['disponivelReal'];
		
		if($dados['pedido'][0]['ped_tipo'] == 6 OR $dados['pedido'][0]['ped_tipo'] == 4)
		{
			//echo 'aqui';
			
			$dados['saldo_total'] = $dados['saldoBonus']['disponivel']+$dados['saldo']['disponivel'];
			
		}else{
			//echo 'erro';
			$dados['saldo_total'] = $dados['saldo']['disponivel'];
		}
		//print_r($dados);die;
		return $dados;
		}else{return false;}
	}
	
	public function transferencia(){     
    //echo "<pre>"; print_r($_POST); die;
	
	$usu = $_SESSION['usuario']['usu_doc'];
		$this->SetFkUsuDoc( $usu );
		$conta = $this->verificaContaUsuExiste();
		
		//echo '<pre>';print_r($conta);die;
		
		
		return array(
					'dados' => $conta
					);
   
	  } 
	  
	  public function transferencia_ajax()
	  {
	  //echo '<pre>';print_r($_POST);die;
	  	$this->usuario = new Usuario;
		
		$usu = $_SESSION['usuario']['usu_doc'];
		$senha = $this->usuario->Password($_POST['senha']);

		if($this->banco->ValidaRegistro('public.tb_usuarios','usu_id',"usu_doc = '{$usu}' AND usu_seguranca = '{$senha}' AND usu_usuario != '{$_POST['usu']}'"))
		{
			
			
			if($this->banco->ValidaRegistro('public.tb_usuarios','usu_id',"usu_usuario = '{$_POST['usu']}'"))
		{
			
			$this->SetFkUsuDoc( $usu );
			$conta = $this->verificaContaUsuExiste();
			$cred = $this->banco->ver('public.tb_usuarios','usu_doc', "usu_usuario = '{$_POST['usu']}'");
			
			if($conta['saldo']['disponivel'] >= $_POST['valor'])
			{
			
				$valor = $_POST['valor']-3;
				
				$this->banco->inserir('banco.tb_movimento',array(
															'fk_conta_corrente' => $conta['numero'],
															'fk_tipo_movimento' => 6,
															'fk_status_movimento' => 2,
															'mvm_valor' =>$valor,
															'fk_usu' => $cred['usu_doc']
																));
											
				//$query1 = "UPDATE banco.tb_saldo SET sld_valor_debito = ".$conta['saldo']['debito']."+".$valor." WHERE fk_conta_corrente = '{$conta['numero']}'";
				//echo $query;die;
				//$this->banco->executar($query1);
				
				
				
				$this->AddTaxaAdm($conta['numero'],$usu);
				$this->DebTaxaAdm($conta['numero'],$cred['usu_doc']);
				
				$this->saldo_atual($conta['numero']);
				
				
				
//				print_r($cred);die;
				$this->SetFkUsuDoc( $cred['usu_doc'] );
				$conta_cred = $this->verificaContaUsuExiste();
				
				$this->banco->inserir('banco.tb_movimento',array(
															'fk_conta_corrente' => $conta_cred['numero'],
															'fk_tipo_movimento' => 7,
															'fk_status_movimento' => 2,
															'mvm_valor' =>$valor,
															'fk_usu' => $usu
																));
											
				//$query = "UPDATE banco.tb_saldo SET sld_valor_credito = ".$conta['saldo']['credito']."+".$valor." WHERE fk_conta_corrente = '{$conta_cred['numero']}'";
				
				//echo $query;die;
									
				//$this->banco->executar($query);
				$this->saldo_atual($conta_cred['numero']);
				
				$this->SetFkUsuDoc( $usu );
				$conta_res = $this->verificaContaUsuExiste();
				
			return array('template' => 'null',
						'saldo' => $conta_res['saldo']['disponivelReal'],
						'msg' =>'Sua Transferência foi executada com sucesso.',
						'retorno' => 'sim'
						);
						
					
			}else{
				
				return array('template' => 'null',
					'msg' =>'Sua solicitação de saque é maior que o valor disponível.',
					'retorno' => 'nao'
					);
				
			}
			
		}else{
		
	
		return array('template' => 'null',
					'msg' =>'Usuário Não Existe.',
					'retorno' => 'nao'
					);
					
		}
		
		}else{
		
	
		return array('template' => 'null',
					'msg' =>'Senha de Segurança incorreta ou Usuário Inválido.',
					'retorno' => 'nao'
					);
					
		}
		
		
		//echo '<pre>';print_r($_POST);die;
	  
	  }
	  
	  
		public function saldoAtual_ajax(){
			foreach ($this->getSaldoAtual_ajax() as $saldo){}
			  echo number_format($saldo['total'],2,",",".");	
			  
			  return array("template"=>"saldoAtual_ajax");	
		}
		
		
      
}