

jQuery(function($) {
	
	
	$("#senha").livequery('blur', function() {
		
		host = location.host;
		url = 'http://'+host;
		senha = $(this).val();	
	
	$.ajax({
		type: "POST",
		url: url+'/Senha/alterar_senha',
		data: {senha:senha, confirmar:"ok"},
		dataType: "json",
		success: function(res){		
			if(res.retorno == 'sim'){
				$('#msg').html('');
				$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Senha atual foi confirmada com sucesso.</span></div>');			
			}else{  
			  $("#senha").val("");                  	 
			  $('#msg').html('');
			  $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência! </strong> <span id="msg_erro">Senha atual está incorreta!</span></div>'); 			  
			  return false;
			  
		   }	
	     }	
	  });
   })
	

  $("#psw_nova_c").livequery('blur', function() {
	
	 psw_nova   = $("#psw_nova").val();
	 psw_nova_c = $(this).val();  
	 	  
	 if( psw_nova_c != psw_nova ){
	   $('#msg').html('');
	   $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência! </strong> <span id="msg_erro">Senhas Diferentes!</span></div>'); 
	   $(this).val(""); 
	   return false;	 
   }else{	
	$('#msg').html('');

	}
	  
	  
	})
	

$("#alterar").livequery('click', function() {
	 
	senha      = $("#senha").val();
	psw_nova   = $("#psw_nova").val();
	psw_nova_c = $("#psw_nova_c").val();
	
	if( senha == "" ){
		$('#msg').html('');
		$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência! </strong> <span id="msg_erro">Preencha o campo com sua senha atual!</span></div>'); 
		return false;	 
	}else{
		$('#msg').html('');
	}	 
	
	if( psw_nova == "" ){
		$('#msg').html('');
		$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência! </strong> <span id="msg_erro">Preencha o campo com sua nova senha!</span></div>'); 
		return false;	 
	}else{
		$('#msg').html('');
	}
	
	if( psw_nova_c == "" ){
		$('#msg').html('');
		$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência! </strong> <span id="msg_erro">Preencha o campo com sua senha de confirmação!</span></div>'); 
		return false;	 
	}else{
		$('#msg').html('');
	}
	 
	 host = location.host;
	 url = 'http://'+host;
		
	 $.ajax({
		type: "POST",
		url: url+'/Senha/update_senha_cd',
		data: {psw_nova_c:psw_nova_c, acao:"alterar"},
		dataType: "json",
		success: function(res){			
			if(res.retorno == 'sim'){
				$('#msg').html('');
				$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Senha atualizada com sucesso.</span></div>');	
				$("#senha").val("");
				$("#psw_nova").val("");
				$("#psw_nova_c").val("");						
			}else{                    	 
			  $('#msg').html('');
			  $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência! </strong> <span id="msg_erro">Não foi possível alterar sua senha!</span></div>'); return false;
		   }	
	     }	
	  });
	 
	 
	 
	
	})
	
	
	
	
	

});