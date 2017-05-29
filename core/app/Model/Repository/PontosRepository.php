<?php
class PontosRepository {
	
	public $banco;
	
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function CriarTabelaPontos($data) {
		//$sql = "CREATE SEQUENCE financeiro.tb_pontos_".$data."_pt_id_seq START 1";
		//$result = $this->banco->executar($sql);
		//"pt_id" int8 DEFAULT nextval(\'financeiro.tb_pontos_'.$data.'_pt_id_seq\'::regclass) NOT NULL,
		
		$sql = 'CREATE TABLE financeiro.tb_pontos_'.$data.' (
					"pt_id" serial8 NOT NULL,
					"pt_perna" char(1) NOT NULL,
					"pt_pontos" numeric(10,2) NOT NULL,
					"pt_datapg" date,
					"pt_data" date NOT NULL,
					"fk_ped" int8 NOT NULL, 
					"fk_usu" varchar NOT NULL, 
					"fk_status" int2 NOT NULL, 
					"fk_usu_rede" varchar,
					"fk_status_pagamento" int2,
					CONSTRAINT tb_pontos_'.$data.'_pkey PRIMARY KEY ("pt_id"),
					CONSTRAINT fk_usu_pontos_'.$data.' FOREIGN KEY ("fk_usu") REFERENCES public.tb_usuarios ("usu_doc") ON DELETE NO ACTION ON UPDATE CASCADE,
					CONSTRAINT fk_rede_pontos_'.$data.' FOREIGN KEY ("fk_usu_rede") REFERENCES public.tb_usuarios ("usu_doc") ON DELETE NO ACTION ON UPDATE CASCADE
					)';
		$result = $this->banco->executar($sql);
		
		//$sql = 'ALTER TABLE "financeiro"."tb_pontos_'.$data.'" ADD PRIMARY KEY ("pt_id")';
		//$result = $this->banco->executar($sql);
		
