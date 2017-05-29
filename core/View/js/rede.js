jQuery(function($) {
	$('#myCarousel').carousel({
	    interval: 20000
	})

	$('#autoativacao').click(
	    function() {
			var valor = $('#auto').val();
			if( valor == 0 ) {
			   $('#auto').val('1');
			} else {
			   $('#auto').val('0');
			}
			
			valor = $('#auto').val();
			$.ajax({
				   type: "POST",
				   url: "autoativacao",
				   data: {auto:valor},
				   dataType: "json",
				   success: function(res){
							$('#erro_end').html('');
							$('#erro_end').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button><strong>AUTO ATIVAÇÃO</strong> alterada</div>');
							setTimeout(function(){$('#erro_end').html('');}, 3000 );
						}
					});
	    }
	);
	
	$('#pernaPrefD').click(function(){
		var valor = $('#pernaPrefD').val();
		$('#pernaPref').val(valor);
		gravaPerna();
	});

	$('#pernaPrefE').click(function(){
		var valor = $('#pernaPrefE').val();
		$('#pernaPref').val(valor);
		gravaPerna();
	});

	$('#pernaPrefA').click(function(){
		var valor = $('#pernaPrefA').val();
		$('#pernaPref').val(valor);
		gravaPerna();
	});
	
	function gravaPerna() {
		var perna = $('#pernaPref').val();
		$.ajax({
			   type: "POST",
			   url: "perna",
			   data: {perna:perna},
			   dataType: "json",
			   success: function(res){
						$('#erro_end').html('');
						$('#erro_end').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button><strong>PERNA PREFERENCIAL</strong> alterada</div>');
						setTimeout(function(){$('#erro_end').html('');}, 3000 );
					}
				});
	}
	
	$(".pernaa").blur(function(){

	    perna = $(this).val();	
		
	    $.ajax({
	           type: "POST",
	           url: "perna",
	           data: {perna:perna},
	           dataType: "json",
	           success: function(res){

	                    if(res.model == 'ok'){

							$('#erro').html('');
							$('#erro').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Parabéns!</strong> <span id="msg_erro">Perna Atualizada com sucesso!</span></div>');

	                            }else{
	                            	$('#erro').html('');
	    							$('#erro').html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Advertência!</strong> <span id="msg_erro">Erro ao Alualizar, tente novamente</span></div>');
	                    }

	                        }
	                });

	 });
	
	$( document ).tooltip();

});

function cleanErro() {
	$('#erro_end').html('');
}