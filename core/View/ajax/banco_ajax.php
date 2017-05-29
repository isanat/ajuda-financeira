<?php  

//echo "<pre>"; print_r( $dados['model']['adm'] ); die;

if($dados['model']['adm'] == "ok"){
echo "
<div class='alert alert-success'>
   <strong>ATENÇÃO</strong> 
   Este usuário encontra-se não apto a receber sua doação é essa doação será feita para á <strong>Nossa Equipe </strong>para que você não se prejudique
   assim que esse usuário efetuar a doação ele porderá prosseguir normalmente OBRIGADO.			  
</div><p>";
}
if($dados['model']['retorno'] == "sim"){ 
if($dados['model']['adm'] == "no"){
?>
<table width="100%" border="0"  class="table table-striped" cellpadding="0">
  <tr>
    <td colspan="2"><h3>Meios de Recebimento</h3></td>
  </tr>
 <tr>
    <td width="13%">
    <strong>ContaSuper</strong></td>
    <td width="87%"><?php echo $dados['model']['receb'][0]['conta_super']?></td>
  </tr>
  <tr>
    <td><strong> PagSeguro</strong></td>
    <td><?php echo $dados['model']['receb'][0]['pagseguro']?></td>
  </tr>
  <tr>
    <td><strong>Paypal</strong></td>
    <td><?php echo $dados['model']['receb'][0]['paypal']?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<span style="margin-bottom:10px;"></span>
<?php } ?>

<table width="100%" class="table table-striped">
  <tbody>
      <th width="12%">Banco</th>
      <th width="14%">Agência</th>
      <th width="17%">Conta</th>
      <th width="21%">Tipo de Conta</th>
      <th width="14%">Operação</th>
      <th width="22%">Favorecido</th>
  <tbody>
  <?php  
         foreach($dados['model']['banco'] as $res){
	     $tipoConta = ($res['banco_tipo'] == "c") ? "Conta Corrente" : "Conta Poupança" ;
  ?>
    <tr>
      <td><?php echo $res['cod_nome']; ?></td>
      <td><?php $dig = ($res['banco_agencia_digito'] != "") ? "-".$res['banco_agencia_digito'] : "" ; echo $res['banco_agencia'].$dig; ?></td>
      <td><?php $digc = ($res['banco_digito_conta'] != "" ) ? "-".$res['banco_digito_conta'] : "" ; echo $res['banco_conta'].$digc; ?></td>   
      <td><?php echo $tipoConta; ?></td>
      <td><?php echo $res['banco_op']; ?></td>   
      <td><?php echo $res['banco_favorecido']; ?></td>  
    </tr>
  <?php } ?>
  </tbody>
</table>
  <?php }else{ echo "<h5 style='color:red'>Nenhuma Conta Bancária Cadastrada</h5>"; die;} ?>
 