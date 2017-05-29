Number.prototype.formatMoney = function(c, d, t){
var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function adicionarCarrinho(id, qtd) {
	var valor = $("#prod"+id+" option:selected").val();
	
	$.ajax({
		type: "POST",
		url: "consultor_carrinho",
		data: {valor:valor, qtd:qtd,action:'add'},
		dataType: "html",
		success: function(res){
					$('#carrinho').html('');
					$('#carrinho').append(res);
				}
	});
}



function adicionarProdutoCarrinho(id) {
	var valor = $("#prod"+id).val();
		
	$.ajax({
		type: "POST",
		url: "consultor_carrinho",
		data: {valor:valor, qtd:'1',action:'add'},
		dataType: "html",
		success: function(res){
					$('#carrinho').html('');
					$('#carrinho').append(res);
				}
	});
}

function trocaFoto(id) {
	foto = $("#perfume"+id+" option:selected").val();
	foto = foto.split(':');
	
	$("#foto"+id).attr("src","http://loja.balsamoperfumes.com.br/View/front/image/cache/grande/"+foto[2] );
	$("#foto"+id).width( '150' );
	$("#foto"+id).height( '150' );	
}











/* PAGINAÇÃO LOJA CONSULTOR*/
function listarProdutos(categoria) {	

//alert(categoria); return false;
	$.ajax({
		type: "POST",
		url: "consultor_produtos",
		data: {categoria:categoria},
		dataType: "html",
		success: function(res){
			
					$('#produtos').html('');
					$('#produtos').append(res);
				}
	});
	
}



}