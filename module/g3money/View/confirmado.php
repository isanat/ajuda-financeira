<!DOCTYPE html>
 
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Back Office - <?php echo strtoupper($dados['cliente']['usuario'])?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<link rel="shortcut icon" href="http://<?php echo $dados['host'];?>/core/View/assets/img/favicon.ico"/>
<link rel="icon" type="image/gif" href="http://<?php echo $dados['host'];?>/core/View/assets/img/favicon.gif">
 
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
 
 
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/demo.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.uipro/style.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/themes/social.theme-blue.css" rel="stylesheet" id="theme">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/twitter-bootstrap/bootstrap-responsive.css" rel="stylesheet">
 
<style>#external-events{float:left;padding:0 10px;border:1px solid #ccc;background:#eee;text-align:left;}#external-events h4{font-size:16px;margin-top:0;padding-top:1em;}.external-event{margin:10px 0;padding:2px 4px;color:#ffffff;text-shadow:0 -1px 0 rgba(0,0,0,0.25);background-color:#4e6599;border-color:#2c467e #2c467e #182745;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);*background-color:#2c467e;filter:progid:DXImageTransform.Microsoft.gradient(enabled= false);font-size:.85em;cursor:pointer;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;}#external-events p{margin:1.5em 0;font-size:11px;color:#666;}#external-events p input{margin:0;vertical-align:middle;}</style>
 
<style>.wraper #main{margin-top:40px;}</style>
 
 
<!--[if lt IE 9]>
      <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/html5shiv.js"></script>
    <![endif]-->

</head>

<body <?php if($dados['classe'] == 'Rede'){echo 'onload="prettyPrint()";';}?>>

<div class="wraper sidebar-full">
 <div id="testando"> 
<aside class="social-sidebar sidebar-full">
 
<div class="user-settings">
<div class="arrow"></div>
<h3 class="user-settings-title">Minhas Configurações</h3>
<div class="user-settings-content">
<a href="#">
<div class="icon">
<i class="icon-user"></i>
</div>
<div class="title">Minha Conta</div>
<div class="content">Editar meus dados</div>
</a>
<a href="#">
<div class="icon">
<i class="icon-envelope"></i>
</div>
<div class="title">Ver Mensagens</div>
<div class="content">Você tem <strong>17</strong> mensagens</div>
</a>
<a href="#view-pending-tasks">
<div class="icon">
<i class="icon-tasks"></i>
</div>
<div class="title">Seus Relatórios</div>
<div class="content">Você tem <strong>8</strong> pendentes</div>
</a>
</div>
<div class="user-settings-footer">
<a href="#more-settings">Configuração Geral</a>
</div>
</div>
 
 
<div class="social-sidebar-content">
<div class="scrollable">



<div style="padding-right: 30px" class="navigation-sidebar">
	<img src="http://<?php echo $dados['host'];?>/module/<?php echo $dados['cliente']['usuario']?>/View/img/logo.png" class="img-rounded" width="150">
</div>

<div class="user">

	<span>
		<?php $nome = explode(' ',$dados['usuario']['usuario']['usu_nome']); echo $nome[0]?>
	</span>
	<i class="icon-user trigger-user-settings"></i>
</div>
 
 
<div class="navigation-sidebar">
<i class="switch-sidebar-icon icon-align-justify"></i>
</div>
 
 
<div class="search-sidebar">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/search.png" alt="Search">
<form class="search-sidebar-form">
<input type="text" class="search-query input-block-level" placeholder="Search">
</form>
</div>
 
 
<section class="menu">
 
<div class="accordion" id="accordion2">
 
<div class="accordion-group <?php if($dados['metodo'] == 'home'){ echo 'active'; }?> ">
 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'home'){ echo 'opened'; }?>" href="#">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/home.png" alt="Home">
<span>Home </span>
</a>
</div>
</div>

<div class="accordion-group <?php if($dados['metodo'] == 'meuspedidos'){ echo 'active'; }?>">
 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['metodo'] == 'meuspedidos'){ echo 'opened'; }?>" href="#">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/product.png" alt="Home">
<span>Meus Pedidos </span>
</a>
</div>
 
</div>
 
<div class="accordion-group <?php if($dados['classe'] == 'MeusDados'){ echo 'active';}?>">
 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'MeusDados'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#collapse-tables">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/identity.png" alt="Tables">
