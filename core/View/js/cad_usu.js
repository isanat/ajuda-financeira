jQuery(function($) {

$("#celular").mask("(00) 0000-0000");
$("#fixo").mask("(00) 0000-0000");
$("#comercial").mask("(00) 0000-0000");
$("#cpf").mask("000.000.000-00");
$("#datanasc").mask("00/00/0000");
$("#cep").mask("00000-000");
$("#whatsapp").mask("(99) 99999-9999");


	
	$('#celular').focusout(function(){
		var phone, element;
		element = $(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if(phone.length > 10) {
		element.mask("(99) 99999-9999");
		} else {
		element.mask("(99) 9999-999999");
		}
	}).trigger('focusout');


 $('#whatsapp').focusout(function(){
		var phone, element;
		element = $(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if(phone.length > 10) {
		element.mask("(99) 99999-9999");
		} else {
		element.mask("(99) 9999-999999");
		}
	}).trigger('focusout');
	
	
	$("#usuario").blur(function(){

		usu = $(this).val()
		.replace(/[á|ã|â|à]/gi, "a").replace(/[é|ê|è]/gi, "e").replace(/[í|ì|î]/gi, "i").replace(/[õ|ò|ó|ô]/gi, "o")
		.replace(/[ú|ù|û]/gi, "u").replace(/[ç]/gi, "c").replace(/[ñ]/gi, "n").replace(/[á|ã|â]/gi, "a").replace(/[~]/gi, "")
		.replace(/[ ]/gi, "").toLowerCase();
	    $(this).val(usu);
	
		host = location.host;
		url = 'http://'+host;	
		
		if(usu != ""){
			$.ajax({
				type: "POST",
				url: url+'/Usuario/isset_usuario_ajax',
				data: {usu_usuario:usu},
				dataType: "text",
				success: function(res){

					if(res == 'sim'){						
						$('#usuario').val('');
						$('#msg').html('');
						$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Usuário já existe</span></div>'); return false;
                     }else{
                    	 $('#msg').html('');
                    	 $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">nome de usuário aceito em nosso sistema</span></div>');
                     }
				}
			});
		}else{
		$('#msg').html('');
		$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo Usuário</span></div>'); return false;
		
		}
	});
	
	$("#nome").blur(function(){

		usu = $(this).val();
		host = location.host;
		url = 'http://'+host;	
		
		if(usu != ""){
			$('#msg').html('');
			$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Nome Completo preenchido com sucesso.</span></div>');
       
		}else{
		$('#msg').html('');
		$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">O campo Nome Completo não pode está vazio.</span></div>'); return false;
		
		}
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

	});
	
	
	
	$("#email").blur(function(){

		email = $(this).val();
		host = location.host;
		url = 'http://'+host;
		
if(email != ""){
	er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/; 
	if( !er.exec(email) )
	{
		$('#msg').html('');
		$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Email Inválido</span></div>');
		$(this).val("");
		return false;
	}
			
		   }else{
		  $('#msg').html('');
		  $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo de Email</span></div>'); return false;
		  
		  }
        });
		
		
  $("#datanasc").blur(function(){

		data = $(this).val();
		host = location.host;
		url = 'http://'+host;

		if(data != ""){		
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
		}else{
		  $('#msg').html('');
		  $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo de Email</span></div>'); return false;
		
		}

	});

	$("#cep").blur(function(){

		cep = $(this).val().replace('-','')
		host = location.host;
		url = 'http://'+host;
		$(".loadCarr").show();
		if(cep != ""){
           $.ajax({
           type: "POST",
           url: url+"/Usuario/get_cep_ajax",
           data: {end_cep:cep},
           dataType: "json",
           success: function(res){

                    if(res.uf == ''){

						$('#erroCep').html('');
						$('#erroCep').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">CEP Inválido</span></div>');
						$('#uf').val('')
	                    $('#cidade').val('')
	                    $('#bairro').val('')
	                    $('#end').val('');
						$(".loadCarr").hide();

                            }else{
                    $('#erroCep').html('');
                    $('#uf').val(res.uf)
                    $('#cidade').val(res.cidade)
                    $('#bairro').val(res.bairro)
                    $('#end').val(res.logradouro)
                    $('#erroCep').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">CEP válido</span></div>');
					$(".loadCarr").hide();
                    }

                        }
                });
		}else{
		 $('#erroCep').html('');
		 $('#erroCep').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo de Email</span></div>'); return false;
		
		}
	 });
	
	
  $("#repitasenha").blur(function(){

		conf = $(this).val();
		senha = $("#senha").val();


			if(conf != senha){

				$('#msgsenha').html('');
				$('#msgsenha').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Senhas Diferentes</span></div>');
				$(this).val('');
				$("#senha").val('');

			}else{

				$('#msgsenha').html('');				

			}
});
  
  $(".sexom").click(function(){
   $(this).val('m');  
   $(this).attr("checked", true);
   $(".sexof").val("");
  });
  
  
  $(".sexof").click(function(){
   $(this).val('f');  
   $(this).attr("checked", true);
   $(".sexom").val("");
  });
  
  
   $(".cadastrar").click(function(){
       usuario  = $("#usuario").val();
	   nome     = $("#nome").val();
	   cpf      = $("#cpf").val().replace('.','').replace('.','').replace('-','').replace(' ','');
	   email    = $("#email").val();
	   sexom    = $(".sexom").val();
	   sexof    = $(".sexof").val();
	   datanasc = $("#datanasc").val();
	   cep      = $("#cep").val().replace('-','').replace(' ','');
	   end      = $("#end").val();
	   numero   = $("#numero").val();
	   bairro   = $("#bairro").val();
	   cidade   = $("#cidade").val();
	   uf       = $("#uf").val();
	   celular  = $("#celular").val().replace('(','').replace(')','').replace('-','').replace(' ','');
	   whatsapp = $("#whatsapp").val().replace('(','').replace(')','').replace('-','').replace(' ','');
	   fixo     = $("#fixo").val().replace('(','').replace(')','').replace('-','').replace(' ','');
	   comercial= $("#comercial").val().replace('(','').replace(')','').replace('-','').replace(' ','');
	   senha    = $("#senha").val();
	   repitasenha = $("#repitasenha").val();
     
	  //alert(sexof+ " - " +sexom); return false;
	  
	  sexo = (sexom != "") ? sexom : sexof;
	  
	  if(usuario == ""){
				$('#msg').html('');
				$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo Usuário.</span></div>'); return false;
      }else{ $('#msg').html(''); }
	  
	  if(nome == ""){
				$('#msg').html('');
				$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo Nome.</span></div>'); return false;
      }else{ $('#msg').html(''); }
	  
	  if(cpf == ""){
				$('#msg').html('');
				$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo CPF.</span></div>'); return false;
      }else{ $('#msg').html(''); }
	  
	  if(email == ""){
				$('#msg').html('');
				$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo E-mail.</span></div>'); return false;
      }else{ $('#msg').html(''); }
	  
	  if(sexom == "" && sexof == ""){
				$('#msgsexo').html('');
				$('#msgsexo').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Escolha um Sexo.</span></div>'); return false;
      }else{ $('#msgsexo').html(''); }
	  
	   if(datanasc == ""){
				$('#msg').html('');
				$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo da Data de Nascimento.</span></div>'); return false;
      }else{ $('#msg').html(''); }
	  
	  if(cep == ""){
				$('#erroCep').html('');
				$('#erroCep').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo do CEP.</span></div>'); return false;
      }else{ $('#erroCep').html(''); }
	  
	  if(end == ""){
				$('#erroCep').html('');
				$('#erroCep').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo de Endereço.</span></div>'); return false;
      }else{ $('#erroCep').html(''); }
	  
	  if(numero == ""){
				$('#erroCep').html('');
				$('#erroCep').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo do Número.</span></div>'); return false;
      }else{ $('#erroCep').html(''); }
	  
	   if(bairro == ""){
				$('#erroCep').html('');
				$('#erroCep').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo do Bairro.</span></div>'); return false;
      }else{ $('#erroCep').html(''); }
	  
	  if(cidade == ""){
				$('#erroCep').html('');
				$('#erroCep').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo da Cidade.</span></div>'); return false;
      }else{ $('#erroCep').html(''); }
	  
	  if(uf == ""){
				$('#erroCep').html('');
				$('#erroCep').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo UF.</span></div>'); return false;
      }else{ $('#erroCep').html(''); }
	  
	  if(celular == ""){
				$('#msgfone').html('');
				$('#msgfone').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo Celular.</span></div>'); return false;
      }else{ $('#msgfone').html(''); }

	  
	  if(senha == ""){
				$('#msgsenha').html('');
				$('#msgsenha').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo Senha.</span></div>'); return false;
      }else{ $('#msgsenha').html(''); }
	  
	  if(repitasenha == ""){
				$('#msgsenha').html('');
				$('#msgsenha').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Preencha o campo Repetir Senha.</span></div>'); return false;
      }else{ $('#msgsenha').html(''); }
	  
	  $(".carregar").show();
	  host = location.host;
	  url = 'http://'+host;
	  
  
	  $.ajax({
				type: "POST",
				url: url+"/Cadastro/cad_usu",
				data: {
					usuario:usuario,
					nome:nome,
					cpf:cpf,
					email:email,
					sexof:sexof,
					sexom:sexom,
					datanasc:datanasc,
					cep:cep,
					end:end,
					numero:numero,
					bairro:bairro,
					cidade:cidade,
					uf:uf,
					celular:celular,
					whatsapp:whatsapp,
					fixo:fixo,
					comercial:comercial,
					senha:senha,
					repitasenha:repitasenha,
					acao:'cadastrar'
					},
				dataType: "text",
				success: function(res){
		
	if(res == 'sim'){					
									
	$('#msgsenha').html('');
	$('#msgsenha').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>PARABÉNS!</strong> <span id="msg_erro">Olá <strong>'+usuario+'</strong> Seu cadastro foi efetuado com sucesso, favor confirmar no e-mail: <strong>'+email+'</strong> desejamos boa sorte!!</span></div>');
	$('#msg').html('');
	$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>PARABÉNS!</strong> <span id="msg_erro">Olá <strong>'+usuario+'</strong> Seu cadastro foi efetuado com sucesso, favor confirmar no e-mail: <strong>'+email+'</strong> desejamos boa sorte!!</span></div>');
	
	   $("#usuario").val("");
	   $("#nome").val("");
	   $("#cpf").val("");
	   $("#email").val("");
	   $(".sexom").val("");
	   $(".sexof").val("");
	   $("#datanasc").val("");
	   $("#cep").val("");
	   $("#end").val("");
	   $("#numero").val("");
	   $("#bairro").val("");
	   $("#cidade").val("");
	   $("#uf").val("");
	   $("#celular").val("");
	   $("#fixo").val("");
	   $("#comercial").val("");
	   $("#whatsapp").val("");
	   $("#senha").val("");
	   $("#repitasenha").val("");
	   $(".carregar").hide();		
		 		
}if(res == 'nao'){
	
	 $('#msgsenha').html('');
	 $('#msgsenha').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ATENÇÃO!</strong> <span id="msg_erro">Por favor tente fazer o cadastro mais tarde, no momento não temos usuários ativos para receber o seu cadastro. O volume de cadastro está mais rápido do que as pessoas conseguem concretizarem as doações. O sistema e verdadeiramente um SUCESSO!</span></div>');
	 
	 $('#msg').html('');
	 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ATENÇÃO!</strong> <span id="msg_erro">Por favor tente fazer o cadastro mais tarde, no momento não temos usuários ativos para receber o seu cadastro. O volume de cadastro está mais rápido do que as pessoas conseguem concretizarem as doações. O sistema e verdadeiramente um SUCESSO!</span></div>');
 }
if(res != 'sim' && res == 'nao'){
	
	 $('#msgsenha').html('');
	 $('#msgsenha').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ATENÇÃO!</strong> <span id="msg_erro">Você precisa informa um e-mail válido para que você possa finalizar seu cadastro.</span></div>');
	 
	 $('#msg').html('');
	 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ATENÇÃO!</strong> <span id="msg_erro">Você precisa informa um e-mail válido para que você possa finalizar seu cadastro</span></div>');
                     }

				}

			});
	 
	   
   
   })



	
});