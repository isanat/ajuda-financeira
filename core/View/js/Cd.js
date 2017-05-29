jQuery(function($) {
	
	$('#cpf').focusout(function(){
		var phone, element;
		element = $(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if(phone.length > 11) {
		element.mask("99.999.999/9999-99",{placeholder:" "});
		} else {
		element.mask("999.999.999-99?999",{placeholder:" "});
		}
	}).trigger('focusout');
	
	$("#cep").mask("99999-999",{placeholder:" "});
	
	$(".add").click(function(){
		
		$('#titulo').html('');
		$('#titulo').append('Adicionar CD');
		
		$('#cd_senha').show();
		$('#cpf').show(); 
		
		$('#cd_id').val('');
		$('#cd_nome').val('');
		$('#cd_email').val('');
		$('#cpf').val('');
		$('#cep').val('');
		$('#cd_end').val('');
		$('#cd_n').val('');
		$('#cd_comp').val('');
		$('#cd_bairro').val('');
		$('#cd_cidade').val('');
		$('#cd_uf').val('');
		
	});
	
	$(".editar").click(function(){
		


		id = $(this).attr('ids');
		
	
		host = location.host;
		url = 'http://'+host;
		

			$.ajax({
				type: "POST",
				url: url+"/Cd/editar_ajax",
				data: {id:id},
				dataType: "json",
				success: function(res){

					if(res.retorno == 'sim'){
                    	 
						$('#titulo').html('');
						$('#titulo').append('Editar CD');
						
						$('#cd_senha').hide();
						$('#cpf').hide(); 
						
						$('#cd_id').val(res.dados.cd_id);
						$('#cd_nome').val(res.dados.cd_nome);
						$('#cd_email').val(res.dados.cd_email);
						$('#cpf').val(res.dados.cd_doc);
						$('#cep').val(res.dados.cd_cep);
						$('#cd_end').val(res.dados.cd_end);
						$('#cd_n').val(res.dados.cd_n);
						$('#cd_comp').val(res.dados.cd_comp);
						$('#cd_bairro').val(res.dados.cd_bairro);
						$('#cd_cidade').val(res.dados.cd_cidade);
						$('#cd_uf').val(res.dados.cd_uf);
                     }

				}

			});
			
			
			
		


	});




});