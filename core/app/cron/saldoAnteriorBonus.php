#!/usr/bin/php
<?php
//#!/usr/bin/php
include_once( '/var/www/mmn/public_html/core/config/DataMapper.php' );
include_once( '/var/www/mmn/public_html/core/config/Banco.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/UsuarioRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbUsuarios.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/SaldoAnteriorBonusRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbSaldoAnteriorBonus.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Repository/MovimentoBonusRepository.php' );
include_once( '/var/www/mmn/public_html/core/app/Model/Entity/TbMovimentoBonus.php' );

$path = "/var/www/mmn/public_html/core/app/cron/config/";
$diretorio = dir($path);

$hoje = date('Y-m-d');
$timeDiaHoje = time($hoje);
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

//echo $hoje." | ".$diaSaldo." | ".$diaAnterior."<br>";

//executa a pontuação em cada cliente configurado no diretorio config
while($arquivo = $diretorio -> read()){ //loop no diretorio de configuração, por cliente
	if( ( $arquivo != '.' ) and ( $arquivo != '..' ) ) { //ignora os index do diretorio
		include_once( '/var/www/mmn/public_html/core/app/cron/config/'.$arquivo ); 	//inclui o arquivo de config do cliente
		$saldoAnterior = new TbSaldoAnteriorBonus;
		
		$movimento = new TbMovimentoBonus;
		
		$movimento->SetMvmData($diaSaldo);
		$dadosMovimento = $movimento->getMovimentoContaDiaBonus();

		foreach( $dadosMovimento as $regMovimento ) { //percorre as contas correntes encontradas
			//print_r( $regMovimento );
			$saldoAnterior->SetFkContaCorrente($regMovimento['fk_conta_corrente']);
			$saldoAnterior->SetSdaData($diaAnterior);
			$saldoAnterior->verificaExisteSaldoAnteriorBonus(); //verifica se existe saldo anterior na tabela, se não, insere um registro inicial
			$saldoAnterior->saldo = $saldoAnterior->getSaldoDiaAnteriorBonus();

			$saldoAnterior->SetSdaData($diaSaldo);
			$saldoAnterior->processarSaldoContaBonus();
			$saldoHoje = 0;
		}
				
		$saldoAnterior->desconecta();
	}
}

$diretorio->close();
