jQuery(function($) {	

 $("#reentrada").click(function() {

    c = confirm("Você realmente deseja criar uma nova conta?");
	
	if(c == true){
	  host = location.host;
	  url  = 'http://'+host;	   
	  
	  $(".carregando").show();
	  
	   $.ajax({
		type: "POST",
		url: url+"/Usuario/reentradaCadastro",
		data: {acao:'reentrada'},
		dataType: "html",
		success: function(res){
		  $(".carregando").hide();
		  $("#contaC").html("");
		  $("#contaC").html("<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Parabéns</strong> Uma nova conta foi criada com sucesso, clique no botão (Visualizar Contas) e navegue nessa nova conta criada.</div>");
		  
		  
		  
		}
	   });
	}else{
	 return false;
	}
	   
	
	});

});