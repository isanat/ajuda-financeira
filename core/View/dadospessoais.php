<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/jquery.maskedinput.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/dadospessoais.js"></script>

<?php if(!empty($dados['model']['inativo'][0])){ ?>
<div class="alert alert-error">
<strong>ATENÇÃO!</strong> 
Você tem até o dia <strong><?php echo $dados['model']['inativo'][0]['ped_data_expira']; ?></strong> para efetuar sua 1º doação.</div>
<?php } ?>




<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">

<h2>Meus Dados</h2>
<div id="erro"></div>

<br>
<div class="x_content">
<table width="100%" class="table table-striped">
			<tbody>				
				<tr>
					<td width="13%"><strong>Usuário</strong></td>
					<td width="87%" colspan="3">
					<div class="col-md-5 col-sm-5 col-xs-12 form-group has-feedback">
						<input style="width:300px" type="text" class="form-control has-feedback-left" id="inputSuccess2" disabled placeholder="Usuário" value="<?php echo $dados['model']['usu'][0]['usu_usuario']?>">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>								
					</td>
				</tr>
				<tr>
					<td><strong>Nome</strong></td>
					<td colspan="3">
			          <input id="usu_nome" style="width:300px" name="usu_nome" class="form-control" value="<?php echo $dados['model']['usu'][0]['usu_nome']?>" required type="text">
					</td>
				</tr>		
				<tr>
					<td><strong>Sexo</strong></td>
					<td colspan="3">
					
						<div class="control-group">
					      <div class="controls">
					        <label class="radio inline" for="usu_sexo-0">
<input name="usu_sexo" class='usu_sexo' id="usu_sexo-0" value="m" <?php if($dados['model']['usu'][0]['usu_sexo'] == 'm'){echo 'checked';}?> type="radio">
					          Masculino
					        </label>
					        <label class="radio inline" for="usu_sexo-1">
 <input name="usu_sexo" class='usu_sexo' id="usu_sexo-1" <?php if($dados['model']['usu'][0]['usu_sexo'] == 'f'){echo 'checked';}?> value="f" type="radio">
					          Feminino
					        </label>
					      </div>
					    </div>					
					
					</td>
				</tr>
				<tr>
					<td><strong>E-mail</strong></td>
					<td colspan="3">
				      
					  <input type="text" style="width:300px" class="form-control col-md-7 col-xs-5" id="usu_email" name="usu_email" value="<?php echo $dados['model']['usu'][0]['usu_email']?>" required placeholder="E-mail">
					  
					</td>
				</tr>
				<tr>
					<td><strong>Data de Nascimento</strong></td>
					<td colspan="3">
						<input id="usu_datanasc" style="width:300px" name="usu_datanasc" value="<?php echo $dados['model']['usu'][0]['usu_datanasc']?>" class="form-control col-md-7 col-xs-5" required type="text">
					</td>
				</tr>
				<tr>
					<td colspan="4">
					</td>
				</tr>
			</tbody>
		</table>
<div class="form-group">
	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	    <button id="atualizar_dados" name="comprar" class="btn btn-success">Atualizar Dados</button>
	</div>
</div>

</div>
</div>
</div>



<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<h2>Endereço</h2>
<div id="erro_end"></div>
<div class="x_content">	
<div class="social-box">
	<div class="body">
		<table width="100%" class="table table-striped">
			<tbody>
				<tr>
					<td width="13%"><strong>CEP</strong></td>
					<td width="87%" colspan="3">

