<?php 
class TbTipoMovimento extends TipoMovimentoRepository
{
	private $tmv_id;
	private $tmv_cred_deb;
	private $tmv_descricao;
	private $tmv_ativo;

	public function SetTmvId($valor)
	{
		$this->tmv_id = $valor;
	}
	
	public function SetTmvCredDeb($valor)
	{
		$this->tmv_cred_deb = $valor;
	}
	
	public function SetTmvDescricao($valor)
	{
		$this->tmv_descricao = $valor;
	}
	
	public function SetTmvAtivo($valor)
	{
		$this->tmv_ativo = $valor;
	}
	
	////////////////////////////////////////////
		
	public function GetTmvId()
	{
		return $this->tmv_id;
	}
	
	public function GetTmvCredDeb()
	{
		return $this->tmv_cred_deb;
	}
	
	public function GetTmvDescricao()
	{
		return $this->tmv_descricao;
	}
	
	public function GetTmvAtivo()
	{
		return $this->tmv_ativo;
	}
}