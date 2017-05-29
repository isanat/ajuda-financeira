<?php 
class TbSaldoPontos extends SaldoPontosRepository
{
	private $sld_id;
	private $sld_valor_credito;
	private $sld_valor_debito;	
	private $sld_perna;
	private $sld_mes_ano;
	private $fk_usu;

	public function SetSldId($valor)
	{
		$this->sld_id = $valor;
	}
	
	public function SetSldValorCredito($valor)
	{
		$this->sld_valor_credito = $valor;
	}

	public function SetSldValorDebito($valor)
	{
		$this->sld_valor_debito = $valor;
	}

	public function SetSldPerna($valor)
	{
		$this->sld_perna = $valor;
	}
	
	public function SetSldMesAno($valor)
	{
		$this->sld_mes_ano = $valor;
	}
	
	public function SetFkUsu($valor)
	{
		$this->fk_usu = $valor;
	}
	
	////////////////////////////////////////////
		
	public function GetSldId()
	{
		return $this->sld_id;
	}
	
	public function GetSldValorCredito()
	{
		return $this->sld_valor_credito;
	}
	
	public function GetSldValorDebito()
	{
		return $this->sld_valor_debito;
	}
	
	public function GetSldPerna()
	{
		return $this->sld_perna;
	}
	
	public function GetSldMesAno()
	{
		return $this->sld_mes_ano;
	}
	
	public function GetFkUsu()
	{
		return $this->fk_usu;
	}
}