<?php 
class TbDoacoes extends DoacoesRepository
{
	
	private $rpg_id;
	private $rgp_obs;
	private $rpg_comprovante;
	private $rpg_doador;
	private $rgp_recebedor;
	private $fk_status;
	private $rpg_nivel;
	
	public function SetRpgId($valor)
	{
		$this->rpg_id = $valor;
	}
	
	public function SetRpgObs($valor)
	{
		$this->rgp_obs = $valor;
	}
	
	public function SetRpgComprovante($valor)
	{
		$this->rpg_comprovante = $valor;
	}
	
	public function SetRpgDoador($valor)
	{
		$this->rpg_doador = $valor;
	}
	
	public function SetRpgRecebedor($valor)
	{
		$this->rpg_recebedor = $valor;
	}
	
	public function SetFhStatus($valor)
	{
		$this->fk_status = $valor;
	}
	
	public function SetRpgNivel($valor)
	{
		$this->rpg_nivel = $valor;
	}
	
	//////////////////////////////////////////////////////
	
	public function GetRpgId()
	{
		return $this->fone_id;
	}
	
	public function GetRpgObs()
	{
		return $this->rgp_obs;
	}
	
	public function GetRpgComprovante()
	{
		return $this->rpg_comprovante;
	}
	
	public function GetRpgDoador()
	{
		return $this->rpg_doador;
	}
	
	public function GetRpgRecebedor()
	{
		return $this->rpg_recebedor;
	}
	
	public function GetFhStatus()
	{
		return $this->fk_status;
	}
	
	public function GetRpgNivel()
	{
		return $this->rpg_nivel;
	}
	
}