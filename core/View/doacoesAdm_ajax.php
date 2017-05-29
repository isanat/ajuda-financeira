<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/colorbox.css">

<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.colorbox-min.js"></script>

<script>
	$(".thumbnail").colorbox({rel:'group1', transition:"none", width:"75%", height:"75%"});
</script>

<?php

if( !empty( $dados['model']['resPgto']['msg']['action'] ) ) {
	echo '<div class="alert alert-'.$dados['model']['resPgto']['msg']['action'].'">
		<button data-dismiss="alert" class="close" type="button">×</button>
		<strong>'.$dados['model']['resPgto']['msg']['textAttention'].'</strong> '.$dados['model']['resPgto']['msg']['text'].'
	</div>';}
?>

<div class="row-fluid">
	<div class="social-box">
		<div class="body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Usuário</th>
						<th>Foto</th>
						<th>Data Envio</th>
						<th>Data Cadastro</th>						
						<th>E-mail</th>
						<th>Status</th>	
						<th>Ação</th>	
					</tr>
				</thead>
				<tbody>
					<?php foreach( $dados['model']['busca'] AS  $pedidos ) { ?>
						<tr>
							<td><?php echo $pedidos['usu_nome']; ?></td>
							<td><?php echo $pedidos['usu_usuario']; ?></td>
							<td>
								<ul class="thumbnails"> 
									<li>
									<a rel="gallery_group" href="http://<?php echo $dados['host'];?>/core/View/comprovantes_adm/<?php echo $pedidos['compro_img']; ?>" width="50" class="thumbnail cboxElement">
									  <div class="zoom">
										<img src="http://<?php echo $dados['host'];?>/core/View/comprovantes_adm/<?php echo $pedidos['compro_img']; ?>" width="50" alt="">
									  </div>
									</a>
									</li>
								</ul>
							</td>
							<td><?php echo $pedidos['data_envio']; ?></td>
							<td><?php echo $pedidos['usu_data']; ?></td>
							<td><?php echo $pedidos['usu_email']; ?></td>
							<?php
								switch( $pedidos['fk_status'] ) {
									case 1:
											$label_pedidos = '<span class="label label-warning" role="alert">Pendente';
										break;
									case 2:
											$label_pedidos = '<span class="label label-success" role="alert">Ativo';
										break;
									case 3:
											$label_pedidos = '<span class="label label-info" role="alert">Bloqueado';
										break;
									case 4:
											$label_pedidos = '<span class="label label-important" role="alert">Confirmado';
										break;
									default:
											$label_pedidos = '<span class="label label" role="alert">';
										break;
								}
							?>
							<td><?php echo $label_pedidos."</span>";?></td>
							<td>
							
						<?php if($pedidos['fk_status_compro'] < 2) { ?>
							<button type="submit" class="btn btn-primary" onclick="confirmarAdm(<?php echo $pedidos['usu_doc']; ?>,<?php echo $pedidos['compro_id']; ?>)">Confirmar</button>					
						<?php }else{ ?>
							<span class="label label-success" role="alert">Confirmado com sucesso</span>
						<?php } ?>	
						
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
<div>	

<?php
	echo $dados['model']['paginacao'];
?>