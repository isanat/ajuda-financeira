<?php 

class  TbCarrinhoVoucher extends CarrinhoVoucherRepository
{
	private $voucher_id;
	private $voucher_pro_id;
	private $voucher_session;
	private $voucher_qtd;
	private $voucher_valor;
	private $fk_usu;
	private $fk_status;
	private $voucher_data;
	
	public function SetVoucherId($valor)
	{
		$this->voucher_id = $valor;
	}
	
	public function SetVoucherProId($valor)
	{
		$this->voucher_pro_id = $valor;
	}
	
	public function SetVoucherSession($valor)
	{
		$this->voucher_session = $valor;
	}
	
	public function SetVoucherQtd($valor)
	{
		$this->voucher_qtd = $valor;
	}
	
	public function SetVoucherValor($valor)
	{
		$this->voucher_valor = $valor;
	}
	
	public function SetFkUsu($valor)
	{
		$this->fk_usu = $valor;
	}
	
	public function SetFkStatus($valor)
	{
		$this->fk_status = $valor;
	}
	
	public function SetVoucherData($valor)
	{
		$this->voucher_data = $valor;
	}
	
	////////////////////////////////////////////

	public function GetVoucherId()
	{
		return $this->voucher_id;
	}
		
	public function GetVoucherProId()
	{
		return $this->voucher_pro_id;
	}
	
	public function GetVoucherSession()
	{
		return $this->voucher_session;
	}
	
	public function GetVoucherQtd()
	{
		return $this->voucher_qtd;
	}
	
	public function GetVoucherValor()
	{
		return $this->voucher_valor;
	}
	
	public function GetFkUsu()
	{
		return $this->fk_usu;
	}
	
	public function GetFkStatus()
	{
		return $this->fk_status;
	}
	
	public function GetVoucherData()
	{
		return $this->voucher_data;
	}
}