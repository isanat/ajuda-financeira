<?php 

abstract class ApiRepository
{

	public $banco;
	public $token;
	
	public function __construct() {

		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);
		
		if($this->ver_token())
		{
			return true;
			
		}else{
			//echo 'erro';die;
			$this->Erro('Token Invalido','010');
			
		}

	}
	
	protected function ver_token()
	{
		
		$this->GetToken();

	try{
			
			$query = $this->banco->conexao->prepare("
					SELECT usu_doc FROM public.tb_usuarios
					where (usu_doc)::text = (?)::text");
			
			
			$campos = array($this->token);
			
			
			$query->execute($campos);
			
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			
			if(!empty($res[0])){
			
// 			print_r($res[0]['usu_doc']);die;
				return true;
			
			} else {
				return false;
			}
			
		} catch (PDOException $e){

			return false;
		}
		
		
	}
	
	protected function ver_usuario()
	{
	
		try{
				
			$query = $this->banco->conexao->prepare("
					SELECT usu_usuario FROM public.tb_usuarios
					where (usu_usuario)::text = (?)::text");
				
				
			$campos = array($_POST['usu_usuario']);
				
				
			$query->execute($campos);
				
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
				
			if(!empty($res[0])){
					
				// 			print_r($res[0]['usu_doc']);die;
				return true;
					
			} else {
				return false;
			}
				
		} catch (PDOException $e){
	
			return false;
		}
	
	
	}
	
	protected function GetToken()
	{
		$this->token = Controller::$parametros['token'];
		
		return $this->token;
	}
	
	public function LoginUser($usuario,$senha) {
	
		try{
	
			$query_logar = $this->banco->conexao->prepare("
					SELECT usu_doc, fk_status, usu_usuario FROM public.tb_usuarios
					where (usu_usuario)::text = (?)::text and (usu_senha)::text = (?)::text");
	
			$campos = array($usuario,$senha);
	
			$query_logar->execute($campos);
	
			$res = $query_logar->fetchAll(PDO::FETCH_ASSOC);
	
	
			if(!empty($res[0])){
	
				if($res[0]['fk_status'] == 2)
				{
	
					//$_SESSION['usuario'] = $res[0];
	
					//$this->CriarArquivo();
	
					return true;
	
				}elseif($res[0]['fk_status'] == 4)
				{
					return false;
					
				}else{
					return false;
				}
	
			} else {
	
				return false;
					
			}
				
		} catch (PDOException $e){
	
			$msg = 'Erro ao Logar: ' . $e->getMessage();
			$this->banco->log($msg);
		}
	
	
	}
	
	public function ListaCep($cep)
	{
		try{
			
			
		
			$query = $this->banco->executar("
					SELECT u.usu_nome, u.usu_usuario, e.end_cidade, e.end_bairro, e.end_uf
						FROM tb_usuarios u
						INNER JOIN tb_endereco e ON u.usu_doc = e.fk_usu
					
					WHERE e.end_cep in (
					
						SELECT DISTINCT end_cep FROM public.tb_endereco 
					
							WHERE( ( SELECT MAX(end_cep::INT) FROM public.tb_endereco WHERE ( end_cep::INT < {$cep}) ) = end_cep::INT OR 
					
								 (SELECT MIN(end_cep::INT) FROM public.tb_endereco WHERE ( end_cep::INT > {$cep}) ) = end_cep::INT ) ORDER BY end_cep desc
					
					)");
		
			/* $campos = array('end_cep' => $cep);
		
			$query->execute($campos);
		
			$res = $query->fetchAll(PDO::FETCH_ASSOC); */
// 		print_r($query);die;
		
			if(!empty($query[0]['usu_usuario'])){
		
				if(!empty($query[0]['usu_usuario']))
				{
		
					//$_SESSION['usuario'] = $res[0];
		
					//$this->CriarArquivo();
		
					return $query;
		
				}elseif(empty($query[0]['usu_usuario']))
				{
					return false;
						
				}else{
					return false;
				}
		
			} else {
		
				return false;
					
			}
		
		} catch (PDOException $e){
		
			$msg = 'Erro ao Cep: ' . $e->getMessage();
			$this->banco->log($msg);
			return false;
		}
	}
	
	protected function VerUsuario()
	{
	 
		$dados_post = json_decode($_POST['json']);
	
		$usu = $dados_post->usuario;

		try{
	
			$query = $this->banco->conexao->prepare("
					SELECT usu_usuario FROM public.tb_usuarios
					where (usu_usuario)::text = (?)::text");
	
	
			$campos = array($usu);
	
	
			$query->execute($campos);
	
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
	
			if(!empty($res[0])){
					
				// 			print_r($res[0]['usu_doc']);die;
				return true;
					
			} else {
				return false;
			}
	
		} catch (PDOException $e){
	
			return false;
		}
	
	
	}
	
	protected function Erro($msg,$cod)
	{
		$array = array(
				'status' => '0',
				'descricao' => $msg,
				'cod' => $cod
				);
		
		echo json_encode($array);die;
	}
	
	protected function Sucesso($msg,$cod,$dados = null)
	{
		$array = array(
				'status' => '1',
				'descricao' => $msg,
				'dados' => $dados,
				'cod' => $cod
		);
	
		echo json_encode($array);die;
	}
	
	
}