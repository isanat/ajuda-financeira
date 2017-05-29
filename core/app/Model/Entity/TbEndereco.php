<?php 

class TbEndereco extends EnderecoRepository
{
	private $end_cep;
	private $end_end;
	private $end_n;
	private $end_comp;
	private $end_bairro;
	private $end_cidade;
	private $end_uf;
	//private $fk_usu;
	
	public function SetEndCep($valor)
	{
		$this->end_cep = str_replace('-','',$valor);
	}
	
	public function SetEndEnd($valor)
	{
		$this->end_end = $valor;
	}
	
	public function SetEndN($valor)
	{
		$this->end_n = $valor;
	}
	
	public function SetEndComp($valor)
	{
		$this->end_comp = $valor;
	}
	
	public function SetEndBairro($valor)
	{
		$this->end_bairro = $valor;
	}
	
	public function SetEndCidade($valor)
	{
		$this->end_cidade = $valor;
	}
	
	public function SetEndUf($valor)
	{
		$this->end_uf = $valor;
	}
	
	public function SetFkUsu($valor)
	{
		$this->fk_usu = $valor;
	}
	
	///////////////////////////////
	
	public function GetEndCep()
	{
		return $this->end_cep;
	}
	
	public function GetEndEnd()
	{
		return $this->end_end;
	}
	
	public function GetEndN()
	{
		return $this->end_n;
	}
	
	public function GetEndComp()
	{
		return $this->end_comp;
	}
	
	public function GetEndBairro()
	{
		return $this->end_bairro;
	}
	
	public function GetEndCidade()
	{
		return $this->end_cidade;
	}
	
	public function GetEndUf()
	{
		return $this->end_uf;
	}
	
	public function GetFkUsu()
	{
		return $this->fk_usu;
	}
	
	
}
