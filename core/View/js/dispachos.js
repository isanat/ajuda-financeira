function paginacao(pagina) {
	$("#pagina").val(pagina);
	$('#busca').val();
	dispachos();
}

function dispachos() {
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	busca = $('#busca').val();

	
	$.ajax({
		type: "POST",
		url: "dispachos_ajax",
		data: {pagina:pagina,busca:busca,regpag:regpag},
		dataType: "html",
		success: function(res){			
					$('#listar_dispachos').html('');
					$('#listar_dispachos').append(res);
				}
		});			
}


