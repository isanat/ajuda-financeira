jQuery(function($) {
	

	
	$("#pj_cnpj").mask("99.999.999/9999-99",{placeholder:" "});
	$('#cnpj').hide();
	
	$('#pj').click(function(){
		$('#cnpj').show('');
	});
	
	$('#pf').click(function(){
		$('#cnpj').hide('');
	});
	
	$('.cel').focusout(function(){
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
	
	$(".fones").mask("(99) 9999-9999",{placeholder:" "});
	
	$('#voucher').hide();
	$('#pagar').hide();
	
	/*function removeCampo() {
		$(".removerCampo").unbind("click"); 
		$(".removerCampo").bind("click", 
				function () { i=0; 
				$(".telefones .camposfone").each(function () { 
					i++; 
				}); 
				
				if (i>1) { 
					$(this).parent().remove(); 
				} 
		
		}); 
		return false;
	}
	
	removeCampo(); 
	
	$(".adicionarCampo").click(function () {
		novoCampo = $(".telefones .camposfone:first").clone(); 
		novoCampo.find("input").val(""); 
		novoCampo.insertAfter(".telefones .camposfone:last"); 
		removeCampo(); 
	});*/
	
	$("#fk_bonus").change(function(){
		
		host = location.host;
		url = 'http://'+host;
		plano = $(this).val();
		
		//alert(url)
		//url: url+"/Usuario/isset_email_ajax",
		
		location.href=url+'/Usuario/cadastrar/usuario/torus/plano/'+plano;
		
		
	});
	
	$(".usuario").blur(function(){

		usu = $(this).val();
		host = location.host;
		url = 'http://'+host;
		id = $(this).attr('id');
		
		
		if(id == 'usuario1'){
			id = $('#usuario1').val();
			id1 = $('#usuario2').val();
			id2 = $('#usuario3').val();
			
		}else if(id == 'usuario2'){
			id = $('#usuario2').val();
			id1 = $('#usuario1').val();
			id2 = $('#usuario3').val();
		}else if(id == 'usuario3'){
			id = $('#usuario3').val();
			id1 = $('#usuario1').val();
			id2 = $('#usuario2').val();
		}else{
			id = $(this).val();
			id1 = '';
			id2 = '';
			
		}

		
		if(id == id1 || id == id2){

			$(this).val('');
			$('#msg').html('');
			$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ADVERTENCIA!</strong> <span id="msg_erro">Escriba los nombres de usuario diferente para cada campo!</span></div>');
		
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
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ADVERTENCIA!</strong> <span id="msg_erro">Usuario ya existe</span></div>');

                     }else{
                    	 $('#msg').html('');
                    	 $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Felicidades!</strong> <span id="msg_erro">nombre de usuario aceptado en nuestro sistema</span></div>');
                     }

				}

			});
		}


	});
	
	$("#email").blur(function(){

		email = $(this).val();
		host = location.host;
		url = 'http://'+host;


			$.ajax({
				type: "POST",
				url: url+"/Usuario/isset_email_ajax",
				data: {usu_email:email},
				dataType: "text",
				success: function(res){

					if(res == 'sim'){
						
						$('#email').val('');
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ADVERTENCIA!</strong> <span id="msg_erro">Correo electrónico ya existe</span></div>');

                     }else{
                    	 $('#msg').html('');
                    	 $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Felicidades!</strong> <span id="msg_erro">Aceptado en nuestro sistema de correo electrónico</span></div>');
                     }

				}

			});


	});
	
	$("#re_password").blur(function(){

		conf = $(this).val();
		senha = $("#password").val();


			if(conf != senha){

				$('#msg').html('');
				$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ADVERTENCIA!</strong> <span id="msg_erro">Contraseñas diferentes</span></div>');
				$(this).val('');
				$("#usu_senha").val('');

			}else{

				$('#msg').html('');
				$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Felicidades!</strong> <span id="msg_erro">Contraseña aceptada</span></div>');

			}


	});
	
	$("#re_password_s").blur(function(){

		conf = $(this).val();
		senha = $("#password_s").val();


			if(conf != senha){

				$('#msg').html('');
				$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ADVERTENCIA!</strong> <span id="msg_erro">Contraseñas de seguridad</span></div>');
				$(this).val('');
				$("#usu_senha").val('');

			}else{

				$('#msg').html('');
				$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Felicidades!</strong> <span id="msg_erro">Contraseñas de seguridad aceptadas</span></div>');

			}


	});
	
	$("#datanasc").blur(function(){

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
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ADVERTENCIA!</strong> <span id="msg_erro">Eres menor de edad!</span></div>');

                     }else{
                    	 $('#msg').html('');
                    	 $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Felicidades!</strong> <span id="msg_erro">Edad acepta</span></div>');
                     }

				}

			});


	});
	
	$("#voucher_hash").blur(function(){

		voucher = $(this).val();
		usu = $('#usu_org').val();
		fk_prod = $('#fk_prod').val();
		host = location.host;
		url = 'http://'+host;
		
			$.ajax({
				type: "POST",
				url: url+"/Usuario/get_usu_voucher_ajax",
				data: {usu_voucher:voucher,fk_prod:fk_prod},
				dataType: "json",
				success: function(res){

					if(res.usu_nome != 'erro'){
						
						
						$('#usu_voucher').html('')
						$('#usu_voucher').html('Voucher de: '+res.usu_nome)
						$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Voucher de: '+res.usu_nome+'</span></div>')
						

                     }else{
                    	 $('#voucher_hash').val('')
                    	 $('#usu_voucher').html('')
                    	 $('#usu_voucher').html('Voucher Inválido')
                    	 $('#msg').html('');
                    	 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> <span id="msg_erro">Voucher nao encontrado</span></div>');
                     }

				}

			});


	});
	
	$("#pj_cnpj").blur(function(){

		cnpj = $(this).val();
		host = location.host;
		url = 'http://'+host;


			$.ajax({
				type: "POST",
				url: url+"/Usuario/isset_cnpj_ajax",
				data: {usu_cnpj:cnpj},
				dataType: "text",
				success: function(res){

					if(res == 'nao'){

						$('#pj_cnpj').val('');
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ADVERTENCIA!</strong> <span id="msg_erro">CNPJ inválido o ya existe en nuestro sistema</span></div>');


					}else{

						$('#msg').html('');
						$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Felicidades!</strong> <span id="msg_erro">CNPJ válido</span></div>');

					}

						}

			});


	});
	
	$("#cpf").blur(function(){

		cpf = $(this).val();
		host = location.host;
		url = 'http://'+host;


			$.ajax({
				type: "POST",
				url: url+"/Usuario/isset_cpf_ajax",
				data: {usu_doc:cpf},
				dataType: "text",
				success: function(res){
Advertência
					if(res == 'nao'){

						$('#cpf').val('');
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ADVERTENCIA!</strong> <span id="msg_erro">CPF inválido o ya existe en nuestro sistema</span></div>');


					}else{

						$('#msg').html('');
						$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Felicidades!</strong> <span id="msg_erro">CPF válido</span></div>');

					}

						}

			});


	});
	
	$("#cep").blur(function(){

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
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ADVERTENCIA!</strong> <span id="msg_erro">Código postal no válido</span></div>');
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
                    $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Felicidades!</strong> <span id="msg_erro">Código postal válido</span></div>');
                    }

                        }
                });


	});
	
	$(".forma").change(function(){
		
		forma = $(this).val()
		
		if(forma == 'boleto')
		{
				$('#voucher').hide()
				$('#pagar').hide()
				$('#boleto').show()
		}else{
			
			$('#voucher').show()
			$('#pagar').show()
			$('#boleto').hide()
		}
	});
	
	
	
});


