var interval = 0;

jQuery(function($) {
	$( window ).load(function(){
		listar_u();
	
	});
	
	
	

	$("#regpag").change(function(){
		$("#pagina").val(1);
		
		listar_u();
	});
	
	$("#busca").keyup(function(){
		
		// começa a contar o tempo  
        clearInterval(interval); 

        // 500ms após o usuário parar de digitar a função é chamada  
        interval = window.setTimeout(function(){  
			$("#pagina").val(1);
			listar_u();
        }, 500);  

	}); 
	
	$("#ativa").click(function(){
		alert( 'teste' );
		return false;
	});
	
});

function admAtivaBloqueia(id,action) {
	$('#admAtivaBloq').val(id);
	$('#admAtivaBloqAction').val(action);
	listar_u();
}

function paginacao(pagina) {
	$("#pagina").val(pagina);
	listar_u();
}

function listar_u() {
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	admAtivaBloq = $('#admAtivaBloq').val();
	admAtivaBloqAction = $('#admAtivaBloqAction').val();
	busca = $('#busca').val();

	$.ajax({
		type: "POST",
		url: "adm_listar_u_ajax",
		data: {pagina:pagina,regpag:regpag,busca:busca,admAtivaBloq:admAtivaBloq,admAtivaBloqAction:admAtivaBloqAction},
		dataType: "html",
		success: function(res){
					$('#listar_u').html('');
					$('#listar_u').append(res);
				}
		});			
}



