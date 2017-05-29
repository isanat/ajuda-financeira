<?php 

abstract class SaldoPontosRepository
{
	public $banco;
	
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function atualizaSaldo() {
		$dados['sld_valor_credito'] 	= $this->GetSldValorCredito();
		$dados['sld_valor_debito']		= $this->GetSldValorDebito();		
		$dados['sld_perna'] 			= $this->GetSldPerna();
		$dados['sld_mes_ano'] 			= $this->GetSldMesAno();
		$dados['fk_usu'] 				= $this->GetFkUsu();

		//procura se registro mes_ano do fk_usu existe
		$sql = "SELECT sld_id 
					FROM financeiro.tb_saldo_pontos 
					WHERE ( sld_perna = '".$dados['sld_perna']."' ) AND 
							( fk_usu = '".$dados['fk_usu']."' ) AND 
							( sld_mes_ano = '".$dados['sld_mes_ano']."')";
		$res = $this->banco->executar( $sql );

		if( $res[0] ) {
			$sql = "UPDATE financeiro.tb_saldo_pontos SET sld_valor_credito = ( sld_valor_credito + ".$dados['sld_valor_credito']." ), 
							sld_valor_debito = ( sld_valor_debito + ".$dados['sld_valor_debito']." ) 
						WHERE ( sld_perna = '".$dados['sld_perna']."' ) AND 
								( fk_usu = '".$dados['fk_usu']."' ) AND 
								( sld_mes_ano = '".$dados['sld_mes_ano']."')";
			$res = $this->banco->executar($sql);
		} else {
			$this->banco->inserir('financeiro.tb_saldo_pontos', $dados);
		}
	}
	
	function getVolumePontos() {
		$fkUsu = $this->GetFkUsu();
		$perna = $this->GetSldPerna();
		
		$sql = "SELECT SUM( sld_valor_credito ) AS sld_valor_credito, 
						SUM( sld_valor_debito ) AS sld_valor_debito 
				FROM financeiro.tb_saldo_pontos 
				WHERE( fk_usu = '".$fkUsu."' ) AND 
						( sld_perna = '".$perna."' )";
						
		//echo $sql;
		$res = $this->banco->executar( $sql );
		return $res[0];
	}
	
	function getAllPontos($fk_usu) {
		$sql = "SELECT SUM(sld_valor_credito) AS totalPontos 
					FROM financeiro.tb_saldo_pontos 
					WHERE( fk_usu = '".$fk_usu."') AND 
							( sld_perna = 'e')";		
		$resE = $this->banco->executar( $sql );
		
		$sql = "SELECT SUM(sld_valor_credito) AS totalPontos 
					FROM financeiro.tb_saldo_pontos 
					WHERE( fk_usu = '".$fk_usu."') AND 
							( sld_perna = 'd')";		
		$resD = $this->banco->executar( $sql );
		
		$res = array( 'e' => $resE[0]['totalpontos'], 
						 'd' => $resD[0]['totalpontos'] );
		return $res;
	}
}
