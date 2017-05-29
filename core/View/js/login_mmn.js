jQuery(function($) {
	
	//$("#esqueceu_cpf").mask("999.999.999-99",{placeholder:" "});
	
	$("#esqueceu").click(function(){

		email       = $("#esqueceu_email").val();
		usu_usuario = $("#usu_usuario").val();
		host = location.host;
		url = 'http://'+host;
		
		$('#msg_esqueceu').html('');
		$('#msg_esqueceu').append('<img src="'+url+'/core/View/img/load.gif">');		

			$.ajax({
				type: "POST",
				url: url+'/Backoffice/esqueceu',
				data: {email:email,usu_usuario:usu_usuario},
				dataType: "json",
				success: function(res){
					if(res.retorno == 1){
						
						
						$('#msg_esqueceu').html('');
						$('#msg_esqueceu').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns, '+res.usuario+'!</strong> <span id="msg_erro">Uma nova senha foi enviada para o Email: '+res.email+'</span></div>');
						
                     }else{
                    	 $('#msg_esqueceu').html('');
                    	 $('#msg_esqueceu').append('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Dados Inválidos</span></div>');
                     }

				}

			});


	});
	
	
	
});