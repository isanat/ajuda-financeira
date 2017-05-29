<?php 

class  TbUsuarios extends UsuarioRepository
{
	private $usu_nome;
	private $usu_logo;
	private $usu_usuario;
	private $usu_senha;
	private $usu_seguranca;
	private $fk_status;
	private $usu_datanasc;
	private $fk_type;
	private $usu_doc;
	private $usu_data;
	private $fk_usu;
	private $usu_perna;
	private $usu_perna_pref;
	private $usu_sexo;
	private $fk_usu_rede;
	private $fk_bonus;
	private $usu_email;
	private $usu_perna_auto;
	private $usu_auto_ativacao;
	
	public function SetUsuNome($valor)
	{
		$this->usu_nome = $valor;
	}
	
	public function SetUsuLogo($valor)
	{
		$this->usu_logo = $valor;
	}
	
	public function SetUsuUsuario($valor)
	{
		$this->usu_usuario = strtolower(str_replace(' ','',$valor));
	}
	
	public function SetUsuSenha($valor)
	{
		$this->usu_senha = $this->Password($valor);
	}
	
	public function SetUsuSeguranca($valor)
	{
		$this->usu_seguranca = $this->Password($valor);
	}
	
	public function SetFkStatus($valor)
	{
		$this->fk_status = $valor;
	}
	
	public function SetUsuDatanasc($valor)
	{
		$this->usu_datanasc = $this->banco->PtUs($valor);
	}
	
	public function SetFkType($valor)
	{
		$this->fk_type = $valor;
	}
	
	public function SetUsuDoc($valor)
	{
		
		$this->usu_doc = str_replace(' ','',str_replace('-','',str_replace('.', '', $valor)));
	}
	
	public function SetUsuData($valor)
	{
		$this->usu_data = $valor;
	}
	
	public function SetFkUsu($valor)
	{
		$this->fk_usu = str_replace(' ','',str_replace('-','',str_replace('.', '', $valor)));
	}
	
	public function SetUsuPerna($valor)
	{
		$this->usu_perna = $valor;
	}
	
	public function SetUsuPernaPref($valor)
	{
		$this->usu_perna_pref = $valor;
	}
	
	public function SetUsuSexo($valor)
	{
		$this->usu_sexo = strtolower($valor);
	}
	
	public function SetFkUsuRede($valor)
	{
		$this->fk_usu_rede = $valor;
	}
	
	public function SetFkBonus($valor)
	{
		$this->fk_bonus = $valor;
	}
	
	public function SetUsuEmail($valor)
	{
		$this->usu_email = strtolower(str_replace(' ','',$valor));
	}
	
	public function SetUsuPernaAuto($valor)
	{
		$this->usu_perna_auto = $valor;
	}
	
	public function SetUsuAutoAtivacao($valor)
	{
		$this->usu_auto_ativacao = $valor;
	}
	
		
	public function GetUsuNome()
	{
		return $this->usu_nome;
	}
	
	public function GetUsuLogo()
	{
		return $this->usu_logo;
	}
	
	public function GetUsuUsuario()
	{
		return $this->usu_usuario;
	}
	
	public function GetUsuSenha()
	{
		return $this->usu_senha;
	}
	
	public function GetUsuSeguranca()
	{
		return $this->usu_seguranca;
	}
	
	public function GetFkStatus()
	{
		return $this->fk_status;
	}
	
	public function GetUsuDatanasc()
	{
		return $this->usu_datanasc;
	}
	
	public function GetFkType()
	{
		return $this->fk_type;
	}
	
	public function GetUsuDoc()
	{
		return $this->usu_doc;
	}
	
	public function GetUsuData()
	{
		return $this->usu_data;
	}
	
	public function GetFkUsu()
	{
		return $this->fk_usu;
	}
	
	public function GetUsuPerna()
	{
		return $this->usu_perna;
	}
	
	public function GetUsuPernaPref()
	{
		return $this->usu_perna_pref;
	}
	
	public function GetUsuSexo()
	{
		return $this->usu_sexo;
	}
	
	public function GetFkUsuRede()
	{
		return $this->fk_usu_rede;
	}
	
	public function GetFkBonus()
	{
		return $this->fk_bonus;
	}
	
	public function GetUsuEmail()
	{
		return $this->usu_email;
	}

	public function GetUsuPernaAuto()
	{
		return $this->usu_perna_auto;
	}
	
	public function GetUsuAutoAtivacao()
	{
		return $this->usu_auto_ativacao;
	}

}