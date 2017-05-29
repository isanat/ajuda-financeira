interval = 0;
jQuery(function($) {



});

function indicacoes() {
	
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	idPedido = $('#idPedido').val();
	busca = $('#busca').val();
	tipo = $('#tipo').val();
	action = $('#action').val();

	$.ajax({
		type: "POST",
		url: "indicacoes_ajax",
		data: {pagina:pagina,regpag:regpag,idPedido:idPedido,action:action,busca:busca,tipo:tipo},
		dataType: "html",
		success: function(res){
					$('#listar_c').html('');
					$('#listar_c').append(res);
				}
		});			
}

function paginacao_ind(pagina) {
	$('#id').val('');
	$('#action').val('');
	$("#pagina").val(pagina);	
	indicacoes();

}