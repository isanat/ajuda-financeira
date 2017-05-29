<!DOCTYPE html>
 
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Escritório Virtual - Sistema de distribuição de doações espontâneas por usuários em rede de relacionamento!</title>
<meta name="keywords" content="ajudamutua, ajuda mutua, ajuda mutua oficial, sistema de ajuda mutua, rede de amigos, sistema de doacoes, doacao entre amigos">
<meta name="description" content="Ajude 1 pessoas para começar a participar, convide seus parentes, amigos ou conhecidos, e receba milhares de doações!!!">
<meta name="robots" content="index,follow">
<meta name="Language" content="Portuguese">
<meta name="Googlebot" content="all">
<meta name="revisit" content="2 days">
<meta name="author" content="Marcelo S Rodrigues - (11)98182-0513">
<meta name="copyright" content="Ajuda Mútua - Sistema de distribuição de doações espontâneas por usuários em rede de relacionamento!">
<meta name="identifier-url" content="http://associativismovirtual.com.br/">
<meta name="content-language" content="portuguese">
<meta name="robots" content="all">
<meta name="language" content="pt-br">

<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/twitter-bootstrap/bootstrap.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/social-jquery-ui-1.10.0.custom.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/social.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/social.plugins.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/font-awesome.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/social-coloredicons-buttons.css" rel="stylesheet">

<!-- <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery/jquery.js"></script> -->
<script>window.jQuery || document.write('<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery/jquery.js"><\/script>')</script>

<!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="http://<?php echo $dados['host'];?>/core/View/assets/css/social-jquery.ui.1.10.0.ie.css"/>
    <![endif]-->

<script>



  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-64078702-1', 'auto');
  ga('send', 'pageview');

</script> 
 
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/demo.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.uipro/style.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/themes/social.theme-blue.css" rel="stylesheet" id="theme">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/twitter-bootstrap/bootstrap-responsive.css" rel="stylesheet">
 
<style>

</style>
 
<style>.wraper #main{margin-top:40px;}</style>
 
 
<!--[if lt IE 9]>
      <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/html5shiv.js"></script>
    <![endif]-->

</head>

<body <?php if($dados['metodo'] == 'binario'){echo 'onload="prettyPrint()";';}?>>





<div class="wraper sidebar-full">
 <div id="testando"> 
<aside class="social-sidebar sidebar-full">
 
<div class="user-settings">

</div>
 
 
<div class="social-sidebar-content">
<div class="scrollable">



<div style="padding-right: 30px" class="navigation-sidebar">
	<img src="http://<?php echo $dados['host'];?>/module/<?php echo $dados['cliente']['usuario']?>/View/img/logo.png" class="img-rounded" width="150">
</div>

<div class="user">

	<span>
		<?php $nome = $_SESSION['usuario']['usu_usuario']; echo $nome?>
	</span>
	<i class="icon-user trigger-user-settings"></i>
</div>
 

<div class="search-sidebar">
<!-- img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/search.png" alt="Search">
<form class="search-sidebar-form">
<input type="text" class="search-query input-block-level" placeholder="Search">
</form -->
</div>
 
 
<section class="menu">
 
<div class="accordion" id="accordion2">
 
<div class="accordion-group <?php if($dados['metodo'] == 'home_msr'){ echo 'active'; }?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'home_msr'){ echo 'opened'; }?>" href="../Backoffice/home_msr">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/home.png" alt="Home">
<span>Home </span>
</a>
</div> 
</div>

<!-- DADOS PESSOAIS --> 
<div class="accordion-group <?php if($dados['classe'] == 'MeusDados'){ echo 'active';}?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'MeusDados'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#collapse-tables">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/identity.png" alt="Tables">
<span>Meus Dados </span><span class="arrow"></span>
</a>
</div>
<ul id="collapse-tables" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'MeusDados'){ echo 'in';}?>">
<li <?php if($dados['metodo'] == 'historico'){ echo 'class="dadospessoais"';}?>><a href="../MeusDados/dadospessoais">Dados Pessoais</a></li>
<li <?php if($dados['metodo'] == 'dadosbancarios'){ echo 'class="active"';}?>><a href="../MeusDados/dadosbancarios">Dados Bancários</a></li>
<li <?php if($dados['metodo'] == 'alterarsenha'){ echo 'class="active"';}?>><a href="../MeusDados/alterarsenha">Alterar Senha de Login</a></li>
</ul> 
</div>
<!-- FIM DADOS PESSOAS -->


