<?php
class ComissaoRepository {
	public $banco;
	
	public function __construct() {
		
		global $array_db;
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function CriarTabelaComissao($data) {
		
		//$sql = "CREATE SEQUENCE financeiro.tb_comissao_".$data."_cm_id_seq START 1";
		//$result = $this->banco->executar($sql);
		//"cm_id" int8 DEFAULT nextval(\'financeiro.tb_comissao_'.$data.'_cm_id_seq\'::regclass) NOT NULL,

		$sql = 'CREATE TABLE financeiro.tb_comissao_'.$data.' (
					"cm_id" serial8 NOT NULL,
					"cm_comissao" numeric NOT NULL,
					"cm_data" date NOT NULL,
					"fk_ped" int8 NOT NULL, 
					"fk_usu_indicou" varchar,
					"fk_usu_indicado" varchar NOT NULL,
					"cm_percent_comissao" numeric NOT NULL,
					"fk_status_pagamento" int2,
					"cm_data_pag" date,
					CONSTRAINT tb_comissao_'.$data.'_pkey PRIMARY KEY ("cm_id"),
					CONSTRAINT fk_usu_comissao_'.$data.' FOREIGN KEY ("fk_usu_indicou") REFERENCES public.tb_usuarios ("usu_doc") ON DELETE NO ACTION ON UPDATE CASCADE,
					CONSTRAINT fk_indicado_comissao_'.$data.' FOREIGN KEY ("fk_usu_indicado") REFERENCES public.tb_usuarios ("usu_doc") ON DELETE NO ACTION ON UPDATE CASCADE,
					CONSTRAINT fk_ped_comissao_'.$data.' FOREIGN KEY ("fk_ped") REFERENCES public.tb_pedidos ("ped_id") ON DELETE NO ACTION ON UPDATE CASCADE
					)';
		$result = $this->banco->executar($sql);
		
		//$sql = 'ALTER TABLE "financeiro"."tb_comissao_'.$data.'" ADD PRIMARY KEY ("cm_id")';
		//$result = $this->banco->executar($sql);
		
		return true;
	}
	
	
	public function VerificaExisteTabela($data, $criar=true) {
		$sql = "SELECT
					 relname 
				FROM pg_stat_user_tables 
				WHERE ( relname = 'tb_comissao_".$data."' )
				ORDER BY relname";
		$result = $this->banco->executar($sql);
		
		if( !$result ) {
			if( $criar == true ) {
				$this->CriarTabelaComissao($data);
				return true;
			}
			return false;
		} else {
			return true;	
		}
	}
	
	public function InsereComissao($tabela) {
		echo "insere comissao ".$tabela." - pedido: ".$this->GetPedId()." - status: ".$this->GetFkStatus();
	}
	
	public function VerificaExisteComissao($data) {
		try{
			$id = $this->GetFkPed();
			$res = $this->banco->ver("financeiro.tb_comissao_{$data}",'cm_id',"fk_ped = {$id}");
			return $res;
		}
		catch( PDOException $e ) {
			$msg = 'Erro ao selecionar categoria de produto: ' . $e->getMessage();
			$this->banco->log( $msg );
			return true;
		}
	}
	
	public function GetPorcentagemComissao($prodId) {
		/*
		$sql = "SELECT tb_bonus.bn_cad_perc, 
						tb_carrinho.cart_qtd, 
						tb_carrinho.cart_valor 
					FROM tb_pedidos 
					INNER JOIN tb_carrinho ON tb_carrinho.fk_sessao = tb_pedidos.ped_sessao 
					INNER JOIN tb_prod_carac ON tb_prod_carac.pc_id = tb_carrinho.fk_prod 
					INNER JOIN tb_produtos ON tb_produtos.pro_cod::text = tb_prod_carac.fk_prod::text 
					INNER JOIN tb_bonus ON tb_bonus.bn_id = tb_produtos.fk_bonus 
				WHERE( tb_pedidos.ped_id = ".$prodId." )";
		*/
		$sql = "SELECT b.bn_cad_perc, 
						c.cart_qtd, 
						c.cart_valor 
					FROM tb_pedidos p
					INNER JOIN tb_carrinho c ON c.fk_sessao = p.ped_sessao 
					INNER JOIN tb_caracteristicas  cc ON cc.carac_id = c.fk_carac 
					INNER JOIN tb_produtos pp ON pp.pro_id::text = c.fk_prod::text 
					INNER JOIN tb_bonus b ON b.bn_id = cc.fk_bonus 
				WHERE( p.ped_id = ".$prodId." )";
				
		$result = $this->banco->conexao->prepare($sql);
		$result->execute();
		$ret = $result->fetchAll(PDO::FETCH_ASSOC);
		
		return $ret;
	}

