<?php 

abstract class EcommerceRepository
{
	public $banco;
	
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}

	public function addLoja()
	{
	  try{		
		$addLoja = array(
					'loja_nome'=>$this->GetLojaNome(),
					'loja_valor'=>$this->GetLojaValor(),
					'fk_usu'=>$this->GetFkUsu(),
					'fk_ped'=>$this->GetFkPed()
				);
		$loja['loja'] = $this->SelectLojaComprar();

        $this->banco->inserir('tb_loja', $addLoja);

		}catch( PDOException $e ) {
			$msg = 'Erro ao comprar sua Loja: ' . $e->getMessage();
		}
	}	

	public function SelectLojaComprar() {
		try{
			
			$query = " SELECT 
						loja.loja_nome as loja_nome ,
						loja.fk_usu,
						loja.loja_id,
						loja.fk_bonus,
						loja.fk_ped,
						loja.loja_valor AS loja_valor ,
						loja.fk_usu AS fk_usu ,
						loja.loja_data_compra AS loja_data_compra ,
						loja.loja_data_expira AS loja_data_expira ,
						loja.loja_status AS loja_status
					FROM 
				        tb_loja AS loja
					WHERE
      					loja.fk_usu = '{$_SESSION['usuario']['usu_doc']}' AND loja.loja_status = 1";

// 					echo '<pre>';print_r($query);die;
			
			$sql = $this->banco->executar($query) ;

					return $sql;

		}
		catch( PDOException $e ) {
			$msg = 'Erro ao selecionar sua loja: ' . $e->getMessage() ;
			$this->banco->log( $msg ) ;
			}		
	}





}
