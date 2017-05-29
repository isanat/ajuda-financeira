<?php 
class  TbComissao extends ComissaoRepository
{
	private $cm_id;
	private $fk_ped;
	private $cm_comissao;
	private $cm_data;
	private $fk_usu_indicou;
	private $fk_usu_indicado;
	private $cm_percent_comissao;
	private $fk_status_pagamento;

	public function SetCmId($valor)
	{
		$this->cm_id = $valor;
	}
	
	public function SetFkPed($valor)
	{
		$this->fk_ped = $valor;
	}
	
	public function SetCmComissao($valor)
	{
		$this->cm_comissao = $valor;
	}
	
	public function SetCmData($valor)
	{
		$this->cm_data = $valor;
	}

	public function SetFkUsuIndicou($valor)
	{
		$this->fk_usu_indicou = $valor;
	}

	public function SetFkUsuIndicado($valor)
	{
		$this->fk_usu_indicado = $valor;
	}
	
	public function SetCmPercentComissao($valor)
	{
		$this->cm_percent_comissao = $valor;
	}

	public function SetFkStatusPagamento($valor)
	{
		$this->fk_status_pagamento = $valor;
	}
	
	public function SetCmDataPag($valor)
	{
		$this->cm_data_pag = $valor;
	}

	////////////////////////////////////////////
		
	public function GetCmId()
	{
		return $this->cm_id;
	}
	
	public function GetFkPed()
	{
		return $this->fk_ped;
	}
	
	public function GetCmComissao()
	{
		return $this->cm_comissao;
	}
	
	public function GetCmData()
	{
		return $this->cm_data;
	}
	
	public function GetFkUsuIndicou()
	{
		return $this->fk_usu_indicou;
	}
	
	public function GetFkUsuIndicado()
	{
		return $this->fk_usu_indicado;
	}
	
	public function GetCmPercentComissao()
	{
		return $this->cm_percent_comissao;
	}
	
	public function GetFkStatusPagamento()
	{
		return $this->fk_status_pagamento;
	}
	
	public function GetCmDataPag()
	{
		return $this->cm_data_pag;
	}
}