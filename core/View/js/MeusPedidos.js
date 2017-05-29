var interval = 0;

function adm_paginacao_p(pagina) {
	$('#id').val('');
	$('#action').val('');
	$("#pagina").val(pagina);
	meuspedidos_ajax();
}

function meuspedidos_ajax() {
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	idPedido = $('#idPedido').val();
	busca = $('#busca').val();
	tipo = $('#tipo').val();
	action = $('#action').val();

	$.ajax({
		type: "POST",
		url: "meuspedidos_ajax",
		data: {pagina:pagina,regpag:regpag,idPedido:idPedido,action:action,busca:busca,tipo:tipo},
		dataType: "html",
		success: function(res){
					$('#pedidos').html('');
					$('#pedidos').append(res);
				}
		});			
}