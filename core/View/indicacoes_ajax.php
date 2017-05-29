<?php
if( !empty( $dados['model']['resPgto']['msg']['action'] ) ) {
	echo '<div class="alert alert-'.$dados['model']['resPgto']['msg']['action'].'">
		<button data-dismiss="alert" class="close" type="button">×</button>
		<strong>'.$dados['model']['resPgto']['msg']['textAttention'].'</strong> '.$dados['model']['resPgto']['msg']['text'].'
	</div>';	
}
?>
<div class="row-fluid">
	<div class="social-box">
		<div class="body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Usuário</th>
						<th>Data Cadastro</th>
						<th>E-mail</th>
						<th>Status</th>
						
					</tr>
				</thead>
				<tbody>
					<?php	
					//echo "<pre>"; print_r( $dados['model'] ); die;
						
					   foreach( $dados['model']['busca'] AS  $pedidos ) {
					?>
						<tr>
							<td><?php echo $pedidos['usu_nome']; ?></td>
							<td><?php echo $pedidos['usu_usuario']; ?></td>
							<td><?php echo $pedidos['usu_data']; ?></td>
							<td><?php echo $pedidos['usu_email']; ?></td>
							<?php
								switch( $pedidos['fk_status'] ) {
									case 1:
											$label_pedidos = '<span class="label label-warning">';
										break;
									case 2:
											$label_pedidos = '<span class="label label-success">';
										break;
									case 3:
											$label_pedidos = '<span class="label label-info">';
										break;
									case 4:
											$label_pedidos = '<span class="label label-important">';
										break;
									default:
											$label_pedidos = '<span class="label label">';
										break;
								}
							?>
							<td><?php echo $label_pedidos.$pedidos['status_nome']."</span>";?></td>
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