<?php
include_once('Banco.php');

class Controller extends Core{

public function __construct(){

		self::$ip 		= $_SERVER['REMOTE_ADDR'];
		self::$browser 	= $_SERVER['HTTP_USER_AGENT'];
		self::$page 	= $_SERVER['REQUEST_URI'];
		if(((isset($_SERVER['HTTP_REFERER']))) && (!empty($_SERVER['HTTP_REFERER']))){self::$referer = $_SERVER['HTTP_REFERER'];}
		
		global $array_global;
		
		global $config;
		
		self::$config = $config;
		
		global $template;
		
		self::$dados_usu 		= $array_global;

		$this->dados['usuario'] = self::$dados_usu;

		$this->parametros();
		
		
		self::$cliente = $this->Cliente();
		
		
		if( isset( $_SESSION['usuario'] ) && !empty($_SESSION['usuario'])) {


		$key = $this->GetClasseMetodo();

		$classe = $key['classe'];
		$metodo = $key['metodo'];
		
		$this->dados['javascript'] = $this->getJs();			
		//if( method_exists( $this, $metodo ) ) { $this->$metodo(); }else{$this->template = 'template';}


			if( $classe == 'Backoffice' && $metodo == 'login') {

				//echo $metodo;die;
				$classe = 'Backoffice';
				$metodo = 'home_msr';
				$this->classe = $classe;
				$this->metodo = $metodo;
				
			}
			
			if( $classe == 'Adm' && $metodo == 'login_adm') {
			
				//echo $metodo;die;
				$classe = 'Adm';
				$metodo = 'home_adm';
				$this->classe = $classe;
				$this->metodo = $metodo;
			
			}
			
			$this->dados['model'] = $this->GetModel($this->metodo);
			
				if($this->dados['model'] == 'erro')
				{
					
					$this->metodo = 'erro';

					$metodo = 'erro';
					
					$this->dados['model'] = $this->GetModel($this->metodo);
					
					if( method_exists( $this, $metodo ) ) {
						$this->$metodo();
					}
				}

			$this->dados['classe']	=	$this->classe;
			$this->dados['metodo']	=	$this->metodo;

			

			if( $this->metodo == 'login' ) {
				$this->View = new View;
				$this->View->$metodo('View/admin/login.php');
				
			}elseif( $this->metodo == 'rede' ) {
				$this->View = new View;

				$this->View->$metodo('View/admin/rede.php', $this->dados);
				
			} else {
					
					if( method_exists( $this, $metodo ) ) {
						
						$this->$metodo();
						
					}else{
						
						if(empty($this->dados['model']['template'])){
							$this->template = $template;
						}else{
							$this->template = $this->dados['model']['template'];
						}
						
					}	
				
					$template = $this->Template();
					//echo $template;die;
					if($this->template == 'null')
					{
						echo json_encode($this->dados['model']);
					} else {
						
						$this->dados['param']['usuario'] = self::$parametros['usuario'];
						$this->dados['caminho'] = $this->Caminho();
						$this->View	= new View($template, $this->dados);
					}
					
					$dados['javascript'] = $this->getJs();

			}
			
		}else{
					
					$key = $this->GetClasseMetodo();
					
					$metodo = $key['metodo'];
// 					echo $metodo;die;
					$this->dados['model'] = $this->GetModel($metodo);
					
					//echo '<pre>';print_r($this->dados['model']);die;
					
					$this->template = $this->dados['model']['template'];
					$template = $this->Template();
					
					$this->dados['param']['usuario'] = self::$parametros['usuario'];
					
					$this->dados['caminho'] = $this->Caminho();
					$this->View 			= new View($template, $this->dados);
		}
 		
	}
	
	
	
	
	
	
	public function NaoEncontrada()
	{
		$this->template = 'erro';
	}
	
	public function erro()
	{
		$this->template = 'erro';
	}

	public function perna()
	{
		$this->template = null;
	}
	
	public function autoativacao()
	{
		$this->template = null;
	}
	/* public function login()
	{
		$this->Instancia = new Backoffice;
		$this->Instancia->login($_POST);
		$this->template = 'login';
		$this->metodo = 'login';
	} */
	
	public function adm_listar_u_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function adm_listar_p_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function adm_listar_v_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function adm_baixaboleto_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function alterarsenha_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function meuspedidos_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function listarvoucher_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function pontuacao_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function comissoes_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function historico_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function historico_bonus_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function pagarpedidos_ajax() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}

	public function linearjson() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function consultor_carrinho() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function inserirCarConsultor() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	
	public function inserirPedConsultor() 
	{
		$key = $this->GetClasseMetodo();

		$metodo = $key['metodo'];
		$this->template = $metodo;
	}
	/*public function perna()
	{
		$this->template = null;
	}
	
	public function VerEmail()
	{
		$this->template = null;
	}
	
	public function Correios()
	{
		$this->template = null;
	}
	
	public function MaiorIdade()
	{
		$this->template = null;
	}
	*/
	public function UpUsu()
	{
		$this->template = null;
	}
	
	public function UpEnd()
	{
		$this->template = null;
	}
	
	public function UpFone()
	{
		$this->template = null;
	}
	/*
	public function isset_usuario_ajax()
	{
		$this->Instancia = new Usuario;
		$this->Instancia->isset_usuario_ajax();
		$this->template = null;
		$this->metodo = 'isset_usuario_ajax';
		
	}
	
	public function isset_email_ajax()
	{
		$this->Instancia = new Usuario;
		$this->Instancia->isset_email_ajax();
		$this->template = null;
		$this->metodo = 'isset_email_ajax';
	
	}
	
	public function isset_idade_ajax()
	{
		$this->Instancia = new Usuario;
		$this->Instancia->isset_idade_ajax();
		$this->template = null;
		$this->metodo = 'isset_idade_ajax';
	
	}
	
	public function isset_cpf_ajax()
	{
		$this->Instancia = new Usuario;
		$this->Instancia->isset_cpf_ajax();
		$this->template = null;
		$this->metodo = 'isset_cpf_ajax';
	
	}
	
	public function get_cep_ajax()
	{
		$this->Instancia = new Usuario;
		$this->Instancia->get_cep_ajax();
		$this->template = null;
		$this->metodo = 'get_cep_ajax';
	
	}
	
	public function get_usu_voucher_ajax()
	{
		$this->Instancia = new Usuario;
		$this->Instancia->get_usu_voucher_ajax();
		$this->template = null;
		$this->metodo = 'get_usu_voucher_ajax';
	
	} */
	
	public function ComVoucher()
	{
		$this->Instancia = new Pagamento;
		$this->Instancia->ComVoucher();
	
	}
	
	public function ComBoleto()
	{
		$this->Instancia = new Pagamento;
		$this->Instancia->ComBoleto();
	
	}
	
	public function PagarManual()
	{
		$this->Instancia = new Pagamento;
		$this->Instancia->PagarManual();
	
	}


}