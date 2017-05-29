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
$('#whatsapp').focusout(function(){
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

 
 
 
 
$(".nome").blur(function(){
	nome = $(this).val();
	if(nome == ""){
	   $('#msg').html('');
	   $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">O campo Nome não pode ser vazio!</span></div>');
	   return false;
	}else{
		$('#msg').html('');
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

$("#datanasc").blur(function(){

	data = $(this).val();
	host = location.host;
	url = 'http://'+host;
		
	if(data == "" || data == "_/_/__"  ){
		 $('#msg').html('');
		 $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Data de Nascimento não pode ser vazio!</span></div>');
		 return false;
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
 						return false;
                     }else{
                    	 $('#msg').html('');
                     }

				}

			});
		}

	});
	
	
});