<span>Meus Dados </span><span class="arrow"></span>
</a>
</div>
 
 
<ul id="collapse-tables" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'MeusDados'){ echo 'in';}?>">
<li <?php if($dados['metodo'] == 'historico'){ echo 'class="dadospessoais"';}?>><a href="#">Dados Pessoais</a></li>
<li <?php if($dados['metodo'] == 'dadosbancarios'){ echo 'class="active"';}?>><a href="#">Dados Bancários</a></li>
<li <?php if($dados['metodo'] == 'alterarsenha'){ echo 'class="active"';}?>><a href="#">Alterar Senha de Login</a></li>
<li <?php if($dados['metodo'] == 'alterartoken'){ echo 'class="active"';}?>><a href="#">Alterar Token</a></li>
</ul>
 
</div>
 
<div class="accordion-group <?php if($dados['classe'] == 'ContaCorrente'){ echo 'active';}?>" >
 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'ContaCorrente'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#collapse-ui-elements">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/money.png" alt="Relatórios">
<span>Conta Corrente </span><span class="arrow"></span>
</a>
</div>
 
 
<ul id="collapse-ui-elements" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'ContaCorrente'){ echo 'in';}?>">
<li <?php if($dados['metodo'] == 'contacorrente'){ echo 'class="active"';}?> ><a href="#">Conta Corrente</a></li>
<li <?php if($dados['metodo'] == 'historico'){ echo 'class="active"';}?> ><a href="#">Histórico</a></li>
<li <?php if($dados['metodo'] == 'historico_bonus'){ echo 'class="active"';}?> ><a href="#">Histórico Bonus</a></li>
<li <?php if($dados['metodo'] == 'tranferencia'){ echo 'class="active"';}?>><a href="#">Transferência</a></li>
<li <?php if($dados['metodo'] == 'pagarpedidos'){ echo 'class="active"';}?>><a href="#">Pagar Pedidos</a></li>
<li <?php if($dados['metodo'] == 'solicitarsaque'){ echo 'class="active"';}?>><a href="#">Solicitar Saque</a></li>
</ul>
 
</div>
 
 
<div class="accordion-group <?php if($dados['classe'] == 'Extrato'){ echo 'active';}?>" >
 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'Extrato'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#collapse-extrato">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/credit.png" alt="Relatórios">
<span>Extrato de Rede </span><span class="arrow"></span>
</a>
</div>
 
 
<ul id="collapse-extrato" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'Extrato'){ echo 'in';}?>">
<li <?php if($dados['metodo'] == 'pontuacao'){ echo 'class="active"';}?> ><a href="#">Pontuação</a></li>
<li <?php if($dados['metodo'] == 'comissoes'){ echo 'class="active"';}?> ><a href="#">Comissoes</a></li>
</ul>
 
</div>
 
 
 

 
 
<div class="accordion-group  hidden-desktop">
 
<div class="accordion-heading">
<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion2" href="#collapse-layouts">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/database.png" alt="Layouts">
<span>Rápido </span><span class="arrow"></span>
</a>
</div>
 
 
<ul id="collapse-layouts" class="accordion-body nav nav-list collapse ">
<li><a href="#">Meus Pedidos</a></li>
<li><a href="#">Histórico</a></li>
<li><a href="#">Transferência</a></li>
<li><a href="#">Pagar Pedidos</a></li>
<li><a href="#">Solicitar Saque</a></li>
<li><a href="#">Meus Dados</a></li>
<li><a href="#">Dados Bancários</a></li>
<li><a href="#">Alterar Senha</a></li>
<li><a href="#">Alterar Token</a></li>
<li><a href="#">Rede</a></li>
</ul>
 
</div>

<div class="accordion-group <?php if($dados['classe'] == 'Rede'){ echo 'active';}?>">
 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'Rede'){ echo 'opened';}?>" href="#">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/group.png" alt="Rede">
<span>Rede </span>
</a>
</div>
 
</div>

<!-- INICIO COMPRAR VOUCHER -->
<div class="accordion-group <?php if($dados['classe'] == 'Voucher'){ echo 'active';}?>">
 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'Voucher'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#collapse-tables-voucher">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/voucher.png" alt="Tables">