		return true;
	}
	
	public function VerificaExisteTabela($data, $criar=true) {
		$sql = "SELECT
					 relname 
				FROM pg_stat_user_tables 
				WHERE ( relname = 'tb_pontos_".$data."' )
				ORDER BY relname";
		$result = $this->banco->executar($sql);
		
		if( !$result ) {
			if( $criar == true ) {
				$this->CriarTabelaPontos($data);
				return true;
			}
			return false;
		} else {
			return true;	
		}
	}
	
	public function VerificaExistePontuacao($data) {
		try{
			$id = $this->GetFkPed();
			$res = $this->banco->ver("financeiro.tb_pontos_{$data}",'pt_id',"fk_ped = {$id}");
			return $res;
		}
		catch( PDOException $e ) {
			$msg = 'Erro ao selecionar categoria de produto: ' . $e->getMessage();
			$this->banco->log( $msg );
			return $msg;
		}
	}
	
	public function updatePagarPontos( $statusPagamento, $mes_ano ) {
		$sql = "UPDATE financeiro.tb_pontos_".$mes_ano." SET 
					pt_datapg = now(), 
					fk_status_pagamento = ".$statusPagamento." 
					WHERE( pt_id = ".$this->GetPtId()." )";
		$this->banco->executar($sql);
	}
	
	public function getRegistroPonto( $mes_ano ) {
		$id = $this->GetPtId();
		$sql = "SELECT * 
					FROM financeiro.tb_pontos_".$mes_ano." 
					WHERE( pt_id = ".$id." )";
		$res = $this->banco->executar($sql);
		
		return $res[0];
	}
	
	public function GetPontos($prodId) {
				
		$sql = "SELECT  tb_carrinho.cart_pontos, 
						tb_carrinho.cart_qtd, 
						tb_carrinho.cart_valor 
					FROM tb_pedidos 
					INNER JOIN tb_carrinho ON tb_carrinho.fk_sessao = tb_pedidos.ped_sessao 
				WHERE( tb_pedidos.ped_id = ".$prodId." )";
		
				
		$result = $this->banco->conexao->prepare($sql);
		$result->execute();
		$ret = $result->fetchAll(PDO::FETCH_ASSOC);
		
		return $ret;
	}
	
	public function InserePontuacao($dados, $dataTabela) {
		$this->VerificaExisteTabela($dataTabela);
		$pontos = $this->GetPtPontos();
		$ped = $this->GetFkPed();
		$fk_status_pagamento = $this->GetFkStatusPagamento();
		
		$campos = array( 'pt_perna' 				=> $dados['usu_perna'], 
							'pt_pontos' 			=> $pontos, 
							'fk_status'				=> 2, 
							'pt_data' 				=> date('Y-m-d H:i:s'), 
							'fk_ped' 				=> $ped, 
							'fk_usu_rede' 			=> $this->GetFkUsuRede(), 
							'fk_usu' 				=> $dados['usu_doc'], 
							'fk_status_pagamento'	=> $fk_status_pagamento 
						);
		return $this->banco->inserir('financeiro.tb_pontos_'.$dataTabela,$campos);	
	}
	
	
	
	public function GetPontosUsuario($idUsu, $perna, $mesAno) {
		
		/*$sql = "SELECT SUM(financeiro.tb_pontos_".$mesAno.".pt_pontos) AS total 
				FROM financeiro.tb_pontos_".$mesAno." 
				WHERE( financeiro.tb_pontos_".$mesAno.".pt_perna = '".$perna."' ) AND 
						( financeiro.tb_pontos_".$mesAno.".fk_usu = '".$idUsu."' ) AND 
						( financeiro.tb_pontos_".$mesAno.".fk_status_pagamento = 1 ) AND 
						( financeiro.tb_pontos_".$mesAno.".fk_status_perna = '1' )"; */
		
		$this->VerificaExisteTabela($mesAno);
		
		$sql = "WITH RECURSIVE familia (usu_doc, usu_usuario, parente, nivel, path) AS
                    (
                        SELECT 
                            r1.usu_doc, r1.usu_usuario, r1.fk_usu_rede, 1 AS nivel, array[r1.usu_id]
                        FROM tb_usuarios AS r1
                        WHERE 
                            r1.fk_usu_rede = '{$idUsu}' AND r1.usu_perna = '{$perna}'
                        UNION ALL
                        SELECT 
                            r2.usu_doc, r2.usu_usuario, r2.fk_usu_rede, f.nivel + 1 AS nivel, (f.path || r2.usu_id)
                        FROM tb_usuarios AS r2
                        INNER JOIN familia f ON r2.fk_usu_rede = f.usu_doc
                        WHERE
                            f.nivel <= 1000   
                    )
                    
                    SELECT 
                        sum(p.pt_pontos) as total
                    FROM 
                    	familia f 
					INNER JOIN financeiro.tb_pontos_$mesAno p ON p.fk_usu = '{$idUsu}' AND p.fk_usu_rede = f.usu_doc AND p.fk_status_pagamento = 1";
						
		//echo $sql; die;
		$result = $this->banco->conexao->prepare($sql);
		$result->execute();
		$ret = $result->fetchAll(PDO::FETCH_ASSOC);
		
		$ret[0]['total'] = ( empty( $ret[0]['total'] ) ) ? 0 : $ret[0]['total'];
		return $ret[0];			
	}
	
	public function valida_usu_perna($usu, $rede, $perna)
	{
		$query = "WITH RECURSIVE familia (usu_doc, fk_usu_rede) AS
                    (
                        SELECT 
                            r1.usu_doc, r1.fk_usu_rede
                        FROM tb_usuarios AS r1
                        WHERE 
                            r1.fk_usu_rede = '{$usu}' AND r1.usu_perna = '{$perna}'
                        UNION ALL
                        SELECT 
                            r2.usu_doc, r2.fk_usu_rede
                        FROM tb_usuarios AS r2
                        INNER JOIN familia f ON r2.fk_usu_rede = f.usu_doc  
                    )
                    SELECT 
                        f.usu_doc
                    FROM 
                    familia f 
					WHERE f.usu_doc = '{$rede}'";
					
		$result = $this->banco->conexao->prepare($query);
		$result->execute();
		$res = $result->fetchAll(PDO::FETCH_ASSOC);
		
		return $res;
					
					
		
	}
	
	public function ListarPontosUsuario($filtros) {
		$mesAno = $filtros['mes'].'_'.$filtros['ano'];
		
		$this->VerificaExisteTabela(date("m_Y"));
		
	   
	   $queryPt = "WITH RECURSIVE familia (usu_doc, usu_usuario, fk_usu_rede) AS
                    (
                        SELECT 
                          r1.usu_doc, r1.usu_usuario, r1.fk_usu_rede
                        FROM tb_usuarios AS r1
                        WHERE 
                            r1.fk_usu_rede = '".$filtros['usu_doc']."' AND r1.usu_perna = '".$filtros['perna']."'
                        UNION ALL
                        SELECT 
                            r2.usu_doc, r2.usu_usuario, r2.fk_usu_rede
                        FROM tb_usuarios AS r2
                        INNER JOIN familia f ON r2.fk_usu_rede = f.usu_doc
                    )
                    
                    SELECT 
                        COUNT(*)
                    FROM 
                        familia f 
                    INNER JOIN financeiro.tb_pontos_".date("m_Y")." p ON p.fk_usu = '".$filtros['usu_doc']."' AND p.fk_usu_rede = f.usu_doc ";
					
					
	$pendente = $this->banco->executar("WITH RECURSIVE familia (usu_doc, usu_usuario, fk_usu_rede) AS
                    (
                        SELECT 
                          r1.usu_doc, r1.usu_usuario, r1.fk_usu_rede
                        FROM tb_usuarios AS r1
                        WHERE 
                            r1.fk_usu_rede = '".$filtros['usu_doc']."' AND r1.usu_perna = '".$filtros['perna']."'
                        UNION ALL
                        SELECT 
                            r2.usu_doc, r2.usu_usuario, r2.fk_usu_rede
                        FROM tb_usuarios AS r2
                        INNER JOIN familia f ON r2.fk_usu_rede = f.usu_doc
                    )
                    
                    SELECT 
                         p.pt_id, p.pt_pontos, p.pt_data,  p.pt_perna, f.usu_usuario, p.pt_datapg, p.fk_status_pagamento
                    FROM 
                        familia f 
                    INNER JOIN financeiro.tb_pontos_".date("m_Y")." p ON p.fk_usu = '".$filtros['usu_doc']."' AND p.fk_usu_rede = f.usu_doc AND p.fk_status_pagamento = 1 ");
	
	$pagos = $this->banco->executar("WITH RECURSIVE familia (usu_doc, usu_usuario, fk_usu_rede) AS
                    (
                        SELECT 
                          r1.usu_doc, r1.usu_usuario, r1.fk_usu_rede
                        FROM tb_usuarios AS r1
                        WHERE 
                            r1.fk_usu_rede = '".$filtros['usu_doc']."' AND r1.usu_perna = '".$filtros['perna']."'
                        UNION ALL
                        SELECT 
                            r2.usu_doc, r2.usu_usuario, r2.fk_usu_rede
                        FROM tb_usuarios AS r2
                        INNER JOIN familia f ON r2.fk_usu_rede = f.usu_doc
                    )
                    
                    SELECT 
                         p.pt_id, p.pt_pontos, p.pt_data,  p.pt_perna, f.usu_usuario, p.pt_datapg, p.fk_status_pagamento
                    FROM 
                        familia f 
                    INNER JOIN financeiro.tb_pontos_".date("m_Y")." p ON p.fk_usu = '".$filtros['usu_doc']."' AND p.fk_usu_rede = f.usu_doc AND p.fk_status_pagamento = 2 ");				
					

	$query = "WITH RECURSIVE familia (usu_doc, usu_usuario, fk_usu_rede) AS
                    (
                        SELECT 
                          r1.usu_doc, r1.usu_usuario, r1.fk_usu_rede
                        FROM tb_usuarios AS r1
                        WHERE 
                            r1.fk_usu_rede = '".$filtros['usu_doc']."' AND r1.usu_perna = '".$filtros['perna']."'
                        UNION ALL
                        SELECT 
                            r2.usu_doc, r2.usu_usuario, r2.fk_usu_rede
                        FROM tb_usuarios AS r2
                        INNER JOIN familia f ON r2.fk_usu_rede = f.usu_doc
                    )
                    
                    SELECT 
                        p.pt_id, p.pt_pontos, p.pt_data,  p.pt_perna, f.usu_usuario, p.pt_datapg, p.fk_status_pagamento
                    FROM 
                        familia f 
                    INNER JOIN financeiro.tb_pontos_".date("m_Y")." p ON p.fk_usu = '".$filtros['usu_doc']."' AND p.fk_usu_rede = f.usu_doc ";
		           
				if( !empty( $filtros['busca'] ) ) {
						$queryBusca = " WHERE ( p.fk_usu::text = '".$filtros['usu_doc']."' ) AND 
											( ( to_char( p.pt_data, 'DD/MM/YYYY')::text ILIKE '%".$filtros['busca']."%' ) OR 
											( f.usu_usuario::text ILIKE '%".$filtros['busca']."%' ) OR 
											( p.pt_pontos::text = '".$filtros['busca']."'  ) OR
											( p.pt_id::text = '".$filtros['busca']."'  )
										)";				
										
					}else{
			      $query .= "ORDER BY p.pt_id DESC ";
		          $query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
			       }			   
	   

		$result = $this->banco->conexao->prepare($query.$queryBusca);
		$result->execute();
		$ret = $result->fetchAll(PDO::FETCH_ASSOC);

        $retornoPt = $this->ListarPontosUsuarioPaginacao( $queryPt, $filtros['pagina'], $filtros['limit'] );
		
		$retorno['busca'] = $ret;
		$retorno['pendente'] = $pendente;
		$retorno['pagos'] = $pagos;
		$retorno['paginacao'] = $retornoPt;
         //echo "<pre>"; print_r($retorno); die;
		return $retorno;
	}
	
	public function ListarPontosUsuarioPaginacao($sql, $pagina, $regpag ) {
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		$totalRegistros = $res[0]['count'];
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
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(pontuacao_paginacao(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(pontuacao_paginacao(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(pontuacao_paginacao(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(pontuacao_paginacao(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>';

		return $html;
	}
	
	public function getPontuacaoPeriodo( $intervalo, $idUsu ) {
		$sql = "";
		foreach( $intervalo['union'] AS $tabela ) {
			if( $sql ) {
				$sql .= " UNION SELECT * FROM financeiro.tb_pontos_".$tabela;
			} else {
				$sql = "SELECT * FROM financeiro.tb_pontos_".$tabela;
			}
		}
		
		$sql .= " WHERE ( fk_usu = '".$idUsu."' ) AND ( fk_status_pagamento = '1' ) AND ( pt_data BETWEEN '".$intervalo['inicio']."' AND '".$intervalo['fim']."' ) ORDER BY pt_data ASC";
		$res = $this->banco->executar($sql);
		
		return $res;
	}
	
	public function getUsuariosPeriodo( $intervalo ) {
		$sql = "";
		foreach( $intervalo['union'] AS $tabela ) {
			if( $sql ) {
				$sql .= " UNION SELECT fk_usu FROM financeiro.tb_pontos_".$tabela;
			} else {
				$sql = "SELECT fk_usu FROM financeiro.tb_pontos_".$tabela;
			}
		}
		
		$sql .= " WHERE ( fk_status_pagamento = '1' ) AND ( pt_data BETWEEN '".$intervalo['inicio']."' AND '".$intervalo['fim']."' ) 
					GROUP BY fk_usu";
		$res = $this->banco->executar($sql);
		
		return $res;
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