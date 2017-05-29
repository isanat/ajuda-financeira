jQuery(function($) {

	

	$(".pagar").livequery('change', function() {
		

		status = $(this).val();
		id = $('.st').attr('st');
		
		$("#form").submit();

	});
	

	/*$("#marcar").livequery('click', function() {
		    
		    
		        $(".marcar").attr("checked",true);
		    
		    
		    $(this).attr('id','desmarcar');
		    
	});
		
	$("#desmarcar").livequery('click', function() {
	    
	    
        $(".marcar").attr("checked",false);
    
    
    $(this).attr('id','marcar');
    
});*/
		
	
	
$("#export").livequery('click', function() {
	
//	host = location.host;
//	url = 'http://'+host;
	
	$("#form").submit();
		
		/*host = location.host;
		url = 'http://'+host;*/
		
		/*camposMarcados = new Array();
		$("input[type=checkbox][name='lista[]']:checked").each(function(){
		    camposMarcados.push($(this).val());
		    

		});*/
		
		/*$.post(url+"/Arquivos/export_saque",{list: camposMarcados},function(data){

		 });*/
		
		


			/*$.ajax({
				type: "POST",
				url: url+"/Relatorios/rel_saque_ajax",
				data: {teste:'teste'},
				dataType: "html",
				success: function(res){
			
					$('#ajax').html('');
					$('#ajax').append(res);
					
					
			
				}
		
			});*/
			
			

		});




});
	
    


  

	
