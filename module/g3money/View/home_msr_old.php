
<?php 
//echo "<pre>"; print_r($dados['model']['doar']['rece']); die;
 $valor = 0;
 foreach($dados['model']['doar']['rece'] as $receber){
	$valor += $receber['ped_total'];
 }
$usu      = $dados['model']['nivel']['resNivel'][0]['usu_fk'];
$ped      = $dados['model']['nivel']['resNivel'][0]['fk_status'];
$nivelUsu = $dados['model']['nivel']['resNivel'][0]['ped_nivel'];

//echo "<pre>"; print_r($dados['model']['nivel']); die;


if(empty($dados['model']['banco']['bancoOnline'])){
?>

<aside id="alertar" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="myModalLabel" class="enviar_comprovante" style="color:red">PENDÊNCIA</h3>
    </div>
    <div class="modal-body validCompro">
<strong>1º</strong> - VOCÊ PRECISA CADASTRAR SUA CONTA BANCÁRIA PARA QUE VOCÊ POSSA ESTÁ RECEBENDO NORMALMENTE.<p><p>
    </div>
</aside>


<?php }
if($_SESSION['usuario']['usu_doc'] != "00000000001"){
	  
if($dados['model']['banco']['bancoOnline']){
if(empty($dados['model']['ativa'])){
?>
<!-- INICIO ENVIAR COMPROVANTE -->
<aside id="alertars" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="myModalLabel" class="enviar_comprovante" style="color:red">PENDÊNCIA</h3>
    </div>
    <div class="modal-body validCompro">
<strong>1º</strong> - VOCÊ PRECISA EFETUAR SUA PRIMEIRA DOAÇÃO EM 48 HORAS PARA QUE VOCÊ POSSA ESTÁ CADASTRANDO OUTROS PARTICIPANTES, OU VOCÊ PODERÁ ESTÁ PERDENDO SUA CONTA.<p><p>
</div>
</aside>
<!-- FIM ENVIAR COMPROVANTE -->

<?php }}} ?>



<?php 
//Se a data ainda não venceu me exibe o prazo que tenho
$vencimento = $dados['model']['dia'][0]['ped_data_expira'];

//echo "<pre>"; print_r($vencimento); die;

if( $vencimento > date('Y-m-d H:m:s')){
 ?>
<div class="social-box">
    <header class="header">
    <h4>Prazo para efetuar sua 1º doação, após a confirmação você poderá cadastrar outros participantes.</h4>    
    </header>    
    <div class="body">        
       <div class="row-fluid">
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/contatdor.css" type="text/css" />

<div id="contador">
  <div style="color:#3C3C3C;text-align:center" id="clock" class="onstart animated" data-animation="fadeInUp" data-animation-out="fadeOutDown" data-animation-delay="600" data-animation-out-delay="1000"></div>
</div>

       </div>         
    </div>
</div> 
 <?php } ?>
 
 
<?php 
//Relogio contando as 48 hrs
$relogio = $dados['model']['relogio'][0]['ped_data_expira'];

if( empty($vencimento)){

if( $relogio > date('d/m/Y H:m:s')){ ?>
<div class="social-box">
    <header class="header">
    <h4>Prazo para que você possa está efetuando sua proxíma doação.</h4>    
    </header>    
    <div class="body">        
       <div class="row-fluid">
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/contatdor.css" type="text/css" />

<div id="contador_relogio">
  <div style="color:#3C3C3C;text-align:center" id="relogio" class="onstart animated" data-animation="fadeInUp" data-animation-out="fadeOutDown" data-animation-delay="600" data-animation-out-delay="1000"></div>
</div>
       </div>         
    </div>
</div> 
 <?php } } ?>


 <?php if(!empty($dados['model']['migrar3m1r'])){ ?>
<div class="social-box">
    <header class="header">
    <h4>Conheça o projeto <strong>3M1R</strong> Ajuda Mútua Financeira.</h4>    
    </header>    
    <div class="body">        
       <div class="row-fluid">
        <a target="_blank" href="http://3m1r.com.br/3m1r">
           <img src="http://<?php echo $dados['host'];?>/module/ativo/View/img/bannerativo.png"/>
        </a>
       </div>         
    </div>
</div>
 <?php } ?>

 <?php if($_SESSION['usuario']['fk_status'] == 1){ ?>

<div class="social-box">
    <header class="header">
    <h4>SIMPLES PARA COMEÇAR</h4>    
    </header>
    
    <div class="body">        
       <div class="row-fluid">
         
<strong>1º PASSO</strong><br>
Faça sua 1º doação de R$ 20,00 reais via depósito ou transferência bancária para seu 1º UPLINE, <strong>DOAÇÕES REAIZAR</strong>.<p><p>

<strong>2º PASSO</strong><br>
Escaneie ou fotografe o comprovante e envie para o participante pelo seu Escritório Virtual. (O site enviará o comprovante<br>
para o participante a qual você fez a doação) .<p><p>

<strong>3º PASSO</strong><br>
Ao enviar o comprovante você aguardará o Recebedor da doação confirmar sua doação, ao ser confirmado você poderá começar<br>
a cadastrar outros participantes, comece a divulgar seu link de indicação para seus amigos, familiares, conhecidos e etc...         
         
       </div>         
    </div>
</div>
<?php } ?>



