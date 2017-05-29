<?php 

class  TbEcommercer extends EcommerceRepository
{
	private $loja_nome;
	private $loja_valor;
	private $fk_usu;
	private $loja_data_compra;
	private $loja_data_expira;
	private $fk_ped;
	
	public function SetLojaNome($valor)
	{
		$this->loja_nome = $valor;
	}
	
	public function SetLojaValor($valor)
	{
		$this->loja_valor = $valor;
	}
	
	public function SetFkUsu($valor)
	{
		$this->fk_usu = $valor;
	}
	public function SetLojaData($valor)
	{
		$this->loja_data_compra = $valor;
	}
	
	public function SetLojaDataExpira($valor)
	{
		$this->loja_data_expira = $valor;
	}
	
	public function SetFkPed($valor)
	{
		$this->fk_ped = $valor;
	}
	
	////////////////////////////////////////////
		
	public function GetLojaNome()
	{
		return $this->loja_nome ;
	}
	
	public function GetLojaValor()
	{
		return $this->loja_valor ;
	}
	
	public function GetFkUsu()
	{
		return $this->fk_usu;
	}

	public function GetLojaData()
	{
		return $this->loja_data_compra;
	}
	
	public function GetLojaDataExpira()
	{
		return $this->loja_data_expira;
	}
	
	public function GetFkPed()
	{
		return $this->fk_ped;
	}
	
}