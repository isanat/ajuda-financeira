<?php 

class Rede extends TbUsuarios
{
	
	public function binario()
	{
     $rede['rede'] = $this->GetRedeBinario($_SESSION['usuario']['usu_doc']);
	 
	 return $rede;

     }

	
	public  function montaPerna($rede, $perna)
	{
		foreach ($rede as $key => $lista)
		{
			if($lista['nivel'] == 1)
			{
				$listar[$lista['usu_perna']] = $lista;
				//$um = $listar[$lista['usu_perna']];
					
			}elseif($lista['nivel'] == 2)
			{
				//$listar[] = $lista;
				$listar[$perna][$lista['usu_perna']] = $lista;
				$dois = $listar;
			}elseif($lista['nivel'] == 3)
			{
				if($lista['fk_usu_rede'] == $listar[$perna]['d']['usu_doc'])
				{
					$listar[$perna]['d'][$lista['usu_perna']] = $lista;
		
				}elseif($lista['fk_usu_rede'] == $listar[$perna]['e']['usu_doc'])
				{
					$listar[$perna]['e'][$lista['usu_perna']] = $lista;
				}
			}
				
		
		}
		
		return $listar;
	}
	
	public function matriz4x4()
	{
	
		$this->SetUsuUsuario($_REQUEST['usu_usuario']);
			
		$usu_doc = $this->SelectOne();
	
		if(!isset($_REQUEST['usu_usuario'])){
			//echo 'um';die;
			$usu_doc = $_SESSION['usuario']['usu_doc'];
				
			$rede = $this->GetRede4x4($usu_doc);
				
				
			return $rede;
	
		}elseif ($usu_doc == $_SESSION['usuario']['usu_doc'])
		{//echo 'dois';die;
			return $this->GetRede4x4($_SESSION['usuario']['usu_doc']);
		}else{
				
			$usu_search = $usu_doc;
				
			while ($usu_search != $_SESSION['usuario']['usu_doc']) {
					
				$usu_search = $this->Search4x4($usu_search);
					
				if($usu_search == $_SESSION['usuario']['usu_doc'])
				{
					return $this->GetRede4x4($usu_doc);
						
				} elseif (empty($usu_search))
				{
					return $this->GetRede4x4($_SESSION['usuario']['usu_doc']);
						
				}
					
			}
				
				
		}
		
		
	
	
	}
	
	public function MontaBinario($usu_doc)
	{
		$topo = $this->PiramideBinaria($usu_doc);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo['usuario']['fk_usu']) ? $topo['usuario']['usu_email'] : null;
		
		$rede['principal'] = array('nome' => $topo['usuario']['usu_usuario'], 'status' => $topo['usuario']['carreira'],
				 'sexo' => $topo['usuario']['usu_sexo'], 'email' => $email, 'nome_completo' => $topo['usuario']['usu_nome'],
			//'bonus' => $topo['usuario']['ca_nome'], 
				'patrocionador' => $topo['usuario']['patrocionador'], 'data' => $topo['usuario']['usu_data'],
				'upline' => $topo['usuario']['upline'], 
				'usu_doc' => $usu_doc, 
				'usu_usuario' => $topo['usuario']['usu_usuario'], 
				'usu_auto_ativacao' => $topo['usuario']['usu_auto_ativacao']  
				);
		//echo '<pre>';print_r($topo);die;
		$topo_e = $this->PiramideBinaria($topo['e']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_e['usuario']['fk_usu']) ? $topo_e['usuario']['usu_email'] : null;
		