<div class="social-box">
    <header class="header">
    <h4><i class="icon-bar-chart"></i> Dados</h4>    
    </header>
    
    <div class="body">        
       <div class="row-fluid">
          <a href="../../Doacoes/recebidas" class="icon-btn span6">
            <i class="icon-money icon-5x"></i>
            <div>Doações Recebidas</div>
            <span class="badge  label-info badge-right">R$:<?php echo number_format($valor,2,",","."); ?></span>
          </a>          
          <a href="#" class="icon-btn icon-btn-blue span6">
            <i class="icon-sitemap icon-5x"></i>
            <div>Nível</div>
            <?php if( $usu == 2 && $ped == 3 ){ ?>
              <span class="badge label-success"><?php echo $nivelUsu; ?></span>
            <?php }else{ ?>
                <span class="badge label-success">0</span>			
			<?php } ?>
          </a>
       </div>         
    </div>
</div>

<?php //echo "<pre>"; print_r($dados['model']['preenchendoLinha']); die; ?>

<div class="social-box">
    <header class="header">
    <h4><strong>Como estou no Associativismo Virtual?</strong></h4>    
    </header>

   <div class="body">
    <table class="table table-striped">
      <tbody>
        <tr>
          <th width="660">Sua posição na rede é: </th>
          <td width="633"><span class="label label-info" style="font-size:20px"><?php echo $dados['model']['posicaoRede']['total']."º Linha"; ?></span></td>
        </tr>
        <tr>
          <th>O sistema está preenchendo a: </th>
          <td><span class="label label-success" style="font-size:20px"><?php echo $dados['model']['preenchendoLinha']['total']."º linha"; ?></span></td>
        </tr>
       <!-- <tr>
          <th>Quantas pessoas estão na sua frente para receber doações: </th>
          <td><span class="label label-info">@fat</span></td>
        </tr>-->
        <tr>
          <th>Meu último indicado</th>
          <td><span class="label label-info" style="font-size:20px"><?php echo $dados['model']['meusUltimosCadastros']['ultimoCad'][0]['usu_data']; ?></span></td>
        </tr>
    <!--    <tr>
          <th>Quantas pessoas já entraram no sistema depois de mim:</th>
          <td><span class="label label-success" style="font-size:20px"><?php echo $dados['model']['cadDepoisDeMim']['total']; ?> Pessoas</span></td>
        </tr>-->
        <tr>
          <th>A partir de 3 sim automático de comprovantes você perderá sua conta: </th>
          <td><span class="label" style="font-size:20px; background:#F00">0</span></td>
        </tr>
     </tbody>
    </table>
          </div>
</div>


<?php
if($_COOKIE['visitas'] < date('d/m/Y')){
  setcookie('visitas', '');
}

$data = date('d/m/Y'); 
setcookie('visitas', $data);

