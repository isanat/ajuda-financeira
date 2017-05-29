jQuery(function($) {	
	
	$(".list_sub").livequery('click', function(res) {
		pagina = $("#pagina").val();
		id = $(this).attr('id');
		$("#idProd").val(id);
		
		
		$.ajax({
			   type: "POST",
			   url: "list_produtos",
			   data: {id:id,pagina:pagina},
			   dataType: "html",
			   success: function(res){
				   
						$('#produtos').html('');
						$('#produtos').html(res);
						
					}
		});
		
	});
		
		$(".ver_det").livequery('click', function(res) {
			
			nome = $(this).attr('nome');
			det = $(this).attr('det');
			
			$('#detalhesNome').html('');
			$('#detalhes').html('');
			
			$('#detalhesNome').append(nome);
			$('#detalhes').append(det);
			
		});
		
		$(".adicionar").livequery('click', function(res) {
			
			id = $(this).attr('cod');
			action = $(this).attr('action');
			carac = $('#carac'+id).val();
			
			if(carac != '0')
				{
			
			$.ajax({
				   type: "POST",
				   url: "consultor_carrinho",
				   data: {id:id,action:action,carac:carac,qtd:'1'},
				   dataType: "html",
				   success: function(res){
					   
					   	$('#carrinho').html('');
						$('#carrinho').append(res);
							
						}
			});
			
				}else{
					alert('Favor escolha a caracteristica do produto');
					return false;
					}
			
			
			
			
			
		});
		
		
		
		$("#calcular").livequery('click', function(res) {
			 frete = $("#frete").val().replace("-","");
			 $(".valFrete").html("");
			 $("#fecharPedido").hide();
			 $("#loading").show();
		     $.ajax({
					type: "POST",
					url: "calculaFrete",
					data: {frete:frete, acao:"cal"},
					dataType: "json",
					success: function(res){
						$("#loading").hide();
						
						
						if( res.erro == '0' ) {
							
							$("#resFrete").val(res);
							$(".valFrete").html("");
							//alert( res.valor+' | '+res.valorReais );
							$(".valFrete").html("R$ "+res.valorReais);
							$("#valorTotalFrete").val(res.valor);
							//$("#frete").val("");
							

							recalcularTotalPedido();
							
							
							
							$("#fecharPedido").show();
						} else {
							
							if( res.erro == '3' ) {
								$("#resFrete").val();
								$(".valFrete").html("");
								$("#valorTotalFrete").val(0);
								recalcularTotalPedido();
								alert( 'CEP inválido, tente novamente' );
								return false;
							} else {
								$("#resFrete").val();
								$(".valFrete").html("");
								$("#valorTotalFrete").val(0);
								recalcularTotalPedido();
								alert( 'Erro ao consultar o CEP, tente novamente' );
								return false;	
							}
						}
					}
				});
		 

		});
		
		function recalcularTotalPedido() {
			
			valorFrete 		= $("#valorTotalFrete").val();	
			valorProdutos 	= $("#valorTotalProdutos").val();
			
			valorPedido 	= parseFloat( valorFrete )+parseFloat( valorProdutos );
			
			$.ajax({
				type: "POST",
				url: "format_moeda",
				data: {valor:valorPedido},
				dataType: "json",
				success: function(res){
					
					$("#totalProdutosReais").html("");
					$("#totalProdutosReais").append("R$ "+res.valor);
							

						}
			});
			
			//valor = (valorPedido).formatMoney(2, ',', '.');
			
			//var int = getMoney( valorPedido );
			
			//var valor = moeda2float( valorPedido )
			
			
			
		}
		
		
		$("#cepEntrega").livequery('blur', function(res) {
			 
			$("#resFrete").val();
			$(".valFrete").html("");
			$("#valorTotalFrete").val(0);
			recalcularTotalPedido();
			
			$("#loadingEntrega").show();
			var cep = $("#cepEntrega").val();
			cep = cep.replace('-','');
			$.ajax({
				type: "POST",
				url: "../core/lib/correios.php",
				data: {cep:cep, acao:'correios'},
				dataType: "json",
				success: function(res){
							$("#loadingEntrega").hide();
							if(res.uf == ''){
								$("#numeroEntrega").val('');
								$("#complementoEntrega").val('');
								$("#enderecoEntrega").val('');
								$("#bairroEntrega").val('');
								$("#cidadeEntrega").val('');
								$("#estadoEntrega").val('');
								$("#cepEntrega").val('');
								$("#frete").val();
								alert('CEP Inválido...!');
								return false;
							} else {
								$("#frete").val($("#cepEntrega").val());
								$("#numeroEntrega").val('');
								$("#complementoEntrega").val('');
								$("#enderecoEntrega").val(res.logradouro);
								$("#bairroEntrega").val(res.bairro);
								$("#cidadeEntrega").val(res.cidade);
								$("#estadoEntrega").val(res.uf);
								calcularFrete();
								return true;
							}
						}
			});
		});
		

		

	
	
	
});


function updateCarrinho(idProd,funcao) {
	$.ajax({
		type: "POST",
		url: "consultor_carrinho",
		data: {idProd:idProd,funcao:funcao,action:'upd'},
		dataType: "html",
		success: function(res){
					$('#carrinho').html('');
					$('#carrinho').append(res);
					$(".valFrete").html("");
					//calcularFrete();
				}
	});
}

function deletarCarrinho(idProd) {
	if( confirm( 'Deseja remover o produto selecionado do carrinho?' ) ) {
		$.ajax({
			type: "POST",
			url: "consultor_carrinho",
			data: {idProd:idProd,action:'del'},
			dataType: "html",
			success: function(res){
						$('#carrinho').html('');
						$('#carrinho').append(res);
					}
		});
	}
}

function fecharPedido() {
	
	
	if( confirm( 'Deseja fechar o pedido?' ) ) {
		
		cep			= $("#cepEntrega").val();
		endereco 	= $("#enderecoEntrega").val();
		numero 		= $("#numeroEntrega").val();
		complemento	= $("#complementoEntrega").val();
		bairro 		= $("#bairroEntrega").val();
		cidade 		= $("#cidadeEntrega").val();
		estado 		= $("#estadoEntrega").val();
		valFrete = $(".valFrete").html();
		
		
		
	if(valFrete == ""){
		  alert("Calcule o frete antes de finalizar o pedido!"); return false;
	}else{
		
		$.ajax({
			type: "POST",
			url: "consultor_carrinho",
			data: {action:'ped',cep:cep,endereco:endereco,numero:numero,complemento:complemento,bairro:bairro,cidade:cidade,estado:estado},
			dataType: "html",
			success: function(res){
						$('#carrinho').html('');
						$('#carrinho').append(res);
					}
		});
	}	
		
	}	
}




function paginacao_p(valor){ 	
	 $("#pagina").val(valor); 	
		list_prod();		
	};
	
function list_prod(){ 	

	pagina = $("#pagina").val(); 
	id     = $("#idProd").val();
		//alert(pagina +" - "+ id); return false;
		
		$.ajax({
			   type: "POST",
			   url: "list_produtos",
			   data: {id:id,pagina:pagina},
			   dataType: "html",
			   success: function(res){
				   
						$('#produtos').html('');
						$('#produtos').html(res);
						
					}
		});
				
	};
