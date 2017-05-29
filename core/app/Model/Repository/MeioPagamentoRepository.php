<?php 

abstract class MeioPagamentoRepository
{

	public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);

	}
	
	public function gera_boleto_cad($usu,$ped)
	{

		$post = 'valor='.urlencode($ped['valor']).'&pedido='.urlencode($ped['transid']).'&nome='.urlencode($usu['usuario']['usu_nome']).'&email='.urlencode($usu['usuario']['usu_email']);
		$post .= '&logradouro='.urlencode($usu['endereco']['end_end']).'&numero='.urlencode($usu['endereco']['end_n']).'&comp='.urlencode($usu['endereco']['end_comp']);
		$post .='&bairro='.urlencode($usu['endereco']['end_bairro']).'&cidade='.urlencode($usu['endereco']['end_cidade']).'&uf='.urlencode($usu['endereco']['end_uf']).'&cep='.urlencode($usu['endereco']['end_cep']);
		//$cookie_file = '';
		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_URL, 'http://goldpay.com.br/Api/gerar_pedido/token/hbdchjbfvjcbfv521gblvj$4$!goikj');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language: pt-br,en"));
		
		/* curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				"Accept-Language: pt-br,en",
				'Content-Length: ' . strlen($post))
		); */
			
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
			
		curl_setopt ($ch, CURLOPT_HEADER, false);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
			
		
		$resultado = curl_exec ($ch);
		// 	echo $resultado;die;
		curl_close ($ch);
		// 					echo $resultado;die;
		$resul = strripos($resultado, 'status":"1","descricao');
		
			if($resul === false)
			{
					preg_match_all('(descricao":"(.*)","cod)siU', $resultado, $result);
				
					return utf8_encode($result[1][0]);
				
			}else{
				
				preg_match_all('(dados":"(.*)","cod)siU', $resultado, $result);
				return str_replace('\/','/',utf8_encode($result[1][0]));
			}
		}
		
	public function gera_boleto($ped)
	{
		$usu = $this->banco->executar("SELECT * FROM public.vw_v_usuarios_enderecos WHERE usu_doc = '{$_SESSION['usuario']['usu_doc']}'");
		
		$post = 'valor='.urlencode($ped['valor']).'&pedido='.urlencode($ped['transid']).'&nome='.urlencode($usu[0]['usu_nome']).'&email='.urlencode($usu[0]['usu_email']);
		$post .= '&logradouro='.urlencode($usu[0]['end_end']).'&numero='.urlencode($usu[0]['end_n']).'&comp='.urlencode($usu[0]['end_comp']);
		$post .='&bairro='.urlencode($usu[0]['end_bairro']).'&cidade='.urlencode($usu[0]['end_cidade']).'&uf='.urlencode($usu[0]['end_uf']).'&cep='.urlencode($usu[0]['end_cep']);
		
		//echo $post;die;
		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_URL, 'http://goldpay.com.br/Api/gerar_pedido/token/hbdchjbfvjcbfv521gblvj$4$!goikj');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language: pt-br,en"));
		
		/* curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				"Accept-Language: pt-br,en",
				'Content-Length: ' . strlen($post))
		); */
			
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
			
		curl_setopt ($ch, CURLOPT_HEADER, false);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
			
		
		$resultado = curl_exec ($ch);
		// 	echo $resultado;die;
		curl_close ($ch);
		// 					echo $resultado;die;
		$resul = strripos($resultado, 'status":"1","descricao');
		
			if($resul === false)
			{
					preg_match_all('(descricao":"(.*)","cod)siU', $resultado, $result);
				
					return utf8_encode($result[1][0]);
				
			}else{
				
				preg_match_all('(dados":"(.*)","cod)siU', $resultado, $result);
				return str_replace('\/','/',utf8_encode($result[1][0]));
			}
		}
	
}