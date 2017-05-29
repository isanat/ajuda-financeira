jQuery(function($) {
	
	
	$("#usuario_deb").blur(function(){
		
		usu = $(this).val();
		
		$.ajax({
			type: "POST",
			url: "ver_usu_deb",
			data: {usu:usu},
			dataType: "json",
			success: function(res){
				
				
						if(res.retorno == 'nao')
						{
							$('#usuario_deb').val('');
							alert('Usuário não Existe');
						
						}else{
							
							
							$('#conta').val(res.res.conta)
						}
						//calcularFrete();
					}
		});
		
		
		
	});
	
$("#gravar").click(function(){
		
	usu = $('#usuario_deb').val();
	conta = $('#conta').val();
	valor = $('#valor').val();
	
	$.ajax({
		type: "POST",
		url: "debitar_forcado",
		data: {conta:conta,valor:valor},
		dataType: "json",
		success: function(res){
			
			
					location.href="http://admmarca.marcaoriginal.com.br/Adm/deb_cred";
				}
	});
		
		
		
	});
	
	
});