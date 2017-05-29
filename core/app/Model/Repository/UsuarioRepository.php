<?php 

abstract class UsuarioRepository
{

	public $banco;
	
	public function __construct() {
		
		global $array_db;
		
		$db = $array_db['db'];

		$this->banco = Banco::conecta('pgsql',$db);

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
	
	public function SelectOne()
	{
		try{
			
			$query = $this->banco->conexao->prepare("
					SELECT usu_doc FROM public.tb_usuarios
					where (usu_usuario)::text = (?)::text");
			
			
			$campos = array($this->GetUsuUsuario());
			
			
			$query->execute($campos);
			
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			
			if(!empty($res[0])){
			
			//echo "<pre>"; print_r($res[0]['usu_doc']);die;
			
				return $res[0]['usu_doc'];
			
			} else {
				return $_SESSION['usuario']['usu_doc'];
			}
			
		} catch (PDOException $e){

			$msg = 'Erro ao Selecionar Usuario: ' . $e->getMessage();
			$this->banco->log($msg);
		}
		
	}
	
	public function SelectAtivo()
	{
		
		try{
	
			$query = $this->banco->conexao->prepare("
					SELECT usu_doc FROM public.tb_usuarios
					where (usu_usuario)::text = (?)::text AND (fk_status)::text = (?)::text");
	
	
			$campos = array($this->GetUsuUsuario(),2);
	
	
			$query->execute($campos);
	
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
	
			if(!empty($res[0])){
					
				// 			print_r($res[0]['usu_doc']);die;
				return $res[0]['usu_doc'];
					
			} else {
				return $_SESSION['usuario']['usu_doc'];
			}
	
		} catch (PDOException $e){
	
			$msg = 'Erro ao Selecionar Usuario Ativo: ' . $e->getMessage();
			$this->banco->log($msg);
		}
	
	}
	
	
	public function SelectSearch($doc)
	{
	
		try{
				
			$query = $this->banco->conexao->prepare("
					SELECT fk_usu_rede FROM tb_usuarios
					where (usu_doc)::text = (?)::text");
				
				
			$campos = array($doc);
				
				
			$query->execute($campos);
				
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
				
				
			if(!empty($res[0])){
					

				return $res[0]['fk_usu_rede'];
					
			} else {
				return $_SESSION['usuario']['usu_doc'];
			}
				
		} catch (PDOException $e){
	
			$msg = 'Erro ao Selecionar Usuario: ' . $e->getMessage();
			$this->banco->log($msg);
		}
	
	}
	
	public function Search4x4($doc)
	{
	
		try{
	
			$query = $this->banco->conexao->prepare("
					SELECT usu_upline FROM tb_usuarios
					where (usu_doc)::text = (?)::text");
	
	
			$campos = array($doc);
	
	
			$query->execute($campos);
	
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
	
	
			if(!empty($res[0])){
					
	
				return $res[0]['usu_upline'];
					
			} else {
				return $_SESSION['usuario']['usu_doc'];
			}
	
		} catch (PDOException $e){
	
			$msg = 'Erro ao Selecionar Usuario: ' . $e->getMessage();
			$this->banco->log($msg);
		}
	
	}
	
	public function SelectFkUsu($table) {
	
		try{
				
			$query = $this->banco->conexao->prepare("
					SELECT * FROM $table
					where (fk_usu)::text = (?)::text");
				
				
			$campos = array($_SESSION['usuario']['usu_doc']);
				
				
			$query->execute($campos);
				
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
				
				
			if(!empty($res[0])){
					
				return $res;
					
			} else {
				
				return false;
				
			}
				
		} catch (PDOException $e){
	
			$msg = 'Erro ao Selecionar fk_usu Usuario: ' . $e->getMessage();
			$this->banco->log($msg);
		}
	
	}
	
	public function LoginUser() {
		
		if( $_SESSION['captcha'] == $_POST['captcha']){

		Try{

			$query_logar = $this->banco->conexao->prepare("
													SELECT usu_doc, fk_status, usu_usuario FROM public.tb_usuarios
													where (usu_usuario)::text = (?)::text and (usu_senha)::text = (?)::text");
	
				$campos = array($this->GetUsuEmail(),$this->GetUsuSenha());
				
				$query_logar->execute($campos);
	
				$res = $query_logar->fetchAll(PDO::FETCH_ASSOC);
				
					if(!empty($res[0])){		
						        $_SESSION['usuario'] = $res[0];					

								header('location:../Backoffice/home_msr');
								
						if($res[0]['fk_status'] == 3)
						{
							header('location:../Backoffice/confirmanoCadastro');
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
		
	
	}
	
	public function LoginUserAdm() {

		try{
			$query_logar = $this->banco->conexao->prepare("
													SELECT usu_doc FROM public.tb_usuarios
													where (usu_usuario)::text = (?)::text and (usu_senha)::text = (?)::text");
	
	
				$campos = array($this->GetUsuEmail(),$this->GetUsuSenha());

				$query_logar->execute($campos);
	
				$res = $query_logar->fetchAll(PDO::FETCH_ASSOC);
	
				
					if(!empty($res[0])){
								
								$_SESSION['usuario'] = $res[0];
								
								$this->CriarArquivo();
	
							
	
					header('location:../Adm/home_adm');
	
					} else {	
						
						return false;
							
					}
					
		} catch (PDOException $e){

			$msg = 'Erro ao Logar: ' . $e->getMessage();
			$this->banco->log($msg);
		}
		
	
	}

	public function AutoAtivar() 
	{
		try{
			$doc   = $this->GetUsuDoc();
			$auto   = $this->GetUsuAutoAtivacao();
			
			$this->banco->editar('tb_usuarios', array( 'usu_auto_ativacao' => "{$auto}"), "usu_doc = '{$doc}'");
			
			$this->CriarArquivo();
			
			return true;

		} catch (PDOException $e){
			
			$msg = 'Erro ao Atualizar perna: ' . $e->getMessage();
			$this->banco->log($msg);
			return false;
		}
	}

	public function UpPerna() 
	{
		try{
			
			$perna = $this->GetUsuPernaPref();
			$doc   = $this->GetUsuDoc();
			$auto   = $this->GetUsuPernaAuto();
			
			$this->banco->editar('tb_usuarios', array( 'usu_perna_pref' => "{$perna}", 'usu_perna_auto' => "{$auto}"), "usu_doc = '{$doc}'");
			
			$this->CriarArquivo();
			
			return true;

		} catch (PDOException $e){
			
			$msg = 'Erro ao Atualizar perna: ' . $e->getMessage();
			$this->banco->log($msg);
			return false;
		}
	}
	

	public function ValidaEmail() {
		$email = $this->GetUsuEmail();
	
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		} else {
			return false;
		}
	}
	
	public function ValidaSenha() {
		$usu_doc = $this->GetUsuDoc();
		$senha = $this->GetUsuSenha();

		$query_logar = $this->banco->conexao->prepare("SELECT tb_usuarios.usu_doc 
														FROM tb_usuarios 
														WHERE( (tb_usuarios.usu_senha)::text = (?)::text ) AND 
															( (tb_usuarios.usu_doc)::text = (?)::text )");

		$campos = array($this->GetUsuSenha(),$this->GetUsuDoc());
		$query_logar->execute($campos);
		$res = $query_logar->fetchAll(PDO::FETCH_ASSOC);		

		if(!empty($res[0])){
			return true;
		} else {
			return false;	
		}
	}
	
	public function AlterarSenhaUsu()
	{
		//593caf9bc62140a37024c731cf9a5414
		$usu 	= $this->GetUsuDoc();
		$senha 	= $this->GetUsuSenha();
		$campo  = array(
				'usu_senha'=>$senha
		);
		
		$this->banco->editar('public.tb_usuarios',$campo, "usu_doc = '{$usu}'");
		
		return true;
	}

	
	public function VerMaiorIdade()
	{
		list($dia_nasc, $mes_nasc, $ano_nasc) = explode("/", $this->banco->UsPt($this->GetUsuDatanasc()));
		list($dia_hoje, $mes_hoje, $ano_hoje) = explode("/", date("d/m/Y", time()));
		
		if ( mktime(23, 59, 59, $mes_nasc, $dia_nasc, $ano_nasc) < mktime(00, 00, 00, $mes_hoje, $dia_hoje, $ano_hoje - 18) ) {
			return true;
		} else {
			return false;
		}
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
		unset($filders['usu_logo']);
		return $filders;
	}
	
	public function ValidaSexo()
	{
		$sexo = $this->GetUsuSexo();
		
		if($sexo == 'm' or $sexo == 'f')
		{
			return true;
		}else{
			return false;
		}
	}
	
	public  function CriarArquivo()
	{
		
		$user = $_SESSION['usuario']['usu_doc'];
		$cliente = $_SESSION['cliente']['usu_usuario'];
		
				$query_usu = $this->banco->conexao->prepare("
													SELECT * FROM tb_usuarios
													where (usu_doc)::text = (?)::text");
	
	
				$campos = array($user);
	
	
				$query_usu->execute($campos);
	
				$res = $query_usu->fetchAll(PDO::FETCH_ASSOC);
				
				unset($res[0]['usu_senha']);
				$res[0]['usu_datanasc'] = $this->banco->UsPt($res[0]['usu_datanasc']);
		
		$texto = '<?php ';
		
		$texto .= '$array_global = array(';
		$texto .= "'usuario' => array( ";
		
		foreach($res[0] as $key => $dados)
		{
			
			$texto .= "'{$key}'=>'{$dados}',";
			
		}
		$texto .= ' )';
		
		$tabelas = array(
					'endereco'=>'tb_endereco',
					'pj'=>'tb_pj',
				);
		
		foreach ($tabelas as $key => $tabela)
		{
			if(($res = $this->SelectFkUsu($tabela)) != false)
			{
				unset($res[0]['fk_usu']);
					
				$texto .= ',';
					
				$texto .= "'{$key}' => array( ";
					
				foreach($res[0] as $key => $dados)
				{
						
					$texto .= "'{$key}'=>'{$dados}',";
						
				}
				$texto .= ' )';
			}
		}
		
		
				
		$texto .= ');';
		
		$arquivo = 'module/'.$cliente.'/config/'.$user.'.php';
		
		if($arquivo = fopen($arquivo, "w"))
			{
		
				fputs($arquivo, $texto);

				fclose($arquivo);
			}
		
	}
	
	public function ValidaCpf($cpf)
	{
		
			$cpf = $this->GetUsuDoc();
		
			$cpf = str_replace('-', '', str_replace('.', '', $cpf));
			
			//Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cpf em diferentes formatos como "000.000.000-00", "00000000000", "000 000 000 00" etc...
			$j=0;
			
			for($i=0; $i<(strlen($cpf)); $i++)
			{
				if(is_numeric($cpf[$i]))
					
				{
					$num[$j]=$cpf[$i];
						$j++;
				}
			}
			//Etapa 2: Conta os dígitos, um cpf válido possui 11 dígitos numéricos.
			if(count($num)!=11)
			{
				$isCpfValid=false;
			}
		//Etapa 3: Combinações como 00000000000 e 22222222222 embora não sejam cpfs reais resultariam em cpfs válidos após o calculo dos dígitos verificares e por isso precisam ser filtradas nesta parte.
			else
			{
				for($i=0; $i<10; $i++)
				{
					if ($num[0]==$i && $num[1]==$i && $num[2]==$i && $num[3]==$i && $num[4]==$i && $num[5]==$i && $num[6]==$i && $num[7]==$i && $num[8]==$i)
					{
						$isCpfValid=false;
						
						break;
					}
				}
			}
			//Etapa 4: Calcula e compara o primeiro dígito verificador.
			if(!isset($isCpfValid))
			{
				$j=10;
				
				for($i=0; $i<9; $i++)
				{
					$multiplica[$i]=$num[$i]*$j;
					$j--;
				}
					
				$soma = array_sum($multiplica);
				
				$resto = $soma%11;
				
					if($resto<2)
					{
						$dg=0;
					}
					else
					{
						$dg=11-$resto;
					}
					if($dg!=$num[9])
					{
						$isCpfValid=false;
					}
			}
		//Etapa 5: Calcula e compara o segundo dígito verificador.
		if(!isset($isCpfValid))
		{
			$j=11;
				for($i=0; $i<10; $i++)
				{
					$multiplica[$i]=$num[$i]*$j;
					$j--;
				}
				
			$soma = array_sum($multiplica);
			
			$resto = $soma%11;
			
				if($resto<2)
				{
					$dg=0;
				}
				else
				{
					$dg=11-$resto;
				}
				if($dg!=$num[10])
				{
					$isCpfValid=false;
				}
				else
				{
					$isCpfValid=true;
				}
		}
		
		
		if($isCpfValid == true){
		
		return true;
		
		}else
		{
				return false;
		}
		
	}
	
	 
	
	public function novo_cadastro($array){
	
		try{
// 			echo '<pre>';print_r($array);die;
			$this->banco->conexao->beginTransaction();
				
	
			$this->banco->inserir('tb_usuarios',$array['usuario']);
			$this->banco->inserir('tb_endereco',$array['endereco']);
	
	
			//$npedido = $this->add_ped($array);
	
			//$sqlPed = "SELECT * FROM tb_pedidos WHERE ( ped_id = '".$npedido."' )";
			//$resPed = $this->banco->executar( $sqlPed );
			
			//$res = $this->banco->ver('public.vw_novo_cad', '*',"usu_doc = '{$array['usuario']['usu_doc']}' order by ped_id DESC");
			//$res = $this->banco->ver('public.vw_novo_cad', '*',"(usu_doc = '".$array['usuario']['usu_doc']."') and (ped_sessao = '".$array['sessao']."')");
	
			$this->banco->conexao->commit();
			
			/* $sql = "SELECT usu_id FROM tb_usuarios WHERE (usu_doc = '".$array['usuario']['usu_doc']."' )";
			$resId = $this->banco->executar($sql); */
						
			
						
			session_regenerate_id();
			
			/* $res['usu_id'] = $resId;
			$res['pedido'] = $resPed[0]; */
			
			return true;
	
		}catch (PDOException $e){
	
			$msg = $e->getMessage();
	
			$this->banco->conexao->rollBack();
	
			$this->banco->log($msg);
			
			return false;
	
		}
	
	}
	
public function add_ped($dados)
	{
// 		echo '<pre>';print_r($dados);die;
		session_regenerate_id();
		
		//$usu 		= $dados['pedido']['fk_usu'];
		
		$usu        = $this->GetUsuDoc();
	
		$cod 		= $dados['pedido']['fk_bonus'];
		$transid	= $this->Transid($usu);
	
		$ip = Controller::$ip;
		$browser = Controller::$browser;
	
		try{
				$res = $this->banco->executar("SELECT c.carac_valor, b.bn_pontos, fk_prod, p.pro_id
						FROM public.tb_caracteristicas c
						INNER JOIN public.tb_bonus b ON c.fk_bonus = b.bn_id
						INNER JOIN public.tb_produtos p ON p.pro_cod::text = c.fk_prod::text
						WHERE c.fk_prod::text = '{$cod}'::text");
				
				
				
				$pedido = array('fk_usu'=>$usu,
										'ped_transid'=>$transid, 
										'ped_sessao'=>session_id(),
										'ped_ip'=>$ip,
										'fk_status'=>2,
										'ped_total'=>$res[0]['carac_valor'],
										'ped_browser'=>$browser,
										'ped_tipo'=> $dados['pedido']['ped_tipo'],
										'ped_valor_frete' => $dados['pedido']['ped_valor_frete']
									);
				
			$npedido = $this->banco->inserir('public.tb_pedidos',$pedido,'tb_pedidos_ped_id_seq');
						
			$carrinho = array('fk_prod'=>$res[0]['fk_prod'],
										'cart_valor'=>$res[0]['carac_valor'],
										'fk_sessao'=>session_id(),
										'cart_pontos'=>$res[0]['bn_pontos'],
										'fk_carac'=>$res[0]['pro_id'],
									);
			
			$this->banco->inserir('tb_carrinho',$carrinho);
			
			session_regenerate_id();
			
			return array('transid' => $transid, 'valor' => $res[0]['carac_valor']+$dados['pedido']['ped_valor_frete']);
						
		}catch (PDOException $e){
	
			$msg = $e->getMessage();
			echo 'erro '.$msg;die;
		}
	
	
	
	
					
	
	}
	
	public function cadastro_4x4($array)
	{
	
		try{
	
			$this->banco->conexao->beginTransaction();
	
	
			$this->banco->inserir('tb_usuarios',$array['usuario']);
			$this->banco->inserir('tb_endereco',$array['endereco']);
			$this->banco->inserir('tb_dados_banco',$array['banco']);
			$this->banco->editar('tb_usuarios',$array['upline'],"usu_doc = '{$array['usuario']['usu_upline']}'");
	
			$query = "SELECT u.usu_usuario, u.usu_nome, u.usu_doc, up.usu_super_conta,
			up.usu_paypal, up.usu_pagseguro, up.usu_usuario as upline,nb.cod_nome, b.*
			FROM tb_usuarios u
			INNER JOIN tb_usuarios up ON u.usu_upline = up.usu_doc
			INNER JOIN tb_dados_banco b ON u.usu_upline = b.fk_usu
			INNER JOIN tb_banco nb ON b.banco_code = nb.cod_code
			WHERE u.usu_doc = '{$array['usuario']['usu_doc']}' order by u.usu_id DESC";
	
			//echo $query;die;
			$res = $this->banco->executar($query);
				
	
			$this->banco->conexao->commit();
			session_regenerate_id();
				
			return $res[0];
	
		}catch (PDOException $e){
	
		$msg = $e->getMessage();
	
		$this->banco->conexao->rollBack();
	
		$this->banco->log($msg);
			
		return false;
	
		}
	
		}
	
	public function RedeLinear()
	{
		
			
			
			/*	
			$query = $this->banco->conexao->prepare("
					
					WITH RECURSIVE familia (usu_id, usu_doc, usu_usuario, parente, nivel, path) AS
                    (
                        SELECT 
                            u1.usu_id, u1.usu_doc, u1.usu_usuario, (select usu_id from tb_usuarios where usu_doc = u1.fk_usu), 1 AS nivel, array[u1.usu_id]
                        FROM tb_usuarios AS u1
                        WHERE 
                            u1.usu_doc = ?
                        UNION ALL
                        SELECT 
                            u2.usu_id, u2.usu_doc, u2.usu_usuario, (select usu_id from tb_usuarios where usu_doc = u2.fk_usu), f.nivel + 1 AS nivel, (f.path || u2.usu_id)
                        FROM tb_usuarios AS u2
                        INNER JOIN familia AS f ON u2.fk_usu = f.usu_doc
                        WHERE
                            f.nivel < 50
                    )
                    SELECT 
                        *
                    FROM 
                    familia
                    
                    
                    
					
					");
				
				
			$campos = array($_SESSION['usuario']['usu_doc']);
				
				
			$query->execute($campos);
				
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($res[0]['usu_usuario'])){
				$retorno = array();
				foreach( $res as $key => $value ) {
					if( !empty( $value['parente'] ) ) {
						$retorno[$value['parente']][$value['usu_doc']]['doc'] 		= $value['usu_doc'];
						$retorno[$value['parente']][$value['usu_doc']]['usuario'] 	= $value['usu_usuario'];
						$retorno[$value['parente']][$value['usu_doc']]['nivel'] 	= $value['nivel'];
						$retorno[$value['parente']][$value['usu_doc']]['pai'] 		= $value['parente'];
					} else {
						$retorno[0][$value['usu_doc']]['doc'] 		= $value['usu_doc'];
						$retorno[0][$value['usu_doc']]['usuario'] 	= $value['usu_usuario'];
						$retorno[0][$value['usu_doc']]['nivel'] 	= $value['nivel'];
						$retorno[0][$value['usu_doc']]['pai'] 		= $value['parente'];
				}
				}
				
				$res = array( 'res' => $res, 'retorno' => $retorno );
				return $res;
					
			} else {
				return false;
			}
				*/
				
				//print_r( $_SESSION );
		
	}
	
	public function RedeLinearJson()
	{
		
		$query = $this->banco->conexao->prepare("					
					WITH RECURSIVE familia (usu_id, usu_doc, usu_usuario, datacadastro, carreira, usu_email, end_cidade, end_uf, fone_fone, parente, nivel, path) AS
                    (
                        SELECT 
                            u1.usu_id, u1.usu_doc, u1.usu_usuario, to_char(u1.usu_data, 'DD/MM/YYYY'), ca1.ca_nome, u1.usu_email, end1.end_cidade, end1.end_uf, (select fn1.fone_fone from tb_fone as fn1 where fn1.fk_usu = u1.usu_doc AND fn1.fk_tipo = '3' LIMIT 1), (select usu_doc from tb_usuarios where usu_doc = u1.fk_usu), 0 AS nivel, array[u1.usu_id]
                        FROM tb_usuarios AS u1 
						INNER JOIN tb_carreira AS ca1 ON ca1.ca_id = u1.fk_carreira 
						LEFT JOIN tb_endereco AS end1 ON end1.fk_usu = u1.usu_doc 
                        WHERE 
                           ( u1.usu_doc = ? ) AND 
						   ( u1.fk_status IN ('2', '3' )) 
                        UNION ALL
                        SELECT 
                            u2.usu_id, u2.usu_doc, u2.usu_usuario, to_char(u2.usu_data, 'DD/MM/YYYY'), ca2.ca_nome, u2.usu_email, end2.end_cidade, end2.end_uf, (select fn2.fone_fone from tb_fone as fn2 where fn2.fk_usu = u2.usu_doc AND fn2.fk_tipo = '3' LIMIT 1), (select usu_doc from tb_usuarios where usu_doc = u2.fk_usu), f.nivel + 1 AS nivel, (f.path || u2.usu_id)
                        FROM tb_usuarios AS u2 
						INNER JOIN tb_carreira AS ca2 ON ca2.ca_id = u2.fk_carreira 
                        INNER JOIN familia AS f ON u2.fk_usu = f.usu_doc 
						LEFT JOIN tb_endereco AS end2 ON end2.fk_usu = u2.usu_doc 
                        WHERE
                            ( f.nivel < 50 ) AND 
							( u2.fk_status IN ('2', '3') ) 
                    )
                    SELECT 
                        *
                    FROM 
                    familia	
					ORDER BY usu_id ASC");
				
		$campos = array($_SESSION['usuario']['usu_doc']);
		$query->execute($campos);
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		//echo "oi";
		//echo "<pre>"; print_r( $res ); echo "</pre>";
		
		$retorno = array();
		foreach( $res AS $value ) {
			$retorno[] = $value;
		}
		
		$res = array( 'res' => $retorno );

		return $res;
	}
	
	public function Derrama4x4(&$pais,&$resultado=1,&$filhos=null)
	{
		foreach($pais as $pai)
		{
			$query = "SELECT usu_doc, usu_um, usu_dois, usu_tres, usu_quatro FROM public.tb_usuarios WHERE usu_doc =  '{$pai}'";
			$res = $this->banco->executar($query);
				
			$conta = 0;
				
			foreach($res[0] as $key => $valor)
			{
				if($valor == null)
				{
					$resultado = array('usu_upline' => $pai, 'campo' => $key);
						
					return true;
						
				}else{
	
	
	
					$resultado = 1;
	
					if($conta >= 1)
					{
						//echo 's '.$key .' - ' .$valor.'<br>';
							
							
						$pais[] = $valor;
							
						/* if($conta >= 4){
							unset($pais[0]);
						echo '<pre>';print_r($pais);
						die;
						} */
							
						if($conta >= 4){
							unset($pais[0]);
						};
					}
					$conta++;
				}
			}
				
		}
	
	}
		
	public function DerramaBinario($indicador,&$usu_perna=null)
	{
	
		$res = array();
		
	
		$res = $this->banco->executar("SELECT usu_nome, usu_doc, usu_perna_pref, usu_perna_auto FROM tb_usuarios WHERE usu_doc = '{$indicador}'");
		
		
		
		if($usu_perna == null){
			
			
			if( $res[0]['usu_perna_auto'] ) {
				//VERIFICAÇÃO DA PERNA AUTOMATICA
				$rede = new Rede();
				$perna = $rede->pernaAtiva($indicador);
				$volumeBinario = array();
				$volume_dPrincipal = 0;
				$rede->GetVolumeBinario($volumeBinario, $perna['d'], NULL, $volume_dPrincipal);
					
				$volumeBinario = array();
				$volume_ePrincipal = 0;
				$rede->GetVolumeBinario($volumeBinario, $perna['e'], NULL, $volume_ePrincipal);
				//END VERIFICAÇÃO DA PERNA AUTOMATICA
				$pernaAutomatica = ( $volume_ePrincipal <= $volume_dPrincipal ) ? 'e' : 'd';
				$this->banco->editar('tb_usuarios', array( 'usu_perna_pref' => "{$pernaAutomatica}"), "usu_doc = '{$indicador}'");
				$res = $this->banco->executar("SELECT usu_nome, usu_doc, usu_perna_pref, usu_perna_auto FROM tb_usuarios WHERE usu_doc = '{$indicador}'");
			}
			
			$usu_perna = $res[0]['usu_perna_pref'];
		}
		
		
		
		if($usu_perna == 'e'){
			
			$perna = $this->esquerdo(	$res[0]['usu_doc']	);
		}
		elseif($usu_perna == 'd'){
			
			$perna = $this->direito(	$res[0]['usu_doc']	);
		}
	
		// echo '<pre>';print_r($perna);die; 9 8148 14579
	
		if($perna == 'vazio'){
			return array(
	
					'res'=>$res[0],
					'novo'=>$perna,
					'perna'=>$usu_perna
	
			);
		}else{
	
			return array(
	
					'res'=>false,
					'novo'=>$perna
	
			);
	
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
	
public function AtivarUsuario()
	{
		$perna 	= $this->GetUsuPerna();
		$rede 	= $this->GetFkUsuRede();
		$status = $this->GetFkStatus();
		$usu 	= $this->GetUsuDoc();
		
		$campo = array(
				'fk_status'=>$status,
				'usu_perna'=>$perna,
				'fk_usu_rede'=>$rede
		);
		
		$conta = new ContaCorrente;
		
		$conta->SetFkUsuDoc($usu);
		$conta->verificaContaUsuExiste();
		
		return $this->banco->editar('public.tb_usuarios',$campo, "usu_doc = '{$usu}'");
	}
	
	public function AlterarFkUsu()
	{
		$fk_usu 	= $this->GetFkUsu();
		$usu 		= $this->GetUsuDoc();
// 	echo $usu.' - '.$fk_usu;die;
		$campo = array(
				'fk_usu'=>$fk_usu
		);
	
		return $this->banco->editar('public.tb_usuarios',$campo, "usu_doc = '{$usu}'");
	}

	public function pernaAtiva($idUsu) {
		$sql = "SELECT tb_usuarios.usu_doc, 
						tb_usuarios.usu_perna 
				FROM tb_usuarios 
				WHERE( tb_usuarios.fk_usu_rede = '".$idUsu."' ) 
				ORDER BY tb_usuarios.usu_perna DESC";
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);
		$perna = array();
		
		if( isset( $res[0]['usu_doc'] ) ) {
			$perna[$res[0]['usu_perna']] = $res[0]['usu_doc'];
		}
		
		if( isset( $res[1]['usu_doc'] ) ) {
			$perna[$res[1]['usu_perna']] = $res[1]['usu_doc'];
		}
		
		if( !empty( $perna['d'] ) and !empty( $perna['e'] ) ) {
			$perna['ativo'] = true;
		} else {
			$perna['ativo'] = false;	
		}
		
		return $perna;
	}
	
	public function pernaAtivaQualificado($idUsu) {
		$sql = "SELECT tb_usuarios.usu_perna, 
						COUNT(*) AS total_perna 
				FROM tb_usuarios 
				WHERE( tb_usuarios.fk_usu = '".$idUsu."' AND  fk_status = 2 ) 
				GROUP BY tb_usuarios.usu_perna";
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);
		$perna = array();
		if( isset( $res[0]['usu_perna'] ) ) {
			$perna[$res[0]['usu_perna']] = $res[0]['total_perna'];
		}
		
		if( isset( $res[1]['usu_perna'] ) ) {
			$perna[$res[1]['usu_perna']] = $res[1]['total_perna'];
		}
		
		if( !empty( $perna['d'] ) and !empty( $perna['e'] ) ) {
			$perna['qualificado'] = true;
		} else {
			$perna['qualificado'] = false;	
		}
		
		return $perna;
	}
	
	public function usuarioAtivo($idUsu=NULL) {
		$sql = "SELECT tb_usuarios.fk_usu_rede
				FROM tb_usuarios ";
		if( $idUsu ) {
			$sql .= "WHERE ( tb_usuarios.usu_doc = '".$idUsu."' )";	
		}
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);

		if( ( !empty( $res[0]['fk_usu_rede'] ) ) or ( $idUsu == '00000000001' ) ) {
			return true;
		}

		return false;
	}
	
	/** BUSCA TODOS USUÁRIOS DA BASE */
	public function GetDadosUsuario($idUsu=NULL) {
		$sql = "SELECT tb_usuarios.usu_id, 
						tb_usuarios.usu_usuario, 
						tb_usuarios.usu_doc, 
						tb_usuarios.fk_usu, 
						tb_usuarios.fk_status, 
						tb_usuarios.fk_usu_rede, 
						tb_usuarios.fk_status, 
						tb_usuarios.usu_perna, 
						tb_carreira.ca_nome, 
						tb_carreira.ca_pontos, 
						tb_bonus.bn_nome, 
						tb_bonus.bn_rede_perc, 
						tb_bonus.bn_pontos, 
						tb_bonus.bn_cad_perc, 
						tb_usuarios.usu_perna_auto,
						tb_usuarios.usu_perna_pref
				FROM public.tb_usuarios 
				LEFT JOIN public.tb_carreira ON tb_carreira.ca_id = tb_usuarios.fk_carreira 
				LEFT JOIN public.tb_bonus ON tb_bonus.bn_id = tb_usuarios.fk_bonus ";
		if( $idUsu ) {
			$sql .= "WHERE ( tb_usuarios.usu_doc = '".$idUsu."' )";	
		}

		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]; //retorna em array
	}
		
	/** BUSCA TODOS USUÁRIOS DA BASE */
	public function GetUsuarios($idUsu=NULL) {
		$sql = "SELECT tb_usuarios.usu_id, 
						tb_usuarios.usu_usuario, 
						tb_usuarios.usu_doc, 
						tb_usuarios.fk_usu, 
						tb_usuarios.fk_status, 
						tb_usuarios.fk_usu_rede, 
						tb_usuarios.fk_status, 
						tb_usuarios.usu_perna, 
						tb_carreira.ca_nome, 
						tb_carreira.ca_pontos, 
						tb_bonus.bn_nome, 
						tb_bonus.bn_rede_perc, 
						tb_bonus.bn_pontos, 
						tb_bonus.bn_cad_perc, 
						tb_usuarios.usu_perna_auto 
				FROM tb_usuarios 
				LEFT JOIN tb_carreira ON tb_carreira.ca_id = tb_usuarios.fk_carreira 
				LEFT JOIN tb_bonus ON tb_bonus.bn_id = tb_usuarios.fk_bonus ";
		if( $idUsu ) {
			$sql .= "WHERE ( tb_usuarios.usu_doc = '".$idUsu."' AND tb_usuarios.usu_perna is not null AND tb_usuarios.fk_usu_rede is not null  )";	
		}

		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);
		
		if(!empty($res[0]))
		{
			$temp = $this->pernaAtiva( $res[0]['fk_usu_rede'] );
			$res[0]['perna'] = $temp;
		}else{
			return false;
		}
		
		
		
		return $res; //retorna em array
	}
	
	public function GetUsuariosComiss($idUsu=NULL) {
		$sql = "SELECT tb_usuarios.usu_id,
		tb_usuarios.usu_usuario,
		tb_usuarios.usu_doc,
		tb_usuarios.fk_usu,
		tb_usuarios.fk_status,
		tb_usuarios.fk_usu_rede,
		tb_usuarios.fk_status,
		tb_usuarios.usu_perna,
		tb_carreira.ca_nome,
		tb_carreira.ca_pontos,
		tb_bonus.bn_nome,
		tb_bonus.bn_rede_perc,
		tb_bonus.bn_pontos,
		tb_bonus.bn_cad_perc,
		tb_usuarios.usu_perna_auto
		FROM tb_usuarios
		LEFT JOIN tb_carreira ON tb_carreira.ca_id = tb_usuarios.fk_carreira
		LEFT JOIN tb_bonus ON tb_bonus.bn_id = tb_usuarios.fk_bonus ";
		if( $idUsu ) {
			$sql .= "WHERE ( tb_usuarios.usu_doc = '".$idUsu."' AND tb_usuarios.usu_perna is not null  )";
		}
	
		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);
	
		$temp = $this->pernaAtiva( $res[0]['usu_doc'] );
		
		$res[0]['perna'] = $temp;
		//print_r( $temp );
		
		return $res; //retorna em array
	}
	
	/** 
	BUSCA O USUARIO ACIMA, QUEM INDICOU 
	não encontrou acima, retorna FALSE
	$usuario é recebido por referência
	*/
	public function GetUsuarioAcimaComiss( &$usuario, $idUsu ) { //Busca usuario para comissao
		if( $idUsu ) {
			$consulta = $this->GetUsuariosComiss( $idUsu );
			if( isset( $consulta[0]['fk_usu'] ) and !empty( $consulta[0]['fk_usu'] ) ) {
				$usuario['indicado'] = $consulta[0];
				$consulta = $this->GetUsuariosComiss($consulta[0]['fk_usu']);
				$usuario['indicou'] = $consulta[0];
			} else {
				return false;	
			}
		}
	}
	
	public function GetUsuarioAcima( &$usuario, $idUsu ) {
		if( $idUsu ) {
			$consulta = $this->GetUsuarios( $idUsu );
			if( isset( $consulta[0]['fk_usu'] ) and !empty( $consulta[0]['fk_usu'] ) ) {
				$usuario['indicado'] = $consulta[0];
				$consulta = $this->GetUsuarios($consulta[0]['fk_usu']);
				$usuario['indicou'] = $consulta[0];
			} else {
				return false;
			}
		}
	}
	
	public function GetRedeBinaria( &$rede, $idUsu, $count, $idUsuStop=NULL ) {
		$count++;

		if( ( $count >= 100000 ) or empty( $idUsu ) or ( $idUsu == $idUsuStop ) or ( $idUsu == '00000000001' ) ) {
			if( !empty( $idUsuStop ) ) {
				$temp = $this->GetUsuarios($idUsu);
				$rede[] = $temp[0];
			}
			return false;
		} else {
			$temp = $this->GetUsuarios($idUsu);
			$rede[] = $temp[0];
			$idUsu = $temp[0]['fk_usu_rede'];
			//echo "rede ".$idUsu;
			$this->GetRedeBinaria($rede, $idUsu, $count, $idUsuStop );
		}
	}
	
	public function GetUsuariosLinear($idUsu=NULL) {
		$sql = "SELECT tb_usuarios.usu_id, 
						tb_usuarios.usu_doc, 
						tb_usuarios.fk_usu, 
						tb_usuarios.fk_status, 
						tb_usuarios.fk_usu_rede, 
						tb_usuarios.usu_perna,
						tb_usuarios.usu_qualif
				FROM tb_usuarios 
				";
		if( $idUsu ) {
			$sql .= "WHERE ( tb_usuarios.usu_doc = '".$idUsu."' AND tb_usuarios.usu_perna is not null  )";	
		}

		$ver = $this->banco->conexao->prepare($sql);
		$ver->execute();
		$res = $ver->fetchAll(PDO::FETCH_ASSOC);
		
		if(!empty($res[0]))
		{
			return $res;
		}else{
			return false;
		}
		
		
		
		 //retorna em array
	}
	
	public function GetRedeLinear( &$rede, $idUsu, $count=0 ) {
		
		
		
		if( ( $count == 8 ) or empty( $idUsu ) or ( $idUsu == '00000000001' ) ) {
			
				$temp = $this->GetUsuariosLinear($idUsu);
				$temp[0]['nivel'] = $count;
				$rede[] = $temp[0];
			
			return false;
		} else {
			
			$temp = $this->GetUsuariosLinear($idUsu);
			$count++;
			$rede[] = $temp[0];
			$idUsu = $temp[0]['fk_usu'];
			
			$this->GetRedeLinear($rede, $idUsu,$count );
		}
	}
	
	public  function BinarioAcimaRecursivo($usu)
	{
		$query = "WITH RECURSIVE familia (usu_doc, usu_perna, fk_usu_rede) AS
                    (
                        SELECT 
                            r1.usu_doc, r1.usu_perna, r1.fk_usu_rede
                        FROM tb_usuarios AS r1
                        WHERE 
                            r1.usu_doc = '{$usu}'
                        UNION ALL
                        SELECT 
                            r2.usu_doc, r2.usu_perna, r2.fk_usu_rede
                        FROM tb_usuarios AS r2
                        INNER JOIN familia f ON r2.usu_doc = f.fk_usu_rede   
                    )
                    SELECT 
                        f.usu_doc, f.usu_perna
                    FROM 
                    familia f ";
		
		$res = $this->banco->executar($query);
		
		return $res;
		
	}
	
	public function GetRede4x4($pai)
	{
			
		$query = $this->banco->conexao->prepare("
				SELECT u.usu_usuario, u.usu_nome, u.usu_doc, u.usu_email, c.ca_nome,
				u.usu_super_conta, u.usu_paypal, u.usu_pagseguro,
				u.usu_facebook, up.usu_usuario as upline, nb.cod_nome,
				um.usu_usuario as um,
				dois.usu_usuario as dois,
				tres.usu_usuario as tres,
				quatro.usu_usuario as quatro,
				u.usu_data, up.usu_nome as nome_up, b.*
				FROM tb_usuarios u
				INNER JOIN tb_usuarios up ON u.usu_upline = up.usu_doc
				LEFT JOIN tb_usuarios um ON u.usu_um = um.usu_doc
				LEFT JOIN tb_usuarios dois ON u.usu_dois = dois.usu_doc
				LEFT JOIN tb_usuarios tres ON u.usu_tres = tres.usu_doc
				LEFT JOIN tb_usuarios quatro ON u.usu_quatro = quatro.usu_doc
				INNER JOIN tb_carreira c ON u.fk_carreira = c.ca_id
				INNER JOIN tb_dados_banco b ON u.usu_doc = b.fk_usu
				INNER JOIN tb_banco nb ON b.banco_code = nb.cod_code
				where (u.usu_doc)::text = (?)::text order by u.usu_id DESC");
			
			
		$campos = array($pai);
			
			
		$query->execute($campos);
			
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
			
		return $res[0];
	
	}
	
	public function GetReferidos($dados)
	{
		return $this->banco->executar("SELECT u.*, up.usu_usuario as upline, p.usu_usuario as patriocinador, c.ca_nome, e.*
				FROM tb_usuarios u
				INNER JOIN tb_usuarios up ON u.usu_upline = up.usu_doc
				INNER JOIN tb_usuarios p ON u.fk_usu = p.usu_doc
				INNER JOIN tb_carreira c ON u.fk_carreira = c.ca_id
				INNER JOIN tb_endereco e ON e.fk_usu = u.usu_doc
				where (u.usu_upline)::text in ('{$dados}') order by u.usu_id DESC");
	}
	
	public function GetUpline4x4($doc)
	{
			
		$query = $this->banco->conexao->prepare("
				SELECT up.usu_usuario, up.usu_nome, up.usu_doc, up.usu_email, c.ca_nome,
				up.usu_super_conta, up.usu_paypal, up.usu_pagseguro,
				nb.cod_nome, up.usu_upline,
				up.usu_data, b.*
				FROM tb_usuarios u
				INNER JOIN tb_usuarios up ON u.usu_upline = up.usu_doc
				INNER JOIN tb_carreira c ON up.fk_carreira = c.ca_id
				INNER JOIN tb_dados_banco b ON up.usu_doc = b.fk_usu
				INNER JOIN tb_banco nb ON b.banco_code = nb.cod_code
				where (u.usu_doc)::text = (?)::text order by u.usu_id DESC");
			
			
		$campos = array($doc);
			
			
		$query->execute($campos);
			
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
			
		return $res[0];
	
	}
	
	public function GetDoacao4x4($doador, $recebedor, $nivel=null)
	{
			
		if($nivel == null)
		{
		$query = $this->banco->conexao->prepare("
				SELECT d.*, s.status_nome FROM tb_doacoes d
				INNER JOIN tb_status_doacoes s ON d.fk_status = s.status_id
				WHERE d.rpg_doador = (?)::text AND d.rpg_recebedor = (?)::text order by d.rpg_id desc");
		
		$campos = array($doador,$recebedor);
		
		}else{
			
			$query = $this->banco->conexao->prepare("
					SELECT d.*, s.status_nome FROM tb_doacoes d
					INNER JOIN tb_status_doacoes s ON d.fk_status = s.status_id
					WHERE d.rpg_doador = (?)::text AND d.rpg_recebedor = (?)::text AND d.rpg_nivel::text = (?)::text order by d.rpg_id desc");
			
			$campos = array($doador,$recebedor,$nivel);
			
		}
			
			
		
			
			
		$query->execute($campos);
			
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
			
		return $res[0];
	
	}
	
	
	public function GetVolumeBinario( &$rede, $idUsu, $perna, &$count ) {
		if( empty( $idUsu ) ) {
			return false;
		} else {
			$count++;
			$rede[$idUsu] = $this->pernaAtiva( $idUsu );
			if( !empty( $rede[$idUsu]['d'] ) ) {
				$this->GetVolumeBinario( $rede, $rede[$idUsu]['d'], 'd', $count );
			}
			
			if( !empty( $rede[$idUsu]['e'] ) ) {
				$this->GetVolumeBinario( $rede, $rede[$idUsu]['e'], 'e', $count );
			}
		}
	}
	
	public function photoUsu(){		
	 //$query = $this->banco->executar("SELECT usu_id, usu_logo FROM tb_usuarios WHERE usu_id= ".Backoffice::$idUsuPhoto.""); 
	 //return $query;
  }  
  
   public function resVolPontos(){		
   
   $query = $this->banco->executar("
   SELECT
        SUM(pt.pt_pontos) as pt_pontos
   FROM 
		financeiro.tb_pontos_".date("m_Y")." as pt,
		public.tb_usuarios as tb_usu
   WHERE
        tb_usu.usu_doc = pt.fk_usu");
   return $query;
  } 
  
 public function calcVolPontos(){
    $query = $this->banco->executar("
		SELECT
			SUM(pt.pt_pontos) as pt_pontos,
			pt.fk_usu              as fk_usu,
			tb_usu.usu_id          as usu_id,
			tb_usu.usu_usuario     as usu_usuario,
			tb_usu.usu_doc         as usu_doc
		FROM 
			 financeiro.tb_pontos_".date("m_Y")." as pt,
			 public.tb_usuarios as tb_usu
		WHERE 
			 tb_usu.usu_doc = pt.fk_usu AND
			 pt.fk_usu = pt.fk_usu_rede 			 
		GROUP BY pt.fk_usu,
				 tb_usu.usu_id,		
				 tb_usu.usu_usuario,
				 tb_usu.usu_doc");
   return $query; 
 }
 
    public function getAllUsu(){
	 $query = $this->banco->executar(" SELECT * FROM tb_usuarios ORDER BY usu_id ASC LIMIT ".Usuario::$numreg." OFFSET ".Usuario::$inicial."");
	  return $query;
	}
	
	public function getNumUsuRecruta($usu_doc = NULL){
	 $query = $this->banco->executar("SELECT * FROM public.tb_usuarios WHERE fk_usu = '$usu_doc' ORDER BY usu_id ASC");	 
	  return $query;
	}
    
	public function updateUsuario(){
//self::$usu_senhaSegUsu
      if(Usuario::$usu_senhaUsu == ""){
	    $usuarios = array(
	        "usu_id"=> Usuario::$idUsuUsu,
			"usu_nome"=>Usuario::$usu_nomeUsu,
			"usu_usuario"=>Usuario::$usu_usuarioUsu,
			"usu_datanasc"=>Usuario::$nascimentoUsu,
			"usu_sexo"=>Usuario::$sexoUsu,
			"usu_email"=>Usuario::$usu_emailUsu					  
	   );	
	   $this->banco->editar("public.tb_usuarios", $usuarios, "usu_id = '".Usuario::$idUsuUsu."'");	    
	   }
	  else{
	  $usuarios = array(
	        "usu_id"=> Usuario::$idUsuUsu,
			"usu_nome"=>Usuario::$usu_nomeUsu,
			"usu_usuario"=>Usuario::$usu_usuarioUsu,
			"usu_senha"=>$this->Password(Usuario::$usu_senhaUsu),
			"usu_datanasc"=>Usuario::$nascimentoUsu,
			"usu_sexo"=>Usuario::$sexoUsu,
			"usu_email"=>Usuario::$usu_emailUsu					  
	   );	
	 $this->banco->editar("public.tb_usuarios", $usuarios, "usu_id = '".Usuario::$idUsuUsu."'");	 
	 }
	 
	  if(Usuario::$usu_senhaSegUsu == ""){
	    $usuarios_seg = array(
	        "usu_id"=> Usuario::$idUsuUsu,
			"usu_nome"=>Usuario::$usu_nomeUsu,
			"usu_usuario"=>Usuario::$usu_usuarioUsu,
			"usu_datanasc"=>Usuario::$nascimentoUsu,
			"usu_sexo"=>Usuario::$sexoUsu,
			"usu_email"=>Usuario::$usu_emailUsu					  
	   );	
	   $this->banco->editar("public.tb_usuarios", $usuarios_seg, "usu_id = '".Usuario::$idUsuUsu."'");	    
	   }
	    else{
	  $usuarios_seg = array(
	        "usu_id"=> Usuario::$idUsuUsu,
			"usu_nome"=>Usuario::$usu_nomeUsu,
			"usu_usuario"=>Usuario::$usu_usuarioUsu,
			"usu_seguranca"=>$this->Password(Usuario::$usu_senhaSegUsu),
			"usu_datanasc"=>Usuario::$nascimentoUsu,
			"usu_sexo"=>Usuario::$sexoUsu,
			"usu_email"=>Usuario::$usu_emailUsu					  
	   );	
	  $this->banco->editar("public.tb_usuarios", $usuarios_seg, "usu_id = '".Usuario::$idUsuUsu."'");	 
	 }
     

	 $num = explode(",",Usuario::$endUsu);
	 
	 $end = array(				
	        "end_cep"=>Usuario::$end_cepUsu, 
			"end_end"=>Usuario::$endUsu,  
			"end_n"=>$num[1],      
			"end_comp"=>Usuario::$end_compUsu, 	
			"end_bairro"=>Usuario::$end_bairroUsu, 
			"end_cidade"=>Usuario::$end_cidadeUsu, 			
			"end_uf"=> Usuario::$end_ufUsu,	   
	   ); 	   
	   
	   $this->banco->editar("public.tb_endereco", $end, "fk_usu = '".Usuario::$usu_docUsu."'");
	   
	   $fone = array(
	     "fone_fone"=>Usuario::$foneUsu  
	   );
      $this->banco->editar("public.tb_fone", $fone, "fk_usu = '".Usuario::$usu_docUsu."'");	  

	}
	
	public function getSaldoAtual(){
    //echo "<pre>"; print_r($_SESSION['usuario']['usu_doc']); die;
		
	  $query = $this->banco->executar("
SELECT
	SUM(sa.sld_valor_credito - sa.sld_valor_debito) AS total,
	sa.fk_conta_corrente as fk_conta_corrente,
	cc.cta_numero        as cta_numero,    
	cc.fk_usu_doc        as fk_usu_doc 
FROM 
	banco.tb_saldo as sa,
	banco.tb_conta_corrente as cc
WHERE
    sa.fk_conta_corrente = cc.cta_numero AND
	cc.fk_usu_doc = '".$_SESSION['usuario']['usu_doc']."'
GROUP BY
sa.fk_conta_corrente,
cc.cta_numero,
cc.fk_usu_doc ");	 
	  return $query;	
	}

public function getPedidoUsuario(){
	
	$query = $this->banco->executar("
								SELECT 
									ped_id,
									fk_usu,
									ped_transid,
									ped_total
								FROM 
									public.tb_pedidos
								WHERE
									fk_usu= '".$_SESSION['usuario']['usu_doc']."'
									");
	return $query;
	
	}
	
	public function ativo_tipo($tipo,$usu=null)
	{
		$doc = ($usu == null) ? $_SESSION['usuario']['usu_doc'] : $usu;
	
		//Verifica o dia de aniversario da ativação
		$dia = $this->banco->executar("SELECT p.ped_data_pag FROM public.tb_pedidos p
				INNER JOIN public.tb_carrinho c ON c.fk_sessao = p.ped_sessao
				INNER JOIN public.tb_produtos pro ON c.fk_prod::text = pro.pro_id::text
				WHERE fk_usu = '{$doc}' AND fk_status = 3 AND pro.fk_tipo = {$tipo}
				GROUP BY p.ped_data_pag
				ORDER BY ped_data_pag ASC limit 1");
					
				return $dia[0]['ped_data_pag'];
	}
	
	public function data_ativo_binario($usu=null)
	{
		$doc = ($usu == null) ? $_SESSION['usuario']['usu_doc'] : $usu;
		
		//Verifica o dia de aniversario da ativação
		$dia = $this->banco->executar("SELECT p.ped_data_pag FROM public.tb_pedidos p
					INNER JOIN public.tb_carrinho c ON c.fk_sessao = p.ped_sessao
					INNER JOIN public.tb_produtos pro ON c.fk_prod::text = pro.pro_id::text
					WHERE fk_usu = '{$doc}' AND fk_status = 3 AND pro.fk_tipo in ('3','6') 
					GROUP BY p.ped_data_pag
					ORDER BY ped_data_pag ASC limit 1");
					
		$data_dia = $dia[0]['ped_data_pag'];
// 		echo 'data: '.$data_dia;die;
		$dia_dia = explode("-", $data_dia);
		
		
		//Verifica o ultimo mes de ativação
		$mes = $this->banco->executar("SELECT p.ped_data_pag FROM public.tb_pedidos p
				INNER JOIN public.tb_carrinho c ON c.fk_sessao = p.ped_sessao
				INNER JOIN public.tb_produtos pro ON c.fk_prod::text = pro.pro_id::text
				WHERE fk_usu = '{$doc}' AND fk_status = 3 AND pro.fk_tipo in ('3','6')
				GROUP BY p.ped_data_pag
				ORDER BY ped_data_pag DESC limit 1");
					
		$data_mes = $mes[0]['ped_data_pag'];
// 		echo 'data: '.$data_mes;die;
		$mes_mes = explode("-", $data_mes);
		
		
		$vence = mktime(0, 0, 0, $mes_mes[1] + 1, $dia_dia[2]+5, $mes_mes[0]);
		$atual = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		
		if($atual <= $vence){

			return date('d/m/Y', mktime(0, 0, 0, $mes_mes[1] + 1, $dia_dia[2], $mes_mes[0]));
				
		}else{

			return 'Você não está Ativo';
		
		
		}
	}
	
	public function data_ativo_matriz($usu=null)
	{
		$doc = ($usu == null) ? $_SESSION['usuario']['usu_doc'] : $usu;
	
		
		//Verifica o dia de aniversario da ativação
		$dia = $this->banco->executar("SELECT p.ped_data_pag FROM public.tb_pedidos p
					INNER JOIN public.tb_carrinho c ON c.fk_sessao = p.ped_sessao
					INNER JOIN public.tb_produtos pro ON c.fk_prod::text = pro.pro_id::text
					WHERE fk_usu = '{$doc}' AND fk_status = 3 AND pro.fk_tipo = 4 
					GROUP BY p.ped_data_pag
					ORDER BY ped_data_pag ASC limit 1");
					
		$data_dia = $dia[0]['ped_data_pag'];
// 		echo 'data: '.$data_dia;die;
		$dia_dia = explode("-", $data_dia);
		
		
		//Verifica o ultimo mes de ativação
		$mes = $this->banco->executar("SELECT p.ped_data_pag FROM public.tb_pedidos p
				INNER JOIN public.tb_carrinho c ON c.fk_sessao = p.ped_sessao
				INNER JOIN public.tb_produtos pro ON c.fk_prod::text = pro.pro_id::text
				WHERE fk_usu = '{$doc}' AND fk_status = 3 AND pro.fk_tipo = 4
				GROUP BY p.ped_data_pag
				ORDER BY ped_data_pag DESC limit 1");
					
		$data_mes = $mes[0]['ped_data_pag'];
// 		echo 'data: '.$data_mes;die;
		$mes_mes = explode("-", $data_mes);
		
		
		$vence = mktime(0, 0, 0, $mes_mes[1] + 1, $dia_dia[2]+5, $mes_mes[0]);
		$atual = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		
		if($atual <= $vence){

			return date('d/m/Y', mktime(0, 0, 0, $mes_mes[1] + 1, $dia_dia[2], $mes_mes[0]));
				
		}else{

			return 'Você não está Ativo';
		
		
		}
	}
	
	public function saldo_atual($conta)
	{
		$cred = $this->banco->executar("SELECT sum(m.mvm_valor) as valor FROM banco.tb_movimento  m
							INNER JOIN banco.tb_tipo_movimento t ON m.fk_tipo_movimento = t.tmv_id
							WHERE fk_conta_corrente = '{$conta}' AND t.tmv_cred_deb = 'c'");
						
		$deb = $this->banco->executar("SELECT sum(m.mvm_valor) as valor FROM banco.tb_movimento  m
							INNER JOIN banco.tb_tipo_movimento t ON m.fk_tipo_movimento = t.tmv_id
							WHERE fk_conta_corrente = '{$conta}' AND t.tmv_cred_deb = 'd'");
							
		$query = "UPDATE banco.tb_saldo SET sld_valor_credito = ".$cred[0]['valor'].", sld_valor_debito = ".$deb[0]['valor']." WHERE fk_conta_corrente = '{$conta}'";
									
				$this->banco->executar($query);
						
		return true;
		
		
	}
	
	public function getPontosPessoais()
	{  
	  $query = $this->banco->executar("
						SELECT 
							SUM(car.cart_qtd*car.cart_pontos) as pontos
						FROM
							public.tb_pedidos AS pe,
							public.tb_carrinho AS car
						WHERE 
							pe.fk_usu = '".$_SESSION['usuario']['usu_doc']."' AND
							car.fk_sessao = pe.ped_sessao AND pe.fk_status = 3");
	return $query;
	 
	}
	
	public function getUsuIndicou($usu)
	{  
	  $query = $this->banco->executar("
						SELECT rede_indicado FROM public.tb_rede
						WHERE usu_indicou = '".$usu."'");
	  return $query;
	 
	}
	
	
	public function DerramaRedes( &$pais, $indicado, &$resultado=1, $rede )
	{
		foreach($pais as $pai)
		{
			$list = $this->getUsuIndicou($pai);
			
			if( count($list) == $rede ){
				
				foreach ($list as $lista)
				{
				
				$pais[] = $lista['rede_indicado'];
				
				}
				
			}else{
				
				$resultado = array('usu_indicou' => $pai, 'rede_indicado' => $indicado);
				
				return true;
				
			}
	

	
		}
	
	}
	
	public function MatrizRede($usu)
	{
		$query = $this->banco->executar("
				WITH RECURSIVE familia (id, indicou, indicado, nivel) AS
                    (
                        SELECT 
                            r1.id, r1.usu_indicou, r1.rede_indicado, 1 AS nivel
                        FROM tb_rede AS r1
                        WHERE 
                            r1.usu_indicou = '{$usu}'
                        UNION ALL
                        SELECT 
                            r2.id, r2.usu_indicou, r2.rede_indicado, f.nivel + 1 AS nivel
                        FROM tb_rede AS r2
                        INNER JOIN familia AS f ON r2.usu_indicou = f.indicado
                        WHERE
                            f.nivel < 1  
                    ) 
                    SELECT 
						f.id, f.indicou, f.indicado, u.usu_usuario as usu_indicado, uu.usu_usuario as usu_indicou
					FROM familia AS f 
						INNER JOIN public.tb_usuarios u ON u.usu_doc = f.indicado
						INNER JOIN public.tb_usuarios uu ON uu.usu_doc = f.indicou");
		return $query;
	
	}
	
	public function GetUpRede($tamanho, $usu)
	{
		$query = $this->banco->executar("
				WITH RECURSIVE familia (id, indicou, indicado, nivel) AS
                    (
                        SELECT 
                            r1.id, r1.usu_indicou, r1.rede_indicado, 1 AS nivel
                        FROM tb_rede AS r1
                        WHERE 
                            r1.rede_indicado = '{$usu}'
                        UNION ALL
                        SELECT 
                            r2.id, r2.usu_indicou, r2.rede_indicado, f.nivel + 1 AS nivel
                        FROM tb_rede AS r2
                        INNER JOIN familia AS f ON r2.rede_indicado = f.indicou
												WHERE f.nivel <= '{$tamanho}'
  
                    ) 
                    SELECT 
												f.*
										FROM familia AS f 
										INNER JOIN public.tb_usuarios u ON u.usu_doc = f.indicou
										WHERE u.fk_bonus != 1
										ORDER BY f.nivel ASC");
				return $query;
	
	}
	
	public function GetRede($usu)
	{
		$query = $this->banco->executar("
		      SELECT 
				  r1.usu_id, r1.usu_doc,
				  r1.usu_sexo, r1.fk_carreira,
				  r1.usu_usuario, to_char(r1.usu_data, 'DD/MM/YYYY') as usu_data,
				  r1.fk_usu_rede, r1.usu_nome, r1.usu_email,r1.fk_status
			  FROM tb_usuarios AS r1
			  WHERE 
			  	r1.fk_usu_rede = '$usu' ORDER BY r1.usu_id ASC LIMIT 5");
				return $query;
	
	}
	
	
	public function GetRedePai($usu)
	{
		$query = $this->banco->executar("
		      SELECT 
				  r1.usu_id, r1.usu_doc,
				  r1.usu_sexo, r1.fk_carreira, r1.fk_status,
				  r1.usu_usuario, to_char(r1.usu_data, 'DD/MM/YYYY') as usu_data,
				  r1.fk_usu_rede, r1.usu_nome, r1.usu_email,r1.fk_status
			  FROM tb_usuarios AS r1
			  WHERE 
			  	r1.usu_doc = '$usu' ORDER BY r1.usu_id ASC LIMIT 5
		");
				return $query;
	
	}
	
	public function subirNivel($usu)
	{
		$query = $this->banco->executar("
		      SELECT 
				  r1.usu_id, r1.usu_doc,
				  r1.usu_sexo, r1.fk_carreira,
				  r1.usu_usuario, to_char(r1.usu_data, 'DD/MM/YYYY') as usu_data,
				  r1.fk_usu_rede, r1.fk_status , r1.usu_nome, r1.usu_email
			  FROM tb_usuarios AS r1
			  WHERE 
			  	r1.usu_doc = '$usu' ORDER BY r1.usu_id ASC LIMIT 5
		");
	    
		return $query;
	
	}
	
	public function GetRedeFones($usu)
	{
		$query = $this->banco->executar("
		      SELECT 
				 *
			  FROM tb_fone
			  WHERE 
			  	fk_usu = '$usu' AND fk_tipo = 1");
				return $query;	
	}
	
	public function GetRedeComercial($usu)
	{
		$query = $this->banco->executar("
		      SELECT 
				 *
			  FROM tb_fone
			  WHERE 
			  	fk_usu = '$usu' AND fk_tipo = 2");
				return $query;	
	}
	
	public function GetRedeWaths($usu)
	{
		$query = $this->banco->executar("
		      SELECT 
				 *
			  FROM tb_fone
			  WHERE 
			  	fk_usu = '$usu' AND fk_tipo = 4");
				return $query;	
	}
	
	public function GetRedeCelular($usu)
	{
		$wats = $this->banco->executar("
		      SELECT 
				 *
			  FROM tb_fone
			  WHERE 
			  	fk_usu = '$usu' AND fk_tipo = 3");
				return $wats;	
	}
	
	
	
	public function PricipalBinario($usu)
	{
		$ver = $this->banco->conexao->prepare("SELECT u.usu_usuario, u.usu_nome, u.usu_doc, c.ca_nome, u.usu_sexo, 
														u.usu_email, u.fk_usu, to_char(u.usu_data, 'DD/MM/YYYY') as usu_data,   
														uu.usu_usuario as patrocionador, uuu.usu_usuario as upline, u.usu_perna_pref,
														u.usu_perna_auto, u.fk_status
														FROM tb_usuarios u
														LEFT JOIN tb_carreira c ON u.fk_carreira = c.ca_id
														LEFT JOIN tb_usuarios uu ON u.fk_usu = uu.usu_doc
														LEFT JOIN tb_usuarios uuu ON u.fk_usu_rede = uuu.usu_doc
														where u.usu_doc = ? AND (u.fk_status = 2)");
	
				$ver->execute(array($usu));
				$res = $ver->fetchAll(PDO::FETCH_ASSOC);
		
		return $res;
	
	}
	
	public function contaUsuPerna( $usu, $perna )
	{
	
		$query = $this->banco->executar("
				WITH RECURSIVE familia (usu_doc, parente) AS
				(
				SELECT
				r1.usu_doc, r1.fk_usu_rede
				FROM tb_usuarios AS r1
				WHERE
				r1.fk_usu_rede = '{$usu}' and r1.usu_perna = '{$perna}'
				UNION ALL
				SELECT
				r2.usu_doc, r2.fk_usu_rede
				FROM tb_usuarios AS r2
				INNER JOIN familia f ON r2.fk_usu_rede = f.usu_doc
	
				)
				SELECT
				count(f.usu_doc) as total
				FROM
				familia f");
	
	
				return $query[0]['total'];
	
	}
	
	public function PernaAutomatica( $usu )
	{
	
		$perna_e = $this->contaUsuPerna($usu, 'e');
		$perna_d = $this->contaUsuPerna($usu, 'd');
		
		$perna = ($perna_e <= $perna_d)?'e':'d';

		$usuario = $this->UltimoPerna($usu, $perna);
		
		return array('perna' => $perna, 'usuario' => $usuario);
	
	}
	
	public function UltimoPerna($usu, $perna)
	{
		$query = $this->banco->executar("
				WITH RECURSIVE familia (usu_doc, usu_perna, fk_usu_rede, nivel) AS
			(
					SELECT 
							r1.usu_doc, r1.usu_perna, r1.fk_usu_rede,  1 AS nivel
					FROM tb_usuarios AS r1
					WHERE 
							r1.fk_usu_rede = '{$usu}' AND r1.usu_perna = '{$perna}'

					UNION ALL

					SELECT 
							r2.usu_doc, r2.usu_perna, r2.fk_usu_rede, f.nivel + 1 AS nivel
					FROM tb_usuarios AS r2
					INNER JOIN familia f ON r2.fk_usu_rede = f.usu_doc
					WHERE r2.usu_perna = '{$perna}'
			)
			SELECT 
					f.usu_doc
			FROM 
			familia f 
			ORDER BY f.nivel DESC LIMIT 1");
			
			if(empty($query[0]))
			{
				
				return $usu;
				
			}else{
				return $query[0]['usu_doc'];
				
			}
	
	}
	
	public function loop_recursivo($array,$nivel=0,$histKey="") {
		$out = '';
		$bar = $separador;
		$nivel++;
		$out .= '<ul>';
		foreach($array as $value) {
			if(is_array($value)) {
		  $marcador = ($histKey) ? $histKey : '';
		  $out .= '<li>inicio<ul><li>' .$this->loop_recursivo($value,$nivel,$marcador.$key).'</li></ul>fim</li>';
			}else{
		  $out .= $value.'<br>';
			}
		}
		$out .= '</ul>';
		return $out;
	}
		 
 
	
	
	
	
	
}