if($_COOKIE['visitas'] != date('d/m/Y')){ ?>
<!--
<aside id="alertars2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px">
    <div class="modal-header">
       <form method="post" id="viewModal">
        <h3 id="myModalLabel" class="enviar_comprovante" style="color:red">ATENÇÃO</h3>
    </div>
    <div class="modal-body">
    
<strong>Parceiros(as)</strong> , de nada vale termos o melhor Sistema de Ajuda Mútua se ele não for conhecido!<p><p>

Contamos com a colaboração de todos para divulgarem regularmente nossas publicidades em suas redes sociais, afinal só assim nos tornamos fortes enquanto uma equipe.<p>

Aos que tem tempo útil mesmo que pouco, por favor fique online no CHAT e dê suporte a quem tem dúvida.<p>

Quem ainda não tem nenhum usuário em sua rede, atenda nossos visitantes do CHAT e recupere imediatamente o valor doado.<p>

Você tem uma grande ideia que vai ajudar toda a equipe, por favor acesse o formulário de contato e nos avise.

<p><p>

<div class="modal-footer">
        <button type="submit" class="btn btn-success" data-dismiss="modal">Fechar</button>
      </div>
      </form>

    </div>
</aside>-->
<?php } ?>


<?php if($_SESSION['usuario']['fk_status'] == 2){ ?>
<aside id="alertars2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px; height:500px">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="myModalLabel" class="tituloCampanha" style="color:red">CAMPANHA: QUEM INDICA GANHA MUITO MAIS!</h3>
    </div>
    <div class="modal-body">

<strong>OBJETIVO DA CAMPANHA:</strong><p>
Incentivar financeiramente as pessoas que mais indicam pessoas para o projeto se tornar um verdadeiro sucesso.<p><p>

<strong>O PRÊMIO:</strong><p>
Os vencedores iram receber o montante do prêmio em dinheiro em suas contas do PagSeguro.<p><p>

<strong>REGRAS:</strong><p>
Será o grande vencedor a pessoa que mais tiver indicado pessoas ativas no período de um mês da data estipulada, em caso de empate, o usuário mais antigo será o vencedor. <p>Sendo que, o 1º lugar receberá 50% dos valores recebidos durante a campanha.<p><p>

O valor da Campanha será de R$:10,00 <p><p>

Os 50% restante da premiação em dinheiro será distribuído igualmente a todos os demais ganhadores, que:<br>
- Tenha quatro ou mais indicados ativos durante a campanha.<p><p>

<strong>ORIGEM DOS RECURSOS A SEREM PREMIADOS:</strong><p>
É de interesse de toda a equipe que o sistema cresça mais rapidamente e todos nós temos que dar a nossa parcela de contribuição para que isso aconteça.<p><p>

<strong>INÍCIO DA CAMPANHA:</strong><p>
A campanha começará no dia <strong>01/09/2015</strong> é terminará <strong>01/10/2015</strong> com o grande vencedor(a) que será anúnciado(a) para todos do projeto Associativismo Virtual.<p><p>

<strong>Atenciosamente</strong><p><p>

<strong>Associativismo Virtual</strong><p><p>
<strong>Onde pequenos valores, somam grandes OPORTUNIDADES.</strong>


<div class="modal-footer">
<form action="https://pagseguro.uol.com.br/checkout/v2/donation.html" method="post">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="currency" value="BRL" />
<input type="hidden" name="receiverEmail" value="nilspoladori@yahoo.com.br" />
<input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/doacoes/209x48-doar-assina.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
     </div>
</div>

    </div>
</aside>
<?php } ?>



<div class="row-fluid sortable-socialboxes">
           
            <div class="span6 column ui-sortable" id="col-1" style="text-align:center">
             <article id="porlet-1" class="social-box sortable ui-helper-clearfix">
              <header>
                <h4><img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/video.png"> Vídeo de Apresentação</h4>              </header>
              <div class="body">
                 <iframe width="420" height="315" src="https://www.youtube.com/embed/VBnzpUvMZIw" frameborder="0" allowfullscreen></iframe>
              </div>
           </article>
          </div>
          
          <div class="span6 column ui-sortable" id="col-1" style="text-align:center">
             <article id="porlet-1" class="social-box sortable ui-helper-clearfix">
              <header>
                <h4><img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/video.png"> REGRAS DO SISTEMA</h4>              </header>
              <div class="body">
                 <iframe width="420" height="315" src="https://www.youtube.com/embed/TFbdwjiPGYo" frameborder="0" allowfullscreen></iframe>
              </div>
           </article>
          </div>
 </div>
 
 
