<?php 

class  TbMeioPagamento extends MeioPagamentoRepository
{
	private $nome;
	private $email;
	private $tipo_lojista;
	private $sistema;
	private $categoriaid;
	private $atendimentoemail;
	private $ddd_atendimentotel;
	private $atendimentotel;
	private $ddd_atendimentotel2;
	private $atendimentotel2;
	private $ddd_atendimentotel3;
	private $atendimentotel3;
	private $ddd_atendimentotel4;
	private $atendimentotel4;
	private $ddd_atendimentotel5;
	private $atendimentotel5;
	private $ddd_atendimentotel6;
	private $atendimentotel6;
	private $ddd_atendimentotel7;
	private $atendimentotel7;
	private $site;
	private $softdescriptor;
	private $pass;
	
	private $cnpj;
	private $razaosocial;
	private $empresa_ddd_tel;
	private $empresa_telefone;
	private $empresa_cep;
	private $empresa_logradouro;
	private $empresa_numero;
	private $empresa_complemento;
	private $empresa_bairro;
	private $empresa_cidade;
	private $empresa_estado;
	
	private $responsavel_name;
	private $responsavel_cpf;
	private $responsavel_datanasc;
	private $responsavel_telefone;
	private $responsavel_cep;
	private $responsavel_logradouro;
	private $responsavel_numero;
	private $responsavel_bairro;
	private $responsavel_cidade;
	private $responsavel_estado;
	
	private $recebedor_email;
	private $recebedor_api_token;
	private $pagador_nome;
	private $pagador_email;
	private $pagador_cpf;
	private $pagador_telefone_ddd;
	private $pagador_telefone;
	private $entrega_nome;
	private $entrega_logradouro;
	private $entrega_numero;
	private $entrega_complemento;
	private $entrega_bairro;
	private $entrega_cep;
	private $entrega_cidade;
	private $entrega_estado;
	private $entrega_pais;
	private $pedido_id;
	private $pedido_valor_total_original;
	private $pedido_meio_pagamento;
	private $pedido_moeda;
	private $pedido_url_redirecionamento;
	
	
	public function Setnome($valor)
	{
		$this->nome = $valor;
	}
	
	public function Setemail($valor)
	{
		$this->email = strtolower(str_replace(' ','',$valor));
	}
	
	public function Settipo_lojista($valor)
	{
		$this->tipo_lojista = $valor;
	}
	
	public function Setsistema($valor)
	{
		$this->sistema = $valor;
	}
	
	public function Setcategoriaid($valor)
	{
		$this->categoriaid = $valor;
	}
	
	public function Setatendimentoemail($valor)
	{
		$this->atendimentoemail = strtolower(str_replace(' ','',$valor));
	}
	
	public function Setddd_atendimentotel($valor)
	{
		$this->ddd_atendimentotel = $valor;
	}
	
	public function Setatendimentotel($valor)
	{
		$this->atendimentotel = $valor;
	}
	
	public function Setddd_atendimentotel2($valor)
	{
		$this->ddd_atendimentotel2 = $valor;
	}
	
	public function Setatendimentotel2($valor)
	{
		$this->atendimentotel2 = $valor;
	}
	
	public function Setddd_atendimentotel3($valor)
	{
		$this->ddd_atendimentotel3 = $valor;
	}
	
	public function Setatendimentotel3($valor)
	{
		$this->atendimentotel3 = $valor;
	}
	
	public function Setddd_atendimentotel4($valor)
	{
		$this->ddd_atendimentotel4 = $valor;
	}
	
	public function Setatendimentotel4($valor)
	{
		$this->atendimentotel4 = $valor;
	}
	
	public function Setddd_atendimentotel5($valor)
	{
		$this->ddd_atendimentotel5 = $valor;
	}
	
	public function Setatendimentotel5($valor)
	{
		$this->atendimentotel5 = $valor;
	}
	
	public function Setddd_atendimentotel6($valor)
	{
		$this->ddd_atendimentotel6 = $valor;
	}
	
	public function Setatendimentotel6($valor)
	{
		$this->atendimentotel6 = $valor;
	}
	
	public function Setddd_atendimentotel7($valor)
	{
		$this->ddd_atendimentotel7 = $valor;
	}
	
	public function Setatendimentotel7($valor)
	{
		$this->atendimentotel7 = $valor;
	}
	
	
	public function Setsite($valor)
	{
		$this->site = strtolower(str_replace(' ','',$valor));
	}
	
	public function Setsoftdescriptor($valor)
	{
		$this->softdescriptor = $valor;
	}
	
	public function Setpass($valor)
	{
		$this->pass = strtolower(str_replace(' ','',$valor));
	}
	
	public function Setcnpj($valor)
	{
		$this->cnpj = str_replace('/','',str_replace(' ','',str_replace('-','',str_replace('.', '', $valor))));
	}
	
	public function Setrazaosocial($valor)
	{
		$this->razaosocial = $valor;
	}
	
	public function Setempresa_ddd_tel($valor)
	{
		$this->empresa_ddd_tel = $valor;
	}
	
