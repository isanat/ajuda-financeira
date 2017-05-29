<?php 
class TbPj extends PjRepository
{
	private $pj_cnpj;
	private $fk_usu;

	public function SetPjCnpj($valor)
	{
		$this->pj_cnpj = str_replace('/','',str_replace(' ','',str_replace('-','',str_replace('.', '', $valor))));
	}
	
	public function SetFkUsu($valor)
	{
		$this->fk_usu = str_replace(' ','',str_replace('-','',str_replace('.', '', $valor)));
	}
	
	////////////////////////////////////////////
		
	public function GetPjCnpj()
	{
		return $this->pj_cnpj;
	}
	
	public function GetFkUsu()
	{
		return $this->fk_usu;
	}
	
}