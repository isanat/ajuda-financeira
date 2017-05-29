<script src="http://<?php echo $dados['host'];?>/core/View/js/livequery.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/realizar.js"></script>

 <script src="http://<?php echo $dados['host'];?>/core/View/assets/js/ui-elements.general.js"></script>

<?php 
//echo "<pre>"; print_r($dados['model']); die;


if(!empty($dados['model']['inativo'][0])){ ?>
<div class="alert alert-error">
<strong>ATENÇÃO!</strong> 
Você tem até o dia <strong><?php echo $dados['model']['inativo'][0]['ped_data_expira']; ?></strong> para efetuar sua 1º doação.</div>
<?php } ?>
 
 
<div  id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="false" style="display: none; padding-right: 17px;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="myModalLabel" class="cbancaria" style='color:red'>Conta Bancária</h3>
    </div>
    <div class="modal-body">
        <span class="bank"></span>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
    </div>

		</div>
	</div>
</div>
 
 
 
<div  id="MyContato" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="false" style="display: none; padding-right: 17px;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="myModalLabel" class="cbancaria">Informações de Contato</h3>
    </div>
    <div class="modal-body">
        <span class="listContato"></span>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
    </div>

		</div>
	</div>
</div>
 
 

<!-- INICIO ENVIAR COMPROVANTE -->


<div  id="myEnviar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="false" style="display: none; padding-right: 17px;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="myModalLabel" class="enviar_comprovante">Enviar Comprovante</h3>
    </div>
    <div class="modal-body validCompro">
    
        <form action="../Doacoes/realizar" enctype="multipart/form-data" method="post" name="form">
            <div class="control-group">
              <label class="control-label" for="filebutton">Arquivo</label>
              <div class="controls">
                <input id="arquivo" name="arquivo" class="input-file" type="file">
              </div>
            </div>
            
            <div class="controls">
                <input type="hidden" id="comprovante" name="comprovante" value="" />
                <input type="hidden" id="id_ped" name="id_ped" value="" />
                <input type="hidden" id="id_compro" name="id_compro" value="" />
                <input type="hidden" name="acao" value="comprovante" /><p><p>
                <input type="submit" id="enviar" name="enviar" class="btn btn-primary" value="Enviar" />
            </div>
        </form>
       
                    
    </div>
    
     <div class="modal-body validComproMsg" style="display:none;"></div>
     <div class="modal-body validUsuarioMsg" style="display:none;"></div>
     <div class="modal-body confirmDoacao" style="display:none;"></div>

    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
    </div>

		</div>
	</div>
</div>

<!-- FIM ENVIAR COMPROVANTE -->


<?php  
if($dados['model']['retorno'] == "ok"){ ?>
    <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Parabéns!</strong> O Comprovante foi enviado com sucesso, aguarda a confirmação do Recebedor!</div>
<?php } if($dados['model']['formato'] == "no"){  ?>
    <div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>ERRO!</strong> O Formato do comprovante e inválido, aceitamos apenas<strong> ( jpeg, jpg, png )</strong> !</div>
<?php } if($dados['model']['banco'] == "no"){  ?>
    <div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>ERRO!</strong> Você só pode enviar o comprovante se esse usuário estiver um Conta Bancária cadastrada!</div>
<?php } ?>


<?php if($dados['model']['statusCompro'][0]['fk_status_compro'] == 4){  ?>
    <div class="alert alert-error">
    <strong>ATENÇÃO!</strong> 
    O comprovante enviado para <strong><?php echo $dados['model']['statusCompro'][0]['usu_usuario']; ?></strong>
    na data <strong><?php echo $dados['model']['statusCompro'][0]['compro_data_envio'] ?></strong> no valor de
    <strong>R$:<?php echo number_format($dados['model']['statusCompro'][0]['ped_total'], 2,",","."); ?></strong>
    foi cancelado, entre em contato com o usuário(a) <strong><?php echo $dados['model']['statusCompro'][0]['usu_usuario']; ?></strong><p><p>
    <strong>E-MAIL: </strong> <?php echo $dados['model']['statusCompro'][0]['usu_email'] ?> <strong>ENVIE NOVAMENTE O COMPROVANTE.</strong>
  </div>
<?php } ?>


