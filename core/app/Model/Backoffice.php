<?php 

class Backoffice extends TbUsuarios
{
	
	public function home_msr()
	{		
     
	if(isset($_POST['acao']) == "novaconta"){
	  $novasContas = $this->banco->executar("SELECT master_reentrada, usu_usuario, usu_doc FROM public.tb_usuarios WHERE usu_doc = '{$_POST['id']}'");	  	
	  
	  $master = $this->banco->executar("SELECT usu_usuario, usu_doc FROM public.tb_usuarios WHERE usu_doc = '{$novasContas[0]['master_reentrada']}'");
	
	  unset($_SESSION['usuario']['usu_doc']);
	  unset($_SESSION['usuario']['usu_usuario']);

	  $_SESSION['usuario']['master'] = strip_tags(trim($novasContas[0]['master_reentrada']));
	  $_SESSION['usuario']['usu_master'] = strip_tags(trim($master[0]['usu_usuario']));
	  
	  $_SESSION['usuario']['usu_doc'] = strip_tags(trim($_POST['id']));
	  $_SESSION['usuario']['usu_usuario'] = strip_tags(trim($novasContas[0]['usu_usuario']));
	  
	  return array("template"=>"null", "retorno"=>"ok");
	}
	 
	 
	$doacao = new Doacoes;
	
	$query = $this->banco->executar("SELECT *, to_char(usu_data,'DD/MM/YYYY') as usu_data FROM public.tb_usuarios 
	INNER JOIN tb_status_usu u ON public.tb_usuarios.fk_status = u.status_id
	ORDER BY usu_id DESC");
      
	$novasContas = $this->banco->executar("SELECT usu_usuario, usu_doc FROM public.tb_usuarios WHERE master_reentrada = '{$_SESSION['usuario']['usu_doc']}' ORDER BY usu_id DESC");	  	
	  
	$migrar3m1r = $this->banco->executar("SELECT ped_nivel FROM public.tb_pedidos WHERE fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND fk_status = 3 AND ped_nivel = 2");
	  
    $ativa = $this->banco->executar("
						SELECT 
							usu.usu_usuario,
							usu.usu_doc,
							to_char(ped.ped_data_expira, 'DD/MM/YYYY HH:MM:SS'  ) as ped_data_expira
						FROM 
							public.tb_usuarios as usu,
							public.tb_pedidos as ped
						WHERE
							usu.usu_doc = '{$_SESSION['usuario']['usu_doc']}' AND
							usu.usu_doc = ped.fk_usu AND
							ped.ped_nivel = 1 AND
							ped.fk_status = 3 AND
							usu.fk_status = 2 
						");	

	$inativo = $this->banco->executar("
						SELECT 
							usu.usu_usuario,
							usu.usu_doc,
							to_char(ped.ped_data_expira, 'DD/MM/YYYY HH:MM:SS'  ) as ped_data_expira
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
						
    $dia = $this->banco->executar("
						SELECT 						
							ped_data_expira
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
    						
	$relogio = $this->banco->executar("
						SELECT 						
							ped_data_expira
						FROM 
							public.tb_usuarios as usu,
							public.tb_pedidos as ped
						WHERE
							usu.usu_doc = '{$_SESSION['usuario']['usu_doc']}' AND
							usu.usu_doc = ped.fk_usu AND
							ped.fk_status = 1 AND
							usu.fk_status != 1 AND
							ped.ped_data_expira IS NOT NULL
										");	
	  $diaSemana = $this->banco->executar("SELECT date_part('dow', timestamp '".date('Y-m-d')."') as semana");	    
	  
	  $allUser = $this->banco->executar("SELECT count(usu_id) as total FROM public.tb_usuarios");	 
	  
	  
	  return array(
				'query' => $query,
				'doar'=>$doacao->recebidas_home(),
				'nivel'=>$doacao->getNivel(),
				"banco"=>$doacao->listBanco(),
				"ativa"=>$ativa,
				"dia"=>$dia,
				"inativo"=>$inativo,
				"migrar3m1r"=>$migrar3m1r,
				"relogio"=>$relogio,
				"diaSemana"=>$diaSemana,
				"posicaoRede"=>$this->posicaoRede(),
				"preenchendoLinha"=>$this->preenchendoLinha(),
				"meusUltimosCadastros"=>$this->meusUltimosCadastros(),
				"novasContas"=>$novasContas,
				"allUser"=>$allUser
				
		);
	   
	}
	
	
	public function confirmanoCadastro(){
	  	 
	  if(isset($_POST['acao']) == "comprovante"){		
		$seg 		= explode('.', microtime(true));
		$foto	    = date('YmdHis').$seg[1].$_FILES["arquivo"]['name'];
		$allowedExts = array("image/jpeg", "image/jpg", "image/png");		
		
		$comp = $this->banco->executar("SELECT fk_usu FROM public.tb_comprovantes_getcash WHERE fk_usu = '".strip_tags(trim($_SESSION['usuario']['usu_doc']))."'");
		
		if(empty($comp[0]['fk_usu'])){
			
			  if(in_array($_FILES["arquivo"]['type'], $allowedExts)){	
			 
				$comprovantes = array(
					'compro_img'=> strtolower($foto),
					'fk_usu'=> $_SESSION['usuario']['usu_doc']
				);
				$this->banco->inserir('public.tb_comprovantes_getcash',$comprovantes);  
				$pasta = "/var/www/getcash/public_html/core/View/comprovantes_adm/". strtolower($foto);
				
				move_uploaded_file($_FILES["arquivo"]["tmp_name"], $pasta );
				session_regenerate_id();
		        return array("retorno"=>"ok");
				
			 }else{
				session_regenerate_id();
				return array("formato"=>"no");
			}
	    }else{
			session_regenerate_id();
			return array("retorno"=>"no");
		}
	 }
	  
	}
	
	
	
	public function posicaoRede(){

	  $posicao = $this->banco->executar("
	    WITH RECURSIVE familia (usu_id, usu_doc, fk_status, fk_usu_rede, nivel) AS
		(
		SELECT 
			u1.usu_id, u1.usu_doc, u1.fk_status, u1.fk_usu_rede, 1 AS nivel
		FROM tb_usuarios AS u1
		WHERE
			u1.usu_doc = '{$_SESSION['usuario']['usu_doc']}'
		UNION ALL
		SELECT 
			u2.usu_id, u2.usu_doc, u2.fk_status, u2.fk_usu_rede, f.nivel + 1 AS nivel
		FROM tb_usuarios AS u2
		INNER JOIN familia AS f ON u2.usu_doc = f.fk_usu_rede

		)
		SELECT 
		f.usu_id, f.usu_doc, f.fk_status, f.fk_usu_rede, (SELECT count(usu_id) FROM public.tb_usuarios WHERE fk_usu_rede = f.usu_doc) as total
		FROM 
		familia as f		
		ORDER BY f.usu_id ASC");	    
	  
	  foreach($posicao as $numP){
	   $total += count($numP['usu_doc']); 
	  }	 
	  return array("total"=>$total);

	}
	
	
	public function preenchendoLinha(){
	  
	  $cad = new TbCadastro;		  
	  $docs = $cad->getUsuRede5x5();
	  $doc = $docs['redeFilhos'][0]['usu_doc'];	  

	  $preenchendoLinha = $this->banco->executar("
	    WITH RECURSIVE familia (usu_id, usu_doc, fk_status, fk_usu_rede, nivel) AS
		(
		SELECT 
			u1.usu_id, u1.usu_doc, u1.fk_status, u1.fk_usu_rede, 1 AS nivel
		FROM tb_usuarios AS u1
		WHERE
			u1.usu_doc = '$doc' AND u1.fk_status = 2
		UNION ALL
		SELECT 
			u2.usu_id, u2.usu_doc, u2.fk_status, u2.fk_usu_rede, f.nivel + 1 AS nivel
		FROM tb_usuarios AS u2
		INNER JOIN familia AS f ON u2.usu_doc = f.fk_usu_rede
		WHERE u2.fk_status = 2
		)
		SELECT 
		f.usu_id, f.usu_doc, f.fk_status, f.fk_usu_rede, (SELECT count(usu_id) FROM public.tb_usuarios WHERE fk_usu_rede = f.usu_doc) as total
		FROM 
		familia as f		
		ORDER BY f.usu_id ASC");	    
	 
	  $total = 0;
	  foreach($preenchendoLinha as $numP){
	   $total += count($numP['usu_doc']); 
	  }
	  return array("total"=>$total);

	}
	
	public function meusUltimosCadastros(){
		$ultimoCad = $this->banco->executar("SELECT to_char(usu_data, 'DD/MM/YYYY') as usu_data FROM public.tb_usuarios WHERE fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND fk_status = 2 ORDER BY usu_id DESC LIMIT 1");
	    return array("ultimoCad"=>$ultimoCad);
	}
	/*
	public function cadDepoisDeMim(){
		$cadEpois = $this->banco->executar("SELECT usu_id FROM public.tb_usuarios WHERE usu_doc = '{$_SESSION['usuario']['usu_doc']}' AND fk_status = 2");
		$cadEpois2 = $this->banco->executar("
											SELECT 
												usu_id
											FROM 
												public.tb_usuarios
											WHERE 
												usu_id > ".strip_tags(trim($cadEpois[0]['usu_id']))."
											ORDER BY usu_id DESC");


										
		foreach($cadEpois2 as $numP){
	      $total += count($numP['usu_id']); 
	     }
	    //echo "<pre>"; print_r( $total ); die;
		
		return array("total"=>$total);
	}*/
	
	
	public function pessoasNaFrenteReceber(){
	 /* 
	  $cad = new TbCadastro;		  
	  $docs = $cad->getUsuRede5x5();
	  $doc = $docs['redeFilhos'][0]['usu_doc'];	  

	  $preenchendoLinha = $this->banco->executar("
	    WITH RECURSIVE familia (usu_id, usu_doc, fk_status, fk_usu_rede, nivel) AS
		(
		SELECT 
			u1.usu_id, u1.usu_doc, u1.fk_status, u1.fk_usu_rede, 1 AS nivel
		FROM tb_usuarios AS u1
		WHERE
			u1.usu_doc = '$doc' AND u1.fk_status = 2
		UNION ALL
		SELECT 
			u2.usu_id, u2.usu_doc, u2.fk_status, u2.fk_usu_rede, f.nivel + 1 AS nivel
		FROM tb_usuarios AS u2
		INNER JOIN familia AS f ON f.usu_doc = u2.fk_usu_rede
		WHERE u2.fk_status = 2
		)
		SELECT 
		f.usu_id, f.usu_doc, f.fk_status, f.fk_usu_rede, (SELECT count(usu_id) FROM public.tb_usuarios WHERE fk_usu_rede = f.usu_doc) as total
		FROM 
		familia as f
		WHERE (SELECT count(usu_id) FROM public.tb_usuarios WHERE fk_usu_rede = f.usu_doc) < 3
		ORDER BY nivel, f.usu_id ASC LIMIT 1");	    

	  foreach($preenchendoLinha as $numP){
	   $total += count($numP['usu_doc']); 
	  }
	  
	 //echo "<pre>"; print_r( $total ); die;
	  
	  return array("total"=>$total);
	  
	 */
	}
	
	public function campanha(){
	
	
	}
	
	
	public function login()
	{
		if($_POST != null)
		{
			$this->SetUsuEmail($_POST['usuario']);
			$this->SetUsuSenha($_POST['password']);
			$this->LoginUser();
		}
		
		return array(
				'template' => 'login'
		);

	}
	
	public function esqueceu()
	{
		$this->SetUsuEmail($_POST['email']);
		$this->SetUsuUsuario($_POST['usu_usuario']);
	
		$usu_usuario = $this->GetUsuUsuario();
	
		$verifica = $this->banco->ver('tb_usuarios','usu_usuario, usu_email', "usu_email = '{$this->GetUsuEmail()}' AND usu_usuario = '{$usu_usuario}'");

		if($verifica)
		{
			$rand = rand();
				
			$senha = $this->Password($rand);
				
			$this->banco->editar('tb_usuarios', array('usu_senha'=>$senha),"usu_usuario = '{$usu_usuario}'");
				
			$verifica['senha'] = $rand;
				
			$this->email = new Email;
				
			$msg = $this->email->msg_esqueceu_senha($verifica);
				
			$verifica['assunto'] = 'Esqueceu Senha '.$verifica['usu_usuario'];
			$verifica['msg'] = $msg;
				
			$this->email->enviar($verifica);
				
			echo json_encode(array(
					'usuario' => $verifica['usu_usuario'],
					'email' => $verifica['usu_email'],
					'retorno' => true
			));
				
		}else{
			echo json_encode(array(
					'retorno' => false
			));
		}
	
	
	
		/* return array(
		 'template' => 'ajax/esqueceu_senha'
		); */
	
	}
	
	public function confirmado()
	{
		
		$usuario = Controller::$parametros['usuario'];
		
		if($this->banco->ValidaRegistro('public.tb_usuarios','usu_id', "usu_usuario = '{$usuario}' AND fk_status = 1"))
		{
// 	echo '1';die;
	
		$this->banco->editar('public.tb_usuarios',array('fk_status' => 4),"usu_usuario = '{$usuario}'");
	
			return array(
					'template' => 'confirmado'
			);
		
		}elseif($this->banco->ValidaRegistro('public.tb_usuarios','usu_id', "usu_usuario = '{$usuario}' AND fk_status = 4"))
		{
			
			
			return array(
					'template' => 'confirmado'
			);
			
			
		}else{
		
// 			echo '2';die;
			return array(
					'template' => 'login'
			);
			
		}
	
	}
	
	
	public function UploadComprovante()
	{
		$cliente = Controller::$cliente;
		$ds          = DIRECTORY_SEPARATOR;  //1
	
		$usuario = Controller::$parametros['usuario'];
		$cod = $usuario.date('dmYHis');
	
		$arquivo = $this->Password($cod);
	
		$host = $_SERVER['HTTP_HOST'];
	
		$link_arquivo = "http://{$host}/module/{$cliente}/View/comprovantes/{$arquivo}.jpg";
	
		// 		echo $link_arquivo;die;
	
	
		$storeFolder = 'comprovantes';   //2
	
		if (!empty($_FILES)) {
	
			$tempFile = $_FILES['file']['tmp_name'];          //3
	
			$targetPath = "/var/www/mmn/public_html/module/".$cliente."/View/comprovantes/";  //4
			// 			echo $_SERVER['HTTP_HOST'];die;
			  //5
				
			$arquivo = $arquivo.'.jpg';
			
			$res = $this->banco->ver(
					"public.tb_usuarios u INNER JOIN public.tb_usuarios up ON u.usu_upline = up.usu_doc",
					'u.usu_doc, u.usu_upline, u.usu_usuario, up.usu_email, up.usu_nome, up.usu_usuario as upline',
					"u.usu_usuario = '{$usuario}'"
					);
			
			$verifica = $this->banco->executar("SELECT rpg_id, rpg_comprovante
				FROM tb_doacoes
				where rpg_doador = '{$res['usu_doc']}' AND rpg_recebedor = '{$res['usu_upline']}'
												AND fk_status = 1 ORDER BY rpg_id DESC limit 1");
			
			if(!empty($verifica))
			{
				$arquivo = $verifica[0]['rpg_comprovante'];
				
			}else{
				
				$dados = array(
						'rpg_obs' 			=>	'Primeira Doação para iniciar',
						'rpg_comprovante' 	=>	$arquivo,
						'rpg_doador'		=>	$res['usu_doc'],
						'rpg_recebedor'		=>	$res['usu_upline'],
						'rpg_nivel'			=>	'1'
				);
				$this->banco->inserir('public.tb_doacoes',$dados);
				
			}
				
			$targetFile =  $targetPath. $arquivo;
			
			if(move_uploaded_file($tempFile,$targetFile))
			{

				$this->email = new Email;
				$metodo = 'doacao_'.$cliente;
				$this->email->$metodo($res['usu_usuario'],$res['upline'],$link_arquivo,$res['usu_email']);
	
	
			}
			 
		}
	
		return true;
	}

	
	public function sair()
	{
		unset($_SESSION['usuario']);
		header('location:../Backoffice/login');
	}
	
	public function __call($metodo,$argumanto)
	{
		return 'erro';
	
	}
}