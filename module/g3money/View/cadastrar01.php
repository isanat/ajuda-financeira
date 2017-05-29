<?php //echo '<pre>'; print_r($dados['model']);die;?>
<!DOCTYPE html>
 
<html>
<head>
<meta charset="utf-8">
<title>
Cadastro - <?php echo strtoupper($dados['cliente']['usuario'])?>
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
    
    <link href="http://<?php echo $dados['host'];?>/core/View/assets/css/themes/cadastrar.css" rel="stylesheet" id="theme">
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
 

 
<?php  $dominio = str_replace('backoffice','www',$dados['host']);?>
    

    
		<div  class="row-fluid topo_cad">
        <div class="span12">
            <h3 class="page-title">

<img src="http://<?php echo $dados['host'];?>/module/<?php echo $dados['cliente']['usuario']?>/View/img/logo.png" class="img-rounded" width="150">
            </h3>
            <!-- BEGIN BREADCRUMBS -->
		<ul class="breadcrumb">
		    <li>
		        <i class="icon-user"></i>
<?php echo $dados['linguagem']['indicado']['indicado']; ?> <?php echo strtoupper($dados['param']['usuario']); //echo '<pre>'; print_r($dados);?>                           
		</ul>
<!-- END BREADCRUMBS -->
        </div>
    </div>
    
   
    

    
    
    
<!-- BANDEIRAS -->

<!-- FIM BANDEIRAS -->
    
  

<div class="body" id="validationwizard">
        <!-- BEGIN TABS CONTROLS WIZARD -->

        
<div class="navbar form-wizard">
<div class="navbar-inner">
<div class="container-fluid">
<ul class="nav nav-pills">
<li class="active"><a data-toggle="tab" href="#tab-validation1"><i class="icon-thumbs-up">
</i><?php echo $dados['linguagem']['categoria']['acesso']; ?></a></li>
<li><a data-toggle="tab" href="#tab-validation2"><i class="icon-user"></i> <?php echo $dados['linguagem']['categoria']['pessoais']; ?></a></li>
<li><a data-toggle="tab" href="#tab-validation3"><i class="icon-home"></i> <?php echo $dados['linguagem']['categoria']['endereco']; ?></a></li>
<li><a data-toggle="tab" href="#tab-validation4"><i class="icon-check"></i> <?php echo $dados['linguagem']['categoria']['contrato']; ?></a></li>
</ul>
</div>
</div>
</div>
        
        
        <!-- END TABS CONTROLS WIZARD -->
        <!-- BEGIN PROGRESS BAR -->
        <div class="progress active" id="bar2">
          <div class="bar bar-danger" style="width: 25%;"></div>
        </div>
        <!-- END PROGRESS BAR -->
        <!-- BEGIN FORM WIZARD  -->
        
        <?php if(isset($dados['model']['erro'])){?>
        <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro"><?php echo $dados['model']['erro'];?></span></div>
        <?php }
		//echo "<pre>"; print_r($dados); //die; 
		
		
		?>
        
        <div id="msg"></div>
        <form class="form-horizontal" id="form-validation" action="" method="POST" novalidate>
        <input type="hidden" name="sessao" id="sessao" value="<?php echo session_id();?>" />
            <div class="tab-content offset2">
                <!-- BEGIN TAB1 CONTAINER -->
                <div id="tab-validation1" class="tab-pane active">
                    <h3 class="acesse"><?php echo $dados['linguagem']['visita']['acceso']; ?></h3>
                    
                    <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label"><?php echo $dados['linguagem']['plano']['plano']; ?></label>
                      <div class="controls">
                        <?php
					          $plano = $dados['param']['plano'];
										  
if($plano == 1){
echo $dados['linguagem']['plano']['plano1']."<input type='hidden' name='country' id='plano' value='1' />";
						  
}else{?>
							  
							  
		                        <select class="input-xlarge" name="country" id="fk_bonus">
						          <option value=""><?php echo $dados['linguagem']['list']['escolha']; ?></option>
						          <?php foreach ($dados['model']['produtos'] as $produtos){?>
						          <option value="<?php echo $produtos['pro_cod']?>"><?php echo $produtos['pro_nome']?></option>
						          <?php }?>
						        </select>
		                        <p class="help-block"></p>
		                      
						      <?php }?>
                        <p class="help-block"></p>
                      </div>
                    </div>

                    
              
				  
				   <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label"><?php echo $dados['linguagem']['usu']['usuario']; ?></label>
                      <div class="controls">
                        
