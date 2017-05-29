var interval = 0;

function adm_paginacao_cd(pagina) {
	$('#id').val('');
	$('#action').val('');
	$("#pagina").val(pagina);	
	adm_listar_cd();
}

function adm_listar_cd() {
	
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	idPedido = $('#idPedido').val();
	busca = $('#busca').val();
	tipo = $('#tipo').val();
	action = $('#action').val();
	
	//alert(busca); return false; 
	
	$.ajax({
		type: "POST",
		url: "entrada_ajax",
		data: {pagina:pagina,regpag:regpag,idPedido:idPedido,action:action,busca:busca,tipo:tipo},
		dataType: "html",
		success: function(res){
			
					$('#listar_p').html('');
					$('#listar_p').append(res);					
				}
		});			
}

function adm_paginacao_cd_saida(pagina) {
	$('#id').val('');
	$('#action').val('');
	$("#pagina").val(pagina);	
	adm_listar_cd();
}

function adm_listar_cd_saida() {
	
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	idPedido = $('#idPedido').val();
	busca = $('#busca').val();
	tipo = $('#tipo').val();
	action = $('#action').val();

	$.ajax({
		type: "POST",
		url: "saida_ajax",
		data: {pagina:pagina,regpag:regpag,idPedido:idPedido,action:action,busca:busca,tipo:tipo},
		dataType: "html",
		success: function(res){
			
					$('#listar_p').html('');
					$('#listar_p').append(res);					
				}
		});			
}