	public function Setempresa_telefone($valor)
	{
		$this->empresa_telefone = $valor;
	}
	
	public function Setempresa_cep($valor)
	{
		$this->empresa_cep = str_replace('-','',$valor);
	}
	
	public function Setempresa_logradouro($valor)
	{
		$this->empresa_logradouro = $valor;
	}
	
	public function Setempresa_numero($valor)
	{
		$this->empresa_numero = $valor;
	}
	
	public function Setempresa_complemento($valor)
	{
		$this->empresa_complemento = $valor;
	}
	
	public function Setempresa_bairro($valor)
	{
		$this->empresa_bairro = $valor;
	}
	
	public function Setempresa_cidade($valor)
	{
		$this->empresa_cidade = $valor;
	}
	
	public function Setempresa_estado($valor)
	{
		$this->empresa_estado = $valor;
	}
	
	
	
	public function Setresponsavel_name($valor)
	{
		$this->responsavel_name = $valor;
	}
	
	public function Setresponsavel_cpf($valor)
	{
		$this->responsavel_cpf = $valor;
	}
	
	public function Setresponsavel_datanasc($valor)
	{
		$this->responsavel_datanasc = $valor;
	}
	
	public function Setresponsavel_telefone($valor)
	{
		$this->responsavel_telefone = str_replace(' ','',$valor);
	}
	
	public function Setresponsavel_cep($valor)
	{
		$this->responsavel_cep = $valor;
	}
	
	public function Setresponsavel_logradouro($valor)
	{
		$this->responsavel_logradouro = $valor;
	}
	
	public function Setresponsavel_numero($valor)
	{
		$this->responsavel_numero = $valor;
	}
	
	public function Setresponsavel_bairro($valor)
	{
		$this->responsavel_bairro = $valor;
	}
	
	public function Setresponsavel_cidade($valor)
	{
		$this->responsavel_cidade = $valor;
	}
	
	public function Setresponsavel_estado($valor)
	{
		$this->responsavel_estado = $valor;
	}
	
	
	
	public function Setrecebedor_email($valor)
	{
		$this->recebedor_email = $valor;
	}
	
	public function Setrecebedor_api_token($valor)
	{
		$this->recebedor_api_token = $valor;
	}
	
	public function Setpagador_nome($valor)
	{
		$this->pagador_nome = $valor;
	}
	
	public function Setpagador_email($valor)
	{
		$this->pagador_email = $valor;
	}
	
	public function Setpagador_cpf($valor)
	{
		$this->pagador_cpf = $valor;
	}
	
	public function Setpagador_telefone_ddd($valor)
	{
		$this->pagador_telefone_ddd = $valor;
	}
	
	public function Setpagador_telefone($valor)
	{
		$this->pagador_telefone = $valor;
	}
	
	public function Setentrega_nome($valor)
	{
		$this->entrega_nome = $valor;
	}
	
	public function Setentrega_logradouro($valor)
	{
		$this->entrega_logradouro = $valor;
	}
	
	public function Setentrega_numero($valor)
	{
		$this->entrega_numero = $valor;
	}
	
	public function Setentrega_complemento($valor)
	{
		$this->entrega_complemento = $valor;
	}
	
	public function Setentrega_bairro($valor)
	{
		$this->entrega_bairro = $valor;
	}
	
	public function Setentrega_cep($valor)
	{
		$this->entrega_cep = $valor;
	}
	
	public function Setentrega_cidade($valor)
	{
		$this->entrega_cidade = $valor;
	}
	
	public function Setentrega_estado($valor)
	{
		$this->entrega_estado = $valor;
	}
	
	public function Setentrega_pais($valor)
	{
		$this->entrega_pais = $valor;
	}
	
	public function Setpedido_id($valor)
	{
		$this->pedido_id = $valor;
	}
	
	public function Setpedido_valor_total_original($valor)
	{
		$this->pedido_valor_total_original = $valor;
	}
	
	public function Setpedido_meio_pagamento($valor)
	{
		$this->pedido_meio_pagamento = $valor;
	}
	
	public function Setpedido_moeda($valor)
	{
		$this->pedido_moeda = $valor;
	}
	
	public function Setpedido_url_redirecionamento($valor)
	{
		$this->pedido_url_redirecionamento = $valor;
	}
	
	
	///////////////////////////////
	
	
	public function Getnome()
	{
		return $this->nome;
	}
	
	public function Getemail()
	{
		return $this->email;
	}
	
	public function Gettipo_lojista()
	{
		return $this->tipo_lojista;
	}
	
	public function Getsistema()
	{
		return $this->sistema;
	}
	
	public function Getcategoriaid()
	{
		return $this->categoriaid;
	}
	
	public function Getatendimentoemail()
	{
		return $this->atendimentoemail;
	}
	
	public function Getddd_atendimentotel()
	{
		return $this->ddd_atendimentotel;
	}
	
	public function Getatendimentotel()
	{
		return $this->atendimentotel;
	}
	
	public function Getddd_atendimentotel2()
	{
		return $this->ddd_atendimentotel2;
	}
	
	public function Getatendimentotel2()
	{
		return $this->atendimentotel2;
	}
	
