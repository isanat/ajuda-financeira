<?php
//#!/usr/bin/php
include_once( '/var/www/mmn_torus/public_html/core/config/DataMapper.php' );
include_once( '/var/www/mmn_torus/public_html/core/config/Banco.php' );
include_once( '/var/www/mmn_torus/public_html/core/app/Model/Repository/UsuarioRepository.php' );
include_once( '/var/www/mmn_torus/public_html/core/app/Model/Entity/TbUsuarios.php' );
include_once( '/var/www/mmn_torus/public_html/core/app/Model/Repository/SaldoAnteriorRepository.php' );
include_once( '/var/www/mmn_torus/public_html/core/app/Model/Entity/TbSaldoAnterior.php' );
include_once( '/var/www/mmn_torus/public_html/core/app/Model/Repository/MovimentoRepository.php' );
include_once( '/var/www/mmn_torus/public_html/core/app/Model/Entity/TbMovimento.php' );
//$path = "/var/www/mmn_torus/public_html/core/app/cron/config/";

include_once( '/var/www/mmn_torus/public_html/core/app/cron/config/config_torus.php' ); 	//inclui o arquivo de config do cliente

//$diretorio = dir($path);

//for( $dia=1; $dia<=31; $dia++ ) {	//mes
//	$dataDia = ( $dia < 10 ) ? "0".$dia : $dia;	//mes
//	if(checkdate(date('m'),$dataDia, date('Y')))	//mes
// 	{	//mes
// 		$hoje = date('Y-m-'.$dataDia); //mes
// 		$hoje = date('Y-m-d');
		$hoje = '2014-07-18';
		$timeDiaHoje = gmmktime(0,0,0,substr($hoje, 5, 2), substr($hoje, 8, 2), substr($hoje, 0, 4) );
		$timeDiaHoje = $timeDiaHoje - 86400; //geração do saldo do dia anterior
		$dataSaldo = getdate( $timeDiaHoje );
		$diaSaldo = ( $dataSaldo['mday'] < 10 ) ? '0'.$dataSaldo['mday'] : $dataSaldo['mday'];
		$mesSaldo = ( $dataSaldo['mon'] < 10 ) ? '0'.$dataSaldo['mon'] : $dataSaldo['mon'];
		$anoSaldo = $dataSaldo['year'];
		$diaSaldo = $anoSaldo."-".$mesSaldo."-".$diaSaldo;
		
		$timeDiaAnterior = $timeDiaHoje - 86400; //dia anterior a geração do saldo
		$data = getdate( $timeDiaAnterior );
		$diaAnterior = ( $data['mday'] < 10 ) ? '0'.$data['mday'] : $data['mday'];
		$mesAnterior = ( $data['mon'] < 10 ) ? '0'.$data['mon'] : $data['mon'];
		$diaAnterior = $data['year']."-".$mesAnterior."-".$diaAnterior;
		
		$dataSaldo = getdate( $timeDiaHoje );
		$diaSaldo = ( $dataSaldo['mday'] < 10 ) ? '0'.$dataSaldo['mday'] : $dataSaldo['mday'];
		$mesSaldo = ( $dataSaldo['mon'] < 10 ) ? '0'.$dataSaldo['mon'] : $dataSaldo['mon'];
		$anoSaldo = $dataSaldo['year'];
		$diaSaldo = $anoSaldo."-".$mesSaldo."-".$diaSaldo;
		
		$timeDiaAnterior = $timeDiaHoje - 86400; //dia anterior a geração do saldo
		$data = getdate( $timeDiaAnterior );
		$diaAnterior = ( $data['mday'] < 10 ) ? '0'.$data['mday'] : $data['mday'];
		$mesAnterior = ( $data['mon'] < 10 ) ? '0'.$data['mon'] : $data['mon'];
		$diaAnterior = $data['year']."-".$mesAnterior."-".$diaAnterior;
		
		
		echo $hoje." | ".$diaSaldo." | ".$diaAnterior."<br>";
		//executa o saldo em cada cliente configurado no diretorio config
		$saldoAnterior = new TbSaldoAnterior;
		
		$movimento = new TbMovimento;
		
		$movimento->SetMvmData($diaSaldo);
		echo $diaSaldo;
		$dadosMovimento = $movimento->getMovimentoContaDia();
		echo $arquivo;
		foreach( $dadosMovimento as $regMovimento ) { //percorre as contas correntes encontradas
			print_r( $regMovimento );
			$saldoAnterior->SetFkContaCorrente($regMovimento['fk_conta_corrente']);
			$saldoAnterior->SetSdaData($diaAnterior);
			$saldoAnterior->verificaExisteSaldoAnterior(); //verifica se existe saldo anterior na tabela, se não, insere um registro inicial
			$saldoAnterior->saldo = $saldoAnterior->getSaldoDiaAnterior();
	
			$saldoAnterior->SetSdaData($diaSaldo);
			$saldoAnterior->processarSaldoConta();
			$saldoHoje = 0;
		}
			
		$saldoAnterior->desconecta();
//	}	//mes
//} //mes