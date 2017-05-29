<?php 

class Adm extends TbUsuarios
{

	
	public function home_adm()
	{
		$res_forn = $this->banco->executar('SELECT f.fn_nome, sum(c.cart_qtd*c.cart_valor) as subtotal, sum(c.cart_qtd*ca.carac_custo) as custototal, sum(c.cart_qtd*c.cart_valor)-sum(c.cart_qtd*ca.carac_custo) as liquido FROM public.tb_carrinho c
												INNER JOIN public.tb_pedidos p ON c.fk_sessao = p.ped_sessao
												INNER JOIN public.tb_produtos pro ON pro.pro_id::text = c.fk_prod::text
												INNER JOIN public.tb_caracteristicas ca ON pro.pro_cod = ca.fk_prod
												INNER JOIN public.tb_fornecedor f ON f.fn_id = pro.fk_fornecedor
												WHERE p.fk_status = 3
												GROUP BY pro.fk_fornecedor, f.fn_nome');
		
		$res_prod = $this->banco->executar('SELECT pro.pro_nome, sum(c.cart_qtd*c.cart_valor) as subtotal, sum(c.cart_qtd) as qtd, sum(c.cart_pontos) as pontos
												FROM public.tb_carrinho c
												INNER JOIN public.tb_pedidos p ON c.fk_sessao = p.ped_sessao
												INNER JOIN public.tb_produtos pro ON pro.pro_id::text = c.fk_prod::text
												WHERE p.fk_status = 3
												GROUP BY pro.pro_nome ORDER BY pro.pro_nome ASC');
		
		$res_dest = $this->banco->executar('SELECT (sum(c.cart_qtd*c.cart_valor)/100)*8 as impostos, 
												(sum(c.cart_qtd*c.cart_valor)/100)*3 as ti,
												sum(c.cart_pontos)*3 as bonus
												FROM public.tb_carrinho c
												INNER JOIN public.tb_pedidos p ON c.fk_sessao = p.ped_sessao
												INNER JOIN public.tb_produtos pro ON pro.pro_id::text = c.fk_prod::text
												WHERE p.fk_status = 3');
		
		return array(
				'fornecedor' => $res_forn,
				'produtos' => $res_prod,
				'destino' => $res_dest
				
				);
		
	}
	
	public function deb_cred()
	{
		return $this->banco->executar("SELECT u.usu_usuario, m.mvm_valor as valor, c.cta_numero, to_char(m.mvm_data, 'DD/MM/YYYY') as data FROM banco.tb_movimento  m
								INNER JOIN banco.tb_conta_corrente c ON c.cta_numero = m.fk_conta_corrente
								INNER JOIN public.tb_usuarios u ON u.usu_doc = c.fk_usu_doc
								WHERE m.fk_tipo_movimento = 18");
	}
	
	public function ver_usu_deb()
	{
		$usu =  $this->banco->executar("SELECT u.usu_usuario, c.cta_numero as conta FROM banco.tb_conta_corrente  c
								INNER JOIN public.tb_usuarios u ON u.usu_doc = c.fk_usu_doc
								WHERE u.usu_usuario = '{$_POST['usu']}'");
// 		echo 'ok';die;
		if(empty($usu[0]))
		{
			return array('template' => 'null',
					'retorno' => 'nao');
			
		}else{
		
		return array('template' => 'null',
					'retorno' => 'sim',
					'res' => $usu[0]);
		
		}
	}
	
	public function debitar_forcado()
	{
		$dados = array(
				'fk_conta_corrente' => $_POST['conta'],
				'fk_tipo_movimento' => 18,
				'fk_status_movimento' => 2,
				'mvm_data' => 'NOW()',
				'mvm_valor' => str_replace(',','.', str_replace('.','', $_POST['valor']))
				);
		
		$this->banco->inserir('banco.tb_movimento', $dados);
		
		$conta = new ContaCorrente;
		
		$conta->saldo_atual($_POST['conta']);
		
		return array('template' => 'null',
				'retorno' => 'sim');
				
	}

	public function login_adm()
	{
		if($_POST != null)
		{
			$this->SetUsuEmail($_POST['email']);
			$this->SetUsuSenha($_POST['password']);
			$this->LoginUserAdm();
		}
		
		return array(
				'template' => 'login_adm'
		);

	}
	
	public function sair()
	{
		unset($_SESSION['usuario']);
		header('location:../Adm/login_adm');
	}
	
	public function __call($metodo,$argumanto)
	{
		return 'erro';
	
	}
}