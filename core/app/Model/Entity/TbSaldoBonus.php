<?php 
class TbSaldoBonus extends SaldoBonusRepository
{
	private $sld_id;
	private $fk_conta_corrente;
	private $sld_valor_debito;
	private $sld_valor_credito;

	public function SetSldId($valor)
	{
		$this->sld_id = $valor;
	}
	
	public function SetFkContaCorrente($valor)
	{
		$this->fk_conta_corrente = $valor;
	}
	
	public function SetSldValorDebito($valor)
	{
		$this->sld_valor_debito = $valor;
	}
	
	public function SetSldValorCredito($valor)
	{
		$this->sld_valor_credito = $valor;
	}
	
	////////////////////////////////////////////
		
	public function GetSldId()
	{
		return $this->sld_id;
	}
	
	public function GetFkContaCorrente()
	{
		return $this->fk_conta_corrente;
	}
	
	public function GetSldValorDebito()
	{
		return $this->sld_valor_debito;
	}
	
	public function GetSldValorCredito()
	{
		return $this->sld_valor_credito;
	}
}