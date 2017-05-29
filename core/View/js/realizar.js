interval = 0;
jQuery(function($) {
   
    $(".MyContato").livequery('click', function() {
      id = $(this).attr('contact');
	  host = location.host;
	  url  = 'http://'+host;	   
	   
	   $.ajax({
		type: "POST",
		url: url+"/Doacoes/listContatoUsu",
		data: {id:id,acao:'contato'},
		dataType: "html",
		success: function(res){
	      
		   $(".listContato").html("");
		   $(".listContato").html(res);
	  
		}
	   });
	
	});
	
	
	
   $(".banco").livequery('click', function() {
	   
	   id   = $(this).attr("banco");
	   idPed   = $(this).attr("pedId");
	   host = location.host;
	   url  = 'http://'+host;
	   fk_pai = $(this).attr("banco");
	   

// Verificar se o usuário está ativo	
	$.ajax({
		type: "POST",
		url: url+"/Doacoes/verificarUsuAtivo",
		data: {fk_pai:fk_pai,acao:'validar'},
		dataType: "json",
		success: function(res){
						
		   if(res.retorno == "nao"){	
		     $(".cbancaria").html("");
			 $(".cbancaria").html("<span style='color:red'>Usuário não ativo.</span>");
			 $('.bank').html("");
			 $('.bank').html("<span style='color:red'>Para que você possa realizar essa doação este usuário precisa está ativo, aguarde ó usuário se ativar.</span>");
		   }else{
		   
		   // Verificar se o usuário tem alguma conta bancária
			 $.ajax({
				type: "POST",
				url: url+"/Doacoes/validarProxPedSerPago",
				data: {fk_pai:fk_pai,idPed:idPed,acao:'validarPedSerPago'},
				dataType: "html",
				success: function(res){
					$('.bank').html('');
					$('.bank').append(res);	
	
				}		
			});
		
		
		}
	   }		
	});
		
	  
		
	});
	
	
	 $(".comp").livequery('click', function() {
	    doc   = $(this).attr("comp");
		        $("#comprovante").val(doc);
				
		idPed = $(this).attr("pedId");		
		        $("#id_ped").val(idPed);
     });
	
	
 $(".comp").livequery('click', function() {
	id   = $(".banco").attr("banco");
	fk_pai = $(this).attr("comp");	
	fk_ped = $(this).attr("pedId");
	host = location.host;
	url  = 'http://'+host;
		
// Verificar se o usuário está ativo
	$.ajax({
		type: "POST",
		url: url+"/Doacoes/verificarUsuAtivo",
		data: {fk_pai:fk_pai,acao:'validar'},
		dataType: "json",
		success: function(res){
						
if(res.retorno != "sim"){
	
		$(".enviar_comprovante").html("");
		$(".enviar_comprovante").html("<span style='color:red'>Usuário não ativo.</span>");
		$(".validUsuarioMsg").show();
		$(".validUsuarioMsg").html("<span style='color:red'>Para que você possa realizar essa doação este usuário precisa está ativo, aguarde ó usuário se ativar.</span>");
		$(".validCompro").hide();
		return false;
				
}else{
	  
	  
	  
	  
	  
	 $.ajax({
		type: "POST",
		url: url+"/Doacoes/validacaoContaBancaria",
		data: {fk_pai:fk_pai,acao:'list'},
		dataType: "json",
		success: function(res){
			
		  if(res.retorno == "nao"){
			  $(".enviar_comprovante").html("");
			  $(".enviar_comprovante").html("<h2 style='color:red'>Conta Bancária</h2>");
			  $(".validCompro").html("");
			  $(".validCompro").html("<h4 style='color:red'>Nenhuma Conta Bancária Cadastrada</h4>");
			  return false;
		  }	
		  if(res.retorno == "sim"){
			  
			//Valido o comprovante		
			$.ajax({
					type: "POST",
					url: url+"/Doacoes/validaComprovante",
					data: {fk_pai:fk_pai, fk_ped:fk_ped, acao:'validarComp'},
					dataType: "json",
					success: function(res){
				
			// Aguardando o comprovante ser validado
			if(res.dados[0].fk_status_compro == "1"){
				$(".validComproMsg").show();
				$(".validComproMsg").html("");
				$(".validComproMsg").html("<span style='color:red; font-size:15px'>Um comprovante já foi enviado, por favor aguarde a confirmação.</span>");
						
				$(".enviar_comprovante").html("");
				$(".enviar_comprovante").html("<span style='color:red'>Aguardando confirmação do depósito.</span>");	
				$(".validCompro").hide();
			}
					
			// Comprovante válido
			if(res.dados[0].fk_status_compro == "2"){
				$(".validComproMsg").show();
				$(".validComproMsg").html("");
				$(".validComproMsg").html("<span style='color:#666; font-size:15px'>Seu depósito foi confirmado com sucesso, agora você precisa indicar seus 3 Downlines para que você possa está subindo de nível á nível.</span>");
				$(".enviar_comprovante").html("");
				$(".enviar_comprovante").html("<span style='color:#0C3'>Depósito Confirmado.</span>");
				$(".validCompro").hide();
				$(".confirmDoacao").hide();
			}
			
			if(res.dados[0].fk_status_compro == "4"){
			   $("#id_compro").val(res.dados[0].compro_id);
			}		
												
				  }		
			   });	
		
		  }
			
		}
	 });
	
	

}	
			}	  
		  	
      });
		
    });

});