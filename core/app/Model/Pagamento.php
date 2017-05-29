<?php 

class Pagamento
{

	public $voucher;
	public $carrinhoVoucher;
	public $comissao;
	public $pedidos;
	public $usuario;
	public $boleto;
	public $pontos;
	public $cron;
// 	public $data = '07_2014';
	public $data;
	
	

	
	public function PagarManual($tipo = NULL, $idpedido=NULL)
	{
		$this->data = date('m_Y');
		
		//$_POST['tipo'] = !empty($tipo) ? $tipo : $_POST['tipo'] ;
		
		$_POST['tipo'] = ($tipo==null)?$_POST['tipo']:$tipo;
		$_POST['idPedido'] = ($idpedido==null)?$_POST['idPedido']:$idpedido;
		
		
		
	switch( $_POST['tipo'] ) {
			case 1:
				$this->pedidos = new Pedido;
				$this->pedidos->SetPedId($_POST['idPedido']);
				$total = $this->pedidos->ValorTotal();
				$dados_pedido = $this->pedidos->GetDadosPedido();
				$this->pedidos->SetFkUsu($dados_pedido[0]['fk_usu']);
				$this->pedidos->SetFkStatus(3);
				$this->pedidos->SetFkForma(1);
				$this->pedidos->SetFkPag(2);
				$this->pedidos->SetPedDataPag('NOW()');
				$this->pedidos->SetPedValorPago($total[0]['ped_total']);
			
				$this->usuario = new Usuario;
					
				$res_usu = $this->usuario->GetDadosUsuario($dados_pedido[0]['fk_usu']);
					
				$res_rede = $this->usuario->UltimoPerna($res_usu['fk_usu'], $res_usu['usu_perna_pref']);
				
				$this->usuario->SetUsuPerna($res_usu['usu_perna_pref']);
				
				$this->usuario->SetFkUsuRede($res_rede);
					
					
				$fk_usu = $res_usu['fk_usu'];
				//$this->usuario->SetUsuPerna($res_usu['usu_perna_pref']);
				$this->usuario->SetFkUsu($fk_usu);
				
				//$res = $this->usuario->rede_bin();
					
				//$this->usuario->SetFkUsuRede($res['usu_doc']);
				$this->usuario->SetFkStatus(2);
				$this->usuario->SetUsuDoc($dados_pedido[0]['fk_usu']);
					
				switch( $dados_pedido[0]['fk_status'] ) {
					case 1:
						
						$res['msg']['action'] = "success";
						$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
						$this->usuario->AtivarUsuario();
						$this->pedidos->PagarPedido();
						
						break;
					case 2:
						
						$res['msg']['action'] = "success";
						$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
						
						
						
						
			
						
			
						$this->pontos = new Pontos;
			
						$pontuacao = $this->pontos->GetPontos($_POST['idPedido']);
						
						$this->pedidos->PagarPedido();
						
						if($pontuacao[0]['cart_pontos'] == 0)
						{
							$this->usuario->AtivarUsuario();
							$this->matriz(3);
						}
			
						if($pontuacao[0]['cart_pontos'] > 0)
						{
							if( !$this->executaComissao(1) ) {
								$res['msg']['action'] = "warning";
								$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou comissionamento";
							}
				
							if( !$this->executaPontuacao(2)) {
								$res['msg']['action'] = "warning";
								$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou pontuação";
							}
							
							
							$this->usuario->banco->editar('public.tb_usuarios', array('fk_bonus' => $dados_pedido[0]['pro_id'])," usu_doc = '{$dados_pedido[0]['fk_usu']}'");
								
						}
						
			
						break;
					case 3:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Pedido já está pago";
						break;
					case 4:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Pedido estornado, não pode ser pago";
						break;
					case 5:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Pedido cancelado, não pode ser pago";
			
						break;
					default:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Status indefinido, não pode ser pago";
						break;
				}
			break;
			case 2:
					$this->pedidos = new Pedido;
					$this->pedidos->SetPedId($_POST['idPedido']);
					$total = $this->pedidos->ValorTotal();
					$dados_pedido = $this->pedidos->GetDadosPedido();
					$this->pedidos->SetFkUsu($dados_pedido[0]['fk_usu']);
					$this->pedidos->SetFkStatus(3);
					$this->pedidos->SetFkForma(1);
					$this->pedidos->SetFkPag(2);
					$this->pedidos->SetPedDataPag('NOW()');
					$this->pedidos->SetPedValorPago($total[0]['ped_total']);
					
					$this->usuario = new Usuario;
					
					$res = $this->usuario->GetDadosUsuario($dados_pedido[0]['fk_usu']);
					$fk_usu = $res['fk_usu'];
					$this->usuario->SetFkUsu($fk_usu);

					switch( $dados_pedido[0]['fk_status'] ) {
						case 1:
								$res['msg']['action'] = "success";
								$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
								$this->pedidos->PagarPedido();
								if( !$this->executaComissao('loja') ) {
									$res['msg']['action'] = "warning";
									$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou comissionamento";
								}
								if( !$this->executaPontuacao('loja')) {
									$res['msg']['action'] = "warning";
									$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou pontuação";
								}
							break;
						case 2:
								$res['msg']['action'] = "success";
								$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
								$this->pedidos->PagarPedido();
								if( !$this->executaPontuacao(2)) {
									$res['msg']['action'] = "warning";
									$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou pontuação";
								}
								
							break;
						case 3:
								$res['msg']['action'] = "error";
								$res['msg']['textAttention'] = "ERRO! - Pedido já está pago";
							break;
						case 4:
								$res['msg']['action'] = "error";
								$res['msg']['textAttention'] = "ERRO! - Pedido estornado, não pode ser pago";
							break;
						case 5:
								$res['msg']['action'] = "error";
								$res['msg']['textAttention'] = "ERRO! - Pedido cancelado, não pode ser pago";

							break;
						default:
								$res['msg']['action'] = "error";
								$res['msg']['textAttention'] = "ERRO! - Status indefinido, não pode ser pago";
							break;	
					}
			break;
			case 3:
				$this->pedidos = new Pedido;
				$this->pedidos->SetPedId($_POST['idPedido']);
				$total = $this->pedidos->ValorTotal();
				$dados_pedido = $this->pedidos->GetDadosPedido();
				$this->pedidos->SetFkUsu($dados_pedido[0]['fk_usu']);
				$this->pedidos->SetFkStatus(3);
				$this->pedidos->SetFkForma(1);
				$this->pedidos->SetFkPag(2);
				$this->pedidos->SetPedDataPag('NOW()');
				$this->pedidos->SetPedValorPago($total[0]['ped_total']);
			
				$this->usuario = new Usuario;
					
				$res = $this->usuario->GetDadosUsuario($dados_pedido[0]['fk_usu']);
				$fk_usu = $res['fk_usu'];
				$this->usuario->SetFkUsu($fk_usu);
			
				switch( $dados_pedido[0]['fk_status'] ) {
					case 1:
						$res['msg']['action'] = "success";
						$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
						$this->pedidos->PagarPedido();
						if( !$this->executaComissao(3) ) {
							$res['msg']['action'] = "warning";
							$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou comissionamento";
						}
						break;
					case 2:
						$res['msg']['action'] = "success";
						$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
						$this->pedidos->PagarPedido();
						if( !$this->executaPontuacao(2)) {
							$res['msg']['action'] = "warning";
							$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou pontuação";
						}
						if( !$this->executaComissao(3) ) {
							$res['msg']['action'] = "warning";
							$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou comissionamento";
						}
						break;
					case 3:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Pedido já está pago";
						break;
					case 4:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Pedido estornado, não pode ser pago";
						break;
					case 5:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Pedido cancelado, não pode ser pago";
			
						break;
					default:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Status indefinido, não pode ser pago";
						break;
				}
				break;
			case 4:
					$this->pedidos = new Pedido;
					$this->pedidos->SetPedId($_POST['idPedido']);
					$total = $this->pedidos->ValorTotal();
					$dados_pedido = $this->pedidos->GetDadosPedido();
					$this->pedidos->SetFkUsu($dados_pedido[0]['fk_usu']);
					$this->pedidos->SetFkStatus(3);
					$this->pedidos->SetFkForma(1);
					$this->pedidos->SetFkPag(2);
					$this->pedidos->SetPedDataPag('NOW()');
					$this->pedidos->SetPedValorPago($total[0]['ped_total']);
				
					$this->usuario = new Usuario;
						
					$res = $this->usuario->GetDadosUsuario($dados_pedido[0]['fk_usu']);
					$fk_usu = $res['fk_usu'];
					$this->usuario->SetFkUsu($fk_usu);
				
					switch( $dados_pedido[0]['fk_status'] ) {
						case 2:
							$res['msg']['action'] = "success";
							$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
							$this->pedidos->PagarPedido();
							
							break;
						case 3:
							$res['msg']['action'] = "error";
							$res['msg']['textAttention'] = "ERRO! - Pedido já está pago";
							break;
						case 4:
							$res['msg']['action'] = "error";
							$res['msg']['textAttention'] = "ERRO! - Pedido estornado, não pode ser pago";
							break;
						case 5:
							$res['msg']['action'] = "error";
							$res['msg']['textAttention'] = "ERRO! - Pedido cancelado, não pode ser pago";
				
							break;
						default:
							$res['msg']['action'] = "error";
							$res['msg']['textAttention'] = "ERRO! - Status indefinido, não pode ser pago";
							break;
					}
			break;
			case 5:
					$this->pedidos = new Pedido;
					$this->pedidos->SetPedId($_POST['idPedido']);
					$total = $this->pedidos->ValorTotal();
					$dados_pedido = $this->pedidos->GetDadosPedido();
					$this->pedidos->SetFkUsu($dados_pedido[0]['fk_usu']);
					$this->pedidos->SetFkStatus(3);
					$this->pedidos->SetFkForma(1);
					$this->pedidos->SetFkPag(2);
					$this->pedidos->SetPedDataPag('NOW()');
					$this->pedidos->SetPedValorPago($total[0]['ped_total']);

					$this->usuario = new Usuario;
					
					$res = $this->usuario->GetDadosUsuario($dados_pedido[0]['fk_usu']);
					$fk_usu = $res['fk_usu'];
					$this->usuario->SetFkUsu($fk_usu);

					switch( $dados_pedido[0]['fk_status'] ) {
						case 1:
								$res['msg']['action'] = "success";
								$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
								$this->pedidos->PagarPedido();
								if( !$this->executaComissao('loja') ) {
									$res['msg']['action'] = "warning";
									$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou comissionamento";
								}
								if( !$this->executaPontuacao('loja')) {
									$res['msg']['action'] = "warning";
									$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou pontuação";
								}
							break;
						case 2:
								$res['msg']['action'] = "success";
								$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
								$this->pedidos->PagarPedido();
								if( !$this->executaComissao(5) ) {
									$res['msg']['action'] = "warning";
									$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou comissionamento";
								}
								if( !$this->executaPontuacao(2)) {
									$res['msg']['action'] = "warning";
									$res['msg']['textAttention'] = "ATENÇÃO! - Pagou mas NÃO gerou pontuação";
								}
							break;
						case 3:
								$res['msg']['action'] = "error";
								$res['msg']['textAttention'] = "ERRO! - Pedido já está pago";
							break;
						case 4:
								$res['msg']['action'] = "error";
								$res['msg']['textAttention'] = "ERRO! - Pedido estornado, não pode ser pago";
							break;
						case 5:
								$res['msg']['action'] = "error";
								$res['msg']['textAttention'] = "ERRO! - Pedido cancelado, não pode ser pago";

							break;
						default:
								$res['msg']['action'] = "error";
								$res['msg']['textAttention'] = "ERRO! - Status indefinido, não pode ser pago";
							break;	
					}
			break;
			case 6:
				$this->pedidos = new Pedido;
				$this->pedidos->SetPedId($_POST['idPedido']);
				$total = $this->pedidos->ValorTotal();
				$dados_pedido = $this->pedidos->GetDadosPedido();
				$this->pedidos->SetFkUsu($dados_pedido[0]['fk_usu']);
				$this->pedidos->SetFkStatus(3);
				$this->pedidos->SetFkForma(1);
				$this->pedidos->SetFkPag(2);
				$this->pedidos->SetPedDataPag('NOW()');
				$this->pedidos->SetPedValorPago($total[0]['ped_total']);
			
				$this->usuario = new Usuario;
					
				$res = $this->usuario->GetDadosUsuario($dados_pedido[0]['fk_usu']);
				$fk_usu = $res['fk_usu'];
				$this->usuario->SetFkUsu($fk_usu);
			
				switch( $dados_pedido[0]['fk_status'] ) {
					case 1:
						$res['msg']['action'] = "success";
						$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
						$this->pedidos->PagarPedido();
						break;
					case 2:
						$res['msg']['action'] = "success";
						$res['msg']['textAttention'] = "SUCESSO! - Pagou pedido";
						$this->pedidos->PagarPedido();
						
						break;
					case 3:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Pedido já está pago";
						break;
					case 4:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Pedido estornado, não pode ser pago";
						break;
					case 5:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Pedido cancelado, não pode ser pago";
			
						break;
					default:
						$res['msg']['action'] = "error";
						$res['msg']['textAttention'] = "ERRO! - Status indefinido, não pode ser pago";
						break;
				}
				break;
			default:
					$res['msg']['action'] = "error";
					$res['msg']['action']['textAttention'] = "ERRO! - Tipo inválido, não pode continuar";
				break;
		}
		
		return $res;
	}
	
