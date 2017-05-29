jQuery(function($) {
	

	
	$(".editar").click(function(){

		id = $(this).attr('ids');
		valor = $(this).attr('dados');
		
		$("#novo").val(valor);
		$("#antigo").val(id);

	});
	
	$("#gravar").click(function(){

		var cont = 0;
		
			$("#form .required").each(function(){
		         if($(this).val() == "")
		             {
		        	 $(this).css('border-color','red')
		                 cont++;
		             }
		        });
		     if(cont == 0)
		         {
		             $("#form").submit();
		         }
		

	});
	
	$(".caracterisica").on('click', function(e) {
		
		cod = $(this).attr('dados');
		$('#fk_prod').val(cod);
		para = $(this).attr('param');
		host = location.host;
		url = 'http://'+host;
		
		$.ajax({
			type: "POST",
			url: url+'/Produtos/carac_ajax/produto/'+para,
			data: {fk_prod:cod},
			dataType: "html",
			success: function(res){

				$('#carac_list').html('');
				$('#carac_list').html(res);

			}

		});
	
	});
	
		$(".del_carac").on('click', function(e) {
				
				id = $(this).attr('dados');
				host = location.host;
				url = 'http://'+host;
				
				$.ajax({
					type: "POST",
					url: url+'/Produtos/apagar_carac',
					data: {carac_id:id},
					dataType: "html",
					success: function(res){
		//alert(res)
						$('#carac_list').html(res);
		
					}
		
				});
			
			});

	$(".fotos").click(function(){
		
		
		fk_prod = $(this).attr('dados');
		$('#foto_fk_prod').val(fk_prod);
	
	});


		$(".exibe_fotos").on('click', function(e) {
			
			
			cod = $(this).attr('dados');
		
			para = $(this).attr('param');
			host = location.host;
			url = 'http://'+host;
			
			$.ajax({
				type: "POST",
				url: url+'/Produtos/ver_fotos_ajax/produto/'+para,
				data: {pro_cod:cod},
				dataType: "html",
				success: function(res){
		
					$('#tela_fotos').html('');
					$('#tela_fotos').html(res);
		
				}
		
			});
		
		});



		$(".teste").on('click', function(e) {
		
		alert('teste')
		
		});

$("#editar").hide();
$(".editarProd").click(function(){
	
		pro_cod = $(this).attr('dados');
		fk_tipo = $(this).attr('fk_tipo');
		forne = $(this).attr('fornecedor');

		host = location.host;
		url = 'http://'+host;
		
		$.ajax({
			type: "POST",
			url: url+'/Produtos/editar_produto',
			data: {pro_cod:pro_cod,fk_tipo:fk_tipo,forne:forne},
			dataType: "json",
			success: function(res){				
				$("#editar").show();
				$("#inserir").hide();
				$("#idProd").val(res.dados[0].pro_id);				
				$("#edite_nome").val(res.dados[0].pro_nome);
				$("#edite_cod").val(res.dados[0].pro_cod);
				$("#edite_desc").val(res.dados[0].pro_desc);				
			}	
		});		
		
		$.ajax({
			type: "POST",
			url: url+'/Produtos/editar_tipo',
			data: {fk_tipo:fk_tipo},
			dataType: "html",
			success: function(res){				
				$("#edite_prodi").html("");
				$("#edite_prodi").html(res);					
			}	
		});
		
		$.ajax({
			type: "POST",
			url: url+'/Produtos/editar_fornecedor',
			data: {forne:forne},
			dataType: "html",
			success: function(res){			  
			    $("#edite_fornecedor").html("");
				$("#edite_fornecedor").html(res);			
			}	
		});
	
	$("#ocultar").hide();
	
	});


	$("#atualizar").click(function(){
		idProd = $("#idProd").val();
		nome = $("#edite_nome").val();
		cod  = $("#edite_cod").val();
		prod = $("#edite_prodi").val();
		forn = $("#edite_fornecedor").val();
		desc = $("#edite_desc").val();
		
	$.ajax({
			type: "POST",
			url: url+'/Produtos/editar_info_produtos',
			data: {idProd:idProd, nome:nome, cod:cod, prod:prod, forn:forn, desc:desc, acao:"atuala"},
			dataType: "json",
			success: function(res){	
				
if(res.msg == 'sim'){
	$('#msg').html('');
	$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Sua atualização foi atualizada com sucesso!!!</span></div>');			
}else{                    	 
  $('#msg').html('');
  $('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Não foi possível atualizar as informações do produto.</span></div>');
                     }	
			}	
		});		
	});




});