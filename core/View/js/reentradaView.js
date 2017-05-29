interval = 0;

jQuery(function($) {	
		
 $(".docs").click(function() {
	 
  id = $(this).attr("id"); 
  host = location.host;
  url  = 'http://'+host;	   
  
  //alert(location); return false;
  
   $.ajax({
	type: "POST",
	url: url+"/Backoffice/home_msr",
	data: {id:id, acao:'novaconta'},
	dataType: "json",
	success: function(res){
		
	if(res.retorno == "ok"){
	alert("Visualizar todas as informações deste usuário.");	
	clearInterval(interval); 
	interval = window.setTimeout(function(){
		location.href= "http://escritorio.g3money10.com.br/Backoffice/home_msr";
		
		 }, 1000);
	}
	 
	 
	 }
   });

  });

});