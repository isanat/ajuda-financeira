<?php 

class Api extends ApiRepository
{
		
	
	
	public function ValidaUsuario()
	{		
		if($this->ver_usuario())
		{
			$this->Sucesso('Usuario Confirmado','01');
			
		}else{			
			$this->Erro("Usuario invalido",'02');
		}		
	}
	
	public function Password($password)
	{
	
		$hash = hash('sha512', '&u*i$r#').$password;
	
		return md5($hash);
	}
	
	public function Transid($cpf)
	{
		usleep(1);
		$seg 		= explode('.', microtime(true));
		$transid	= $cpf.date('YmdHis').$seg[1];
	
		return $transid;
	}
	
	public function LoginUsuario()
	{
		
		$senha = $this->Password($_POST['usu_senha']);
		$usuario = $_POST['usu_usuario'];
		
				
		if($this->LoginUser($usuario,$senha))
		{
			$this->Sucesso('Usuario Confirmado','01');
				
		}else{
				
			$this->Erro("Usuario invalido",'02');
		}
		
	}
	
	public function PreCadastro()
	{
// 		echo '<pre>';print_r($_POST);die;
	
		$this->banco->inserir('public.tb_pre',$_POST);
		
		if($this->banco->ValidaRegistro('public.tb_pre', 'pre_email', "pre_email = '{$_POST['pre_email']}'"))
		{
			$this->Sucesso('Cadastro Confirmado','03');
			
		}else{
			$this->Erro("Erro ao Cadastrar",'04');
		}
		
		
	
	}
	
	public function ProximoCep()
	{
		$cep = str_replace(' ','',str_replace('-','',str_replace(' ', '', $_POST['end_cep'])));
// 		echo '<pre>';print_r($cep);die;
		$ceps = $this->ListaCep($cep);
// 		var_dump($ceps);die;
		if(!empty($ceps))
		{
			$this->Sucesso('Ceps Encontrados','09',$ceps);
				
		}else{
			$this->Erro("Cep Invalido",'07');
		}
	}
	
	public function retorno_pag()
	{
	
		$dados_post = json_decode($_POST['json']);
	
		$transid = $dados_post->transid;
	
		//Faz o Pagamento no sistema
		$query = $this->banco->executar("
				SELECT DISTINCT
				p.ped_id as idpedido,
				p.ped_tipo as tipo
				FROM
				public.tb_pedidos as p
				WHERE
				p.ped_transid = '{$transid}' AND
				p.fk_status = 2
				");
	
	
				$pagar = new Pagamento;
	
				if(!empty($query[0]['idpedido'])){
					
				foreach($query as $post){
					
				$pagar->PagarManual($post['tipo'],$post['idpedido']);
	
				$this->Sucesso('Pagamento Confirmado','01');
					
				}
	
				}else{
	
				$this->Erro("Pagamento invalido",'02');
	
	}
	
		
	}
	
	public function valida_usuario()
	{
		// 		echo 'ok';die;
		if($this->VerUsuario())
		{
			$this->Sucesso('Usuario Confirmado','01');
	
		}else{
	
			$this->Erro("Usuario invalido",'02');
		}
	}
	
	
	
	public function __call($metodo,$argumento)
	{
		$this->Erro("Metodo: '{$metodo}', invalido",'011');
	
	}
	
	
}