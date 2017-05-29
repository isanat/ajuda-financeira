<?php //echo md5('adm123'); ?>
<!DOCTYPE html>
 
<html>
<head>
<meta charset="utf-8">
<title>
MMN - 3M1R
</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">


<link rel="shortcut icon" href="http://<?php echo $dados['host'];?>/core/View/assets/img/favicon.ico"/>
<link rel="icon" type="image/gif" href="http://<?php echo $dados['host'];?>/core/View/assets/img/favicon.gif">
 
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/twitter-bootstrap/bootstrap.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/social.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/font-awesome.css" rel="stylesheet">
<link href="http://<?php echo $dados['host'];?>/core/View/assets/css/twitter-bootstrap/bootstrap-responsive.css" rel="stylesheet">
<style type="text/css">body{padding-top:40px;padding-bottom:40px;background-color:#e9eaed;}</style>
<style>.wraper #main{margin-top:40px;}</style>
 
 
<!--[if lt IE 9]>
    <script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/html5shiv.js"></script>
    <![endif]-->

</head>
<body>
 
<div class="container">
 
<form class="form-login" method="post" action="../Adm/login_adm">
	<h2 class="form-heading">
	<img src="http://<?php echo $dados['host'];?>/module/<?php echo $dados['cliente']['usuario']?>/View/img/logo.png" class="img-rounded" width="200">
	</h2>
	<h2 class="form-heading">
      ADMINISTRAÇÃO <br /><br />
      </h2>
<input type="text" name="email" class="input-block-level" placeholder="Usuário">
<input type="password" name="password" class="input-block-level" placeholder="Senha">
<div class="row-fluid">
<!-- <label class="checkbox span6">
<input type="checkbox" value="remember-me"> Lembre-me
</label> -->
<button class="btn btn-primary pull-right span6" type="submit">Logar</button>
</div>

</form>
 
 
<form class="form-register hide" method="get" action="">
<h2 class="form-heading">Cadastro</h2>
<div class="alert alert-info hide">
Enviamos um <strong>link de ativação</strong> para seu email
</div>
<div id="register-container">
<p class="text-center">Quem é você?</p>
<div class="input-prepend input-fullwidth">
<span class="add-on"><i class="icon-user"></i></span>
<div class="input-wrapper">
<input type="text" placeholder="Username"/>
</div>
</div>
<div class="input-prepend input-fullwidth">
<span class="add-on"><i class="icon-envelope-alt"></i></span>
<div class="input-wrapper">
<input type="text" placeholder="Email"/>
</div>
</div>
<div class="input-prepend input-fullwidth">
<span class="add-on"><i class="icon-lock"></i></span>
<div class="input-wrapper">
<input type="text" placeholder="Password"/>
</div>
</div>
<div class="input-prepend input-fullwidth">
<span class="add-on"><i class="icon-ok-sign"></i></span>
<div class="input-wrapper">
<input type="text" placeholder="Repeat Password"/>
</div>
</div>
</div>
<div class="form-actions">
<button class="btn btn-primary btn-back" type="button"><i class="icon-angle-left"></i> Back</button>
<button class="btn btn-success pull-right" type="button" id="btn-register-user">Cadastrar</button>
</div>
</form>
 
 
<form class="form-forgot hide" method="get" action="demo/dashboard.html">
<h2 class="form-heading">Esqueceu sua Senha</h2>
<p>Digite seu endereço de e-mail para redefinir sua senha</p>
<div class="input-prepend input-fullwidth">
<span class="add-on"><i class="icon-envelope-alt"></i></span>
<div class="input-wrapper">
<input type="text" placeholder="Email"/>
</div>
</div>
<div class="form-actions">
<button class="btn btn-primary btn-back" type="button"><i class="icon-angle-left"></i> Back</button>
<button class="btn btn-success pull-right" type="button">Enviar</button>
</div>
</form>
 
<br />
<div class="form-footer-copyright">
<small>2015 © 3M1R</small>
</div>
 
</div>
 

 
 
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