	public function matriz($matriz)
	{

		$indicado 	= $this->pedidos->GetFkUsu();	//Quem ta pagando seu cadastro
		
		
		
		$pais = array($this->usuario->GetFkUsu());
		
		$resultado = 1;
		
		while($resultado == 1)
		{
		
			$this->usuario->DerramaRedes($pais, $indicado, $resultado, $matriz);

		};
			
		$this->usuario->banco->inserir('public.tb_rede', $resultado);
		
		return true;
	}
	
	public function executaComissao($tipo)
	{
		$this->data = date('m_Y');
		
		$this->comissao = new Comissao; //instancia classe comissao
		$this->usuario = new Usuario; //instancia classe usuario
		
		$dados_pedido = $this->pedidos->GetDadosPedido(); //busca dados gerais do pedido
		
		$this->pedidos->SetFkStatus($dados_pedido[0]['fk_status']); //busca status do pedido

		$this->comissao->SetCmData( date('Y-m-d H:i:s') ); //armazea a data
		$this->comissao->SetFkPed($this->pedidos->GetPedId()); //armazena o ID do pedido
		$this->comissao->SetFkStatusPagamento(2); //define a comissao como pendente

		$temp = $this->comissao->VerificaExisteTabela($this->data);
		$temp = $this->comissao->VerificaExisteComissao($this->data); //verifica se existe tabela de comissao		

		$rede = array();
		
		switch( $this->pedidos->GetFkStatus() ) {
			case 3:
					if( !$temp ) {
						switch( $tipo ) {
							case 2:
								
								//$percentComissao = $this->comissao->GetPorcentagemComissao($this->pedidos->GetPedId()); //busca porcentagem comissao
								/* $rede = array( 'indicou' => $this->pedidos->GetFkUsu(), 
												'indicado' => $this->pedidos->GetFkUsu() ); */
								
								
								
								$percentComissao = $this->pontos->GetPontos($this->pedidos->GetPedId()); //busca pontos dos produtos
										
										
										
										
										 	
										$this->usuario->GetRedeLinear($rede, $this->pedidos->GetFkUsu() );
										
										unset($rede[0]);
										
										//echo '<pre>'; print_r($percentComissao);die;
											
										foreach( $percentComissao as $key => $value ) {
										
												foreach( $rede as $dadosRede ) {
													
														//if($dadosRede['usu_qualif'] == '1'){
														
														$comissao = (($value['cart_qtd']*$value['cart_pontos'])/100)*$dadosRede['pc_perc'];
														
														if($comissao > 0)
														{
														
															//echo $comissao;die;
															
															try{
																	
															$this->comissao->banco->conexao->beginTransaction();
															
															$this->comissao->SetCmComissao($comissao);
															$this->comissao->SetCmData('now()');
															$this->comissao->SetCmDataPag('now()');
															
															
															
																
															
																$this->comissao->SetFkStatusPagamento('2');
																
																
																$this->comissao->SetFkPed($this->pedidos->GetPedId());
																$this->comissao->SetFkUsuIndicou($dadosRede['usu_doc']);
																$this->comissao->SetFkUsuIndicado($this->pedidos->GetFkUsu());
																$this->comissao->SetCmPercentComissao($dadosRede['pc_perc']);
																
																
																$this->comissao->InsereRegistroComissao($this->data);
																
																$contaCorrente = new ContaCorrente;
																$contaCorrente->SetFkUsuDoc($this->comissao->GetFkUsuIndicou());
																$conta = $contaCorrente->verificaContaUsuExiste();
																	
																//INSERE O MOVIMENTO
																$movimento = new Movimento;
																$dadosMovimento = array('fk_conta_corrente'		=> $conta['numero'],
																		'fk_tipo_movimento'		=> 2,
																		'fk_status_movimento'	=> 2,
																		'mvm_data'				=> 'now()',
																		'mvm_valor'				=> $this->comissao->GetCmComissao(),
																		'fk_ped' => $this->pedidos->GetPedId(),
																		'fk_usu' => $this->pedidos->GetFkUsu()
																);
																
																$movimento->insereMovimento( $dadosMovimento );
																
																//INSERE O SALDO DE MOVIMENTO
																/* $classSaldo = new Saldo;
																$classSaldo->SetFkContaCorrente($conta['numero']);
																$res = $classSaldo->getSaldo();
																$classSaldo->SetSldValorCredito($this->comissao->GetCmComissao());
																$classSaldo->insereSaldoCredito(); */
																
																$contaCorrente->saldo_atual($conta['numero']); //Atualiza a tabela tb_saldo
																
																
															
															
														
															$this->comissao->banco->conexao->commit();
															
															}catch (PDOException $e){
															
																$msg = $e->getMessage();
															
																$this->comissao->banco->conexao->rollBack();
															
																$this->comissao->banco->log($msg);
																	
																return false;
															
															}
													
														}
												}
										}
										
										return true;
										
										
										
									
								
								
								
							break;
							case 1:
								
								//echo $this->pedidos->GetPedId();die;		
						$usu = $this->pedidos->GetFkUsu();

						$percentComissao = $this->comissao->GetPorcentagemComissao($this->pedidos->GetPedId()); //busca porcentagem comissao
						$fk_usu = $this->usuario->banco->executar("SELECT u.fk_usu, uu.fk_bonus FROM public.tb_usuarios u 
																		INNER JOIN public.tb_usuarios uu ON u.fk_usu = uu.usu_doc 
																		WHERE u.usu_doc = '{$usu}'");
						
						if($fk_usu[0]['fk_bonus'] != 1)
						{
							
							$fk_usu = $fk_usu[0]['fk_usu'];
							$this->comissao->SetCmDataPag('now()');
							$this->comissao->SetFkStatusPagamento('2');
							foreach( $percentComissao as $key => $value ) {
								$this->comissao->SetCmPercentComissao($value['bn_cad_perc']); //armazena porcentagem da comissao
								//$this->comissao->SetCmComissao($this->comissao->CalculaComissao($this->pedidos->GetPedValorPago(), $percentComissao[$key]['bn_cad_perc'] )); //calcula e SET valor da comissao
								$valorTotalProduto = $value['cart_qtd']*$value['cart_valor'];
								$comissao_80 = (($valorTotalProduto/100)*10);
								$comissao_20 = ((($valorTotalProduto/100)*10)/100)*20;
								
								$this->comissao->SetCmComissao($comissao_80); //calcula e SET valor da comissao
								//echo '<pre>Rede: ';print_r($rede);
	
									$this->comissao->SetFkUsuIndicou($fk_usu); //armazena usuario que indicou
									$this->comissao->SetFkUsuIndicado($this->pedidos->GetFkUsu()); //armazena usuario indicado
									$this->comissao->InsereRegistroComissao(date('m_Y'));
									$contaCorrente = new ContaCorrente;
									$contaCorrente->SetFkUsuDoc($this->comissao->GetFkUsuIndicou());
									$conta = $contaCorrente->verificaContaUsuExiste();
									//INSERE O MOVIMENTO
									$movimento = new Movimento;
									$dadosMovimento = array('fk_conta_corrente'		=> $conta['numero'],
															'fk_tipo_movimento'		=> 2, 
															'fk_status_movimento'	=> 2,
															'mvm_data'				=> 'now()',
															'mvm_valor'				=> $this->comissao->GetCmComissao(),
															'fk_ped' => $this->pedidos->GetPedId(),
															'fk_usu' => $this->pedidos->GetFkUsu()
														);
									$movimento->insereMovimento( $dadosMovimento );
		
									//INSERE O SALDO DE MOVIMENTO
									$classSaldo = new Saldo;
									$classSaldo->SetFkContaCorrente($conta['numero']);
									$res = $classSaldo->getSaldo();
									$classSaldo->SetSldValorCredito($this->comissao->GetCmComissao());
									$classSaldo->insereSaldoCredito();
									
									$dadosMovimento = array('fk_conta_corrente'		=> $conta['numero'],
															'fk_tipo_movimento'		=> 13,
															'fk_status_movimento'	=> 2,
															'mvm_data'				=> 'now()',
															'mvm_valor'				=> $comissao_20,
															'fk_usu' 				=> $this->pedidos->GetFkUsu(),
															'fk_ped' 				=> $this->pedidos->GetPedId()
														);
									$movimento->insereMovimento( $dadosMovimento );
									
									$contaCorrente->atualiza_saldo_anterior($conta['numero']);
								
							}
							
							
							$rede_matriz = $this->usuario->GetUpRede( 9, $this->pedidos->GetFkUsu() );
							
							$total_matriz = (($comissao_20/100)*40)/10;
							
							$this->comissao->SetCmDataPag('now()');
							$this->comissao->SetFkStatusPagamento('2');
							$this->comissao->SetCmPercentComissao('4');
							$this->comissao->SetCmComissao($total_matriz);
							
							foreach($rede_matriz as $matriz)
							{
								
								$this->comissao->SetFkUsuIndicou($matriz['indicou']); //armazena usuario que indicou
								$this->comissao->SetFkUsuIndicado($this->pedidos->GetFkUsu()); //armazena usuario indicado
								$this->comissao->InsereRegistroComissao(date('m_Y'));
								
								
								
								$contaCorrente->SetFkUsuDoc($matriz['indicou']);
								$conta = $contaCorrente->verificaContaUsuExiste();
									//INSERE O MOVIMENTO
									$movimento = new Movimento;
									$dadosMovimento = array('fk_conta_corrente'		=> $conta['numero'],
															'fk_tipo_movimento'		=> 14, 
															'fk_status_movimento'	=> 2,
															'mvm_data'				=> 'now()',
															'mvm_valor'				=> $this->comissao->GetCmComissao(),
															'fk_ped' => $this->pedidos->GetPedId(),
															'fk_usu' => $this->pedidos->GetFkUsu()
														);
									$movimento->insereMovimento( $dadosMovimento );
		
									//INSERE O SALDO DE MOVIMENTO
									
									$classSaldo->SetFkContaCorrente($conta['numero']);
									$res = $classSaldo->getSaldo();
									$classSaldo->SetSldValorCredito($this->comissao->GetCmComissao());
									$classSaldo->insereSaldoCredito();
									
								$contaCorrente->atualiza_saldo_anterior($conta['numero']);
								
								
							};
							
						}
						
						return true;
					
							break;
							case 3:

								 $percentComissao = $this->comissao->GetPorcentagemComissao($this->pedidos->GetPedId()); //busca porcentagem comissao
							
								 
							
								 
								 foreach( $percentComissao as $key => $value ) {

								 
								 	
								 	
								 									 	

								 	$comissao = (($value['cart_qtd']*$value['cart_valor'])/100)*40;
								 	
								 	
								 	
							 		if($comissao > 0)
							 		{
							
								 	
								 			
								 		try{
								 			
								 		$this->comissao->banco->conexao->beginTransaction();
								 			
								 		$this->comissao->SetCmComissao($comissao);
								 		$this->comissao->SetCmData('now()');
								 		$this->comissao->SetCmDataPag('now()');
								 			
								 			
								 		$this->comissao->SetFkStatusPagamento('2');
							
							
								 		$this->comissao->SetFkPed($this->pedidos->GetPedId());
								 		$this->comissao->SetFkUsuIndicou($this->pedidos->GetFkUsu());
								 		$this->comissao->SetFkUsuIndicado($this->pedidos->GetFkUsu());
								 		$this->comissao->SetCmPercentComissao(40);
							
							
								 		$this->comissao->InsereRegistroComissao($this->data);
							
								 		$contaCorrente = new ContaCorrente;
								 		$contaCorrente->SetFkUsuDoc($this->comissao->GetFkUsuIndicou());
								 		$conta = $contaCorrente->verificaContaUsuExiste();
								 			
								 		//INSERE O MOVIMENTO
								 		$movimento = new Movimento;
								 		$dadosMovimento = array('fk_conta_corrente'		=> $conta['numero'],
								 		'fk_tipo_movimento'		=> 15,
								 		'fk_status_movimento'	=> 2,
								 		'mvm_data'				=> 'now()',
								 		'mvm_valor'				=> $this->comissao->GetCmComissao(),
								 		'fk_ped' => $this->pedidos->GetPedId(),
								 		'fk_usu' => $this->pedidos->GetFkUsu()
								 		);
							
								 		$movimento->insereMovimento( $dadosMovimento );
							
								 		//INSERE O SALDO DE MOVIMENTO
							
								 		$contaCorrente->saldo_atual($conta['numero']); //Atualiza a tabela tb_saldo
							
							
								 			
								 			
							
								 		$this->comissao->banco->conexao->commit();
								 			
								 		}catch (PDOException $e){
								 					
								 			$msg = $e->getMessage();
								 				
								 			$this->comissao->banco->conexao->rollBack();
								 				
								 			$this->comissao->banco->log($msg);
								 				
								 			return false;
								 				
										 }
										 				
										 		}
								 				
									 		
								 		}
							
								 		return true;
							
							
							
												
							
							
							
								 		break;
							case 5:
														

							
								 $comissao = $this->pedidos->GetPedValorPago();
							
								 	if($comissao > 0)
								 	{
							
								 			
								 		try{
								 			
								 		$this->comissao->banco->conexao->beginTransaction();
								 			
								 		/*$this->comissao->SetCmComissao($comissao);
								 		$this->comissao->SetCmData('now()');
								 		$this->comissao->SetCmDataPag('now()');
							
								 			
								 		$this->comissao->SetFkStatusPagamento('2');
							
							
								 		$this->comissao->SetFkPed($this->pedidos->GetPedId());
								 		$this->comissao->SetFkUsuIndicou($this->pedidos->GetFkUsu());
								 		$this->comissao->SetFkUsuIndicado($this->pedidos->GetFkUsu());
								 		$this->comissao->SetCmPercentComissao($dadosRede['pc_perc']);
							
							
								 		$this->comissao->InsereRegistroComissao($this->data);*/
							
								 		$contaCorrente = new ContaCorrente;
								 		$contaCorrente->SetFkUsuDoc($this->pedidos->GetFkUsu());
								 		$conta = $contaCorrente->verificaContaUsuExiste();
								 			
								 		//INSERE O MOVIMENTO
								 		$movimento = new MovimentoBonus;
								 		$dadosMovimento = array('fk_conta_corrente'		=> $conta['numero'],
								 		'fk_tipo_movimento'		=> 15,
								 		'fk_status_movimento'	=> 2,
								 		'mvm_data'				=> 'now()',
								 		'mvm_valor'				=> $comissao,
								 		'fk_ped' => $this->pedidos->GetPedId(),
								 		'fk_usu' => $this->pedidos->GetFkUsu()
								 		);
							
								 		$movimento->insereMovimento( $dadosMovimento );
							
								 		$contaCorrente->saldo_atual_bonus($conta['numero']); //Atualiza a tabela tb_saldo_bonus
							
							
								 			
								 			
							
								 		$this->comissao->banco->conexao->commit();
								 			
								 		}catch (PDOException $e){
								 					
								 			$msg = $e->getMessage();
								 				
								 			$this->comissao->banco->conexao->rollBack();
								 				
								 			$this->comissao->banco->log($msg);
								 				
								 			return false;
								 				
								 		}
								 				
								 		}
								 		
								 		
							
								 		return true;
							
							
							
												
							
							
							
							break;
						}
					} else {
						return false;	
					}
				break;
			default:
					return false;
				break;
		}
	}
	

	public function executaPontuacao($tipo) {
		$this->pontos = new Pontos; //instancia a classe pontos
		$this->usuario = new Usuario; //instancia classe usuario
		
		$dados_pedido = $this->pedidos->GetDadosPedido(); //busca dados gerais do pedido
		$this->pedidos->SetFkStatus($dados_pedido[0]['fk_status']); //busca status do pedido
		$this->pontos->SetFkPed($this->pedidos->GetPedId()); //armazena o ID do pedido
		$this->pontos->SetFkStatusPagamento(1); //defini o status como pendente

		$temp = $this->pontos->VerificaExisteTabela($this->data);

		$rede = array();
		
		if( $temp ) {
			$temp = $this->pontos->VerificaExistePontuacao($this->data); //verifica se nao existe a pontuacao
			switch( $this->pedidos->GetFkStatus() ) {
				case 3:
						switch( $tipo ) {
							case 2: 
								if( !$temp ) {
									
									
									$pontuacao = $this->pontos->GetPontos($this->pedidos->GetPedId()); //busca pontos dos produtos
									$this->pontos->SetFkUsuRede( $this->pedidos->GetFkUsu() );
									$usu_rede = $this->pedidos->GetFkUsu();
									
									
									
									$rede = $this->usuario->BinarioAcimaRecursivo($this->pedidos->GetFkUsu());
// 									echo "<pre>"; print_r( $pontuacao ); echo "</pre>"; die;
									foreach( $pontuacao as $key => $value ) {
										
										foreach ($rede AS $dadosRede)
										{
											$cpf = $dadosRede['usu_doc'];
											
											
											$totalPontos = $value['cart_qtd']*$value['cart_pontos'];
											
											if($totalPontos)
											{
											
											$this->pontos->SetPtPontos($totalPontos);								
											
											$this->pontos->InserePontuacao($dadosRede, $this->data);
											
											//valida_usu_perna
											//echo 'usu '.$cpf.' Rede '.$usu_rede.'<br>';
											$ver_e = $this->pontos->valida_usu_perna($cpf,$usu_rede,'e');
											$ver_d = $this->pontos->valida_usu_perna($cpf,$usu_rede,'d');
											
											//echo '<pre>';print_r($ver_e);print_r($ver_d);echo '</pre>';
											
											if(!empty($ver_e[0]))
											{
											
												if(!$this->usuario->banco->ValidaRegistro('financeiro.tb_saldo_pontos','sld_id',"fk_usu = '{$cpf}' AND sld_perna = 'e'"))
												{
													$this->usuario->banco->inserir('financeiro.tb_saldo_pontos', 
																					array(
																					'sld_valor_credito' => $totalPontos,
																					'sld_valor_debito'  => 0,
																					'sld_perna' => 'e',
																					'sld_mes_ano' => $this->data,
																					'fk_usu' => $cpf
																					)
													);
													
												}else{
													
													$this->usuario->banco->executar("UPDATE financeiro.tb_saldo_pontos SET sld_valor_credito = sld_valor_credito+".$totalPontos." WHERE fk_usu = '{$cpf}' AND sld_perna = 'e'");
													
												}
											
											}elseif(!empty($ver_d[0]))
											{
											
												if(!$this->usuario->banco->ValidaRegistro('financeiro.tb_saldo_pontos','sld_id',"fk_usu = '{$cpf}' AND sld_perna = 'd'"))
												{
													$this->usuario->banco->inserir('financeiro.tb_saldo_pontos', 
																					array(
																					'sld_valor_credito' => $totalPontos,
																					'sld_valor_debito'  => 0,
																					'sld_perna' => 'd',
																					'sld_mes_ano' => $this->data,
																					'fk_usu' => $cpf
																					)
													);
													
												}else{
													
													$this->usuario->banco->executar("UPDATE financeiro.tb_saldo_pontos SET sld_valor_credito = sld_valor_credito+".$totalPontos." WHERE fk_usu = '{$cpf}' AND sld_perna = 'd'");
													
												}
												
											}
											
											}
										
										}
										
									}
									
									
									
									
									
									
									
									
									return true;
								} else {
									return false;	
								}
							break;
							case 1: 
								if( !$temp ) {
									$pontuacao = $this->pontos->GetPontos($this->pedidos->GetPedId()); //busca pontos dos produtos
									$this->pontos->SetFkUsuRede( $this->pedidos->GetFkUsu() );
									/*  busca usuarios rede
									 *  parm 1 = array da rede vazio
									 *	parm 2 = id do usuario que comprou
									 *	parm 3 = contador para segurança de loops infinitos, enviar sempre 0
									 *	parm 4 = não obrigatório, usuário que deseja parar o loop. se no enviar, percorre toda a arvore até o topo
									 *	retorna um array iniciando em 0
									 */
									$rede = $this->usuario->BinarioAcimaRecursivo($this->pedidos->GetFkUsu());
									//echo "<pre>"; print_r( $rede ); echo "</pre>"; die;
									foreach( $pontuacao as $key => $value ) {
										$totalPontos = $value['cart_qtd']*$value['bn_pontos'];
										$this->pontos->SetPtPontos($totalPontos); //armazena os pontos								
										//unset( $rede[0] ); //remove o usuario que está comprando, pois ele não ganha comissao nem registra pontos
			
										foreach( $rede AS $dadosRede ) {
											$this->pontos->InserePontuacao($dadosRede, $this->data);
			
											//ATUALIZA O SALDO DE PONTOS
											$saldoPontos = new SaldoPontos;
											$saldoPontos->SetSldValorCredito($value['bn_pontos']);
											$saldoPontos->SetSldValorDebito(0);
											$saldoPontos->SetSldPerna($dadosRede['usu_perna']);
											$saldoPontos->SetSldMesAno($this->data);
											$saldoPontos->SetFkUsu($dadosRede['fk_usu_rede']);
											$saldoPontos->atualizaSaldo();
										}
									}
									
									return true;
								} else {
									return false;	
								}
							break;
						}
					break;
				default:
						return false;
					break;
			}
		} else {
			return false;
		}
	}
	
	
	
}