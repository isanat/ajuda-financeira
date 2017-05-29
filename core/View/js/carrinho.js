jQuery(function($) {

	$(".qty").blur(function(){
            qtd_voucher = +$(this).val().replace(/\D/g,"");
			voucher_id  = $("#voucher_id").val();
			end = (location.href);
/*
		 $.ajax({
		   type: "POST",
		   url: end,
		   data: {voucher_id:voucher_id, qtd_voucher:qtd_voucher},
		   success: function(res){
				$('#testando').html('');
				$('#testando').append(res);
		   }
		});*/
});

});

