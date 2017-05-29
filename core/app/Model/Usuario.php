<?php 

class Usuario extends TbUsuarios
{		

	public $endereco;
	public $pj;
	public $fone;
	public $voucher;
	public $parametros;
	public $usuario;
	public $pagamento;
	public $phpmailer;
	public $meiopagamento;
    public static $doc;
	static $numreg;
	static $inicial;
	
	public static $idUsuUsu;
	public static $usu_usuarioUsu;
	public static $usu_nomeUsu;
	public static $usu_senhaUsu;
	public static $usu_senhaSegUsu;
	public static $usu_docUsu ;
	public static $sexoUsu; 
	public static $usu_emailUsu;   
	public static $nascimentoUsu ;	
	public static $endUsu;        
	public static $end_compUsu; 	
	public static $end_cidadeUsu; 
	public static $end_bairroUsu; 
	public static $end_cepUsu; 
	public static $end_ufUsu; 
	public static $foneUsu;
	public $valorDoacao = '150';
	public $matrix5 = '3';
	
public function cadastrar()
	{
	
$ind = $this->banco->executar("SELECT usu_doc FROM tb_usuarios WHERE usu_usuario = '".Controller::$parametros['usuario']."' AND fk_status = 2");
   
   if(!empty($ind[0])){
      if(isset($_POST['acao']) == "cadastrar"){
		session_regenerate_id();
		


$indicante = $this->banco->executar("SELECT usu_doc FROM tb_usuarios WHERE usu_usuario = '".Controller::$parametros['usuario']."'");
$doc = $indicante[0]['usu_doc'];

// Se eu não tiver nenhum abaixo ele cadastra pra mim pelo menos uma pessoa pra mim reculperar o dinheiro investido		
$cadMeuDireto = $this->banco->executar(" SELECT count(fk_usu) as total FROM public.tb_usuarios WHERE fk_usu = '$doc'");	    

		
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
    <td>
	<a href='http://g3money10.com.br/'".$_POST['usuario']."' target='_blank'>http://g3money10.com.br/'".$_POST['usuario']."'</a>
	</td>
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

$cadNm = $this->banco->executar("SELECT count(fk_usu) as total FROM public.tb_usuarios WHERE fk_usu_rede = '{$_SESSION['usuario']['usu_doc']}'");	    
			
$cadastro = new TbCadastro;		  
$redeFilhos = $cadastro->getUsuRede5x5();	  // Retorna os usuários da minha rede
$usuDoc =  $redeFilhos['redeFilhos'][0]['usu_doc'];			
	
$document = ($cadNm[0]['total'] == 3) ? $usuDoc : $_SESSION['usuario']['usu_doc'] ;
		

        $cpf = str_replace(".","",$_POST['cpf']);
		$cpf = str_replace("-","",$cpf);
		$sexo = $_POST['gender']; 	
		
	$usuario = array(
		"usu_nome"=>$_POST['fullname'],
		"usu_usuario"=>$_POST['usuario'],
		"usu_senha"=>$this->Password($_POST['re_password']),
		"fk_status"=>1,
		"usu_datanasc"=>implode("-",array_reverse(explode("/",$_POST['datanasc']))),
		"usu_doc"=>$cpf,
		"usu_data"=>"NOW()",
		"fk_usu"=>$doc,
		"usu_sexo"=>$sexo,
		"fk_usu_rede"=>$document,
		"fk_bonus"=>1,		   
		"usu_email"=>$_POST['email'],
		"fk_carreira"=>1,	   
		); 
		
	$seqId = $this->banco->inserir("public.tb_usuarios", $usuario, "tb_usuarios_usu_id_seq");
		
		 $cel = str_replace("(","",$_POST['cel']);
		 $cel = str_replace(")","",$cel);
		 $cel = str_replace("-","",$cel);
		 $cel = str_replace(" ","",$cel);
		 $cel = ($cel != "") ? $cel : NULL ;
			  if($cel != ""){					
				 $celular = array(
				   "fone_fone" => $cel,
				   "fk_usu"=>$cpf,
				   "fk_tipo"=>3
				 );
				
		$this->banco->inserir("public.tb_fone", $celular);
			  }
		$w = str_replace("(","",$_POST['whatsapp']);
		$w = str_replace(")","",$w);
		$w = str_replace("-","",$w);
		$w = str_replace(" ","",$w);
		$w = ($w != "") ? $w : NULL ;	
		  
		if($w != ""){
			$whatsapp = array(
			   "fone_fone"=>$w,
			   "fk_usu"=>$cpf,
			   "fk_tipo"=>4
			 );
		// echo "<pre>"; print_r($cpf); die;
	$this->banco->inserir("public.tb_fone", $whatsapp);
		}
				
		$f = str_replace("(","",$_POST['fixo']);
		$f = str_replace(")","",$f);
		$f = str_replace("-","",$f);
		$f = str_replace(" ","",$f);		 
		$f = ($f != "") ? $f : NULL;
			if($f != ""){		 
				 $fixo = array(
				   "fone_fone"=>$f,
				   "fk_usu"=>$cpf,
				   "fk_tipo"=>1
				 );
			 
		$this->banco->inserir("public.tb_fone", $fixo);
			}
			
			$c = str_replace("(","",$_POST['comercial']);
			$c = str_replace(")","",$f);
			$c = str_replace("-","",$f);
			$c = str_replace(" ","",$f);
			$c = ($c != "") ? $c : NULL ;	
			  
			if($c != ""){
				$comercial = array(
				   "fone_fone"=>$c,
				   "fk_usu"=>$cpf,
				   "fk_tipo"=>2
				 );

		$this->banco->inserir("public.tb_fone", $comercial);
			}
			
				 
				 $endereco = array(
				   "end_cep"=>str_replace("-","",$_POST['cep']),
				   "end_end"=>$_POST['endereco'],
				   "end_n"=>$_POST['numero'],
				   "end_bairro"=>$_POST['bairro'],
				   "end_cidade"=>$_POST['cidade'],
				   "end_uf"=>$_POST['uf'],
				   "fk_usu"=>$cpf
				 );  
			
	$this->banco->inserir("public.tb_endereco", $endereco);

		 $ip = Controller::$ip;
		 $browser = Controller::$browser;	 
		 $cad = new Cadastro;
		 
         $documento = $this->banco->executar("SELECT usu_doc FROM public.tb_usuarios WHERE usu_id = '$seqId'"); 
		 $AcimaNivel = $cad->getNiveisAcimaReentrada($documento[0]['usu_doc']);

	   if(!$AcimaNivel['dados']){
			
		 session_regenerate_id();
		 $num = 1;
		 $conta = $num++;
		   
		 $dataEx = ($conta == 1) ? date('Y-m-d H:m:s', strtotime('+1 days')) : NULL;
		  
		 $pedidos = array(
		   "fk_usu"=>$cpf,
		   "ped_total"=>$this->valorDoacao,
		   "ped_sessao"=>session_id(),
		   "ped_ip"=>$ip,
		   "ped_browser"=>$browser,
		   "ped_data_expira"=>$dataEx,
		   "fk_pai"=> "00000000001",
		   "ped_nivel"=>$conta,
		   "ped_qtd_downlines"=>$this->matrix5
		 );   
		
		  $this->banco->inserir("public.tb_pedidos", $pedidos);	
			
		}else{

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
		   "fk_usu"=>$cpf,
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
	   }
   
	   
$dados = array(
	"usu_usuario"=>$_POST['usuario'],
	"usu_senha"=>$_POST['re_password'],
	"usu_email"=>$_POST['email'],
	"assunto"=>"Parabéns! Você deu o primeiro passo para o seu sucesso financeiro‏",
	"msg" => $html
	); 

		
$email = new Email;
$mail = $email->enviar($dados); // Envia o e-mail com boas vindas	

		
$usu = $this->banco->executar("SELECT usu_email, usu_usuario FROM public.tb_usuarios WHERE usu_doc = '".$usuDoc."' AND fk_status = 2");
	   
//Dados da pessoa que se cadastrou
$nome2 = strip_tags(trim($_POST['fullname']));
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
	   return array("template"=>"cadastrar", "retorno"=>"sim", "mail"=>"sim");
	

}else{	*/
		
	$cadastro = new TbCadastro;		  
	$redeFilhos    = $cadastro->getUsuRede5x5();	  // Retorna os usuários da minha rede
	
	$usuDoc =  $redeFilhos['redeFilhos'][0]['usu_doc'];
	if(!empty($redeFilhos['redeFilhos'][0])){	
	
	$cpf = str_replace(".","",$_POST['cpf']);
	$cpf = str_replace("-","",$cpf);
	$sexo = $_POST['gender']; 	
		
	$usuario = array(
		"usu_nome"=>$_POST['fullname'],
		"usu_usuario"=>$_POST['usuario'],
		"usu_senha"=>$this->Password($_POST['re_password']),
		"fk_status"=>1,
		"usu_datanasc"=>implode("-",array_reverse(explode("/",$_POST['datanasc']))),
		"usu_doc"=>$cpf,
		"usu_data"=>"NOW()",
		"fk_usu"=>$doc,
		"usu_sexo"=>$sexo,
		"fk_usu_rede"=>$usuDoc,
		"fk_bonus"=>1,		   
		"usu_email"=>$_POST['email'],
		"fk_carreira"=>1,	   
		); 
		
	$seqId = $this->banco->inserir("public.tb_usuarios", $usuario, "tb_usuarios_usu_id_seq");		
		
		 $cel = str_replace("(","",$_POST['cel']);
		 $cel = str_replace(")","",$cel);
		 $cel = str_replace("-","",$cel);
		 $cel = str_replace(" ","",$cel);
		 $cel = ($cel != "") ? $cel : NULL ;
			  if($cel != ""){					
				 $celular = array(
				   "fone_fone" => $cel,
				   "fk_usu"=>$cpf,
				   "fk_tipo"=>3
				 );
				
		$this->banco->inserir("public.tb_fone", $celular);
			  }
		$w = str_replace("(","",$_POST['whatsapp']);
		$w = str_replace(")","",$w);
		$w = str_replace("-","",$w);
		$w = str_replace(" ","",$w);
		$w = ($w != "") ? $w : NULL ;	
		  
		if($w != ""){
			$whatsapp = array(
			   "fone_fone"=>$w,
			   "fk_usu"=>$cpf,
			   "fk_tipo"=>4
			 );
		// echo "<pre>"; print_r($cpf); die;
	$this->banco->inserir("public.tb_fone", $whatsapp);
		}
				
		$f = str_replace("(","",$_POST['fixo']);
		$f = str_replace(")","",$f);
		$f = str_replace("-","",$f);
		$f = str_replace(" ","",$f);		 
		$f = ($f != "") ? $f : NULL;
			if($f != ""){		 
				 $fixo = array(
				   "fone_fone"=>$f,
				   "fk_usu"=>$cpf,
				   "fk_tipo"=>1
				 );
			 
		$this->banco->inserir("public.tb_fone", $fixo);
			}
			
			$c = str_replace("(","",$_POST['comercial']);
			$c = str_replace(")","",$f);
			$c = str_replace("-","",$f);
			$c = str_replace(" ","",$f);
			$c = ($c != "") ? $c : NULL ;	
			  
			if($c != ""){
				$comercial = array(
				   "fone_fone"=>$c,
				   "fk_usu"=>$cpf,
				   "fk_tipo"=>2
				 );

		$this->banco->inserir("public.tb_fone", $comercial);
			}
			
				 
				 $endereco = array(
				   "end_cep"=>str_replace("-","",$_POST['cep']),
				   "end_end"=>$_POST['endereco'],
				   "end_n"=>$_POST['numero'],
				   "end_bairro"=>$_POST['bairro'],
				   "end_cidade"=>$_POST['cidade'],
				   "end_uf"=>$_POST['uf'],
				   "fk_usu"=>$cpf
				 );  
			
	     $this->banco->inserir("public.tb_endereco", $endereco);

		 $ip = Controller::$ip;
		 $browser = Controller::$browser;	 
		 $cad = new Cadastro;
		 
		 $documento = $this->banco->executar("SELECT usu_doc FROM public.tb_usuarios WHERE usu_id = '$seqId'"); 
		 $AcimaNivel = $cad->getNiveisAcimaReentrada($documento[0]['usu_doc']);

	   if(!$AcimaNivel['dados']){
			
		 session_regenerate_id();
		 $num = 1;
		 $conta = $num++;
		   
		 $dataEx = ($conta == 1) ? date('Y-m-d H:m:s', strtotime('+1 days')) : NULL;
		  
		 $pedidos = array(
		   "fk_usu"=>$cpf,
		   "ped_total"=>$this->valorDoacao,
		   "ped_sessao"=>session_id(),
		   "ped_ip"=>$ip,
		   "ped_browser"=>$browser,
		   "ped_data_expira"=>$dataEx,
		   "fk_pai"=> "00000000001",
		   "ped_nivel"=>$conta,
		   "ped_qtd_downlines"=>$this->matrix5
		 );   
		
		  $this->banco->inserir("public.tb_pedidos", $pedidos);	
			
		  }else{

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
		   "fk_usu"=>$cpf,
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
	   }

	   $dados = array(
		"usu_usuario"=>$_POST['usuario'],
		"usu_senha"=>$_POST['re_password'],
		"usu_email"=>$_POST['email'],
		"assunto"=>"Parabéns! Você deu o primeiro passo para o seu sucesso financeiro‏",
		"msg" => $html
		); 
		
	  $email = new Email;
	  $mail = $email->enviar($dados); // Envia o e-mail com boas vindas	
		
	    $usu = $this->banco->executar("SELECT usu_email, usu_usuario FROM public.tb_usuarios WHERE usu_doc = '".$usuDoc."' AND fk_status = 2");
	   
	    //Dados da pessoa que se cadastrou
	    $nome2 = strip_tags(trim($_POST['fullname']));
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
	   return array("template"=>"cadastrar", "retorno"=>"sim", "mail"=>"sim");
	 }	
	  else{
		   session_regenerate_id();	 
			return array("template"=>"cadastrar", "retorno"=>"nao");
      }		


	  //}
	
	 }
}else{
	return array("template"=>"cadastrar", "retorno"=>"nao");
} 
return array("template"=>"cadastrar");
		
}

