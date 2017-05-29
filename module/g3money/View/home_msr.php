<?php 
//echo "<pre>"; print_r($dados['model']['doar']['rece']); die;
 $valor = 0;
 foreach($dados['model']['doar']['rece'] as $receber){
	$valor += $receber['ped_total'];
 }
$usu      = $dados['model']['nivel']['resNivel'][0]['usu_fk'];
$ped      = $dados['model']['nivel']['resNivel'][0]['fk_status'];
$nivelUsu = $dados['model']['nivel']['resNivel'][0]['ped_nivel'];

if(empty($dados['model']['banco']['bancoOnline'])){
?>

<!-- EXIBINDO TODAS AS MODAIS -->

<div  id="alertar" class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" aria-hidden="false" style="display: block; padding-right: 17px;">
<div class="modal-backdrop fade in" style="height: 100%;"></div>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title enviar_comprovante" id="myModalLabel">PENDÊNCIA</h4>
			</div>
			<div class="modal-body validCompro">
				<strong>1º</strong> - VOCÊ PRECISA CADASTRAR SUA CONTA BANCÁRIA PARA QUE VOCÊ POSSA ESTÁ RECEBENDO NORMALMENTE.<p><p>
			</div>
			<div class="modal-footer">
				<a href="../MeusDados/dadosbancarios" class="btn btn-primary">Cadastrar</a>
			</div>

		</div>
	</div>
</div>
<?php }
if($_SESSION['usuario']['usu_doc'] != "00000000001"){
	
  if($dados['model']['banco']['bancoOnline']){
    if(empty($dados['model']['ativa'])){
?>
<!-- INICIO ENVIAR COMPROVANTE -->

<div  id="alertars" class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" aria-hidden="false" style="display: block; padding-right: 17px;">
<div class="modal-backdrop fade in" style="height: 100%;"></div>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title enviar_comprovante" id="myModalLabel">PENDÊNCIA</h4>
			</div>
			<div class="modal-body validCompro">
				<strong>1º</strong> - VOCÊ PRECISA EFETUAR SUA PRIMEIRA DOAÇÃO EM 48 HORAS PARA QUE VOCÊ POSSA ESTÁ CADASTRANDO OUTROS PARTICIPANTES, OU VOCÊ PODERÁ ESTÁ PERDENDO SUA CONTA.<p><p>
			</div>
			<div class="modal-footer">
				<a href="../Doacoes/realizar" class="btn btn-primary">Efetuar doação</a>
			</div>

		</div>
	</div>
</div>

<!-- FIM ENVIAR COMPROVANTE -->

<?php }}} ?>

<p style="margin-top:10px">           
<div class="alert alert-success alert-dismissible fade in" role="alert" style="background:#F00; color:#FFF">
	 <strong>Seja Bem Vindo !</strong>   <p><p> <p><p>    
<?php 
	if($_SESSION['usuario']['fk_status'] == 2){
	  echo "<strong>Participo do nosso grupo no WhatsApp:</strong> (11) 98182-0513";
	}

	$usu_master = $_SESSION['usuario']['usu_master'];
	$doc = $_SESSION['usuario']['master'];
	if(empty($doc)){	
?> <p><p><p>
   <strong><p  style="color:#FFF">Link de Divulgação   
   
    <a href="http://g3money10.com.br/<?php echo $_SESSION['usuario']['usu_usuario']; ?>" class="btn-link" target="_blank">
      <strong style="color:#FFF">http://g3money10.com.br/<?php echo $_SESSION['usuario']['usu_usuario']; ?></strong>
    </a><p></strong>
	
     <strong style="color:#FFF">  Link de Cadastro: </strong>
     <a target="_blank" style="color:#FFF" href="http://escritorio.g3money10.com.br/Usuario/cadastrar/usuario/<?php echo $_SESSION['usuario']['usu_usuario']; ?>"><strong>escritorio.g3money10.com.br/Usuario/cadastrar/usuario/<?php echo $_SESSION['usuario']['usu_usuario']; ?></strong></a>
<?php } ?>       

</div>
			 <div class="row tile_count">
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-user"></i> Total Usuários</span>
                            <div class="count green"><?php echo $dados['model']['allUser'][0]['total']; ?></div>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top indique"><i class="fa fa-sitemap"></i> Última Indicação</span>
                            <div class="count green"><?php echo $dados['model']['meusUltimosCadastros']['ultimoCad'][0]['usu_data']; ?></div>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-sitemap"></i> Nível</span>
							<?php if( $usu == 2 && $ped == 3 ){ ?>
							<div class="count green"><?php echo $nivelUsu; ?></div>
							<?php }else{ ?>
							  <div class="count green">0</div>	
							<?php } ?>                            
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-money"></i> Doações Recebidas</span>
                            <div class="count green"><?php echo "R$:".number_format($valor,2,",","."); ?></div>
                        </div>
                    </div>
                    
                     <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-sitemap"></i> Linha na Rede</span>
                            <div class="count green"><?php echo $dados['model']['posicaoRede']['total']."º"; ?></div>
                        </div>
                    </div>
					 <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-sitemap"></i> Preenchendo Linha</span>
                            <div class="count green"><?php echo $dados['model']['preenchendoLinha']['total']."º"; ?></div>
                        </div>
                    </div>
                    
                   

                </div>
                <!-- /top tiles -->

				
