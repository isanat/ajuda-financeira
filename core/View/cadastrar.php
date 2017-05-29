<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>
Cadastro G3Money
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
$dominio = "<strong>http://g3money.com.br</strong>";
?>


<div class="row-fluid">
        <div class="span12" style="background:#000; color:#FFF">
            <h3 class="page-title" style="margin-left:15px; color:#FFF">
          <img src="http://<?php echo $dados['host'];?>/module/<?php echo $dados['cliente']['usuario']?>/View/img/logo.png" class="img-rounded" width="100">
            Cadastre-se, se ative e já comece a convidar seus parentes, amigos e conhecidos!
            </h3>
            
            <!-- BEGIN BREADCRUMBS -->
		<ul style="background:#000;list-style:none">
		    <li>
		        <i class="icon-user"></i>
		        <a style="color:#FFF;" href="#">Você está sendo indicado por <strong><?php echo strtoupper($dados['param']['usuario']);?></strong> </a>                            
		</ul>
<!-- END BREADCRUMBS -->
        </div>
    </div>



<?php 
//echo "<pre>"; print_r($dados['model']['mail']); die;
$dominio = "<strong>http://g3money.com.br</strong>";
if($dados['model']['retorno'] == "sim"){
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
                    <h4 class="text-center" style="color:#FFF">CADASTRO REALIZADO COM SUCESSO!</h4>
                    <p style="color:#000; text-align:center">Seu cadastro foi efetuado com sucesso, favor confirmar no e-mail: <strong> <?php echo $_POST['email']; ?></strong> desejamos boa sorte!</p>
                    
                    <p style="color:#000; text-align:center">
                    Por favor verifique se chegou o e-mail em sua caixa de <strong>SPAN ou LIXO ELETRÔNICO</strong>.                    
                    <p>
                    <a href="../../../Usuario/cadastrar/usuario/<?php echo $dados['param']['usuario'];?>" class="btn btn-info">Cadastrar novamente</a>
                    <a href="http://g3money.com.br/<?php echo $dados['param']['usuario'];?>" class="btn btn-success">Voltar so Site</a>
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
     <a href="../../../Usuario/cadastrar/usuario/<?php echo $dados['param']['usuario'];?>" class="btn btn-info">Cadastrar novamente</a>
     <a target="_blank" href="http://g3money.com.br/<?php echo $dados['param']['usuario'];?>" class="btn btn-success">Voltar so Site</a>
    
</div>

<?php }?>	

<div class="body" id="validationwizard" <?php echo $style; ?>>
        <!-- BEGIN TABS CONTROLS WIZARD -->
               
        <div class="navbar form-wizard">
          <div class="navbar-inner">
            <div class="container-fluid">
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="tab" href="#tab-validation1"><i class="icon-thumbs-up"></i> Acesso</a></li>
                    <li><a data-toggle="tab" href="#tab-validation2"><i class="icon-user"></i> Pessoais</a></li>
                    <li><a data-toggle="tab" href="#tab-validation3"><i class="icon-phone"></i> Contatos</a></li>
                    <li><a data-toggle="tab" href="#tab-validation4"><i class="icon-home"></i> Endereço</a></li>
                    <li><a data-toggle="tab" href="#tab-validation5"><i class="icon-check"></i> Contrato</a></li>
                </ul>
         </div>
          </div>
        </div>
        
        
        <!-- END TABS CONTROLS WIZARD -->
        <!-- BEGIN PROGRESS BAR -->
        <div class="progress active" id="bar2">
          <div class="bar bar-success" style="width: 25%;"></div>
        </div>
        <!-- END PROGRESS BAR -->
        <!-- BEGIN FORM WIZARD  -->
        <div id="msg"></div>
        <form class="form-horizontal" id="form-validation" action="" method="POST" novalidate>
            <div class="tab-content offset2">
                <!-- BEGIN TAB1 CONTAINER -->
                <div id="tab-validation1" class="tab-pane active">
                    <h3>Acesso ao Sistema</h3>
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label">Nome de Usuário</label>
              <div class="controls">
