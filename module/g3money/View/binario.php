<?php
// 	echo '<pre>';print_r($dados['model']);die;
	/*$rede = new Rede();

	$perna = $rede->pernaAtiva($dados['usuario']['usuario']['usu_doc']);	
	$volumeBinario = array();
	$volume_dPrincipal = 0;
	$rede->GetVolumeBinario($volumeBinario, $perna['d'], NULL, $volume_dPrincipal);
	
	$volumeBinario = array();
	$volume_ePrincipal = 0;
	$rede->GetVolumeBinario($volumeBinario, $perna['e'], NULL, $volume_ePrincipal);

	$perna = $rede->pernaAtiva($dados['model']['principal']['usu_doc']);	
	$volumeBinario = array();
	$volume_d = 0;
	$rede->GetVolumeBinario($volumeBinario, $perna['d'], NULL, $volume_d);
	
	$volumeBinario = array();
	$volume_e = 0;
	$rede->GetVolumeBinario($volumeBinario, $perna['e'], NULL, $volume_e);
	
	$pontos = new Pontos();
	$novoVolumeGrupoE = $pontos->GetPontosUsuario($dados['model']['principal']['usu_doc'], 'e', date('m_Y'));
	$novoVolumeGrupoD = $pontos->GetPontosUsuario($dados['model']['principal']['usu_doc'], 'd', date('m_Y'));*/
	
	$pernaAutomatica = ( $dados['model']['perna_e'] <= $dados['model']['perna_d'] ) ? 'e' : 'd';
	$pernaAutomaticaText = ( $dados['model']['perna_e'] <= $dados['model']['perna_d'] ) ? 'esquerda' : 'direita';
	
?>
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/binario.css"/>
<link href="http://<?php echo $dados['host'];?>/core/View/css/uniform.default.min.css" rel="stylesheet">
<div id="erro"></div>

<div class="social-box">
	<div class="header">
		<h4><i class="icon-sitemap icon-2"></i>Configurações de <span class="label label-info"><?php echo $dados['usuario']['usuario']['usu_usuario'];?></span></h4>
		<div id="erro_end"></div>
	</div>
	<div class="body">
		<span id="resposta"></span>
		<?php 
			//echo $volume_ePrincipal."|".$volume_dPrincipal."|".$volume_e."|".$volume_d;
			//echo "<pre>"; print_r( $dados ); echo "</pre>"; 
			
		if($_SESSION['usuario']['fk_status'] == '2')
		{
		?>
		
		<table class="table table-striped">
			<tbody>
				<tr>
					<td>Perna preferencial:
						&nbsp;&nbsp;&nbsp;
						<input name="perna" id="pernaPrefD" class="perna" <?php if($dados['usuario']['usuario']['usu_perna_pref'] == 'e'){echo 'checked';}?> type="radio" value="e" />
						<span class="lbl"> Esquerda</span>&nbsp;&nbsp;&nbsp;
						<input name="perna" id="pernaPrefE" class="perna" <?php if($dados['usuario']['usuario']['usu_perna_pref'] == 'd'){echo 'checked';}?> type="radio" value="d" />
						<span class="lbl"> Direita</span>&nbsp;&nbsp;&nbsp;
						<input name="perna" id="pernaPrefA" class="perna" <?php if($dados['usuario']['usuario']['usu_perna_auto'] == '1'){echo 'checked';}?> type="radio" value="a:<?php echo $pernaAutomatica;?>" />
						<span class="lbl"> Perna Automática <span class="label label-info">(<?php echo $pernaAutomaticaText;?>)</span>&nbsp;&nbsp;&nbsp;
						<input type="hidden" name="pernaPref" id="pernaPref" value="<?php echo $dados['usuario']['usuario']['usu_perna_pref'];?>" />
					</td>
				</tr>
				<tr>
					<td>
					
					</td>
				</tr>
			</tbody>
		</table>
		<?php }?>
	</div>
</div>

