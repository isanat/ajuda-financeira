
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>G3Money | Ajuda Mútua Financeira</title>
<meta name="keywords" content="ajudamutua, ajuda mutua, ajuda mutua oficial, sistema de ajuda mutua, rede de amigos, sistema de doacoes, doacao entre amigos">
<meta name="description" content="Ajude 1 pessoas para começar a participar, convide seus parentes, amigos ou conhecidos, e receba milhares de doações!!!">
<meta name="robots" content="index,follow">
<meta name="Language" content="Portuguese">
<meta name="Googlebot" content="all">
<meta name="revisit" content="1 days">
<meta name="author" content="Marcelo Silva Rodrigues - (11) 98182-0513">
<meta name="copyright" content="G3Money - Sistema de distribuição de doações espontâneas por usuários em rede de relacionamento!">
<meta name="identifier-url" content="http://g3money.com.br/">
<meta name="content-language" content="portuguese">
<meta name="robots" content="all">
<meta name="language" content="pt-br">

    <!-- Bootstrap core CSS -->

    <link href="http://<?php echo $dados['host'];?>/core/View/css/bootstrap.min.css" rel="stylesheet">

    <link href="http://<?php echo $dados['host'];?>/core/View/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://<?php echo $dados['host'];?>/core/View/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="http://<?php echo $dados['host'];?>/core/View/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://<?php echo $dados['host'];?>/core/View/css/maps/jquery-jvectormap-2.0.1.css" />
    <link href="http://<?php echo $dados['host'];?>/core/View/css/icheck/flat/green.css" rel="stylesheet" />
    <link href="http://<?php echo $dados['host'];?>/core/View/css/floatexamples.css" rel="stylesheet" type="text/css" />

    <script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.min.js"></script>
    <script src="http://<?php echo $dados['host'];?>/core/View/js/nprogress.js"></script>
    <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-69121008-1', 'auto');
	  ga('send', 'pageview');
    </script>
	
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="">
                     <!-- menu prile quick info -->
                    <div class="profile">
					<?php if($_SESSION['usuario']['fk_status'] == 1 && $_SESSION['usuario']['fk_status'] == 3){ 
					$link = "#";
					}else{
					$link = "../Backoffice/home_msr";						
					}

					?>
                      <a href="<?php echo $link; ?>">
                       <img style="padding: 10px 0 0px 10px" src="http://<?php echo $dados['host'];?>/module/<?php echo $dados['cliente']['usuario']?>/View/img/logo.png" class="img-rounded" width="150">
                      </a>
                    </div>                    
                    <!-- /menu prile quick info -->
                    <br />
                    <h5 style="text-align: center; color: #FFF"> Olá <?php echo $_SESSION['usuario']['usu_usuario'];?></h5>
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3></h3>
							<?php if($_SESSION['usuario']['fk_status'] != 3){?>
                            <ul class="nav side-menu">
                                <li><a href="../Backoffice/home_msr"><i class="fa fa-home"></i> Home</a></li>
                                <li><a><i class="fa fa-edit"></i> Meus Dados <span class="fa fa-chevron-down"></span></a>						
                                    <ul class="nav child_menu" style="display: none">
										<li><a href="../MeusDados/dadospessoais">Dados Pessoais</a></li>
										<li><a href="../MeusDados/dadosbancarios">Dados Bancários</a></li>
										<li><a href="../MeusDados/alterarsenha">Alterar Senha de Login</a></li>
                                    </ul>
                                </li>
                                 <li><a href="../Doacoes/recebimentos"><i class="fa fa-money"></i> Meios de Recebimento</a></li>
                                 <li><a href="../Doacoes/realizar"><i class="fa fa-money"></i> Doacões Realizar</a></li>
                                 <li><a href="../Doacoes/recebidas"><i class="fa fa-money"></i> Doacões Recebidas</a></li>
                                 <li><a href="../Doacoes/realizadas"><i class="fa fa-money"></i> Doacões Realizadas</a></li>
                                 <li><a href="../Indicados/indicacoes"><i class="fa fa-user"></i> Meus Indicados</a></li>
                                 
<?php 
	if($_SESSION['usuario']['fk_status'] == 2){
?> 
                                 
                                 <li><a href="../Cadastro/cad_usu"><i class="fa fa-thumbs-up"></i> Cadastro</a></li>
                                 
  <?php } ?>                               
                                 
                                 <li><a><i class="fa fa-sitemap"></i> Rede  <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="../Rede/matriz">Rede 3x3</a></li>
                                    </ul>
                                </li>
                                <li><a href="../Backoffice/sair"><i class="fa fa-power-off"></i> Sair</a></li>
                            </ul>
							<?php } ?>
							
                        </div>
                       

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="../Backoffice/sair" aria-expanded="false">
                                    <span class="fa fa-power-off"></span> SAIR 
                                </a>                                
                            </li>
