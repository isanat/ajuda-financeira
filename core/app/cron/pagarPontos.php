#!/usr/bin/php
<?php
include_once( '/var/www/mmn/public_html/core/config/DataMapper.php' );
include_once( '/var/www/mmn/public_html/core/config/Banco.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/LogPagPontosRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbLogPagPontos.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/PontosRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbPontos.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/UsuarioRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbUsuarios.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/SaldoBonusRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbSaldoBonus.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/SaldoRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbSaldo.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Saldo.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/SaldoBonus.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/ContaCorrenteRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbContaCorrente.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/MovimentoRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbMovimento.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/MovimentoBonusRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbMovimentoBonus.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/SaldoPontosRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbSaldoPontos.php' );

$path = "/var/www/mmn/public_html/core/app/cron/config/";
$diretorio = dir($path);

$logPontos['pontos_e'] = 0;
$logPontos['pontos_d'] = 0;
$logPontos['media_perc'] = 0;
$logPontos['valor_bonus'] = 0;
$logPontos['valor_credito'] = 0;
$contaMedia = 0;
$totalMedia = 0;

//executa a pontuação em cada cliente configurado no diretorio config
while($arquivo = $diretorio -> read()){ //loop no diretorio de configuração, por cliente
	if( ( $arquivo != '.' ) and ( $arquivo != '..' ) ) { //ignora os index do diretorio
		//echo $arquivo."<br>";
		include_once( '/var/www/mmn/public_html/core/app/cron/config/'.$arquivo ); //inclui o arquivo de config do cliente
		$logPagPontos = new TbLogPagPontos;
		$log = $logPagPontos->getUltimaData(); //busca última data de pagamento
		//print_r( $log );
		$verifica = $logPagPontos->verificaPagarHoje($log['data_pag'], $dias_pagamento); //verifica se está na data de pagamento correta
		//echo $dias_pagamento;
		//echo $verifica;
		//echo "<hr>";
		if( $verifica ) { //executa pagamento de pontos
			$pontuacao = new TbPontos;
			$usuarios = new TbUsuarios;
			$dados = $pontuacao->getUsuariosPeriodo($verifica);
			$contaCorrente = new TbContaCorrente;
			foreach( $dados AS $dadosUsuario ) {
				//echo "<hr>".$dadosUsuario['fk_usu']." "; print_r( $qualificado ); echo "<br>";
				$pontos = $pontuacao->getPontuacaoPeriodo($verifica, $dadosUsuario['fk_usu']); //busca pontuação nas duas pernas
				if( $usuarios->usuarioAtivo( $dadosUsuario['fk_usu'] ) ) { //verifica se usuário está ativo
					$contaCorrente->SetFkUsuDoc( $dadosUsuario['fk_usu'] );
					$conta['contacorrente'] = $contaCorrente->verificaContaUsuExiste();
					//print_r( $conta );
					$qualificado = $usuarios->pernaAtivaQualificado( $dadosUsuario['fk_usu'] ); //verifica qualificação do usuario
					if( $qualificado['qualificado'] ) {
						
						/* CHECAGEM DOS PONTOS */
						$arrayPontos = array();
						foreach( $pontos as $ponto ) { //soma todos os pontos encontrados na perna 'e' ou 'd'
							$arrayPontos[$ponto['pt_perna']] += $ponto['pt_pontos'];
						}
						$logPontos['pontos_e'] += $arrayPontos['e'];
						$logPontos['pontos_d'] += $arrayPontos['d'];
						if( $arrayPontos['e'] < $arrayPontos['d'] ) { //armazana o saldo para incluir para o proximo dia e define a perna que vai pagar
							$perna = 'e';
							$saldo = $arrayPontos['d'] - $arrayPontos['e'];
						} elseif( $arrayPontos['e'] > $arrayPontos['d'] ) {
							$perna = 'd';
							$saldo = $arrayPontos['e'] - $arrayPontos['d'];
						} else {
							$perna = 'e';
							$saldo = $arrayPontos['e'];
						}
						
						$bonusPerc = $usuarios->banco->ver('tb_usuarios INNER JOIN tb_bonus ON tb_bonus.bn_id = tb_usuarios.fk_bonus', 'tb_bonus.bn_rede_perc', "( usu_doc = '".$dadosUsuario['fk_usu']."' )");
						$bonusUsuario = ( $arrayPontos[$perna] * $bonusPerc['bn_rede_perc'] ) / 100;
						$bonusUsuario = number_format( $bonusUsuario, 2, '.', '' );
						
						$totalMedia += $bonusPerc['bn_rede_perc'];
						$contaMedia++;
						$arrayPagamento['bonus'] = ( $bonusUsuario * $porcentagem_bonificacao ) / 100;
						$arrayPagamento['bonus'] = number_format( $arrayPagamento['bonus'], 2, '.', '' );
						$logPontos['valor_bonus'] += $arrayPagamento['bonus'];
						$arrayPagamento['credito'] = ( $bonusUsuario * ( 100 - $porcentagem_bonificacao ) ) / 100;
						$arrayPagamento['credito'] = number_format( $arrayPagamento['credito'], 2, '.', '' );
						$logPontos['valor_credito'] += $arrayPagamento['credito'];
						
						if( $arrayPagamento['bonus'] > 0 ) {
							//INSERE MOVIMENTO BONUS
							$dadosBonus = array('fk_conta_corrente'=>$conta['contacorrente']['numero'],
													'fk_tipo_movimento'=>1, 
													'fk_status_movimento'=>2,
													'mvm_data'=>'now()',
													'mvm_valor'=>$arrayPagamento['bonus'] 
												);
							$movimentoBonus = new TbMovimentoBonus;
							$movimentoBonus->insereMovimento( $dadosBonus );
							
							//INSERE O SALDO DE MOVIMENTO BONUS
							$classSaldoBonus = new TbSaldoBonus;
							$classSaldoBonus->SetFkContaCorrente($conta['contacorrente']['numero']);
							$res = $classSaldoBonus->getSaldoBonus();
							$classSaldoBonus->SetSldValorCredito($arrayPagamento['bonus']);
							$classSaldoBonus->insereSaldoCredito();
						}
												
						if( $arrayPagamento['credito'] > 0 ) {
							//INSERE MOVIMENTO
							$dadosMovimento = array('fk_conta_corrente'=>$conta['contacorrente']['numero'],
													'fk_tipo_movimento'=>1, 
													'fk_status_movimento'=>2,
													'mvm_data'=>'now()',
													'mvm_valor'=>$arrayPagamento['credito'] 
												);
							$movimento = new TbMovimento;
							$movimento->insereMovimento( $dadosMovimento );
							
							//INSERE O SALDO DE MOVIMENTO
							$classSaldo = new TbSaldo;
							$classSaldo->SetFkContaCorrente($conta['contacorrente']['numero']);
							$res = $classSaldo->getSaldo();
							$classSaldo->SetSldValorCredito($arrayPagamento['credito']);
							$classSaldo->insereSaldoCredito();
						}
						
						/* GRAVAÇÃO DOS PONTOS */
						foreach( $pontos as $ponto ) {
							$mes_ano = substr( $ponto['pt_data'], 5, 2 )."_".substr( $ponto['pt_data'], 0, 4 );
							$pontuacao->SetPtId($ponto['pt_id']);
							$pontuacao->updatePagarPontos( 2, $mes_ano );
						}
						
						//INSERE SALDO DE PONTOS NA PERNA PARA PROXIMO DIA
						$novaPerna = ( $perna == 'e' ) ? 'd' : 'e'; 
						$pontuacao->SetPtPontos($saldo);
						$pontuacao->SetFkPed('0');
						$pontuacao->SetFkStatusPagamento('1');
								
						$dadosPontos = array( 'usu_perna' => $novaPerna, 
												'fk_status' => 2, 
												'usu_doc' => $dadosUsuario['fk_usu'],
												'fk_usu_rede' => $dadosUsuario['fk_usu'] 
												);
						$pontuacao->InserePontuacao($dadosPontos, date('m_Y'));
						
						/* //ATUALIZA O SALDO DE PONTOS
						$saldoPontos = new TbSaldoPontos;
						$saldoPontos->SetSldValorCredito($saldo);
						$saldoPontos->SetSldValorDebito(0);
						$saldoPontos->SetSldPerna($novaPerna);
						$saldoPontos->SetSldMesAno(date('m_Y'));
						$saldoPontos->SetFkUsu($dadosUsuario['fk_usu']);
						$saldoPontos->atualizaSaldo(); */
						
					} else {
						/* GRAVAÇÃO DOS PONTOS */
						foreach( $pontos as $ponto ) {
							$mes_ano = substr( $ponto['pt_data'], 5, 2 )."_".substr( $ponto['pt_data'], 0, 4 );
							$pontuacao->SetPtId($ponto['pt_id']);
							$pontuacao->updatePagarPontos( 3, $mes_ano );
							
							//ATUALIZA O SALDO DE PONTOS
							$res = $pontuacao->getRegistroPonto( $mes_ano );
							$saldoPontos = new TbSaldoPontos;
							$saldoPontos->SetSldValorCredito(0);
							$saldoPontos->SetSldValorDebito($res['pt_pontos']);
							$saldoPontos->SetSldPerna($res['pt_perna']);
							$saldoPontos->SetSldMesAno($mes_ano);
							$saldoPontos->SetFkUsu($res['fk_usu']);
							$saldoPontos->atualizaSaldo();
						}
						//echo $dadosUsuario['fk_usu']." não qualificado<br>";	
					}
				} else {
					/* GRAVAÇÃO DOS PONTOS */
					foreach( $pontos as $ponto ) {
						$mes_ano = substr( $ponto['pt_data'], 5, 2 )."_".substr( $ponto['pt_data'], 0, 4 );
						$pontuacao->SetPtId($ponto['pt_id']);
						$pontuacao->updatePagarPontos( 3, $mes_ano );

						//ATUALIZA O SALDO DE PONTOS
						$res = $pontuacao->getRegistroPonto( $mes_ano );
						$saldoPontos = new TbSaldoPontos;
						$saldoPontos->SetSldValorCredito(0);
						$saldoPontos->SetSldValorDebito($res['pt_pontos']);
						$saldoPontos->SetSldPerna($res['pt_perna']);
						$saldoPontos->SetSldMesAno($mes_ano);
						$saldoPontos->SetFkUsu($res['fk_usu']);
						$saldoPontos->atualizaSaldo();

					}
					//echo $dadosUsuario['fk_usu']." não está ativo<br>";	
				}
			}
			
			if( $contaMedia > 0 ) {
				$logPontos['media_perc'] = ( $totalMedia / $contaMedia );
			} else {
				$logPontos['media_perc'] = 0;	
			}
			//echo "<br><br>"; print_r( $logPontos );
			$dadosLog = array( 'pontos_e' => $logPontos['pontos_e'], 
								'pontos_d' => $logPontos['pontos_d'], 
								'media_perc' => $logPontos['media_perc'], 
								'valor_bonus' => $logPontos['valor_bonus'], 
								'valor_credito' => $logPontos['valor_credito'] 
							);
			$logPagPontos->insereLog($dadosLog);
		}
		
		$logPagPontos->desconecta();
	}
}
$diretorio -> close();
