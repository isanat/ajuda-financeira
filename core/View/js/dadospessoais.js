jQuery(function($) {

	$("#usu_datanasc").mask("99/99/9999",{placeholder:" "});
	$("#end_cep").mask("99999-999");

	
	$("#end_cep").blur(function(){

		cep = $(this).val().replace('-','')
		$(".carregar").show();

           $.ajax({
           type: "POST",
           url: "Correios",
           data: {cep:cep},
           dataType: "json",
           success: function(res){

        	   
                    if(res.uf == ''){

						$('#erro').html('');
						$('#erro').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">CEP Inválido</span></div>');

                            }else{
                            	
                    $('#erro').html('');
                    $('#end_uf').val(res.uf);
                    $('#end_cidade').val(res.cidade);
                    $('#end_bairro').val(res.bairro);
                    $('#end_end').val(res.logradouro);
					$(".carregar").hide();
                    }

                        }
                });


	});
	
	/*$("#usu_email").blur(function(){

	    email = $(this).val();	
		
	    $.ajax({
	           type: "POST",
	           url: "VerEmailAjax",
	           data: {usu_email:email},
	           dataType: "text",
	           success: function(res){

	                    if(res == 'ok'){

							$('#erro').html('');
							$('#erro').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Email está liberado!</span></div>');

	                            }else{
	                            	$('#erro').html('');
	    							$('#erro').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Email já existe em nosso cadastro, tente novamente</span></div>');
	    							$("#usu_email").val('');
	                    }

	                        }
	                });

	 });*/
	
	$("#usu_datanasc").blur(function(){

	    data = $(this).val();
		
	    $.ajax({
	           type: "POST",
	           url: "MaiorIdadeAjax",
	           data: {usu_datanasc:data},
	           dataType: "text",
	           success: function(res){

	                    if(res == 'ok'){

							$('#erro').html('');
							$('#erro').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Você é maior de idade!</span></div>');

	                            }else{
	                            	$('#erro').html('');
	    							$('#erro').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Você é menor de idade, tente novamente</span></div>');
	    							$("#usu_datanasc").val('');
	                    }

	                        }
	    });

	 });
	
	$('#cadastrar').click(function(){
		
		nome = $('#usu_nome').val();
		
	    email = $('#usu_email').val();
	    data = $('#usu_datanasc').val();	    
	    if($("#usu_sexo-0").is(":checked")){
	    	sexo = 'm';
	    }else{
	    	sexo = 'f';
	    }
		
	    $.ajax({
	           type: "POST",
	           url: "UpUsu",
	           data: {usu_nome:nome,usu_sexo:sexo,usu_email:email,usu_datanasc:data,tabela:'tb_usuarios'},
	           dataType: "json",
	           success: function(res){

	                    if(res.model == 'ok'){

							$('#erro').html('');
							$('#erro').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Seus dados foram atualizados com sucesso!</span></div>');

	                            }else{
	                            	$('#erro').html('');
	    							$('#erro').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Verifique seus dados, tente novamente</span></div>');
	    							
	                    }

	                        }
	    });
	});
	
	$('#atualizar_dados').click(function(){
		
		nome = $('#usu_nome').val();
	    email = $('#usu_email').val();
	    data = $('#usu_datanasc').val();
		//doc = $('#usu_cpf').val().replace('.','').replace('.','').replace('-','').replace(' ','');

	    if($("#usu_sexo-0").is(":checked"))
	    	{
	    	sexo = 'm';
	    	}else{
	    		sexo = 'f';
	    	}
		
	    $.ajax({
	           type: "POST",
	           url: "UpUsu",
	           data: {usu_nome:nome,usu_sexo:sexo,usu_email:email,usu_datanasc:data,acao:"atualizar"},
	           dataType: "text",
	           success: function(res){
				
				
				
	                    if(res == 'ok'){

							$('#erro').html('');
							$('#erro').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Seus dados foram atualizados com sucesso!</span></div>');

	                            }else{
	                            	$('#erro').html('');
	    							$('#erro').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Verifique seus dados, tente novamente</span></div>');return false;
	    							
	                    }

	                        }
	    });
	});
	
$('#atualizar_end').click(function(){
		
		cep 	= $('#end_cep').val().replace('-','');
	    end 	= $('#end_end').val();
	    n 		= $('#end_n').val();
	    comp 	= $('#end_comp').val();
	    bairro 	= $('#end_bairro').val();
	    cidade 	= $('#end_cidade').val();
	    uf	 	= $('#end_uf').val();
		
		
	    $.ajax({
	           type: "POST",
	           url: "UpEnd",
	           data: {end_cep:cep, end_end:end, end_n:n, end_comp:comp, end_bairro:bairro, end_cidade:cidade, end_uf:uf, acao:'upend'},
	           dataType: "text",
	           success: function(res){

	                    if(res == 'ok'){

							$('#erro_end').html('');
							$('#erro_end').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Seu Endereço foi atualizado com sucesso!</span></div>');

	                     }else{
	                            	$('#erro_end').html('');
	    							$('#erro_end').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Verifique seus dados, tente novamente</span></div>');
	    							
	                    }

	                        }
	    });
	});
	
	
	
	
	
$('#atualizar_fone').click(function(){
		
		fone_fixo 	   = $('#fone_fixo').val().replace('(','').replace(')','').replace('-','').replace(' ','');
	    fone_celular   = $('#fone_celular').val().replace('(','').replace(')','').replace('-','').replace(' ','');
	    fone_comercial = $('#fone_comercial').val().replace('(','').replace(')','').replace('-','').replace(' ','');
		fone_whatsapp = $('#fone_whatsapp').val().replace('(','').replace(')','').replace('-','').replace(' ','');	   
		
		fixoId = $('#resid').val();
		celId = $('#celid').val();
		comerId = $('#comerid').val();
		whatsId = $('#whatsId').val();
		
				
		$.ajax({
			type: "POST",
			url: "upFoneUsu",
		data: {fone_fixo:fone_fixo, fone_celular:fone_celular, fone_comercial:fone_comercial,fone_whatsapp:fone_whatsapp,fixoId:fixoId, celId:celId, comerId:comerId,whatsId:whatsId, acao:'upFone'},
			dataType: "text",
			success: function(res){
		
			if(res == 'ok'){
				
				$('#erro_fone').html('');
				$('#erro_fone').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Telefones atualizados com sucesso!</span></div>');
			
			}else{
				$('#erro_fone').html('');
				$('#erro_fone').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Erro ao tentar atualizar os Telefones.</span></div>');
				return false;
			  }
			  
			}
		  });
		});	
	
	
	

});