<?php echo $dados['linguagem']['site']['site']; ?><input type="text" required placeholder="<?php echo $dados['linguagem']['usu']['usuario']; ?>" value="" name="usu_usuario" id="usu_usuario" class="usuario">
                        <p class="help-block">Ex: <?php echo $dados['linguagem']['site']['site']; ?><strong style="color:red"><?php echo $dados['linguagem']['usu']['usu']; ?></strong></p>
                        <p class="help-block"></p>
                      </div>
                    </div>	
                    
                    

<div class="control-group">
<label class="control-label"><?php echo $dados['linguagem']['senha']['senha']; ?></label>
<div class="controls">
<input type="password" class="input-xlarge" required placeholder="<?php echo $dados['linguagem']['senha']['senhainfo']; ?>" name="password" id="password">
<p class="help-block"></p>
</div>
</div>

<div class="control-group">
<label class="control-label"><?php echo $dados['linguagem']['senha']['senhaconf']; ?></label>
<div class="controls">
<input type="password" class="input-xlarge" required placeholder="<?php echo $dados['linguagem']['senha']['senhaconf']; ?>" name="re_password"  id="re_password">
<p class="help-block"></p>
</div>
</div>


<div class="control-group">
<label class="control-label"><?php echo $dados['linguagem']['senha']['seguranca']; ?></label>
<div class="controls">
<input type="password" class="input-xlarge" required placeholder="<?php echo $dados['linguagem']['senha']['segurancainfo']; ?>" name="password_s" id="password_s">
<p class="help-block"></p>
</div>
</div>

<div class="control-group">
<label class="control-label"><?php echo $dados['linguagem']['senha']['confseguranca']; ?></label>
<div class="controls">
<input type="password" class="input-xlarge" required placeholder="<?php echo $dados['linguagem']['senha']['reptseguranca']; ?>" name="re_password_s"  id="re_password_s">
<p class="help-block"></p>
</div>
</div>
                    
                    	

                </div>
                <!-- END TAB1 CONTAINER -->
                <!-- BEGIN TAB2 CONTAINER -->
                <div id="tab-validation2" class="tab-pane">
                    <h3><?php echo $dados['linguagem']['dados']['info']; ?></h3>

<!-- Text input-->
<div class="control-group">
<label class="control-label"><?php echo $dados['linguagem']['dados']['nome']; ?></label>
<div class="controls">
<input type="text" class="input-xlarge" placeholder="<?php echo $dados['linguagem']['dados']['nome']; ?>"  required="" name="fullname" id="fullname">
<p class="help-block"></p>
</div>
</div>

<div class="control-group">
<label class="control-label"><?php echo $dados['linguagem']['dados']['tipo']; ?></label>
<div class="controls">
<label class="pessoa">
  <input type="radio" value="f" class="tipo_pessoa" id="pf" name="pessoa" checked="checked">
  <?php echo $dados['linguagem']['dados']['fisica']; ?>
</label>
<label class="radio">
  <input type="radio" value="j" class="tipo_pessoa" id="pj" name="pessoa">
   <?php echo $dados['linguagem']['dados']['juridica']; ?>
</label>
</div>
</div>

