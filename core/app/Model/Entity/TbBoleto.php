<?php 
class  TbBoleto extends BoletoRepository
{
	private $fk_transid;
	private $bl_link;

	public function SetFkTransid($valor)
	{
		$this->fk_transid = $valor;
	}
	
	public function SetBlLink($valor)
	{
		$this->bl_link = $valor;
	}
	
	////////////////////////////////////////////
		
	public function GetFkTransid()
	{
		return $this->fk_transid;
	}
	
	public function GetBlLink()
	{
		return $this->bl_link;
	}
}