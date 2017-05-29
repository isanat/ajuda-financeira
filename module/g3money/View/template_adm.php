<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>3M1R - <?php echo strtoupper($dados['cliente']['usuario'])?></title>
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
<link href="http://<?php echo $dados['host'];?>/core/View/assets/plugins/datatables/media/DT_bootstrap.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.ui.bootstrap/assets/css/docs.css" rel="stylesheet">
<?php if($dados['metodo'] == 'adm_baixaboleto'){?>
    <link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.dropzone/css/dropzone.css">
<?php } ?>
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
 				
 				
 				
				<div class="navigation-sidebar">
					<i class="switch-sidebar-icon icon-align-justify"></i>
				</div> 
                <div class="search-sidebar">
                    <!-- img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/search.png" alt="Search">
	                <form class="search-sidebar-form">
        	            <input type="text" class="search-query input-block-level" placeholder="Search">
    	            </form -->
				</div> 
				<section class="menu">
 					<div class="accordion" id="accordion2">
						<div class="accordion-group <?php if($dados['metodo'] == 'home'){ echo 'active'; }?> ">
							<div class="accordion-heading">
                                <a class="accordion-toggle <?php if($dados['metodo'] == 'home'){ echo 'opened'; }?>" href="http://<?php echo $dados['host'];?>/Adm/home_adm">
                                    <img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/home.png" alt="Home">
                                    <span>Home </span>
                                </a>
							</div>
						</div>
						<div class="accordion-group <?php if($dados['classe'] == 'Pedido'){ echo 'active';}?>" >
 							<div class="accordion-heading">
                                <a class="accordion-toggle <?php if($dados['classe'] == 'Pedido'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#pedido">
                                    <img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/keynote.png" alt="Relatórios">
                                    <span>Pedidos </span><span class="arrow"></span>
                                </a>
							</div>
                             <ul id="pedido" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'Pedido'){ echo 'in';}?>">
                        <!--<li <?php if($dados['metodo'] == 'listar_c'){ echo 'class="active"';}?> ><a href="http://<?php echo $dados['host'];?>/Pedido/adm_listar_c">Cadastros</a></li>-->
                        <li <?php if($dados['metodo'] == 'listar_p'){ echo 'class="active"';}?> ><a href="http://<?php echo $dados['host'];?>/Pedido/adm_listar_p">Entregar</a></li>

                        
                            </ul> 
						</div> 
                         
 						<!--<div class="accordion-group <?php if($dados['classe'] == 'Usuario'){ echo 'active';}?>" >
 							<div class="accordion-heading">
                                <a class="accordion-toggle <?php if($dados['classe'] == 'Usuario'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#usuario">
                                    <img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/group.png" alt="Relatórios">
                                    <span>Usuário </span><span class="arrow"></span>
                                </a>
							</div>
<ul id="usuario" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'Usuario'){ echo 'in';}?>">
<li <?php if($dados['metodo'] == 'top_vendas'){ echo 'class="active"';}?> ><a href="http://<?php echo $dados['host'];?>/Usuario/top_vendas">Top Vendedores</a></li>
<li <?php if($dados['metodo'] == 'top_recrutamento'){ echo 'class="active"';}?> ><a href="http://<?php echo $dados['host'];?>/Usuario/top_recrutamento">Top Recrutadores</a></li>
<li <?php if($dados['metodo'] == 'adm_listar_u'){ echo 'class="active"';}?>><a href="http://<?php echo $dados['host'];?>/Usuario/adm_listar_u">Listar</a></li>
</ul>
 
						</div>-->
                        
<!-- Relatoriso -->
<div class="accordion-group <?php if($dados['classe'] == 'Relatorios'){ echo 'active';}?>" >
 <div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'Relatorios'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#relatorios">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/statistics.png" alt="Relatórios">
  <span>Relatórios </span><span class="arrow"></span>
</a>
</div>
<ul id="relatorios" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'Relatorios'){ echo 'in';}?>">
<!--<li <?php if($dados['metodo'] == 'entrada') { echo 'class="active"';}?>>
     <a href="http://<?php echo $dados['host'];?>/Relatorios/entrada">Entrada</a>
</li>-->
<li <?php if($dados['metodo'] == 'saida') { echo 'class="active"';}?>>
     <a href="http://<?php echo $dados['host'];?>/Relatorios/saida">Saída</a>
</li>
</ul> 
</div>
<!-- Fim Relatorios -->




<!-- Estoque -->
<div class="accordion-group <?php if($dados['classe'] == 'Estoque'){ echo 'active';}?>" >
 <div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'Estoque'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#estoque">