		$rede['principal']['e'] = array('nome' =>$topo_e['usuario']['usu_usuario'], 'status' => $topo_e['usuario']['carreira'], 
				'sexo' => $topo_e['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_ee = $this->PiramideBinaria($topo_e['e']);
		//echo '<pre>';print_r($topo_ee);die;
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_ee['usuario']['fk_usu']) ? $topo_ee['usuario']['usu_email'] : null;
		
		$rede['principal']['e']['e'] = array('nome' =>$topo_ee['usuario']['usu_usuario'], 'status' => $topo_ee['usuario']['carreira'], 
				'sexo' => $topo_ee['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_eee = $this->PiramideBinaria($topo_ee['e']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_eee['usuario']['fk_usu']) ? $topo_eee['usuario']['usu_email'] : null;
		
		$rede['principal']['e']['e']['e'] = array('nome' =>$topo_eee['usuario']['usu_usuario'], 'status' => $topo_eee['usuario']['carreira'],
				 'sexo' => $topo_eee['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_eed = $this->PiramideBinaria($topo_ee['d']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_eed['usuario']['fk_usu']) ? $topo_eed['usuario']['usu_email'] : null;
		
		$rede['principal']['e']['e']['d'] = array('nome' =>$topo_eed['usuario']['usu_usuario'], 'status' => $topo_eed['usuario']['carreira'],
				 'sexo' => $topo_eed['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_ed = $this->PiramideBinaria($topo_e['d']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_ed['usuario']['fk_usu']) ? $topo_ed['usuario']['usu_email'] : null;
		
		$rede['principal']['e']['d'] = array('nome' =>$topo_ed['usuario']['usu_usuario'], 'status' => $topo_ed['usuario']['carreira'],
				 'sexo' => $topo_ed['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_ede = $this->PiramideBinaria($topo_ed['d']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_ede['usuario']['fk_usu']) ? $topo_ede['usuario']['usu_email'] : null;
		
		$rede['principal']['e']['d']['e'] = array('nome' =>$topo_ede['usuario']['usu_usuario'], 'status' => $topo_ede['usuario']['carreira'],
				 'sexo' => $topo_ede['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_edd = $this->PiramideBinaria($topo_ed['e']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_edd['usuario']['fk_usu']) ? $topo_edd['usuario']['usu_email'] : null;
		
		$rede['principal']['e']['d']['d'] = array('nome' =>$topo_edd['usuario']['usu_usuario'], 'status' => $topo_edd['usuario']['carreira'],
				 'sexo' => $topo_edd['usuario']['usu_sexo'], 'email' => $email);
		
		
		$topo_d = $this->PiramideBinaria($topo['d']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_d['usuario']['fk_usu']) ? $topo_d['usuario']['usu_email'] : null;
		
		$rede['principal']['d'] = array('nome' =>$topo_d['usuario']['usu_usuario'], 'status' => $topo_d['usuario']['carreira'],
				 'sexo' => $topo_d['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_de = $this->PiramideBinaria($topo_d['e']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_de['usuario']['fk_usu']) ? $topo_de['usuario']['usu_email'] : null;
		
		$rede['principal']['d']['e'] = array('nome' =>$topo_de['usuario']['usu_usuario'], 'status' => $topo_de['usuario']['carreira'],
				 'sexo' => $topo_de['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_dee = $this->PiramideBinaria($topo_de['e']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_dee['usuario']['fk_usu']) ? $topo_dee['usuario']['usu_email'] : null;
		
		$rede['principal']['d']['e']['e'] = array('nome' =>$topo_dee['usuario']['usu_usuario'], 'status' => $topo_dee['usuario']['carreira'],
				 'sexo' => $topo_dee['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_ded = $this->PiramideBinaria($topo_de['d']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_ded['usuario']['fk_usu']) ? $topo_ded['usuario']['usu_email'] : null;
		
		$rede['principal']['d']['e']['d'] = array('nome' =>$topo_ded['usuario']['usu_usuario'], 'status' => $topo_ded['usuario']['carreira'],
				 'sexo' => $topo_ded['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_dd = $this->PiramideBinaria($topo_d['d']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_dd['usuario']['fk_usu']) ? $topo_dd['usuario']['usu_email'] : null;
		
		$rede['principal']['d']['d'] = array('nome' =>$topo_dd['usuario']['usu_usuario'], 'status' => $topo_dd['usuario']['carreira'],
				 'sexo' => $topo_dd['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_dde = $this->PiramideBinaria($topo_dd['e']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_dde['usuario']['fk_usu']) ? $topo_dde['usuario']['usu_email'] : null;
		
		$rede['principal']['d']['d']['e'] = array('nome' =>$topo_dde['usuario']['usu_usuario'], 'status' => $topo_dde['usuario']['carreira'],
				 'sexo' => $topo_dde['usuario']['usu_sexo'], 'email' => $email);
		
		$topo_ddd = $this->PiramideBinaria($topo_dd['d']);
		
		$email = ($_SESSION['usuario']['usu_doc'] == $topo_ddd['usuario']['fk_usu']) ? $topo_ddd['usuario']['usu_email'] : null;
		$rede['principal']['d']['d']['d'] = array('nome' =>$topo_ddd['usuario']['usu_usuario'], 'status' => $topo_ddd['usuario']['carreira'],
				 'sexo' => $topo_ddd['usuario']['usu_sexo'], 'email' => $email);
		
		return $rede;
	}
	
	public function PiramideBinaria($usu){
	
		try{
	
			if($usu == 'vazio'){
	
				$res[0]['usu_usuario'] = 'vazio';
				$res[0]['carreira'] = 'vazio';
				$res[0]['usu_sexo'] = 'm';
	
				return array(
	
						'usuario'=>$res[0],
						'e'=>'vazio',
						'd'=>'vazio'
	
				);
			}else{
				$ver = $this->banco->conexao->prepare("SELECT u.usu_usuario, u.usu_nome, u.usu_doc, u.fk_carreira, u.usu_sexo, 
														u.usu_email, u.fk_usu, to_char(u.usu_data, 'DD/MM/YYYY') as usu_data, 
															CASE 
																WHEN u.fk_status = 3 THEN 'bloqueado'
																ELSE c.ca_nome 
															END as carreira, c.ca_nome, u.usu_perna_auto, u.usu_auto_ativacao,   
														uu.usu_usuario as patrocionador, uuu.usu_usuario as upline
														FROM tb_usuarios u
														LEFT JOIN tb_carreira c ON u.fk_carreira = c.ca_id
														LEFT JOIN tb_usuarios uu ON u.fk_usu = uu.usu_doc
														LEFT JOIN tb_usuarios uuu ON u.fk_usu_rede = uuu.usu_doc
														where u.usu_doc = ? AND (u.fk_status = 2 OR u.fk_status = 3)");
	
				$ver->execute(array($usu));
				$res = $ver->fetchAll(PDO::FETCH_ASSOC);
				
// 				$res[0]['fk_carreira'] = $this->tb_carreira($res[0]['fk_carreira']);
				
				$data = date('Y-m-d',$res[0]['usu_data']);
				
	
// 				$res[0]['fk_carreira']['ca_nome'] = strtolower(str_replace(' ', '', $res[0]['fk_carreira']['ca_nome']));
	
	
				$esquerda = $this->esquerdo(	$res[0]['usu_doc']	);
				$direita = $this->direito(	$res[0]['usu_doc']	);
				
				$res[0]['carreira'] = strtolower(str_replace(' ', '', $res[0]['carreira']));
				
	
	
				return array(
	
						'usuario'=>$res[0],
						'e'=>$esquerda,
						'd'=>$direita
	
				);
			}
	
		}catch (PDOException $e){
	
			$msg = $e->getMessage();
			echo 'erro '.$msg;die;
		}
	
	}
	
	public function esquerdo($usu){
		try{
	
			$ver = $this->banco->conexao->prepare("SELECT usu_doc
					FROM tb_usuarios
					where fk_usu_rede = ? AND usu_perna = 'e'
					ORDER BY usu_id ASC LIMIT 1");
	
			$ver->execute(array($usu));
			$res = $ver->fetchAll(PDO::FETCH_ASSOC);
	
			if(!empty($res[0]) && $usu != 'vazio'){
	
				return $res[0]['usu_doc'];
	
			}else{
	
				return 'vazio';
	
			}
	
		}catch (PDOException $e){
	
			$msg = $e->getMessage();
			echo 'erro '.$msg;die;
		}
	}
	
	public function direito($usu){
		try{
	
			$ver = $this->banco->conexao->prepare("SELECT usu_doc
					FROM tb_usuarios
					where fk_usu_rede = ? AND usu_perna = 'd'
					ORDER BY usu_id ASC LIMIT 1");
	
			$ver->execute(array($usu));
			$res = $ver->fetchAll(PDO::FETCH_ASSOC);
	
			if(!empty($res[0])){
	
				return $res[0]['usu_doc'];
	
			}else{
	
				return 'vazio';
	
			}
	
		}catch (PDOException $e){
	
			$msg = $e->getMessage();
			echo 'erro '.$msg;die;
		}
	}
	
	public function tb_carreira($bn){
// 	echo "select * from tb_carreira where bn_id = {$bn}";die;
		$res = $this->banco->executar("select * from tb_carreira where ca_id = {$bn}");
	
		return $res[0];
	}
	
	public function carreira() {
		$resCarreira = false;
		$carreira = new TbCarreira;
		$resCarreira = $carreira->getCarreira();
		$saldoPontos = new TbSaldoPontos;
		$resPontos = $saldoPontos->getAllPontos($_SESSION['usuario']['usu_doc']);
		
		$res = array( 'carreira' => $resCarreira, 
						'totalPontos' => $resPontos );
		return $res;
	}
	
	public function linear() 
	{
		return $this->RedeLinear();
	}
	
	public function linearjson() 
	{
		return $this->RedeLinearJson();
	}
		
	public function autoativacao() {
		$this->SetUsuDoc($_SESSION['usuario']['usu_doc']);
		$this->SetUsuAutoAtivacao($_REQUEST['auto']);
		$this->AutoAtivar();
	}
	
	public function perna()
	{
		$this->SetUsuDoc($_SESSION['usuario']['usu_doc']);
		$perna = explode( ':', $_REQUEST['perna'] );
		if( $perna[0] == 'a' ) {
			$this->SetUsuPernaPref($perna[1]);
			$this->SetUsuPernaAuto('1');
		} else {
			$this->SetUsuPernaPref($_REQUEST['perna']);
			$this->SetUsuPernaAuto('0');
		}
		
		if($this->UpPerna())
		{
			return 'ok';
		} else {
			return 'nao';
		}
	}
	
	public function referidos()
	{
		$res['um'] = $this->GetReferidos($_SESSION['usuario']['usu_doc']);
		
		$consultar = $this->PreparaIn($res['um']);
// 		echo $consultar;die;
		$res['dois'] = $this->GetReferidos($consultar);
		
		$consultar = $this->PreparaIn($res['dois']);
		
		$res['tres'] = $this->GetReferidos($consultar);
		
		$consultar = $this->PreparaIn($res['tres']);
		
		$res['quatro'] = $this->GetReferidos($consultar);
		
		return $res;
			
	}
	
	public function PreparaIn($in)
	{
		foreach ($in as $one)
		{
			$consultar[] = $one['usu_doc'];				
		}
		
		$consultar = implode('\', \'', $consultar);
		
		return $consultar;
	}
	
	public function matriz()
	{
		if(isset($_POST['usu_usuario'])) 
		{
			$this->SetUsuUsuario($_POST['usu_usuario']);			
			$usu_doc = $this->SelectOne();

			$matriz['pai'] = $this->GetRedePai($usu_doc);
			$matriz['rede'] = $this->GetRede($usu_doc);					
			$matriz['fones'] = $this->GetRedeFones($usu_doc);
			$matriz['comer'] = $this->GetRedeComercial($usu_doc);
			$matriz['cel'] = $this->GetRedeCelular($usu_doc);
			$matriz['wats'] = $this->GetRedeWaths($usu_doc);
			
		}
		elseif(isset($_POST['usu_subir'])) 
		{			
		    $matriz['pai'] = $this->subirNivel($_POST['usu_subir']);
			$matriz['rede'] = $this->GetRede($_POST['usu_subir']);
			$matriz['fones'] = $this->GetRedeFones($_POST['usu_subir']);
			$matriz['comer'] = $this->GetRedeComercial($_POST['usu_subir']);
			$matriz['cel'] = $this->GetRedeCelular($_POST['usu_subir']);
			$matriz['wats'] = $this->GetRedeWaths($_POST['usu_subir']);			
			
			if(!empty($matriz['pai']) && !empty($matriz['rede'])){
				
			  $matriz['pai'] = $this->subirNivel($_POST['usu_subir']);
			  $matriz['rede'] = $this->GetRede($_POST['usu_subir']);
			  $matriz['fones'] = $this->GetRedeFones($_POST['usu_subir']);	
			  $matriz['comer'] = $this->GetRedeComercial($_POST['usu_subir']);
			  $matriz['cel'] = $this->GetRedeCelular($_POST['usu_subir']);
			  $matriz['wats'] = $this->GetRedeWaths($_POST['usu_subir']);		
			
			}else{
			  $matriz['pai'] = $this->subirNivel($_SESSION['usuario']['usu_doc']);
			  $matriz['rede'] = $this->GetRede($_SESSION['usuario']['usu_doc']);	
			  $matriz['fones'] = $this->GetRedeFones($_SESSION['usuario']['usu_doc']);	
			  $matriz['comer'] = $this->GetRedeComercial($_SESSION['usuario']['usu_doc']);
			  $matriz['cel'] = $this->GetRedeCelular($_SESSION['usuario']['usu_doc']);
			  $matriz['wats'] = $this->GetRedeWaths($_SESSION['usuario']['usu_doc']);		
			}
			
		}
		
		else{			
		    $matriz['pai']   = $this->GetRedePai($_SESSION['usuario']['usu_doc']);	
			$matriz['rede']   = $this->GetRede($_SESSION['usuario']['usu_doc']);
			$matriz['fones'] = $this->GetRedeFones($_SESSION['usuario']['usu_doc']);	
			$matriz['comer'] = $this->GetRedeComercial($_SESSION['usuario']['usu_doc']);
			$matriz['cel'] = $this->GetRedeCelular($_SESSION['usuario']['usu_doc']);
			$matriz['wats'] = $this->GetRedeWaths($_SESSION['usuario']['usu_doc']);		
			
		}
		 
		 return $matriz;
	}
	

	
	public function __call($metodo,$argumanto)
	{
		return 'erro';
	
	}
	
	
	
}