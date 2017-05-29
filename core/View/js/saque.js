jQuery(function($) {

//	$("#valor").mask("99/99/9999",{placeholder:" "});
$("#valor").maskMoney({
					showSymbol:true, 
					symbol:"R$", 
					decimal:",", 
					thousands:"."
					});

	
	$("#pagar").click(function(){
		


		senha = $('#seguranca').val();
		valor = parseFloat($('#valor').val().replace(".", "").replace(",", "."))+3;
		usu   = $('#usuario').val();
		disp  = parseFloat($('#disponivel').val().replace(",", "."));
		
	
				//alert(disp+' - '+valor);
				//return false;
		host = location.host;
		url = 'http://'+host;
		
		if((senha != '' && valor >= 300))
		{
			if(disp >= valor)
			{

		$('#msg').html('');
		$('#msg').html('<img src="'+url+'/core/View/img/load.gif" >');
		

			$.ajax({
				type: "POST",
				url: url+"/ContaCorrente/saque_ajax",
				data: {usu_doc:usu, valor:valor, senha:senha},
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
			$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Não é permitido campos vazios ou valor menor que R$ 300,00.</span></div>');
						
		}


	});




});
	
    


  

	
