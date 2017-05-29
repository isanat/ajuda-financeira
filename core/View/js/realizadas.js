var interval = 0;

function loadHTML(){
	host = location.host;
	url  = 'http://'+host;
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	busca = $('#busca').val();

	$.ajax({
	type: "POST",
	url: url+"/Doacoes/realizadas_ajax",
	data: {pagina:pagina,regpag:regpag,busca:busca},
	dataType: "html",
	success: function(res){
	  
	   $(".realizadas").html("");
	   $(".realizadas").html(res);
	
	}
	});
}

function paginacao_realizadas(pagina) {
	$("#pagina").val(pagina);	
	loadHTML();
}