<?php 

class  TbProdutos extends ProdutosRepository
{
	private $pro_cod;
	private $pro_valor;
	private $pro_desc;
	private $pro_qtd;
	private $fk_sub;
	private $pro_nome;
	private $fk_bonus;
	private $fk_tipo;
	
	
	public function SetProCod($valor)
	{
		$this->pro_cod = $valor;
	}
	
	public function SetProValor($valor)
	{
		$this->pro_valor = $valor;
	}
	
	public function SetProDesc($valor)
	{
		$this->pro_desc = strtolower($valor);
	}
	
	public function SetProQtd($valor)
	{
		$this->pro_qtd = $this->Password($valor);
	}
	
	public function SetFkSub($valor)
	{
		$this->fk_sub = $valor;
	}
	
	public function SetProNome($valor)
	{
		$this->pro_nome = $valor;
	}
	
	public function SetFkBonus($valor)
	{
		$this->fk_bonus = $valor;
	}
	
	public function SetFkTipo($valor)
	{
		$this->fk_tipo = $valor;
	}
	
	
	////////////////////////////////////////////
		
	public function GetProCod()
	{
		return $this->pro_cod;
	}
	
	public function GetProValor()
	{
		return $this->pro_valor;
	}
	
	public function GetProDesc()
	{
		return $this->pro_desc;
	}
	
	public function GetProQtd()
	{
		return $this->pro_qtd;
	}
	
	public function GetFkSub()
	{
		return $this->fk_sub;
	}
	
	public function GetProNome()
	{
		return $this->pro_nome;
	}
	
	public function GetFkBonus()
	{
		return $this->fk_bonus;
	}
	
	public function GetFkTipo()
	{
		return $this->fk_tipo;
	}
}