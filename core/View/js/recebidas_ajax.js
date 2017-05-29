function loadHTML(){
	host = location.host;
	url  = 'http://'+host;
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	busca = $('#busca').val();

	$.ajax({
	type: "POST",
	url: url+"/Doacoes/recebidas_ajax",
	data: {pagina:pagina,regpag:regpag,busca:busca},
	dataType: "html",
	success: function(res){	  
	   $(".corpo_recebidas").html("");
	   $(".corpo_recebidas").html(res);
	
	}
	});
}

function paginacao_recebidas(pagina) {
	$("#pagina").val(pagina);	
	loadHTML();
}