<img src="http://<?php echo $dados['host'];?>/module/cd/View/img/estoque.png" alt="Estoque">
  <span>Estoque</span><span class="arrow"></span>
</a>
</div>
<ul id="estoque" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'Estoque'){ echo 'in';}?>">
<li <?php if($dados['metodo'] == 'listar_estoque') { echo 'class="active"';}?>>
     <a href="http://<?php echo $dados['host'];?>/Estoque/listar_estoque">Listar Estoque</a>
</li>
</ul> 
</div>
<!-- Fim Estoque -->

<!-- SENHA -->
<div class="accordion-group <?php if($dados['classe'] == 'Senha'){ echo 'active';}?>" >
 <div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'Senha'){ echo 'opened';}?>" href="../Senha/alterar_senha">
<img src="http://<?php echo $dados['host'];?>/core/View/img/senha.png" alt="Estoque" />
  <span>Alterar Senha</span>
</a>
</div>
</div>
<!-- Fim SENHA -->




<!-- Produtos -->
<!--<div class="accordion-group <?php if($dados['classe'] == 'Produtos'){ echo 'active';}?>" >
 <div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'Produtos'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#produtos">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/shipping.png" alt="Produtos">
  <span>Produtos </span><span class="arrow"></span>
</a>
</div>
<ul id="produtos" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'Produtos'){ echo 'in';}?>">
<li <?php if($dados['metodo'] == 'dispachos') { echo 'class="active"';}?>>
     <a href="http://<?php echo $dados['host'];?>/Produtos/categorias">Categorias</a>
</li>
<li <?php if($dados['metodo'] == 'rel_saque') { echo 'class="active"';}?>>
     <a href="http://<?php echo $dados['host'];?>/Produtos/bonus">Bônus</a>
</li>
</ul> 
</div>-->
<!-- Fim Produtos -->

<!-- CD's -->
<!--<div class="accordion-group <?php if($dados['classe'] == 'Cd'){ echo 'active';}?>" >
 <div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'Cd'){ echo 'opened';}?>" data-toggle="collapse" data-parent="#accordion2" href="#cd">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/administrative-docs.png" alt="Produtos">
  <span>CD's </span><span class="arrow"></span>
</a>
</div>
<ul id="cd" class="accordion-body nav nav-list collapse <?php if($dados['classe'] == 'Produtos'){ echo 'in';}?>">
<li <?php if($dados['metodo'] == 'dispachos') { echo 'class="active"';}?>>
     <a href="http://<?php echo $dados['host'];?>/Cd/listar_cd">Listar</a>
</li>

</ul> 
</div>-->
<!-- Fim CD's -->

<!--<div class="accordion-group <?php if($dados['classe'] == 'Adm'){ echo 'active'; }?> ">
 
<div class="accordion-heading">
<a class="accordion-toggle <?php if($dados['classe'] == 'deb_cred'){ echo 'opened'; }?>" href="http://<?php echo $dados['host'];?>/Adm/deb_cred">
<img src="http://<?php echo $dados['host'];?>/core/View/assets/img/icons/stuttgart-icon-pack/32x32/product.png" alt="Home">
<span>Débito Forçado </span>
</a>
</div>
</div>-->

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
					<a class="brand" href="#">Menu</a>
					
					<ul class="nav pull-right nav-indicators"> 
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-caret-down"></i></a>
							<ul class="dropdown-menu">
                                
                                <li><a href="../Adm/sair"><i class="icon-off"></i> Sair</a></li>
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
                        ADM - <?php echo strtoupper($dados['cliente']['usuario'])?>
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php include_once($dados['caminho'] . $dados['metodo'] . '.php');	?>
        
        <footer id="footer">
            <div class="container-fluid">
                2015 © <em>Sistema 3M1R</em>
            </div>
        </footer> 
        
      </div>
        
    </div>
 
</div>

 
 

<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.ui.touch-punch/jquery.ui.touch-punch.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/twitter-bootstrap/bootstrap.js"></script>
<!--<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>-->
<script src="http://<?php //echo $dados['host'];?>/core/View/assets/plugins/jquery.cookie/jquery.cookie.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.uipro/uipro.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/dispachos.js"></script>

<!-- <script src="http://<?php //echo $dados['host'];?>/core/View/assets/plugins/jquery.livefilter/jquery.livefilter.js"></script> -->
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/extents.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/app.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/demo-settings.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/sidebar.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/html5shiv.js"></script>
<?php if($dados['metodo'] == 'adm_baixaboleto'){?>
    <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.dropzone/dropzone.js"></script>
<?php } ?>

<?php if($dados['metodo'] == 'historico'  || $dados['metodo'] == 'meuspedidos'){?>
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/DT_bootstrap.css"/>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.dataTables.min.js"></script>


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
