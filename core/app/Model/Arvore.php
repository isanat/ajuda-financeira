<?php
	include_once( '../../../config/config_mmn.php' );
	include_once( '../../config/DataMapper.php' );
	include_once( '../../config/Banco.php' );

class Arvore {

	public $banco;

	public function __construct() {
		$this->banco = Banco::conecta('pgsql','mmn');
	}
	
	/** BUSCA TODOS USUÁRIOS DA BASE */
	public function getUsuarios($idUsu=NULL) {
		$sql = "SELECT tb_usuarios.usu_id, 
						tb_usuarios.usu_usuario, 
						tb_usuarios.usu_doc, 
						tb_usuarios.fk_usu, 
						tb_usuarios.fk_status, 
						tb_carreira.ca_nome, 
						tb_carreira.ca_pontos, 
						tb_bonus.bn_nome, 
						tb_bonus.bn_rede_perc, 
						tb_bonus.bn_pontos, 
						tb_bonus.bn_cad_perc 
				FROM tb_usuarios 
				LEFT JOIN tb_carreira ON tb_carreira.ca_id = tb_usuarios.fk_carreira 
				LEFT JOIN tb_bonus ON tb_bonus.bn_id = tb_usuarios.fk_bonus ";
		if( $idUsu ) {
			$sql .= "WHERE ( tb_usuarios.usu_doc = '".$idUsu."' )";	
		}

		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		return $res; //retorna em array
	}
	
	/** 
		BUSCA O USUARIO ACIMA, QUEM INDICOU 
		não encontrou acima, retorna FALSE
		$usuario é recebido por referência
	*/
	public function getUsuarioAcima( &$usuario, $idUsu ) {
		if( $idUsu ) {
			$consulta = $this->getUsuarios( $idUsu );
			if( isset( $consulta[0]['fk_usu'] ) and !empty( $consulta[0]['fk_usu'] ) ) {
				$usuario['indicado'] = $consulta[0];
				$consulta = $this->getUsuarios($consulta[0]['fk_usu']);
				$usuario['indicou'] = $consulta[0];
			} else {
				return false;	
			}
		}
	}
	/** 
		MONTA A ARVORE, RECEBE UM ARRAY E O idPai = 0
		PERCORRE O PROPRIO ARRAY RECURSIVAMENTE RECRIANDO EM UM SEGUNDO ARRAY COM OS FILHOS, NETOS, BISNETOS, ETC.
	*/
	public function montaArvore( $arvore, $idPai, $nivel) {
		$tree2 = array();
		foreach($arvore as $i => $item){
			if($item['fk_usu'] == $idPai) {
				$tree2[$item['usu_doc']] = $item; //simplismente armazena o usuario atual
				$tree2[$item['usu_doc']]['nivel'] = $nivel;
				$tree2[$item['usu_doc']]['submenu'] = $this->montaArvore($arvore, $item['usu_doc'], $nivel); //chamada recursiva para chamar o filho
			}
		}

		return $tree2; // retorna a arvore recriada
	}
	
	public function foo (&$var) {
		$var++;
	}

	/** 
		INSERE O NÍVEL DO USUÁRIO NA ÁRVORE
		$resArvore é recebido por referência
	*/
	public function setNivel( &$resArvore, $nivel, $idPai ) {
		if( !is_array( $resArvore ) ) {
			//return false;
		} else {
			$nivel++;
			foreach( $resArvore AS $id => $arv ) {				
				$resArvore[$id]['nivel'] = $nivel;
				$this->setNivel( $resArvore[$id]['submenu'], $nivel, $id );	
			}
		}		
	}
}

/** exemplos de implementação */
/*

$arvore = new Arvore();

/** 
	CONSULTA USUARIOS, MONTA A ARVORE E DEFINE O NÍVEL, RETORNA EM ARRAY 
	parâmetro $resArvore é passado por referência e preenchido pela função
*/
	//$resArvore = array();
	//$resArvore = $arvore->getUsuarios();
	//$resArvore = $arvore->montaArvore( $resArvore, 0 );
	//$arvore->setNivel( $resArvore, 0, 0 );
/** END - CONSULTA USUARIOS, MONTA A ARVORE E DEFINE O NÍVEL, RETORNA EM ARRAY */

/** 
	BUSCA QUEM INDICOU
	parâmetro $usuario é passado por referência e preenchido pela função
 */
	//$usuario = array();
	//$arvore->getUsuarioAcima( $usuario, '68533390297');
/** END - BUSCA QUEM INDICOU */