Ex: <?php echo $dominio;?>/<input type="text" required class="input-medium usuario" placeholder="Nome de Usuário" value="" name="usuario" id="usuario">
<p class="help-block">Ex: <?php echo $dominio;?>/<strong style="color:red">usuário</strong></p>

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
                      <label class="control-label">Senha</label>
                      <div class="controls">
                        <input type="password" class="input-xlarge" required placeholder="Informe sua Senha" name="password" id="password">
                        <p class="help-block"></p>
                      </div>
                    </div>
                    
                    <div class="control-group">
                      <label class="control-label">Confirmar Senha</label>
                      <div class="controls">
                        <input type="password" class="input-xlarge" required placeholder="Repita sua Senha" name="re_password"  id="re_password">
                        <p class="help-block"></p>
                      </div>
                    </div>

                </div>
                <!-- END TAB1 CONTAINER -->
                <!-- BEGIN TAB2 CONTAINER -->
                <div id="tab-validation2" class="tab-pane">
                    <h3>Informe seu dados Pessoais</h3>

                    <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label">Nome</label>
                      <div class="controls">
                        <input type="text" class="input-xlarge" placeholder="Seu Nome"  required="" name="fullname" id="fullname">
                        <p class="help-block"></p>
                      </div>
                    </div>
                    
                    <div class="control-group">
                      <label class="control-label">CPF</label>
                      <div class="controls">
                        <input type="text" class="input-xlarge" required placeholder="Seu CPF" name="cpf" id="cpf">
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
                </div>
                <!-- END TAB2 CONTAINER -->
                
                
                 <!-- BEGIN TAB3 CONTAINER -->
                <div id="tab-validation3" class="tab-pane">

                    <h3>Telefones</h3>                      
					    <div class="control-group">
					      <label for="fone_fixo" class="control-label">Fixo</label>
					      <div class="controls">
					        <input type="text" class="input-xlarge" placeholder="(99) 9999-9999" name="fixo" id="fixo">
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
					    <div class="control-group">
					      <label for="fone_comercial" class="control-label">Comercial</label>
					      <div class="controls">
					        <input type="text" class="input-xlarge" placeholder="(99) 9999-9999" name="comercial" id="comercial">
					      </div>
					    </div>					
                </div>
                <!-- END TAB3 CONTAINER -->
                
                
                <!-- BEGIN TAB3 CONTAINER -->
                <div id="tab-validation4" class="tab-pane">

                    <h3>Seu Endereço</h3>
                      <div class="control-group">
					      <label for="end_cep" class="control-label">CEP</label>
					      <div class="controls">
					        <input type="text" required class="input-small required" placeholder="CEP" value="" name="cep" id="cep">
					        <img src="http://<?php echo $dados['host'];?>/core/View/img/load.gif" class="carregar" style="display:none" />
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_end" class="control-label">Endereço</label>
					      <div class="controls">
					        <input type="text" required class="input-xlarge required" placeholder="Endereço" value="" name="endereco" id="endereco">
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_n" class="control-label">Número</label>
					      <div class="controls">
					        <input type="text" required class="input-small required" placeholder="Número" value="" name="numero" id="numero">
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_comp" class="control-label">Complemento</label>
					      <div class="controls">
					        <input type="text" class="input-small" placeholder="Complemento" value="" name="end_comp" id="end_comp">
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_bairro" class="control-label">Bairro</label>
					      <div class="controls">
					        <input type="text" required class="input-xlarge required" placeholder="Bairro" value="" name="bairro" id="bairro">
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_cidade" class="control-label">Cidade</label>
					      <div class="controls">
					        <input type="text" required class="input-xlarge required" placeholder="Cidade" value="" name="cidade" id="cidade">
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_uf" class="control-label">UF</label>
					      <div class="controls">
					        <input type="text" required class="input-small required" placeholder="UF" maxlength="2" value="" name="uf" id="uf">
					      </div>
					    </div>	
					    
                </div>
                <!-- END TAB3 CONTAINER -->
                <!-- BEGIN TAB4 CONTAINER -->
                <div id="tab-validation5" class="tab-pane">
                    <h1 id="container">Termos de Uso, Código de Ética e Conduta.                    </h1>
                    <h3>&nbsp;</h3>

						<div class="control-group">
					      <div class="controls" style="margin:0 auto">
 <textarea readonly disabled="disabled" id="textarea1" rows="10" cols="150" style="width:800px; text-align:left">
1- Não existe nenhum tipo de investimento. O membro DOADOR faz as suas DOAÇÕES de livre e espontânea vontade, sem coação ou influência de quem quer que seja, gratuitamente e sem condições ou encargos de qualquer natureza.

2- Não existe nenhuma garantia de retorno financeiro, tudo depende do trabalho e dedicação de cada participante.

3- Para participar do Ajuda Mutua, o DOADOR deve ser maior de 18 anos.

4- Ao se cadastrar no sistema, preencha seus dados bancários no "escritório virtual" para poder receber as doações.

5- Após realizar a doação e fazer os procedimentos de confirmação através do seu escritório virtual, entre em contato com o Destinatário e informe sobre a doação, solicitando a confirmação de recebimento e a liberação imediata do seu cadastro (ativação).

6- As DOAÇÕES são realizadas diretamente nas contas bancárias de cada participante de livre e espontânea vontade, sem intermediações!

7- O usuário terá um prazo de ativação de 48 horas: Se você concorda com os termos, faça seu cadastro no sistema e siga as instruções do mesmo. Caso não concorde com os termos, interrompa seu cadastro e deixe a página.

8- O sistema não controla as doações nem gerencia nenhum tipo de quantia em espécie. As transferências são feitas entre as próprias pessoas (doadores) que se utilizam do sistema como ferramenta. O site G3Money, não tem qualquer responsabilidade ou controle pelo dinheiro das doações. Cada doador cadastrado fará as liberações dos membros da sua rede após a confirmação dos pagamentos na sua conta bancária.

9- Na eventualidade de qualquer problema técnico ou judicial, dentre outros, o site poderá manter-se no direito de pausar os cadastros sem aviso prévio, durante um prazo determinado para as devidas modificações.

