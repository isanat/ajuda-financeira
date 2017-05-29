<?php  if($_SESSION['usuario']['fk_status'] != 1){ ?>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<h2><i class="icon-sitemap icon-2"></i>Matriz 3x3</h2>
<div class="x_content">

<div class="social-box">
	<div class="body">
		<table width="100%" class="table table-striped">
			<thead>
				<tr>
					<td width="37%">
						<form id="form_usu_rede" class="form-search" method="POST">
							<input type="text" id="busca_usu_rede" name="usu_usuario"  placeholder="Nome de Usuário" class="form-control" /><p><p>
							<button  class="btn btn-primary btn-small">Procurar</button>
						</form>
					</td>
                    <td width="55%"></td>
					<td width="4%"></td>
					<td width="4%"></td>
				</tr>
			</thead>
			<tbody>
				<tr>
				  <td colspan="4">
                 
                 <?php if(!empty($dados['model']['pai'])){ ?>
                 
                 <table width="100%" border="0" cellpadding="0">           
				    <tr>
				      <td width="16%"><strong>Nome:</strong></td>
				      <td width="34%"><?php echo $dados['model']['pai'][0]['usu_nome']; ?></td>
				      <td width="11%"><strong>Fixo:</strong></td>
				      <td width="39%"><span class="f_fixo"><?php echo $dados['model']['fones'][0]['fone_fone']; ?></span></td>
			        </tr>
				    <tr>
				      <td><strong>Usuário:</strong></td>
				      <td><?php echo $dados['model']['pai'][0]['usu_usuario']; ?></td>
				      <td><strong>Celular:</strong></td>
				      <td><span class="f_cel"><?php echo $dados['model']['cel'][0]['fone_fone']; ?></span></td>
			        </tr>
				    <tr>
				      <td><strong>Status do Usuário:</strong></td>
				      <td><?php $status = ($dados['model']['pai'][0]['fk_status'] == 2 ) ? "<div class='label label-success'>Ativo</div>" : "<div class='label label-warning'>Pendende</div>"; 
					      echo $status; ?></td>
				      <td><strong>whatsapp:</strong></td>
				      <td><span class="f_what"><?php echo $dados['model']['wats'][0]['fone_fone']; ?></span></td>
			        </tr>
				    <tr>
				      <td><!--<strong>E-mail</strong>--></td>
				      <td><?php //echo $dados['model']['pai'][0]['usu_email']; ?></td>
				      <td><strong>Comercial:</strong></td>
				      <td><span class="f_comer"><?php echo $dados['model']['comer'][0]['fone_fone']; ?></span></td>
		           </tr>
                   <tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td></td>
				      <td></td>
		           </tr>
                   							   
			      </table>
                   <?php } ?>
                  
                  </td>
			  </tr>			
				<tr>
					<td>
						<form class="form-search" method="POST">
							<input type="hidden" name="usu_usuario" value="<?php echo $_SESSION['usuario']['usu_usuario']?>" />
							<button class="btn btn-primary" type="submit"><i class="icon-arrow-up"></i> Voltar ao topo</button>
						</form>
					</td>
					<td>
                    <form class="form-search" method="POST">
							<input type="hidden" name="usu_subir" value="<?php echo $dados['model']['pai'][0]['fk_usu_rede']; ?>" />
							<button class="btn btn-success" type="submit"><i class="icon-arrow-up"></i> Subir um Nível</button>
					</form>
                    </td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
</div>	
</div>

	</div>
  </div>
</div>
						
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/binario.css"/>
<link href="http://<?php echo $dados['host'];?>/core/View/css/uniform.default.min.css" rel="stylesheet">
<div id="erro"></div>


<!-- Inicio Rede -->
<div class="container">
	<div class="row">
		<div class="span8">
<ul id="org" style="display:none">
    <li class="redeusu">
  <?php
  if($dados['model']['pai'][0]['fk_status'] == 1){
	 $img = "bloqueado.png";
	}
	elseif($dados['model']['pai'][0]['fk_status'] == 2){
	 $img = "consultor.png";
	}else{
	 $img = "vazio.png";
	}
   
   //$img = isset($dados['model']['pai'][0]['usu_usuario']) ? "consultor.png" : "vazio.png"; ?>
	<img class="redeusu" id="<?php echo $dados['model']['pai'][0]['usu_usuario'] ?>" 
	 src="http://<?php echo $dados['host'];?>/module/g3money/View/img/rede/<?php echo $dados['model']['pai'][0]['usu_sexo']."/$img"; ?>" alt="">
	 <?php echo $dados['model']['pai'][0]['usu_usuario'] ?>
<ul>		
<li>
    <?php 
	if($dados['model']['rede'][0]['fk_status'] == 1){
	 $img = "bloqueado.png";
	}
	elseif($dados['model']['rede'][0]['fk_status'] == 2){
	 $img = "consultor.png";
	}else{
	 $img = "vazio.png";
	}	
	?>
	<img class="redeusu" id="<?php echo $dados['model']['rede'][0]['usu_usuario'] ?>" 
	 src="http://<?php echo $dados['host'];?>/module/g3money/View/img/rede/<?php echo $dados['model']['rede'][0]['usu_sexo']."/$img"; ?>" alt="">
	 <?php echo $dados['model']['rede'][0]['usu_usuario'] ?>
</li>
<li> 
    <?php
	if($dados['model']['rede'][1]['fk_status'] == 1){
	 $img = "bloqueado.png";
	}
	elseif($dados['model']['rede'][1]['fk_status'] == 2){
	 $img = "consultor.png";
	}else{
	 $img = "vazio.png";
	}
   ?>
	<img class="redeusu" id="<?php echo $dados['model']['rede'][1]['usu_usuario'] ?>" 
	 src="http://<?php echo $dados['host'];?>/module/g3money/View/img/rede/<?php echo $dados['model']['rede'][1]['usu_sexo']."/$img"; ?>" alt="">
	<?php echo $dados['model']['rede'][1]['usu_usuario'] ?>

</li>
 <li> 
    <?php
	if($dados['model']['rede'][2]['fk_status'] == 1){
	 $img = "bloqueado.png";
	}
	elseif($dados['model']['rede'][2]['fk_status'] == 2){
	 $img = "consultor.png";
	}else{
	 $img = "vazio.png";
	}
    ?>  
   
    <img class="redeusu" id="<?php echo $dados['model']['rede'][2]['usu_usuario'] ?>" 
	 src="http://<?php echo $dados['host'];?>/module/g3money/View/img/rede/<?php echo $dados['model']['rede'][2]['usu_sexo']."/$img"; ?>" alt="">
	<?php echo $dados['model']['rede'][2]['usu_usuario'] ?>
</li>

</ul>

</li>
</ul>

<div style="width:400px; float:center; margin:0 auto;">

	<div id="teste" class="orgChart"></div>
    <div id="chart" class="orgChart"></div>
    
</div>

</div>
    
</div>      
</div>
    <!-- Fim Rede -->

<br>


<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.chosen/chosen.jquery.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/bootstrap.colorpicker/bootstrap-colorpicker.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/bootstrap.switch/bootstrapSwitch.js"></script>

<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.mask.js"></script>

<script>
	$(".f_cel").mask("(00) 00000-0000");
	$(".f_fixo").mask("(00) 0000-0000");
	$(".f_comer").mask("(00) 0000-0000");
	$(".f_what").mask("(99) 99999-9999");
</script>
<?php }else{ ?>
	<h2> VOCÊ PRECISA ESTÁ ATIVO PARA QUE POSSA NAVEGAR NA REDE.</h2>
<?php } ?>	
	
