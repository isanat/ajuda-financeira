<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="dashboard_graph">
		<div class="row x_title">
			<div class="col-md-12">
				<h3>Olá, <strong><?php echo $_SESSION['usuario']['usu_usuario']; ?></strong>  quer participar da maior revolução digital? </h3><p style="margin-bottom:20px">


<h3>O SISTEMA GetCash.</h3><p style="margin-bottom:20px">
<p style="margin-bottom:20px">
Sentimo-nos lisonjeados por tê-lo junto conosco!<p style="margin-bottom:20px">

O sistema GetCash é nosso, portanto, sinta-se à vontade para dizer que ele é seu.<p style="margin-bottom:20px">

E como peça fundamental na engrenagem desta máquina dinâmica eficiente que nos conduzirá ao sucesso,<br>
precisamos de igual forma ser dinâmicos e eficientes.<p style="margin-bottom:20px">


Para participar do nosso sistema e caminhar lado a lado conosco em direção ao Sucesso,<br>
você deverá primeiro efetuar o depósito de R$ 10,00 (dez reais) na conta bancária da GetCash.<br>
Logo que você efetuar a doação dos R$:10,00 para GetCash você terá que enviar o comprovante e assim nos estaremos liberando <br>
todos os recursos da plataforma e assim você poderá está doando e recebendo diretamente em sua conta. <p style="margin-bottom:20px">

<h3>Por que este depósito?</h3><p style="margin-bottom:20px"><p style="margin-bottom:20px">

Queremos deixar bem claro que não estamos aqui para nos aventurar, estamos aqui para ganhar <br>
dinheiro como empreendedores visionários que somos. E em nossa opinião, visão sem competência<br>
não passa de uma simples utopia!<p style="margin-bottom:20px">

E para que não venhamos reincidir nos mesmos erros dos muitos sistemas que foram apresentados<br>
na internet com proposta de inovação e sucesso garantido e acabaram dando em nada, buscamos<br>
a sustentabilidade do nosso sistema.<p style="margin-bottom:20px">

É impossível oferecer o melhor assumindo sozinho as despesas. O nosso sistema é funcional, <br>
temos gastos com servidores, uma equipe de profissionais na programação e outra no suporte.<p style="margin-bottom:20px">

E não se esqueça, somos diferentes de tudo o que já foi apresentado na internet como Sistema de Ajuda Mútua.<br>
Somos diferentes porque não somos aventureiros, somos um grupo empreendedores fortes que pensam em nada mais,<br>
nada menos do que AJUDAR O PRÓXIMO.<p>

<strong>Em nosso sistema, a sua rede verdadeiramente fica no piloto automático!</strong><p style="margin-bottom:20px">
		
<strong>Se ative e já comece a convidar seus parentes, amigos e conhecidos!</strong>	<p style="margin-bottom:20px">

<strong>SEGUE ABAIXO DOIS MEIOS QUE VOCÊ PODE USAR PARA EFETUAR  A DOAÇÃO DOS R$:10,00</strong><p style="margin-bottom:20px">

Grato

Administração
<p style="margin-bottom:20px">		

<?php if($dados['model']['retorno'] == "ok"){ ?>
<div class="alert alert-success alert-dismissible fade in" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
<strong>Parabéns!</strong> O Comprovante foi enviado com sucesso, aguarda a confirmação!
</div>
<?php } if($dados['model']['formato'] == "no"){  ?>
<div class="alert alert-danger alert-dismissible fade in" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
<strong>ERRO!</strong>  O Formato do comprovante e inválido, aceitamos apenas<strong> ( jpeg, jpg, png )</strong>.
</div>
<?php } if($dados['model']['retorno'] == "no"){ ?>
<div class="alert alert-danger alert-dismissible fade in" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
<strong>ERRO!</strong> Um comprovante já foi enviado agora, aguarde a liberação!
</div>
<?php } ?>


<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<h2>Contas Bancárias</h2>
<div class="x_content">	

<div class="social-box">
          <div class="body">			
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Banco</th>
                  <th>Tipo</th>
                  <th>Agência</th>
                  <th>Conta</th>
                  <th>Favorecido</th>
				  <th>Valor R$</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Itaú</td>
                  <td>Corrente</td>
                  <td>0173 - </td>
                  <td>06350 - 4</td>
                  <td>Marcelo Silva Rodrigues</td>   
				  <td>10,00</td>   				  
                </tr>
              </tbody>		  
			</table>			
          </div>
      </div>
	  
	</div>
  </div>

 <div class="x_panel">
<h2>Meio de Pagamento Digital</h2>
<div class="x_content">	
<div class="social-box">
          <div class="body">			
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Conta Super</th>
				  <th>Valor R$</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>startox@hotmail.com</td> 
				  <td>10,00</td>				  
                </tr>
              </tbody>		  
			</table>			
          </div>
      </div>	  
	</div>
  </div> 
  
</div>


 <form action='../Backoffice/confirmanoCadastro' enctype='multipart/form-data' method='post' name='form'>
            <div class='control-group'>
              <label class='control-label' for='filebutton'> Enviar Comprovante:</label>
              <div class='controls'>
               <input id='arquivo' name='arquivo' class='input-file' type='file'>
              </div>
            </div>
            <p style="margin-bottom:20px">
            <div class='controls'>
			<input type="hidden" name="acao" value="comprovante" />
                <input type='submit' id='enviar' name='enviar' class='btn btn-primary' value='Enviar' />
            </div>
        </form>			
				
				
			</div>                               
		</div>
		</div>
	</div>
</div>
