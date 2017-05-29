<?php  // echo utf8_decode("TELA DE CADASTRO EM MANUTENÇÃO VOLTAMOS AS 16:30 HORAS"); die; ?>
<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<title>
Informações de Pré-Cadastro
</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- BEGIN STYLE CODES -->    
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/twitter-bootstrap/bootstrap.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/social-jquery-ui-1.10.0.custom.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/social.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/font-awesome.css" rel="stylesheet">

<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" href="../../../core/View/assets/css/social-jquery.ui.1.10.0.ie.css"/>
<![endif]-->

<!-- BEGIN STYLE CODE FOR THE CURRENT PAGE -->
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/plugins/fuelux.css" rel="stylesheet">
<!-- END STYLE CODE FOR THE CURRENT PAGE -->


<link href="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.uipro/style.css" rel="stylesheet">

<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/themes/social.theme-blue.css" rel="stylesheet" id="theme">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/twitter-bootstrap/bootstrap-responsive.css" rel="stylesheet">


    <!-- BEGIN STYLE CODE FOR THE CURRENT PAGE -->
        <!-- END STYLE CODE FOR THE CURRENT PAGE -->

        <style>
      .wraper #main{
        margin-top: 40px;
      }
    </style>
    <!-- END STYLE CODES -->
    
<script> 
function bottomReached(objectID) { 
	var object = document.getElementById(objectID); 
	var bottomReached = false; 
	var actualLocation = object.scrollTop + object.offsetHeight; 
	var scrollHeight = object.scrollHeight; 
	if (actualLocation > scrollHeight)
	{ 
		$("#form-validation").submit(); 
	}else{
			alert('Baixe a barra de rolagem até o fim')
	}
	
	 } 
</script>

</head>
<body>

<?php  if($dados['model']['retorno'] == "nao"){ ?>
 
<div class="span12">
        <!-- BEGIN ALERTS BOX EXAMPLES -->
       <div class="social-box">
            <div class="header">
                <h4>Atenção</h4>
            </div>
            <div class="body">
                <div class="alert alert-block alert-error">
                    <h4 class="alert-heading">Erro!</h4>
                    <p>O usuário <strong><?php echo strtoupper($dados['param']['usuario']);?></strong>, não se encontra ativo em nosso sistema. Favor procure um indicante válido.</p>
                </div>

            </div>
        </div>
        <!-- END ALERTS BOX EXAMPLES -->
    </div> 
 
<?php

 }else{
$dominio = "<strong>http://getcash.com.br</strong>";
?>


<div class="row-fluid">
        <div class="span12">
            <h3 class="page-title" style="margin-left:15px; color:#0D4360">
          <img src="http://<?php echo $dados['host'];?>/module/<?php echo $dados['cliente']['usuario']?>/View/img/logo.png" class="img-rounded" width="100">
            Cadastre-se, se ative e já comece a convidar seus parentes, amigos e conhecidos!
            </h3>
            
            <!-- BEGIN BREADCRUMBS -->
		<ul class="breadcrumb">
		    <li>
		        <i class="icon-user"></i>
		        <a href="#">Você está sendo indicado por <?php echo strtoupper($dados['param']['usuario']);?> </a>                            
		</ul>
<!-- END BREADCRUMBS -->
        </div>
    </div>

<?php 
//echo "<pre>"; print_r($dados['model']['mail']); die;
$dominio = "<strong>http://getcash.com.br</strong>";
if($dados['model']['retorno'] == "ok"){
	$style = "style='display:none'";
?>
<style type="text/css">
@import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);

body {padding-top:50px;}

.box {
    border-radius: 3px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    padding: 10px 25px;
    text-align: right;
    display: block;
    margin-top: 60px;
}
.box-icon {
    background-color: #57a544;
    border-radius: 50%;
    display: table;
    height: 100px;
    margin: 0 auto;
    width: 100px;
    margin-top: -61px;
}
.box-icon span {
    color: #fff;
    display: table-cell;
    text-align: center;
    vertical-align: middle;
}
.info h4 {
    font-size: 26px;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.info > p {
    color: #717171;
    font-size: 16px;
    padding-top: 10px;
    text-align: justify;
}
.info > a {
    background-color: #03a9f4;
    border-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    color: #fff;
    transition: all 0.5s ease 0s;
}
.info > a:hover {
    background-color: #0288d1;
    box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.16), 0 2px 5px 0 rgba(0, 0, 0, 0.12);
    color: #fff;
    transition: all 0.5s ease 0s;
}
</style>

<div class="container">
  <div class="row" style="background:#91C47A">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="background:#A5CC93;">
            <div class="box">
                <div class="box-icon">
                    <span class="fa fa-4x fa-user"></span>
                </div>
                <div class="info">
                    <h4 class="text-center" style="color:#FFF">SEU PRÉ-CADASTRO FOI REALIZADO COM SUCESSO!</h4>
                    <p style="color:#000; text-align:center">Olá <strong> <?php echo $_POST['nome']; ?> </strong>, desejamos boa sorte!</p>
                    <p style="color:#000; text-align:center">
                    Por favor verifique se chegou o e-mail em sua caixa de <strong>SPAN ou LIXO ELETRÔNICO</strong>. <br>                   
                    <p>
                    <a href="../../../Usuario/precadastro/usuario/<?php echo $dados['param']['usuario'];?>" class="btn btn-info">Cadastrar novamente</a>
                    <a href="http://getcash.com.br/<?php echo $dados['param']['usuario'];?>" class="btn btn-success">Voltar so Site</a>
                </div>
            </div>
        </div>    
	</div>
</div>

<?php } if($dados['model']['retorno'] == "nao"){  $style = "style='display:none'"; ?>

<div class="alert alert-error">

    <h2>ERRO!</h2>
     Por favor tente fazer o cadastro mais tarde, no momento não temos usuários ativos para receber o seu cadastro. O volume de cadastro está mais rápido do que as pessoas conseguem concretizarem as doações. O sistema e verdadeiramente um SUCESSO!
  <p style="margin-top:20px">
     <a href="../../../Usuario/precadastro/usuario/<?php echo $dados['param']['usuario'];?>" class="btn btn-info">Cadastrar novamente</a>
     <a target="_blank" href="http://getcash.com.br/<?php echo $dados['param']['usuario'];?>" class="btn btn-success">Voltar so Site</a>
    
</div>

<?php }?>	