<!-- PUBLICIDADE-->
<div class="accordion-group <?php if($dados['metodo'] == 'publicidade'){ echo 'active'; }?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'publicidade'){ echo 'opened'; }?>" href="../Publi/publicidade">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/propaganda.png" alt="Publicidade">
<span>Publicidade</span>
</a>
</div> 
</div>
 <!--FIM PUBLICIDADE -->

<!-- Realizar -->
<!--<div class="accordion-group <?php if($dados['metodo'] == 'subir'){ echo 'active'; }?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'subir'){ echo 'opened'; }?>" href="../Nivel/subir">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/sign-in.png" alt="Realizar">
<span>Subir Nível</span>
</a>
</div> 
</div>-->
<!-- FIM Realizar -->

<!-- Realizar -->
<div class="accordion-group <?php if($dados['metodo'] == 'recebimentos'){ echo 'active'; }?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'recebimentos'){ echo 'opened'; }?>" href="../Doacoes/recebimentos">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/money.png" alt="Meios de Recebimento">
<span>Meios de Recebimento</span>
</a>
</div> 
</div>
<!-- FIM Realizar -->


<!-- Realizar -->
<div class="accordion-group <?php if($dados['metodo'] == 'realizar'){ echo 'active'; }?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'realizar'){ echo 'opened'; }?>" href="../Doacoes/realizar">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/money.png" alt="Realizar">
<span>Doacões Realizar</span>
</a>
</div> 
</div>
<!-- FIM Realizar -->

<!-- Recebidas -->
<div class="accordion-group <?php if($dados['metodo'] == 'recebidas'){ echo 'active'; }?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'recebidas'){ echo 'opened'; }?>" href="../Doacoes/recebidas">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/money.png" alt="Realizar">
<span>Doacões Recebidas</span>
</a>
</div> 
</div>
<!-- FIM Recebidas -->

<!-- Realizadas -->
<div class="accordion-group <?php if($dados['metodo'] == 'realizadas'){ echo 'active'; }?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'realizadas'){ echo 'opened'; }?>" href="../Doacoes/realizadas">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/money.png" alt="Realizar">
<span>Doacões Realizadas</span>
</a>
</div> 
</div>
<!-- FIM Realizadas -->


<!-- INDICADOS DIRETA -->
<div class="accordion-group <?php if($dados['metodo'] == 'indicacoes'){ echo 'active'; }?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'indicacoes'){ echo 'opened'; }?>" href="../Indicados/indicacoes">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/group.png" alt="Home">
<span>Meus Indicados</span>
</a>
</div> 
</div>
<!-- FIM INDICADOS DIRETA -->

<!-- CADASTRO -->
<div class="accordion-group <?php if($dados['metodo'] == 'cad_usu'){ echo 'active'; }?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'cad_usu'){ echo 'opened'; }?>" href="../Cadastro/cad_usu">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/attibutes.png" alt="Cadastro">
<span>Cadastro</span>
</a>
</div> 
</div>
<!-- FIM CADASTRO -->




<!-- REDE -->
<div class="accordion-group <?php if($dados['classe'] == 'Rede'){ echo 'active';}?>" > 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'Rede'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#collapse-rede">
<i class="icon-sitemap icon-2"></i> <span> Rede </span><span class="arrow"></span>
</a>
</div> 
<ul id="collapse-rede" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'Rede'){ echo 'in';}?>">
<!--<li <?php if($dados['metodo'] == 'linear'){ echo 'class="active"';}?> ><a href="../Rede/linear">Linear</a></li>-->
<li <?php if($dados['metodo'] == 'matriz'){ echo 'class="active"';}?> ><a href="../Rede/matriz">Rede 3x3</a></li>
</ul> 
</div>
<!-- FIM REDE -->