	public function GetValorComissaoLinear($prodId) {

		$sql = "SELECT tb_bonus.bn_vl_linear 
					FROM tb_pedidos 
					INNER JOIN tb_carrinho ON tb_carrinho.fk_sessao = tb_pedidos.ped_sessao 
					INNER JOIN tb_prod_carac ON tb_prod_carac.pc_fk_prod::text = tb_carrinho.fk_prod::text 
					INNER JOIN tb_caracteristicas ON tb_caracteristicas.carac_id = tb_prod_carac.pc_fk_carac 
					INNER JOIN tb_produtos ON tb_produtos.pro_cod::text = tb_prod_carac.pc_fk_prod::text 
					INNER JOIN tb_bonus ON tb_bonus.bn_id = tb_caracteristicas.fk_bonus 
				WHERE( tb_pedidos.ped_id = ".$prodId." )";
				
		$result = $this->banco->conexao->prepare($sql);
		$result->execute();
		$ret = $result->fetchAll(PDO::FETCH_ASSOC);
		
		return $ret;
	}
	
	function CalculaComissao( $valorTotal, $percentComissao ) {
		$valorComissao = (( $valorTotal * $percentComissao ) / 100 );
		//$valorComissao = floor( $valorComissao );
		$valorComissao = number_format( $valorComissao, 2, '.', '' );
		
		return $valorComissao;
	}

	public function InsereRegistroComissao($dataTabela) {
		
		$cm_comissao			= $this->GetCmComissao();
		$cm_data 				= $this->GetCmData();
		$cm_data_pag			= $this->GetCmDataPag();
		$fk_status_pagamento	= $this->GetFkStatusPagamento();
		$fk_ped					= $this->GetFkPed();
		$fk_usu_indicou			= $this->GetFkUsuIndicou();
		$fk_usu_indicado		= $this->GetFkUsuIndicado();
		$cm_percent_comissao	= $this->GetCmPercentComissao();
		$fk_status_pagamento	= $this->GetFkStatusPagamento();

		$campos = array(
				'cm_comissao'				=>$cm_comissao,
				'cm_data'					=>$cm_data,
				'cm_data_pag'				=>$cm_data_pag,
				'fk_status_pagamento'		=>$fk_status_pagamento,								
				'fk_ped'					=>$fk_ped,
				'fk_usu_indicou'			=>$fk_usu_indicou,
				'fk_usu_indicado'			=>$fk_usu_indicado, 
				'cm_percent_comissao'		=>$cm_percent_comissao, 
				'fk_status_pagamento'		=>$fk_status_pagamento 
		);
// 		print_r( $campos ); die();
		return $this->banco->inserir('financeiro.tb_comissao_'.$dataTabela,$campos);
	}
	
