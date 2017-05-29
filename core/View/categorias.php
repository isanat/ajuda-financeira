<?php //echo '<pre>';print_r($dados);?>

<aside id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="myModalLabel">Editar Categoria</h3>
    </div>
    <div class="modal-body">
    
        <form action="editar_cat" method="POST">
			<div class="control-group">
              <label class="control-label">Editar Categoria</label>
              <div class="controls">
                <div class="input-append">
                  <input style="width: 180px" type="text" id="novo" class="span10" name="novo" placeholder="Editar Categoria">
                  <input type="hidden" id="antigo" name="antigo" value="">
                  <button type="submit" class="btn">Gravar</button>
                </div>
              </div>
			</div>
	</form>
	
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
    </div>
</aside>


<div class="row-fluid">

    <div class="span12">
    
    
    <form action="inserir_cat" method="POST">
			<div class="control-group">
              <label class="control-label">Inserir Nova Categoria</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" id="cat" class="span10" name="cat" placeholder="Inserir Categoria">
                  <button type="submit" class="btn">Gravar</button>
                </div>
              </div>
			</div>
	</form>
           
           
           
           
           
      <div class="social-box">
          <div class="header">
              <h4>Categorias</h4>
          </div>
          <div class="body">

            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($dados['model'] as $cat){?>
                <tr>
                  <td><?php echo $cat['cat_nome']?></td>
                  <td>
                  		<div class="btn-group">
    <form action="apagar_cat" method="POST" style="margin: 0px">
    <button class="btn btn-danger" name="del_cat" type="submit" value="<?php echo $cat['cat_id']?>"><i class="icon-white icon-trash"></i></button>
    </form>
				        </div>
				        
				        <div class="btn-group">
<a class="btn btn-info editar" dados="<?php echo $cat['cat_nome']?>" ids="<?php echo $cat['cat_id']?>" href="#myModal" data-toggle="modal">
<i class="icon-pencil"></i></a>
				        </div>
				        
				        <div class="btn-group">
				        <a class="btn btn-warning" href="sub/sub/<?php echo $cat['cat_id']?>">Sub-Categoria</i></a>
				        </div>
                  </td>
                </tr>
			<?php }?>
              </tbody>
            </table>

          </div>
      </div>
    </div>
    
    

  </div>
<script src="http://<?php echo $dados['host'];?>/core/View/js/categorias.js"></script>