<?php 
//Relogio contando as 48 hrs
$relogio = $dados['model']['relogio'][0]['ped_data_expira'];

if( empty($vencimento)){

if( $relogio > date('d/m/Y H:m:s')){?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="dashboard_graph">

		<div class="row x_title">
			<div class="col-md-6">
				<h3>Após a confirmação da sua primeira doação você poderá cadastrar outros participantes.</h3>
			</div>                               
		</div>
		
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/contatdor.css" type="text/css" />
<div id="contador">
  <div style="color:#3C3C3C;text-align:center" id="clock" class="onstart animated" data-animation="fadeInUp" data-animation-out="fadeOutDown" data-animation-delay="600" data-animation-out-delay="1000"></div>
</div>           
			<div class="clearfix"></div>
		</div>
	</div>

</div>
<br />		
		
<?php  }} ?>				
				
				

<?php 
//Se a data ainda não venceu me exibe o prazo que tenho
$vencimento = $dados['model']['dia'][0]['ped_data_expira'];

if( $vencimento > date('Y-m-d H:m:s')){
 ?>				
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="dashboard_graph">

	<div class="row x_title">
		<div class="col-md-6">
			<h3>Prazo para que você possa está efetuando sua proxíma doação.</h3>
		</div>                               
	</div>
		
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/contatdor.css" type="text/css" />
<div id="contador_relogio">
  <div style="color:#3C3C3C;text-align:center" id="relogio" class="onstart animated" data-animation="fadeInUp" data-animation-out="fadeOutDown" data-animation-delay="600" data-animation-out-delay="1000"></div>
</div>
           
			<div class="clearfix"></div>
		</div>
	</div>

</div>
<br />				
 <?php  } ?>					
								
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="dashboard_graph">

		<div class="row x_title">
			<div class="col-md-6">
				<h3>SIMPLES PARA COMEÇAR</h3>
			</div>                               
		</div>
							
<h3>1º PASSO</h3><br>
Faça sua 1º doação de R$ 150,00 reais via depósito ou transferência bancária para seu 1º UPLINE, <strong>DOAÇÕES REAIZAR</strong>.<p><p>

<h3>2º PASSO</h3><br>
Escaneie ou fotografe o comprovante e envie para o participante pelo seu Escritório Virtual. (O site enviará o comprovante
para o participante a qual você fez a doação) .<p><p>

<h3>3º PASSO</h3><br>
Ao enviar o comprovante você aguardará o Recebedor da doação confirmar sua doação, ao ser confirmado você poderá começar
a cadastrar outros participantes, comece a divulgar seu link de indicação para seus amigos, familiares, conhecidos e etc...         
         
                            
			<div class="clearfix"></div>
		</div>
	</div>

</div>
<br />

<span id="contaC"></span>

                <div class="row">
<?php 
/*if($_SESSION['usuario']['fk_status'] == 2 ){
	$usu_master = $_SESSION['usuario']['usu_master'];
	$doc = $_SESSION['usuario']['master'];
	if(empty($doc)){	
	 if( $dados['metodo'] != "campanha"){*/
?> 
                    <div class="col-md-12 col-sm-4 col-xs-12">
                        <div class="x_panel tile fixed_height_320 overflow_hidden">
                            <div class="x_title">
                                <h2>Você deseja aumentar seus ganhos ?</h2>                            
                                <div class="clearfix"></div>
							</div>
                            <div class="x_content">
							
<div class="alert alert-info alert-dismissible fade in" role="alert" style="background:#F00; color:#FFF">                          
<h3>Registre em um clique quantas contas desejar.<p></h3>
</div>							       
<img class="carregando" src="http://<?php echo $dados['host'];?>/core/View/img/load.gif" style="display:none" />
<input class="btn btn-success" style="background:#000; color:#FFF" type="submit" id="reentrada" value="Abrir nova conta">   


                            </div>
                        </div>
                    </div>
<?php //} }	} ?>
                </div>

 
<script src="http://<?php echo $dados['host'];?>/core/View/js/livequery.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/reentrada.js"></script>