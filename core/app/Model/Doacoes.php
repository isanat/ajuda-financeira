<?php

  class Doacoes extends TbDoacoes {
    
	public $valorDoacao = '150';
	public $matrix5 = '3';

    public function realizar(){
    
		$realizar = $this->banco->executar("
				SELECT 
					u.usu_usuario,
					u.usu_doc,
					u.usu_email,
					p.ped_id,
					p.ped_total,
					p.fk_status,
					stp.status_nome,
					to_char(p.ped_data_expira, 'DD/MM/YYYY') as ped_data_expira,
					to_char(p.ped_data_pag, 'DD/MM/YYYY') as ped_data_pag,
					p.ped_nivel
				FROM 
					public.tb_usuarios as u,
					public.tb_pedidos  as p,
					public.tb_status_pedido  as stp
				WHERE
					p.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND
					p.fk_pai = u.usu_doc AND			
					stp.status_id = p.fk_status ORDER BY p.ped_id ASC LIMIT 3");	
	                
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

$newPedUsu = $this->banco->executar("
SELECT * FROM tb_pedidos WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."' and fk_status = 3 ORDER BY ped_id DESC LIMIT 1");
	
	$ativaUsu    = $this->validaAtivacaoUsu();
	$ped         = $this->getUsuPedidos($realizar);
    $banco       = $this->listBanco();
	$resultNivel = $this->getNivel();
    $statusCompro = $this->statusComprovante();
	 
  if(isset($_POST['acao']) == "comprovante"){

		$seg 		= explode('.', microtime(true));
		$foto	    = date('YmdHis').$seg[1].$_FILES["arquivo"]['name'];
      	$allowedExts = array("image/jpeg", "image/jpg", "image/png");


	if(in_array($_FILES["arquivo"]['type'], $allowedExts)){		
		
		
		$fk_pag_adm = $this->banco->executar("SELECT ped_id, fk_pag_adm FROM public.tb_pedidos WHERE ped_id = '".strip_tags(trim($_POST['id_ped']))."'");
		 
		$fk_pag = ($fk_pag_adm[0]['fk_pag_adm'] != NULL) ? $fk_pag_adm[0]['fk_pag_adm'] : NULL ;
		
		$allowedExts = array("jpeg", "jpg", "png");
		$temp = explode(".", strtolower($foto));
		$extension = end($temp); 
		$pasta = "/var/www/g3money/public_html/core/View/comprovantes/". strtolower($foto);
		
		if ((($_FILES["arquivo"]["type"] == "image/jpeg")
		|| ($_FILES["arquivo"]["type"] == "image/jpg")
		|| ($_FILES["arquivo"]["type"] == "image/png"))	
		&& in_array(strtolower($extension), $allowedExts)) {	
  	    
		$comp = $this->banco->executar("SELECT * FROM public.tb_comprovantes WHERE fk_ped = '".strip_tags(trim($_POST['id_ped']))."'");								   
		
		$ped_id = $this->banco->executar("SELECT fk_usu, fk_pai FROM public.tb_pedidos WHERE ped_id = '".strip_tags(trim($_POST['id_ped']))."'");

  if(empty($comp[0]['fk_ped'])){
	
	  $comprovantes = array(
		'compro_img'=> strtolower($foto),
		'fk_usu'=> $ped_id[0]['fk_usu'],
		'fk_pai'=> $_POST["comprovante"],
		'fk_ped'=> $_POST["id_ped"],
		'fk_pag_adm'=>$fk_pag
	  );
	  
	//echo "<pre>"; print_r($comprovantes); die;
	
	$this->banco->inserir('public.tb_comprovantes',$comprovantes);  
	
	move_uploaded_file($_FILES["arquivo"]["tmp_name"], $pasta );
   
   $usu = $this->banco->executar("SELECT usu_usuario,usu_email FROM public.tb_usuarios WHERE usu_doc = '".$_POST["comprovante"]."'");
      
   $usu_enviou = $this->banco->executar("SELECT usu_email,usu_usuario,usu_nome FROM public.tb_usuarios WHERE usu_doc = '".$_SESSION['usuario']['usu_doc']."'");
   // Quem está enviando o comprovante
   $nome_quem_enviou    = $usu_enviou[0]['usu_nome']; 
   $usuario_quem_enviou = $usu_enviou[0]['usu_usuario'];
   $email_quem_enviou   = $usu_enviou[0]['usu_email']; 

$html ="
<table width='100%' border='0' cellpadding='2'>
<tr>
<td width='100%'></td>
</tr>
<tr>
<td><h3><strong>ATENÇÃO! O um comprovante foi enviado para você.</strong></h3></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td><p><strong>IMPORTANTE: <br>
</strong><strong><br>
</strong>Você acaba de receber um comprovante de um participante(a), favor confirmar em seu <strong>escritório virtual </strong>para que essa pessoa possa<br>
receber doações e que possa cadastrar outras pessoas normalmente.
<br>
<br>
<strong>SEGUE ABAIXO AS INFORMAÇÕES DE CONTATO</strong><br>
<br>
<strong>Nome:</strong> $nome_quem_enviou<br>
<strong>Usuário:</strong> $usuario_quem_enviou<br>
<strong>E-mail:</strong> $email_quem_enviou
<p> </td>
</tr>
<tr>
<td><p><strong>Não deixe passar essa oportunidade de negocio para aumentar a renda e sem comprometer seu horário de Trabalho. </strong></p>
<p>Sempre que precisar, entre em contato conosco, estaremos ao seu dispor! </p>
<p>Atenciosamente,</p>
<p><strong>G3Money - Ajuda Mútua Financeira</strong><br>
<a target='_blank' href='http://g3money10.com.br'>http://g3money10.com.br</a> </p></td>
</tr>
</table>";

		$enviar = array(			
		    "usu_usuario"=> $usu[0]['usu_usuario'],
			"usu_email"=> $usu[0]['usu_email'],
			"assunto"=>"G3Money - Comprovante Enviado!‏",
			"msg" => $html  
		); 		
		   
		$email = new Email;
		//$email->enviar($enviar);

		}else{

		  $pasta = "/var/www/g3money/public_html/core/View/comprovantes/". strtolower($comp[0]['compro_img']);
		  unlink($pasta);
		  
		  $arquivo = "/var/www/g3money/public_html/core/View/comprovantes/". strtolower($foto);
		  
		   $comprovantes = array(
			  	'compro_img'=> strtolower($foto),
			  	'compro_data_envio'=> "NOW()",
				'fk_status_compro'=> 1
			  );
			  			 
			$this->banco->editar('public.tb_comprovantes',$comprovantes, " compro_id = '".strip_tags(trim($_POST['id_compro']))."'");  
			
			
			$usu = $this->banco->executar("SELECT usu_usuario,usu_email FROM public.tb_usuarios WHERE usu_doc = '".$_POST["comprovante"]."'");
      
   $usu_enviou = $this->banco->executar("SELECT usu_email,usu_usuario,usu_nome FROM public.tb_usuarios WHERE usu_doc = '".$_SESSION['usuario']['usu_doc']."'");
   // Quem está enviando o comprovante
   $nome_quem_enviou    = $usu_enviou[0]['usu_nome']; 
   $usuario_quem_enviou = $usu_enviou[0]['usu_usuario'];
   $email_quem_enviou   = $usu_enviou[0]['usu_email']; 

$html ="
<table width='100%' border='0' cellpadding='2'>
<tr>
<td width='100%'></td>
</tr>
<tr>
<td><h3><strong>ATENÇÃO! O um comprovante foi enviado para você.</strong></h3></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td><p><strong>IMPORTANTE: <br>
</strong><strong><br>
</strong>Você acaba de receber um comprovante de um participante(a), favor confirmar em seu <strong>escritório virtual </strong>para que essa pessoa possa<br>
receber doações e que possa cadastrar outras pessoas normalmente.
<br>
<br>
<strong>SEGUE ABAIXO AS INFORMAÇÕES DE CONTATO</strong><br>
<br>
<strong>Nome:</strong> $nome_quem_enviou<br>
<strong>Usuário:</strong> $usuario_quem_enviou<br>
<strong>E-mail:</strong> $email_quem_enviou
<p> </td>
</tr>
<tr>
<td><p><strong>Não deixe passar essa oportunidade de negocio para aumentar a renda e sem comprometer seu horário de Trabalho. </strong></p>
<p>Sempre que precisar, entre em contato conosco, estaremos ao seu dispor! </p>
<p>Atenciosamente,</p>
<p><strong>G3Money - Ajuda Mútua Financeira</strong><br>
<a target='_blank' href='http://g3money10.com.br'>http://g3money10.com.br</a> </p></td>
</tr>
</table>";

		$enviar = array(			
		    "usu_usuario"=> $usu[0]['usu_usuario'],
			"usu_email"=> $usu[0]['usu_email'],
			"assunto"=>"G3Money - Comprovante Enviado!‏",
			"msg" => $html  
		); 		
		   
		$email = new Email;
		//$email->enviar($enviar);			
			
			move_uploaded_file($_FILES["arquivo"]["tmp_name"], $arquivo );
		    
		}

				$realizar2 = $this->banco->executar("
						SELECT 
							u.usu_usuario,
							u.usu_doc,
							u.usu_email,
							p.ped_id,
							p.ped_total,
							p.fk_status,
							to_char(p.ped_data_expira, 'DD/MM/YYYY') as ped_data_expira,
							to_char(p.ped_data_pag, 'DD/MM/YYYY') as ped_data_pag,
							stp.status_nome,
							p.ped_nivel
						FROM 
							public.tb_usuarios as u,
							public.tb_pedidos  as p,
							public.tb_status_pedido  as stp
						WHERE
							p.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND
							p.fk_pai = u.usu_doc AND
							stp.status_id = p.fk_status ORDER BY p.ped_id ASC LIMIT 3");
							
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

			return array("retorno"=>"ok", 
			"resultDoa"=>$this->validaDoacoesUsu(),
			"res"=>$realizar2, 
			"statusCompro"=>$statusCompro,
			"newPedUsu"=>$newPedUsu, 
			"ativaUsu"=>$ativaUsu, 
			"ped"=>$ped, 
			"usuNivel"=>$resultNivel,
			"inativo"=>$inativo);
				
		}else{
		  
		  $realizar2 = $this->banco->executar("
				SELECT 
					u.usu_usuario,
					u.usu_doc,
					u.usu_email,
					p.ped_id,
					p.ped_total,
					to_char(p.ped_data_expira, 'DD/MM/YYYY') as ped_data_expira,
					to_char(p.ped_data_pag, 'DD/MM/YYYY') as ped_data_pag,
					p.fk_status,
					stp.status_nome,
					p.ped_nivel
				FROM 
					public.tb_usuarios as u,
					public.tb_pedidos  as p,
					public.tb_status_pedido  as stp
				WHERE
					p.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND
					p.fk_pai = u.usu_doc AND
					stp.status_id = p.fk_status ORDER BY p.ped_id ASC LIMIT 3");
					
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
						

		  return array("img"=>"no",
		  "res"=>$realizar2,
		  "resultDoa"=>$this->validaDoacoesUsu(), 
		  "statusCompro"=>$statusCompro,
		  "newPedUsu"=>$newPedUsu, 
		  "ativaUsu"=>$ativaUsu, 
		  "ped"=>$ped,
		  "usuNivel"=>$resultNivel,
		  "inativo"=>$inativo);		
		}
		
		}else{ 
		 $realizar2 = $this->banco->executar("
				SELECT 
					u.usu_usuario,
					u.usu_doc,
					u.usu_email,
					p.ped_id,
					p.ped_total,
					to_char(p.ped_data_expira, 'DD/MM/YYYY') as ped_data_expira,
					to_char(p.ped_data_pag, 'DD/MM/YYYY') as ped_data_pag,
					p.fk_status,
					stp.status_nome,
					p.ped_nivel
				FROM 
					public.tb_usuarios as u,
					public.tb_pedidos  as p,
					public.tb_status_pedido  as stp
				WHERE
					p.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND
					p.fk_pai = u.usu_doc AND
					stp.status_id = p.fk_status ORDER BY p.ped_id ASC LIMIT 3");
					
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
		   
		   return array(
		    "formato"=>"no",
			"res"=>$realizar2,
			"statusCompro"=>$statusCompro,
			"resultDoa"=>$this->validaDoacoesUsu(), 
			"newPedUsu"=>$newPedUsu, 
			"ativaUsu"=>$ativaUsu, 
			"ped"=>$ped,
			"usuNivel"=>$resultNivel,
			"inativo"=>$inativo);	
		
		}
		
    }

     return array("res"=>$realizar, 
	 "ativaUsu"=>$ativaUsu, 
	 "newPedUsu"=>$newPedUsu, 
	 "statusCompro"=>$statusCompro,
	 "ped"=>$ped,
	 "resultDoa"=>$this->validaDoacoesUsu(),
	 "usuNivel"=>$resultNivel,
	 "inativo"=>$inativo);
		
}
    
	public function statusComprovante(){
	  
	 $status = $this->banco->executar("		
			SELECT 
				co.compro_id,
				co.fk_usu,
				co.fk_status_compro,
				scomp.status_compro_nome,
				usu.usu_usuario,
				usu.usu_email,
				ped.ped_total,
				to_char(co.compro_data_envio, 'DD/MM/YYYY') as compro_data_envio
			FROM
				public.tb_comprovantes as co,
				public.tb_status_compro as scomp,
				public.tb_usuarios as usu,
				public.tb_pedidos as ped
			WHERE	
				co.fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND
				ped.ped_id = co.fk_ped AND
				usu.usu_doc = co.fk_pai AND
				co.fk_status_compro = scomp.status_compro_id
			ORDER BY compro_id DESC");
	 
	 return $status;
			
	}

	public function getUsuPedidos( $doc = NULL ){
	 
	  if( $doc != NULL ){
		  
		$subirNivel =  $this->getUsuMaiorQue5();
		
		$numUsu = 0;
		foreach($subirNivel['qtdFilhos'] as $qtdFilhos){
		   	$numUsu += $qtdFilhos['total'];
		}

		   $pedTotal = $this->banco->executar("
							SELECT 
								pe.ped_id, pe.ped_total, pe.fk_status, pe.ped_nivel, pe.fk_pai, pe.fk_usu, stp.status_nome
							FROM 
								public.tb_pedidos pe,
								public.tb_status_pedido stp
							WHERE
								pe.fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND
								stp.status_id = pe.fk_status AND
								pe.fk_status = 1
							");	

		  return array( "result"=>$pedTotal );
		  
	  }
	  		
	}
	
	public function getUsuMaiorQue5(){	   
	   $usu = $this->banco->executar("
				WITH RECURSIVE familia (usu_id, usu_doc, fk_usu_rede, nivel) AS
				(
				SELECT 
						u1.usu_id, u1.usu_doc, u1.fk_usu_rede, 1 AS nivel
				FROM tb_usuarios AS u1
				WHERE
						u1.usu_doc = '".$_SESSION['usuario']['usu_doc']."'
				UNION ALL
				SELECT 
						u2.usu_id, u2.usu_doc, u2.fk_usu_rede, f.nivel + 1 AS nivel
				FROM tb_usuarios AS u2
				INNER JOIN familia AS f ON f.usu_doc = u2.fk_usu_rede
				)
				SELECT 
				f.usu_id, f.usu_doc, f.fk_usu_rede, (SELECT count(usu_id) FROM public.tb_usuarios WHERE fk_usu_rede = f.usu_doc) as total
				FROM 
				familia as f
				WHERE (SELECT count(usu_id) FROM public.tb_usuarios WHERE fk_usu_rede = f.usu_doc) < 3
				ORDER BY nivel, f.usu_id ASC");	   
				
	   return array("qtdFilhos"=>$usu);	   
	}
	
	
   
    public function listBanco(){
     
	 if(isset($_POST['acao']) == "list"){      
	  $doc = strip_tags(trim($_POST['id']));
 
	  $banco = $this->banco->executar("
					SELECT DISTINCT
						b.cod_nome,
						db.banco_agencia,
						db.banco_agencia_digito,
						db.banco_conta,
						db.banco_digito_conta,
						db.banco_op,
						db.banco_favorecido,
						db.banco_tipo
					FROM 
						public.tb_dados_banco db,
						public.tb_banco b
					WHERE 
						db.fk_usu = '$doc' AND 
						b.cod_code = db.banco_code");
		
         if(!empty($banco[0]['cod_nome'])){			 
		   return array("template"=>"ajax/banco_ajax", "retorno"=>"sim", "banco"=>$banco, "bancoOnline"=>$banco);		 
		 }else{
		   return array("template"=>"ajax/banco_ajax", "retorno"=>"nao", "banco"=>$banco, "bancoOnline"=>$banco);		  
		} 
  
	 }
	  
	  $banco = $this->banco->executar("
					SELECT 
						b.cod_nome,
						db.banco_agencia,
						db.banco_agencia_digito,
						db.banco_conta,
						db.banco_digito_conta,
						db.banco_op,
						db.banco_favorecido,
						db.banco_tipo,
						db.banco_op
					FROM 
						public.tb_dados_banco db,
						public.tb_banco b
					WHERE 
						db.fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND 
						b.cod_code = db.banco_code");

	  return array("template"=>"ajax/banco_ajax", "bancoOnline"=>$banco);

	}
	
	
	public function validacaoContaBancaria(){
	 
	 if(isset($_POST['acao']) == "list"){      
		  $doc = strip_tags(trim($_POST['fk_pai']));
	
		  $banco = $this->banco->executar("
						SELECT DISTINCT
							b.cod_nome,
							db.banco_agencia,
							db.banco_agencia_digito,
							db.banco_conta,
							db.banco_digito_conta,
							db.banco_op,
							db.banco_favorecido,
							db.banco_tipo
						FROM 
							public.tb_dados_banco db,
							public.tb_banco b
						WHERE 
							db.fk_usu = '$doc' AND 
							b.cod_code = db.banco_code");
							
	 	 
			 if(!empty($banco[0]['cod_nome'])){			 
			   return array("template"=>"null", "retorno"=>"sim");		 
			 }else{	  
			   return array("template"=>"null", "retorno"=>"nao");		  
			} 
	  
		 }	
	
	}
	
    
	 public function recebidas_home(){	  
	     
		 $query = $this->banco->executar("
			SELECT 
			    usu.usu_id,
			    usu.usu_nome,
				usu.usu_usuario,
				usu.usu_doc,
				pe.ped_id,
				pe.ped_total,
				pe.ped_nivel,
				pe.fk_status,
				comp.compro_id,
				comp.compro_img,
				to_char(comp.compro_data_envio,'DD/MM/YYYY') as compro_data_envio,
				to_char(pe.ord_date,'DD/MM/YYYY') as ord_date,
				to_char(pe.ped_data_expira,'DD/MM/YYYY') as ped_data_expira,
				comp.fk_ped,
                stp.status_compro_nome,
				comp.fk_status_compro,
				comp.fk_pag_adm
			FROM 
				public.tb_pedidos pe,
				public.tb_usuarios usu,
				public.tb_comprovantes comp,
				public.tb_status_compro stp
			WHERE 
				pe.fk_pai = '".$_SESSION['usuario']['usu_doc']."' AND
				usu.usu_doc = pe.fk_usu AND
				pe.ped_id = comp.fk_ped AND
				comp.fk_usu = usu.usu_doc AND
				pe.fk_status = 3 AND
				comp.fk_pai = '".$_SESSION['usuario']['usu_doc']."' AND				
                stp.status_compro_id = comp.fk_status_compro AND
				comp.fk_pag_adm is null
			");
	  
	  $retorno['rece'] = $query;
      return $retorno;
	
	  
	}	
	 
    public function recebidas(){
	 
	}

	
	public function recebidas_ajax(){
		
		 $filtros = array();
	
		$filtros['limit'] = $_REQUEST['regpag'];
	
		if( $_REQUEST['pagina'] > 1 ) {
			$filtros['offset'] = ( ( $_REQUEST['pagina'] * $_REQUEST['regpag'] ) - $_REQUEST['regpag'] );
		} else {
			$filtros['offset'] = 0;
		}
	
		if( !empty( $_REQUEST['busca'] ) ) {
			$filtros['busca'] = $_REQUEST['busca'];
		} else {
			$filtros['busca'] = "";
		}
	
		$filtros['pagina'] = $_REQUEST['pagina'];
		
		$queryPag = "
			SELECT 
			    count(*) as total
			FROM 
				public.tb_pedidos pe,
				public.tb_usuarios usu,
				public.tb_comprovantes comp,
				public.tb_status_compro stp
			";
	   	
		$query = "
			SELECT 
			    usu.usu_id,
			    usu.usu_nome,
				usu.usu_usuario,
				usu.usu_doc,
				pe.ped_id,
				pe.ped_total,
				pe.ped_nivel,
				pe.fk_status,
				comp.compro_id,
				comp.compro_img,
				to_char(comp.compro_data_envio,'DD/MM/YYYY') as compro_data_envio,
				to_char(pe.ord_date,'DD/MM/YYYY') as ord_date,
				to_char(pe.ped_data_expira,'DD/MM/YYYY') as ped_data_expira,
				comp.fk_ped,
                stp.status_compro_nome,
				comp.fk_status_compro,
				comp.fk_pag_adm
			FROM 
				public.tb_pedidos pe,
				public.tb_usuarios usu,
				public.tb_comprovantes comp,
				public.tb_status_compro stp
			";
			
	 if( !empty( $filtros['busca'] ) ) {

		$queryBusca = "
				WHERE 
					pe.fk_pai = '".$_SESSION['usuario']['usu_doc']."' AND
					usu.usu_doc = pe.fk_usu AND
					pe.ped_id = comp.fk_ped AND
					comp.fk_usu = usu.usu_doc AND
					comp.fk_pai = '".$_SESSION['usuario']['usu_doc']."' AND				
					stp.status_compro_id = comp.fk_status_compro AND
					comp.fk_pag_adm is null AND
							( ( usu.usu_usuario LIKE '%".$filtros['busca']."%' ) OR
							( to_char(comp.compro_data_envio,'DD/MM/YYYY')::text LIKE '%".$filtros['busca']."%' ) OR
							( pe.ped_total::text LIKE '%".$filtros['busca']."%' ) OR
							( stp.status_compro_nome LIKE '%".$filtros['busca']."%' )) ";
		
		$queryBuscaPag = "
				WHERE 
					pe.fk_pai = '".$_SESSION['usuario']['usu_doc']."' AND
					usu.usu_doc = pe.fk_usu AND
					pe.ped_id = comp.fk_ped AND
					comp.fk_usu = usu.usu_doc AND
					comp.fk_pai = '".$_SESSION['usuario']['usu_doc']."' AND				
					stp.status_compro_id = comp.fk_status_compro AND
					comp.fk_pag_adm is null AND
							( ( usu.usu_usuario LIKE '%".$filtros['busca']."%' ) OR
							( to_char(pe.ped_data_pag,'DD/MM/YYYY')::text LIKE '%".$filtros['busca']."%' ) OR
							( pe.ped_total::text LIKE '%".$filtros['busca']."%' ) OR
							( usu.usu_email LIKE '%".$filtros['busca']."%' )) ";
	   
	   $queryPag .= $queryBuscaPag;
	   
	   $queryPag .= " GROUP BY comp.compro_id ORDER BY comp.compro_id DESC ";
	   $queryPag .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
		
							
	 }else{
	      $queryBusca = "
			WHERE 
				pe.fk_pai = '".$_SESSION['usuario']['usu_doc']."' AND
				usu.usu_doc = pe.fk_usu AND
				pe.ped_id = comp.fk_ped AND
				comp.fk_usu = usu.usu_doc AND
				comp.fk_pai = '".$_SESSION['usuario']['usu_doc']."' AND				
                stp.status_compro_id = comp.fk_status_compro AND
				comp.fk_pag_adm is null
			";
			
		$queryBuscaPag = "
				WHERE 
					pe.fk_pai = '".$_SESSION['usuario']['usu_doc']."' AND
					usu.usu_doc = pe.fk_usu AND
					pe.ped_id = comp.fk_ped AND
					comp.fk_usu = usu.usu_doc AND
					comp.fk_pai = '".$_SESSION['usuario']['usu_doc']."' AND				
					stp.status_compro_id = comp.fk_status_compro AND
					comp.fk_pag_adm is null";
	   
	   $queryPag .= $queryBuscaPag;
	 
	 }
      
	  
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
						usu.fk_status = 1");	
		
				
		
		
		$retornoPag = $this->SearchPaginacaoRecebidas( $queryPag, $filtros['pagina'], $filtros['limit'] );
		$query .= $queryBusca;	
		
		$query .= "ORDER BY comp.compro_id DESC ";
		$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];		
		
		//echo "<pre>"; print_r($query); die;		
		
		$ver = $this->banco->executar($query);		
		
		$retorno['rece'] = $ver;
		$retorno['inativo'] = $inativo;
		$retorno['template'] = "ajax/recebidas_ajax";
		$retorno['paginacao'] = $retornoPag;
		
		return $retorno;
	
	}
	
	public function SearchPaginacaoRecebidas($sql, $pagina, $regpag ) {
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		$totalRegistros = $res[0]['total'];
		if( $totalRegistros > 0 ) {
			$totalPaginas = ceil( $totalRegistros / $regpag );
			$totalPagina = ( $pagina * $regpag );
			$totalPagina = ( $totalPagina < $totalRegistros ) ? $totalPagina : $totalRegistros;

			if( $pagina > 1 ) {
				$offset = ( ( $pagina * $regpag ) - $regpag );
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
				  <div class="dataTables_paginate paging_full_numbers" id="example_paginate">
					<div class="span6">       		
					  ';
							//botao botao anterior
							$html .= ( $pagina > 1 ) ? '<a tabindex="0" class="previous paginate_button" href="javascript:void(paginacao_recebidas(\''.( $pagina - 1 ).'\'));">← Anterior</a>' : '<a class="paginate_button_disabled" href="#">← Anterior</a>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<a tabindex="0" class="paginate_button" href="javascript:void(paginacao_recebidas(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a>' : '<a href="#">&nbsp;</a>';
							$html .= '<a tabindex="0" class="paginate_active" href="#">'.$pagina.'</a>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<a tabindex="0" class="paginate_button" href="javascript:void(paginacao_recebidas(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a>' : '<a href="#">&nbsp;</a>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<a tabindex="0" class="next paginate_button" href="javascript:void(paginacao_recebidas(\''.( $pagina + 1 ).'\'));">Próxima → </a>' : '<a href="#">Próxima → </a>';
							$html .= '					
					 </div>
			       </div>	
				</div>';

		return $html;
	}
	
	public function resUltimoBase(){
	
			$query = $this->banco->executar("
					WITH RECURSIVE familia (usu_id, usu_doc, fk_status, fk_usu_rede, nivel) AS
					(
					SELECT 
							u1.usu_id, u1.usu_doc, u1.fk_status, u1.fk_usu_rede, 1 AS nivel
					FROM tb_usuarios AS u1
					WHERE
							u1.usu_doc = '00000000001' AND u1.fk_status = 2
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
					ORDER BY f.usu_id DESC LIMIT 1");
			
				return array( "base"=>$query );

	}
	
	public function resUltimoBaseGerarPedido($doc = NULL){
	   if($doc != NULL){
			$base = $this->banco->executar("
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
				WHERE f.nivel <= 3
			)
			SELECT 
				*
			FROM 
				familia 
	        ORDER BY usu_id DESC LIMIT 3");
			
				return array( "basePed"=>$base );
	   }
	}
  
   
	
	
	public function ConfirmarDoacao(){

	if(isset($_POST['acao']) == 'confirmarPag'){
	    session_regenerate_id(); 	
		
	    // Mostra o pedido 	   
	    $ped = $this->banco->executar("		   
		SELECT 
			ped.ped_id, ped.ped_total, ped.ped_nivel, ped.fk_status, 
			to_char(ped.ped_data_expira,'DD/MM/YYYY') as ped_data_expira, 
			ped.fk_pai, ped.fk_usu,usu_doc, usu.usu_usuario, usu.fk_status, usu.usu_email, 
			usu.fk_usu_rede, ped.ped_qtd_downlines, ped_fase
		FROM 
			public.tb_pedidos as ped,
			public.tb_usuarios as usu
		WHERE  
			ped.ped_id = '".strip_tags(trim($_POST['idPed']))."' AND
			ped.fk_status = 1  AND
			ped.fk_usu = usu.usu_doc");  

	    $xUsu = $this->banco->executar("SELECT * FROM tb_usuarios WHERE  usu_id = '".$_POST['idUsu']."'");

		if($ped[0]['fk_status'] != 2){		
		  $usuarios = array( 'fk_status'=>2 );	
		 $this->banco->editar("public.tb_usuarios", $usuarios, " usu_doc = '".strip_tags(trim($ped[0]['usu_doc']))."'");
		}
		
		//Da baixa no pedido
		 $pedidos = array('fk_status'=>3,'ped_data_pag'=>"NOW()",'ped_valor_pago'=>$ped[0]['ped_total']);	
			  	
		 $this->banco->editar("public.tb_pedidos", $pedidos, " ped_id = '".strip_tags(trim($ped[0]['ped_id']))."'");
		
	     // Da baixa no comprovante
		 $comprovante = array('fk_status_compro'=>2,'compro_data_pag'=>"NOW()");				
	
		 $this->banco->editar("public.tb_comprovantes", $comprovante, " compro_id = '".$_POST['idCompro']."'");

//Lista o novo pedido a ser pago
$newPedUsu = $this->banco->executar("SELECT * FROM tb_pedidos WHERE fk_usu = '".strip_tags(trim($ped[0]['usu_doc']))."'
ORDER BY ped_id DESC LIMIT 1");

//Lista o ultimo pedido pago
$ultPedUsu = $this->banco->executar("SELECT * FROM tb_pedidos WHERE fk_usu = '".strip_tags(trim($ped[0]['usu_doc']))."' AND 
fk_status = 3 ORDER BY ped_id DESC LIMIT 1");

//$usuar = $this->banco->executar("SELECT usu_doc FROM public.tb_usuarios WHERE usu_doc = '".strip_tags(trim($ped[0]['usu_doc']))."'");
$voltarBase = $this->qtdDoacoesNivel($ped[0]['fk_pai']);

$doc = strip_tags(trim($ped[0]['usu_doc']));

$fases = $voltarBase['qtdDoacoes'][0]['ped_fase'];

if($voltarBase['qtdDoacoes'][0]['total'] == 27){

	// Lista o Usuário da base
	$usuBase = $this->resUltimoBase();

	// Cadastrar o usuário novamente mais na base
	$this->insercaoReentradaUsuario($ped[0]['fk_pai'], $usuBase['base'][0]['usu_doc']);
		
	session_regenerate_id();
	
	return array("template"=>"null","retorno"=>"ree");  
  
}else{

// Mostra o pedido 	   
$pedi = $this->banco->executar("		   
SELECT 
	ped.ped_id, ped.ped_total, ped.ped_nivel, ped.fk_status, 
	to_char(ped.ped_data_expira,'DD/MM/YYYY') as ped_data_expira, 
	ped.fk_pai, ped.fk_usu, usu.usu_usuario, usu.usu_email, 
	usu.fk_usu_rede, ped.ped_qtd_downlines, ped_fase
FROM 
	public.tb_pedidos as ped,
	public.tb_usuarios as usu
WHERE  
	ped.ped_id = '".strip_tags(trim($_POST['idPed']))."' AND
	ped.fk_status = 3  AND
	ped.fk_usu = usu.usu_doc ORDER BY ped.ped_id DESC"); 	

// Gerar pedido
$newUsu = new TbUsuarios;
$ip = Controller::$ip;
$browser = Controller::$browser;

if($pedi[0]['ped_total'] == 150){
  $valor = 250;	
  $docUsu = $xUsu[0]['usu_doc'];  
  $pe = $this->banco->executar("SELECT ped_total FROM public.tb_pedidos WHERE fk_usu = '$docUsu' AND ped_total = 250");  
 
    if($pe[0]['ped_total'] != 250){
   		 
		 $criaPedidos = array(
			   "fk_usu"=>$pedi[0]['fk_usu'],
			   "ped_total"=>$valor,
			   "ped_sessao"=>session_id(),
			   "ped_ip"=>$ip,
			   "ped_browser"=>$browser,
			   "ped_data_expira"=>NULL,
			   "fk_pai"=>$pedi[0]['fk_pai'],
			   "ped_nivel"=>($pedi[0]['ped_nivel'] + 1),
			   "ped_qtd_downlines"=>9,
			   "ped_fase"=>$pedi[0]['ped_fase']
			 ); 	 
	 
	$this->banco->inserir("public.tb_pedidos", $criaPedidos);		 
	$usu = $this->banco->executar("SELECT fk_pai FROM public.tb_comprovantes WHERE compro_id = '".strip_tags(trim($_POST['idCompro']))."'");
    $this->validaQtdDoacoesRecebidas($pedi[0]['fk_pai']);
	
    session_regenerate_id();
    return array("template"=>"null","retorno"=>"ok");
}

	$this->validaQtdDoacoesRecebidas($pedi[0]['fk_pai']);
	session_regenerate_id();
    return array("template"=>"null","retorno"=>"ok");

  }
	
if($pedi[0]['ped_total'] == 250){
	
 $valor = 1000;
 $docUsu = $xUsu[0]['usu_doc'];  
 $pe = $this->banco->executar("SELECT ped_total FROM public.tb_pedidos WHERE fk_usu = '$docUsu' AND ped_total = 1000");		 
 
 if($pe[0]['ped_total'] != 1000){
 	
 $criaPedidos = array(
	   "fk_usu"=>$pedi[0]['fk_usu'],
	   "ped_total"=>$valor,
	   "ped_sessao"=>session_id(),
	   "ped_ip"=>$ip,
	   "ped_browser"=>$browser,
	   "ped_data_expira"=>NULL,
	   "fk_pai"=>$pedi[0]['fk_pai'],
	   "ped_nivel"=>($pedi[0]['ped_nivel'] + 1),
	   "ped_qtd_downlines"=>27,
	   "ped_fase"=>$pedi[0]['ped_fase']
	 ); 	 
		 			 
	   $this->banco->inserir("public.tb_pedidos", $criaPedidos);		 
	   $usu = $this->banco->executar("SELECT fk_pai FROM public.tb_comprovantes WHERE compro_id = '".strip_tags(trim($_POST['idCompro']))."'");
       $this->validaQtdDoacoesRecebidas($pedi[0]['fk_pai']);
	   
	   session_regenerate_id();
	   return array("template"=>"null","retorno"=>"ok");	
       
      }	 
      $this->validaQtdDoacoesRecebidas($pedi[0]['fk_pai']);
      session_regenerate_id();
      return array("template"=>"null","retorno"=>"ok");

   }
   
  if($pedi[0]['ped_total'] == 1000){
	  $this->validaQtdDoacoesRecebidas($pedi[0]['fk_pai']);
	  session_regenerate_id();
      return array("template"=>"null","retorno"=>"ok");  
  } 
  
  } 
   
 }
 
}

   public function insercaoReentradaUsuario($docUsu = NULL, $usuBase = NULL){
	 
	 if( isset($docUsu) != NULL && isset($usuBase) != NULL ){

	 $modifUsu = $this->banco->executar("SELECT usu_usuario, usu_doc FROM tb_usuarios WHERE usu_doc = '".$docUsu."'");	 
 
	  
	 //Edita o usuario e o doc 
	 $this->banco->editar("public.tb_usuarios", array('usu_usuario'=>$modifUsu[0]['usu_usuario']."_x")," usu_doc = '".$docUsu."'");  
	 
	 $listUsu = $this->banco->executar("SELECT * FROM tb_usuarios WHERE usu_doc = '".$docUsu."'");	
	 
	 $newDoc = $this->geradorCpf();
	 $newUsu = explode( "_", $listUsu[0]['usu_usuario'] );  	   

	  $usuario = array(
		"usu_nome"=>$listUsu[0]['usu_nome'],
		"usu_usuario"=>$newUsu[0],
		"usu_senha"=>$listUsu[0]['usu_senha'],
		"fk_status"=>1,
		"usu_datanasc"=>$listUsu[0]['usu_datanasc'],
		"usu_doc"=>$newDoc,
		"usu_data"=>$listUsu[0]['usu_data'],
		"fk_usu"=>$listUsu[0]['fk_usu'],
		"usu_sexo"=>$listUsu[0]['usu_sexo'],
		"fk_usu_rede"=>$usuBase,
		"fk_bonus"=>1,		   
		"usu_email"=>$listUsu[0]['usu_email'],
		"fk_carreira"=>1
	); 

   $seqId = $this->banco->inserir("public.tb_usuarios", $usuario, "tb_usuarios_usu_id_seq");


   $this->banco->editar("public.tb_usuarios", array('master_reentrada'=>$newDoc[0]), " master_reentrada = '".$listUsu[0]['usu_doc']."'");  

   $celu = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$listUsu[0]['usu_doc']."' AND fk_tipo = 3");	
	
   $cel = $celu[0]['fone_fone'];
   $cel = ($cel != "") ? $cel : NULL ;
	  if($cel != ""){					
		 $celular = array(
		   "fone_fone" => $cel,
		   "fk_usu"=>$newDoc,
		   "fk_tipo"=>3
		 );
				
		$this->banco->inserir("public.tb_fone", $celular);
	}
			  
$wha = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$listUsu[0]['usu_doc']."' AND fk_tipo = 4");
			  
		$w = $wha[0]['fone_fone'];
		$w = ($w != "") ? $w : NULL ;	
		  
		if($w != ""){
			$whatsapp = array(
			   "fone_fone"=>$w,
			   "fk_usu"=>$newDoc,
			   "fk_tipo"=>4
			 );

	$this->banco->inserir("public.tb_fone", $whatsapp);
		}

$listFones = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$listUsu[0]['usu_doc']."' AND fk_tipo = 1");
				
		$f = $listFones[0]['fone_fone'];
			 
		$f = ($f != "") ? $f : NULL;
			if($f != ""){		 
				 $fixo = array(
				   "fone_fone"=>$f,
				   "fk_usu"=>$newDoc,
				   "fk_tipo"=>1
				 );
			 
	$this->banco->inserir("public.tb_fone", $fixo);
			}

	

    $comer = $this->banco->executar("SELECT fone_fone FROM tb_fone WHERE fk_usu = '".$listUsu[0]['usu_doc']."' AND fk_tipo = 2");

			$c = $comer[0]['fone_fone'];
			$c = ($c != "") ? $c : NULL ;	
			  
			if($c != ""){
				$comercial = array(
				   "fone_fone"=>$c,
				   "fk_usu"=>$newDoc,
				   "fk_tipo"=>2
				 );

		$this->banco->inserir("public.tb_fone", $comercial);
		}
			
       $listEnd = $this->banco->executar("SELECT * FROM tb_endereco WHERE fk_usu = '".$listUsu[0]['usu_doc']."'");
				 
				 $endereco = array(
				   "end_cep"=>$listEnd[0]['end_cep'],
				   "end_end"=>$listEnd[0]['end_end'],
				   "end_n"=>$listEnd[0]['end_n'],
				   "end_bairro"=>$listEnd[0]['end_bairro'],
				   "end_cidade"=>$listEnd[0]['end_cidade'],
				   "end_uf"=>$listEnd[0]['end_uf'],
				   "fk_usu"=>$newDoc
				 );  
			
	$this->banco->inserir("public.tb_endereco", $endereco);


$ip = Controller::$ip;
$browser = Controller::$browser;	 
$cad = new Cadastro;

$documento = $this->banco->executar("SELECT usu_doc FROM public.tb_usuarios WHERE usu_id = '$seqId'"); 
$AcimaNivel = $cad->getNiveisAcima($documento[0]['usu_doc']);	 
	 
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
	   "fk_usu"=>$newDoc,
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
	  session_regenerate_id();
	}  

$novoCadastro = $this->banco->executar("SELECT usu_nome, usu_doc, usu_usuario, usu_email FROM public.tb_usuarios WHERE usu_id = '$seqId'");

$html = "
<table width='100%' border='0' cellpadding='2'>
  <tr>
    <td colspan='2'></td>
  </tr>
  <tr>
    <td colspan='2' align='center'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'><h3>Parabéns! </h3></td>
  </tr>
  <tr>
    <td colspan='2'><p><strong>Não deixe passar essa oportunidade de negocio para aumentar a renda e sem comprometer seu horário de Trabalho. </strong></p></td>
  </tr>
  <tr>
    <td width='19%'>&nbsp;</td>
    <td width='81%'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'>Olá, <strong>".$novoCadastro[0]['usu_usuario']."</strong> </td>
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
    <td><a href='http://g3money10.com.br/".$novoCadastro[0]['usu_usuario']."' target='_blank'>http://g3money10.com.br/".$_POST['usuario']."</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'>Suas credencias de acesso continuam sendo a mesma do usuário: ".$novoCadastro[0]['usu_usuario']."</td>
  </tr>
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'>
<strong>Após 24 horas sem pagar o sistema deletará o seu cadastro e você perderá a sua posição.</strong></td>
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
	
$dados = array(
	"usu_usuario"=>$novoCadastro[0]['usu_usuario'],
	"usu_email"=>$novoCadastro[0]['usu_email'],
	"assunto"=>"PARABÉNS! Você deu o primeiro passo para o seu sucesso financeiro‏"	 ,
	"msg" => $html  
); 
   
$email = new Email;
$mail = $email->enviar($dados); // Envia o e-mail com boas vindas	   

$base = $this->banco->executar("SELECT usu_nome,usu_doc,usu_email FROM public.tb_usuarios WHERE usu_doc = '$usuBase'");


$nome2 = $novoCadastro[0]['usu_nome'];
$usuario2 = $novoCadastro[0]['usu_usuario'];
$email2 = $novoCadastro[0]['usu_email'];
		
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
		    "usu_usuario"=> $base[0]['usu_usuario'],
			"usu_email"=> $base[0]['usu_email'],			
			"assunto"=>"PARABÉNS - UMA PESSOA ACABA DE SE CADASTRAR ABAIXO DE VOCÊ.‏"	 ,
			"msg" => $htmlCad  
		); 		

		$enviarEmail = new Email;
		$enviarEmail->enviar($enviar);

   }
   
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
	
	
	
	
	
	
	
	
	
	public function getNivel(){
	   
	   $resNivel = $this->banco->executar("
		SELECT 
			pe.ped_id, pe.fk_usu, pe.fk_status, ped_total, usu.fk_status as usu_fk, pe.fk_pai, pe.ped_nivel 
		FROM 
			public.tb_pedidos pe,
			public.tb_usuarios usu
		WHERE
			pe.fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND 
			usu.usu_doc = '".$_SESSION['usuario']['usu_doc']."' AND
			pe.fk_status = 3 AND
			usu.fk_status = 2 ORDER BY pe.ped_nivel DESC");

		return array("resNivel"=>$resNivel, "comprova"=>$comprova);
	
	  }
	
	//Valida os comprovantes
	  public function validaComprovante(){
		  if(isset($_POST['acao']) == "validarComp"){  
		   
		   $comprova = $this->banco->executar("
				SELECT 
					* 
				FROM 
					public.tb_comprovantes 
				WHERE  
					fk_pai = '".$_POST['fk_pai']."' AND 
					fk_ped = '".$_POST['fk_ped']."' AND
					fk_usu = '".$_SESSION['usuario']['usu_doc']."'");	

			if(empty($comprova[0])){
			  return array("template"=>"null", "dados"=>$comprova ,"retorno"=>"sim");
			}else{
			  return array("template"=>"null", "dados"=>$comprova ,"retorno"=>"nao");
			}				
		  }
	  }
	  
	 
	public function validaAtivacaoUsu(){
		   
		   $ativar = $this->banco->executar("
				SELECT 
					ped.ped_id, ped.ped_total, usu.usu_usuario, ped.fk_usu, ped.fk_status, 
					to_char(ped.ped_data_expira,'DD/MM/YYYY') as ped_data_expira, 
					ped.fk_pai, usu.usu_email,usu.usu_doc
				FROM 
					public.tb_pedidos as ped,
					public.tb_usuarios as usu
					
				WHERE  
					ped.fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND 
					ped.ped_nivel = 1 AND
					usu.usu_doc = ped.fk_pai					
					");	

			  return array("dados"=>$ativar );
					
	  } 
	
	
	//Valida as Doações
	public function validaDoacoesUsu(){
	 
	 $usu = $this->banco->executar("
	  SELECT fk_pai FROM public.tb_pedidos WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."'  AND fk_status = 1 ORDER BY ped_id ASC LIMIT 1");
	
	return array("resDoa"=>$usu); 
	
	}
	  
	// Verificar se o usuário está ativo 
    public function verificarUsuAtivo(){
		if( isset($_POST['acao']) == "validar" ){  
		 
		   $ativarUsu = $this->banco->executar("
				SELECT fk_status, usu_usuario
				FROM 
					public.tb_usuarios
				WHERE  
					usu_doc = '".strip_tags(trim($_POST['fk_pai']))."'");	

			if($ativarUsu[0]['fk_status'] == 2){
			  return array("template"=>"null","retorno"=>"sim");
			}else{
			  return array("template"=>"null", "retorno"=>"nao");
			}
		}					
	  } 
	
/*
   Verifico se já recebir a quantidade de doação exata por nivél, 
   e exibo o pedido a ser pago após completar a quantidade de doações recebidas
*/	

	public function validaQtdDoacoesRecebidas($docs = NULL){
    
	if( $docs != "00000000001"){		 

	 $doacoes = $this->qtdDoacoesNivel($docs);	 // Quantidade de doação exata por nivél  
	 $proxPed = $this->proxPedSerPago($docs);     //Proxímo pedido a ser pago após completar a quantidade de doações recebidas
     $pedId = strip_tags(trim($proxPed['proxPedPag'][0]['ped_id'])); // ID do proximo pedido a ser definido uma data de vencimento

	    if( $proxPed['proxPedPag'][0]['ped_data_expira'] == NULL ){		 
	      if( $doacoes['qtdDoacoes'][0]['total'] == 3 && $doacoes['qtdDoacoes'][0]['ped_total'] == '150'){			  
			/* $nivel2 = $this->banco->executar("SELECT fk_status FROM tb_pedidos WHERE fk_usu = '$docs' AND ped_nivel = 2");
			   if($nivel2[0]['fk_status'] =! 2 ){*/
	            $dataExpira = array( "ped_data_expira"=>date("Y-m-d H:m:s", strtotime("+2 days")));	
			    $this->banco->editar("public.tb_pedidos", $dataExpira, " ped_id = '$pedId'");
			  // }
		  }
 
		 if( $doacoes['qtdDoacoes'][0]['total'] == 9 && $doacoes['qtdDoacoes'][0]['ped_total'] == '250'){ 
		  /*$nivel3 = $this->banco->executar("SELECT fk_status FROM tb_pedidos WHERE fk_usu = '$docs' AND ped_nivel = 3");
		    if($nivel3[0]['fk_status'] =! 2 ){*/
	         $dataExpira = array( "ped_data_expira"=>date("Y-m-d H:m:s", strtotime("+2 days")));	
			 $this->banco->editar("public.tb_pedidos", $dataExpira, " ped_id = '$pedId'");	
		   //}
		 }
	   }	
	 }	  
   }

	public function qtdDoacoesNivel($doc){		
		
		//Se eu tiver recebido a quantidade de doação exata por nivél ele exibe o total de doações
		$qtdDoacoes = $this->banco->executar("
			SELECT 
				COUNT(*) as total,
				ped_qtd_downlines,
				fk_pai,
				ped_total,
				ped_nivel,
				ped_fase
			FROM 
				public.tb_pedidos
			WHERE 
				fk_pai = '".$doc."' AND fk_status = 3
			GROUP BY 
				ped_qtd_downlines,
				fk_pai,
				ped_total,
				ped_nivel,
				ped_fase,
				ped_qtd_downlines::text
			ORDER BY ped_nivel,ped_total DESC LIMIT 1");   
		
		return array("qtdDoacoes"=>$qtdDoacoes);
	
	}
	
	public function proxPedSerPago($doc){
	   
	//Proxímo pedido a ser pago após completar a quantidade de doações recebidas
	$proxPedPag = $this->banco->executar("
		SELECT 
			* 
		FROM 
			tb_pedidos 
		WHERE 
			fk_usu = '".$doc."' AND 
			fk_status = 1
		ORDER BY ped_id 
		ASC LIMIT 1");

	return array("proxPedPag"=>$proxPedPag);
	
	}
	
   public function validarProxPedSerPago($fk = NULL){
	     
	  if(isset($_POST['acao']) == "validarPedSerPago"){ 
		$dataAtual = date("Y-m-d");

		/*Verificar se expirou a data do pagamento, se não tiver pago aparece a conta administrativa, senão aparece a conta do usuário.*/
		$proxPedPag = $this->banco->executar("
			SELECT 
				ped_id,
				fk_status,
				fk_pag_adm,
				to_char(ped_data_expira,'YYYY-MM-DD') as ped_data_expira
			FROM 
				tb_pedidos 
			WHERE 
				fk_usu = '".strip_tags(trim($_POST['fk_pai']))."' AND 
				ped_id = '".strip_tags(trim($_POST['idPed']))."' AND 
				fk_status = 1
			ORDER BY ped_id ASC LIMIT 1");
		
$ped = $this->banco->executar("SELECT ped_id, fk_pag_adm FROM public.tb_pedidos WHERE ped_id = '".strip_tags(trim($_POST['idPed']))."'");
		
	if($ped[0]['fk_pag_adm'] == "00000000001"){
		
	    $receb = $this->banco->executar("SELECT * FROM public.tb_meios_recebimentos WHERE fk_usu = '".strip_tags(trim($_POST['fk_pai']))."'");
			
			$banco = $this->banco->executar("
			SELECT DISTINCT
				b.cod_nome,
				db.banco_agencia,
				db.banco_agencia_digito,
				db.banco_conta,
				db.banco_digito_conta,
				db.banco_op,
				db.banco_favorecido,
				db.banco_tipo
			FROM 
				public.tb_dados_banco db,
				public.tb_banco b
			WHERE 
				db.fk_usu = '00000000001' AND 
				b.cod_code = db.banco_code");
			
			if(!empty($banco[0]['cod_nome'])){			 
			return array("template"=>"ajax/banco_ajax", "receb"=>$receb, "adm"=>"ok", "retorno"=>"sim", "banco"=>$banco, "bancoOnline"=>$banco);		 
			}else{
			return array("template"=>"ajax/banco_ajax", "retorno"=>"nao", "banco"=>$banco, "bancoOnline"=>$banco);		  
			} 
		
		}else{ 
		
if($proxPedPag[0]['ped_data_expira'] != NULL){ 
  // Se passou da data de vencimento e ainda não efetuou a doação a ADM recebe o dinheiro
  if($proxPedPag[0]['ped_data_expira'] < $dataAtual){ 
	
    $this->banco->editar("public.tb_pedidos" , array("fk_pag_adm"=>"00000000001", "fk_status"=>6), " ped_id = '".strip_tags(trim($_POST['idPed']))."'"); 
					   
    $receb = $this->banco->executar("SELECT * FROM public.tb_meios_recebimentos WHERE fk_usu = '".strip_tags(trim($_POST['fk_pai']))."'");
			  
			  $banco = $this->banco->executar("
					SELECT DISTINCT
						b.cod_nome,
						db.banco_agencia,
						db.banco_agencia_digito,
						db.banco_conta,
						db.banco_digito_conta,
						db.banco_op,
						db.banco_favorecido,
						db.banco_tipo
					FROM 
						public.tb_dados_banco db,
						public.tb_banco b
					WHERE 
						db.fk_usu = '00000000001' AND 
						b.cod_code = db.banco_code");
		
			 if(!empty($banco[0]['cod_nome'])){			 
			   return array("template"=>"ajax/banco_ajax", "receb"=>$receb, "adm"=>"ok", "retorno"=>"sim", "banco"=>$banco, "bancoOnline"=>$banco);		 
			 }else{
			   return array("template"=>"ajax/banco_ajax", "retorno"=>"nao", "banco"=>$banco, "bancoOnline"=>$banco);		  
			 }    		   
		   }
		   if($proxPedPag[0]['ped_data_expira'] > $dataAtual){
	            $receb = $this->banco->executar("SELECT * FROM public.tb_meios_recebimentos WHERE fk_usu = '".strip_tags(trim($_POST['fk_pai']))."'");
			    $banco = $this->banco->executar("
					SELECT DISTINCT
						b.cod_nome,
						db.banco_agencia,
						db.banco_agencia_digito,
						db.banco_conta,
						db.banco_digito_conta,
						db.banco_op,
						db.banco_favorecido,
						db.banco_tipo
					FROM 
						public.tb_dados_banco db,
						public.tb_banco b
					WHERE 
						db.fk_usu = '".strip_tags(trim($_POST['fk_pai']))."' AND 
						b.cod_code = db.banco_code");
			
			 if(!empty($banco[0]['cod_nome'])){			 
			   return array("template"=>"ajax/banco_ajax", "adm"=>"no", "receb"=>$receb, "retorno"=>"sim", "banco"=>$banco, "bancoOnline"=>$banco);		 
			 }else{
			   return array("template"=>"ajax/banco_ajax", "retorno"=>"nao", "banco"=>$banco, "bancoOnline"=>$banco);		  
			 } 	
		   }		   
		 }else{

         $receb = $this->banco->executar("SELECT * FROM public.tb_meios_recebimentos WHERE fk_usu = '".strip_tags(trim($_POST['fk_pai']))."'");
			    $banco = $this->banco->executar("
					SELECT DISTINCT
						b.cod_nome,
						db.banco_agencia,
						db.banco_agencia_digito,
						db.banco_conta,
						db.banco_digito_conta,
						db.banco_op,
						db.banco_favorecido,
						db.banco_tipo
					FROM 
						public.tb_dados_banco db,
						public.tb_banco b
					WHERE 
						db.fk_usu = '".strip_tags(trim($_POST['fk_pai']))."' AND 
						b.cod_code = db.banco_code");
			
			 if(!empty($banco[0]['cod_nome'])){			 
			   return array("template"=>"ajax/banco_ajax", "adm"=>"no", "receb"=>$receb, "retorno"=>"sim", "banco"=>$banco, "bancoOnline"=>$banco);		 
			 }else{
			   return array("template"=>"ajax/banco_ajax", "retorno"=>"nao", "banco"=>$banco, "bancoOnline"=>$banco);		  
			 }			
		   }    
	     }		 		     
	   }	  
  }

   public function recebimentos(){
	   $receb = $this->banco->executar("SELECT * FROM public.tb_meios_recebimentos WHERE fk_usu = '".$_SESSION['usuario']['usu_doc']."'");
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
	   
	   return array("receb"=>$receb, "inativo"=>$inativo);
   }


   public function cadastrarRecebimentos(){ 
	   
   if(isset($_POST['acao']) == "cadastrar"){
	if(!empty($_POST['contasuper']) || !empty($_POST['pagseguro']) || !empty($_POST['paypal'])){
        
	 $conta = $this->banco->executar("SELECT * FROM public.tb_meios_recebimentos WHERE fk_usu = '".strip_tags(trim($_SESSION['usuario']['usu_doc']))."'");
	  
	  if(!empty($conta[0])){	 
		$recebimentos = array(
		    'conta_super'=>strip_tags(trim($_POST['contasuper'])),
		    'pagseguro'=>strip_tags(trim($_POST['pagseguro'])),
			'paypal'=>strip_tags(trim($_POST['paypal'])),
			'fk_usu'=>strip_tags(trim($_SESSION['usuario']['usu_doc']))
		);
		
		$this->banco->editar("public.tb_meios_recebimentos", $recebimentos, " fk_usu = '".strip_tags(trim($_SESSION['usuario']['usu_doc']))."'");	
		return array("template"=>"null", "retorno"=>"update");
		
	  }else{		  
	    $recebimentos = array(
		    'conta_super'=>strip_tags(trim($_POST['contasuper'])),
		    'pagseguro'=>strip_tags(trim($_POST['pagseguro'])),
			'paypal'=>strip_tags(trim($_POST['paypal'])),
			'fk_usu'=>strip_tags(trim($_SESSION['usuario']['usu_doc']))
		);
		
	    $this->banco->inserir("public.tb_meios_recebimentos", $recebimentos);	    
		return array("template"=>"null", "retorno"=>"insert");
	   }
	 }else{
	    return array("template"=>"null", "retorno"=>"no");
	  
	  }
    }
	
   }
   
   public function listContatoUsu(){
	   
	if(isset($_POST['acao']) == "contato"){	
		$cont = $this->banco->executar("SELECT * FROM public.tb_usuarios WHERE usu_doc = '".strip_tags(trim($_POST['id']))."'");
		$fone = $this->banco->executar("SELECT * FROM public.tb_fone WHERE fk_usu = '".strip_tags(trim($_POST['id']))."' AND fk_tipo = 1");
		$cel = $this->banco->executar("SELECT * FROM public.tb_fone WHERE fk_usu = '".strip_tags(trim($_POST['id']))."' AND fk_tipo = 3");
		$whats = $this->banco->executar("SELECT * FROM public.tb_fone WHERE fk_usu = '".strip_tags(trim($_POST['id']))."' AND fk_tipo = 4");
		$comer = $this->banco->executar("SELECT * FROM public.tb_fone WHERE fk_usu = '".strip_tags(trim($_POST['id']))."' AND fk_tipo = 2");
		
		return array("template"=>"ajax/listContato",
		"cont"=>$cont,
		"fone"=>$fone,
		"cel"=>$cel,
		"whats"=>$whats,
		"comer"=>$comer
		);   
	   
	}
   }

	
		
	public function realizadas(){
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
		return array("inativo"=>$inativo);   
	
	}
	
	public function realizadas_ajax(){
	  
	    $filtros = array();
	
		$filtros['limit'] = $_REQUEST['regpag'];
	
		if( $_REQUEST['pagina'] > 1 ) {
			$filtros['offset'] = ( ( $_REQUEST['pagina'] * $_REQUEST['regpag'] ) - $_REQUEST['regpag'] );
		} else {
			$filtros['offset'] = 0;
		}
	
		if( !empty( $_REQUEST['busca'] ) ) {
			$filtros['busca'] = $_REQUEST['busca'];
		} else {
			$filtros['busca'] = "";
		}
	
		$filtros['pagina'] = $_REQUEST['pagina'];

      $query = "
		SELECT 
			usu.usu_id,
			usu.usu_nome,
			usu.usu_usuario,
			pe.fk_pai,
			usu.usu_doc,
			usu.usu_email,
			pe.ped_id,
			pe.ped_total,
			pe.ped_nivel,
			pe.fk_status,
			to_char(pe.ped_data_pag,'DD/MM/YYYY') as ped_data_pag,
			stp.status_compro_nome,
			stp.status_compro_id
		FROM 
			public.tb_pedidos pe,
			public.tb_usuarios usu,
			public.tb_status_compro stp
		";

			if( !empty( $filtros['busca'] ) ) {
				$queryBusca = "
				WHERE 
					pe.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND
					usu.usu_doc = pe.fk_pai AND
					stp.status_compro_id = pe.fk_status AND
					pe.fk_status = 3 AND 
				 ( ( usu.usu_usuario LIKE '%".$filtros['busca']."%' ) OR
									( to_char(pe.ped_data_pag,'DD/MM/YYYY')::text LIKE '%".$filtros['busca']."%' ) OR
									( pe.ped_total::text LIKE '%".$filtros['busca']."%' ) OR
									( usu.usu_email LIKE '%".$filtros['busca']."%' )) ";
			$queryP = "
				WHERE 
					pe.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND
					usu.usu_doc = pe.fk_pai AND
					stp.status_compro_id = pe.fk_status AND
					pe.fk_status = 3 AND 
				 ( ( usu.usu_usuario LIKE '%".$filtros['busca']."%' ) OR
									( to_char(pe.ped_data_pag,'DD/MM/YYYY')::text LIKE '%".$filtros['busca']."%' ) OR
									( pe.ped_total::text LIKE '%".$filtros['busca']."%' ) OR
									( usu.usu_email LIKE '%".$filtros['busca']."%' )) ";
									
			
			}else{
			  $queryBusca = "
			  WHERE 
					pe.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND
					usu.usu_doc = pe.fk_pai AND
					stp.status_compro_id = pe.fk_status AND
					pe.fk_status = 3 ";
			 
			$queryP ="
			  WHERE 
					pe.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND
					usu.usu_doc = pe.fk_pai AND
					stp.status_compro_id = pe.fk_status AND
					pe.fk_status = 3 ";
			
			}
		   
		    $queryPag = "
				SELECT 
					count(*) as total
				FROM 
					public.tb_pedidos pe,
					public.tb_usuarios usu,
					public.tb_status_compro stp
				$queryP
				GROUP BY pe.ped_id
				ORDER BY pe.ped_id DESC";	

					
			$retornoPag = $this->SearchPaginacao( $queryPag, $filtros['pagina'], $filtros['limit'] );
			$query .= $queryBusca;	
				
			$query .= "ORDER BY pe.ped_id DESC ";
			$query .="LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];

			$ver = $this->banco->executar($query);

			$retorno['res'] = $ver;
			$retorno['template'] = "ajax/realizadas_ajax";
			$retorno['paginacao'] = $retornoPag;
			
			return $retorno;
	
	}
	
	public function SearchPaginacao($sql, $pagina, $regpag ) {
		
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		$totalRegistros = $res[0]['total'];
		if( $totalRegistros > 0 ) {
			$totalPaginas = ceil( $totalRegistros / $regpag );
			$totalPagina = ( $pagina * $regpag );
			$totalPagina = ( $totalPagina < $totalRegistros ) ? $totalPagina : $totalRegistros;

			if( $pagina > 1 ) {
				$offset = ( ( $pagina * $regpag ) - $regpag );
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
				  <div class="dataTables_paginate paging_full_numbers" id="example_paginate">
					<div class="span6">';
							//botao botao anterior
							$html .= ( $pagina > 1 ) ? '<a tabindex="0" class="previous paginate_button" href="javascript:void(paginacao_realizadas(\''.( $pagina - 1 ).'\'));">← Anterior</a>' : '<a class="paginate_button_disabled" href="#">← Anterior</a>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<a tabindex="0" class="paginate_button" href="javascript:void(paginacao_realizadas(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a>' : '<a href="#">&nbsp;</a>';
							$html .= '<a tabindex="0" class="paginate_active" href="#">'.$pagina.'</a>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<a tabindex="0" class="paginate_button" href="javascript:void(paginacao_realizadas(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a>' : '<a href="#">&nbsp;</a>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<a tabindex="0" class="next paginate_button" href="javascript:void(paginacao_realizadas(\''.( $pagina + 1 ).'\'));">Próxima → </a>' : '<a href="#">Próxima → </a>';
							$html .= '					
					 </div>
			       </div>	
				</div>';
	

		return $html;
	}
	
	public function CancelandoComprovante(){	 
	 if(isset($_POST['acao']) == "CancelCompro"){
					 
		$idComp = strip_tags(trim($_POST['idCompro']));
		$idPed = strip_tags(trim($_POST['idPed']));
		
		  $this->banco->editar("public.tb_comprovantes", array("fk_status_compro"=>4), " compro_id = '$idComp'");
		  $usu = $this->banco->executar("SELECT usu_email,usu_usuario FROM public.tb_usuarios WHERE usu_doc = '".$_SESSION['usuario']['usu_doc']."'");
		 
		  $compEmail = $this->banco->executar("
			SELECT 
			    u.usu_nome,
				u.usu_usuario,
				u.usu_email,
				p.ped_total,
				to_char(c.compro_data_envio, 'DD/MM/YYYY') as compro_data_envio
			FROM 
				public.tb_comprovantes AS c,
				public.tb_usuarios AS u,
				public.tb_pedidos AS p
			WHERE
				c.fk_usu = u.usu_doc AND
				p.ped_id = '$idPed' AND
				c.compro_id = '$idComp'");		   
		  
		  //echo "<pre>"; print_r($compEmail); die;
		   
		   $data = $compEmail[0]['compro_data_envio'];
		   $valor = number_format($compEmail[0]['ped_total'],2,",",".");
		   $email = $usu[0]['usu_email'];    // email de quem cancelou o comprovante
		   $usuario = $usu[0]['usu_usuario']; // usuario de quem cancelou o comprovante
		   
		   
$html ="
<table width='100%' border='0' cellpadding='2'>
<tr>
<td width='100%'></td>
</tr>
<tr>
<td><h3><strong>ATENÇÃO! O seu comprovante foi cancelado.</strong></h3></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td><p><strong>IMPORTANTE: <br>
</strong><strong><br>
</strong>O comprovante enviado para <strong>$usuario</strong> na data <strong>$data</strong> no valor de <strong>R$:$valor</strong> foi cancelado,<br>
entre em contato com o usuário(a) urgente para que você não se prejudique e consiga receber doações<br>
normalmente.<br><p><p>
<br>
<strong>E-MAIL: </strong> $email<br>
<br>
<strong>ENVIE NOVAMENTE O COMPROVANTE ATRAVÉS DO SEU ESCRITÓRIO VIRTUAL.</strong></p></td>
</tr>
<tr>
<td><p>&nbsp;</p>
<p><strong>Não deixe passar essa oportunidade de negocio para aumentar a sua renda e sem comprometer seu horário de Trabalho. </strong></p>
<p>&nbsp;</p>
<p>Sempre que precisar, entre em contato conosco, estaremos ao seu dispor! </p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>&nbsp;</p><p>&nbsp;</p>
<p><strong>G3Money - Ajuda Mútua Financeira</strong><br>
<a target='_blank' href='http://g3money10.com.br'>http://g3money10.com.br/</a> </p></td>
</tr>
</table>";

		$enviar = array(			
		    "usu_usuario"=> $compEmail[0]['usu_usuario'],
			"usu_email"=>$compEmail[0]['usu_email'],
			"assunto"=>"G3Money - COMRPOVANTE CANCELADO!‏"	 ,
			"msg" => $html  
		); 		
		   
		$email = new Email;
		$mail = $email->enviar($enviar);
		
		return array("template"=>"null","retorno"=>"ok");	 
	 }	 
	}
	
	
   public function rotina24horas(){  
	     
		 $usu = $this->banco->executar("
				SELECT 
					u.usu_usuario,
					u.usu_doc,
					p.fk_usu,
					u.fk_status,
					to_char(p.ped_data_expira,'DD/MM/YYYY')
				FROM
					tb_usuarios as u,
					tb_pedidos as p
				WHERE
					u.usu_doc = p.fk_usu AND
					p.fk_status = 1 AND
					u.fk_status = 1 AND
					p.ped_nivel = 1 AND
					p.ped_data_expira < (SELECT current_timestamp)
				ORDER BY usu_id ASC ");	
				
				//echo "<pre>"; print_r($usu); die;
	    
	  foreach($usu as $listUsu){		  

	$doc = strip_tags(trim($listUsu['usu_doc']));
	$comprUsu = $this->banco->executar("SELECT * FROM public.tb_comprovantes WHERE fk_usu = '".$doc."' AND fk_status_compro = '1'");	

	  
	    if(empty($comprUsu[0]['fk_usu'])){
	     	
		  $listusuarios = $this->banco->executar("
		            SELECT 
					 usu_id,usu_nome, usu_usuario, usu_doc, usu_data,usu_email
					FROM 
					 tb_usuarios
					WHERE 
					 usu_doc = '$doc' ");
		  
		  $usuarios = array(
		  	'usu_nome'=>$listusuarios[0]['usu_nome'],
		  	'usu_usuario'=>$listusuarios[0]['usu_usuario'],
		  	'usu_doc'=>$listusuarios[0]['usu_doc'],
		  	'usu_data'=>$listusuarios[0]['usu_data'],
		  	'usu_email'=>$listusuarios[0]['usu_email']
		  );	  
		  
		  $this->banco->inserir("public.tb_usuarios_bloqueados", $usuarios);
		  $this->banco->excluir("public.tb_dados_banco", "fk_usu = '".$doc."'");
		  $this->banco->excluir("public.tb_comprovantes", "fk_usu = '".$doc."'");
		  $this->banco->excluir("public.tb_comprovantes_getcash", "fk_usu = '".$doc."'");
		  $this->banco->excluir("public.tb_endereco", "fk_usu = '".$doc."'");
		  $this->banco->excluir("public.tb_fone", "fk_usu = '".$doc."'");
		  $this->banco->excluir("public.tb_meios_recebimentos", "fk_usu = '".$doc."'");
		  $this->banco->excluir("public.tb_pedidos", "fk_usu = '".$doc."'");
		  $this->banco->excluir("public.tb_usuarios", "usu_doc = '".$doc."'");
	   }		  
    }
}
	//Validação de todos os pedidos e comprovantes
	public function validacaoPedCompro(){
	 
	  $query = $this->banco->executar("
					SELECT 
						p.ped_id,
						c.compro_id,
						p.fk_usu,
						p.ped_total,
						p.ped_nivel,
						p.ped_fase,
						p.fk_pai,
						c.fk_ped
					FROM
						tb_pedidos as p,
						tb_comprovantes as c
					WHERE
						p.ped_id = c.fk_ped AND
						p.fk_status = 1 AND
						c.fk_status_compro = 1 AND
						to_char(c.compro_data_envio,'DD/MM/YY')  < ('10/11/2015') ORDER BY compro_data_envio ASC");		
	   
foreach($query as $listquery){	   

 $peId = $this->banco->executar("SELECT ped_id,fk_pai,ped_total FROM public.tb_pedidos WHERE ped_id = '{$listquery['ped_id']}'");  

 //Ativar Usuário
 $usuario = array('fk_status'=>2);	
 $this->banco->editar("public.tb_usuarios", $usuario, " usu_doc = '".$listquery['fk_usu']."'");

 //Da baixa no pedido
 $pedidos = array('fk_status'=>3,'ped_data_pag'=>"NOW()",'ped_valor_pago'=>$listquery['ped_total']);	
 $this->banco->editar("public.tb_pedidos", $pedidos, " ped_id = '".$listquery['ped_id']."'");

 // Da baixa no comprovante
 $comprovante = array('fk_status_compro'=>2,'compro_data_pag'=>"NOW()");	
 $this->banco->editar("public.tb_comprovantes", $comprovante, " fk_ped = '".$peId[0]['ped_id']."'");

// Mostra o pedido 	   
$pedi = $this->banco->executar("		   
SELECT 
	fk_usu_rede
FROM 
	public.tb_usuarios
WHERE  
	usu_doc = '".strip_tags(trim($peId[0]['fk_pai']))."'"); 

$ip = Controller::$ip;
$browser = Controller::$browser;
	 
if($peId[0]['ped_total'] == 150){
    $valor = 250;	
  
    $pe = $this->banco->executar("SELECT ped_total FROM public.tb_pedidos WHERE fk_usu = '{$listquery['fk_usu']}' AND ped_total = 250");  
    
    if($pe[0]['ped_total'] != 250){ 
		 session_regenerate_id();
		 $criaPedidos = array(
			   "fk_usu"=>$listquery['fk_usu'],
			   "ped_total"=>$valor,
			   "ped_sessao"=>session_id(),
			   "ped_ip"=>$ip,
			   "ped_browser"=>$browser,
			   "ped_data_expira"=>NULL,
			   "fk_pai"=>$pedi[0]['fk_usu_rede'],
			   "ped_nivel"=>($listquery['ped_nivel'] + 1),
			   "ped_qtd_downlines"=>9,
			   "ped_fase"=>$listquery['ped_fase']
			 ); 	 

	$this->banco->inserir("public.tb_pedidos", $criaPedidos);	
 
    session_regenerate_id();
  	
    }
 }
	
if($peId[0]['ped_total'] == 250){
    $valor = 1000;	
  
    $pe = $this->banco->executar("SELECT ped_total FROM public.tb_pedidos WHERE fk_usu = '{$listquery['fk_usu']}' AND ped_total = 1000");  
 
    if($pe[0]['ped_total'] != 1000){ 
		session_regenerate_id(); 
		 $criaPedidos = array(
			   "fk_usu"=>$listquery['fk_usu'],
			   "ped_total"=>$valor,
			   "ped_sessao"=>session_id(),
			   "ped_ip"=>$ip,
			   "ped_browser"=>$browser,
			   "ped_data_expira"=>NULL,
			   "fk_pai"=>$pedi[0]['fk_usu_rede'],
			   "ped_nivel"=>($listquery['ped_nivel'] + 1),
			   "ped_qtd_downlines"=>27,
			   "ped_fase"=>$listquery['ped_fase']
			 ); 	 

	$this->banco->inserir("public.tb_pedidos", $criaPedidos);	
 
    session_regenerate_id();
	
    }
  }
}

}


public function resolverPedido(){

	$cad = new Cadastro;	
	$usuPed = $this->banco->executar("SELECT usu_doc FROM public.tb_usuarios WHERE usu_doc != '00000000001' EXCEPT SELECT fk_usu FROM public.tb_pedidos WHERE fk_usu != '00000000001'");

	foreach( $usuPed as $listUsuDoc ){
	$AcimaNivel = $cad->getNiveisAcimaReentrada($listUsuDoc['usu_doc']);  	
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
		 
		 $ip = Controller::$ip;
		 $browser = Controller::$browser;
		 
		 $pedidos = array(
		   "fk_usu"=>$listUsuDoc['usu_doc'],
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
		   session_regenerate_id();
		} 
	  
}

  
  }
  
  public function doacoesAdm(){
    
  }
  
  	
	public function doacoesAdm_ajax(){
		
	$filtros = array();

	$filtros['limit'] = $_REQUEST['regpag'];

	if( $_REQUEST['pagina'] > 1 ) {
		$filtros['offset'] = ( ( $_REQUEST['pagina'] * $_REQUEST['regpag'] ) - $_REQUEST['regpag'] );
	} else {
		$filtros['offset'] = 0;
	}

	if( !empty( $_REQUEST['busca'] ) ) {
		$filtros['busca'] = $_REQUEST['busca'];
	} else {
		$filtros['busca'] = "";
	}

	$filtros['pagina'] = $_REQUEST['pagina'];
	
	$queryPag = "SELECT count(compro_id) as total FROM public.tb_comprovantes_getcash";

	$query = "
			SELECT 
			    cash.compro_id,
				cash.fk_status_compro,
				cash.compro_img,
				to_char(cash.compro_data_envio,'DD/MM/YYYY') as data_envio,
				usu.usu_doc,
				usu.usu_nome,
				usu.usu_usuario,
				usu.usu_email,
				usu.fk_status
			FROM 
				public.tb_comprovantes_getcash as cash,
				public.tb_usuarios as usu
			WHERE 
				cash.fk_usu = usu.usu_doc";
	
	if( !empty( $filtros['busca'] ) ) {
		$queryBusca = " AND ( ( usu.usu_usuario LIKE '%".$filtros['busca']."%' ) OR ( usu.usu_email LIKE '%".$filtros['busca']."%' )) ";
	}

	$queryPag .= $queryBusca;	

	$retornoPag = $this->SearchPaginacaoAdmDoacao( $queryPag, $filtros['pagina'], $filtros['limit'] );
	$query .= $queryBusca;	
	
	$query .= " ORDER BY cash.compro_id DESC ";
	$query .= " LIMIT ".$filtros['limit']." OFFSET ".$filtros['offset'];
	
	//echo "<pre>"; print_r( $query ); die;
	
	$ver = $this->banco->executar($query);
	$retorno['template'] = "doacoesAdm_ajax";
	$retorno['busca'] = $ver;
	$retorno['paginacao'] = $retornoPag;
	
	return $retorno;
 }
 
 
 
 
 public function SearchPaginacaoAdmDoacao($sql, $pagina, $regpag ) {
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		$totalRegistros = $res[0]['total'];
		if( $totalRegistros > 0 ) {
			$totalPaginas = ceil( $totalRegistros / $regpag );
			$totalPagina = ( $pagina * $regpag );
			$totalPagina = ( $totalPagina < $totalRegistros ) ? $totalPagina : $totalRegistros;

			if( $pagina > 1 ) {
				$offset = ( ( $pagina * $regpag ) - $regpag );
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
					<div class="span12">
						<div class="dataTables_info" id="editable_info">Mostrando '.$offsetMaisUm.' até '.$totalPagina.' de '.$totalRegistros.' registros</div>
					</div>	
				  <div class="dataTables_paginate paging_full_numbers" id="example_paginate">
					<div class="span6">';
							//botao botao anterior
							$html .= ( $pagina > 1 ) ? '<a tabindex="0" class="previous paginate_button" href="javascript:void(paginacao_doarAdm(\''.( $pagina - 1 ).'\'));">← Anterior</a>' : '<a class="paginate_button_disabled" href="#">← Anterior</a>';
					
							//monta 3 links de páginação
							$html .= ( ( $pagina - 1 ) > 0 ) ? '<a tabindex="0" class="paginate_button" href="javascript:void(paginacao_doarAdm(\''.( $pagina - 1 ).'\'));">'.( $pagina - 1 ).'</a>' : '<a href="#">&nbsp;</a>';
							$html .= '<a tabindex="0" class="paginate_active" href="#">'.$pagina.'</a>';
							$html .= ( ( $pagina + 1 ) <= $totalPaginas ) ? '<a tabindex="0" class="paginate_button" href="javascript:void(paginacao_doarAdm(\''.( $pagina + 1 ).'\'));">'.( $pagina + 1 ).'</a>' : '<a href="#">&nbsp;</a>';
							
							//monta botao proximo							
							$html .= ( $pagina < $totalPaginas ) ? '<a tabindex="0" class="next paginate_button" href="javascript:void(paginacao_doarAdm(\''.( $pagina + 1 ).'\'));">Próxima → </a>' : '<a href="#">Próxima → </a>';
							$html .= '					
					 </div>
			       </div>	
				</div>';

		return $html;
	}
	
    public function confirmaDoacaoAdm(){
	
	 if(isset($_POST['acao']) == 'ok'){
 
	    $ped = $this->banco->executar("					
				SELECT 
					usu.usu_doc,
					usu.fk_status
				FROM 
					public.tb_comprovantes_getcash as cash,
					public.tb_usuarios as usu
				WHERE 
				usu.usu_doc = '".strip_tags(trim($_POST['doc']))."' AND
				cash.fk_usu = '".strip_tags(trim($_POST['doc']))."'
				");  

		if($ped[0]['fk_status'] == 3){		
		 $usuarios = array( 'fk_status'=>1 );	
		 $this->banco->editar("public.tb_usuarios", $usuarios, " usu_doc = '".strip_tags(trim($ped[0]['usu_doc']))."'");
		}

		 $comprovante = array('fk_status_compro'=>2,'compro_data_pag'=>"NOW()");	
		 $this->banco->editar("public.tb_comprovantes_getcash", $comprovante, " compro_id = '".$_POST['id']."'");
		 
		 return array("template"=>"null", "retorno"=>"ok");
	 }

		
		
	}


}