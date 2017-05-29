<?php //echo "<pre>Equipe fazendo testes"; print_r($dados['model']['fone']); die;?>
<table width="100%" class="table">
  <thead>
    <tr>
      <th width="31%">Nome</th>
      <th width="22%">Usuário</th>
      <th width="32%">E-mail</th>
      <th width="15%">Status</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td><?php echo $dados['model']['cont'][0]['usu_nome']; ?></td>
      <td><?php echo $dados['model']['cont'][0]['usu_usuario']; ?></td>
      <td><?php echo $dados['model']['cont'][0]['usu_email']; ?></td>
      <td align="center"><span class="label label-success">Ativo</span></td>
    </tr>
  </tbody>
</table>
               
<span style="margin:10px 0 10px 0"></span>        
                
<table width="100%" border="0" class="table table-striped">
<tr>
  <td colspan="2"><h3>Telefones para Contato</h3></td>
  </tr>
<tr>
  <th width="14%" align="left">Celular:</th>
  <td width="86%">
    <?php echo "<span class='cel'>".$dados['model']['cel'][0]['fone_fone']."</span>"; ?>
    </td>
</tr>
<tr>
  <th align="left">whatsapp:</th>
  <td>
  <?php echo "<span class='whatsapp'>".$dados['model']['whats'][0]['fone_fone']."</span>"; ?>
  </td>
</tr>
<tr>
  <th align="left">Fixo:</th>
  <td>
  <?php  echo "<span class='fixo'>".$dados['model']['fone'][0]['fone_fone']."</span>"; ?>
  </td>
</tr>
<tr>
  <th align="left">Comercial:</th>
  <td><?php echo "<span class='comercial'>".$dados['model']['comer'][0]['fone_fone']."</span>"; ?></td>
</tr>

</table>

<script>
$(".cel").mask("(00) 00000-0000");
$(".whatsapp").mask("(00) 00000-0000");
$(".fixo").mask("(00) 0000-0000");
$(".comercial").mask("(00) 0000-0000");   
</script>