<div class="control-group" id="cnpj">
<label class="control-label"><?php echo $dados['linguagem']['dados']['cnpj']; ?></label>
<div class="controls">
<input type="text" class="input-xlarge" placeholder="Seu CNPJ" name="pj_cnpj" id="pj_cnpj">
<p class="help-block"></p>
</div>
</div>
            
                  <?php 
				  
				  switch($_SESSION['lang']){
				  case "ptbr":
				      echo "<div class='control-group'>
							  <label class='control-label'>CPF</label>
							  <div class='controls'>
								<input type='text' class='input-xlarge' required placeholder='Seu CPF' name='cpf' id='cpf'>
								<p class='help-block'></p>
							  </div>
                            </div>";
				   break;
				   case "es":
				   $doc = $dados['linguagem']['dados']['doc'];
				      echo "<div class='control-group'>
							  <label class='control-label'>".$dados['linguagem']['dados']['doc']."</label>
							  <div class='controls'>
								<input type='text' class='input-xlarge' required placeholder='$doc' name='cpf'>
								<p class='help-block'></p>
							  </div>
                            </div>";
				   break;
				   default:
				      echo "<div class='control-group'>
							  <label class='control-label'>CPF</label>
							  <div class='controls'>
								<input type='text' class='input-xlarge' required placeholder='Seu CPF' name='cpf' id='cpf'>
								<p class='help-block'></p>
							  </div>
                            </div>";
				  
		       } 			  
                ?>                  
                    
                    <div class="control-group">
                      <label class="control-label"><?php echo $dados['linguagem']['dados']['data']; ?></label>
                      <div class="controls">
        <input type="text" class="input-xlarge" required placeholder="<?php echo $dados['linguagem']['dados']['data']; ?>" name="datanasc" id="datanasc">
                        <p class="help-block"></p>
                      </div>
                    </div>

                    <div class="control-group">
                      <label class="control-label"><?php echo $dados['linguagem']['dados']['sexo']; ?></label>
                      <div class="controls">
                        <label class="radio">
                          <input type="radio" value="m" name="gender" checked="checked">
                          <?php echo $dados['linguagem']['dados']['mascu']; ?>
                        </label>
                        <label class="radio">
                          <input type="radio" value="f" name="gender">
                          <?php echo $dados['linguagem']['dados']['femi']; ?>
                        </label>
                      </div>
                    </div>
                    
                    <legend><?php echo $dados['linguagem']['dados']['contat']; ?></legend>
                    
                    <div class="control-group">
                      <label class="control-label"><?php echo $dados['linguagem']['dados']['email']; ?></label>
                      <div class="controls">
                        <input type="email" class="input-xlarge" required placeholder="<?php echo $dados['linguagem']['dados']['email']; ?>" name="email" id="email">
                        <p class="help-block"></p>
                      </div>
                    </div>
                    
                    <div class="control-group telefones">
                      <label class="control-label"><?php echo $dados['linguagem']['dados']['celular']; ?> *</label>
                      <div class="controls camposfone">
                        <input type="text" class="input-medium cel" required name="celular" >
                        <p class="help-block"></p>
                      </div>
                    </div>
                    
                    <div class="control-group telefones">
                      <label class="control-label"><?php echo $dados['linguagem']['dados']['residencial']; ?></label>
                      <div class="controls camposfone">
                        <input type="text" class="input-medium fones" name="residencial" >
                        <p class="help-block"></p>
                      </div>
                    </div>
                    
                    <div class="control-group telefones">
                      <label class="control-label"><?php echo $dados['linguagem']['dados']['comercial']; ?></label>
                      <div class="controls camposfone">
                        <input type="text" class="input-medium fones"  name="comercial" >
                        <p class="help-block"></p>
                      </div>
                    </div>
                    

                    
                    

                    
                </div>
                <!-- END TAB2 CONTAINER -->
                <!-- BEGIN TAB3 CONTAINER -->
                <div id="tab-validation3" class="tab-pane">

                    <h3><?php echo $dados['linguagem']['dados']['sende']; ?></h3>
                      <div class="control-group">
					      <label for="end_cep" class="control-label"><?php echo $dados['linguagem']['dados']['cep']; ?></label>
					      <div class="controls">
					        <input type="text" required class="input-small required" placeholder="<?php echo $dados['linguagem']['dados']['cep']; ?>" value="" name="cep" id="cep">
					
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_end" class="control-label"><?php echo $dados['linguagem']['dados']['end']; ?></label>
					      <div class="controls">
					        <input type="text" required class="input-xlarge required" placeholder="<?php echo $dados['linguagem']['dados']['end']; ?>" value="" name="endereco" id="endereco">
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_n" class="control-label"><?php echo $dados['linguagem']['dados']['n']; ?></label>
					      <div class="controls">
					        <input type="text" required class="input-small required" placeholder="<?php echo $dados['linguagem']['dados']['n']; ?>" value="" name="numero" id="numero">
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_comp" class="control-label"><?php echo $dados['linguagem']['dados']['comp']; ?></label>
					      <div class="controls">
					        <input type="text" class="input-small" placeholder="<?php echo $dados['linguagem']['dados']['comp']; ?>" value="" name="end_comp" id="end_comp">
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_bairro" class="control-label"><?php echo $dados['linguagem']['dados']['bairro']; ?></label>
					      <div class="controls">
					        <input type="text" required class="input-xlarge required" placeholder="<?php echo $dados['linguagem']['dados']['bairro']; ?>" value="" name="bairro" id="bairro">
					      </div>
					    </div>
					
					    <div class="control-group">
					      <label for="end_cidade" class="control-label"><?php echo $dados['linguagem']['dados']['cidade']; ?></label>
					      <div class="controls">
					        <input type="text" required class="input-xlarge required" placeholder="<?php echo $dados['linguagem']['dados']['cidade']; ?>" value="" name="cidade" id="cidade">
					      </div>
					    </div>
					
					    <div class="control-group">
