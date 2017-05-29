<?php 

class  TbCd extends CdRepository
{
	private $cd_nome;
	private $cd_logo;
	private $cd_usuario;
	private $cd_senha;
	private $fk_status;
	private $cd_doc;
	private $cd_data;
	private $cd_email;
	private $cd_token;
	private $cd_cep;
	private $cd_end;
	private $cd_n;
	private $cd_comp;
	private $cd_bairro;
	private $cd_cidade;
	private $cd_uf;
	
	public function SetCdNome($valor)
	{
		$this->cd_nome = $valor;
	}
	
	public function SetCdLogo($valor)
	{
		$this->cd_logo = $valor;
	}
	
	public function SetCdUsuario($valor)
	{
		$this->cd_usuario = strtolower(str_replace(' ','',$valor));
	}
	
	public function SetCdSenha($valor)
	{
		$this->cd_senha = $this->Password($valor);
	}
	
	
	public function SetFkStatus($valor)
	{
		$this->fk_status = $valor;
	}
	
	
	public function SetCdDoc($valor)
	{
		
		$this->cd_doc = str_replace(' ','',str_replace('-','',str_replace('.', '', $valor)));
	}
	
	public function SetCdData($valor)
	{
		$this->cd_data = $valor;
	}	
	
	public function SetCdEmail($valor)
	{
		$this->cd_email = strtolower(str_replace(' ','',$valor));
	}
	
	public function SetCdToken($valor)
	{
		$this->cd_token = $valor;
	}
	
	public function SetCdCep($valor)
	{
		$this->cd_cep = str_replace(' ','',str_replace('-','',str_replace('.', '', $valor)));
	}
	
	public function SetCdEnd($valor)
	{
		$this->cd_end = $valor;
	}
	
	public function SetCdN($valor)
	{
		$this->cd_n = $valor;
	}
	public function SetCdComp($valor)
	{
		$this->cd_comp = $valor;
	}
	public function SetCdBairro($valor)
	{
		$this->cd_bairro = $valor;
	}
	public function SetCdCidade($valor)
	{
		$this->cd_cidade = $valor;
	}
	public function SetCdUf($valor)
	{
		$this->cd_uf = $valor;
	}
	////////////////////////////////////////////
		
	public function GetCdNome()
	{
		return $this->cd_nome;
	}
	
	public function GetCdLogo()
	{
		return $this->cd_logo;
	}
	
	public function GetCdUsuario()
	{
		return $this->cd_usuario;
	}
	
	public function GetCdSenha()
	{
		return $this->cd_senha;
	}
	
	public function GetFkStatus()
	{
		return $this->fk_status;
	}
	
	public function GetCdDoc()
	{
		return $this->cd_doc;
	}
	
	public function GetCdData()
	{
		return $this->cd_data;
	}
	
	public function GetCdEmail()
	{
		return $this->cd_email;
	}

	public function GetCdToken()
	{
		return $this->cd_token;
	}
	
	public function GetCdCep()
	{
		return $this->cd_cep;
	}
	
	public function GetCdEnd()
	{
		return $this->cd_end;
	}
	
	public function GetCdN()
	{
		return $this->cd_n;
	}
	public function GetCdComp()
	{
		return $this->cd_comp;
	}
	public function GetCdBairro()
	{
		return $this->cd_bairro;
	}
	public function GetCdCidade()
	{
		return $this->cd_cidade;
	}
	public function GetCdUf()
	{
		return $this->cd_uf;
	}

}