<?php 
class TbFone extends FoneRepository
{
	private $fone_id;
	private $fone_fone;
	private $fk_usu;
	private $fk_tipo;

	public function SetFoneId($valor)
	{
		$this->fone_id = $valor;
	}
	
	public function SetFoneFone($valor)
	{
		$this->fone_fone = str_replace(')','',str_replace(' ','',str_replace('-','',str_replace('(', '', $valor))));
	}
	
	public function SetFkUsu($valor)
	{
		$this->fk_usu = str_replace(' ','',str_replace('-','',str_replace('.', '', $valor)));
	}
	
	public function SetFkTipo($valor)
	{
		$this->fk_tipo = $valor;
	}
	
	////////////////////////////////////////////
		
	public function GetFoneId()
	{
		return $this->fone_id;
	}
	
	public function GetFoneFone()
	{
		return $this->fone_fone;
	}
	
	public function GetFkUsu()
	{
		return $this->fk_usu;
	}
	
	public function GetFkTipo()
	{
		return $this->fk_tipo;
	}
}