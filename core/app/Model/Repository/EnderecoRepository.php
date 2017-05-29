<?php 

abstract class EnderecoRepository
{

	public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);
	
	}
	
	public function VerEmpty(array $filders)
	{
	
		$filders = $this->NullUsuarios($filders);
	
		foreach($filders as $key => $campos)
		{
			if(empty($filders[$key]) or (strlen($filders[$key]) <= 0))
			{
	
				return false;
	
			}else{
				return true;
			}
		}
	}
	
	public function NullUsuarios(array $filders)
	{
		unset($filders['end_comp']);
		return $filders;
	}
	
	public function ValidaCEP()
	{
	
		$cep = str_replace('-', '', $this->GetEndCep());
		
		$refer = "http://www.correios.com.br/";
	
		$postfields = 'relaxation='.urlencode($cep).'&Metodo='.urlencode("listaLogradouro").'&TipoConsulta='.urlencode("relaxation").'&StartRow='.urlencode("1").'&EndRow='.urlencode("10");
	
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.buscacep.correios.com.br/servicos/dnec/consultaLogradouroAction.do');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3"));
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt ($ch, CURLOPT_HEADER, false);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$resultado = curl_exec($ch);
		curl_close ($ch);
	
		preg_match_all('(<td width="268" style="padding: 2px">(.*)</td>)siU', $resultado, $teste);
		$logradouro = utf8_encode($teste[1][0]);
	
	
		preg_match_all('(<td width="25" style="padding: 2px">(.*)</td>)siU', $resultado, $teste);
		$uf = utf8_encode($teste[1][0]);
	
		preg_match_all('(<td width="140" style="padding: 2px">(.*)</td>)siU', $resultado, $teste);
	
	
		if(empty($teste[1][1]))
		{
			$cidade = utf8_encode($teste[1][0]);
	
			$bairro = null;
	
		}else{
			$cidade = utf8_encode($teste[1][1]);
	
			preg_match_all('(<td width="140" style="padding: 2px">(.*)</td>)siU', $resultado, $teste);
			$bairro = utf8_encode($teste[1][0]);
		}
	
		$logradouro = explode('- ',$logradouro);
	
	
		$res = array(
					
				'logradouro'=>$logradouro[0],
				'bairro'=>$bairro,
				'cidade'=>$cidade,
				'uf'=>$uf
		);
			
		//$res = array_map("htmlentities",$res);
			
		return $res;
		// 		echo json_encode($res);die;
	}
	
}