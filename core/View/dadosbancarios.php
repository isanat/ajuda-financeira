<?php if(!empty($dados['model']['inativo'][0])){ ?>
<div class="alert alert-error">
<strong>ATENÇÃO!</strong> 
Você tem até o dia <strong><?php echo $dados['model']['inativo'][0]['ped_data_expira']; ?></strong> para efetuar sua 1º doação.</div>
<?php } ?>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<h2>Adicionar Nova Conta</h2>
<div class="x_content">	

<div class="social-box">
	<div class="header">
		<?php if(isset($dados['model']['resultado']['ok'])){?>
				<div class="alert alert-success">
                  <button data-dismiss="alert" class="close" type="button">×</button>
                  <strong>Parabéns!</strong> <?php echo $dados['model']['resultado']['ok'];?>.
                </div>
		<?php }
		if(isset($dados['model']['resultado']['erro'])){?>
		
				<div class="alert alert-error">
                  <button data-dismiss="alert" class="close" type="button">×</button>
                  <strong>Atenção!</strong> <?php echo $dados['model']['resultado']['erro'];?>
                </div>
		<?php } ?>
	</div>
	<div class="body">
		<form action="dadosbancarios" method="post">
		<table class="table">
			<tbody>
				<tr>
					<td>Tipo</td>
					<td colspan="3">
					
						<div class="control-group">
					      <div class="controls">
					        <label class="radio inline" for="banco_tipo">
					          <input style="width:300px" name="banco_tipo" id="banco_tipoc" value="c" checked="checked" type="radio">
					          Corrente
					        </label>
					        <label class="radio inline" for="banco_tipo">
					          <input style="width:300px" name="banco_tipo" id="banco_tipop" value="p" type="radio">
					          Poupança
					        </label>
					      </div>
					    </div>					
					
					</td>
				</tr>
				<tr>
					<td>Banco</td>
					<td colspan="3">

						<div class="control-group">
					      <div class="controls">
					        <select style="width:300px" id="banco_code" name="banco_code" class="form-control">
					          <option value="0">Escolha seu Banco</option>
					          <?php
							   
							   foreach ($dados['model']['bancos'] as $cod){?>
					          <option value="<?php echo $cod['cod_code']?>" ><?php echo $cod['cod_nome']?></option>
					          <?php }?>
					        </select>
					      </div>
					    </div>
					
					</td>
				</tr>
				<tr>
					<td>Operação</td>
					<td colspan="3"><input style="width:100px" name="banco_op" type="text" class="form-control" id="agencia" placeholder="Operação" maxlength="3"></td>
				</tr>
				<tr>
					<td>Agência</td>
					<td colspan="3"><input style="width:100px" id="agencia" name="banco_agencia" placeholder="Agência" class="form-control" required type="text"> - <input style="width:50px" name="banco_agencia_digito" type="text" class="form-control" id="ng" placeholder="Dígito Agência" maxlength="2"></td>
				</tr>
				<tr>
					<td>Conta</td>
					<td colspan="3"><input style="width:100px" id="conta" name="banco_conta" placeholder="Conta" class="form-control" required type="text"> - <input style="width:50px" name="banco_digito_conta" type="text" required class="form-control" id="nc" placeholder="Dígito da Conta" maxlength="2"></td>
				</tr>
				<tr>
					<td>Favorecido</td>
					<td colspan="3"><input style="width:100px" id="conta" name="banco_favorecido" required placeholder="Favorecido" class="form-control" type="text"></td>
				</tr>
				<tr>
					<td>Observação<br>Dados opcionais<br>para depósito</td>
					<td colspan="3"><textarea style="width:300px" class="form-control" id="textarea" name="banco_obs"></textarea></td>
				</tr>
				<tr>
					<td colspan="4">
					
						<div class="form-actions">
                        <div class="span6 offset2">
                            <input type="hidden" name="insertB" value="ok" />
                            <input class="btn btn-primary" type="submit" id="submit-button" value="Criar Conta" />
                        </div>
                    </div>
						
					</td>
				</tr>
			</tbody>
		</table>
		</form>
	</div>
</div>

	</div>
  </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<h2>Contas Bancárias</h2>
<div class="x_content">	

<div class="social-box">
          <div class="body">
			
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Banco</th>
                  <th>Tipo</th>
                  <th>Operador</th>
                  <th>Agência</th>
                  <th>Conta</th>
                  <th>Favorecido</th>
                  <th>obs</th>
                  <th>Apagar</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($dados['model']['contas'] as $banco){?>
                <tr>
                  <td><?php echo $banco['cod_nome'] ?></td>
                  <td><?php if($banco['banco_tipo'] == 'c'){echo 'Corrente';}else{echo 'Poupança';} ?></td>
                  <td><?php echo $banco['banco_op']?></td>
                  <td><?php echo $banco['banco_agencia'].' - '. $banco['banco_agencia_digito']?></td>
                  <td><?php echo $banco['banco_conta'].' - '. $banco['banco_digito_conta']?></td>
                  <td><?php echo $banco['banco_favorecido']?></td>
                  <td><?php echo $banco['banco_obs']?></td>
                  <td>
                  <form action="dadosbancarios" method="POST">
					<input name="banco_id" value="<?php echo $banco['banco_id'] ?>" type="hidden">
                  	<button class="btn btn-danger" type="submit"><i class="fa fa-close"></i></button>
                  </form>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
			
          </div>
      </div>
	  
	</div>
  </div>
</div>