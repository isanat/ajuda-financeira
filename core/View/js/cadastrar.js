jQuery(function($) {

	$('#cel').focusout(function(){
		var phone, element;
		element = $(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if(phone.length > 10) {
		element.mask("(99) 99999-9999",{placeholder:" "});
		} else {
		element.mask("(99) 9999-9999?9",{placeholder:" "});
		}
	}).trigger('focusout');
	
  $("#fixo").mask("(99) 9999-9999");
  $("#comercial").mask("(99) 9999-9999");
  $("#whatsapp").mask("(99) 99999-9999");
 
	$(".usuario").blur(function(){
		usu = $(this).val()
		.replace(/[á|ã|â|à]/gi, "a").replace(/[é|ê|è]/gi, "e").replace(/[í|ì|î]/gi, "i").replace(/[õ|ò|ó|ô]/gi, "o")
		.replace(/[ú|ù|û]/gi, "u").replace(/[ç]/gi, "c").replace(/[ñ]/gi, "n").replace(/[á|ã|â]/gi, "a").replace(/[~]/gi, "")
		.replace(/[ ]/gi, "").replace('.', "").toLowerCase();
	    $(this).val(usu);
		
		host = location.host;
		url = 'http://'+host;
		id = $(this).attr('id');
		
		if(usu == ""){
		 $('#msg').html('');
		 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Usuário não pode ser vazio!</span></div>');
		
		}else{
			$.ajax({
				type: "POST",
				url: url+'/Usuario/isset_usuario_ajax',
				data: {usu_usuario:usu},
				dataType: "text",
				success: function(res){

					if(res == 'sim'){
						
						$('.usuario').val('');
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Usuário já existe</span></div>');

                     }else{
                    	 $('#msg').html('');
                    	 $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">nome de usuário aceito em nosso sistema</span></div>');
                     }

				}

			});
		
		}

	});
	
	$("#email").blur(function(){

		email = $(this).val();
		host = location.host;
		url = 'http://'+host;		
		
        
		if(email == ""){
		 $('#msg').html('');
		 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">E-mail não pode ser vazio!</span></div>');		
		}else{			
			$('#msg').html('');
er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/; 
if( !er.exec(email) )
{
 $('#msg').html('');
 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">E-mail Inválido!</span></div>');
  $(this).val("");
return false;
}
		}

	});
	
	$("#re_password").blur(function(){

		conf = $(this).val();
		senha = $("#password").val();
         if(senha == ""){
		 $('#msg').html('');
		 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Senha não pode ser vazio!</span></div>');
		
		}else{

			if(conf != senha){

				$('#msg').html('');
				$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Senhas Diferentes</span></div>');
				$(this).val('');
				$("#usu_senha").val('');

			}else{

				$('#msg').html('');
				$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Senhas aceitas</span></div>');

			}
		}

	});
	
	$("#re_password_s").blur(function(){

		conf = $(this).val();
		senha = $("#password_s").val();
       
     if(conf == ""){
		 $('#msg').html('');
		 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Confirmação de Senha não pode ser vazio!</span></div>');
		
		}else{  
			if(conf != senha){

				$('#msg').html('');
				$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Senhas de Segurança diferentes</span></div>');
				$(this).val('');
				$("#usu_senha").val('');

			}else{

				$('#msg').html('');
				$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Senhas de Segurança aceitas</span></div>');

			}
		}

	});
	
	$("#datanasc").blur(function(){

		data = $(this).val();
		host = location.host;
		url = 'http://'+host;
		
	if(data == "" || data == "_/_/__"  ){
		 $('#msg').html('');
		 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Data de Nascimento não pode ser vazio!</span></div>');
		
		}else{
		
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
		}

	});
	
	$("#cpf").blur(function(){

		cpf = $(this).val();
		host = location.host;
		url = 'http://'+host;
       
         if(cpf == ""){
		 $('#msg').html('');
		 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">CPF não pode ser vazio!</span></div>');
		
		}else{
			$.ajax({
				type: "POST",
				url: url+"/Usuario/isset_cpf_ajax",
				data: {usu_doc:cpf},
				dataType: "text",
				success: function(res){

					if(res == 'nao'){

						$('#cpf').val('');
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">CPF Inválido ou já existe em nosso sistema</span></div>');


					}else{

						$('#msg').html('');
						$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">CPF válido</span></div>');

					}

						}

			});
		}

	});
	
	$("#cep").blur(function(){

		cep = $(this).val().replace('-','')
		host = location.host;
		url = 'http://'+host;

       if(cep == ""){
		 $('#msg').html('');
		 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Cep não pode ser vazio!</span></div>');
		
		}else{
		   $(".carregar").show();
           $.ajax({
           type: "POST",
           url: url+"/Usuario/get_cep_ajax",
           data: {end_cep:cep},
           dataType: "json",
           success: function(res){


                    if(res.uf == ''){

						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">CEP Inválido</span></div>');
						$('#uf').val('')
	                    $('#cidade').val('')
	                    $('#bairro').val('')
	                    $('#endereco').val('')

                            }else{
                    $('#msg').html('');
                    $('#uf').val(res.uf)
                    $('#cidade').val(res.cidade)
                    $('#bairro').val(res.bairro)
                    $('#endereco').val(res.logradouro)
                    $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">CEP válido</span></div>');
					 $(".carregar").hide();
                    }

                        }
                });
		}

	});
	
		
	
});