<div class="social-box">
	<div class="header">
		<h4><i class="icon-sitemap icon-2"></i>Rede Binária</h4>
		<div id="erro_end"></div>
	</div>
	<div class="body">
		<table class="table table-striped">
			<thead>
				<tr>
					<td>
						<form id="form_usu_rede" class="form-search" method="POST">
							<input type="text" id="busca_usu_rede" name="usu_usuario"  placeholder="Nome de Usuário" class="input-medium search-query" />
							<button  class="btn btn-primary btn-small">
								Procurar
								<i class="icon-search icon-on-right bigger-110"></i>
							</button>
						</form>
					</td>
				</tr>
			</thead>
            <?php $usuarios = new Usuario; ?>
			<tbody>
				<tr>
					<td>Nome:</td>
					<td><?php echo $dados['model']['p'][0]['usu_nome']?></td>
					<td>Patrocinado Pessoalmente::</td>
					<td>Não</td>
				</tr>
                <?php
				//verifica ativo
				$usu_ativo = $usuarios->usuarioAtivo( $dados['model']['p'][0]['usu_doc'] );
				$usu_ativo = ( $usu_ativo ) ? 'sim' : 'não';
				?>
				<tr>
					<td>Título Alcançado:</td>
					<td><?php echo $dados['model']['p'][0]['ca_nome']?></td>
					<td>Ativo:</td>
					<td><?php echo $usu_ativo;?></td>
				</tr>
                <?php
                //verifica qualificado
				$qualificado = $usuarios->pernaAtivaQualificado( $dados['model']['p'][0]['usu_doc'] );
				$qualificado = ( $qualificado['qualificado'] ) ? 'sim' : 'não';
				?>
				<tr>
					<td>Cadastrado:</td>
					<td><?php echo $dados['model']['p'][0]['usu_data']?></td>
					<td>Qualificado:</td>
					<td><?php echo $qualificado; ?></td>
				</tr>
				<tr>
					<td>Volume Pontos Dia (E):</td>
					<td><?php echo $dados['model']['dia_e']['total'];?></td>
					<td>Volume Pontos Dia (D):</td>
					<td><?php echo $dados['model']['dia_d']['total'];?></td>
				</tr>
                
				<tr>
					<td>Total Volume Pontos (E):</td>
					<td><?php echo $dados['model']['geral_e'];?></td>
					<td>Total Volume Pontos (D):</td>
					<td><?php echo $dados['model']['geral_d'];?></td>
				</tr>
				<tr>
					<td>Usuários na Equipe (E):</td>
					<td><?php echo $dados['model']['usu_e'];?></td>
					<td>Usuários na Equipe (D):</td>
					<td><?php echo $dados['model']['usu_d'];?></td>
				</tr>
				<tr>
					<td>Patrocinador:</td>
					<td><?php echo $dados['model']['p'][0]['patrocionador']?></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>
						<form class="form-search" method="POST">
							<input type="hidden" name="usu_usuario" value="<?php echo $dados['model']['p'][0]['upline']?>" />
							<button class="btn btn-primary" type="submit"><i class="icon-arrow-up"></i> Subir um nível</button>
						</form>
					</td>
					<td></td>
					<td>
						<form class="form-search" method="POST">
							<input type="hidden" name="usu_usuario" value="" />
							<button class="btn btn-primary" type="submit"><i class="icon-arrow-up"></i> Voltar ao topo</button>
						</form>
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
</div>
	
	
</div>





<!-- Inicio Rede -->
<div class="container">
	<div class="row">
		<div class="span12">


