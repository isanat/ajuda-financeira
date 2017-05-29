<?php
abstract class LogPagPontosRepository
{
	public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function getUltimaData() {
		$sql = "SELECT * FROM financeiro.tb_log_pag_pontos ORDER BY data_pag DESC LIMIT 1";
		$result = $this->banco->executar($sql);

		return $result[0];		
	}
	
	public function insereLog( $arrayDados ) {
		$sql = "INSERT INTO financeiro.tb_log_pag_pontos ( pontos_d, pontos_e, media_porcentagem, valor_bonus, valor_credito, data_pag ) 
					VALUES( ".$arrayDados['pontos_d'].", ".$arrayDados['pontos_e'].", ".$arrayDados['media_perc'].", ".$arrayDados['valor_bonus'].", ".$arrayDados['valor_credito'].", '".date('Y-m-d H:i:s')."' )";

		$this->banco->executar($sql);
		return true;
	}
	
	public function verificaPagarHoje( $dataPag=NULL, $dias_pagamento ) {
		if( !$dataPag ) { //nao encontrou lançamentos no log do cliente, cria log inicial
			$dados = array( 'pontos_d' => 0, 
							'pontos_e' => 0, 
							'media_perc' => 0,
							'valor_bonus' => 0,
							'valor_credito' => 0 );
			$this->insereLog( $dados );
			$this->verificaPagarHoje( date('Y-m-d H:i:s'), $dias_pagamento );
		} else {
			$timePag = strtotime( $dataPag );
			$timeHoje = time();
			$dias = 86400 * $dias_pagamento; //intervalo de dias para execução * um dia
			$dif = $timeHoje - $timePag; //diferença para verificação do prazo
			if( $dif > $dias ) {
				$retData['inicio'] = substr( $dataPag, 0, 10 )." 00:00:00"; //devolve a data de inicio da consulta
				$dataFim = getdate( $timeHoje-86400 );
				$diaFim = ( $dataFim['mday'] < 10 ) ? '0'.$dataFim['mday'] : $dataFim['mday'];
				$mesFim = ( $dataFim['mon'] < 10 ) ? '0'.$dataFim['mon'] : $dataFim['mon'];
				$retData['fim'] = $dataFim['year']."-".$mesFim."-".$diaFim." 23:59:59"; //devolve a data do fim da consulta
				
				$mesInicio = substr( $dataPag, 5, 2 );
				$anoInicio = substr( $dataPag, 0, 4 );
				$stop = false;
				$union = array();
				while( !$stop ) {
					$confere = $mesInicio."_".$anoInicio;
					$union[] = $confere;
					if( ( $mesInicio."_".$anoInicio ) == ( $mesFim."_".$dataFim['year'] ) ) {
						$stop = true;	
					} else {
						$mesInicio++;
						$mesInicio = ( $mesInicio < 10 ) ? '0'.$mesInicio : $mesInicio;
						if( $mesInicio > 12 ) {
							$mesInicio = '01';							
							$anoInicio++;	
						}
					}
				}
				$retData['union'] = $union;
				return $retData;
			}
		}
		
		return false; //falso se não necessita executar
	}

	public function desconecta() {
		Banco::desconecta_pgsql();
	}
}