<label for="end_uf" class="control-label"><?php echo $dados['linguagem']['dados']['uf']; ?></label>
<div class="controls">
<input type="text" required class="input-small required" placeholder="<?php echo $dados['linguagem']['dados']['uf']; ?>" maxlength="2" value="" name="uf" id="uf">
					      </div>
					    </div>	
					    
                </div>
                <!-- END TAB3 CONTAINER -->
                <!-- BEGIN TAB4 CONTAINER -->
                <div id="tab-validation4" class="tab-pane">
                    <h3><?php echo $dados['linguagem']['dados']['titulo_contrato']; ?></h3>
                    <h5><?php echo $dados['linguagem']['dados']['rolagem']; ?></h5>
                    
                     


						<div class="control-group">
					      <div class="controls span8">
                       
                          
<textarea readonly id="textarea1" rows="10" cols="100" class="input-block-level">
					        	Contrato de Adesão

Contrato de adesão ao Oexclusivo

O produto principal da Oexclusivo, bem como os demais produtos adicionais são divulgados pelos associados que por livre e espontânea vontade se afiliam ao Sistema. Além disso, cada associado tem direito exclusivo a treinamentos diversos, além de ferramentas para o trabalho on-line.

Cada membro receberá comissões ao cumprir o plano de compensação estabelecido pelo sistema. De forma que seus ganhos serão proporcionais ao seu desenvolvimento como divulgador/distribuidor.

1 – Cada associado precisa estar de acordo com o termos deste contrato de adesão. Pois o mesmo dispõe de todas as normas para o ingresso e permanência no sistema.

2 – Ao se cadastrar no Oexclusivo, o afiliado atesta que leu e concorda com todas as cláusulas contidas no presente termo. A confirmação do seu cadastro constitui a assinatura eletrônica de aprovação deste termo de adesão.

3 – O sistema permanecerá existente e regido por este termo, o qual constitui a base que alicerça as normas e regimes exigidos.

4- Através deste termo, todos recebem os mesmos direitos e deveres como membro.

5- A não observância das normas aqui contidas por parte de algum membro, resultará no cancelamento do cadastro de tal membro sem que haja aviso prévio.

6- Deixamos claro que o Oexclusivo não está isento de problemas quanto ao funcionamento. O mesmo pode ocorrer falhas e o site pode ficar temporariamente fora do ar. Mas qualquer problema será imediatamente solucionado. Isso não irá de forma alguma trazer prejuízos a qualquer associado. Pois seus dados bem como seus rendimentos estarão arquivados em segurança.

7 – NÃO declaramos que o associado irá receber lucros altos em curto período de tempo. Isso depende da disposição e desenvolvimento de cada um. Nossa tabela com o potencial de ganhos para afiliados expressa uma possibilidade que somente será alcançada com esforço e dedicação. Portanto, não podemos ser acusados de fazer propaganda enganosa nesse sentido.

