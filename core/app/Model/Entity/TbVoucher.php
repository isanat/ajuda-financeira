<?php 

class  TbVoucher extends VoucherRepository
{
	private $voucher_id;
	private $voucher_valor;
	private $fk_usu;
	private $fk_status_voucher;
	private $voucher_data;
	private $voucher_data_usu;
	private $fk_prod;
	private $fk_bonus;
	private $fk_usu_voucher;
	private $voucher_hash;
	
	public function SetVoucherId($valor)
	{
		$this->voucher_id = $valor;
	}
	
	public function SetVoucherValor($valor)
	{
		$this->voucher_valor = $valor;
	}
	
	public function SetFkUsu($valor)
	{
		$this->fk_usu = $valor;
	}
	
	public function SetFkStatusVoucher($valor)
	{
		$this->fk_status_voucher = $valor;
	}
	
	public function SetVoucherData($valor)
	{
		$this->voucher_data = $valor;
	}
	
	public function SetVoucherDataUsu($valor)
	{
		$this->voucher_data_usu = $valor;
	}
	
	public function SetFkProd($valor)
	{
		$this->fk_prod = $valor;
	}
	
	public function SetFkBonus($valor)
	{
		$this->fk_bonus = $valor;
	}
	
	public function SetFkUsuVoucher($valor)
	{
		$this->fk_usu_voucher = $valor;
	}
	
	public function SetVoucherHash($valor)
	{
		$this->voucher_hash = $valor;
	}
	
	
	////////////////////////////////////////////
		
	public function GetVoucherId()
	{
		return $this->voucher_id ;
	}
	
	public function GetVoucherValor()
	{
		return $this->voucher_valor ;
	}
	
	public function GetFkUsu()
	{
		return $this->fk_usu;
	}
	
	public function GetFkStatusVoucher()
	{
		return $this->fk_status_voucher;
	}
	
	public function GetVoucherData()
	{
		return $this->voucher_data;
	}
	
	public function GetVoucherDataUsu()
	{
		return $this->voucher_data_usu;
	}
	
	public function GetFkProd()
	{
		return $this->fk_prod;
	}
	
	public function GetFkBonus()
	{
		return $this->fk_bonus;
	}
	
	public function GetFkUsuVoucher()
	{
		return $this->fk_usu_voucher;
	}
	
	public function GetVoucherHash()
	{
		return $this->voucher_hash;
	}

}