	public function ListarComissoesUsuario($filtros) {
		$mesAno = $filtros['mes'].'_'.$filtros['ano'];
		
		$this->VerificaExisteTabela($mesAno);
		
		$queryPt = "SELECT COUNT(*) AS total 
				FROM financeiro.tb_comissao_".$mesAno." 
				INNER JOIN financeiro.tb_status_pagamento ON financeiro.tb_status_pagamento.sts_id = financeiro.tb_comissao_".$mesAno.".fk_status_pagamento 
				LEFT JOIN tb_usuarios usu_ind ON usu_ind.usu_doc = financeiro.tb_comissao_".$mesAno.".fk_usu_indicado ";
		
		$query = "SELECT financeiro.tb_comissao_".$mesAno.".cm_id, 
						financeiro.tb_comissao_".$mesAno.".cm_comissao, 
						financeiro.tb_comissao_".$mesAno.".fk_usu_indicado, 
						to_char( financeiro.tb_comissao_".$mesAno.".cm_data, 'DD/MM/YYYY') AS cm_data, 
						to_char( financeiro.tb_comissao_".$mesAno.".cm_data_pag, 'DD/MM/YYYY') AS cm_data_pag, 
						financeiro.tb_comissao_".$mesAno.".fk_status_pagamento, 
						financeiro.tb_comissao_".$mesAno.".cm_percent_comissao, 
						usu_ind.usu_nome AS usu_nome_ind, 
						usu_ind.usu_usuario AS usu_usuario,
						financeiro.tb_status_pagamento.sts_nome 
				FROM financeiro.tb_comissao_".$mesAno." 
				INNER JOIN financeiro.tb_status_pagamento ON financeiro.tb_status_pagamento.sts_id = financeiro.tb_comissao_".$mesAno.".fk_status_pagamento 
				LEFT JOIN tb_usuarios usu_ind ON usu_ind.usu_doc = financeiro.tb_comissao_".$mesAno.".fk_usu_indicado ";
		
				
		if( !empty( $filtros['busca'] ) ) {
			$queryBusca = "WHERE ( financeiro.tb_comissao_".$mesAno.".fk_usu_indicou::text = '".$filtros['usu_doc']."' ) AND 
								( ( to_char( financeiro.tb_comissao_".$mesAno.".cm_data, 'DD/MM/YYYY')::text ILIKE '%".$filtros['busca']."%' ) OR 
								( usu_ind.usu_nome::text ILIKE '%".$filtros['busca']."%' ) OR 
								( financeiro.tb_comissao_".$mesAno.".cm_comissao::text = '".$filtros['busca']."' ) OR 
								( financeiro.tb_comissao_".$mesAno.".cm_percent_comissao::text = '".$filtros['busca']."' ) 
							)";
		} else {
			$queryBusca = "WHERE( financeiro.tb_comissao_".$mesAno.".fk_usu_indicou = '".$filtros['usu_doc']."' ) ";	
		}

		$queryPt .= $queryBusca;

		$retornoPt = $this->ListarComissoesUsuarioPaginacao( $queryPt, $filtros['pagina'], $filtros['limit'] );
						
		$query .= $queryBusca;
		//echo $query;
		$query .= "ORDER BY financeiro.tb_comissao_".$mesAno.".cm_id DESC ";
		$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
						
		//echo $sql; die;
		$result = $this->banco->conexao->prepare($query);
		$result->execute();
		$ret = $result->fetchAll(PDO::FETCH_ASSOC);
		
		$retorno['busca'] = $ret;
		$retorno['paginacao'] = $retornoPt;
		
		return $retorno;
	}
	
	public function ListarComissoesUsuarioPaginacao($sql, $pagina, $regpag ) {
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
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(comissao_paginacao(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(comissao_paginacao(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(comissao_paginacao(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(comissao_paginacao(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>';

		return $html;
	}
	
	public function getMeses() {
		$meses = array();
		$anoAnt = ( date('Y')-1 );
		for( $j=$anoAnt; $j<=date('Y'); $j++ ) {
			for( $i=1; $i<=12; $i++ ) {
				$mes = ( $i < 10 ) ? '0'.$i : $i;
				$ano = $j;
				$verifica = $this->VerificaExisteTabela($mes.'_'.$ano, false);
				if( $verifica == true ) {
					$meses[] = 	$mes.'_'.$ano;
				}
			}
		}
		
		return $meses;
	}
}
?>