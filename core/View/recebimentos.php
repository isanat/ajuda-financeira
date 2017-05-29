<script src="http://<?php echo $dados['host'];?>/core/View/js/livequery.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/recebimentos.js"></script>

<?php if(!empty($dados['model']['inativo'][0])){ ?>
<div class="alert alert-error">
<strong>ATENÇÃO!</strong> 
Você tem até o dia <strong><?php echo $dados['model']['inativo'][0]['ped_data_expira']; ?></strong> para efetuar sua 1º doação.</div>
<?php } ?>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<h2>Meios de Recebimento</h2>
<div class="x_content">

<div class="social-box">

<div class="body">
  <div class="alert alert-info">
       Facilite para quem vai lhe doar, mantenha sempre seus dados atualizados.       
  </div>
  <p>
   
   <p> <span class="msg"></span></p>
    
  <table width="100%" border="0" class="table table-striped">
  <tr>
    <td>
    <strong>E-mail cadastrado no ContaSuper 
    <span style="color:#F00">*</span> (Recomendado)</strong> <a href="https://www.contasuper.com.br/NovoCadastro" target="_blank">Abrir conta</a></td>
  </tr>
  <tr>
    <td>
 <input style="width:300px" name="contasuper" id="contasuper" type="text" placeholder="ContaSuper" class="form-control" value="<?php echo $dados['model']['receb'][0]['conta_super']?>" /></td>
  </tr>
  <tr>
    <td><strong>E-mail cadastrado no PagSeguro</strong></td>
  </tr>
  <tr>
    <td><input style="width:300px" name="pagseguro" id="pagseguro" type="text" placeholder="PagSeguro" class="form-control" value="<?php echo $dados['model']['receb'][0]['pagseguro']?>" /></td>
  </tr>
  <tr>
    <td><strong>E-mail cadastrado no Paypal</strong></td>
  </tr>
  <tr>
    <td><input style="width:300px" name="paypal" id="paypal" type="text" placeholder="Paypal" class="form-control" value="<?php echo $dados['model']['receb'][0]['paypal']?>" /></td>
  </tr>
</table>
</div><p>
<div class="form-actions">
    <div class="span6 offset2">
        <input class="btn btn-primary" type="submit" id="criar" value="Criar Conta">
    </div>
 </div>
</div>

	</div>
  </div>
</div>