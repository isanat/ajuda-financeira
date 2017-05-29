jQuery(function($) {
	
	
	
	
	$(".voucher_hash").blur(function(){

		voucher = $(this).val();
		usu = $('#usu_org').val();
		host = location.host;
		url = 'http://'+host;
		
			$.ajax({
				type: "POST",
				url: url+"/Usuario/get_usu_voucher_ajax",
				data: {usu_voucher:voucher,fk_prod:'2'},
				dataType: "json",
				success: function(res){

					if(res.usu_nome != 'erro'){
						
						
						$('#usu_voucher').html('')
						$('#usu_voucher').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Voucher de: '+res.usu_nome+'</span></div>')
						

                     }else{
                    	 
                    	 $('.voucher_hash').val('');
                    	 $('#usu_voucher').html('');
                    	 $('#usu_voucher').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Voucher inválido</span></div>')
 						 
                    	 
                     }

				}

			});


	});
	



	});
	
	


