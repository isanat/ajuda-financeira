<script src="http://<?php echo $dados['host'];?>/core/View/js/livequery.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/cad_usu.js"></script>

<?php 
  //echo utf8_decode("TELA DE CADASTRO EM MANUTENÇÃO VOLTAMOS AS 16:30 HORAS"); die;
  if($_SESSION['usuario']['fk_status'] == 1){
?>
<div class="alert alert-error"><strong>ATENÇÃO!</strong> <span id="msg_erro"> 
Para que você possa efetuar cadastros você precisa está ativo no sistema, e para se ativar você precisa efetuar sua 1º doação em: <strong>DOAÇÕES REALIZAR</strong>,<br> E ENVIAR O <strong>COMPROVANTE</strong> PARA O PARTICIPANTE QUE SERÁ SEU <strong>1º UPLINE</strong></span></div>
<?php
}else{
?>

<div class="social-box">

<div class="col-md-12 col-sm-12 col-xs-12">
 <div class="x_panel">
  <h2>Informações de Cadastro</h2>
   <div class="x_content">	
    
    <div class="body">      
                <!-- BEGIN TAB1 CONTAINER -->
                <div class="tab-pane active" id="tab-validation1">
                   <h3>Básico</h3>
                   <span id="msg"></span>
                    <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label">Usuário <span style="color:red">*</span></label>
                      <div class="controls">
                        <input id="usuario" name="usuario" style="width:300px" placeholder="Nome de Usuário" class="form-control" type="text">
                        <p class="help-block"></p>
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label">Nome <span style="color:red">*</span></label>
                      <div class="controls">
                        <input id="nome" name="nome" style="width:300px" placeholder="Nome Completo" class="form-control" type="text">
                        <p class="help-block"></p>
                      </div>
                    </div>
					
                    <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label">CPF <span style="color:red">*</span></label>
                      <div class="controls">
                        <input id="cpf" name="cpf" style="width:300px" placeholder="999.999.999-99" class="form-control" type="text">
                        <p class="help-block"></p>
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label">E-mail <span style="color:red">*</span></label>
                      <div class="controls">
                        <input id="email" name="email" style="width:300px" placeholder="E-mail" class="form-control" type="text">
                        <p class="help-block"></p>
                      </div>
                    </div>
					
                    <!-- Multiple Checkboxes -->
                    <div class="control-group">
                      <label class="control-label">Sexo <span style="color:red">*</span></label>
                      <div class="controls">
                        <label>
                          <input name="sexo" class="sexom" value="" type="radio">
                          Masculino
                        </label>
                        <label>
                          <input name="sexo" class="sexof" value="" type="radio">
                          Feminino
                        </label>                
                      </div>
                    </div><p>
                    
                    <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label">Data Nascimento <span style="color:red">*</span></label>
                      <div class="controls">
                        <input id="datanasc" name="datanasc" style="width:300px" placeholder="99/99/9999" class="form-control" type="text">
                        <p class="help-block"></p>
                      </div>
                    </div> 
					
         <h3>Endereço</h3>
                    <div class="widget-content padded">
                    
            <span id="erroCep"></span>

              <div class="form-group">
                  <label for="disabledInput">CEP</label>
                  <input class="form-control" style="width:300px" id="cep" name="cep" required placeholder="00000-000" type="text">
                  <img class="loadCarr" style="display:none" src="http://<?php echo $dados['host'];?>/core/View/img/load.gif" />
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail">Endereço Completo <span style="color:red">*</span></label><br>
                  <input class="form-control" id="end" name="end" placeholder="Endereço Completo" style="width:300px" type="text">
                  <input class="form-control" id="numero" name="numero" placeholder="Número" style="width:80px" type="text">
                </div>
				
                <div class="form-group">
                  <label for="disabledInput">Complemento</label>
                  <input class="form-control" style="width:200px" id="comple" name="comple" placeholder="Complemento" type="text">                 
                </div>
				
              <div class="form-group">
                  <label for="disabledInput">Bairro <span style="color:red">*</span></label>
                  <input class="form-control" style="width:300px" id="bairro" name="bairro" placeholder="Bairro" type="text">                 
                </div>
                <div class="form-group">
                  <label for="disabledInput">Cidade <span style="color:red">*</span></label>
                  <input class="form-control" style="width:300px" id="cidade" name="cidade" placeholder="Cidade" type="text">                 
                </div>
                <div class="form-group">
                  <label for="disabledInput">UF <span style="color:red">*</span></label>
                  <input class="form-control" style="width:300px" id="uf" maxlength="2" name="estado" placeholder="Estado" type="text">                 
                </div>
            </div>
                    
         <h3>Telefones</h3>
			 <span id="msgfone"></span>
                   <div class="widget-content padded">
          

              <div class="form-group">
                  <label for="disabledInput">Celular <span style="color:red">*</span></label>
                  <input class="form-control" style="width:300px" id="celular" placeholder="(00) 00000-0000" name="celular" type="text">                 
              </div>
              
              <div class="form-group">
                  <label for="disabledInput">whatsapp</label>
                  <input class="form-control" style="width:300px" id="whatsapp" placeholder="(00) 00000-0000" name="whatsapp" type="text">                 
              </div>
              
              <div class="form-group">
                  <label for="disabledInput">Fixo</label>
                  <input class="form-control" style="width:300px" id="fixo" placeholder="(00) 0000-0000" name="fixo" type="text">                 
              </div>              

              <div class="form-group">
                  <label for="disabledInput">Comercial</label>
                  <input class="form-control" style="width:300px" id="comercial" name="comercial" placeholder="(00) 0000-0000" type="text">
                 
              </div>
            </div>
    
    <h3>Senha de Acesso</h3>
       <span id="msgsenha"></span>              

          <div class="widget-container fluid-height clearfix">

            <div class="widget-content padded">       
              <div class="form-group">
                  <label for="disabledInput">Senha <span style="color:red">*</span></label>
                  <input class="form-control" style="width:300px" id="senha" name="senha" placeholder="Senha" type="password">                 
            
			
                  <label for="disabledInput">Repetir Senha <span style="color:red">*</span></label>
                  <input class="form-control" style="width:300px" id="repitasenha" name="repitasenha" placeholder="Repetir Senha" type="password">                 
              </div>
            </div>
          </div>
                       

</div>
</div>

	</div>
  </div>
</div>


<span class="carregar" style="display:none">
<img src="http://<?php echo $dados['host'];?>/core/View/img/load.gif" /> <span style="color:red">Cadastrando.....</span>
</span><br>

<span id="msgsexo"></span>

 <div class="form-actions">
     
      <input type="button" class="btn btn-primary cadastrar" value="Cadastrar" />
 </div>

<?php
}
?>