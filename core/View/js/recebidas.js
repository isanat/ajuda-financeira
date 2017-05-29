interval = 0;

jQuery(function($) {
	
	$(".confirmar").click(function(){	
	 usu   = $(this).attr("usu");
	 valor = $(this).attr("valor");
	 
	 msg = confirm(" Você confirma o pagamento do usuário ( "+usu+" ) no valor de "+valor+" ? ");
	  
	  if(msg == true){	

		idPed    = $(this).attr('idPed');
		idUsu    = $(this).attr('idUsu');
		idCompro = $(this).attr('idCompro');
		host = location.host;
		url = 'http://'+host;
		
		$(".loadC").show();
		
		//alert(location); return false;
		
			$.ajax({
				type: "POST",
				url: url+'/Doacoes/ConfirmarDoacao',
				data: {idPed:idPed,idUsu:idUsu,idCompro:idCompro, acao:'confirmarPag'},
				dataType: "json",
				success: function(res){	
					
					if(res.retorno == "ok"){
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Pagamento confirmado com sucesso.</span></div>'); 
					   
					     $(".loadC").hide();
						 
							clearInterval(interval); 
							interval = window.setTimeout(function(){
								location.href= url+'/Doacoes/recebidas';	
							}, 2000);
						
					}
					else if(res.retorno == "ree"){
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Pagamento confirmado com sucesso.</span></div>'); 
					   
					     $(".loadC").hide();
						  
						  alert("Parabéns! Você alcançou seu objetivo de atingir o 3º nível é agora o sistema irá redirecionar você para tela de login para que você possa entrar novamente com o mesmo usuário e senha de acesso.");
						  
						  
							clearInterval(interval); 
							interval = window.setTimeout(function(){
								location.href= url+'/Backoffice/sair';	
							}, 2000);					
					}
					
					else{
					
					  $('#msg').html('');
					  $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Não foi possível efetuar o pagamento!</span></div>'); return false;
					
					}
				}

			});
	  }
   });
   
   
   $(".cancelarComp").click(function(){	
	 
	 msg = confirm(" Você deseja cancelar esse comprovante ? ");
	 
	 if(msg == true){
		  idCompro = $(this).attr('idCompro');
		  idPed    = $(this).attr('idPed');
		  host = location.host;
		  url = 'http://'+host;
		  
		  
		 $(".load"+idCompro).show(); //return false;
		 $.ajax({
				type: "POST",
				url: url+'/Doacoes/CancelandoComprovante',
				data: {idCompro:idCompro,idPed:idPed, acao:'CancelCompro'},
				dataType: "json",
				success: function(res){	 				  
				 if(res.retorno == "ok"){
					 $(".load"+idCompro).hide(); 
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Comprovante cancelado com sucesso, entre em contato com a pessoa que fez a doação.</span></div>'); 
			
			
					
			clearInterval(interval); 
			interval = window.setTimeout(function(){
				location.href= url+'/Doacoes/recebidas';				
				 }, 2800);  
						
					}else{					
					  $('#msg').html('');
					  $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Não foi possível cancelar esse comprovante!</span></div>'); return false;
					
					}
				
				}
   
          });	  
		  
	 }
   
   });
   
	
});