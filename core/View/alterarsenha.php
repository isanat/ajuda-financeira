<?php if(!empty($dados['model']['inativo'][0])){ ?>
<div class="alert alert-error">
<strong>ATENÇÃO!</strong> 
Você tem até o dia <strong><?php echo $dados['model']['inativo'][0]['ped_data_expira']; ?></strong> para efetuar sua 1º doação.</div>
<?php } ?>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<h2>Alterar Senha</h2>
<div class="x_content">	
<span id="resSenha"></span>
<div class="social-box">
	<div class="body">
        
		<table class="table table-striped">
			<tbody>
				<tr>
					<td class="span2">Senha atual</td>
					<td>					
						<input style="width:300px" id="usu_senha" name="usu_senha" placeholder="Senha atual" class="form-control vazio" required="" type="password">
                        <span id="confSenhaAtual"></span>
					</td>					
				</tr>
				<tr>
					<td>Nova Senha</td>
					<td >				
						<input style="width:300px" id="n_usu_senha" name="n_usu_senha" placeholder="Nova senha" class="form-control vazio" required="" type="password">
                        <span id="confSenhaNova"></span>
                        <span id="login-secure-important" class="label label-important">&nbsp;</span>
                        <span id="login-secure-warning" class="label label-warning">&nbsp;</span>
                        <span id="login-secure-success" class="label label-success">&nbsp;</span>
					</td>					
				</tr>
				<tr>
					<td>Confirmar Senha</td>
					<td >
                    	<input style="width:300px" id="c_usu_senha" name="c_usu_senha" placeholder="Confirme nova senha" class="form-control vazio" required="" type="password">
                        <span id="confSenhaNovaAgain"></span>
                    </td>					
				</tr>
				<tr>
					<td colspan="4">					
						<button id="cadastrar" name="comprar" class="btn btn-primary">Salvar</button>						
					</td>					
				</tr>
			</tbody>
		</table>
	</div>
</div>

	</div>
  </div>
</div>