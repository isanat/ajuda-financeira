jQuery(function($) {
	
	$("#card_doc").mask("999.999.999-99",{placeholder:" "});
	$("#card_datanasc").mask("99/99/9999",{placeholder:" "});
	$("#card_cep").mask("99999-999",{placeholder:" "});
		
	
	$("#card_datanasc").blur(function(){

		data = $(this).val();
		host = location.host;
		url = 'http://'+host;
		
			$.ajax({
				type: "POST",
				url: url+"/Usuario/isset_idade_ajax",
				data: {usu_datanasc:data},
				dataType: "text",
				success: function(res){

					if(res == 'sim'){
						
						$('#datanasc').val('');
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Você é menor de idade!</span></div>');

                     }else{
                    	 $('#msg').html('');
                    	 $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Idade aceita</span></div>');
                     }

				}

			});


	});
	

	
	$("#card_doc").blur(function(){

		cpf = $(this).val();
		host = location.host;
		url = 'http://'+host;


			$.ajax({
				type: "POST",
				url: url+"/Usuario/card_cpf_ajax",
				data: {usu_doc:cpf},
				dataType: "text",
				success: function(res){

					if(res == 'nao'){

						$('#card_doc').val('');
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">CPF Inválido ou já existe em nosso sistema</span></div>');


					}else{

						$('#msg').html('');
						$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">CPF válido</span></div>');

					}

						}

			});


	});
	
	$("#card_cep").blur(function(){

		cep = $(this).val().replace('-','')
		host = location.host;
		url = 'http://'+host;


           $.ajax({
           type: "POST",
           url: url+"/Usuario/get_cep_ajax",
           data: {end_cep:cep},
           dataType: "json",
           success: function(res){


                    if(res.uf == ''){

						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">CEP Inválido</span></div>');
						$('#card_uf').val('')
	                    $('#card_cidade').val('')
	                    $('#card_bairro').val('')
	                    $('#card_ende').val('')

                            }else{
                    $('#msg').html('');
                    $('#card_uf').val(res.uf)
                    $('#card_cidade').val(res.cidade)
                    $('#card_bairro').val(res.bairro)
                    $('#card_end').val(res.logradouro)
                    $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">CEP válido</span></div>');
                    }

                        }
                });


	});
	
	
	$(".required").blur(function(){

		campo = $(this).val();

		
		if(campo == '')
			{
			$(this).css('border-color','red')
			}
		else{
			$(this).css('border-color','')
		}

	});
	
	$(".gravar").click(function(){

		var cont = 0;
		
		
		
			$("#form .required").each(function(){
		         if($(this).val() == "")
		             {
		        	 $(this).css('border-color','red')
		                 cont++;
		             }
		        });
		     if(cont == 0)
		         {
		             $("#form").submit();
		         }
		

	});
	
	$(".required_card").blur(function(){

		campo = $(this).val();

		
		if(campo == '')
			{
			$(this).css('border-color','red')
			}
		else{
			$(this).css('border-color','')
		}

	});
	
	$(".gravar_card").click(function(){

		var cont = 0;
		
		
		
			$("#form_card .required_card").each(function(){
		         if($(this).val() == "")
		             {
		        	 $(this).css('border-color','red')
		                 cont++;
		             }
		        });
		     if(cont == 0)
		         {
		             $("#form_card").submit();
		         }
		

	});
	
	
	$(".view").click(function(){

		id = $(this).attr('id');
		host = location.host;
		url = 'http://'+host;
		$('.modal-header').html('');
			$.ajax({
				type: "POST",
				url: url+"/MeusDados/cartao_ajax",
				data: {id:id,acao:'listar'},
				dataType: "html",
				success: function(res){

                    	 
                    	 $('.modal-header').html(res);
                     

				}

			});


	});
	
	$(".del").click(function(){

		id = $(this).attr('apagar');
		host = location.host;
		url = 'http://'+host;

			$.ajax({
				type: "POST",
				url: url+"/MeusDados/cartao_ajax",
				data: {id:id,acao:'apagar'},
				dataType: "html",
				success: function(res){

                    	 
                    	 //$('.modal-header').html(res);
						 location.reload(); 
                     

				}

			});


	});
	
	$(".editar").click(function(){
		
		id = $(this).attr('get_id');
		nome = $(this).attr('get_nome');
		
		$('#usu_editar').html('');
		$('#card_id').val('');
		$('#usu_editar').append(nome);
		$('#card_id').val(id);
		
		
		
		
	});
	
	
	
	
});


