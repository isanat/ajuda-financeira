<?php 
class TbContaCorrente extends ContaCorrenteRepository
{
	private $cta_id;
	private $cta_numero;
	private $cta_digito;
	private $fk_usu_doc;
	private $cta_ativo;

	public function SetCtaId($valor)
	{
		$this->cta_id = $valor;
	}
	
	public function SetCtaNumero($valor)
	{
		$this->cta_numero = $valor;
	}
	
	public function SetCtaDigito($valor)
	{
		$this->cta_digito = $valor;
	}
	
	public function SetFkUsuDoc($valor)
	{
		$this->fk_usu_doc = $valor;
	}

	public function SetCtaAtivo($valor)
	{
		$this->cta_ativo = $valor;
	}
	
	////////////////////////////////////////////
		
	public function GetCtaId()
	{
		return $this->cta_id;
	}
	
	public function GetCtaNumero()
	{
		return $this->cta_numero;
	}
	
	public function GetCtaDigito()
	{
		return $this->cta_digito;
	}
	
	public function GetFkUsuDoc()
	{
		return $this->fk_usu_doc;
	}

	public function GetCtaAtivo()
	{
		return $this->cta_ativo;
	}

}