<?php
 
if($_SESSION['usuario']['fk_status'] != 1){ 

	$usu_master = $_SESSION['usuario']['usu_master'];
	$doc = $_SESSION['usuario']['master'];
	if(empty($doc)){	
	
?>
<li class="">
	<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	   Visualizar Contas
		<span class=" fa fa-angle-down"></span>
	</a>
	
	<ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
	<?php foreach($dados['model']['novasContas'] as $novasContas){ ?>
		<li class="docs" id="<?php echo $novasContas['usu_doc']; ?>">
          <a href="#"><?php echo $novasContas['usu_usuario']; ?></a>
        </li>
	<?php  } ?> 				
	</ul>
</li>
<?php }else{ ?> 

<li class="">
	<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	   Conta Master
		<span class=" fa fa-angle-down"></span>
	</a>
	<ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
	    <li class="docs" id="<?php echo $doc; ?>">
          <a href="#"><?php echo $usu_master; ?></a>
        </li>				
	</ul>
</li>
<?php  
    }
 }
?> 

<script src="http://<?php echo $dados['host'];?>/core/View/js/reentradaView.js"></script>						
							
                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->
			

           
            <div class="right_col" role="main">

                 <?php include_once($dados['caminho'] . $dados['metodo'] . '.php'); ?>
			
                <!-- footer content -->
                <footer>
                    <div class="">
                        <p class="pull-right">Onde há uma empresa de sucesso, alguém tomou uma decisão valente. | <span class="lead"> G3Money</span>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
            <!-- /page content -->
        </div>
    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

<script src="http://<?php echo $dados['host'];?>/core/View/js/bootstrap.min.js"></script>

<!-- gauge js -->
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/gauge/gauge.min.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/gauge/gauge_demo.js"></script>
<!-- chart js -->
<script src="http://<?php echo $dados['host'];?>/core/View/js/chartjs/chart.min.js"></script>
<!-- bootstrap progress js -->
<script src="http://<?php echo $dados['host'];?>/core/View/js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/nicescroll/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="http://<?php echo $dados['host'];?>/core/View/js/icheck/icheck.min.js"></script>
<!-- daterangepicker -->
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/moment.min.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/datepicker/daterangepicker.js"></script>

<script src="http://<?php echo $dados['host'];?>/core/View/js/custom.js"></script>

<!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/flot/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/flot/jquery.flot.time.min.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/flot/date.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/flot/jquery.flot.spline.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/flot/jquery.flot.stack.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/flot/curvedLines.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/flot/jquery.flot.resize.js"></script>

<!-- worldmap -->
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/maps/jquery-jvectormap-2.0.1.min.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/maps/gdp-data.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/maps/jquery-jvectormap-world-mill-en.js"></script>
<script type="text/javascript" src="http://<?php echo $dados['host'];?>/core/View/js/maps/jquery-jvectormap-us-aea-en.js"></script>

<script src="http://<?php echo $dados['host'];?>/core/View/js/skycons/skycons.js"></script>
	
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.maskMoney.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.mask.js"></script>
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
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/lib/rede/css/custom1.css"/>
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


<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.pulsate/jquery.pulsate.min.js"></script>

<script>
$(document).ready(function() {
		
  $(".confer").pulsate({
			  pause: 1000,
			  color: "rgba(52, 152, 219, 0.45)"
  }); 	
   
});
</script>



<?php if($dados['classe'] == 'home_msr'){?>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.countdown.js" type="text/javascript"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.pulsate/jquery.pulsate.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/ui-elements.general.js"></script>	



<script>
$(document).ready(function() {
	$(".publicidade").pulsate({
			  pause: 1000,
			  color: "#F2F5F7"
			}); 

   $(".participar").pulsate({
			  pause: 1000,
			  color: "#468847"
			}); 
			
  $(".confer").pulsate({
			  pause: 1000,
			  color: "rgba(52, 152, 219, 0.45)"
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

	<?php }?>

	
	
</body>

</html>
