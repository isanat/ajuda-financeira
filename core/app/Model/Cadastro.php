<?php 

class Cadastro extends TbUsuarios{

	 public $matrix5 = '3';	 
	
     public function cad_usu(){

	if(isset($_POST['acao']) == "cadastrar"){
		session_regenerate_id();
		

// Se eu não tiver nenhum abaixo ele cadastra pra mim pelo menos uma pessoa pra mim reculperar o dinheiro investido		
$cadMeuDireto = $this->banco->executar("
SELECT count(fk_usu) as total FROM
public.tb_usuarios WHERE fk_usu = '{$_SESSION['usuario']['usu_doc']}'");	    
	
	
$html = "
<table width='100%' border='0' cellpadding='2'>
  <tr>
    <td colspan='2'></td>
  </tr>
  <tr>
    <td colspan='2' align='center'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'><h3>Parabéns! Você deu o primeiro passo para o seu sucesso financeiro</h3></td>
  </tr>
  <tr>
    <td colspan='2'><p><strong>Não deixe passar essa oportunidade de negocio para aumentar a renda e sem comprometer seu horário de Trabalho. </strong></p></td>
  </tr>
  <tr>
    <td width='19%'>&nbsp;</td>
    <td width='81%'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'>Olá, <strong>'".$_POST['usuario']."'</strong> </td>
  </tr>
  <tr>
    <td colspan='2'> 
<strong>Parabéns pela sua decisão em se juntar a nós. </strong><p>
Quero lhe alertar que esse foi apenas o seu primeiro passo para o sucesso financeiro.<p> 
Lembre-se que a qualquer momento alguém poderá ser derramado para você e se você<br> 
não estiver ativo, você irá perder os novos participantes que estão ingressando no projeto,<br>
caso você não efetue sua 1º doação. 
<strong>Não perca tempo. </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'><p><strong>IMPORTANTE: </strong>As informações da sua 1º doação você só poderá acessar pelo seu escritório virtual onde consta <strong>( Dados Bancários, Nome, E-mail, Telefones e etc..)</strong> e o sistema informará todas as outras doações conforme você vai recebendo doações de outros participantes, importante lembrar que você só poderá subir de nível após receber a quantidade exata de doações<br>
por nível OU SEJA quando você receber 3 ou 9 ou 27 doações a cada nível exemplo<strong>:( 1º Nível são 3 doações, 2º Nível são 9 doações, ) A CADA VEZ QUE VOCÊ RECEBE AS DOAÇÕES.</strong></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Credenciais de Acesso ao Sistema</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Escritório Virtual</strong></td>
    <td><a href='http://escritorio.g3money10.com.br/' target='_blank'>http://escritorio.g3money10.com.br/</a></td>
  </tr>
  <tr>
    <td><strong>Link de divulgação:</strong></td>
    <td><a href='http://g3money10.com.br/'".$_POST['usuario']."' target='_blank'>http://g3money10.com.br/'".$_POST['usuario']."'</a></td>
  </tr>
  <tr>
    <td><strong>Usuário:</strong></td>
    <td>'".$_POST['usuario']."'</td>
  </tr>
  <tr>
    <td><strong>Senha:</strong></td>
    <td>'".$_POST['re_password']."'</td>
  </tr>
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'><strong>Após 24 horas sem pagar o sistema deletará o seu cadastro e você 
perderá a sua posição.</strong></td>
  </tr>
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'>Por favor verifique se chegou o e-mail em sua caixa se span, lixo eletrônico</td>
  </tr>
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'><p>Sempre que precisar, entre em contato conosco, estaremos ao seu dispor! </p>
      <p>Atenciosamente,</p>
      <p><strong>G3Money - Ajuda Mútua Financeira</strong><br>
       <a target='_blank' href='http://g3money10.com.br/'>http://g3money10.com.br/</a> </p></td>
  </tr>
</table>";	
/*	
if($cadMeuDireto[0]['total'] == 0){
	
$cadNm = $this->banco->executar(" SELECT count(fk_usu) as total FROM public.tb_usuarios WHERE fk_usu_rede = '{$_SESSION['usuario']['usu_doc']}'");	    
			
$cadastro = new TbCadastro;		  
$redeFilhos = $cadastro->getUsuRede5x5();	  // Retorna os usuários da minha rede
$usuDoc =  $redeFilhos['redeFilhos'][0]['usu_doc'];			

$document = ($cadNm[0]['total'] == 3) ? $usuDoc : $_SESSION['usuario']['usu_doc'] ;

		$sexo = !empty($_POST['sexom']) ? $_POST['sexom'] : $_POST['sexof']; 	
		
		$usuario = array(
		"usu_nome"=>$_POST['nome'],
		"usu_usuario"=>$_POST['usuario'],
		"usu_senha"=>$this->Password($_POST['repitasenha']),
		"fk_status"=>1,
		"usu_datanasc"=>implode("-",array_reverse(explode("/",$_POST['datanasc']))),
		"usu_doc"=>$_POST['cpf'],
		"usu_data"=>"NOW()",
		"fk_usu"=>$_SESSION['usuario']['usu_doc'],
		"usu_sexo"=>$sexo,
		"fk_usu_rede"=>$document,
		"fk_bonus"=>1,		   
		"usu_email"=>$_POST['email'],
		"fk_carreira"=>1,	   
		); 

		$seqId = $this->banco->inserir("public.tb_usuarios", $usuario, "tb_usuarios_usu_id_seq");		
		
		 $cel = ($_POST['celular'] != "") ? $_POST['celular'] : NULL ;
			  if($_POST['celular'] != ""){
					
				 $celular = array(
				   "fone_fone" => $cel,
				   "fk_usu"=>$_POST['cpf'],
				   "fk_tipo"=>3
				 );
				 
		$this->banco->inserir("public.tb_fone", $celular);
			  }

		$w = ($_POST['whatsapp'] != "") ? $_POST['whatsapp'] : NULL ;	
		  
		if($w != ""){
			$whatsapp = array(
			   "fone_fone"=>$w,
			   "fk_usu"=>$_POST['cpf'],
			   "fk_tipo"=>4
			 );
        
		$this->banco->inserir("public.tb_fone", $whatsapp);
		}
				
				 
		$f = ($_POST['fixo'] != "") ? $_POST['fixo'] : NULL;
			if($_POST['fixo'] != ""){		 
				 $fixo = array(
				   "fone_fone"=>$f,
				   "fk_usu"=>$_POST['cpf'],
				   "fk_tipo"=>1
				 );
			$this->banco->inserir("public.tb_fone", $fixo);
			}
				 
			if($_POST['comercial'] != ""){	 
				 $c = ($_POST['comercial'] != "") ? $_POST['comercial'] : NULL ;		 
				 $comercial = array(
				   "fone_fone"=>$c,
				   "fk_usu"=>$_POST['cpf'],
				   "fk_tipo"=>2
				 );
			$this->banco->inserir("public.tb_fone", $comercial);
			}
				 
				 $endereco = array(
				   "end_cep"=>$_POST['cep'],
				   "end_end"=>$_POST['end'],
				   "end_n"=>$_POST['numero'],
				   "end_bairro"=>$_POST['bairro'],
				   "end_cidade"=>$_POST['cidade'],
				   "end_uf"=>$_POST['uf'],
				   "fk_usu"=>$_POST['cpf']
				 );  
				 
		 $this->banco->inserir("public.tb_endereco", $endereco);

		 $ip = Controller::$ip;
		 $browser = Controller::$browser;			
		 
		 $documento = $this->banco->executar("SELECT usu_doc FROM public.tb_usuarios WHERE usu_id = '$seqId'"); 
		 $AcimaNivel = $this->getNiveisAcima($documento[0]['usu_doc']);
		 	 
		 $num = 1;
		 foreach( $AcimaNivel['dados'] as $listDoc ){
		 session_regenerate_id();
		 $conta = $num++;

		 $dataEx = ($conta == 1) ? date('Y-m-d H:m:s', strtotime('+1 days')) : NULL;
		 
		 if($conta == 1){
		  $valor = 150;		  
		 }
		 if($conta == 2){
		  $valor = 250;
		 }
		 if($conta == 3){
		  $valor = 1000;
		 }

		 $pedidos = array(
		   "fk_usu"=>$_POST['cpf'],
		   "ped_total"=>$valor,
		   "ped_sessao"=>session_id(),
		   "ped_ip"=>$ip,
		   "ped_browser"=>$browser,
		   "ped_data_expira"=>$dataEx,
		   "fk_pai"=>$listDoc['usu_doc'],
		   "ped_nivel"=>$conta,
		   "ped_qtd_downlines"=>$this->matrix5
		 );   
			
		  $this->banco->inserir("public.tb_pedidos", $pedidos);	
		
		}

			
		$dados = array(
			"usu_usuario"=>$_POST['usuario'],
			"usu_senha"=>$_POST['repitasenha'],
			"usu_email"=>$_POST['email'],
			"assunto"=>"PARABÉNS! Você deu o primeiro passo para o seu sucesso financeiro‏"	 ,
			"msg" => $html  
		); 
		   
		$email = new Email;
		$mail = $email->enviar($dados); // Envia o e-mail com boas vindas	   

	   $usu = $this->banco->executar("SELECT usu_email, usu_usuario FROM public.tb_usuarios WHERE usu_doc = '".$usuDoc."' AND fk_status = 2");
	   
	    //Dados da pessoa que se cadastrou
	    $nome2 = strip_tags(trim($_POST['nome']));
	    $usuario2 = strip_tags(trim($_POST['usuario']));
	    $email2 = strip_tags(trim($_POST['email']));
		
$htmlCad = "
<table width='100%' border='0' cellpadding='2'>
<tr>
<td width='100%'></td>
</tr>
<tr>
<td><h3><strong>PARABÉNS!</strong> Uma pessoa acaba de se cadastrar abaixo de você!</h3></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td><p>Envie um e-mail parabenizando está pessoa por da um passo tão importante!<br>
<br>
<strong>    Segue as informações de contato da pessoa.</strong>
<p><strong>Nome:</strong> $nome2<br>
<p><strong>Usuário:</strong> $usuario2<br>
<p><strong>E-mail:</strong> $email2 
<p><br>
<br>
</td>
</tr>
<tr>
<td><p><strong>Não deixe passar essa oportunidade de negocio para aumentar a renda e sem comprometer seu horário de Trabalho. </strong></p>
<p>Sempre que precisar, entre em contato conosco, estaremos ao seu dispor! </p>
<p>Atenciosamente,</p>
<p><strong>G3Money - Ajuda Mútua Financeira</strong><br>
<a target='_blank' href='http://g3money10.com.br/'>http://g3money10.com.br/</a> </p></td>
</tr>
</table>";
	
		$enviar = array(			
		    "usu_usuario"=> $usu[0]['usu_usuario'],
			"usu_email"=> $usu[0]['usu_email'],			
			"assunto"=>"PARABÉNS - UMA PESSOA ACABA DE SE CADASTRAR ABAIXO DE VOCÊ.‏"	 ,
			"msg" => $htmlCad  
		); 		
		   
		$enviarEmail = new Email;
		$enviarEmail->enviar($enviar);
		
		session_regenerate_id();	
		 
			echo "sim"; die;	


}else{	*/
		   
$cadastro = new TbCadastro;		  
$redeFilhos = $cadastro->getUsuRede5x5();	  // Retorna os usuários da minha rede
$usuDoc =  $redeFilhos['redeFilhos'][0]['usu_doc'];

	  if(!empty($redeFilhos['redeFilhos'][0])){		

		$sexo = !empty($_POST['sexom']) ? $_POST['sexom'] : $_POST['sexof']; 	
		
		$usuario = array(
			"usu_nome"=>$_POST['nome'],
			"usu_usuario"=>$_POST['usuario'],
			"usu_senha"=>$this->Password($_POST['repitasenha']),
			"fk_status"=>1,
			"usu_datanasc"=>implode("-",array_reverse(explode("/",$_POST['datanasc']))),
			"usu_doc"=>$_POST['cpf'],
			"usu_data"=>"NOW()",
			"fk_usu"=>$_SESSION['usuario']['usu_doc'],
			"usu_sexo"=>$sexo,
			"fk_usu_rede"=>$usuDoc,
			"fk_bonus"=>1,		   
			"usu_email"=>$_POST['email'],
			"fk_carreira"=>1,	   
		); 

		$seqId = $this->banco->inserir("public.tb_usuarios", $usuario, "tb_usuarios_usu_id_seq");
		
		
		 $cel = ($_POST['celular'] != "") ? $_POST['celular'] : NULL ;
			  if($_POST['celular'] != ""){
					
				 $celular = array(
				   "fone_fone" => $cel,
				   "fk_usu"=>$_POST['cpf'],
				   "fk_tipo"=>3
				 );
				 
		$this->banco->inserir("public.tb_fone", $celular);
			  }

		$w = ($_POST['whatsapp'] != "") ? $_POST['whatsapp'] : NULL ;	
		  
		if($w != ""){
			$whatsapp = array(
			   "fone_fone"=>$w,
			   "fk_usu"=>$_POST['cpf'],
			   "fk_tipo"=>4
			 );
        
		$this->banco->inserir("public.tb_fone", $whatsapp);
		}
				
				 
		$f = ($_POST['fixo'] != "") ? $_POST['fixo'] : NULL;
			if($_POST['fixo'] != ""){		 
				 $fixo = array(
				   "fone_fone"=>$f,
				   "fk_usu"=>$_POST['cpf'],
				   "fk_tipo"=>1
				 );
			$this->banco->inserir("public.tb_fone", $fixo);
			}
				 
			if($_POST['comercial'] != ""){	 
				 $c = ($_POST['comercial'] != "") ? $_POST['comercial'] : NULL ;		 
				 $comercial = array(
				   "fone_fone"=>$c,
				   "fk_usu"=>$_POST['cpf'],
				   "fk_tipo"=>2
				 );
			$this->banco->inserir("public.tb_fone", $comercial);
			}
				 
				 $endereco = array(
				   "end_cep"=>$_POST['cep'],
				   "end_end"=>$_POST['end'],
				   "end_n"=>$_POST['numero'],
				   "end_bairro"=>$_POST['bairro'],
				   "end_cidade"=>$_POST['cidade'],
				   "end_uf"=>$_POST['uf'],
				   "fk_usu"=>$_POST['cpf']
				 );  
				 
		 $this->banco->inserir("public.tb_endereco", $endereco);

		 $ip = Controller::$ip;
		 $browser = Controller::$browser;	
		 
		 $documento = $this->banco->executar("SELECT usu_doc FROM public.tb_usuarios WHERE usu_id = '$seqId'"); 
		 $AcimaNivel = $this->getNiveisAcima($documento[0]['usu_doc']);
		 
		// echo "<pre>"; print_r($AcimaNivel); die;
		 		 
		 $num = 1;
		 foreach( $AcimaNivel['dados'] as $listDoc ){
		 session_regenerate_id();
		 $conta = $num++;

		 $dataEx = ($conta == 1) ? date('Y-m-d H:m:s', strtotime('+1 days')) : NULL;
		 
		 if($conta == 1){
		  $valor = 150;
		 }
		 if($conta == 2){
		  $valor = 250;
		 }
		 if($conta == 3){
		  $valor = 1000;
		 }
		  
		 $pedidos = array(
		   "fk_usu"=>$_POST['cpf'],
		   "ped_total"=>$valor,
		   "ped_sessao"=>session_id(),
		   "ped_ip"=>$ip,
		   "ped_browser"=>$browser,
		   "ped_data_expira"=>$dataEx,
		   "fk_pai"=>$listDoc['usu_doc'],
		   "ped_nivel"=>$conta,
		   "ped_qtd_downlines"=>$this->matrix5
		 );   
			
		  $this->banco->inserir("public.tb_pedidos", $pedidos);	
		
		}

		
			
		$dados = array(
			"usu_usuario"=>$_POST['usuario'],
			"usu_senha"=>$_POST['repitasenha'],
			"usu_email"=>$_POST['email'],
			"assunto"=>"PARABÉNS! Você deu o primeiro passo para o seu sucesso financeiro‏"	 ,
			"msg" => $html  
		); 
		   
$email = new Email;
$mail = $email->enviar($dados); // Envia o e-mail com boas vindas	   

$usu = $this->banco->executar("SELECT usu_email, usu_usuario FROM public.tb_usuarios WHERE usu_doc = '".$usuDoc."' AND fk_status = 2");

//Dados da pessoa que se cadastrou
$nome2 = strip_tags(trim($_POST['nome']));
$usuario2 = strip_tags(trim($_POST['usuario']));
$email2 = strip_tags(trim($_POST['email']));
		
$htmlCad = "
			<table width='100%' border='0' cellpadding='2'>
			<tr>
			<td width='100%'></td>
			</tr>
			<tr>
			<td><h3><strong>PARABÉNS!</strong> Uma pessoa acaba de se cadastrar abaixo de você!</h3></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			</tr>
			<tr>
			<td><p>Envie um e-mail parabenizando está pessoa por da um passo tão importante!<br>
			<br>
			<strong>    Segue as informações de contato da pessoa.</strong>
			<p><strong>Nome:</strong> $nome2<br>
			<p><strong>Usuário:</strong> $usuario2<br>
			<p><strong>E-mail:</strong> $email2 
			<p><br>
			<br>
			</td>
			</tr>
			<tr>
			<td><p><strong>Não deixe passar essa oportunidade de negocio para aumentar a renda e sem comprometer seu horário de Trabalho. </strong></p>
			<p>Sempre que precisar, entre em contato conosco, estaremos ao seu dispor! </p>
			<p>Atenciosamente,</p>
			<p><strong>G3Money - Ajuda Mútua Financeira</strong><br>
			<a target='_blank' href='http://g3money10.com.br/'>http://g3money10.com.br/</a> </p></td>
			</tr>
			</table>";
	
		$enviar = array(			
		    "usu_usuario"=> $usu[0]['usu_usuario'],
			"usu_email"=> $usu[0]['usu_email'],			
			"assunto"=>"PARABÉNS - UMA PESSOA ACABA DE SE CADASTRAR ABAIXO DE VOCÊ.‏"	 ,
			"msg" => $htmlCad  
		); 		
		   
		$enviarEmail = new Email;
		$enviarEmail->enviar($enviar);
		
		session_regenerate_id();	 
			echo "sim"; die;	
         } else{
		   session_regenerate_id();	 
			echo "nao"; die;
		}
		
	//}
		
       }	   

   }     

	public function getNiveisAcima( $doc = NULL ){

	  if($doc != NULL){
	
	  $nivelAcima = $this->banco->executar("
			WITH RECURSIVE familia (usu_id, usu_email, fk_status, usu_doc, usu_usuario, fk_usu_rede, usu_data, parente, nivel, path) AS
			(
			SELECT 
				u1.usu_id, u1.usu_email, u1.fk_status, u1.usu_doc, u1.usu_usuario,u1.fk_usu_rede, to_char(u1.usu_data, 'DD/MM/YYYY'),
				(select usu_id from tb_usuarios where usu_doc = u1.fk_usu), 1 AS nivel, array[u1.usu_id]
			FROM tb_usuarios AS u1
			WHERE
			u1.usu_doc = '$doc'
			UNION ALL
			SELECT
				u2.usu_id, u2.usu_email,u2.fk_status, u2.usu_doc, u2.usu_usuario,u2.fk_usu_rede, to_char(u2.usu_data, 'DD/MM/YYYY'), 
				(select usu_id from tb_usuarios where usu_doc = u2.fk_usu), f.nivel + 1 AS nivel, (f.path || u2.usu_id)
			FROM tb_usuarios AS u2
				INNER JOIN familia AS f ON f.fk_usu_rede = u2.usu_doc
				WHERE f.nivel <= 3 AND u2.fk_status = 2
			)
			SELECT 
				*
			FROM 
				familia 
	   WHERE usu_doc != '$doc' ORDER BY usu_id DESC");	
	
	   
	   return array("dados"=>$nivelAcima);

	  }
	
	}
	
	
	
	public function getNiveisAcimaReentrada( $doc = NULL ){

	  if($doc != NULL){
		  
	  $nivelAcima = $this->banco->executar("
			WITH RECURSIVE familia (usu_id, usu_email, fk_status, usu_doc, usu_usuario, fk_usu_rede, usu_data, parente, nivel, path) AS
			(
			SELECT 
				u1.usu_id, u1.usu_email, u1.fk_status, u1.usu_doc, u1.usu_usuario,u1.fk_usu_rede, to_char(u1.usu_data, 'DD/MM/YYYY'),
				(select usu_id from tb_usuarios where usu_doc = u1.fk_usu), 1 AS nivel, array[u1.usu_id]
			FROM tb_usuarios AS u1
			WHERE
			u1.usu_doc = '$doc'
			UNION ALL
			SELECT
				u2.usu_id, u2.usu_email,u2.fk_status, u2.usu_doc, u2.usu_usuario,u2.fk_usu_rede, to_char(u2.usu_data, 'DD/MM/YYYY'), 
				(select usu_id from tb_usuarios where usu_doc = u2.fk_usu), f.nivel + 1 AS nivel, (f.path || u2.usu_id)
			FROM tb_usuarios AS u2
				INNER JOIN familia AS f ON f.fk_usu_rede = u2.usu_doc
				WHERE f.nivel <= 3 AND u2.fk_status = 2
			)
			SELECT 
				*
			FROM 
				familia 
	   WHERE usu_doc != '$doc' ORDER BY usu_id DESC");	
	
	   
	   return array("dados"=>$nivelAcima);

	  }
	
	}
	
	
  
  }