<input id="end_cep" style="width:300px" name="end_cep" value="<?php echo $dados['model']['end'][0]['end_cep']?>" class="form-control" required type="text">
<img class="carregar" style="display:none" src="http://<?php echo $dados['host'];?>/core/View/img/load.gif" />
					</td>
				</tr>
				<tr>
					<td><strong>Endereço</strong></td>
					<td colspan="3">
					
						<input style="width:300px" id="end_end" name="end_end" value="<?php echo $dados['model']['end'][0]['end_end']?>" class="form-control" required type="text">					
					
					</td>
				</tr>
				<tr>
					<td><strong>Número</strong></td>
					<td colspan="3">
						<input style="width:300px" id="end_n" name="end_n" value="<?php echo $dados['model']['end'][0]['end_n']?>" class="form-control" required type="text">
					</td>
				</tr>
				<tr>
					<td><strong>Complemento</strong></td>
					<td colspan="3">
						<input style="width:300px" id="end_comp" name="end_comp" value="<?php echo $dados['model']['end'][0]['end_comp']?>" class="form-control" required type="text">
					</td>
				</tr>
				<tr>
					<td><strong>Bairro</strong></td>
					<td colspan="3">
					
						<input style="width:300px" id="end_bairro" name="end_bairro" value="<?php echo $dados['model']['end'][0]['end_bairro']?>" class="form-control" required type="text">					
					
					</td>
				</tr>
				<tr>
					<td><strong>Cidade</strong></td>
					<td colspan="3">
					
						<input style="width:300px" id="end_cidade" name="end_cidade" value="<?php echo $dados['model']['end'][0]['end_cidade']?>" class="form-control" required type="text">					
					
					</td>
				</tr>
				<tr>
					<td><strong>Estado</strong></td>
					<td colspan="3">
					
						<input style="width:300px" id="end_uf" maxlength="2" name="end_uf" value="<?php echo $dados['model']['end'][0]['end_uf']?>" class="form-control" required type="text">					
					
					</td>
				</tr>
				<tr>
					<td colspan="4">					
						<button style="width:300px" id="atualizar_end" name="comprar" class="btn btn-success">Atualizar Endereço</button>						
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</div>
</div>
</div>



<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<h2>Telefones</h2>
<div id="erro_fone"></div>
<div class="x_content">	


<div class="social-box">
	<div class="body">
		<table width="100%" class="table table-striped">
			<tbody>

<tr>
    <td width="132"><strong>Fixo</strong></td>
    <td width="1028" colspan="3">
        <input type="hidden" id="resid" value="<?php echo $dados['model']['resiId'];?>" />
        <input type="hidden" id="res" value="<?php echo $dados['model']['resi'];?>" />
        <input id="fone_fixo" style="width:300px" name="fone_fixo" placeholder="(99) 9999-9999" class="form-control" value="<?php echo $dados['model']['resi'];?>" required type="text">
    </td>
</tr>
<tr>
    <td><strong>Celular</strong></td>
    <td colspan="3">	
<input type="hidden" id="celid" value="<?php echo $dados['model']['celId'];?>" />	
<input type="hidden" id="cel" value="<?php echo $dados['model']['cel'];?>" />				
<input id="fone_celular" style="width:300px" name="fone_celular" placeholder="(99) 99999-9999" value="<?php echo $dados['model']['cel'] ;?>" class="form-control" required type="text">			
    </td>
</tr>
<tr>
    <td><strong>Whatsapp</strong></td>
    <td colspan="3">	
<input type="hidden" id="whatsId" value="<?php echo $dados['model']['whatsId'];?>" />	
<input type="hidden" id="whatsapp" value="<?php echo $dados['model']['whatsapp'];?>" />				
<input id="fone_whatsapp" style="width:300px" name="whatsapp" placeholder="(99) 9999-9999"  value="<?php echo $dados['model']['whatsapp'];?>" class="form-control" required type="text">			
    </td>
</tr>
<tr>
    <td><strong>Comercial</strong></td>
    <td colspan="3">		
    <input type="hidden" id="comerid" value="<?php echo $dados['model']['comerId'];?>" />	
        <input type="hidden" id="com" value="<?php echo $dados['model']['comer'];?>" />			
<input id="fone_comercial" style="width:300px" name="fone_comercial" placeholder="(99) 9999-9999" value="<?php echo $dados['model']['comer'];?>" class="form-control" required type="text">
    </td>
</tr>



<tr>
    <td colspan="4">					
        <button id="atualizar_fone" name="comprar" class="btn btn-primary">Atualizar Telefones</button>						
    </td>
</tr>

			</tbody>
		</table>
	</div>	
</div>

</div>
</div>
</div>