var interval = 0;

function admProcessarArquivo(id) {
	$('#id').val(id);
	$('#action').val('processar');
	adm_baixaboleto();
}

function admCancelarProcessamento(id) {
	$('#id').val(id);
	$('#action').val('cancelar');
	adm_baixaboleto();
}

function admExcluirArquivo(id) {
	$('#id').val(id);
	$('#action').val('excluir');
	adm_baixaboleto();
}

function adm_paginacao(pagina) {
	$("#pagina").val(pagina);
	adm_baixaboleto();
}

function adm_paginacao_p(pagina) {
	$('#id').val('');
	$('#action').val('');
	$("#pagina").val(pagina);	
	adm_listar_p();
	adm_listar_c();
}



function adm_paginacao_v(pagina) {
	$('#id').val('');
	$('#action').val('');
	$("#pagina").val(pagina);
	adm_listar_v();
}

function adm_pagar_pedido_c(action,idPedido,tipo) {
	$("#action").val(action);
	$("#idPedido").val(idPedido);
	$("#tipo").val(tipo);
	//alert(tipo);
	adm_listar_c();
}

function adm_pagar_pedido_p(action,idPedido,tipo) {
	$("#action").val(action);
	$("#idPedido").val(idPedido);
	$("#tipo").val(tipo);
	//alert(tipo);
	adm_listar_p();
}

function adm_cancelar_pedido(action,idPedido) {
	$("#action").val(action);
	$("#idPedido").val(idPedido);
	adm_listar_p();
}

function adm_pagar_voucher(action,idPedido) {
	$("#action").val(action);
	$("#idPedido").val(idPedido);
	adm_listar_v();
}

function adm_cancelar_voucher(action,idPedido) {
	$("#action").val(action);
	$("#idPedido").val(idPedido);
	adm_listar_v();
}

function adm_baixaboleto() {
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	id = $('#id').val();
	action = $('#action').val();

	$.ajax({
		type: "POST",
		url: "adm_baixaboleto_ajax",
		data: {pagina:pagina,regpag:regpag,id:id,action:action},
		dataType: "html",
		success: function(res){
					$('#baixaboleto').html('');
					$('#baixaboleto').append(res);
				}
		});			
}

function adm_listar_p() {
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	idPedido = $('#idPedido').val();
	busca = $('#busca').val();
	tipo = $('#tipo').val();
	action = $('#action').val();

	  
	$.ajax({
		type: "POST",
		url: "adm_listar_p_ajax",
		data: {pagina:pagina,regpag:regpag,idPedido:idPedido,action:action,busca:busca,tipo:tipo},
		dataType: "html",
		success: function(res){
					$('#listar_p').html('');
					$('#listar_p').append(res);
					
				}

		});			
}

function adm_listar_c() {
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	idPedido = $('#idPedido').val();
	busca = $('#busca').val();
	tipo = $('#tipo').val();
	action = $('#action').val();

	$.ajax({
		type: "POST",
		url: "adm_listar_c_ajax",
		data: {pagina:pagina,regpag:regpag,idPedido:idPedido,action:action,busca:busca,tipo:tipo},
		dataType: "html",
		success: function(res){
					$('#listar_c').html('');
					$('#listar_c').append(res);
				}
		});			
}


function adm_listar_v() {
	pagina = $('#pagina').val();
	regpag = $('#regpag').val();
	idPedido = $('#idPedido').val();
	tipo = $('#tipo').val();
	busca = $('#busca').val();
	action = $('#action').val();

	$.ajax({
		type: "POST",
		url: "adm_listar_v_ajax",
		data: {pagina:pagina,regpag:regpag,idPedido:idPedido,action:action,busca:busca,tipo:tipo},
		dataType: "html",
		success: function(res){
					$('#listar_v').html('');
					$('#listar_v').append(res);
				}
		});			
}

function modal_id_pedido(id){	

	$.ajax({
		type: "POST",
		url: "modal_pedido_carrinho",
		data: {valor:id, acao:"resCar"},
		dataType: "html",
		success: function(res){
			//alert(res); return false;
			
			
					$('.listInfoCar').html('');
					$('.listInfoCar').append(res);
				}
		});
	
}

function pagar_p(id){	
	
	pagina   = $('#pagina').val();
	regpag   = $('#regpag').val();
	idPedido = $('#idPedido').val();
	tipo     = $('#tipo').val();
	busca    = $('#busca').val();
	action   = $('#action').val();
	
	$.ajax({
		type: "POST",
		url: "adm_listar_p_ajax",
		data: {pagina:pagina, regpag:regpag, idPedido:idPedido, action:action, busca:busca, tipo:tipo, id:id, acao:"alt_cd"},
		dataType: "html",
		success: function(res){			
		
		 //alert(res); return false;
		
 	$('#msg').html('');
	$('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Pedido pago com sucesso.</span></div>');
	
	$('#listar_p').html('');
	$('#listar_p').append(res);			
					
				}
		});
	
}
