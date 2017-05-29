<?php 
class  TbComissao extends ComissaoRepository
{
	private $cm_id;
	private $fk_transid;
	private $cm_comissao;
	private $cm_data;
	private $fk_usu_indicou;
	private $fk_usu_indicado;

	public function SetCmId($valor)
	{
		$this->cm_id = $valor;
	}
	
	public function SetFkTransid($valor)
	{
		$this->fk_transid = $valor;
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
	
	////////////////////////////////////////////
		
	public function GetCmId()
	{
		return $this->cm_id;
	}
	
	public function GetFkTransid()
	{
		return $this->fk_transid;
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
}