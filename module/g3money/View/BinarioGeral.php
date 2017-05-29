<?php
	$rede = new Rede();

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
	$novoVolumeGrupoD = $pontos->GetPontosUsuario($dados['model']['principal']['usu_doc'], 'd', date('m_Y'));
	
	$pernaAutomatica = ( $volume_ePrincipal <= $volume_dPrincipal ) ? 'e' : 'd';
	$pernaAutomaticaText = ( $volume_ePrincipal <= $volume_dPrincipal ) ? 'esquerda' : 'direita';
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
						<div class="controls">
							Eu autorizo a empresa Futurus  Empreendedor debitar R$50,00 do meu crédito, no primeiro dia útil  do mês, para a minha Ativação mensal: &nbsp;
							<div class="make-switch switch-mini" data-on-label="SIM" data-off-label="NÃO" data-on="1" data-off="0" id="autoativacao">
								<?php $sel = ( $dados['usuario']['usuario']['usu_auto_ativacao'] == '1' ) ? ' checked' : ''; ?>
								<input type="checkbox" <?php echo $sel;?>/>
							</div>
							<input type="hidden" name="auto" id="auto" value="<?php echo $dados['usuario']['usuario']['usu_auto_ativacao'];?>" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
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
						<form class="form-search" method="POST">
							<input type="text" name="usu_usuario"  placeholder="Nome de Usuário" class="input-medium search-query" />
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
					<td><?php echo $dados['model']['principal']['nome_completo']?></td>
					<td>Patrocinado Pessoalmente::</td>
					<td>Não</td>
				</tr>
                <?php
				//verifica ativo
				$usu_ativo = $usuarios->usuarioAtivo( $dados['model']['principal']['usu_doc'] );
				$usu_ativo = ( $usu_ativo ) ? 'sim' : 'não';
				?>
				<tr>
					<td>Título Alcançado:</td>
					<td><?php echo $dados['model']['principal']['status']?></td>
					<td>Ativo:</td>
					<td><?php echo $usu_ativo;?></td>
				</tr>
                <?php
                //verifica qualificado
				$qualificado = $usuarios->pernaAtivaQualificado( $dados['model']['principal']['usu_doc'] );
				$qualificado = ( $qualificado['qualificado'] ) ? 'sim' : 'não';
				?>
				<tr>
					<td>Cadastrado:</td>
					<td><?php echo $dados['model']['principal']['data']?></td>
					<td>Qualificado:</td>
					<td><?php echo $qualificado; ?></td>
				</tr>
				<tr>
					<td>Novo Volume de Grupo (E):</td>
					<td><?php echo $novoVolumeGrupoE['total'];?></td>
					<td>Novo Volume de Grupo (D):</td>
					<td><?php echo $novoVolumeGrupoD['total'];?></td>
				</tr>
                <?php
				//get volume E e D
				$volume = new SaldoPontos;
				$volume->SetFkUsu($dados['model']['principal']['usu_doc']);
				$volume->SetSldPerna('e');
				$volume_pontos_e = $volume->getVolumePontos();
				$volume->SetSldPerna('d');
				$volume_pontos_d = $volume->getVolumePontos();
				
				$volume_pontos_e = $volume_pontos_e['sld_valor_credito'] - $volume_pontos_e['sld_valor_debito'];
				$volume_pontos_d = $volume_pontos_d['sld_valor_credito'] - $volume_pontos_d['sld_valor_debito'];
				
				$volume_pontos_e = number_format( $volume_pontos_e, 0, '', '' );
				$volume_pontos_d = number_format( $volume_pontos_d, 0, '', '' );
				?>
				<tr>
					<td>Total Volume de Grupo (E):</td>
					<td><?php echo $volume_pontos_e;?></td>
					<td>Total Volume de Grupo (D):</td>
					<td><?php echo $volume_pontos_d;?></td>
				</tr>
				<tr>
					<td>Usuários na perna (E):</td>
					<td><?php echo $volume_e;?></td>
					<td>Usuários na perna (D):</td>
					<td><?php echo $volume_d;?></td>
				</tr>
				<tr>
					<td>Patrocinador:</td>
					<td><?php echo $dados['model']['principal']['patrocionador']?></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>
						<form class="form-search" method="POST">
							<input type="hidden" name="usu_usuario" value="<?php echo $dados['model']['principal']['upline']?>" />
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
	<img  title="<?php echo 'E-mail: '.$dados['model']['principal']['email'] ?>"
	 src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['sexo'] . '/' . $dados['model']['principal']['status'] ?>.png" alt="">
    <?php echo $dados['model']['principal']['nome'] ?>

		<ul>
			<li>
			<img title="<?php echo 'E-mail: '.$dados['model']['principal']['e']['email'] ?>"
			 src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['e']['sexo'] . '/' . $dados['model']['principal']['e']['status'] ?>.png" alt="">
			<?php echo $dados['model']['principal']['e']['nome'] ?>
						<ul>
							<li>
							<img title="<?php echo 'E-mail: '.$dados['model']['principal']['e']['e']['email'] ?>"
							src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['e']['e']['sexo'] . '/' . $dados['model']['principal']['e']['e']['status'] ?>.png" alt="">
							<?php echo $dados['model']['principal']['e']['e']['nome'] ?>
								<ul>
									<li>
									<img title="<?php echo 'E-mail: '.$dados['model']['principal']['e']['e']['e']['email'] ?>"
									 src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['e']['e']['e']['sexo'] . '/' . $dados['model']['principal']['e']['e']['e']['status'] ?>.png" alt="">
									<?php echo $dados['model']['principal']['e']['e']['e']['nome'] ?>

									</li>

									<li>
									<img title="<?php echo 'E-mail: '.$dados['model']['principal']['e']['e']['d']['email'] ?>"
									 src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['e']['e']['d']['sexo'] . '/' . $dados['model']['principal']['e']['e']['d']['status'] ?>.png" alt="">
									<?php echo $dados['model']['principal']['e']['e']['d']['nome'] ?>

									</li>

								</ul>

							</li>

							<li>
							<img title="<?php echo 'E-mail: '.$dados['model']['principal']['e']['d']['email'] ?>"
							 src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['e']['d']['sexo'] . '/' . $dados['model']['principal']['e']['d']['status'] ?>.png" alt="">
							<?php echo $dados['model']['principal']['e']['d']['nome'] ?>
									<ul>
										<li>
										<img title="<?php echo 'E-mail: '.$dados['model']['principal']['e']['d']['e']['email'] ?>"
										 src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['e']['d']['e']['sexo'] . '/' . $dados['model']['principal']['e']['d']['e']['status'] ?>.png" alt="">
										<?php echo $dados['model']['principal']['e']['d']['e']['nome'] ?>

										</li>

										<li>
										<img title="<?php echo 'E-mail: '.$dados['model']['principal']['e']['d']['d']['email'] ?>"
										 src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['e']['d']['d']['sexo'] . '/' . $dados['model']['principal']['e']['d']['d']['status'] ?>.png" alt="">
										<?php echo $dados['model']['principal']['e']['d']['d']['nome'] ?>

										</li>

									</ul>

							</li>

						</ul>

			</li>

			<li>
			<img title="<?php echo 'E-mail: '.$dados['model']['principal']['d']['email'] ?>"
			src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['d']['sexo'] . '/' . $dados['model']['principal']['d']['status'] ?>.png" alt="">
			<?php echo $dados['model']['principal']['d']['nome'] ?>
						<ul>
							<li>
							<img title="<?php echo 'E-mail: '.$dados['model']['principal']['d']['e']['email'] ?>"
							src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['d']['e']['sexo'] . '/' . $dados['model']['principal']['d']['e']['status'] ?>.png" alt="">
							<?php echo $dados['model']['principal']['d']['e']['nome'] ?>
									<ul>
										<li>
										<img title="<?php echo 'E-mail: '.$dados['model']['principal']['d']['e']['e']['email'] ?>"
										src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['d']['e']['e']['sexo'] . '/' . $dados['model']['principal']['d']['e']['e']['status'] ?>.png" alt="">
										<?php echo $dados['model']['principal']['d']['e']['e']['nome'] ?>

										</li>

										<li>
										<img title="<?php echo 'E-mail: '.$dados['model']['principal']['d']['e']['d']['email'] ?>"
										src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['d']['e']['d']['sexo'] . '/' . $dados['model']['principal']['d']['e']['d']['status'] ?>.png" alt="">
										<?php echo $dados['model']['principal']['d']['e']['d']['nome'] ?>

										</li>

									</ul>

							</li>

							<li>
							<img title="<?php echo 'E-mail: '.$dados['model']['principal']['d']['d']['email'] ?>"
							src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['d']['d']['sexo'] . '/' . $dados['model']['principal']['d']['d']['status'] ?>.png" alt="">
							<?php echo $dados['model']['principal']['d']['d']['nome'] ?>
									<ul>
										<li>
										<img title="<?php echo 'E-mail: '.$dados['model']['principal']['d']['d']['e']['email'] ?>"
										src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['d']['d']['e']['sexo'] . '/' . $dados['model']['principal']['d']['d']['e']['status'] ?>.png" alt="">
										<?php echo $dados['model']['principal']['d']['d']['e']['nome'] ?>

										</li>

										<li>
										<img title="<?php echo 'E-mail: '.$dados['model']['principal']['d']['d']['d']['email'] ?>"
										src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/<?php echo $dados['model']['principal']['d']['d']['d']['sexo'] . '/' . $dados['model']['principal']['d']['d']['d']['status'] ?>.png" alt="">
										<?php echo $dados['model']['principal']['d']['d']['d']['nome'] ?>

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
                	  <div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/vazio.png" alt="Image" style="max-width:100%;" />Vazio</a></div>
                	  <div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/bloqueado.png" alt="Image" style="max-width:100%;" />Bloqueado</a></div>
                	  <div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/consultor.png" alt="Image" style="max-width:100%;" />Consultor</a></div>
                	  <div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/empreendedor.png" alt="Image" style="max-width:100%;" />Empreendedor</a></div>
                	</div><!--/row-fluid-->
                </div><!--/item-->
                 
                <div class="item">
                	<div class="row-fluid">
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/profissional.png" alt="Image" style="max-width:100%;" />Profissional</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/safira.png" alt="Image" style="max-width:100%;" />Safira</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/ruby.png" alt="Image" style="max-width:100%;" />Ruby</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/esmeralda.png" alt="Image" style="max-width:100%;" />Esmeralda</a></div>
                	</div><!--/row-fluid-->
                </div><!--/item-->
                 
                <div class="item">
                	<div class="row-fluid">
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/diamante.png" alt="Image" style="max-width:100%;" />Diamante</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/diamanteduplo.png" alt="Image" style="max-width:100%;" />Diamante Duplo</a></div>
                		<div class="span3" style="text-align: center;"><a href="#x" class="thumbnail"><img src="http://<?php echo $dados['host'];?>/module/futurus/View/img/rede/m/diamantetriplo.png" alt="Image" style="max-width:100%;" />Diamante Triplo</a></div>
                		
                	</div><!--/row-fluid-->
                </div><!--/item-->
                 
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