<div class="social-box">
<div class="header">
  <h4>Doações para Realizar</h4>
</div>
<div class="alert alert-success">
  <strong>ATENÇÃO!<strong> Quando você receber o total de doações por nível o sistema informará automaticamente quando você deverá fazer a sua próxima doação, com um prazo limite de 48 horas. Caso passe da data de vencimento a sua Conta será automaticamente EXCLUÍDA, esta medida se faz necessário para o perfeito funcionamento do sistema, para que outras pessoas não se prejudiquem e possam assim, receber as suas doações por nível normalmente. </div>
<div class="body">
<table class="table table-striped responsive-utilities jambo_table bulk_actionssss">
  <thead>
    <tr>
      <th width="6%">UPLINES</th>
      <th width="11%">Usuários</th>
      <th width="16%">Contato do Usuário</th>
      <th width="10%">R$</th>
      <th width="12%">Data Pag.</th>
      <th width="14%" style="color:#F00">Vencimento</th>
      <th width="14%">Bancos</th>
      <th width="17%" style="text-align:center">Comprovante</th>
	  </tr>
	  </thead>
  <tbody>

  <?php   
      
	 // echo "<pre>"; print_r($dados['model']['statusCompro']); die;
	  
      $usuDoacao = $dados['model']['resultDoa']['resDoa'][0]['fk_pai'];
	  foreach($dados['model']['res'] as $res){  
	  
	  $disabled = ($res['usu_doc'] != $usuDoacao) ? "disabled" : "";
	  $banco    = ($res['usu_doc'] == $usuDoacao) ? "banco={$res['usu_doc']}" : ""; 
	  $classBanco = ($res['usu_doc'] == $usuDoacao) ? "banco" : ""; 
	  $comp    = ($res['usu_doc'] == $usuDoacao) ? "comp={$res['usu_doc']}" : "";
	  $pedId    = ($res['usu_doc'] == $usuDoacao) ? "pedId={$res['ped_id']}" : "";
  ?>
 
    <tr>
      <td><span class="badge label-warning"><?php echo $res['ped_nivel']; ?></span></td>
      <td><?php echo $res['usu_usuario']; ?></td>
      <td style="text-align:center">
        <a href='#MyContato' class="MyContato" contact='<?php echo $res['usu_doc']; ?>' data-toggle="modal">
            <img src="http://<?php echo $dados['host'];?>/core/View/img/contato.png" width="30" />
        </a>
      </td>    
      <td><?php echo number_format($res['ped_total'],2,",","."); ?></td>
      <td><span class="label label-success"><?php echo $res['ped_data_pag']; ?></span></td>
      <td><span class="label label-danger" style="background:#FF2F34"><?php echo $res['ped_data_expira']; ?></span></td>
      <td>
<?php
 if($res['fk_status'] == 1){
?>      
<button href="#myModal" data-toggle="modal" type="button" <?php echo $pedId; ?> class="btn <?php echo $classBanco; ?>" <?php echo $disabled; ?> <?php echo $banco; ?> >
  Bancos
</button>
<?php }else{?>
<button href="#myModal" data-toggle="modal" type="button" class="btn banco" disabled >
  Bancos
</button>
<?php } ?>   
      </td>     
      <td style="text-align:center">

<?php
 if($res['fk_status'] == 1){
?>
 <button href="#myEnviar" data-toggle="modal" <?php echo $pedId; ?> type="button" <?php echo $disabled; ?> class="btn btn-success comp" <?php echo $comp; ?>>
  Enviar Arquivo
</button>
<?php  
 }else if($res['fk_status'] == 2){
   echo '<span class="label label-warning">'.$res['status_nome']."</span>";
 }
 else if($res['fk_status'] == 3){
   echo '<span class="label label-success">'.$res['status_nome']."</span>";
 }
 else if($res['fk_status'] == 4){
   echo '<span class="label label-warning"  style="background:#FF2F34">'.$res['status_nome']."</span>";
 }
 else if($res['fk_status'] == 5){
   echo '<span class="label label">'.$res['status_nome']."</span>";
 }
?>
      </td>    
    </tr>
  <?php } ?>
  
  
  </tbody>
</table>

</div>
</div>
