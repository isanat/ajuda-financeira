<tr>
  <th width="18%">Doador</th>
  <th width="25%">Recebedor</th>
  <th width="23%">Data da Doação</th>                                  
  <th width="20%">Valor</th>
  <th width="14%">Status</th>   
</tr>            
              
<?php 
  foreach($dados['model']['res'] as $rece){?>   
 <tr>                  
  <td><?php echo $_SESSION['usuario']['usu_usuario']; ?></td>
  <td><?php echo $rece['usu_usuario']; ?></td>
  <td><?php echo $rece['ped_data_pag']; ?></td>               
  <td><?php echo "R$:".number_format($rece['ped_total'],2,",","."); ?></td>
  <td>
	<?php
	switch( $rece['fk_status'] ) {
		case 1:
				$label_pedidos = '<span class="label label-warning">Em aberto';
			break;
		case 2:
				$label_pedidos = '<span class="label label-warning">Aguardando';
			break;
		case 3:
				$label_pedidos = '<span class="label label-success">Aprovado';
			break;
		case 4:
				$label_pedidos = '<span class="label label-important">Aguardando';
			break;
		default:
				$label_pedidos = '<span class="label label">Aguardando';
			break;
	}
	?>
	<?php echo $label_pedidos."</span>";?>                  
  </td>                  
</tr>
<?php }?> 

 <tr>                  
  <td colspan="5">
    <?php
	echo $dados['model']['paginacao'];
?>
  </td>     
  </tr>