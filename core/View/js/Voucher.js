jQuery(function($) {

	$("#qtd_voucher").blur(function(){
        x = +$(this).val().replace(/\D/g,"");
             $(this).val(x);
       //salert(x);
	})
})
