$("#valor").maskMoney({thousands:'.', decimal:','});
var interval = 0;

function historico_paginacao(pagina) {
	$("#pagina").val(pagina);
	historico();
}

function historico() {
	//pagina = $('#pagina').val();
	//regpag = $('#regpag').val();
	//busca = $('#busca').val();
	dataInicio = $('#dataInicio').val();
	dataFim = $('#dataFim').val();
	
	$.ajax({
		type: "POST",
		url: "historico_ajax",
		data: {dataInicio:dataInicio,dataFim:dataFim},
		dataType: "html",
		success: function(res){
			//alert(res); return false;
					$('#historico_listar').html('');
					$('#historico_listar').append(res);
				}
		});			
}

function historico_bonus_paginacao(pagina) {
	$("#pagina").val(pagina);
	historico_bonus();
}

function historico_bonus() {
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	busca = $('#busca').val();

	$.ajax({
		type: "POST",
		url: "historico_bonus_ajax",
		data: {pagina:pagina,regpag:regpag,busca:busca},
		dataType: "html",
		success: function(res){
					$('#historico_listar').html('');
					$('#historico_listar').append(res);
				}
		});
}

function pagarpedidos() {
	transid = $('#transid').val();
	senha = $('#seguranca').val();
	usuario = $('#usuario').val();
	
	$.ajax({
		type: "POST",
		url: "pagarpedidos_ajax",
		data: {transid:transid, usuario:usuario, senha:senha},
		dataType: "html",
		success: function(res){
					$('#pagarpedidos_content').html('');
					$('#pagarpedidos_content').append(res);
				}
		});		
}
 
$("#enviar").click(function(){
		


		senha = $('#seguranca').val();
		valor = parseFloat($('#valor').val().replace(".", "").replace(",", "."))+3;
		usu   = $('#usuario').val();
		disp  = parseFloat($('#disponivel').val().replace(",", "."));
				//alert(disp+' - '+valor);
				//return false;
		host = location.host;
		url = 'http://'+host;
		
		if((senha != ''))
		{
			if(disp >= valor)
			{

		$('#msg').html('');
		$('#msg').html('<img src="'+url+'/core/View/img/load.gif" >');
		

			$.ajax({
				type: "POST",
				url: url+"/ContaCorrente/transferencia_ajax",
				data: {usu:usu, valor:valor, senha:senha},
				dataType: "json",
				success: function(res){

					if(res.retorno == 'nao'){
						
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">'+res.msg+'</span></div>');

                     }else{
                    	 $('#msg').html('');
                    	 $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">'+res.msg+'</span></div>');
						 $('#saldo').html('');
						 $('#saldo').append(res.saldo);
						 $('#usuario').val('');
						 $('#valor').val('');
						 $('#seguranca').val('');
                     }

				}

			});
			
			}else{
				
				
				$('#msg').html('');
				$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Sua solicitação de saque é maior que o valor disponível.</span></div>');
				
				
			}
			
		}else{
			
			$('#msg').html('');
			$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Não é permitido campos vazios.</span></div>');
						
		}


	});
 