8 – Qualquer usuário pode participar do sistema optando apenas por usufruir nossos serviços sem que tenha interesse em construir uma rede de afiliados. A decisão de ganhar dinheiro com o sistema é inteiramente pessoal. Pois o oferecimento de nossos serviços é o que constitui a base para a existência de nosso sistema. Mas, é claro, temos a intenção de que cada associado tenha uma renda crescente através de nosso sistema de pagamentos em comissões e bonificações.

9 – As comissões e bonificações são geradas a partir do lucro bruto da empresa.

1 - Exigências para inscrição

1.1 – Para associar-se, o interessado deverá ser portador de seu Cadastro de Pessoas Física (CPF) e ter idade igual ou maior que 18 anos. Caso o interessado tenha idade inferior a esta, poderá participar do sistema com a autorização e cuidado dos pais. O sistema não se responsabilizará por qualquer conseqüência advinda da não observância deste item.

1.2- Para receber suas comissões, o membro deverá possuir conta corrente ou poupança em seu próprio nome. Caso queira usar a conta bancária de outro titular, o sistema também não se responsabilizará por eventuais desentendimentos.

1.3 – Não são consideradas aqui as características físicas, morais ou sexuais de qualquer indivíduo. O Sistema é aberto para todo e qualquer ser humano criado por Deus (“Pois Deus não faz acepção de pessoas”).

2 - Responsabilidades Por Parte dos Associados

2.1 – Após o cadastro no Oexclusivo, o novo associado deverá realizar o depósito de R$10 (Salvo em períodos de adesão gratuita oferecido pela administração do Sistema) na conta especificada no momento do cadastro. O pagamento é feito mensalmente como forma de, cada associado, manter ativa a sua assinatura como assinante/afiliado, manter ativo o seu Website de afiliado, e utilizar os serviços de consumo exclusivos. Após o cadastro, cada interessado em associar-se ao sistema, terá um prazo de apenas 5 dias para efetuar o pagamento. Por exemplo, se alguém se cadastrar no dia 01/01, terá uma tolerância de 5 dias. Ou seja, o prazo para pagamento terminará no dia 5/01.

2.2 – O associado terá um mês para efetuar o pagamento das próximas mensalidades. Após o vencimento, o membro terá um prazo de 8 dias para efetuar seu pagamento.

2.3 – Havendo pendências no cadastro de algum membro, este receberá por e-mail, diversas notificações com o objetivo de estimular esse membro ao pagamento de sua mensalidade. Pois após os 8 dias de tolerância após o vencimento, o associado perderá a sua inscrição bem como seus rendimentos. Dessa forma ele terá de se cadastrar novamente, e perderá a sua posição na rede.

2.4 – A Oexclusivo tem livre arbítrio para enviar mensagens a cada associado. Declaramos que nenhuma mensagem enviada por nós será de conteúdo ofensor. Dessa forma, a confirmação do cadastro por parte do associado, alega que se dispõe a receber nossas mensagens em qualquer tempo.

2.5- A Oexclusivo tem o direito de alterar a qualquer tempo os itens contidos neste termo. Esclarecemos que, qualquer que sejam as alterações, o objetivo será a melhora e crescimento do sistema, tendo em vistas o conforto e benefícios para nossos associados.

2.6- Caso algum associado tenha sua inscrição cancelada, o mesmo perderá todos os benefícios e direitos oferecidos pelo neste cadastro.

2.7 – O sistema não determina nenhuma relação empregatícia com qualquer associado. Dessa forma, os ganhos serão proporcionais ao seu trabalho como distribuidor independente.

2.8- O texto, imagens e logotipo contidos no site são de propriedade exclusiva do sistema. Não sendo permitida a cópia e/ou utilização para outros fins, sem a devida autorização.

2.9 - O sistema tem como prioridade o respeito e a ética para com nossos associados.

2.10 – A forma de pagamento da mensalidade referente à assinatura é devidamente informada ao novo associado. O mesmo deve saber que essa forma de pagamento pode ser modificada, se assim decidir a administração da Oexclusivo. Os membros serão devidamente informados da mudança com antecedência.

2.11 - Usuários que praticarem Spam, perderão a inscrição no sistema sem aviso prévio. E ainda correrão o risco de serem processados judicialmente, dependendo da gravidade do problema causado.

