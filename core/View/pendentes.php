<script src="http://<?php echo $dados['host'];?>/core/View/js/pendentes.js"></script>
<div class="row-fluid">

    <!-- BEGIN TABLE HOVER EXAMPLE -->
    <div class="span12">
      <div class="social-box">
          <div class="header">
              <h4>Cadastros Pendentes</h4>
          </div>
          <div id="msg"></div>
          <div class="body">

            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Usuário</th>
                  <th>Data</th>
                  <th>Perna</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($dados['model']['lista'] as $usuarios){?>
                <tr>
                  <td><?php echo $usuarios['usu_id']?></td>
                  <td><?php echo $usuarios['usu_usuario']?></td>
                  <td><?php echo $usuarios['usu_data']?></td>
                  <td>
					<select name="perna" class="perna" perna="<?php echo $usuarios['usu_id']?>">
					    <?php $sel = ( $usuarios['usu_perna_pref'] == "e" ) ? ' selected="selected"' : ''; ?>
					    <option value="e"<?php echo $sel;?>>Esquerda</option>
					    <?php $sel = ( $usuarios['usu_perna_pref'] == "d" ) ? ' selected="selected"' : ''; ?>
					    <option value="d"<?php echo $sel;?>>Direita</option>
					</select>
                   
                  <?php //echo $usuarios['usu_perna_pref']?></td>
                </tr>
                <?php }?>
              </tbody>
            </table>

          </div>
      </div>
    </div>
    <!-- END TABLE HOVER EXAMPLE -->
  </div>