<!-- PUBLICIDADE -->
<div class="accordion-group <?php if($dados['metodo'] == 'duvidas'){ echo 'active'; }?>"> 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'Faq'){ echo 'opened';}?>" href="../Faq/duvidas">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/faq.png" alt="FAQ"> 
<span>FAQ</span>
</a>
</div> 
</div>
<!-- FIM PUBLICIDADE -->

</div>
 
</div> 
</aside> 
<header>
 
<nav class="navbar navbar-blue navbar-fixed-top social-navbar">
<div class="navbar-inner" style="height:15px;">
<div class="container-fluid">

<a class="btn btn-navbar" data-toggle="collapse" data-target=".social-sidebar">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</a>

<!-- ALERTAS DE MENSAGENS -->
<ul class="nav pull-right nav-indicators">
<li class="dropdown nav-messages">
  
</li>
<!-- FIM ALERTAS DE MENSAGENS -->


<?php 
$usu_master = $_SESSION['usuario']['usu_master'];
$doc = $_SESSION['usuario']['master'];
if(empty($doc)){	
?>     
<ul class="nav visible-desktop vazio">
<li class="dropdown visible-desktop">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<strong>Visualizar Conta</strong>
<b class="caret"></b>
</a>
    <ul class="dropdown-menu">
    <?php 
	foreach($dados['model']['novasContas'] as $novasContas){ ?>
        <li class="docs" id="<?php echo $novasContas['usu_doc']; ?>">
          <a href="#"><?php echo $novasContas['usu_usuario']; ?></a>
        </li>
    <?php  } ?> 
   </ul>   
</li>
</ul>
<?php }else{ ?>     
  
<ul class="nav visible-desktop vazio">
<li class="dropdown visible-desktop">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<strong>Conta Master</strong>
<b class="caret"></b>
</a>
    <ul class="dropdown-menu">
        <li class="docs" id="<?php echo $doc; ?>">
          <a href="#"><?php echo $usu_master; ?></a>
        </li>

   </ul>   
</li>
</ul> 
  
<?php  } ?>  

<script src="http://<?php echo $dados['host'];?>/core/View/js/reentradaView.js"></script>
   
<li class="dropdown"><a href="../MeusDados/dadospessoais"><i class="icon-user"></i> Minha Conta</a>
	<li class="dropdown"><a href="http://marketingativo.com.br/ichat/" target="_blank">
    <img src="http://<?php echo $dados['host'];?>/module/ativo/View/img/chat.png" width="20" />CHAT</a>
<li class="dropdown"><a href="../Backoffice/sair"><i class="icon-off"></i> Sair</a>
</li>

<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.pulsate/jquery.pulsate.min.js"></script>
 <script src="http://<?php echo $dados['host'];?>/core/View/assets/js/ui-elements.general.js"></script>

</ul>
<span id="photoUsuo">
<?php if($dados['usuario']['usuario']['usu_logo'] != ''){?>
<img src="http://<?php echo $dados['host'];?>/core/View/foto_usuario/<?php echo $dados['usuario']['usuario']['usu_logo']; ?>" name="image" width="87" height="58"/>
<?php }?>
</span>

</div>

</div>

</nav>

</header>

    <div id="main">
        <div class="container-fluid">
        
            <div class="row-fluid">
                <div class="span12">
              
                    <h3 class="page-title">
                        Back Office - Associativismo Virtual<p><p>
						
                    </h3>
                    <ul class="breadcrumb">
                        <i class="icon-home"></i>
                            Seja Bem Vindo <a href="../MeusDados/dadospessoais"> <?php echo $_SESSION['usuario']['usu_usuario'];?> </a> <p><p>
   
