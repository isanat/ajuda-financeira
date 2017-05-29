<?php

include_once( '../Model/Arvore.php' );

$arvore = new Arvore();
/** 
	CONSULTA USUARIOS, MONTA A ARVORE E DEFINE O NÍVEL, RETORNA EM ARRAY 
	parâmetro $resArvore é passado por referência e preenchido pela função
*/
$resArvore = array();
$resArvore = $arvore->getUsuarios();
$resArvore = $arvore->montaArvore( $resArvore, 0 );
$arvore->setNivel( $resArvore, 0, 0 );
/** END - CONSULTA USUARIOS, MONTA A ARVORE E DEFINE O NÍVEL, RETORNA EM ARRAY */

/** 
	BUSCA QUEM INDICOU
	parâmetro $usuario é passado por referência e preenchido pela função
 */
$usuario = array();
$arvore->getUsuarioAcima( $usuario, '48024582236');
/** END - BUSCA QUEM INDICOU */

echo "<pre>";
print_r( $usuario );
echo "</pre>";

echo "<pre>";
print_r( $resArvore );
echo "</pre>";
