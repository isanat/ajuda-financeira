interval = 0;
jQuery(function($) {
	
	$(".confirm").click(function(){
		 doar = $(this).attr('doar');
	    alert( doar ); return false;
	})
	
	
});

function confirmarAdm( doc, id ) {
	
	
	$.ajax({
		type: "POST",
		url: "confirmaDoacaoAdm",
		data: {id:id,doc:doc,acao:"ok"},
		dataType: "html",
		success: function(res){
					
					alert("Pagamento confirmado com sucesso.");
					
				}
		});
	
	
}



function doacoesAdm() {

	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	idPedido = $('#idPedido').val();
	busca = $('#busca').val();
	tipo = $('#tipo').val();
	action = $('#action').val();

	$.ajax({
		type: "POST",
		url: "doacoesAdm_ajax",
		data: {pagina:pagina,regpag:regpag,idPedido:idPedido,action:action,busca:busca,tipo:tipo},
		dataType: "html",
		success: function(res){
					$('#listar_c').html('');
					$('#listar_c').append(res);
				}
		});			
}

function paginacao_doarAdm(pagina) {
	$('#id').val('');
	$('#action').val('');
	$("#pagina").val(pagina);	
	doacoesAdm();

}