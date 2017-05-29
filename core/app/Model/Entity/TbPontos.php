<?php 
class TbPontos extends PontosRepository
{
	private $pt_id;
	private $pt_perna;
	private $pt_pontos;
	private $pt_datapg;
	private $fk_status;
	private $pt_data;
	private $fk_ped;
	private $fk_usu;
	private $fk_usu_rede;
	private $fk_status_pagamento;

	public function SetPtId($valor)
	{
		$this->pt_id = $valor;
	}
	
	public function SetPtPerna($valor)
	{
		$this->pt_perna = $valor;
	}
	
	public function SetPtPontos($valor)
	{
		$this->pt_pontos = $valor;
	}

	public function SetPtDatapg($valor)
	{
		$this->pt_data_pg = $valor;
	}

	public function SetFkStatus($valor)
	{
		$this->fk_status = $valor;
	}
	
	public function SetPtData($valor)
	{
		$this->pt_data = $valor;
	}
	
	public function SetFkPed($valor)
	{
		$this->fk_ped = $valor;
	}
	
	public function SetFkUsuRede($valor)
	{
		$this->fk_usu_rede = $valor;
	}
	
	public function SetFkUsu($valor)
	{
		$this->fk_usu = $valor;
	}

	public function SetFkStatusPagamento($valor)
	{
		$this->fk_status_pagamento = $valor;
	}
	
	////////////////////////////////////////////
		
	public function GetPtId()
	{
		return $this->pt_id;
	}
	
	public function GetPtPerna()
	{
		return $this->pt_perna;
	}
	
	public function GetPtPontos()
	{
		return $this->pt_pontos;
	}
	
	public function GetPtDataPag()
	{
		return $this->pt_data_pag;
	}
	
	public function GetFkStatus()
	{
		return $this->fk_fk_status;
	}
	
	public function GetPtData()
	{
		return $this->pt_data;
	}

	public function GetFkPed()
	{
		return $this->fk_ped;
	}

	public function GetFkUsuRede()
	{
		return $this->fk_usu_rede;
	}
	
	public function GetFkUsu()
	{
		return $this->fk_usu;
	}
	
	public function GetFkStatusPagamento()
	{
		return $this->fk_status_pagamento;
	}
}