<?php
abstract class SaldoRepository
{
	public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);

	}
	
	function insereSaldoCredito() {
		$sql = "UPDATE banco.tb_saldo 
					SET sld_valor_credito = ( sld_valor_credito + ".$this->GetSldValorCredito()." ) 
					WHERE fk_conta_corrente = '".$this->GetFkContaCorrente()."'";
		$this->banco->executar( $sql );
	}
	
	function insereSaldoDebito() {
		$sql = "UPDATE banco.tb_saldo 
					SET sld_valor_debito = ( sld_valor_debito + ".$this->GetSldValorDebito()." ) 
					WHERE fk_conta_corrente = '".$this->GetFkContaCorrente()."'";
		$this->banco->executar( $sql );
	}
	
	public function saldoExiste() {
		$fkContaCorrente = $this->GetFkContaCorrente();
		
		$res = $this->banco->executar( "SELECT fk_conta_corrente  
											FROM banco.tb_saldo 
											WHERE fk_conta_corrente = '{$fkContaCorrente}'" ) ;
		
		if(!empty($res[0])){
			return true;
		} else {		
			return $this->saldoInicial();
		}
	}
	
	public function saldoInicial() {
		$conta = $this->GetFkContaCorrente();
		try{		
			$saldo = array(
						'fk_conta_corrente'=>$conta,
						'sld_valor_debito'=>0,
						'sld_valor_credito'=>0 
					);
					
			$this->banco->inserir('banco.tb_saldo',$saldo);
			return true;
		}catch( PDOException $e ) {
			$msg = 'Erro ao inserir conta corrente: ' . $e->getMessage();
// 			echo $msg; die;
			$this->banco->log( $msg );
			return false;
		}
	}
	
	public function getSaldo() {
		if( $this->saldoExiste() ) { 
			$fkContaCorrente = $this->GetFkContaCorrente();
			$res = $this->banco->executar( "SELECT sld_valor_debito, 
													sld_valor_credito   
												FROM banco.tb_saldo 
												WHERE fk_conta_corrente = '{$fkContaCorrente}'" ) ;
			
			if(!empty($res[0])){
				$saldo['debito'] = $res[0]['sld_valor_debito'];
				$saldo['debitoReal'] = number_format( $res[0]['sld_valor_debito'], 2, ',', '.' );
				$saldo['credito'] = $res[0]['sld_valor_credito'];
				$saldo['creditoReal'] = number_format( $res[0]['sld_valor_credito'], 2, ',', '.' );
				$saldo['disponivel'] = $saldo['credito'] - $saldo['debito'];
				$saldo['disponivelReal'] = number_format( $saldo['disponivel'], 2, ',', '.' );
				return $saldo;
			} else {
				return false;
			}
		} else {
			$this->saldoInicial();
			$this->getSaldo();
		}
	}
}