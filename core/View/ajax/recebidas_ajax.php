
<?php 
 //echo "<pre>"; print_r( $dados['model']['rece'] ); die;		

 foreach($dados['model']['rece'] as $rece){?>   
                 <tr>                  
                  <td><?php echo $rece['usu_usuario']; ?></td>
                  <td>
<ul class="thumbnails"> 
    <li>
    <a rel="gallery_group" href="http://<?php echo $dados['host'];?>/core/View/comprovantes/<?php echo $rece['compro_img']; ?>" width="50" class="thumbnail cboxElement">
      <div class="zoom">
        <img src="http://<?php echo $dados['host'];?>/core/View/comprovantes/<?php echo $rece['compro_img']; ?>" width="50" alt="">
      </div>
    </a>
    </li>
</ul>             
                  </td>
                  <td><?php echo $rece['compro_data_envio']; ?></td>
                  <td><?php echo "R$:".number_format($rece['ped_total'],2,",","."); ?></td>
                  <td>
                    <?php
							switch( $rece['fk_status_compro'] ) {
								case 1:
										$label_pedidos = '<span class="label label-warning">';
									break;
								case 2:
										$label_pedidos = '<span class="label label-success">';
									break;
								case 3:
										$label_pedidos = '<span class="label label-warning">';
									break;
								case 4:
										$label_pedidos = '<span class="label label-important">';
									break;
								default:
										$label_pedidos = '<span class="label label">';
									break;
							}
							?>
                            <?php echo $label_pedidos.$rece['status_compro_nome']."</span>";?>
                  
                  </td>
                  <td style="text-align:center">
                 <?php if( $rece['fk_status'] == 1 ){ ?>   
                               
<?php  if($rece['fk_status_compro'] != 4){ ?>         
          
                 <div class="btn-group">
                  <button class="btn btn-primary">Ação</button>
                  <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul class="dropdown-menu">
                  
         
<li>
<a class="confirmar" idUsu="<?php echo $rece['usu_id']; ?>" idPed="<?php echo $rece['ped_id']; ?>" idCompro="<?php echo $rece['compro_id']; ?>" usu="<?php echo $rece['usu_usuario']; ?>" valor="<?php echo "R$:".number_format($rece['ped_total'],2,",","."); ?>" href="#">
<i class="icon-white icon-thumbs-up"></i> Confirmar</a>
</li>

<li><a class="cancelarComp" idPed="<?php echo $rece['ped_id']; ?>" idCompro="<?php echo $rece['compro_id']; ?>" href="#">
    <i class="icon-remove"></i> Cancelar</a>
</li>    
                  </ul>
                </div>
         
<?php }?>                 
                
                 <?php }if( $rece['fk_status'] == 3 ){ ?>  
                    <img src="http://<?php echo $dados['host'];?>/core/View/img/confirmar.png" width="25" alt="">
                 <?php }?> 
                  
                  </td>
                   <td><span style="color:red;display:none; text-align:right" class="load<?php echo $rece['compro_id']; ?>">
                       <img src="http://<?php echo $dados['host'];?>/core/View/img/load.gif" width="50"></span></td>
                </tr>
      <?php }?> 
 <tr>                  
  <td colspan="7">
    <?php
	echo $dados['model']['paginacao'];
?>
  </td>     
  </tr>
  
  <script src="http://<?php echo $dados['host'];?>/core/View/js/recebidas.js"></script>
