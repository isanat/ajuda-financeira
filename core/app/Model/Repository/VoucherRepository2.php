<?php 

abstract class VoucherRepository
{

	public $banco;
	
	public function __construct() {
		
		global $array_db;		
		$db = $array_db['db'];
		$this->banco = Banco::conecta('pgsql',$db);
	}
	
	public function VerStatus()
	{
		$voucher = $this->GetVoucherHash();
	
		return $this->banco->ver('public.tb_voucher','fk_status_voucher', "voucher_hash = '{$voucher}'");
	}
	
	public function AtivarVoucher()
	{
		$voucher 	= $this->GetVoucherHash();
		$usu 		= $this->GetFkUsuVoucher();
		$status 	= $this->GetFkStatusVoucher();
		$data_usu 	= $this->GetVoucherDataUsu();
		
		$campo = array(
					'fk_status_voucher'=>$status,
					'voucher_data_usu'=>$data_usu,
					'fk_usu_voucher'=>$usu
					);
	
		return $this->banco->editar('public.tb_voucher',$campo, "voucher_hash = '{$voucher}'");
	}
	
	public function Add_Voucher()
	{
		Try{
		
		$voucher = array(
					'voucher_valor'=>$this->GetVoucherValor(),
					'fk_usu'=>$this->GetFkUsu(),
					'fk_prod'=>$this->GetFkProd(),
					'voucher_hash'=>$this->GetVoucherHash()
				);
// 		echo '<pre>';print_r($voucher);die;
		
		$this->banco->inserir('tb_voucher',$voucher);
		
		}catch( PDOException $e ) {
			$msg = 'Erro ao selecionar categoria de produto: ' . $e->getMessage();
			echo $msg; die;
			$this->banco->log( $msg );
		}
		
	}
	
	public function ProdutosCadastros() {
	
		try{
			$res = $this->banco->executar( "SELECT * FROM tb_produtos WHERE fk_tipo = 1" ) ;
			return $res ;
		}
		catch( PDOException $e ) {
			$msg = 'Erro ao selecionar categoria de produto: ' . $e->getMessage();
			$this->banco->log( $msg );
		}
	
	}
	
	public function AddCarrinho( $id = null , $valor = null) {
		$dados = array(
				"voucher_pro_id" => $id ,
				"voucher_session" => session_id(),
				"voucher_valor" => $valor
		);
	
		$sql = $this->banco->inserir("tb_carrinho_voucher" , $dados) ;
		$this->SelectCarrinho();
		return $sql;
	}
	
	public function SelectCarrinho( $parm = null ) {
		try{
			$sessao = session_id();
			 
			$sql    = $this->banco->executar(
					" SELECT
					tb_p.pro_id AS pro_id ,
					tb_p.pro_nome AS pro_nome ,
					tb_p.pro_valor AS pro_valor ,
					tb_car.voucher_id AS voucher_id ,
					tb_car.voucher_pro_id AS voucher_pro_id ,
					tb_car.voucher_qtd AS voucher_qtd ,
					tb_car.voucher_valor AS voucher_valor
					FROM
					tb_produtos AS tb_p , tb_carrinho_voucher AS tb_car
					WHERE
					tb_car.voucher_pro_id::text = tb_p.pro_id::text AND tb_car.voucher_session::text = '{$sessao}'::text ORDER BY voucher_id DESC") ;
					return $sql;
		}
		catch( PDOException $e ) {
			$msg = 'Erro ao selecionar produto do carrinho: ' . $e->getMessage() ;
			$this->banco->log( $msg ) ;
			}
		
			}

	public function UpdateCar( $voucher_id , $qtd_voucher ){
			$this->voucher_id  = $voucher_id;
			$this->qtd_voucher = $qtd_voucher;
			 
			$dados = array(
					"voucher_qtd" => $this->qtd_voucher
			);
			$sql = $this->banco->editar("tb_carrinho_voucher" , $dados , "voucher_id = $this->voucher_id") ;
			$this->SelectCarrinho();
			return $sql;
	
		}
	
	public function DelProdutos( $del_pro ){
			$this->del_pro  = $del_pro;
		
			$sql = $this->banco->excluir("tb_carrinho_voucher" , "voucher_id = $this->del_pro") ;
			$this->SelectCarrinho();
			return $sql;
	
		}
		
		public function ValidaVoucherPendente()
		{
			
		}

		public function SelectVoucher() {
		try{
			 
			$sql    = $this->banco->executar(
					" SELECT
						usu.usu_id AS usu_id ,
						usu.usu_nome AS usu_nome ,
						usu.usu_doc AS usu_doc ,
						pro.pro_id AS pro_id ,
						pro.pro_nome AS pro_nome ,
						voucher.voucher_valor AS voucher_valor ,
						voucher.fk_usu AS fk_usu ,
						voucher.fk_status_voucher AS fk_status_voucher,
						voucher.voucher_data AS voucher_data ,
						voucher.fk_prod AS fk_prod ,
						voucher.voucher_hash AS voucher_hash 
					 FROM 
					    tb_usuarios AS usu ,
					    tb_produtos AS pro ,
					    tb_voucher AS voucher
					 WHERE 
			            voucher.fk_usu::text = usu.usu_doc::text AND voucher.fk_prod::text = pro.pro_id::text ORDER BY voucher_data ASC");
					
					return $sql;
		}
	    catch( PDOException $e ) {
			$msg = 'Erro ao selecionar produto do carrinho: ' . $e->getMessage() ;
			$this->banco->log( $msg ) ;
		}
		
   }
}
