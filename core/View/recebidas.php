<input type="hidden" name="pagina" id="pagina" value="1" />
<?php //echo '<pre>';print_r($dados['model']['rece']);die;?>
<link rel="stylesheet" href="http://<?php echo $dados['host'];?>/core/View/css/colorbox.css">
<script src="http://<?php echo $dados['host'];?>/core/View/js/recebidas_ajax.js"></script>
<script src="http://<?php echo $dados['host'];?>/core/View/js/jquery.colorbox-min.js"></script>

<script>
	$(".thumbnail").colorbox({rel:'group1', transition:"none", width:"75%", height:"75%"});
</script>

<aside id="Modal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="myModalLabel">Comprovante</h3>
    </div>
    <div class="modal-body">  
        <div class="control-group">
		  <label class="control-label" for="textarea"><img id="image_comprovante" src=""></label>
		</div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
    </div>
</aside>


<?php if(!empty($dados['model']['inativo'][0])){ ?>
<div class="alert alert-error">
<strong>ATENÇÃO!</strong> 
Você tem até o dia <strong><?php echo $dados['model']['inativo'][0]['ped_data_expira']; ?></strong> para efetuar sua 1º doação.</div>
<?php } ?>

 <?php $registros = ( isset( $_REQUEST['regpag'] ) ) ? $_REQUEST['regpag'] : 5; ?>

<div class="row-fluid">

    <!-- BEGIN ZEBRA-STRIPING TABLE EXAMPLE -->
    <div class="span12">
      <div class="social-box">
          <div class="header">
              <h4>Doações Recebidas</h4>
              
<span style="color:#F00; display:none" class="loadC" >
 <img src="http://<?php echo $dados['host'];?>/core/View/img/load.gif" /><strong>Confirmando pagamento...</strong>
</span>

          </div>
          
          <span id="msg"></span>
          
          
          <div class="body">

            <table class="table table-striped responsive-utilities jambo_table bulk_action" width="100%">
              <thead>
               <tr>
                	<div class="row-fluid">
                        <div class="span6">
						  <div class="form-group">
							<div class="col-md-2 col-sm-2 col-xs-6">
                             registros por página               
                            <select tabindex="1" name="regpag" id="regpag" data-placeholder="Registros por página" class="select2_single form-control">
                                <?php $sel = ( $registros == 5 ) ? ' selected="selected"' : ''; ?>
                                <option value="5"<?php echo $sel;?>>5</option>
                                <?php $sel = ( $registros == 10 ) ? ' selected="selected"' : ''; ?>
                                <option value="10"<?php echo $sel;?>>10</option>
                                <?php $sel = ( $registros == 15 ) ? ' selected="selected"' : ''; ?>
                                <option value="15"<?php echo $sel;?>>15</option>
                                <?php $sel = ( $registros == 20 ) ? ' selected="selected"' : ''; ?>
                                <option value="20"<?php echo $sel;?>>20</option>
                                <?php $sel = ( $registros == 30 ) ? ' selected="selected"' : ''; ?>
                                <option value="30"<?php echo $sel;?>>30</option>
                                <?php $sel = ( $registros == 40 ) ? ' selected="selected"' : ''; ?>
                                <option value="40"<?php echo $sel;?>>40</option>
                            </select> 							
							</div>
                          </div>
							
                        </div>
                        <div class="span6">
						
                            <div class="dataTables_filter" id="editable_filter">
                                <label><span style="color:#F9F9F9">Busca: </span>
								<input type="text" id="busca" size="40" placeholder="O que deseja pesquisar ?" class="form-control" name="busca" aria-controls="editable">
								</label>
								 
                            </div>
                        </div>
                    </div>
                </tr>
                <tr>
                  <th width="11%">Downline</th>
                  <th width="15%">Comprovante</th>
                   <th width="19%">Comprovante enviado</th>                             
                  <th width="10%">Valor</th>
                  <th width="9%">Status</th>
                  <th width="22%" style="text-align:center"></th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="corpo_recebidas">
              
              </tbody>
            </table>
            
          
                  
          </div>
      </div>
    </div>
  </div>  
  
  <script>
    /*<![CDATA[*/
        $(function() {
            jQueryUI.init();
        });
    /*]]>*/
	jQuery(function($) {
		$( window ).load(function(){
			loadHTML();
		});
	
		$("#regpag").change(function(){
			$("#pagina").val(1);
			loadHTML();
		});
		
		$("#busca").keyup(function(){
			// começa a contar o tempo  
			clearInterval(interval); 	
			// 500ms após o usuário parar de digitar a função é chamada  
			interval = window.setTimeout(function(){  
				$("#pagina").val(1);
				loadHTML();
			}, 1000);  
	
		}); 
	});
</script>