<?php 

class TbPedidos extends PedidosRepository
{
	private $ped_id;
	private $fk_usu;
	private $ped_transid;
	private $fk_frete;
	private $ped_frete;
	private $ord_date;
	private $fk_forma;
	private $fk_status;
	private $ped_total;
	private $ped_sessao;
	private $ped_ip;
	private $ped_browser;
	private $fk_pag;
	private $ped_data_pag;
	private $fk_final;
	private $ped_valor_pago;

	
	public function SetPedId($valor)
	{
		$this->ped_id = $valor;
	}
	
	public function SetFkUsu($valor)
	{
		$this->fk_usu = $valor;
	}

	public function SetPedTransId($valor)
	{
		$this->ped_transid = $valor;
	}
	
	public function SetPedFrete($valor)
	{
		$this->ped_frete = $valor;
	}
	
	public function SetOrdDate($valor)
	{
		$this->ord_date = $valor;
	}
	
	public function SetFkForma($valor)
	{
		$this->fk_forma = $valor;
	}
	
	public function SetFkStatus($valor)
	{
		$this->fk_status = $valor;
	}
	
	public function SetPedTotal($valor)
	{
		$this->ped_total = $valor;
	}
	
	public function SetPedSessao($valor)
	{
		
		$this->ped_sessao = $valor;
	}
	
	public function SetPedIp($valor)
	{
		$this->ped_ip = $valor;
	}
	
	public function SetPedBrowser($valor)
	{
		$this->ped_browser = $valor;
	}
	
	public function SetFkPag($valor)
	{
		$this->fk_pag = $valor;
	}
	
	public function SetPedDataPag($valor)
	{
		$this->ped_data_pag = $valor;
	}
	
	public function SetFkFinal($valor)
	{
		$this->fk_final = $valor;
	}
	
	public function SetPedValorPago($valor)
	{
		$this->ped_valor_pago = $valor;
	}
	
	////////////////////////////////////////////
		
	public function GetPedId()
	{
		return $this->ped_id;
	}
	
	public function GetFkUsu()
	{
		return $this->fk_usu;
	}
	
	public function GetPedTransId()
	{
		return $this->ped_transid;
	}
	
	public function GetPedFrete()
	{
		return $this->ped_frete;
	}
	
	public function GetOrdDate()
	{
		return $this->ord_date;
	}
	
	public function GetFkForma()
	{
		return $this->fk_forma;
	}
	
	public function GetFkStatus()
	{
		return $this->fk_status;
	}
	
	public function GetPedTotal()
	{
		return $this->ped_totalr;
	}
	
	public function GetPedSessao()
	{
		
		return $this->ped_sessao;
	}
	
	public function GetPedIp()
	{
		return $this->ped_ip;
	}
	
	public function GetPedBrowser()
	{
		return $this->ped_browser;
	}
	
	public function GetFkPag()
	{
		return $this->fk_pag;
	}
	
	public function GetPedDataPag()
	{
		return $this->ped_data_pag;
	}
	
	public function GetFkFinal()
	{
		return $this->fk_finalr;
	}
	
	public function GetPedValorPago()
	{
		return $this->ped_valor_pago;
	}

}