<div class="row-fluid sortable-socialboxes">      
  
          <div class="span6 column ui-sortable" id="col-1" style="text-align:center">
             <article id="porlet-1" class="social-box sortable ui-helper-clearfix">
              <header>
                <h4><img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/video.png"> Demonstrativo Financeiro</h4>              </header>
              <div class="body">
                 <iframe width="420" height="315" src="https://www.youtube.com/embed/1RNOhkYkCyY" frameborder="0" allowfullscreen></iframe>
              </div>
           </article>
          </div>
          
          <div class="span6 column ui-sortable" id="col-1" style="text-align:center">
             <article id="porlet-1" class="social-box sortable ui-helper-clearfix">
              <header>
                <h4><img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/video.png"> A VERDADEIRA AJUDA MÚTUA</h4>              </header>
              <div class="body">
                 <iframe width="420" height="315" src="https://www.youtube.com/embed/25vUr3JP3V4" frameborder="0" allowfullscreen></iframe>
              </div>
           </article>
          </div>

 </div>






<script src='http://<?php echo $dados['host'];?>/core/View/js/jquery.min-1.11.2.js' type="text/javascript"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.countdown.js" type="text/javascript"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.pulsate/jquery.pulsate.min.js"></script>
 <script src="http://<?php echo $dados['host'];?>/core/View/assets/js/ui-elements.general.js"></script>
<script>
$(document).ready(function() {
   $('#alertar').modal('show');
   $('#alertars').modal('show');
   $('#alertars2').modal('show');
   
   $(".participar").pulsate({
			  pause: 1000,
			  color: "#468847"
			}); 
			
  $(".tituloCampanha").pulsate({
			  pause: 1000,
			  color: "rgb(222, 22, 22)"
  }); 	
  
  
  
  		
   
});
</script>

<script>
(function($) {
  "use strict";
/* ------------------------------------------------------------------------ */
/*	COUNTDOWN
/* ------------------------------------------------------------------------ */

$('#clock').countdown('<?php echo $dados['model']['dia'][0]['ped_data_expira']; ?>').on('update.countdown', function(event) {
	var $this = $(this).html(event.strftime(''
		+ '<div class="counter-container"><div class="counter-box first"><div class="number">%-D</div><span>Dia(s)%!d</span></div>'
		+ '<div class="counter-box"><div class="number">%H</div><span>Horas</span></div>'
		+ '<div class="counter-box"><div class="number">%M</div><span>Minutos</span></div>'
		+ '<div class="counter-box last"><div class="number">%S</div><span>Segundos</span></div></div>'
	));
});


$('#relogio').countdown('<?php echo $dados['model']['relogio'][0]['ped_data_expira']; ?>').on('update.countdown', function(event) {
	var $this = $(this).html(event.strftime(''
		+ '<div class="counter-container"><div class="counter-box first"><div class="number">%-D</div><span>Dia(s)%!d</span></div>'
		+ '<div class="counter-box"><div class="number">%H</div><span>Horas</span></div>'
		+ '<div class="counter-box"><div class="number">%M</div><span>Minutos</span></div>'
		+ '<div class="counter-box last"><div class="number">%S</div><span>Segundos</span></div></div>'
	));
});



jQuery(document).ready(function() {

	/* How to Handle Hashtags */
	jQuery(window).hashchange(function(){
		var hash = location.hash;
		jQuery('a[href='+hash+']').trigger('click');
	});
	jQuery('section.content.hide').hide();
	/* Main Navigation Clicks */
	jQuery('.main-nav ul li a').click(function() {
		var link = jQuery(this).attr('href').substr(1);
		
		if ( !jQuery('section.content.show, section#' + link).is(':animated') ) {
			jQuery('.main-nav ul li a').removeClass('active'); //remove active
			jQuery('section.content.show').addClass('show').animate({'opacity' : 0}, {queue: false, duration: 1000,
				complete: function() {
					jQuery('section.content.show').hide();
					jQuery('a[href="#'+link+'"]').addClass('active'); // add active
					jQuery('section#' + link).show();
					jQuery('section#' + link).addClass('show').animate({'opacity' : 1}, {queue: false, duration: 1000});	
				}
			});
		}
	});

});

})(jQuery);

</script>



