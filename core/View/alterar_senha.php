
<div class="social-box">
          <div class="header">
              <h4>Alterar Senha CD</h4>
          </div>
                    
          <span id="msg"></span>
          
          <div class="body">
	<div class="social-box">
		<div class="body">		
            <table width="100%" border="0">
              <tr>
                <td width="21%">Senha Atual:</td>
                <td width="79%"><input type="password" id="senha" name="senha" aria-controls="editable"></td>
              </tr>
              <tr>
                <td><label> Nova Senha:</label></td>
                <td><input type="password" id="psw_nova" name="psw_nova" aria-controls="editable"></td>
              </tr>
              <tr>
                <td><label> Confirmar Senha:</label></td>
                <td><input type="password" id="psw_nova_c" name="psw_nova_c" aria-controls="editable"></td>
              </tr>
              <tr>
                <td><input type="button" class="btn btn-success" id="alterar" href="#" value="Alterar senha" /></td>
                <td>&nbsp;</td>
              </tr>
            </table>
	  </div>
	</div>
<div>	

<script src="http://<?php echo $dados['host'];?>/core/View/js/livequery.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/Senha_cd.js"></script>