<input type="hidden" name="pagina" id="pagina" value="1" />
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="tipo" id="tipo" value="" />
<input type="hidden" name="idPedido" id="idPedido" value="" />

<?php if(!empty($dados['model']['inativo'][0])){ ?>
<div class="alert alert-error">
<strong>ATENÇÃO!</strong> 
Você tem até o dia <strong><?php echo $dados['model']['inativo'][0]['ped_data_expira']; ?></strong> para efetuar sua 1º doação.</div>
<?php } ?>


      <div class="social-box">
          <div class="header">
              <h4>Indicações</h4>
          </div>
          <?php $registros = ( isset( $_REQUEST['regpag'] ) ) ? $_REQUEST['regpag'] : 5; ?>
          <div class="body">
            <table width="10%" class="table table-hover">
              <thead>
              	<tr>
                	<div class="row-fluid">
                        <div class="span6">
						<div class="form-group">
							<div class="col-md-2 col-sm-2 col-xs-6"> registros por página
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
                                	<input class="form-control" placeholder="Pesquisar" type="text" id="busca" name="busca" aria-controls="editable">
                                </label>
                            </div>
                        </div>
                    </div>
                </tr>
              </thead>
              <tbody>
				<span id="listar_c"></span>
                <tr>
                  <td colspan="3"><strong>Ativos:</strong> <span class="label label-success"><?php echo $dados['model']['ativo'][0]['total']; ?></span></td>
                  <td colspan="3"><strong>Pendentes: </strong> <span class="label label-warning"><?php echo $dados['model']['pendentes'][0]['total']; ?></span></td>
                </tr>
              </tbody>
            </table>
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
			indicacoes();
		});
	
		$("#regpag").change(function(){
			$('#id').val('');
			$('#action').val('');
			$("#pagina").val(1);
			indicacoes();
		});
		
		$("#busca").keyup(function(){
			// começa a contar o tempo  
			clearInterval(interval); 
	
			// 500ms após o usuário parar de digitar a função é chamada  
			interval = window.setTimeout(function(){  
				$('#id').val('');
				$('#action').val('');
				$("#pagina").val(1);
				indicacoes();
			}, 1000);  
	
		}); 
	});
    </script>