<ul id="org" style="display:none">
    <li class="redeusu" >
	<img class="redeusu" id="<?php echo $dados['model']['p'][0]['usu_usuario'] ?>"  title="<?php echo 'E-mail: '.$dados['model']['p'][0]['usu_email'] ?>"
	 src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['p'][0]['usu_sexo'] . '/' . $dados['model']['p'][0]['ca_nome'] ?>.png" alt="">
    <?php echo $dados['model']['p'][0]['usu_usuario'] ?>

		<ul>
			<li>
			<img class="redeusu" id="<?php echo $dados['model']['e']['e']['usu_usuario'] ?>" title=""
			 src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['e']['e']['usu_sexo'] . '/' . $dados['model']['e']['e']['ca_nome'] ?>.png" alt="">
			<?php echo $dados['model']['e']['e']['usu_usuario'] ?>
						<ul>
							<li>
							<img class="redeusu" id="<?php echo $dados['model']['e']['e']['e']['usu_usuario'] ?>" title=""
							src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['e']['e']['e']['usu_sexo'] . '/' . $dados['model']['e']['e']['e']['ca_nome'] ?>.png" alt="">
							<?php echo $dados['model']['e']['e']['e']['usu_usuario'] ?>
								<ul>
									<li>
									<img class="redeusu" id="<?php echo $dados['model']['e']['e']['e']['e']['usu_usuario'] ?>" title=""
									 src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['e']['e']['e']['e']['usu_sexo'] . '/' . $dados['model']['e']['e']['e']['ca_nome'] ?>.png" alt="">
									<?php echo $dados['model']['e']['e']['e']['e']['usu_usuario'] ?>

									</li>

									<li>
									<img class="redeusu" id="<?php echo $dados['model']['e']['e']['e']['d']['nome'] ?>" title=""
									 src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['e']['e']['e']['d']['usu_sexo'] . '/' . $dados['model']['e']['e']['e']['d']['ca_nome'] ?>.png" alt="">
									<?php echo $dados['model']['e']['e']['e']['d']['usu_usuario'] ?>

									</li>

								</ul>

							</li>

							<li>
							<img class="redeusu" id="<?php echo $dados['model']['e']['e']['d']['usu_usuario'] ?>" title=""
							 src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['e']['e']['d']['usu_sexo'] . '/' . $dados['model']['e']['e']['d']['ca_nome'] ?>.png" alt="">
							<?php echo $dados['model']['e']['e']['d']['usu_usuario'] ?>
									<ul>
										<li>
										<img class="redeusu" id="<?php echo $dados['model']['e']['e']['d']['e']['nome'] ?>" title=""
										 src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['e']['e']['d']['e']['usu_sexo'] . '/' . $dados['model']['e']['e']['d']['e']['ca_nome'] ?>.png" alt="">
										<?php echo $dados['model']['e']['e']['d']['e']['usu_usuario'] ?>

										</li>

										<li>
										<img class="redeusu" id="<?php echo $dados['model']['e']['e']['d']['d']['usu_usuario'] ?>" title=""
										 src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['e']['e']['d']['d']['usu_sexo'] . '/' . $dados['model']['e']['e']['d']['d']['ca_nome'] ?>.png" alt="">
										<?php echo $dados['model']['e']['e']['d']['d']['usu_usuario'] ?>

										</li>

									</ul>

							</li>

						</ul>

			</li>

			<li>
			<img class="redeusu" id="<?php echo $dados['model']['d']['d']['usu_usuario'] ?>" title=""
			 src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['d']['d']['usu_sexo'] . '/' . $dados['model']['d']['d']['ca_nome'] ?>.png" alt="">
			<?php echo $dados['model']['d']['d']['usu_usuario'] ?>
						<ul>
							<li>
							<img class="redeusu" id="<?php echo $dados['model']['d']['d']['e']['usu_usuario'] ?>" title=""
								 src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['d']['d']['e']['usu_sexo'] . '/' . $dados['model']['d']['d']['e']['ca_nome'] ?>.png" alt="">
								<?php echo $dados['model']['d']['d']['e']['usu_usuario'] ?>
									<ul>
										<li>
										<img class="redeusu" id="<?php echo $dados['model']['d']['d']['e']['e']['usu_nome'] ?>" title=""
										src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['d']['d']['e']['e']['usu_sexo'] . '/' . $dados['model']['d']['d']['e']['e']['ca_nome'] ?>.png" alt="">
										<?php echo $dados['model']['d']['d']['e']['e']['usu_usuario'] ?>

										</li>

										<li>
										<img class="redeusu" id="<?php echo $dados['model']['d']['d']['e']['d']['usu_usuario'] ?>" title=""
										src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['d']['d']['e']['d']['usu_sexo'] . '/' . $dados['model']['d']['d']['e']['d']['ca_nome'] ?>.png" alt="">
										<?php echo $dados['model']['d']['d']['e']['d']['usu_usuario'] ?>

										</li>

									</ul>

							</li>

							<li>
							<img class="redeusu" id="<?php echo $dados['model']['d']['d']['d']['usu_usuario'] ?>" title=""
							src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['d']['d']['d']['usu_sexo'] . '/' . $dados['model']['d']['d']['d']['ca_nome'] ?>.png" alt="">
							<?php echo $dados['model']['d']['d']['d']['usu_usuario'] ?>
									<ul>
										<li>
										<img class="redeusu" id="<?php echo $dados['model']['d']['d']['d']['e']['usu_usuario'] ?>" title=""
										src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['d']['d']['d']['e']['usu_sexo'] . '/' . $dados['model']['d']['d']['d']['e']['ca_nome'] ?>.png" alt="">
										<?php echo $dados['model']['d']['d']['d']['e']['usu_usuario'] ?>

										</li>

										<li>
										<img class="redeusu" id="<?php echo $dados['model']['d']['d']['d']['d']['usu_usuario'] ?>" title=""
										src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/<?php echo $dados['model']['d']['d']['d']['d']['usu_sexo'] . '/' . $dados['model']['d']['d']['d']['d']['ca_nome'] ?>.png" alt="">
										<?php echo $dados['model']['d']['d']['d']['d']['usu_usuario'] ?>

										</li>

									</ul>

							</li>

						</ul>

			</li>

		</ul>

    </li>
