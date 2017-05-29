<?php 

class  TbContaBancaria extends ContaBancariaRepository
{
	private $ctu_id;
	private $fk_usu_doc;
	private $fk_banco;
	private $ctu_agencia;
	private $ctu_conta;
	private $ctu_conta_dg;
	private $ctu_data;
	private $ctu_ativo;
	private $ctu_tipo;
	
	public function SetCtuId($valor)
	{
		$this->ctu_id = $valor;
	}
	
	public function SetFkUsuDoc($valor)
	{
		$this->fk_usu_doc = $valor;
	}
	
	public function SetFkBanco($valor)
	{
		$this->fk_banco = $valor;
	}
	
	public function SetCtuAgencia($valor)
	{
		$this->ctu_agencia = $valor;
	}
	
	public function SetCtuConta($valor)
	{
		$this->ctu_conta = $valor;
	}
	
	public function SetCtuContaDg($valor)
	{
		$this->ctu_conta_dg = $valor;
	}
	
	public function SetCtuData($valor)
	{
		$this->ctu_data = $valor;
	}
	
	public function SetCtuAtivo($valor)
	{
		$this->ctu_ativo = $valor;
	}
	
	public function SetCtuTipo($valor)
	{
		$this->ctu_tipo = $valor;
	}

	////////////////////////////////////////////

	public function GetCtuId()
	{
		return $this->ctu_id;
	}
	
	public function GetFkUsuDoc()
	{
		return $this->fk_usu_doc;
	}
	
	public function GetFkBanco()
	{
		return $this->fk_banco;
	}
	
	public function GetCtuAgencia()
	{
		return $this->ctu_agencia;
	}
	
	public function GetCtuConta()
	{
		return $this->ctu_conta;
	}
	
	public function GetCtuContaDg()
	{
		return $this->ctu_conta_dg;
	}
	
	public function GetCtuData()
	{
		return $this->ctu_data;
	}
	
	public function GetCtuAtivo()
	{
		return $this->ctu_ativo;
	}
	
	public function GetCtuTipo()
	{
		return $this->ctu_tipo;
	}
}