<span>Voucher </span><span class="arrow"></span>
</a>
</div>
 
 
<ul id="collapse-tables-voucher" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'Voucher'){ echo 'in';}?>">
<li <?php if($dados['metodo'] == 'comprarvoucher'){ echo 'class="active"';}?>><a href="#">Comprar</a></li>
<li <?php if($dados['metodo'] == 'listarvoucher'){ echo 'class="active"';}?>><a href="#">Listar</a></li>
</ul> 
</div>
<!-- FIM COMPRAR VOUCHER -->


 </div>
 
</section>
 
</div>
 
 
</div>
 
</aside>
 
<header>
 
<nav class="navbar navbar-blue navbar-fixed-top social-navbar">
<div class="navbar-inner">
<div class="container-fluid">
 
<a class="btn btn-navbar" data-toggle="collapse" data-target=".social-sidebar">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</a>
 
 
<a class="brand" href="#">
Menu 
</a>
 
<ul class="nav visible-desktop">
 

<li class="dropdown ">
<a href="#layouts" class="dropdown-toggle" data-toggle="dropdown">Rápido <b class="caret"></b></a>
<ul class="dropdown-menu">
 
<li><a href="">Meus Pedidos</a></li>
<li><a href="">Histórico</a></li>
<li><a href="">Transferência</a></li>
<li><a href="">Pagar Pedidos</a></li>
<li><a href="">Solicitar Saque</a></li>
<li><a href="">Meus Dados</a></li>
<li><a href="">Dados Bancários</a></li>
<li><a href="">Alterar Senha</a></li>
<li><a href="">Alterar Token</a></li>
<li><a href="">Rede</a></li>
 
</ul>
</li>
  </ul>
 
 
<ul class="nav pull-right nav-indicators">
 
 
 
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-caret-down"></i></a>
<ul class="dropdown-menu">
<li><a href="#"><i class="icon-user"></i> Minha Conta</a></li>
<!-- <li><a href="#"><i class="icon-cogs"></i> Configurar</a></li> -->
<li><a href="../Backoffice/sair"><i class="icon-off"></i> Log Out</a></li>
<li class="divider"></li>
<!-- <li><a href="#"><i class="icon-info-sign"></i> Help</a></li> -->
</ul>
</li>
 
</ul>
 
 


 
</div>
</div>
</nav>
 
</header>
 
<div id="main">
 
<div class="container-fluid">
<div class="row-fluid">
<div class="span12">
<h3 class="page-title">
Back Office
</h3>
 
<ul class="breadcrumb">
<li>
<i class="icon-home"></i>
Seja Bem Vindo!<a href="#"> </a> 
</li>
</ul>
 
</div>
</div>

<div class="social-box">
	<div class="header">
		<h4>Parabéns, Seu cadastro foi confirmado!</h4>
	</div>
	<div class="body">
		<table class="table">
			<tbody>
				<tr>
					
					<td>
					
						Efetue seu pagamento para ter acesso total em seu Back Office!
					
					</td>
					
				</tr>
				
				<tr>
					<td></td>
					
					
				</tr>
			</tbody>
		</table>
	</div>
</div>

</div>

 
<footer id="footer">
<div class="container-fluid">
2014 © <em>Sistema MMN</em> by <a href="http://www.httpstudio.com.br" target="_blank">httpstudio</a>.
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

<?php if($dados['metodo'] == 'historico'  || $dados['metodo'] == 'historico_bonus' || $dados['metodo'] == 'meuspedidos' || $dados['metodo'] == 'listarvoucher'|| $dados['metodo'] == 'pontuacao'|| $dados['metodo'] == 'comissoes' ){?>
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/DT_bootstrap.css"/>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.dataTables.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.dataTables.bootstrap.js"></script>


<script type="text/javascript">
			$(function() {
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			      null, null,null, null, null, null,
				  { "bSortable": false }
				] } );


				


				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();

					var off2 = $source.offset();
					var w2 = $source.width();

					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
		</script>
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
 </div>

<script>
    jQuery(document).ready(function() {
        $("#org").jOrgChart({
            chartElement : '#chart',
            dragAndDrop  : false
        });
    });
</script>

<?php }?>

<script>
    /*<![CDATA[*/
        $(function() {
            App.init();
            DemoSettings.init({ urlThemes: 'http://<?php echo $dados['host'];?>/core/View/assets/css/themes/social.theme-'});
            SideBar.init({shortenOnClickOutside: false});
            $.uiPro({
                rightMenu : '.rightPanel',
                threshold : 15
            });
        });
    /*]]>*/
</script>
 
 

 

</body>
</html>
