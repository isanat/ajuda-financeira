<?php 
class TbSaldoAnterior extends SaldoAnteriorRepository
{
	private $sda_id;
	private $fk_conta_corrente;
	private $sda_data;
	private $sda_valor;

	public function SetSdaId($valor)
	{
		$this->sda_id = $valor;
	}
	
	public function SetFkContaCorrente($valor)
	{
		$this->fk_conta_corrente = $valor;
	}
	
	public function SetSdaData($valor)
	{
		$this->sda_data = $valor;
	}
	
	public function SetSdaValor($valor)
	{
		$this->sda_valor = $valor;
	}
	
	////////////////////////////////////////////
		
	public function GetSdaId()
	{
		return $this->sda_id;
	}
	
	public function GetFkContaCorrente()
	{
		return $this->fk_conta_corrente;
	}
	
	public function GetSdaData()
	{
		return $this->sda_data;
	}
	
	public function GetSdaValor()
	{
		return $this->sda_valor;
	}
}