<?php 
	$usu_master = $_SESSION['usuario']['usu_master'];
	$doc = $_SESSION['usuario']['master'];
	if(empty($doc)){	
?> 
   
    Link de Divulgação 
    <a href="http://associativismovirtual.com.br/<?php echo $_SESSION['usuario']['usu_usuario']; ?>" class="btn-link" target="_blank">
      <strong>http://associativismovirtual.com.br/<?php echo $_SESSION['usuario']['usu_usuario']; ?></strong>
    </a><p><p>
     <strong>ESTE LINK SERÁ ENVIADO APENAS DE FATO PARA AS PESSOAS QUE REALMENTE IRÃO PARTICIPAR DO PROJETO.</strong><p>
     <strong>  LINK: </strong><a href="http://bc.associativismovirtual.com.br/Usuario/cadastrar/usuario/<?php echo $_SESSION['usuario']['usu_usuario']; ?>"><strong>bc.associativismovirtual.com.br/Usuario/cadastrar/usuario/<?php echo $_SESSION['usuario']['usu_usuario']; ?></strong></a>
	<?php if($_SESSION['usuario']['fk_status'] == 2){ ?>
    <p><p><strong>Participe do grupo no WhatsApp: </strong>(11) 98182-0513<p><p>
    <?php } ?>
<?php } ?>          
                     
                     </li>
                    </ul>
                </div>
            </div>

<script src="http://<?php echo $dados['host'];?>/core/View/js/livequery.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/reentrada.js"></script>

<?php 
$usu_master = $_SESSION['usuario']['usu_master'];
$doc = $_SESSION['usuario']['master'];
if(empty($doc)){	
 if( $dados['metodo'] != "campanha"){
?> 
                
<div class="social-box ">
    <header class="header">
     <h4><strong>ATENÇÃO</strong> <strong>Deseja aumentar os seus ganhos no sistema?</strong></h4>   
    </header>    
    <div class="body">   
    <div class="alert alert-info publi2">
     <strong><p>Registre em um clique quantas contas desejar.
     É rápido fácil e contribui significativamente para o crescimento de toda a equipe!</strong>
    <p><p>
   </div> 
       <div class="row-fluid" style="padding:10px" >
        <img class="carregando" src="http://<?php echo $dados['host'];?>/core/View/img/load.gif" style="display:none" />
        <input class="btn btn-primary" type="submit" id="reentrada" value="Abrir nova conta">        
       </div>         
    </div>
</div>
<?php 
}	}
?> 
        
         <script type="text/javascript">
		   $(".publi").pulsate({
			  pause: 1000,
			  color: "#468847"
			}); 
			
			$(".publi2").pulsate({
			  pause: 1000,
			  color: "#5970A2"
			}); 
		    
			$(".vazio").pulsate({
			  pause: 1000,
			  color: "#FFF"
			}); 
			 
         </script>
         
<!--<div class="alert alert-success"><strong>ATENÇÃO!</strong> 

OLÁ <strong><?php echo $_SESSION['usuario']['usu_usuario']; ?></strong> PARTICIPE DE UM TIRÁ DÚVIDAS AGORA É TIRE TODAS AS SUAS DÚVIDAS, E SÓ CLICAR EM <a href="http://login.meetcheap.com/conference,40157194" target="_blank" style="color:red">PARTICIPAR</a>SE POSSÍVEL COM FONE DE OUVIDO. </div>-->


<?php include_once($dados['caminho'] . $dados['metodo'] . '.php'); ?>
        

     </div> 
        <footer id="footer" style="margin:0 0 10px 0; padding-left:10px">
            <div>                        
                2015 © <em>Associativismo Virtual</em>
            </div>
        </footer>
    </div>
  
</div>

<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.ui.touch-punch/jquery.ui.touch-punch.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/twitter-bootstrap/bootstrap.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
<!-- <script src="http://<?php //echo $dados['host'];?>/core/View/assets/plugins/jquery.cookie/jquery.cookie.js"></script> -->
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.uipro/uipro.min.js"></script>
 <script src="http://<?php echo $dados['host'];?>/core/View/js/voucher.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/carrinho.js"></script>
<!-- <script src="http://<?php //echo $dados['host'];?>/core/View/assets/plugins/jquery.livefilter/jquery.livefilter.js"></script> -->
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/extents.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/app.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/demo-settings.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/sidebar.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.maskMoney.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.mask.js"></script>