10- Não servimos como uma ferramenta de gerenciamento financeiro e não temos responsabilidade pelos dados cadastrados pelos usuários.

10.1- Sem prejuízo do supra disposto, o Usuário assume o compromisso de utilizar o Serviço sempre em conformidade com a lei, moral, bons costumes e a ordem pública.

10.2- Cada participante obriga-se, a fazer uso do Serviço de forma diligente e prudente, abstendo-se de utilizá-lo como meio para a prática de atos ilícitos ou em desacordo com estes Termos, ou que sejam lesivos aos direitos e interesses de terceiros, ou de qualquer forma, possam danificar ou sobrecarregar o Serviço dos Usuários ou de outros internautas.

10.3- O Usuário reconhece ser o único responsável pelo uso do serviço,sem quaisquer outras garantias, de acordo com os limites legalmente permitidos.

10.4- O Usuário declara, reconhece e concorda que a base de pesquisa utilizada na prestação dos serviços é a internet, dessa maneira, considerando que o sistema não possui qualquer controle sobre esta, a G3Money não oferece garantias de obtenção de resultados, quanto da prestação dos serviços. Na hipótese de apresentação, em relação a tais informações, a Ajuda Mutua não oferece garantias, incluindo, sem se limitar, que estas são (i) corretas; (ii) verdadeiras; (iii) adequadas a qualquer finalidade específica; e (iv) a respeito da identidade do autor, fonte ou origem. A G3Money não assume ou assumirá qualquer responsabilidade em relação ao conteúdo das informações obtidas pelo Usuário em decorrência da utilização dos serviços, bem como por danos causados por tal conteúdo.

10.5- O Usuário obriga-se a: (a) não utilizar o Serviço com a finalidade de transmitir/divulgar material ilegal, difamatório, violador da privacidade, (b) não praticar quaisquer atos que violem ou induzam a violação a leis ou regulamentos municipais, estaduais, federais ou internacionais; (c) não transmitir/divulgar informações que sejam falsas, ambíguas, inexatas, exageradas ou extemporâneas, de forma que possam induzir a erro sobre o seu objeto ou sobre as intenções ou propósitos do comunicador; e (d) não utilizar o Serviço para divulgação de produtos ou de serviços, respeitando sempre a natureza não-comercial do Serviço.

11- EXCLUSÃO DE GARANTIAS E DE RESPONSABILIDADE

11.1- Garantimos a total credibilidade do Projeto G3Money para todos que vierem participar. Nós associados certificamos que trata-se, de “doações” em dinheiro entre pessoas idôneas e honestas, é tudo feito em conformidade com a lei, e a veracidade das informações contidas; consideram legítimas, seguras e legal para todos os fins. Fica exposto nessa proposta que é um sistema de DOAÇÕES mútua e voluntária, QUE É TOTALMENTE LÍCITO: 

(Art. 538- [Considera-se doação o contrato em que uma pessoa, por liberalidade, transfere do seu patrimônio bens ou vantagens para o de outra] c/c Art. 541- [A doação far-se-á por escritura pública ou instrumento particular.] Como pode constatar ambos do Código Civil brasileiro)

Fica aqui então firmado, entre todos que aceitam este instrumento particular que não há obtenção para si ou para outrem, de vantagem ilícita, em prejuízo alheio, induzindo alguém em erro, mediante meio fraudulento.
Veja o trecho da lei referente à sua declaração de impostos no caso de doações: Cada participante cabe a responsabilidade de procurar um contador depois de receber mais de R$1.710,00, para averiguar a questão dos impostos.

"Art. 25. As pessoas físicas e jurídicas beneficiadas com o recebimento de contribuições, doações, prêmios e bolsas, na conformidade da Lei nº 3.692, de 15 de dezembro de 1959, ficam obrigadas a provar as autoridades fiscais do imposto de renda, quando exigido, a efetiva aplicação dos recursos nos fins a que se destinaram."
                                
                                </textarea>
					      </div>
					    </div>				
	 
                </div>
                <!-- END TAB4 CONTAINER -->
            </div>
            <!-- BEGIN FORM BUTTONS ACTION CONTROLS -->
            <div class="form-actions" id="action-container">
                <div class="offset2">
                    <button name="previous" class="btn button-previous disabled" type="button"><i class="icon-angle-left"></i> Voltar</button>
                    <button name="next" class="btn button-next" type="button">Continuar <i class="icon-angle-right"></i></button>
                    <input type="hidden" name="acao" value="cadastrar" />
                    <button name="finish" class="btn button-finish"  onclick="return bottomReached('textarea1')" style="display: none;">Cadastrar <i class="icon-ok"></i></button>
                </div>
            </div>
            <!-- END FORM BUTTONS ACTION CONTROLS -->
        </form>
        <!-- END FORM WIZARD  -->      
    </div>
<?php } ?>

        
        <!-- BEGIN JAVASCRIPT CODES -->
        <!-- BEGIN GENERAL JAVASCRIPT CODE -->
        
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
    <script src="http://<?php echo $dados['host'];?>/core/View/js/cadastrar.js"></script>
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