<div class="body" id="validationwizard" <?php echo $style; ?>>
        <!-- BEGIN TABS CONTROLS WIZARD -->
               
        <div class="navbar form-wizard">
          <div class="navbar-inner">
            <div class="container-fluid">
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="tab" href="#tab-validation1"><i class="icon-thumbs-up"></i> Acesso</a></li>
                </ul>
         </div>
          </div>
        </div>

        <div id="msg"></div>
        <form class="form-horizontal" action="" method="POST">
            <div class="tab-content offset2">
                <!-- BEGIN TAB1 CONTAINER -->
          <div id="tab-validation1" class="tab-pane active">
                    <h3>Informações de Pré-cadastro</h3>
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label">Nome Completo</label>
              <div class="controls">
				<input type="text" required class="input-medium nome" placeholder="Nome Completo" value="" name="nome">
                <p class="help-block"></p>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label">Email</label>
              <div class="controls">
                <input type="email" class="input-xlarge" required placeholder="Informe seu Email" name="email" id="email">
                <p class="help-block"></p>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label">Data de Nascimento</label>
              <div class="controls">
                <input type="text" class="input-xlarge" required placeholder="Data de Nascimento" name="datanasc" id="datanasc">
                <p class="help-block"></p>
              </div>
            </div>

             <div class="control-group">
              <label class="control-label">Sexo</label>
              <div class="controls">
                <label class="radio">
                  <input type="radio" value="m" name="gender">
                  Masculino
                </label>
                <label class="radio">
                  <input type="radio" value="f" name="gender">
                  Feminino
                </label>
              </div>
            </div> 

             <div class="control-group">
              <label for="fone_cel" class="control-label">Celular <span style="color:red">*</span></label>
              <div class="controls">
                <input type="text" required class="input-xlarge required" placeholder="(99) 99999-9999" name="cel" id="cel">
              </div>
            </div>	
            <div class="control-group">
              <label for="fone_cel" class="control-label">whatsapp</label>
              <div class="controls">
                <input type="text" class="input-xlarge" placeholder="(99) 99999-9999" name="whatsapp" id="whatsapp">
              </div>
            </div>	

          </div>

            </div>
            <!-- BEGIN FORM BUTTONS ACTION CONTROLS -->
            <div class="form-actions" id="action-container">
                <div class="offset2">
                    <input type="hidden" name="acao" value="ok" />
                    <input type="submit" class="btn btn-success" value="Cadastrar" /> 
                </div>
            </div>
            <!-- END FORM BUTTONS ACTION CONTROLS -->
        </form>
        <!-- END FORM WIZARD  -->      
    </div>
<?php } ?>

</script>
<script>window.jQuery || document.write('<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery/jquery.min.js"><\/script>')</script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.ui.touch-punch/jquery.ui.touch-punch.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/twitter-bootstrap/bootstrap.js"></script>

<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.cookie/jquery.cookie.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.simplecolorpicker/jquery.simplecolorpicker.js"></script>

<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.uipro/uipro.min.js"></script>



<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.livefilter/jquery.liveFilter.js"></script>



<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/extents.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/app.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/demo-settings.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/sidebar.js"></script>

    

    <script>
      /*<![CDATA[*/
      $(function() {
        App.init();
        DemoSettings.init({
          urlThemes: 'http://<?php echo $dados['host'];?>/core/View/assets/css/themes/social.theme-'
        });
        SideBar.init({
          shortenOnClickOutside: false
        });
      });
      /*]]>*/
    </script>
    <!-- END GENERAL JAVASCRIPT CODE -->

    <!-- BEGIN JAVASCRIPT CODES FOR THE CURRENT PAGE -->
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.validation/jquery.validate.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js"></script>
    <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/bootstrap.wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/bootstrap.fuelux/lib/require.js"></script>
    <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/bootstrap.fuelux/loader.min.js"></script>
    <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/bootstrap.fuelux/wizard.js"></script>
    <script src="http://<?php echo $dados['host'];?>/core/View/assets/js/form-stuff.wizard.js"></script>
    <script src="http://<?php echo $dados['host'];?>/core/View/js/precadastro.js"></script>
    <script>
      $(function() {
        FormWizard.init();
      });
    </script>
    <!-- END JAVASCRIPT CODES FOR THE CURRENT PAGE -->
        <!-- END JAVASCRIPT CODES -->
 

 

 
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery/jquery.min.js"><\/script>')</script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/login.js"></script>
<script>
        $(function() {
            Login.init()
        });
    </script>
</body>
</html>
