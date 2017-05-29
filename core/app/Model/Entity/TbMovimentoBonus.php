<?php 

class TbMovimentoBonus extends MovimentoBonusRepository
{
	private $mvm_id;
	private $fk_conta_corrente;
	private $fk_tipo_movimento;
	private $fk_status_movimento;
	private $mvm_data;
	private $mvm_valor;
	
	public function SetMvmId($valor)
	{
		$this->mvm_id = $valor;
	}
	
	public function SetFkContaCorrente($valor)
	{
		$this->fk_conta_corrente = $valor;
	}
	
	public function SetFkTipoMovimento($valor)
	{
		$this->fk_tipo_movimento = $valor;
	}
	
	public function SetFkStatusMovimento($valor)
	{
		$this->fk_status_movimento = $valor;
	}
	
	public function SetMvmData($valor)
	{
		$this->mvm_data = $valor;
	}
	
	public function SetMvmValor($valor)
	{
		$this->mvm_valor = $valor;
	}

	////////////////////////////////////////////

	public function GetMvmId()
	{
		return $this->mvm_id;
	}
	
	public function GetFkContaCorrente()
	{
		return $this->fk_conta_corrente;
	}
	
	public function GetFkTipoMovimento()
	{
		return $this->fk_tipo_movimento;
	}
	
	public function GetFkStatusMovimento()
	{
		return $this->fk_status_movimento;
	}
	
	public function GetMvmData()
	{
		return $this->mvm_data;
	}
	
	public function GetMvmValor()
	{
		return $this->mvm_valor;
	}

}