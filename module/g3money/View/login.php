<!DOCTYPE html>
 
<html>
<head>
<meta charset="utf-8">
	<title>
		Escritorio Virtual
	</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/twitter-bootstrap/bootstrap.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/social.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/font-awesome.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/twitter-bootstrap/bootstrap-responsive.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/themes/login.css" rel="stylesheet" id="theme">
<style type="text/css">body{padding-top:40px;padding-bottom:40px;background-color:#404040;}</style>
<style>
body{background:hsla(0, 0%, 0%, 0.83)}
.wraper #main{margin-top:40px;}
</style>
 
 
<!--[if lt IE 9]>
    <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/html5shiv.js"></script>
    <![endif]-->

</head>
<body>
 
<div class="container">
 
<form class="form-login" method="post" action="../Backoffice/login" style="background:#000000; color:#FFF">
	<h2 class="form-heading">
	<img src="http://<?php echo $dados['host'];?>/module/<?php echo $dados['cliente']['usuario']?>/View/img/logo.png" class="img-rounded" width="200">
	</h2>
	<h2 class="form-heading">
        <img src="http://<?php echo $dados['host'];?>/core/lib/valida.php" alt="código captcha" />
	</h2>

<input type="text" name="captcha" autofocus id="captcha" class="input-block-level" placeholder="Digite o Código Acima">
<input type="text" name="usuario" class="input-block-level" placeholder="Nome de Usuário">
<input type="password" name="password" class="input-block-level" placeholder="Senha">
<div class="row-fluid">
<!-- <label class="checkbox span6">
<input type="checkbox" value="remember-me"> Lembre-me
</label> -->
<button class="btn pull-right span6" type="submit">Logar</button>
</div>
<div class="forget-password">
<p class="text-center" style="color:#FFF">Esqueceu sua senha? <a href="#" id="link-forgot" style="color:#F00">Clique Aqui!</a></p>
</div>
<div class="row-fluid">
<button name="cadastrar" id="cadastrar" style="background:#76C7F0; color:#000" class="btn pull-right span12" type="button">Cadastrar-me</button>
</div>
</form>
 

<form class="form-forgot hide" method="get" action="">
<h2 class="form-heading">Esqueceu sua Senha</h2>
<p>Digite seu endereço de e-mail para redefinir sua senha</p>
<div id="msg_esqueceu"></div>
<div class="input-prepend input-fullwidth">
<span class="add-on"><i class="icon-envelope-alt"></i></span>
<div class="input-wrapper">
<input type="text" name="esqueceu_email" id="esqueceu_email" placeholder="Email"/>
</div>
</div>
<div class="input-prepend input-fullwidth">
<span class="add-on"><i class="icon-user"></i></span>
<div class="input-wrapper">
<input type="text" name="usu_usuario" id="usu_usuario" placeholder="Nome de Usuário"/>
</div>
</div>

<div class="form-actions">
<button class="btn btn-primary btn-back" type="button"><i class="icon-angle-left"></i> Voltar</button>
<button class="btn btn-success pull-right" name="esqueceu" id="esqueceu" type="button">Enviar</button>
</div>
</form>
 
 
<div class="form-footer-copyright" style="background:#000; color:#FFF">2015 © <small>G3Money</small></div>
 
</div>
 

 
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery/jquery.min.js"><\/script>')</script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/jquery.maskedinput.min.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/login.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/login_mmn.js"></script>
<script>
        $(function() {
            Login.init()
        });
		
		$("#cadastrar").click(function(){
			document.location = "http://escritorio.g3money.com.br/Usuario/cadastrar/usuario/g3money";
		});
    </script>
</body>
</html>