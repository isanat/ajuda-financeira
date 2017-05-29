<?php

class MeusDados extends TbUsuarios
{
	public $endereco;
	
	public function dadospessoais()
	{
		$fones = new Fones;
		$fones->SetFkUsu( $_SESSION['usuario']['usu_doc'] );
		$dados['usu'] = $this->getUsuarioOn();
		$dados['end'] = $this->getEndOn();
		$dados['fones'] = $fones->getFones();
		$inativo = $this->banco->executar("
						SELECT 
						usu.usu_usuario,
						usu.usu_doc,
						to_char(ped.ped_data_expira, 'DD/MM/YYYY' ) as ped_data_expira
						FROM 
						public.tb_usuarios as usu,
						public.tb_pedidos as ped
						WHERE
						usu.usu_doc = '{$_SESSION['usuario']['usu_doc']}' AND
						usu.usu_doc = ped.fk_usu AND
						ped.ped_nivel = 1 AND
						ped.fk_status = 1 AND
						usu.fk_status = 1 
						");	
	   
	   $dados['inativo'] = $inativo;
	   
	   foreach($fones->getFones() as $fone){
		
		if($fone['fk_tipo'] == 1){
		 $dados['resi'] = $fone['fone_fone'];
		 $dados['resId'] = $fone['fone_id'];
        }
		if($fone['fk_tipo'] == 2){
		  $dados['comer'] = $fone['fone_fone'];
		  $dados['comerId'] = $fone['fone_id'];
        }
		if($fone['fk_tipo'] == 3){
		 $dados['cel'] = $fone['fone_fone'];
		 $dados['celId'] = $fone['fone_id'];
        }
		if($fone['fk_tipo'] == 4){
		 $dados['whatsapp'] = $fone['fone_fone'];
		 $dados['whatsId'] = $fone['fone_id'];
        }
		
	   }

		return $dados;
	}
	
	
		public function getUsuarioOn(){
	  $usu = $this->banco->executar("
			SELECT 
				usu_id,
				usu_nome,
				usu_usuario,
				usu_doc,
				usu_sexo,
				usu_email,
				to_char(usu_datanasc, 'DD/MM/YYYY') as usu_datanasc
			FROM 
				public.tb_usuarios 
			WHERE 
				usu_doc = '".$_SESSION['usuario']['usu_doc']."'");
				  return $usu;
	}
	
	
	public function getEndOn(){
	  $end = $this->banco->executar("SELECT * FROM public.tb_endereco WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."'");
	  return $end;
	}
	
	public function dadosbancarios()
	{
		
		
		$res = array();
		 
		if(isset($_POST['insertB']) == "ok")
		{
			if($_POST['banco_code'] != '0')
			{
				$_POST['fk_usu'] = $_SESSION['usuario']['usu_doc'];
				
				
				unset($_POST['insertB']);		 
				
				
				$res = $this->banco->inserir('tb_dados_banco',$_POST);
				$res['resultado']['ok'] = 'Conta cadastrada com Sucesso!';
				
				
			}else{ $res['resultado']['erro'] = 'Erro ao cadastrar conta, favor tente novamente!';}
		}
		
		if(isset($_POST['banco_id']))
		{
			$id = $_POST['banco_id'];
			
			$this->banco->excluir('public.tb_dados_banco',"banco_id = {$id} AND fk_usu = '{$_SESSION['usuario']['usu_doc']}'");
			
			$res['resultado']['ok'] = 'Conta Excluida com Sucesso!';
		}

		
		$res['bancos'] = $this->banco->executar('SELECT * FROM public.tb_banco');
		$res['contas'] = $this->banco->executar("SELECT b.cod_nome, d.* FROM public.tb_dados_banco d
													INNER JOIN public.tb_banco b ON d.banco_code = b.cod_code
													WHERE d.fk_usu = '{$_SESSION['usuario']['usu_doc']}'");
		
		$inativo = $this->banco->executar("
						SELECT 
						usu.usu_usuario,
						usu.usu_doc,
						to_char(ped.ped_data_expira, 'DD/MM/YYYY' ) as ped_data_expira
						FROM 
						public.tb_usuarios as usu,
						public.tb_pedidos as ped
						WHERE
						usu.usu_doc = '{$_SESSION['usuario']['usu_doc']}' AND
						usu.usu_doc = ped.fk_usu AND
						ped.ped_nivel = 1 AND
						ped.fk_status = 1 AND
						usu.fk_status = 1 
						");	
	   
	   $res['inativo'] = $inativo;
		
		return $res;
	}
	
	public function alterarsenha()
	{
		$inativo = $this->banco->executar("
						SELECT 
						usu.usu_usuario,
						usu.usu_doc,
						to_char(ped.ped_data_expira, 'DD/MM/YYYY' ) as ped_data_expira
						FROM 
						public.tb_usuarios as usu,
						public.tb_pedidos as ped
						WHERE
						usu.usu_doc = '{$_SESSION['usuario']['usu_doc']}' AND
						usu.usu_doc = ped.fk_usu AND
						ped.ped_nivel = 1 AND
						ped.fk_status = 1 AND
						usu.fk_status = 1 
						");	
	   
	   $res['inativo'] = $inativo;
	   return $res;
	   
	}
	
	public function cartao_ajax()
	{
		if($_POST['acao'] == 'listar')
		{
			return array('lista' => $this->banco->executar("SELECT c.*, s.status_nome FROM tb_card c INNER JOIN tb_status_usu s ON c.fk_status = s.status_id WHERE card_id = {$_POST['id']}"),
			'template' => 'ajax/modal_card'
			);
		}elseif($_POST['acao'] == 'apagar')
		{
			$this->banco->executar("DELETE FROM public.tb_card WHERE card_id = {$_POST['id']}");
			return true;
		}
	}
	
	public function cartao()
	{
		if(isset($_POST['card_doc']))
		{
			$_POST['card_doc'] = ($_POST['card_doc'] == '')?$_SESSION['usuario']['usu_doc']:$_POST['card_doc'];
			$this->SetUsuDoc($_POST['card_doc']);
			$this->SetUsuDatanasc($_POST['card_datanasc']);
			
			$this->endereco = new TbEndereco;
			$this->endereco->SetEndCep($_POST['card_cep']);
			
			$_POST['card_doc'] = $this->GetUsuDoc();
			$_POST['card_datanasc'] = $this->GetUsuDatanasc();
			$_POST['card_cep'] = $this->endereco->GetEndCep();
			$_POST['fk_usu'] = $_SESSION['usuario']['usu_doc'];
			
			
			$this->banco->inserir('public.tb_card',$_POST);
		}
		
		$habilitado = ($this->banco->executar("SELECT * FROM tb_card WHERE card_doc = '{$_SESSION['usuario']['usu_doc']}'"))?'sim':'nao';
		$limite = $this->banco->executar("SELECT count(card_id) as total FROM tb_card WHERE fk_usu = '{$_SESSION['usuario']['usu_doc']}'");
		$ped = $this->banco->executar("SELECT p.ped_id, c.cart_qtd FROM public.tb_pedidos as p
											INNER JOIN public.tb_carrinho c ON c.fk_sessao = p.ped_sessao
											WHERE p.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND p.fk_status = 3 AND c.fk_prod in (18,19)
											ORDER BY ped_id ASC LIMIT 1");
		
		return array(
		'lista' => $this->banco->executar("SELECT c.*, s.status_nome FROM tb_card c INNER JOIN tb_status_usu s ON c.fk_status = s.status_id WHERE fk_usu = '{$_SESSION['usuario']['usu_doc']}'"),
		'habilitado' => $habilitado,
		'limite' => $limite[0]['total'],
		'ped' => $ped
		);
	
	}
	
	public function adm_cartao()
	{
		$usu = Controller::$parametros;
		
		$doc = $this->banco->ver('public.tb_usuarios','usu_doc', "usu_usuario = '{$usu['usuario']}'");
		
		if(isset($_POST['card_doc']))
		{
			
			$this->SetUsuDoc($_POST['card_doc']);
			$this->SetUsuDatanasc($_POST['card_datanasc']);
			
			$this->endereco = new TbEndereco;
			$this->endereco->SetEndCep($_POST['card_cep']);
			
			$_POST['card_doc'] = $this->GetUsuDoc();
			$_POST['card_datanasc'] = $this->GetUsuDatanasc();
			$_POST['card_cep'] = $this->endereco->GetEndCep();
			$_POST['fk_usu'] = $doc['usu_doc'];
			
			
			$this->banco->inserir('public.tb_card',$_POST);
		}elseif(isset($_POST['card_card']))
		{
		
		$this->banco->editar('public.tb_card',array(
															'card_card' => $_POST['card_card'],
															'fk_status' => 2
														), "card_id = {$_POST['card_id']}"
			);
		}
		
		$habilitado = ($this->banco->executar("SELECT * FROM tb_card WHERE card_doc = '{$doc['usu_doc']}'"))?'sim':'nao';
		$limite = $this->banco->executar("SELECT count(card_id) as total FROM tb_card WHERE fk_usu = '{$doc['usu_doc']}'");
		
		return array(
		'lista' => $this->banco->executar("SELECT c.*, s.status_nome FROM tb_card c INNER JOIN tb_status_usu s ON c.fk_status = s.status_id WHERE fk_usu = '{$doc['usu_doc']}'"),
		'habilitado' => $habilitado,
		'limite' => $limite[0]['total']
		);
	
	}
	
	public function alterarsenha_ajax()
	{
		$valida['resSenha'] = false;
		if( $_REQUEST['validaSenhaAtual'] ) {
			$this->SetUsuDoc( $_SESSION['usuario']['usu_doc'] );
			$this->SetUsuSenha( $_REQUEST['usu_senha'] );
			if( $this->ValidaSenha() ) {
				$valida['resSenha'] = '<span class="label label-success">OK</span>';
			} else {
				$valida['resSenha'] = '<span class="label label-important">SENHA INVÁLIDA</span>';
			}
		} elseif( $_REQUEST['alterarSenha'] == 1 ) {
			if( $_REQUEST['novaSenha'] == $_REQUEST['confNovaSenha'] ) {
				$this->SetUsuDoc( $_SESSION['usuario']['usu_doc'] );
				$this->SetUsuSenha( $_REQUEST['senhaAtual'] );
				if( $this->ValidaSenha() ) {
					$this->SetUsuSenha( $_REQUEST['novaSenha'] );
					$this->AlterarSenhaUsu();
					$valida['resSenha'] = '<div class="alert alert-success">
												<button data-dismiss="alert" class="close" type="button">×</button>
												<strong>SUCESSO!</strong> - SENHA ALTERADA
											</div>';
				} else {
					$valida['resSenha'] = '<div class="alert alert-error">
												<button data-dismiss="alert" class="close" type="button">×</button>
												<strong>ERRO!</strong> - SENHA ATUAL INVÁLIDA
											</div>';
				}
			} else {
				$valida['resSenha'] = '<div class="alert alert-error">
											<button data-dismiss="alert" class="close" type="button">×</button>
											<strong>ERRO!</strong> - AS SENHAS ESTÃO DIFERENTES
										</div>';
			}
		}
		
		return $valida;
	}
	
	public function alterartoken()
	{
	
	}
	
	public function meuspedidos()
	{
	
	}
	
public function VerEmailAjax($post_email = null)
	{
		if (isset($_POST['usu_email'])){$post_email = $_POST['usu_email'];}
		$this->SetUsuEmail($post_email);
		$email_form = $this->GetUsuEmail();
		$dados_usu = Controller::$dados_usu;
		$email_usu = $dados_usu['usuario']['usu_email'];//echo $email_usu;die;
		
			if($email = $this->banco->ver_isset('tb_usuarios',array('usu_email'=>$email_form)) === false 
					|| $email_form == $email_usu)
			{
			
				if(($res = $this->ValidaEmail()) === true)
				{
					echo 'ok';die;
				} else {

					echo 'nao';die;

				}
			
			} else {
				echo 'nao';die;
			}
	}
	
	public function VerEmail($post_email = null)
	{
		if (isset($_POST['usu_email'])){
			$post_email = $_POST['usu_email'];
		}
		$this->SetUsuEmail($post_email);
		$email_form = $this->GetUsuEmail();
		$dados_usu = Controller::$dados_usu;
		$email_usu = $dados_usu['usuario']['usu_email'];//echo $email_usu;die;
	
		if($email = $this->banco->ver_isset('tb_usuarios',array('usu_email'=>$email_form)) === false
				|| $email_form == $email_usu)
		{
				
			if(($res = $this->ValidaEmail()) === true)
			{
				return 'ok';
			} else {
	
				return 'nao';
	
			}
				
		} else {
			return 'nao';
		}
	}
	
	public function Correios()
	{

		$cep = $_REQUEST['cep'];
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
			
		echo json_encode($res);die;
	}
	
public function MaiorIdadeAjax($idade = null)
	{
		if (isset($_POST['usu_datanasc'])){
			$idade = $_POST['usu_datanasc'];
		}
		
		$this->SetUsuDatanasc($idade);
		
		if($this->VerMaiorIdade())
		{
			echo 'ok';die;
			
		} else {
			
			echo 'nao';die;
			
		}
	}
	
	public function MaiorIdade($idade = null)
	{
		if (isset($_POST['usu_datanasc'])){
			$idade = $_POST['usu_datanasc'];
		}
	
		$this->SetUsuDatanasc($idade);
	
		if($this->VerMaiorIdade())
		{
			return 'ok';
				
		} else {
				
			return 'nao';
				
		}
	}
	
	public function UpUsu()
	{
		$doc = $_SESSION['usuario']['usu_doc'];
		
		$where = " usu_doc = '{$doc}'";
		$tabela = 'public.tb_usuarios';
			
	    if($_POST['acao'] == "atualizar") {		
		//$_SESSION['usuario']['usu_doc'] = $_POST['doc'];

	     $dados = array(
			 "usu_nome"=>$_POST['usu_nome'],			 
			 "usu_sexo"=>$_POST['usu_sexo'],
			 "usu_email"=>$_POST['usu_email'],
			 "usu_datanasc"=>implode("-",array_reverse(explode("/",$_POST['usu_datanasc'])))
		   );
			
			//echo "<pre>"; print_r($dados); die;
			
			$this->banco->editar($tabela,$dados,$where);
			echo 'ok'; die;
						
		} else {
			echo 'nao'; die;
		}
		
	}
	
	public function UpEnd()
	{
		
		$this->endereco = new TbEndereco;
		
		$doc = $_SESSION['usuario']['usu_doc'];
		$where = " fk_usu = '{$doc}'";
		$tabela = 'public.tb_endereco';
        $end_uf = strtoupper($_POST['end_uf']);
		
		
			if($_POST['acao'] == 'upend'){
						
			  $usu = $this->banco->executar("SELECT * FROM public.tb_endereco WHERE fk_usu = '".strip_tags(trim($doc))."'");	
					
			   if(!empty($usu[0])){		
					$dados = array(
						 "end_cep"=>$_POST['end_cep'],
						 "end_end"=>$_POST['end_end'],
						 "end_n"=>$_POST['end_n'],
						 "end_comp"=>$_POST['end_comp'],
						 "end_bairro"=>$_POST['end_bairro'],
						 "end_cidade"=>$_POST['end_cidade'],
						 "end_uf"=>$end_uf
		  			);	

				 $this->banco->editar($tabela,$dados,$where);
				 echo 'ok'; die;
			   }else{
			     
				$dados = array(
						 "end_cep"=>$_POST['end_cep'],
						 "end_end"=>$_POST['end_end'],
						 "end_n"=>$_POST['end_n'],
						 "end_comp"=>$_POST['end_comp'],
						 "end_bairro"=>$_POST['end_bairro'],
						 "end_cidade"=>$_POST['end_cidade'],
						 "end_uf"=>$end_uf,
						 "fk_usu"=>$doc
		  			);	
				 
				 $this->banco->inserir($tabela,$dados);
				 echo 'ok'; die;			 
			 }
						
			} else {
				
				echo 'nao'; die;
			}		
		
	}
   
   public function upFoneUsu()
	{

if($_POST['acao'] == 'upFone'){

	 $fone = $this->banco->executar("SELECT * FROM tb_fone WHERE fk_tipo = 1 and fk_usu = '".$_SESSION['usuario']['usu_doc']."'");
	  if(!empty($fone)){  
		$dados = array("fone_fone"=>$_POST['fone_fixo'], 'fk_usu'=>$_SESSION['usuario']['usu_doc'],'fk_tipo'=>1);	
		$this->banco->editar("public.tb_fone", $dados, " fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fone_id = '".$fone[0]['fone_id']."'");
		
	  }else{
	    $dados = array("fone_fone"=>$_POST['fone_fixo'], 'fk_usu'=>$_SESSION['usuario']['usu_doc'],'fk_tipo'=>1);	
		$this->banco->inserir("public.tb_fone", $dados);
		 
	  }
     
	 
	$comer = $this->banco->executar("SELECT * FROM tb_fone WHERE fk_tipo = 2 and fk_usu = '".$_SESSION['usuario']['usu_doc']."'");
	  if(!empty($comer)){  
		$dados = array("fone_fone"=>$_POST['fone_comercial'], 'fk_usu'=>$_SESSION['usuario']['usu_doc'],'fk_tipo'=>2);	
		$this->banco->editar("public.tb_fone", $dados, " fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fone_id = '".$comer[0]['fone_id']."'");
	
	  }else{
	    $dados = array("fone_fone"=>$_POST['fone_comercial'], 'fk_usu'=>$_SESSION['usuario']['usu_doc'],'fk_tipo'=>2);	
		$this->banco->inserir("public.tb_fone", $dados);
			 
	  }
	 
	 
	  $cel = $this->banco->executar("SELECT * FROM tb_fone WHERE fk_tipo = 3 and fk_usu = '".$_SESSION['usuario']['usu_doc']."'");
	  if(!empty($cel)){  
		$dados = array("fone_fone"=>$_POST['fone_celular'], 'fk_usu'=>$_SESSION['usuario']['usu_doc'],'fk_tipo'=>3);	
		$this->banco->editar("public.tb_fone", $dados, " fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fone_id = '".$cel[0]['fone_id']."'");

	  }else{
	    $dados = array("fone_fone"=>$_POST['fone_celular'], 'fk_usu'=>$_SESSION['usuario']['usu_doc'],'fk_tipo'=>3);	
		$this->banco->inserir("public.tb_fone", $dados);
			 
	  }
	  
	  $whatsapp = $this->banco->executar("SELECT * FROM tb_fone WHERE fk_tipo = 4 and fk_usu = '".$_SESSION['usuario']['usu_doc']."'");
	  //echo "<pre>"; print_r( $whatsapp ); die;
	  
	  if(!empty($whatsapp)){  
		$dados = array("fone_fone"=>$_POST['fone_whatsapp'], 'fk_usu'=>$_SESSION['usuario']['usu_doc'],'fk_tipo'=>4);	
		$this->banco->editar("public.tb_fone", $dados, " fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fone_id = '".$whatsapp[0]['fone_id']."'");

	  }else{
	    $dados = array("fone_fone"=>$_POST['fone_whatsapp'], 'fk_usu'=>$_SESSION['usuario']['usu_doc'],'fk_tipo'=>4);	
		$this->banco->inserir("public.tb_fone", $dados);			 
	  }
	  
	 echo 'ok'; die;	
			
} else {
	
	echo 'nao'; die;
}		
		
	}



	public function UpFone() {		
		$this->fone = new TbFone;
		
		$doc = $_SESSION['usuario']['usu_doc'];
		$tabela = $_POST['tabela'];
		
		unset($_POST['tabela']);
		
		$_POST['fone_fixo'] = str_replace('.', '', $_POST['fone_fixo']);
		$_POST['fone_fixo'] = str_replace('(', '', $_POST['fone_fixo']);
		$_POST['fone_fixo'] = str_replace(')', '', $_POST['fone_fixo']);
		$_POST['fone_fixo'] = str_replace(' ', '', $_POST['fone_fixo']);
		
		$_POST['fone_celular'] = str_replace('.', '', $_POST['fone_celular']);
		$_POST['fone_celular'] = str_replace('(', '', $_POST['fone_celular']);
		$_POST['fone_celular'] = str_replace(')', '', $_POST['fone_celular']);
		$_POST['fone_celular'] = str_replace(' ', '', $_POST['fone_celular']);
		
		
		$_POST['fone_comercial'] = str_replace('.', '', $_POST['fone_comercial']);
		$_POST['fone_comercial'] = str_replace('(', '', $_POST['fone_comercial']);
		$_POST['fone_comercial'] = str_replace(')', '', $_POST['fone_comercial']);
		$_POST['fone_comercial'] = str_replace(' ', '', $_POST['fone_comercial']);		
		
		$this->fone->SetFkUsu($doc);
		$this->fone->verificaFone();
	
		$dados['fone_fone'] = $_POST['fone_fixo'];
		$where = " fk_usu = '{$doc}' and fk_tipo = 1";
		
		if($this->banco->editar($tabela,$dados,$where))
		{
			$dados['fone_fone'] = $_POST['fone_celular'];
			$where = " fk_usu = '{$doc}' and fk_tipo = 2";
			if($this->banco->editar($tabela,$dados,$where)) {
				$dados['fone_fone'] = $_POST['fone_comercial'];
				$where = " fk_usu = '{$doc}' and fk_tipo = 3";
				if($this->banco->editar($tabela,$dados,$where)) {
					echo 'ok'; die;
				} else {
					echo 'nao';	die;
				}
			} else {
				echo 'nao';	die;
			}			
		} else {			
			echo 'nao';die;
		}
	}
	

	
	
	
	public function __call($metodo,$argumanto)
	{
		return 'erro';
	
	}
}