2.12 - Usuários terão obrigatoriedade de se manterem ativos para ganhar os bônus residuais tanto da matrix 7 x 5 quanto do binario

3 -Vantagens dos Associados da Oexclusivo

3.1 – Cada associado ativo terá direito a receber acesso a nosso conteúdo privativo e a ferramentas para o trabalho on-line.

3.3 – O valor ganho em comissões será transferido diretamente na conta bancária de cada membro.

3.4 – Cada membro só começará a receber depósitos em sua conta, quando alcançar um saldo igual ou superior a R$500,00 em comissões no sistema multinível.

3.5. – Ao completar sua primeira matriz de associados, o membro. poderá se cadastrar no sistrma binario e iniciar a construção de uma nova rede. Dessa forma, poderá lucrar ainda mais.

3.6 – Cada material em forma de produto oferecidos pelo sistema, seja de autoria do Oexclusivo ou de outro autor, Não poderá ser vendido.

3.7 – O esquema de ganhos descrito é uma ilustração matemática para mostrar o potencial de ganhos do afiliado no sistema. Para alcançar o potencial descrito no esquema, o afiliado terá de se empenhar para atingir a meta.

3.8 – Os recursos para distribuir as bonificações, são devidos à mensalidade dos membros de uma determinada matriz, bem como o lucro adquirido com o sistema de vendas diretas.

3.9 – O valor referente às comissões do associado, será depositado no final de cada mês.

3.10 - O produto do Sistema é: Comercio e Distribuição Outlet de produtos importados Roupas.

3.11 - As condições normativas, que regem este Contrato de Adesão, são regidas pela Legislação Brasileira.

LOCAL E DATA.
</textarea>
					      </div>
					    </div>	
					    
					    
                    
                    
                    
                    
	
	 
                </div>
                <!-- END TAB4 CONTAINER -->
            </div>
            <!-- BEGIN FORM BUTTONS ACTION CONTROLS -->
            <div class="form-actions" id="action-container">
                <div class="offset2">
                    <button name="previous" class="btn button-previous disabled" type="button"><i class="icon-angle-left"></i> <?php echo $dados['linguagem']['voltar']['voltar']; ?></button>
                    <button name="next" class="btn button-next" type="button"><?php echo $dados['linguagem']['continua']['continuar']; ?> <i class="icon-angle-right"></i></button>
                    <button name="finish" class="btn button-finish"  onclick="return bottomReached('textarea1')" style="display: none;">Cadastrar <i class="icon-ok"></i></button>
                </div>
            </div>
            <!-- END FORM BUTTONS ACTION CONTROLS -->
        </form>
        <!-- END FORM WIZARD  -->
        <br><br>
        <?php // }else{?>
        <div class="span12">
        <!-- BEGIN ALERTS BOX EXAMPLES -->
        <!--<div class="social-box">
            <div class="header">
                <h4>Atenção</h4>
            </div>
            <div class="body">



               <div class="alert alert-block alert-error">
                    <h4 class="alert-heading">Erro!</h4>
                    <p>O usuário <strong><?php echo strtoupper($dados['param']['usuario']);?></strong>, não está cadastrado em nosso sistema. Favor procure um indicante válido.</p>
                </div>

            </div>
        </div>-->
        <!-- END ALERTS BOX EXAMPLES -->
    </div>
        <?php //}?>
    </div>


        
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
    
   

		    <script src="http://<?php echo $dados['host'];?>/core/View/js/ptbr.js"></script>

   
    <!---->
    <script>
      $(function() {
        FormWizard.init();
      });
    </script>
    <!-- END JAVASCRIPT CODES FOR THE CURRENT PAGE -->
        <!-- END JAVASCRIPT CODES -->
 
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
window.jQuery || document.write('<script src="http://<?php echo $dados['host'];?>/core/View/assets/plugins/jquery/jquery.min.js"><\/script>')</script>
<script src="http://<?php echo $dados['host'];?>/core/View/assets/js/login.js"></script>
<script>
        $(function() {
            Login.init()
        });
    </script>
</body>
</html>