<?php if($dados['metodo'] == 'historico'  || $dados['metodo'] == 'historico_bonus' || $dados['metodo'] == 'meuspedidos' || $dados['metodo'] == 'listarvoucher'|| $dados['metodo'] == 'pontuacao'|| $dados['metodo'] == 'comissoes' ){?>
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/DT_bootstrap.css"/>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.dataTables.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.dataTables.bootstrap.js"></script>

<?php }?>

<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/ui-elements.jquery-ui.js"></script>

<?php 
if( !empty( $dados['javascript'] ) ) {
?>
<script type="text/javascript" src="http://<?php echo $dados['host'].'/'.$dados['javascript'];?>"></script>
<?php
}
?>

<?php if($dados['classe'] == 'Rede'){?>

<script src="http://<?php echo $dados['host'];?>/core/View/js/rede.js"></script>
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/lib/rede/css/jquery.jOrgChart.css"/>
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/lib/rede/css/custom.css"/>
<link href="http://<?php echo $dados['host'];?>/core/lib/rede/css/prettify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/lib/rede/prettify.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/lib/rede/jquery.jOrgChart.js"></script>

<script>
    jQuery(document).ready(function() {
        $("#org").jOrgChart({
            chartElement : '#chart',
            dragAndDrop  : false
        });

        $(".redeusu").click(function(){

    		usu = $(this).attr('id');

    		$("#busca_usu_rede").val(usu)

    		$('#form_usu_rede').submit();
    	});
    });
</script>


<!-- BEGIN JAVASCRIPT CODES FOR THE CURRENT PAGE -->
      <!-- jqueyUi Nestable Lists -->
  <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.nestable/jquery.nestable.js"></script>

    <!-- END JAVASCRIPT CODES FOR THE CURRENT PAGE -->

<?php }?>

<script>
    /*<![CDATA[*/

    /*]]>*/
</script>



<?php if($dados['metodo'] == 'home_msr'){ ?>
<!-- ****************************************** -->     
<!-- Scripts
<script type="text/javascript" src="http://alojasites.com/downloads/facebookpopup/jquery.min.js"></script>
<script src="http://alojasites.com/downloads/facebookpopup/colorbox-min.js"></script>
<link rel="stylesheet" href="http://alojasites.com/downloads/facebookpopup/fbpopup.css" type="text/css" />
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
 Adsense -->
<script type="text/javascript">
/*jQuery(document).ready(function(){
 if (document.cookie.indexOf('visited=true') == -1) {
  var fifteenDays = 1000*60*60*24*1;
  var expires = new Date((new Date()).valueOf() + fifteenDays);
  document.cookie = "visited=true;expires=" + expires.toUTCString();  
  $.colorbox({width:"500px", inline:true,keyboard: false, href:"#mdfb"});  
  (adsbygoogle = window.adsbygoogle || []).push({});
  document.getElementById('cboxOverlay').setAttribute('id','bg'); 
 }
 
 $('.popUp').modal({
 keyboard: false
 });
 
 $(function(){
     $('.adSense').mousedown(function(){      
        document.getElementById('adSense').setAttribute('style', 'display: none');
     $.colorbox.close();
        $('base').removeAttr('target');
     });  
 });
});*/
</script>
<!-- Fim 
<div style='display:none;  overflow:visible' class="popUp"> 

 <div id='mdfb' background:#fff; style='padding:5px; background:#fff; text-align: center; overflow:visible'>

<div class="adSense" id = "adSense" style="position:absolute; 
z-index:1; 
padding:0; 
float: left; 
margin-left: 300px; 
margin-top: 190px;
opacity: 0;"> 

<ins class="adsbygoogle"
     style="display:block; width:200px; height:150px; border:1px solid red"
     data-ad-client="ca-pub-8467032907801760"
     data-ad-slot="5016493132"
     data-ad-format="auto">
</ins>

</div>

<iframe src="//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/associativismovirtual&amp;
  width=300&amp;
  colorscheme=light&amp;
  show_faces=true&amp;
  border_color=%23ffffff&amp;
  stream=false&amp;header=false&amp;
  height=258"
  scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:400px; height:258px; display: block">
</iframe>     


</center> 
</div>
</div>
Adsense -->  
<?php } ?>










</body>
</html>