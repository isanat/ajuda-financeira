<?php 
class TbLogPagPontos extends LogPagPontosRepository
{
	private $id;
	private $pontos;
	private $media_porcentagem;
	private $valor;
	private $data_pag;

	public function SetId($valor)
	{
		$this->id = $valor;
	}
	
	public function SetPontos($valor)
	{
		$this->pontos = $valor;
	}
	
	public function SetMediaPorcentagem($valor)
	{
		$this->media_porcentagem = $valor;
	}
	
	public function SetValor($valor)
	{
		$this->valor = $valor;
	}
	
	public function SetDataPag($valor)
	{
		$this->data_pag = $valor;
	}
	////////////////////////////////////////////
		
	public function GetId()
	{
		return $this->id;
	}
	
	public function GetPontos()
	{
		return $this->pontos;
	}
	
	public function GetMediaPorcentagem()
	{
		return $this->media_porcentagem;
	}
	
	public function GetValor()
	{
		return $this->valor;
	}
	
	public function GetDataPag()
	{
		return $this->data_pag;
	}
}