	public function ValidaCamposEndereco($endereco)
	{
		
		return $this->endereco->VerEmpty($endereco);
		
	}
	
public function ValidaCamposCadastro($usuario)
	{
		//echo '<pre>';print_r($usuario);die;
		/*
		if(!$this->VerEmpty($usuario['usuario']))
		{
			return false;
			
		}*/
		if(!$this->VerMaiorIdade())
		{
			return array('msg' => 'Usuário menor de idade, tente novamente!',
							'retorno' => false);
			
		}elseif(!$this->ValidaEmail())
		{
			return array('msg' => 'Email incorreto, tente novamente!',
							'retorno' => false);
			
		}elseif(!$this->VerEmpty($usuario['usuario']))
		{
			return array('msg' => 'Dados de Usuário incompleto, tente novamente!',
							'retorno' => false);
			
		}elseif(!$this->ValidaCamposEndereco($usuario['endereco']))
		{
			return array('msg' => 'Endereço Incompleto, tente novamente!',
							'retorno' => false);
			
		}elseif($this->banco->ver_isset('tb_usuarios',array('usu_email' => $usuario['usuario']['usu_email'])))
		{
			return array('msg' => 'Email já Existe, tente novamente!',
							'retorno' => false);
			
		}elseif($this->banco->ver_isset('tb_usuarios',array('usu_doc' => $this->GetUsuDoc())))
		{
			return array('msg' => 'CPF já Existe, tente novamente!',
							'retorno' => false);
			
		}elseif(!$this->ValidaSexo())
		{
			return array('msg' => 'Sexo Inválido, tente novamente!',
							'retorno' => false);
			
		}else{
		
			return array('retorno' => true);
		}
	}
	