	public function Getddd_atendimentotel3()
	{
		return $this->ddd_atendimentotel3;
	}
	
	public function Getatendimentotel3()
	{
		return $this->atendimentotel3;
	}
	
	public function Getddd_atendimentotel4()
	{
		return $this->ddd_atendimentotel4;
	}
	
	public function Getatendimentotel4()
	{
		return $this->atendimentotel4;
	}
	
	public function Getddd_atendimentotel5()
	{
		return $this->ddd_atendimentotel5;
	}
	
	public function Getatendimentotel5()
	{
		return $this->atendimentotel5;
	}
	
	public function Getddd_atendimentotel6()
	{
		return $this->ddd_atendimentotel6;
	}
	
	public function Getatendimentotel6()
	{
		return $this->atendimentotel6;
	}
	
	public function Getddd_atendimentotel7()
	{
		return $this->ddd_atendimentotel7;
	}
	
	public function Getatendimentotel7()
	{
		return $this->atendimentotel7;
	}
	
	
	public function Getsite()
	{
		return $this->site;
	}
	
	public function Getsoftdescriptor()
	{
		return $this->softdescriptor;
	}
	
	public function Getpass()
	{
		return $this->pass;
	}
	
	public function Getcnpj()
	{
		return $this->cnpj;
	}
	
	public function Getrazaosocial()
	{
		return $this->razaosocial;
	}
	
	public function Getempresa_ddd_tel()
	{
		return $this->empresa_ddd_tel;
	}
	
	public function Getempresa_telefone()
	{
		return $this->empresa_telefone;
	}
	
	public function Getempresa_cep()
	{
		return $this->empresa_cep;
	}
	
	public function Getempresa_logradouro()
	{
		return $this->empresa_logradouro;
	}
	
	public function Getempresa_numero()
	{
		return $this->empresa_numero;
	}
	
	public function Getempresa_complemento()
	{
		return $this->empresa_complemento;
	}
	
	public function Getempresa_bairro()
	{
		return $this->empresa_bairro;
	}
	
	public function Getempresa_cidade()
	{
		return $this->empresa_cidade;
	}
	
	public function Getempresa_estado()
	{
		return $this->empresa_estado;
	}
	
	
	
	public function Getresponsavel_name()
	{
		return $this->responsavel_name;
	}
	
	public function Getresponsavel_cpf()
	{
		return $this->responsavel_cpf;
	}
	
	public function Getresponsavel_datanasc()
	{
		return $this->responsavel_datanasc;
	}
	
	public function Getresponsavel_telefone()
	{
		return $this->responsavel_telefone;
	}
	
	public function Getresponsavel_cep()
	{
		return $this->responsavel_cep;
	}
	
	public function Getresponsavel_logradouro()
	{
		return $this->responsavel_logradouro;
	}
	
	public function Getresponsavel_numero()
	{
		return $this->responsavel_numero;
	}
	
	public function Getresponsavel_bairro()
	{
		return $this->responsavel_bairro;
	}
	
	public function Getresponsavel_cidade()
	{
		return $this->responsavel_cidade;
	}
	
	public function Getresponsavel_estado()
	{
		return $this->responsavel_estado;
	}
	
	
	
	public function Getrecebedor_email()
	{
		return $this->recebedor_email;
	}
	
	public function Getrecebedor_api_token()
	{
		return $this->recebedor_api_token;
	}
	
	public function Getpagador_nome()
	{
		return $this->pagador_nome;
	}
	
	public function Getpagador_email()
	{
		return $this->pagador_email;
	}
	
	public function Getpagador_cpf()
	{
		return $this->pagador_cpf;
	}
	
	public function Getpagador_telefone_ddd()
	{
		return $this->pagador_telefone_ddd;
	}
	
	public function Getpagador_telefone()
	{
		return $this->pagador_telefone;
	}
	
	public function Getentrega_nome()
	{
		return $this->entrega_nome;
	}
	
	public function Getentrega_logradouro()
	{
		return $this->entrega_logradouro;
	}
	
	public function Getentrega_numero()
	{
		return $this->entrega_numero;
	}
	
	public function Getentrega_complemento()
	{
		return $this->entrega_complemento;
	}
	
	public function Getentrega_bairro()
	{
		return $this->entrega_bairro;
	}
	
	public function Getentrega_cep()
	{
		return $this->entrega_cep;
	}
	
	public function Getentrega_cidade()
	{
		return $this->entrega_cidade;
	}
	
	public function Getentrega_estado()
	{
		return $this->entrega_estado;
	}
	
	public function Getentrega_pais()
	{
		return $this->entrega_pais;
	}
	
	public function Getpedido_id()
	{
		return $this->pedido_id;
	}
	
	public function Getpedido_valor_total_original()
	{
		return $this->pedido_valor_total_original;
	}
	
	public function Getpedido_meio_pagamento()
	{
		return $this->pedido_meio_pagamento;
	}
	
	public function Getpedido_moeda()
	{
		return $this->pedido_moeda;
	}
	
	public function Getpedido_url_redirecionamento()
	{
		return $this->pedido_url_redirecionamento;
	}
	

}