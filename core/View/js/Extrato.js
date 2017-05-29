var interval = 0;



function comissao_paginacao(pagina) {
	$("#pagina").val(pagina);
	comissoes();
}

/*function pontuacao() {
	pagina	= $('#pagina').val();
	regpag 	= $('#regpag').val();
	mes 	= $('#mes').val();
	busca 	= $('#busca').val();
	usu_doc = $('#usu_doc').val();

	$.ajax({
		type: "POST",
		url: "pontuacao_ajax",
		data: {pagina:pagina,regpag:regpag,busca:busca,usu_doc:usu_doc,mes:mes},
		dataType: "html",
		success: function(res){
					$('#pontuacao_listar').html('');
					$('#pontuacao_listar').append(res);
				}
		});			
}*/

function comissoes() {
	pagina 	= $('#pagina').val();
	regpag 	= $('#regpag').val();
	mes 	= $('#mes').val();
	busca 	= $('#busca').val();
	usu_doc = $('#usu_doc').val();

	$.ajax({
		type: "POST",
		url: "comissoes_ajax",
		data: {pagina:pagina,regpag:regpag,busca:busca,usu_doc:usu_doc,mes:mes},
		dataType: "html",
		success: function(res){
					$('#comissoes_listar').html('');
					$('#comissoes_listar').append(res);
				}
		});			
}

function pontuacao_paginacao(pagina) {
	$("#pagina").val(pagina);
	pontuacao_e();
	pontuacao_d();
}

function pontuacao_e() {
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	busca = $('#busca').val();
	perna = $('#perna').val();   	
	 
	$.ajax({
		type: "POST",
		url: "pontuacao_e_ajax",
		data: {pagina:pagina,regpag:regpag,busca:busca,perna:perna},
		dataType: "html",
		success: function(res){
         //  alert(res); return false; 
					$('#pontuacao_listar').html('');
					$('#pontuacao_listar').append(res);
				}
		});			
}



function pontuacao_d() {
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	busca = $('#busca').val();
	perna = $('#perna').val(); 
   
	$.ajax({
		type: "POST",
		url: "pontuacao_d_ajax",
		data: {pagina:pagina,regpag:regpag,busca:busca,perna:perna},
		dataType: "html",
		success: function(res){
			//alert("Ok"); return false;
					$('#pontuacao_listar').html('');
					$('#pontuacao_listar').append(res);
				}
		});			
}