	public function MeuCadastro($cpf)
	{
		
	}
	
	public function adm_listar_u()
	{		
        return false;
	}

	public function adm_listar_u_ajax()
	{
		
     if($_POST['idUsu']){         
			self::$idUsuUsu = strip_tags(trim($_POST['idUsu']));						
			self::$usu_usuarioUsu = strip_tags(trim($_POST['usu_usuario']));			
			self::$usu_nomeUsu = strip_tags(trim($_POST['usu_nome']));	
			
			//echo "<pre>"; print_r(strlen($_POST['senha'])); die;
			
			if(strip_tags(trim($_POST['senha'])) == ""){
			}
			elseif(strlen($_POST['senha']) < 4 ){
			 return array("template"=>"adm_listar_u_ajax",
			 "msg"=>"
					<div class='alert alert-danger' role='alert'>					
					  <strong>Erro!</strong> Informa uma senha maior e segura.
					</div>");
			}			
			else{			
			self::$usu_senhaUsu = strip_tags(trim($_POST['senha']));	
			}
			if(strip_tags(trim($_POST['senha_segu'])) == ""){			
			}
			elseif(strlen($_POST['senha_segu']) < 4 ){
			 return array("template"=>"adm_listar_u_ajax",
			  "msg"=>"
					<div class='alert alert-danger' role='alert'>					 
					  <strong>Erro!</strong> Informa uma senha de segurança maior e segura.
					</div>");

			}			
			else{			
			self::$usu_senhaSegUsu = strip_tags(trim($_POST['senha_segu']));	
			}
				
			
			self::$usu_docUsu = strip_tags(trim($_POST['usu_doc'])); 
			self::$sexoUsu = strip_tags(trim($_POST['sexo']));   
			self::$usu_emailUsu = strip_tags(trim($_POST['usu_email']));   
			
			$nascimento = explode("/",$_POST['nascimento']);			
			self::$nascimentoUsu = strip_tags(trim($nascimento[2]."-".$nascimento[1]."-".$nascimento[0])); 			
			
			self::$endUsu = strip_tags(trim($_POST['end']));        
			self::$end_compUsu = strip_tags(trim($_POST['end_comp']));	
			self::$end_cidadeUsu = strip_tags(trim($_POST['end_cidade'])); 
			self::$end_bairroUsu = strip_tags(trim($_POST['end_bairro']));
			self::$end_cepUsu = strip_tags(trim($_POST['end_cep'])); 
			self::$end_ufUsu = strip_tags(trim($_POST['end_uf'])); 
			self::$foneUsu = strip_tags(trim($_POST['fone']));             
		
		    return array("template"=>"adm_listar_u_ajax",$this->updateUsuario(),
			  "msg"=>"
					<div class='alert alert-success' role='alert'>					 
					  <strong>Sucesso!</strong> Informações atualizadas com sucesso.
					</div>");	        
		}
		
		
		if( 
			( isset( $_REQUEST['admAtivaBloq'] ) and !empty( $_REQUEST['admAtivaBloq'] ) ) and 
			( isset( $_REQUEST['admAtivaBloqAction'] ) and !empty( $_REQUEST['admAtivaBloqAction'] ) ) ) {
			$admAtivaBloq = $this->admAtivaBloqUsuario($_REQUEST['admAtivaBloq'], $_REQUEST['admAtivaBloqAction']);
		} else {
			$admAtivaBloq = false;	
		}

		if( $_REQUEST['pagina'] > 1 ) {
			$offset = ( ( $_REQUEST['pagina'] * $_REQUEST['regpag'] ) - $_REQUEST['regpag'] );
		} else {
			$offset = 0;
		}
		
		/** DADOS DO USUARIO **/
		$sql = "SELECT tb_usuarios.usu_id, 
						tb_usuarios.usu_doc, 
						tb_usuarios.usu_nome, 
						tb_usuarios.usu_sexo, 
						tb_usuarios.usu_email, 
						tb_usuarios.usu_usuario,
						tb_usuarios.usu_senha, 
						tb_usuarios.usu_perna_auto, 
						to_char(tb_usuarios.usu_datanasc, 'DD/MM/YYYY') AS nascimento, 
						tb_endereco.end_cep, 
						tb_endereco.end_end, 
						tb_endereco.end_n, 
						tb_endereco.end_comp, 
						tb_endereco.end_cidade, 
						tb_endereco.end_bairro, 
						tb_endereco.end_uf, 
						tb_carreira.ca_nome, 
						tb_usuarios.fk_status, 
						tb_status_usu.status_nome 
				FROM tb_usuarios 
				INNER JOIN tb_status_usu ON public.tb_status_usu.status_id = tb_usuarios.fk_status 
				LEFT JOIN tb_endereco ON tb_endereco.fk_usu = tb_usuarios.usu_doc 
				LEFT JOIN tb_carreira ON tb_carreira.ca_id = tb_usuarios.fk_carreira ";

		if( !empty( $_REQUEST['busca'] ) ) {
			$busca = "WHERE( tb_usuarios.usu_usuario ILIKE '%".$_REQUEST['busca']."%' ) OR
							( tb_endereco.end_cidade ILIKE '%".$_REQUEST['busca']."%' ) OR
							( tb_endereco.end_uf ILIKE '%".$_REQUEST['busca']."%' ) OR
							( tb_carreira.ca_nome ILIKE '%".$_REQUEST['busca']."%' ) OR
							( tb_status_usu.status_nome ILIKE '%".$_REQUEST['busca']."%' )";
		} else {
			$busca = "";
		}
		/** END DADOS DO USUARIO **/
		
		$sql .=	$busca . "ORDER BY tb_usuarios.usu_nome ASC ";
		$limitOffset = "LIMIT ".$_REQUEST['regpag']." OFFSET ".$offset;
				 
		$ver = $this->banco->conexao->prepare($sql.$limitOffset);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);
		
		/** DADOS DE TELEFONES */
		foreach( $res AS $dadosUser ) {
			$sqlFone = "SELECT tb_fone.fone_fone, 
								tb_tipo_fone.tipo_nome 
							FROM tb_fone 
							INNER JOIN tb_tipo_fone ON tb_tipo_fone.tipo_id = tb_fone.fk_tipo  
							WHERE( tb_fone.fk_usu = '".$dadosUser['usu_doc']."' )";
			//echo $sqlFone; die();
			$verFone = $this->banco->conexao->prepare($sqlFone);
			$verFone->execute();
			$resFone = $verFone->fetchAll(PDO::FETCH_ASSOC);
			$cont = 0;
			if( !empty( $resFone ) ) {
				foreach( $resFone as $dadosFone ) {
					$cont++;
					$retFone[$dadosUser['usu_doc']][$cont]['fone'] = $dadosFone['fone_fone'];
					$retFone[$dadosUser['usu_doc']][$cont]['tipo'] = $dadosFone['tipo_nome'];
				}
			} else {
				$retFone[$dadosUser['usu_doc']] = null;
			}
		}
		/** END DADOS DE TELEFONES */
	
		//paginacao
		$sql = "SELECT COUNT(*) AS total 
				FROM tb_usuarios 
				INNER JOIN tb_status_usu ON public.tb_status_usu.status_id = tb_usuarios.fk_status 
				LEFT JOIN tb_endereco ON tb_endereco.fk_usu = tb_usuarios.usu_doc 
				LEFT JOIN tb_carreira ON tb_carreira.ca_id = tb_usuarios.fk_carreira ";

		if( !empty( $_REQUEST['busca'] ) ) {
			$busca = "WHERE( tb_usuarios.usu_nome ILIKE '%".$_REQUEST['busca']."%' ) OR
							( tb_endereco.end_cidade ILIKE '%".$_REQUEST['busca']."%' ) OR
							( tb_endereco.end_uf ILIKE '%".$_REQUEST['busca']."%' ) OR
							( tb_carreira.ca_nome ILIKE '%".$_REQUEST['busca']."%' ) OR
							( tb_status_usu.status_nome ILIKE '%".$_REQUEST['busca']."%' )";
		} else {
			$busca = "";
		}
		
		$sql .=	$busca;
		
		$paginacao = $this->adm_listar_u_paginacao($sql, $_REQUEST['pagina'], $_REQUEST['regpag']);
		//end paginacao
		
		$res = array('usuarios'=>$res, "template"=>"adm_listar_u_ajax", 'fones'=>$retFone, 'paginacao'=>$paginacao, 'sql'=>$sql, 'msg'=>$admAtivaBloq);
		
		return $res;
	}
	
	function adm_listar_u_paginacao($sql=null,$pagina=1, $regpag=10) 
	{

		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);
		
		$totalRegistros = $res[0]['total'];
		if( $totalRegistros > 0 ) {
			$totalPaginas = ceil( $totalRegistros / $regpag );
			$totalPagina = ( $pagina * $regpag );
			$totalPagina = ( $totalPagina < $totalRegistros ) ? $totalPagina : $totalRegistros;

			if( $_REQUEST['pagina'] > 1 ) {
				$offset = ( ( $_REQUEST['pagina'] * $_REQUEST['regpag'] ) - $_REQUEST['regpag'] );
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
							$html .= ( $pagina > 1 ) ? '<li class="prev"><a href="javascript:void(paginacao(\''.( $pagina - 1 ).'\'));">← Anterior</a></li>' : '<li class="prev disabled"><a href="#">← Anterior</a></li>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<li><a href="javascript:void(paginacao(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							$html .= '<li class="active"><a href="#">'.$pagina.'</a></li>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<li><a href="javascript:void(paginacao(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a></li>' : '<li><a href="#">&nbsp;</a></li>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<li class="next"><a href="javascript:void(paginacao(\''.( $pagina + 1 ).'\'));">Próxima → </a></li>' : '<li class="next disabled"><a href="#">Próxima → </a></li>';
							$html .= '</ul>
						</div>
					</div>
				</div>';

		return $html;
	}

	public function admAtivaBloqUsuario($id=null, $action=null)
	{
		if( !empty( $id ) and !empty( $action ) ) {
			if( $action == 'a' ) { 
				$act = '2'; 
				$textAction = 'ativado';
			} else { 
				$act = '3'; 
				$textAction = 'bloqueado'; 
			}

			$tabela = 'tb_usuarios';
			$where = " usu_id = '{$id}'";
			$update['tb_usuarios']['fk_status'] = $act;
			if($this->banco->editar($tabela,$update['tb_usuarios'],$where)) {
				$dados['action'] = 'success';
				$dados['textAttention'] = 'SUCESSO! - ';
				$dados['text'] = 'Usuário '.$textAction.'.';
				return $dados;
			} else {
				$dados['action'] = 'error';
				$dados['textAttention'] = 'ERRO! - ';
				$dados['text'] = 'Usuário NÃO ativado.';
				return $dados;
			}
		}
	}
	
	public function isset_usuario_ajax()
	{
		$res = $this->banco->ver('tb_usuarios','usu_usuario', "usu_usuario = '{$_POST['usu_usuario']}'");
		
		if(!empty($res)){
			echo 'sim';die;
		}else{
			echo 'nao';die;
		}
	}
	
	public function isset_email_ajax()
	{
		$res = $this->banco->ver('tb_usuarios','usu_email', "usu_email = '{$_POST['usu_email']}'");
	
		if(!empty($res)){
			echo 'sim';die;
		}else{
			echo 'nao';die;
		}
	}
	
	public function isset_idade_ajax()
	{
		$this->SetUsuDatanasc($_POST['usu_datanasc']);
		
		$data = $this->VerMaiorIdade();
		
		//var_dump($data);die;
	
		if(!$data){
			echo 'sim';die;
		}else{
			echo 'nao';die;
		}
	}
	
	public function isset_cpf_ajax()
	{
		$this->SetUsuDoc($_POST['usu_doc']);
		$cpf = $this->GetUsuDoc();
		
		
		
		//var_dump($data);die;
		
		if($this->ValidaCpf()){
			
			if($this->banco->ValidaRegistro('public.tb_usuarios','usu_id',"usu_doc = '{$cpf}'")){
				
			echo 'nao';die;
			
			}else{
				echo 'sim';die;
			}
			
			
		}else{
			echo 'nao';die;
		}
	}
	
	public function card_cpf_ajax()
	{
		$this->SetUsuDoc($_POST['usu_doc']);
		$cpf = $this->GetUsuDoc();
		
		
		
		
		
		if($this->ValidaCpf()){

			if($this->banco->ValidaRegistro('public.tb_card','card_id',"card_doc = '{$cpf}'")){
				
			echo 'nao';die;
			
			}else{
				echo 'sim';die;
			}
			
			
		}else{

			echo 'nao';die;
		}
	}
	
	public function get_usu_voucher_ajax()
	{
		$this->voucher = new TbVoucher;
		$this->voucher->SetVoucherHash($_POST['usu_voucher']);
		$this->voucher->SetFkProd($_POST['fk_prod']);
		$res = $this->voucher->ValidaUsuVoucher();
	
		if(!empty($res)){
			echo json_encode($res);die;
		}else{
			echo '{"usu_nome":"erro"}';die;
		}
	}
	
	public function get_cep_ajax()
	{
		$this->endereco = new TbEndereco;
		$this->endereco->SetEndCep($_POST['end_cep']);
		$res = $this->endereco->ValidaCEP();
		
		echo json_encode($res);die;
	}
	
	public function ValidaUsuario($usu)
	{
		$this->SetUsuUsuario($usu);
		$res = $this->SelectOne();
		
		if($res)
		{
			return $res;
			
		}else{
			
			$this->SetUsuUsuario(Controller::$cliente);
			$res = $this->SelectOne();
			Controller::$parametros['usuario'] = Controller::$cliente;
		}
		
		return $res;
		
	}
	
	public function ValidaUsuarioAtivo($usu)
	{
		$this->SetUsuUsuario($usu);
		$res = $this->SelectAtivo();
	
		
			return $res;
				
		
	
		
	
	}
	
	public function rede_bin(){
	
		// $novousu	= '92317537034';
		
		$indicador = $this->GetFkUsu();
	
		$derrama = array();
	
		$derrama['res'] = false;
		
		$perna = $this->GetUsuPerna();
	
		while ( $derrama['res'] == false) {
	
			$derrama 	= $this->DerramaBinario($indicador,$perna);
			$indicador 	= $derrama['novo'];
			
		}
		$derrama['res']['usu_perna_pref'] = $perna;
		
		return $derrama['res'];
	
	}
	
	public function ver_meio_pagamento()
	{
		
		$this->meiopagamento = new MeioPagamento;
		
				
		return true;
		
	}

	 public function top_vendas(){	
		return array("dados"=>$this->calcVolPontos(), "fracao"=>$this->volPontos(6));	  
     }	 

	 public function top_recrutamento(){
       return false;
     }
	 
	 public function adm_listar_top_ajax() {	
	 
		self::$numreg = $_POST['regpag']; 
	    self::$inicial = 0;
		//echo "<pr>"; print_r($this->getAllUsu());
		
		if (!isset($pg)) {
			$pg = 0;
		}
		self::$inicial = $pg * self::$numreg;	 
	 
        return array(
          "usuRecruta"=>$this->getAllUsu(),
		  "percentPontos"=>$this->volPontos(1),
		  "template"=>"top_recrutamento_ajax",
		);

	}
	 
	 public function volPontos($percent){		
	    foreach($this->resVolPontos() as $volPontos){
		  return $percent * $volPontos['pt_pontos'] / 100;		
		}	  		
	  }
	  
	  
  public function precadastro(){
   
	$indicante = $this->banco->executar("SELECT usu_doc FROM tb_usuarios WHERE usu_usuario = '".Controller::$parametros['usuario']."'");
	$doc = $indicante[0]['usu_doc'];

	if(isset($_POST['acao']) == 'ok'){
			
		$cadastro   = new TbCadastro;	
        $redeFilhos = $cadastro->getUsuRede5x5();
		$usuDoc     =  $redeFilhos['redeFilhos'][0]['usu_doc'];
		
		$da = ($cadMeuDireto[0]['total'] == 0) ? $doc : "00000000001";
		
		
		$sexo = $_POST['gender']; 
		$cel = str_replace("(","",$_POST['cel']);
		$cel = str_replace(")","",$cel);
		$cel = str_replace("-","",$cel);
		$cel = str_replace(" ","",$cel);
		$cel = ($cel != "") ? $cel : NULL ; 
		
		$whatsapp = str_replace("(","",$_POST['whatsapp']);
		$whatsapp = str_replace(")","",$whatsapp);
		$whatsapp = str_replace("-","",$whatsapp);
		$whatsapp = str_replace(" ","",$whatsapp);
		$whatsapp = ($whatsapp != "") ? $whatsapp : NULL ; 

		$usuario = array(
			"temp_nome"=>strip_tags(trim($_POST['nome'])),
			"temp_datanasc"=>implode("-",array_reverse(explode("/",$_POST['datanasc']))),
			"temp_celular"=>strip_tags(trim($cel)),
			"temp_whatsapp"=>strip_tags(trim($whatsapp)),
			"temp_email"=>strip_tags(trim($_POST['email'])),
			"fk_pai"=>strip_tags(trim($usuDoc)),
			"temp_sexo"=>strip_tags(trim($sexo)),
			"fk_status"=>1
		); 
			
		$id = $this->banco->inserir("public.tb_usu_temporarios", $usuario, 'tb_usu_temporarios_temp_id_seq');		  
		  
		$usu = $this->banco->executar("SELECT usu_nome,usu_usuario,usu_email FROM public.tb_usuarios WHERE usu_doc = '$usuDoc'");
		$celular = $this->banco->executar("SELECT fone_fone as fone FROM public.tb_fone WHERE fk_usu = '$usuDoc' AND fk_tipo = 3");
		$whats = $this->banco->executar("SELECT fone_fone as fone FROM public.tb_fone WHERE fk_usu = '$usuDoc' AND fk_tipo = 4 ");
		
		$nomePessoa = strip_tags(trim($_POST['nome']));
		$emailPessoa = strip_tags(trim($_POST['email']));
		
		$nome = strip_tags(trim($usu[0]['usu_nome']));
		$usuario = strip_tags(trim($usu[0]['usu_usuario']));
		$email = strip_tags(trim($usu[0]['usu_email']));
		$celu = strip_tags(trim($celular[0]['fone']));
		$wha = strip_tags(trim($whats[0]['fone']));	
		  
		$html = "<p><strong>PARABÉNS!</strong></p>
			<p> <strong>$nomePessoa</strong> Você acabou de dar um grande PASSO! Esses R$150,00 que vai doar fará uma enorme diferença na sua VIDA. </p>
			<p>Eu sou <strong>$nome</strong> Quero que saiba que permaneço a sua disposição para o que precisar, caso tenha dúvidas, por favor não perca tempo e faça contato imediatamente, coloco-me a sua inteira disposição. Nós somos uma equipe extremamente unida. Este sistema espetacular tem mudado a minha vida significativamente e também mudará a sua vida e eu estou aqui para ajudá-lo a conquistar este resultado.</p>
			<p> A nossa melhor estratégia de atuação é nos unirmos! Este sistema é VERDADEIRAMENTE DE AJUDA MÚTUA, não se compara a nenhum outro sistema já lançado na internet nacional ou internacional. Caso já tenha participado de algum sistema e se decepcionou, não deixe que isso te impeça de ganhar com este sistema. Se você ainda não tem certeza que este sistema pode mudar a sua vida,</p>
			<p>por favor me envie uma mensagem no Whatsapp, SMS ou no e-mail, eu terei uma enorme satisfação em atendê-lo orientá-lo.</p>
			<p> <strong>Para facilitar, deixei aqui os meus dados de contato:</strong></p>
			<p> <strong>Nome:</strong> $nome <br />
			<strong>Usuário:</strong>  $usuario <br />
			<strong>Whatsapp:</strong> $wha<br />
			<strong>Celular:</strong>  $celu<br />
			<strong>E-mail:</strong>   $email<br /></p>
			<p> <strong> $nomePessoa Não deixe passar essa oportunidade única de negócio. Este empreendimento pode aumentar a sua renda, sem comprometer seu horário de Trabalho. </strong></p>
			<p>Eu o parabenizo pela sabia decisão de participar deste projeto tão grandioso e que abre portas para uma infinidade de empreendimentos virtuais, a começar pela AJUDA MÚTUA que é um sucesso absoluto no BRASIL, vários empreendimentos virão.</p>
			<p> Sempre que precisar, entre em contato comigo ou com a nossa equipe, pois sempre estaremos ao seu dispor! </p>	
			<p><strong>Atenciosamente, </strong></p>
			<p><strong>G3Money </strong></p>
			<p>http://g3money10.com.br/ </p>
			<p><strong>Onde pequenos valores somam grande OPORTUNIDADES.</strong></p>";	 
		
		$dados1 = array(
			"usu_usuario"=>$nomePessoa,
			"usu_email"=>$emailPessoa,
			"assunto"=>"Parabéns! Você deu o primeiro passo para o seu sucesso financeiro!",
			"msg" => $html
			); 
		
			
		$email1 = new Email;
		$enviado1 = $email1->enviar($dados1);
		
		$infoContato = $this->banco->executar("SELECT * FROM public.tb_usu_temporarios WHERE temp_id = '$id'");
				
		$nomeContato = $infoContato[0]['temp_nome'];
		$whaContato = $infoContato[0]['temp_whatsapp'];
		$celContato = $infoContato[0]['temp_celular'];
		$emailContato = $infoContato[0]['temp_email'];
		
		$htmlUsuario = "
		    <p><strong>PARABÉNS!</strong></p>
			<p><strong>$nome</strong> Uma pessoa acaba de se cadastrar no seu link! Não Perca tempo e faça contato imediatamente.</p>
			<p> A nossa melhor estratégia de atuação é o seu contato, por favor relacione-se com o seu direto, ele é a pessoa que vai lhe fazer a DOAÇÃO e talvez por falta de informação do projeto você perderá esta oportunidade valiosa de confirmar mais um participante para a equipe. </p>
			<p>Envie uma mensagem no Whatsapp, SMS e no e-mail, parabenizando-o pela sabia decisão de participar deste projeto tão grandioso e que abre portas para uma infinidade de empreendimentos virtuais, a começar pela AJUDA MÚTUA. </p>
			<p>Deixe claro para ele, que ele é muito importante para este projeto e tire todas as suas dúvidas! Segue as informações de contato da pessoa. </p>
			<p><strong>Nome:</strong> $nomeContato <br>
			<strong>Whatsapp:</strong> $whaContato<br>
			<strong>Celular: </strong> $celContato<br>
			<strong>E-mail:</strong> $emailContato <br>
			</p>
			<p> O SEU PAPEL NESTE MOMENTO É:<p> - Tirar as dúvidas da pessoa, dentro do seu nível de conhecimento, sempre sugerindo que a pessoa assista aos vídeos oficiais.</p>
			<p> <strong>$nome</strong> Não deixe passar essa oportunidade única de adicionar o <strong>$nomeContato</strong> ao projeto. </p>
			<p>Faça contato urgentemente, este empreendimento pode aumentar a sua renda sem comprometer o seu horário de Trabalho.</p>
			<p>Sempre que precisar, entre em contato conosco, pois sempre estaremos ao seu dispor! </p>
			<p><strong>Atenciosamente, </strong></p>
			<p><strong>G3Money - Ajuda Mútua Financeira </strong></p>
			<p>http://g3money10.com.br/</p>";

		$dados2 = array(
			"usu_usuario"=>$nome,
			"usu_email"=>$email,
			"assunto"=>"Adicione o [$nomeContato] ao projeto G3Money.",
			"msg" => $htmlUsuario
			); 
			
		$email2 = new Email;
		$enviado2 = $email2->enviar($dados2);

   	    return array(
			  "template"=>"precadastro",
			  "retorno"=>"ok"
			);
	
}
		
	 return array(
		  "template"=>"precadastro"
		);
	
	}
 
	public function mod($dividendo,$divisor){
      return round($dividendo - (floor($dividendo/$divisor)*$divisor));
    }
	
	public function geradorCpf(){
		$compontos == 1;
		$n1 = rand(0,9);
		$n2 = rand(0,9);
		$n3 = rand(0,9);
		$n4 = rand(0,9);
		$n5 = rand(0,9);
		$n6 = rand(0,9);
		$n7 = rand(0,9);
		$n8 = rand(0,9);
		$n9 = rand(0,9);
		$d1 = $n9*2+$n8*3+$n7*4+$n6*5+$n5*6+$n4*7+$n3*8+$n2*9+$n1*10;
		$d1 = 11 - ( $this->mod($d1,11) );
		if ( $d1 >= 10 )
		{ $d1 = 0 ;
		}
		$d2 = $d1*2+$n9*3+$n8*4+$n7*5+$n6*6+$n5*7+$n4*8+$n3*9+$n2*10+$n1*11;
		$d2 = 11 - ( $this->mod($d2,11) );
		if ($d2>=10) { $d2 = 0 ;}
		$retorno = '';
		if ($compontos==1) {$retorno = ''.$n1.$n2.$n3.".".$n4.$n5.$n6.".".$n7.$n8.$n9."-".$d1.$d2;}
		else {$retorno = ''.$n1.$n2.$n3.$n4.$n5.$n6.$n7.$n8.$n9.$d1.$d2;}
   	    
		return $retorno;
		
	}
	
	
public function reentradaCadastro(){

if(isset($_POST['acao']) == "reentrada"){
  session_regenerate_id();
  
if(isset($_SESSION['usuario']['usu_doc'])){
	  
   $novoDoc = $this->geradorCpf();
   $docV = $this->banco->executar("SELECT usu_id FROM public.tb_usuarios WHERE usu_doc = '".$novoDoc."'");	  		

if(!isset($docV[0])){  

	$listUsuarios = $this->banco->executar("SELECT * FROM tb_usuarios WHERE usu_doc = '".$_SESSION['usuario']['usu_doc']."'");
	
	$rand = rand();
	$senha = $this->Password($rand);  
		  
	$masteReen = $this->banco->executar("SELECT count(usu_id) as total FROM public.tb_usuarios WHERE master_reentrada = '".$_SESSION['usuario']['usu_doc']."'");	    		
	
	$num = $masteReen[0]['total']+1;
	$ususUsuario = ( $masteReen[0]['total'] == 0 ) ? $listUsuarios[0]['usu_usuario']."x"."1" : $listUsuarios[0]['usu_usuario']."x".$num;    
		
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
		<td colspan='2'>Olá, <strong>".$ususUsuario."</strong> </td>
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
		<td><a href='http://g3money10.com.br/".$ususUsuario."' target='_blank'>http://g3money10.com.br/".$ususUsuario."</a></td>
	  </tr>
	  <tr>
		<td><strong>Usuário:</strong></td>
		<td>".$ususUsuario."</td>
	  </tr>
	  <tr>
		<td><strong>Senha:</strong></td>
		<td>".$rand."</td>
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

$doc = $listUsuarios[0]['usu_doc'];

// Se eu não tiver nenhum abaixo ele cadastra pra mim pelo menos uma pessoa pra mim reculperar o dinheiro investido		
$cadMeuDireto = $this->banco->executar("SELECT count(fk_usu) as total FROM public.tb_usuarios WHERE fk_usu = '$doc'");	    
/*
if($cadMeuDireto[0]['total'] = 0){

	$cpf = $novoDoc;

	$usuario = array(
		"usu_nome"=>$listUsuarios[0]['usu_nome'],
		"usu_usuario"=>$ususUsuario,
		"usu_senha"=>$listUsuarios[0]['usu_senha'],
		"fk_status"=>1,
		"usu_datanasc"=>$listUsuarios[0]['usu_datanasc'],
		"usu_doc"=>$novoDoc,
		"usu_data"=>"NOW()",
		"fk_usu"=>$doc,
		"usu_sexo"=>$listUsuarios[0]['usu_sexo'],
		"fk_usu_rede"=>$doc,
		"fk_bonus"=>1,		   
		"usu_email"=>$listUsuarios[0]['usu_email'],
		"fk_carreira"=>1,
		"master_reentrada"=>$_SESSION['usuario']['usu_doc']
		); 

	$seqId = $this->banco->inserir("public.tb_usuarios", $usuario, "tb_usuarios_usu_id_seq");

	
$celu = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fk_tipo = 3");	

		 $cel = $celu[0]['fone_fone'];
		 $cel = ($cel != "") ? $cel : NULL ;
			  if($cel != ""){					
				 $celular = array(
				   "fone_fone" => $cel,
				   "fk_usu"=>$novoDoc,
				   "fk_tipo"=>3
				 );
				
		$this->banco->inserir("public.tb_fone", $celular);
			  }
			  
$wha = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fk_tipo = 4");
			  
		$w = $wha[0]['fone_fone'];
		$w = ($w != "") ? $w : NULL ;	
		  
		if($w != ""){
			$whatsapp = array(
			   "fone_fone"=>$w,
			   "fk_usu"=>$novoDoc,
			   "fk_tipo"=>4
			 );
		// echo "<pre>"; print_r($cpf); die;
	$this->banco->inserir("public.tb_fone", $whatsapp);
		}

$listFones = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fk_tipo = 1");
				
		$f = $listFones[0]['fone_fone'];
			 
		$f = ($f != "") ? $f : NULL;
			if($f != ""){		 
				 $fixo = array(
				   "fone_fone"=>$f,
				   "fk_usu"=>$novoDoc,
				   "fk_tipo"=>1
				 );
			 
	$this->banco->inserir("public.tb_fone", $fixo);
			}

	

$comer = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fk_tipo = 2");

			$c = $comer[0]['fone_fone'];
			$c = ($c != "") ? $c : NULL ;	
			  
			if($c != ""){
				$comercial = array(
				   "fone_fone"=>$c,
				   "fk_usu"=>$novoDoc,
				   "fk_tipo"=>2
				 );

		$this->banco->inserir("public.tb_fone", $comercial);
			}
			
$listEnd = $this->banco->executar("SELECT * FROM tb_endereco WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."'");
				 
				 $endereco = array(
				   "end_cep"=>$listEnd[0]['end_cep'],
				   "end_end"=>$listEnd[0]['end_end'],
				   "end_n"=>$listEnd[0]['end_n'],
				   "end_bairro"=>$listEnd[0]['end_bairro'],
				   "end_cidade"=>$listEnd[0]['end_cidade'],
				   "end_uf"=>$listEnd[0]['end_uf'],
				   "fk_usu"=>$novoDoc
				 );  
			
	$this->banco->inserir("public.tb_endereco", $endereco);

$ip = Controller::$ip;
$browser = Controller::$browser;	 
$cad = new Cadastro;

$documento  = $this->banco->executar("SELECT usu_doc FROM public.tb_usuarios WHERE usu_id = '$seqId'"); 
$AcimaNivel = $cad->getNiveisAcimaReentrada($documento[0]['usu_doc']);

//echo "<pre>"; print_r( $AcimaNivel );die;	

 if(!$AcimaNivel['dados']){
			
		 session_regenerate_id();
		 $num = 1;
		 $conta = $num++;
		   
		 $dataEx = ($conta == 1) ? date('Y-m-d H:m:s', strtotime('+1 days')) : NULL;
		  
		 $pedidos = array(
		   "fk_usu"=>$novoDoc,
		   "ped_total"=>$this->valorDoacao,
		   "ped_sessao"=>session_id(),
		   "ped_ip"=>$ip,
		   "ped_browser"=>$browser,
		   "ped_data_expira"=>$dataEx,
		   "fk_pai"=> "00000000001",
		   "ped_nivel"=>$conta,
		   "ped_qtd_downlines"=>$this->matrix5
		 );   
		
		 $this->banco->inserir("public.tb_pedidos", $pedidos);	

			
}else{

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
	   "fk_usu"=>$novoDoc,
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
   }
 
	   $dados = array(
		"usu_usuario"=>$ususUsuario,
		"usu_senha"=>$rand,
		"usu_email"=>$listUsuarios[0]['usu_email'],
		"assunto"=>"Parabéns! Você deu o primeiro passo para o seu sucesso financeiro‏",
		"msg" => $html
		); 
		
	 $email = new Email;
	 $mail = $email->enviar($dados); // Envia o e-mail com boas vindas	
		
$usu = $this->banco->executar("SELECT usu_email, usu_usuario FROM public.tb_usuarios WHERE usu_doc = '".$_SESSION['usuario']['usu_doc']."' AND fk_status = 2");

$usuNovo = $this->banco->executar("SELECT usu_usuario, usu_nome, usu_email  FROM public.tb_usuarios WHERE usu_doc = '".$novoDoc."'");

//Dados da pessoa que se cadastrou
$nome2 = strip_tags(trim($usuNovo[0]['usu_nome']));
$usuario2 = strip_tags(trim($usuNovo[0]['usu_usuario']));
$email2 = strip_tags(trim($usuNovo[0]['usu_email']));
		
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
	   return array("template"=>"cadastrar", "retorno"=>"sim", "mail"=>"sim");
	
	
}else{*/

	$novoDoc = $this->geradorCpf();

	$listUsuarios = $this->banco->executar("SELECT * FROM tb_usuarios WHERE usu_doc = '".$_SESSION['usuario']['usu_doc']."'");
	
	$masteReen = $this->banco->executar("SELECT count(usu_id) as total FROM public.tb_usuarios WHERE master_reentrada = '".$_SESSION['usuario']['usu_doc']."'");	    		
		
	$num = $masteReen[0]['total']+1;
	$ususUsuario = ( $masteReen[0]['total'] == 0 ) ? $listUsuarios[0]['usu_usuario']."x"."1" : $listUsuarios[0]['usu_usuario']."x".$num;    
    
	$doc = $listUsuarios[0]['usu_doc'];

	$cadastro = new TbCadastro;		  
	$redeFilhos    = $cadastro->getUsuRede5x5();	  // Retorna os usuários da minha rede
	
	$usuDoc =  $redeFilhos['redeFilhos'][0]['usu_doc'];
	if(!empty($redeFilhos['redeFilhos'][0])){
	
	$usuario = array(
		"usu_nome"=>$listUsuarios[0]['usu_nome'],
		"usu_usuario"=>$ususUsuario,
		"usu_senha"=>$listUsuarios[0]['usu_senha'],
		"fk_status"=>1,
		"usu_datanasc"=>$listUsuarios[0]['usu_datanasc'],
		"usu_doc"=>$novoDoc,
		"usu_data"=>"NOW()",
		"fk_usu"=>$listUsuarios[0]['usu_doc'],
		"usu_sexo"=>$listUsuarios[0]['usu_sexo'],
		"fk_usu_rede"=>$usuDoc,
		"fk_bonus"=>1,		   
		"usu_email"=>$listUsuarios[0]['usu_email'],
		"fk_carreira"=>1,	
		"master_reentrada"=>$_SESSION['usuario']['usu_doc']   
		); 

    
		
	$seqId = $this->banco->inserir("public.tb_usuarios", $usuario, "tb_usuarios_usu_id_seq");

$celu = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fk_tipo = 3");	

		 $cel = $celu[0]['fone_fone'];
		 $cel = ($cel != "") ? $cel : NULL ;
			  if($cel != ""){					
				 $celular = array(
				   "fone_fone" => $cel,
				   "fk_usu"=>$novoDoc,
				   "fk_tipo"=>3
				 );
				
		$this->banco->inserir("public.tb_fone", $celular);
			  }
			  
$wha = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fk_tipo = 4");
			  
		$w = $wha[0]['fone_fone'];
		$w = ($w != "") ? $w : NULL ;	
		  
		if($w != ""){
			$whatsapp = array(
			   "fone_fone"=>$w,
			   "fk_usu"=>$novoDoc,
			   "fk_tipo"=>4
			 );

	$this->banco->inserir("public.tb_fone", $whatsapp);
		}

$listFones = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fk_tipo = 1");
				
		$f = $listFones[0]['fone_fone'];
			 
		$f = ($f != "") ? $f : NULL;
			if($f != ""){		 
				 $fixo = array(
				   "fone_fone"=>$f,
				   "fk_usu"=>$novoDoc,
				   "fk_tipo"=>1
				 );
			 
		$this->banco->inserir("public.tb_fone", $fixo);
			}
			
$comer = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND fk_tipo = 2");

			$c = $comer[0]['fone_fone'];
			$c = ($c != "") ? $c : NULL ;	
			  
			if($c != ""){
				$comercial = array(
				   "fone_fone"=>$c,
				   "fk_usu"=>$novoDoc,
				   "fk_tipo"=>2
				 );

		$this->banco->inserir("public.tb_fone", $comercial);
			}
			
$listEnd = $this->banco->executar("SELECT * FROM tb_endereco WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."'");
				 
				 $endereco = array(
				   "end_cep"=>$listEnd[0]['end_cep'],
				   "end_end"=>$listEnd[0]['end_end'],
				   "end_n"=>$listEnd[0]['end_n'],
				   "end_bairro"=>$listEnd[0]['end_bairro'],
				   "end_cidade"=>$listEnd[0]['end_cidade'],
				   "end_uf"=>$listEnd[0]['end_uf'],
				   "fk_usu"=>$novoDoc
				 );  
			
	     $this->banco->inserir("public.tb_endereco", $endereco);

		 $ip = Controller::$ip;
		 $browser = Controller::$browser;	 
		 $cad = new Cadastro;
		 
		 $documento  = $this->banco->executar("SELECT usu_doc FROM public.tb_usuarios WHERE usu_id = '$seqId'"); 
         $AcimaNivel = $cad->getNiveisAcimaReentrada($documento[0]['usu_doc']);

	   if(!$AcimaNivel['dados']){
			
		 session_regenerate_id();
		 $num = 1;
		 $conta = $num++;
		   
		 $dataEx = ($conta == 1) ? date('Y-m-d H:m:s', strtotime('+1 days')) : NULL;
		  
		 $pedidos = array(
		   "fk_usu"=>$novoDoc,
		   "ped_total"=>$this->valorDoacao,
		   "ped_sessao"=>session_id(),
		   "ped_ip"=>$ip,
		   "ped_browser"=>$browser,
		   "ped_data_expira"=>$dataEx,
		   "fk_pai"=> "00000000001",
		   "ped_nivel"=>$conta,
		   "ped_qtd_downlines"=>$this->matrix5
		 );   
		
	  $this->banco->inserir("public.tb_pedidos", $pedidos);	
			
		  }else{

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
		   "fk_usu"=>$novoDoc,
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
   	   }
     
	 $dados = array(
		"usu_usuario"=>$ususUsuario,
		"usu_senha"=>$rand,
		"usu_email"=>$listUsuarios[0]['usu_email'],
		"assunto"=>"Parabéns! Você deu o primeiro passo para o seu sucesso financeiro‏",
		"msg" => $html
		); 
		
	$email = new Email;
	$mail = $email->enviar($dados); // Envia o e-mail com boas vindas	

$usu = $this->banco->executar("SELECT usu_email, usu_usuario FROM public.tb_usuarios WHERE usu_doc = '".$doc."' AND fk_status = 2");

$usuNovo = $this->banco->executar("SELECT usu_usuario, usu_nome, usu_email  FROM public.tb_usuarios WHERE usu_doc = '".$novoDoc."'");

//echo "<pre>"; print_r($usu); die;

//Dados da pessoa que se cadastrou
$nome2 = strip_tags(trim($usuNovo[0]['usu_nome']));
$usuario2 = strip_tags(trim($usuNovo[0]['usu_usuario']));
$email2 = strip_tags(trim($usuNovo[0]['usu_email']));

		
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
	   return array("template"=>"cadastrar", "null"=>"sim", "mail"=>"sim");
	 }	
	  else{
		   session_regenerate_id();	 
			return array("template"=>"null", "retorno"=>"nao");
      }	

	 //}

}else{
	return array("template"=>"null", "retorno"=>"nao");
}
}else{
	return array("template"=>"null", "retorno"=>"nao");
} 

}else{
	return array("template"=>"null", "retorno"=>"nao");
} 
return array("template"=>"null");
		
}
	
  
}