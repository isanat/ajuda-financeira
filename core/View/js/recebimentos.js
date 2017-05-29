jQuery(function($) {
 
 // Válidando ContaSuper
 $("#contasuper").livequery('blur', function() {	    
   contasuper = $(this).val();
   re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
   if( re.contasuper == "" || !re.test(contasuper) ){
      $(".msg").html("");
	  $(".msg").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ATENÇÃO! </strong> Informe sua ContaSuper válida.</div>'); return false;
   }else{
      $(".msg").html("");
   }
 });
 
 // Válidando PagSeguro
 $("#pagseguro").livequery('blur', function() {	    
   pagseguro = $(this).val();
   re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
   if( re.pagseguro == "" || !re.test(pagseguro) ){
      $(".msg").html("");
	  $(".msg").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ATENÇÃO! </strong> Informe um E-mail cadastrado no PagSeguro válido.</div>'); return false;
   }else{
      $(".msg").html("");
   }
 });
 
 // Válidando Paypal
 $("#paypal").livequery('blur', function() {	    
   paypal = $(this).val();
   re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
   if( re.paypal == "" || !re.test(paypal) ){
      $(".msg").html("");
	  $(".msg").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ATENÇÃO! </strong> Informe um E-mail cadastrado no Paypal válido.</div>'); return false;
   }else{
      $(".msg").html("");
   }
 });
 
 
 
 $("#criar").livequery('click', function() {
   
   contasuper =  $("#contasuper").val();
   pagseguro = $("#pagseguro").val();
   paypal = $("#paypal").val();
   host = location.host;
   url  = 'http://'+host;
   
  
$.ajax({
	type: "POST",
	url: url+"/Doacoes/cadastrarRecebimentos",
	data: {contasuper:contasuper , pagseguro:pagseguro, paypal:paypal , acao:'cadastrar'},
	dataType: "json",
	success: function(res){

if( res.retorno == 'no'){
     $(".msg").html("");
	 $(".msg").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>ATENÇÃO! </strong> Informe os  Meios de Recebimento</div>'); return false;
 }else{
             
  if( res.retorno == 'update'){
	  $(".msg").html("");
	  $(".msg").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>PARABÉNS! </strong> Seus Meios de Recebimento foram atualizados com sucesso!</div>'); 		  
  }
 if( res.retorno == 'insert'){
     $(".msg").html("");
	 $(".msg").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>PARABÉNS! </strong> Seus Meios de Recebimento foram inseridos com sucesso!</div>'); 
 }
}
		   
  }
});
   
   
   
   
 });

});