</ul>
	<div id="teste" class="orgChart">
    </div>
    <div id="chart" class="orgChart"></div>
    <!-- <script>
        jQuery(document).ready(function() {

            /* Custom jQuery for the example */
            $("#show-list").click(function(e){
                e.preventDefault();

                $('#list-html').toggle('fast', function(){
                    if($(this).is(':visible')){
                        $('#show-list').text('Hide underlying list.');
                        $(".topbar").fadeTo('fast',0.9);
                    }else{
                        $('#show-list').text('Show underlying list.');
                        $(".topbar").fadeTo('fast',1);
                    }
                });
            });

            $('#list-html').text($('#org').html());

            $("#org").bind("DOMSubtreeModified", function() {
                $('#list-html').text('');

                $('#list-html').text($('#org').html());

                prettyPrint();
            });
        });
    </script> -->
    
    
		</div>
	</div>
</div>
    <!-- Fim Rede -->
    


<br>
<div class="container">
	<div class="row">
		<div class="span12">
    	    <div class="well"> 
                <div id="myCarousel" class="carousel slide">
                 
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                 
                <!-- Carousel items -->
                <div class="carousel-inner">
                    
                <div class="item active">
                	<div class="row-fluid">
                	  <div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/cliente.png" alt="Image" style="max-width:100%;" />Cliente</a></div>
                	  <div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/consultor.png" alt="Image" style="max-width:100%;" />Consultor</a></div>
                	  <div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/supervisor.png" alt="Image" style="max-width:100%;" />Supervisor</a></div>
                	  <div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/gerenteregional.png" alt="Image" style="max-width:100%;" />Gerente Regional</a></div>
                	</div><!--/row-fluid-->
                </div><!--/item-->
                 
                <div class="item">
                	<div class="row-fluid">
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/gerentenacional.png" alt="Image" style="max-width:100%;" />Gerente Nacional</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/diretorexecutivo.png" alt="Image" style="max-width:100%;" />Diretor Executivo</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/diretorregional.png" alt="Image" style="max-width:100%;" />Diretor Regional</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/diretornacional.png" alt="Image" style="max-width:100%;" />Diretor Nacional</a></div>
                	</div><!--/row-fluid-->
                </div><!--/item-->
                
                <div class="item">
                	<div class="row-fluid">
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/vicepresidente.png" alt="Image" style="max-width:100%;" />Vice Presidente</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/presidente.png" alt="Image" style="max-width:100%;" />Presidente</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/vazio.png" alt="Image" style="max-width:100%;" />Vazio</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/marca/View/img/rede/m/bloqueado.png" alt="Image" style="max-width:100%;" />Bloqueado</a></div>
                		
                	</div>
                </div>
                 
                </div><!--/carousel-inner-->
                 
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                </div><!--/myCarousel-->
                 
            </div><!--/well-->   
		</div>
	</div>
</div>

<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.chosen/chosen.jquery.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/bootstrap.colorpicker/bootstrap-colorpicker.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/bootstrap.switch/bootstrapSwitch.js"></script>