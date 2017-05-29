<?php 

abstract class ProdutosRepository
{
  public $voucher_id ;
  public $qtd_voucher ;
  public $del_pro;
  public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);

	}
	
	public function getCategorias()
	{
		return $this->banco->executar("SELECT * FROM public.tb_categoria ORDER BY cat_nome ASC");
	}
	
	public function getCategoriasBc($cat=null)
	{
		$categ = ($cat == null)?null:"AND cat_id in ({$cat})";
		
		return $this->banco->executar("SELECT * FROM public.tb_categoria WHERE cat_id != 1 ".$categ." ORDER BY cat_nome ASC");
	}
	
	public function getSubBc($sub=null)
	{
		$subs = ($sub == null)?null:"AND sub_id in ({$sub})";
		
		return $this->banco->executar("SELECT * FROM public.tb_sub WHERE fk_cat != 1 ".$subs);
	}
	
	public function getTipoCarac()
	{
		return $this->banco->executar("SELECT * FROM public.tb_tipo_carac ORDER BY tp_nome ASC");
	}
	
	public function getCarac($carac)
	{
		return $this->banco->executar("SELECT c.carac_id, c.carac_nome, t.tp_nome FROM public.tb_caracteristicas c
										INNER JOIN public.tb_tipo_carac t ON c.fk_carac = t.tp_id
										WHERE c.fk_prod = '{$carac}' ORDER BY tp_nome ASC");
	}
	
	
	public function getBonus() {
		return $this->banco->executar('SELECT * FROM tb_bonus ORDER BY bn_nome ASC');
	}

	public function getFornecedor() {
		return $this->banco->executar('SELECT * FROM tb_fornecedor ORDER BY fn_nome ASC');
	}
	
	public function getFotos($prod)
	{
		return $this->banco->executar("SELECT * FROM public.tb_fotos WHERE fk_prod = '{$prod}' ORDER BY foto_id ASC");
	}
	
	public function getSub($sub)
	{
		return $this->banco->executar("SELECT * FROM public.tb_sub WHERE fk_cat = '{$sub}' ORDER BY sub_sub ASC");
	}
	
	public function getTamanhoProd()
	{
	 	return $this->banco->executar("SELECT carac_id, fk_carac, fk_prod, carac_nome FROM public.tb_caracteristicas WHERE carac_nome is not null");
	}
	
	public function getProduto($prod)
	{
		return $this->banco->executar("
		SELECT 
			*
		FROM 
			public.tb_produtos as po ,
			public.tb_fotos as f
		WHERE 
			f.fk_prod = po.pro_cod AND
			po.fk_sub = '".$prod."' ORDER BY pro_id ASC");
	}
	
	
	public function getCepUsuario() {
		$query = "SELECT end_cep,
		end_end,
		end_n,
		end_comp,
		end_bairro,
		end_cidade,
		end_uf
		FROM tb_endereco WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."'";
		$res = $this->banco->executar($query);
	
		return $res;
	}
	
	public function getProdutosConsultor($categoria=null, $tipo=null) {
		
			$where = ( !empty( $categoria ) ) ? " AND p.fk_sub = {$categoria}" : "";
			$where_tipo = ( !empty( $tipo ) ) ? " p.fk_tipo in ({$tipo})" : "p.fk_tipo != 1";
			
			$query = "SELECT c.carac_id, 
							p.pro_cod,
							p.pro_id,
							p.pro_desc,
							p.pro_nome, 
							s.sub_sub, 
							s.sub_id, 
							b.bn_nome,
							b.bn_pontos,  
							c.carac_valor, 
							c.carac_peso, 
							f.foto_foto 												 
					FROM public.tb_caracteristicas c
					INNER JOIN public.tb_produtos p ON c.fk_prod::text = p.pro_cod::text
					INNER JOIN public.tb_bonus b ON b.bn_id::text = c.fk_bonus::text
					INNER JOIN public.tb_sub s ON s.sub_id::text = p.fk_sub::text
					LEFT JOIN public.tb_fotos f ON p.pro_cod::text = f.fk_prod::text
					WHERE ( $where_tipo ) ".$where." 
					ORDER BY c.carac_valor ASC";
			
					/*$query .= " LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];	
					//echo "<pre>"; print_r($query); die;
		            $res = $this->banco->executar($query);
					
					$queryPag = "SELECT COUNT(*) as total											 
											FROM public.tb_caracteristicas c
											INNER JOIN public.tb_produtos p ON c.fk_prod::text = p.pro_cod::text
											INNER JOIN public.tb_bonus b ON b.bn_id::text = c.fk_bonus::text
											INNER JOIN public.tb_sub s ON s.sub_id::text = p.fk_sub::text
											LEFT JOIN public.tb_fotos f ON p.pro_cod::text = f.fk_prod::text
											WHERE ( $where_tipo ) ".$where." 
											GROUP BY c.carac_valor ORDER BY c.carac_valor ASC";

			$queryPag .= " LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];			
			$retornoPag = $this->paginacao_consultor( $queryPag, $filtros['pagina'], $filtros['limit'] );
			
		   $res['paginacao'] = $retornoPag;*/
		$res = $this->banco->executar($query);
		return $res;
	}
	
	public function paginacao_consultor($sql, $pagina, $regpag ) {
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
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(paginacao_consultor(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(paginacao_consultor(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(paginacao_consultor(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(paginacao_consultor(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>';

		return $html;
	}

	
	
	public function adicionarCarrinhoConsultor() {
		if( !empty( $_POST['valor'] ) ) {
			$valor = explode( ":", $_POST['valor'] );
			
			$res = $this->banco->executar("SELECT c.carac_id, 
													p.pro_cod,
													p.pro_id,
													p.pro_desc,
													p.pro_nome, 
													p.fk_tipo,
													s.sub_sub, 
													b.bn_nome,
													b.bn_pontos,
													c.carac_valor, 
													c.carac_peso, 
													f.foto_foto	,
													c.carac_nome										 
											FROM public.tb_caracteristicas c
											INNER JOIN public.tb_produtos p ON c.fk_prod::text = p.pro_cod::text
											INNER JOIN public.tb_bonus b ON b.bn_id::text = c.fk_bonus::text
											INNER JOIN public.tb_sub s ON s.sub_id::text = p.fk_sub::text
											LEFT JOIN public.tb_fotos f ON p.pro_cod::text = f.fk_prod::text
										WHERE ( p.fk_tipo != 1 ) AND  
													( c.carac_id = '".$valor[1]."' )");
			$qtd = ( isset( $_SESSION['carrinho'][$res[0]['carac_id']]['qtd'] ) ) ? $_SESSION['carrinho'][$res[0]['carac_id']]['qtd'] + $_POST['qtd'] : $_POST['qtd'];
			$res[0]['qtd'] = $qtd;
			$_SESSION['carrinho'][$res[0]['carac_id']] = $res[0];
			
			
			return $res[0];
		} else {
			return false;	
		}
	}
	
	public function adicionarCarrinho() {
		
				
			$res = $this->banco->executar("SELECT c.carac_id,
					p.pro_cod,
					p.pro_id,
					p.pro_desc,
					p.pro_nome,
					p.fk_tipo,
					s.sub_sub,
					b.bn_nome,
					b.bn_pontos,
					c.carac_valor,
					c.carac_peso,
					f.foto_foto	,
					c.carac_nome
					FROM public.tb_caracteristicas c
					INNER JOIN public.tb_produtos p ON c.fk_prod::text = p.pro_cod::text
					INNER JOIN public.tb_bonus b ON b.bn_id::text = c.fk_bonus::text
					INNER JOIN public.tb_sub s ON s.sub_id::text = p.fk_sub::text
					LEFT JOIN public.tb_fotos f ON p.pro_cod::text = f.fk_prod::text
					WHERE ( p.fk_tipo != 1 ) AND p.pro_id = ".$_POST['id']." AND 
					( c.carac_id = '".$_POST['carac']."' )");
			$qtd = ( isset( $_SESSION['carrinho'][$res[0]['carac_id']]['qtd'] ) ) ? $_SESSION['carrinho'][$res[0]['carac_id']]['qtd'] + $_POST['qtd'] : $_POST['qtd'];
			$res[0]['qtd'] = $qtd;
			$_SESSION['carrinho'][$res[0]['carac_id']] = $res[0];
				
				
			return $res[0];
		
	}

	public function updateCarrinhoConsultor() {
		if( !empty( $_POST['idProd'] ) ) {
			if( $_POST['funcao'] == '-' ) {
				if( $_SESSION['carrinho'][$_POST['idProd']]['qtd'] > 1 ) {
					$_SESSION['carrinho'][$_POST['idProd']]['qtd']--;	//Decrementa a quantidade
					return $idProd;
				} else {
					return false;	
				}
			} elseif( $_POST['funcao'] == '+' ) {
				$_SESSION['carrinho'][$_POST['idProd']]['qtd']++;
				return $idProd;
			}
		} else {
			return false;	
		}
	}

	public function deletarCarrinhoConsultor() {
		if( !empty( $_POST['idProd'] ) ) {
			unset( $_SESSION['carrinho'][$_POST['idProd']] );
			return $idProd;
		} else {
			return false;	
		}
	}
	
	public function resPedido(){
     $usu_doc = $_SESSION['usuario']['usu_doc'];
	  return $this->banco->executar("
SELECT * FROM tb_pedidos
WHERE fk_usu = '$usu_doc' AND fk_status = '3'");
 

 }
    public function removerCarrinhoConsultor() {
		if( !empty( $_POST['idProd'] ) ) {
			unset( $_SESSION['carrinho'][$_POST['idProd']] );
			return $idProd;
		} else {
			return false;	
		}
	}
	
  public function getCepCli(){
     $usu_doc = $_SESSION['usuario']['usu_doc'];
	 return $this->banco->executar("SELECT end_cep FROM public.tb_endereco WHERE fk_usu = '$usu_doc'");

 }

 public function produtos_cart($sub, $filtros=null){
 
 	$query = "SELECT
 	tb_produtos.*,
 	tb_caracteristicas.*,
 	tp.tp_nome,
 	tb_fotos.foto_id,
 	tb_fotos.foto_foto,
 	tb_fotos.foto_principal,
 	tb_bonus.bn_pontos
 	FROM tb_produtos
 	LEFT JOIN tb_caracteristicas ON tb_caracteristicas.fk_prod = tb_produtos.pro_cod
 	LEFT JOIN tb_tipo_carac tp ON tb_caracteristicas.fk_carac = tp.tp_id
 	LEFT JOIN tb_fotos ON tb_produtos.pro_cod = tb_fotos.fk_prod
 	LEFT JOIN tb_bonus ON tb_caracteristicas.fk_bonus = tb_bonus.bn_id
 	where tb_produtos.fk_sub = ? and tb_fotos.foto_foto IS NOT NULL AND tb_produtos.fk_tipo != 7
 	ORDER BY tb_produtos.pro_id ASC"; 
 	$query .= " LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset']; 	
 	//echo $query;die;
 	$ver = $this->banco->conexao->prepare($query);
 	$ver->execute(array($sub));
 	$res = $ver->fetchAll(PDO::FETCH_ASSOC);
 	$dados = array();
 	$ver_foto = null;
 	$ver_carac = null; 
 
 	foreach( $res as $key => $value ) {
 		$dados[$res[$key]['pro_cod']]['dados']['pro_id'] = $res[$key]['pro_id'];
 		$dados[$res[$key]['pro_cod']]['dados']['pro_cod'] = $res[$key]['pro_cod'];
 		$dados[$res[$key]['pro_cod']]['dados']['pro_nome'] = $res[$key]['pro_nome'];
 		$dados[$res[$key]['pro_cod']]['dados']['pro_desc'] = $res[$key]['pro_desc'];
 		$dados[$res[$key]['pro_cod']]['dados']['pro_valor'] = $res[$key]['pro_valor'];
 		$dados[$res[$key]['pro_cod']]['dados']['pro_valor_custo'] = $res[$key]['pro_valor_custo'];
 		$dados[$res[$key]['pro_cod']]['dados']['pro_peso'] = $res[$key]['pro_peso'];
 		$dados[$res[$key]['pro_cod']]['dados']['bn_pontos'] = $res[$key]['bn_pontos'];
 

 		if($ver_carac != $res[$key]['carac_id']){
 			$dados[$res[$key]['pro_cod']]['dados']['carac'][] = array(
 					'carac_id' => $res[$key]['carac_id'],
 					'carac_campo' => $res[$key]['tp_nome'],
 					'carac_nome' => $res[$key]['carac_nome'],
 					'carac_valor' => $res[$key]['carac_valor']
 			);
 		}
 		$ver_carac = $res[$key]['carac_id'];

 		if($ver_foto != $res[$key]['foto_id']){
 			$dados[$res[$key]['pro_cod']]['dados']['foto'][] = array(
 					'foto_id' => $res[$key]['foto_id'],
 					'foto_foto' => $res[$key]['foto_foto'],
 					'foto-principal' => $res[$key]['foto_principal']
 			);
 		}
 		$ver_foto = $res[$key]['foto_id'];
 	}
    
	
 	return $dados;
 }

 
public function SearchPaginacao($sql, $pagina, $regpag, $sub ) {
 	$ver = $this->banco->conexao->prepare($sql);
 	$ver->execute(array($sub));
 	$res = $ver->fetchAll(PDO::FETCH_ASSOC);
 	
	//echo count($res); die;
	
 	$totalRegistros = count($res);
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
 	$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(paginacao_p(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
 		
 	//monta 3 links de páginação
 	$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(paginacao_p(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
 	$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
 	$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(paginacao_p(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
 		
 	//monta botao proximo
 	$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(paginacao_p(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
 	$html .= '</ul>
 	</div>
 	</div>
 	</div>';
 
 	return $html;
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
}