<?php
abstract class ContaCorrenteRepository
{
	public $constante = 35;
	public $numeroConta;
	public $digitoConta;	
	public $banco;
	
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);

		$this->constante = '35'; //constante para calculo de DV, NÃO MODIFICAR ESTE NÚMERO
		$this->numeroConta = '';
		$this->digitoConta = '';
	}
	
	/** GERA NÚMERO CONTA CORRENTE */
	public function gerarNovaContaCorrente( $fkUsuDoc=null ) {
		$rand = rand ( 1 , 100000000 ); //define um numero randomico entre 1 e 10000
		//$rand .= date('mY'); //concatena com mes e ano (4 digitos)
		
		$conta = str_pad($rand, 10, "0", STR_PAD_LEFT); //preenche zero a esquerda para completar 10 digitos
		$dv = $this->digitoVerificador( $conta );
		
		$dados['conta'] = $conta;
		$dados['dv'] = $dv['dv'];
		
		$this->SetCtaNumero( $conta );
		$this->SetCtaDigito( $dv['dv'] );
		
		//loop para gerar conta sucessivamente até gerar um número inexistente
		if( $this->verificaContaExiste() ) {
			$this->gerarNovaContaCorrente();
		} else {		
			return $dados; //retorna um array com o numero da conta e o dv
		}
	}
	
	public function digitoVerificador( $conta ) {
		$arrayConta = array();
		$arrayConstante = array();
		
		/** SEPARA A SEQUENCIA DA CONTA E DA CONSTANTE **/
		$const = 0;
		for( $i=0; $i<10; $i++ ) {
			$arrayConta[$i] = $conta[$i];
			$arrayConstante[$i] = substr( $this->constante, $const, 1 );
			$const = ( $const == 0 ) ? 1 : 0;
		}
		
		/** RESULTADO CONTA x CONSTANTE */
		$resultado = 0;
		for( $i=0; $i<10; $i++ ) {
			$resultado += ( $arrayConta[$i] * $arrayConstante[$i] );
		}
		
		/** CALCULA O PRÉ-DIGITO COM MOD 11 */
		$preDigito = $resultado % 11;
		
		/** CALCULA O DIGITO VERIFICADOR */
		switch( $preDigito ) {
			case 0:
					$dv = 0;
				break;
			case 1:
					$dv = 0;
				break;
			default:
					$dv = ( 11 - $preDigito );
				break;
		}
		
		$dados['dv'] = $dv;
		$dados['resultado'] = $resultado;
		$dados['conta'] = $arrayConta;
		$dados['constante'] = $arrayConstante;
		
		/** RETORNA O RESULTADO DAS OPERAÇÕES E O DIGITO VERIFICADOR */
		return $dados;
	}
	
	public function verificaContaExiste() {
		$ctaNumero = $this->GetCtaNumero();

		$res = $this->banco->executar( "SELECT cta_numero 
											FROM banco.tb_conta_corrente 
											WHERE cta_numero = '{$ctaNumero}'" ) ;
		
		if(!empty($res[0])){
			return $res[0]['cta_numero'];
		} else {		
			return false;
		}
	}
	
	public function gravaContaCorrente() {
		try{		
			$conta = array(
						'cta_numero'=>$this->GetCtaNumero(),
						'cta_digito'=>$this->GetCtaDigito(),
						'fk_usu_doc'=>$this->GetFkUsuDoc(),
						'cta_ativo'=>$this->GetCtaAtivo() 
					);			
			$this->banco->inserir('banco.tb_conta_corrente',$conta);
			$conta = array();
			$conta['numero'] = $this->GetCtaNumero();
			$conta['dv'] = $this->GetCtaDigito();
			
			//cria o registro de saldo inicial
			$saldo = new Saldo();
			$saldo->SetFkContaCorrente( $conta['numero'] );
			$saldo = $saldo->getSaldo();
			$conta['saldo'] = $saldo;
			
			//cria saldo anterior inicial
			$saldoAnterior = new SaldoAnterior();
			$saldoAnterior->SetFkContaCorrente( $conta['numero'] );
			$data = $saldoAnterior->getDiaMenosUm( date('Y-m-d') );
			$saldoAnterior->SetSdaData( $data );
			$saldoAnterior->verificaExisteSaldoAnterior();

			$saldoAnteriorBonus = new SaldoAnteriorBonus();
			$saldoAnteriorBonus->SetFkContaCorrente( $conta['numero'] );
			$data = $saldoAnteriorBonus->getDiaMenosUm( date('Y-m-d') );
			$saldoAnteriorBonus->SetSdaData( $data );
			$saldoAnteriorBonus->verificaExisteSaldoAnteriorBonus();

			return $conta;
		}catch( PDOException $e ) {
			$msg = 'Erro ao inserir conta corrente: ' . $e->getMessage();
// 			echo $msg; die;
			$this->banco->log( $msg );
			return false;
		}
	}
	
	public function verificaContaUsuExiste() {
		$usuDoc = $this->GetFkUsuDoc();
		
		$res = $this->banco->executar( "SELECT cta_numero, 
												cta_digito  
											FROM banco.tb_conta_corrente 
											WHERE fk_usu_doc = '{$usuDoc}'" ) ;

		if(!empty($res[0])){
			$conta = array();
			$conta['numero'] = $res[0]['cta_numero'];
			$conta['dv'] = $res[0]['cta_digito'];
			$saldo = new Saldo();
			$saldo->SetFkContaCorrente( $conta['numero'] );
			$saldo = $saldo->getSaldo();
			$conta['saldo'] = $saldo;
			
			$saldoBonus = new SaldoBonus();
			$saldoBonus->SetFkContaCorrente( $conta['numero'] );
			$saldoBonus = $saldoBonus->getSaldoBonus();
			$conta['saldoBonus'] = $saldoBonus;
			return $conta;
		} else {		
			$conta = $this->gerarNovaContaCorrente();
			$this->SetFkUsuDoc( $this->GetFkUsuDoc() );
			$this->SetCtaNumero( $conta['conta'] );
			$this->SetCtaDigito( $conta['dv'] );
			$this->SetCtaAtivo('1');
			return $this->gravaContaCorrente();
		}
	}
	
	public function ListarHistorico($filtros) {
		
		//print_r( $filtros ); die;
		
		$data = substr( $filtros['dia'], 6, 4)."-".substr( $filtros['dia'], 3, 2 )."-".substr( $filtros['dia'], 0, 2 );
		
		$queryPt = "SELECT COUNT(*) AS total 
				FROM banco.tb_movimento 
				INNER JOIN banco.tb_tipo_movimento ON tb_tipo_movimento.tmv_id = banco.tb_movimento.fk_tipo_movimento ";
		
		$query = "SELECT banco.tb_movimento.fk_conta_corrente, 
						banco.tb_movimento.fk_tipo_movimento, 
						banco.tb_movimento.fk_status_movimento, 
						to_char( banco.tb_movimento.mvm_data, 'DD/MM/YYYY') AS mvm_data, 
						banco.tb_movimento.mvm_valor, 
						banco.tb_tipo_movimento.tmv_descricao, 
						banco.tb_tipo_movimento.tmv_cred_deb,
						u.usu_usuario
				FROM banco.tb_movimento 
				INNER JOIN banco.tb_tipo_movimento ON tb_tipo_movimento.tmv_id = banco.tb_movimento.fk_tipo_movimento 
				LEFT JOIN public.tb_usuarios u ON u.usu_doc = banco.tb_movimento.fk_usu ";
		
		//echo '<pre>';print_r($query);die;	
		/*$queryBusca = "WHERE( ( to_char( banco.tb_movimento.mvm_data, 'DD/MM/YYYY')::text LIKE '%".$filtros['dia']."%' )	)  AND 
							( banco.tb_movimento.fk_conta_corrente::text = '".$filtros['contacorrente']."' ) ";*/

		$queryBusca = "WHERE( ( to_char( banco.tb_movimento.mvm_data, 'DD/MM/YYYY')::text BETWEEN '".$filtros['dataInicio']."' AND '".$filtros['dataFim']."'  )	)  AND 
							( banco.tb_movimento.fk_conta_corrente::text = '".$filtros['contacorrente']."' ) ";
		//} else {
		//	$queryBusca = "WHERE ( banco.tb_movimento.fk_conta_corrente::text = '".$filtros['contacorrente']."' ) ";	
		//}
		
		$queryPt .= $queryBusca;			
		
		//echo( $queryPt ); die;
		
		$retornoPt = $this->ListarHistoricoPaginacao( $queryPt, 1, 50000 );
						
		$query .= $queryBusca;

		$query .= "ORDER BY banco.tb_movimento.mvm_id ASC ";
		//$query .="LIMIT 0 OFFSET 500000";

		//echo "<pre>"; print_r( $filtros['contacorrente'] ); die;				
		
		//echo $query; die;
		
		$result = $this->banco->conexao->prepare($query);
		$result->execute();
		$ret = $result->fetchAll(PDO::FETCH_ASSOC);

		if( !empty( $ret['0']['mvm_data'] ) ) {
			$classSaldoAnterior = new SaldoAnterior;
			$dataSaldo = $filtros['dataInicio']; //$ret[0]['mvm_data'];
			$classSaldoAnterior->SetSdaData($dataSaldo);
			$classSaldoAnterior->SetFkContaCorrente($filtros['contacorrente']);
			$saldoAnterior = $classSaldoAnterior->getSaldoAnterior();
			$saldoAnteriorMoeda = number_format( $saldoAnterior['sda_valor'], 2, ',', '.' );

			$retorno['saldoAnterior']['data'] = $saldoAnterior['sda_data'];
			$retorno['saldoAnterior']['saldo'] = $saldoAnterior['sda_valor'];
			$retorno['saldoAnterior']['moeda'] = $saldoAnteriorMoeda;
		} else {
			$retorno['saldoAnterior']['data'] = $filtros['dia'];
			$retorno['saldoAnterior']['saldo'] = 0;
			$retorno['saldoAnterior']['moeda'] = '0,00';
		}
		$retorno['busca'] = $ret;
		$retorno['paginacao'] = $retornoPt;
		//$retorno['busca'] = $ret;
		//$retorno['paginacao'] = $retornoPt;
		return $retorno;
	}
	
	public function ListarHistoricoPaginacao($sql, $pagina, $regpag ) {
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
					</div>';
					/*
					<div class="span6">
						<div class="dataTables_paginate paging_bootstrap pagination">
							<ul>';
							//botao botao anterior
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(historico_paginacao(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(historico_paginacao(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(historico_paginacao(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(historico_paginacao(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>'; */

		return $html;
	}
	
	public function ListarHistoricoBonus($filtros) {
		$queryPt = "SELECT COUNT(*) AS total 
				FROM banco.tb_movimento_bonus 
				INNER JOIN banco.tb_tipo_movimento ON tb_tipo_movimento.tmv_id = banco.tb_movimento_bonus.fk_tipo_movimento ";
		
		$query = "SELECT banco.tb_movimento_bonus.fk_conta_corrente, 
						banco.tb_movimento_bonus.fk_tipo_movimento, 
						banco.tb_movimento_bonus.fk_status_movimento, 
						to_char( banco.tb_movimento_bonus.mvm_data, 'DD/MM/YYYY') AS mvm_data, 
						banco.tb_movimento_bonus.mvm_valor, 
						banco.tb_tipo_movimento.tmv_descricao, 
						banco.tb_tipo_movimento.tmv_cred_deb  
				FROM banco.tb_movimento_bonus 
				INNER JOIN banco.tb_tipo_movimento ON tb_tipo_movimento.tmv_id = banco.tb_movimento_bonus.fk_tipo_movimento ";
		
				
		if( !empty( $filtros['busca'] ) ) {
			$queryBusca = "WHERE( ( to_char( banco.tb_movimento_bonus.mvm_data, 'DD/MM/YYYY')::text ILIKE '%".$filtros['busca']."%' )	)  AND 
								( banco.tb_movimento_bonus.fk_conta_corrente::text = '".$filtros['contacorrente']."' ) ";
		} else {
			$queryBusca = "WHERE ( banco.tb_movimento_bonus.fk_conta_corrente::text = '".$filtros['contacorrente']."' ) ";	
		}
		$queryPt .= $queryBusca;			
		$retornoPt = $this->ListarHistoricoBonusPaginacao( $queryPt, $filtros['pagina'], $filtros['limit'] );
						
		$query .= $queryBusca;

		$query .= "ORDER BY banco.tb_movimento_bonus.mvm_id ASC ";
		$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
						
		//echo $query; die;
		$result = $this->banco->conexao->prepare($query);
		$result->execute();
		$ret = $result->fetchAll(PDO::FETCH_ASSOC);
		
		$classSaldoAnterior = new SaldoAnteriorBonus;
		$dataSaldo = ( empty( $ret[0]['mvm_data'] ) ) ? date('d/m/Y') : $ret[0]['mvm_data'];
		$classSaldoAnterior->SetSdaData($dataSaldo);
		$classSaldoAnterior->SetFkContaCorrente($filtros['contacorrente']);
		$saldoAnterior = $classSaldoAnterior->getSaldoAnteriorBonus();
		$saldoAnteriorMoeda = number_format( $saldoAnterior['sda_valor'], 2, ',', '.' );

		$retorno['saldoAnteriorBonus']['data'] = $saldoAnterior['sda_data'];
		$retorno['saldoAnteriorBonus']['saldo'] = $saldoAnterior['sda_valor'];
		$retorno['saldoAnteriorBonus']['moeda'] = $saldoAnteriorMoeda;
		$retorno['busca'] = $ret;
		$retorno['paginacao'] = $retornoPt;
		
		return $retorno;
	}
	
	public function ListarHistoricoBonusPaginacao($sql, $pagina, $regpag ) {
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
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(historico_bonus_paginacao(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(historico_bonus_paginacao(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(historico_bonus_paginacao(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(historico_bonus_paginacao(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>';

		return $html;
	}

public function getSaldoAtual_ajax(){
		
$query = $this->banco->executar("
SELECT
	SUM(sa.sld_valor_credito - sa.sld_valor_debito) AS total,
	sa.sld_valor_debito as sld_valor_debito,
	sa.sld_valor_credito as sld_valor_credito,
	sa.fk_conta_corrente as fk_conta_corrente,
	cc.cta_numero        as cta_numero,    
	cc.fk_usu_doc        as fk_usu_doc  
FROM 
	banco.tb_saldo as sa,
	banco.tb_conta_corrente as cc
WHERE
    sa.fk_conta_corrente = cc.cta_numero AND
	cc.fk_usu_doc = '".$_SESSION['usuario']['usu_doc']."'
GROUP BY
sa.fk_conta_corrente,
sld_valor_credito,
sld_valor_debito,
cc.cta_numero,
cc.fk_usu_doc ");	 
	  return $query;	
	}


public function getSaldoAtual(){
		
$query = $this->banco->executar("
SELECT
	SUM(sa.sld_valor_credito - sa.sld_valor_debito) AS total,
	sa.sld_valor_debito as sld_valor_debito,
	sa.sld_valor_credito as sld_valor_credito,
	sa.fk_conta_corrente as fk_conta_corrente,
	cc.cta_numero        as cta_numero,    
	cc.fk_usu_doc        as fk_usu_doc  
FROM 
	banco.tb_saldo as sa,
	banco.tb_conta_corrente as cc
WHERE
    sa.fk_conta_corrente = cc.cta_numero AND
	cc.fk_usu_doc = '".$_SESSION['usuario']['usu_doc']."'
GROUP BY
sa.fk_conta_corrente,
sld_valor_credito,
sld_valor_debito,
cc.cta_numero,
cc.fk_usu_doc ");	 
	  return $query;	
	}

public function getUsuTransfer(){
  $query = $this->banco->executar("SELECT usu_usuario FROM public.tb_usuarios WHERE usu_usuario = '".ContaCorrente::$usu."'");	 
  return $query;	
}


public function getUsuSeguranca(){
  $query = $this->banco->executar("SELECT usu_doc,usu_seguranca
                                   FROM public.tb_usuarios 
                                   WHERE 
                                    usu_doc = '".$_SESSION['usuario']['usu_doc']."'");	 
  return $query;	
}

public function insertTranferencia(){

  $usuarioRecebeTransfer = $this->banco->executar("
SELECT 
   usu.usu_usuario,
   usu.usu_doc,
   cc.fk_usu_doc,
   cc.cta_numero
FROM 
   public.tb_usuarios as usu,
   banco.tb_conta_corrente as cc
WHERE 
   usu_usuario = '".ContaCorrente::$usu."' AND
   cc.fk_usu_doc = usu.usu_doc
");



  foreach ($usuarioRecebeTransfer as $listTransf) { }
  foreach ($this->getSaldoAtual() as $valSaldo) { }   

$query = $this->banco->executar("
SELECT
	SUM(sa.sld_valor_credito - sa.sld_valor_debito) AS total,
	sa.sld_valor_debito as sld_valor_debito,
	sa.sld_valor_credito as sld_valor_credito,
	sa.fk_conta_corrente as fk_conta_corrente,
	cc.cta_numero        as cta_numero,    
	cc.fk_usu_doc        as fk_usu_doc  
FROM 
	banco.tb_saldo as sa,
	banco.tb_conta_corrente as cc
WHERE
    sa.fk_conta_corrente = cc.cta_numero AND
	cc.fk_usu_doc = '".$listTransf['fk_usu_doc']."'
GROUP BY
sa.fk_conta_corrente,
sld_valor_credito,
sld_valor_debito,
cc.cta_numero,
cc.fk_usu_doc ");




   $saldoUpCreditar = array(
     "sld_valor_credito"=>ContaCorrente::$valTransf_valid+$query[0]['sld_valor_credito'],
   	);
   $this->banco->editar('banco.tb_saldo',$saldoUpCreditar,"fk_conta_corrente = '".$query[0]['cta_numero']."'");


   $saldoUpDeditar = array(
     "sld_valor_debito"=>ContaCorrente::$valTransf_valid+$valSaldo['sld_valor_debito'],
   	);
   $this->banco->editar('banco.tb_saldo',$saldoUpDeditar,"fk_conta_corrente = '".$valSaldo['cta_numero']."'");

  $moviUpCreditar = array(
     "fk_conta_corrente"=>$query[0]['cta_numero'],
     "fk_tipo_movimento"=>7,
     "fk_status_movimento"=>2,
     "mvm_data"=>"NOW()",
     "mvm_valor"=>ContaCorrente::$valTransf_valid,
     "mvm_usu"=>$valSaldo['cta_numero']
   	);
$this->banco->inserir('banco.tb_movimento',$moviUpCreditar);

   $moviUpDeditar = array(
     "fk_conta_corrente"=>$valSaldo['cta_numero'],
     "fk_tipo_movimento"=>6,
     "fk_status_movimento"=>2,
     "mvm_data"=>"NOW()",
     "mvm_valor"=>ContaCorrente::$valTransf_valid,
     "mvm_usu"=>$valSaldo['cta_numero']
   	);
$this->banco->inserir('banco.tb_movimento',$moviUpDeditar);
//header("Location: transferencia");
}

		public function AddTaxaAdm($conta,$usu)
		{
			$this->banco->inserir('banco.tb_movimento',array(
															'fk_conta_corrente' => '0037148326',
															'fk_tipo_movimento' => 11,
															'fk_status_movimento' => 2,
															'mvm_valor' => 3,
															'fk_usu' => $usu
																));
											
				$query = "UPDATE banco.tb_saldo SET sld_valor_credito = sld_valor_credito+3 WHERE fk_conta_corrente = '0093004920'";
				
				//echo $query;die;
									
				$this->banco->executar($query);
			
			
		}
		
		public function DebTaxaAdm($conta,$usu)
		{
			$this->banco->inserir('banco.tb_movimento',array(
															'fk_conta_corrente' => $conta,
															'fk_tipo_movimento' => 10,
															'fk_status_movimento' => 2,
															'mvm_valor' => 3,
															'fk_usu' => $usu
																));
											
				//$query = "UPDATE banco.tb_saldo SET sld_valor_debito = sld_valor_debito+3 WHERE fk_conta_corrente = '{$conta}'";
				
				//echo $query;die;
									
				//$this->banco->executar($query);
			
			
		}
		
		public function atualiza_saldo()
		{
			
			$usu = $this->banco->executar('SELECT c.cta_numero FROM banco.tb_conta_corrente c
											INNER JOIN public.tb_usuarios u ON u.usu_doc = c.fk_usu_doc');
			
			foreach($usu as $list)
			{
				$this->saldo_atual($list['cta_numero']);
			}
			
			//$this->saldo_atual('0093004920');
			
			
		}
		
		public function saldo_atual($conta)
		{
			
//			$conta = '0093004920';
			
			$cred = $this->banco->executar("SELECT sum(m.mvm_valor) as valor FROM banco.tb_movimento  m
								INNER JOIN banco.tb_tipo_movimento t ON m.fk_tipo_movimento = t.tmv_id
								WHERE fk_conta_corrente::text = '{$conta}'::text AND t.tmv_cred_deb = 'c'");
							
			$deb = $this->banco->executar("SELECT sum(m.mvm_valor) as valor FROM banco.tb_movimento  m
								INNER JOIN banco.tb_tipo_movimento t ON m.fk_tipo_movimento = t.tmv_id
								WHERE fk_conta_corrente::text = '{$conta}'::text AND t.tmv_cred_deb = 'd'");
								
								//echo $deb[0]['valor'];die;
								
			if(empty($deb[0]['valor']))
			{
				$deb[0]['valor'] = 0;
			}
			if(empty($cred[0]['valor']))
			{
				$cred[0]['valor'] = 0;
			}
								
			$query = "UPDATE banco.tb_saldo SET sld_valor_credito = ".$cred[0]['valor'].", sld_valor_debito = ".$deb[0]['valor']." WHERE fk_conta_corrente = '{$conta}'";
										
					$this->banco->executar($query);
							
			return true;
			
			
		}
		
		public function saldo_atual_bonus($conta)
		{
				
			//			$conta = '0093004920';
				
			$cred = $this->banco->executar("SELECT sum(m.mvm_valor) as valor FROM banco.tb_movimento_bonus  m
					INNER JOIN banco.tb_tipo_movimento t ON m.fk_tipo_movimento = t.tmv_id
					WHERE fk_conta_corrente::text = '{$conta}'::text AND t.tmv_cred_deb = 'c'");
						
					$deb = $this->banco->executar("SELECT sum(m.mvm_valor) as valor FROM banco.tb_movimento_bonus  m
							INNER JOIN banco.tb_tipo_movimento t ON m.fk_tipo_movimento = t.tmv_id
							WHERE fk_conta_corrente::text = '{$conta}'::text AND t.tmv_cred_deb = 'd'");
		
							//echo $deb[0]['valor'];die;
		
					if(empty($deb[0]['valor']))
					{
					$deb[0]['valor'] = 0;
		}
		if(empty($cred[0]['valor']))
		{
		$cred[0]['valor'] = 0;
		}
		
		$query = "UPDATE banco.tb_saldo_bonus SET sld_valor_credito = ".$cred[0]['valor'].", sld_valor_debito = ".$deb[0]['valor']." WHERE fk_conta_corrente = '{$conta}'";
		
		$this->banco->executar($query);
			
		return true;
			
			
		}
		
		public function atualiza_saldo_ant($dia=null)
		{
			$data_inicio = ($dia == null)?date('Y-m-d', strtotime("-1 days")):$dia;
				
			$usu = $this->banco->executar("SELECT c.cta_numero FROM banco.tb_conta_corrente c
					INNER JOIN public.tb_usuarios u ON u.usu_doc = c.fk_usu_doc
					WHERE u.fk_status = 2");
			
			
			$data = explode("-", $data_inicio);
			
			$data_fim = date('Y-m-d');
			
				
			foreach($usu as $list)
			{
				$conta = 0;
				$data_meio = $data_inicio;
				
				
					while ($data_meio != $data_fim)
					{
						
					$data_meio =	date('Y-m-d', mktime(0, 0, 0, $data[1], $data[2]+$conta, $data[0]));
					
					//echo $data_meio;die;
					$this->atualiza_saldo_anterior($list['cta_numero'],$data_meio);
					
					$conta++;
					}
				
			}
				
			//$this->atualiza_saldo_anterior('0093004920','2014-07-18');
				
				
		}
		
		public function atualiza_saldo_anterior($conta,$data=null)
		{
			

			$dia = ($data == null)?date('Y-m-d', strtotime("-1 days")):$data;
			
			$dia_o = explode("-", $dia);
			
			$ontem = date('Y-m-d', mktime(0, 0, 0, $dia_o[1], $dia_o[2]-1, $dia_o[0]));
				
			$cred = $this->banco->executar("SELECT sum(m.mvm_valor) as valor FROM banco.tb_movimento  m
							INNER JOIN banco.tb_tipo_movimento t ON m.fk_tipo_movimento = t.tmv_id
							WHERE (fk_conta_corrente::text = '{$conta}'::text AND t.tmv_cred_deb = 'c') 
							and m.mvm_data::text ILIKE '{$dia}%'::text");
						
					$deb = $this->banco->executar("SELECT sum(m.mvm_valor) as valor FROM banco.tb_movimento  m
							INNER JOIN banco.tb_tipo_movimento t ON m.fk_tipo_movimento = t.tmv_id
							WHERE (fk_conta_corrente::text = '{$conta}'::text AND t.tmv_cred_deb = 'd') 
							and m.mvm_data::text ILIKE '{$dia}%'::text");
		
							
		
					if(empty($deb[0]['valor']))
					{
						$deb[0]['valor'] = 0;
					}
					
					if(empty($cred[0]['valor']))
					{
					$cred[0]['valor'] = 0;
					}
					
		$this->banco->executar("DELETE FROM banco.tb_saldo_anterior where fk_conta_corrente = '{$conta}' AND sda_data = '{$dia}'");
		
		$res = $this->banco->executar("SELECT sda_valor FROM banco.tb_saldo_anterior where fk_conta_corrente = '{$conta}' AND sda_data = '{$ontem}'");
		
		//echo 'dia '.$dia.' cred '.$cred[0]['valor'].' deb '.$deb[0]['valor'].' ontem '.$res[0]['sda_valor'].'<br>';
		
		if(empty($res[0]))
		{
			//Inseri um registro com valor Zero
			$this->banco->inserir('banco.tb_saldo_anterior',
					array(
							'fk_conta_corrente' => $conta,
							'sda_data' => $ontem,
							'sda_valor' => 0
					)
			);
		
		$this->banco->inserir('banco.tb_saldo_anterior',
								array(
								'fk_conta_corrente' => $conta, 
								'sda_data' => $dia, 
								'sda_valor' => $cred[0]['valor']-$deb[0]['valor']
								)
				);
		}else{
			
			$this->banco->inserir('banco.tb_saldo_anterior',
					array(
							'fk_conta_corrente' => $conta,
							'sda_data' => $dia,
							'sda_valor' => ($res[0]['sda_valor']+$cred[0]['valor'])-$deb[0]['valor']
					)
			);
			
		}
		
// 		$this->banco->executar($query);
			
		return true;
			
			
		}



}