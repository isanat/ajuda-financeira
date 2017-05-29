jQuery(function($) {
	
	$(".perna").change(function(){
		
		perna = $(this).val();
		id = $(this).attr('perna');
		
		
	
	host = location.host;
	url = 'http://'+host;

	$.ajax({
			type: "POST",
			url: url+"/MeusPedidos/pendentes_ajax",
			data: {id:id,perna:perna},
			dataType: "json",
			success: function(res){
				
				if(res.retorno == 'nao'){
					
					$('#msg').html('');
					$('#msg').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">'+res.msg+'</span></div>');

                 }else{
                	 $('#msg').html('');
                	 $('#msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">'+res.msg+'</span></div>');
					 
                 }
					}
			});
	
	});


});