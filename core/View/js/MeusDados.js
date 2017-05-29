var interval = 0;

$('#login-secure-important').stop().animate({width: '0px', opacity: 0}, 1000);
$('#login-secure-warning').stop().animate({width: '0px', opacity: 0}, 1000);
$('#login-secure-success').stop().animate({width: '0px', opacity: 0}, 1000);				
$('#cadastrar').css('display', 'none');

function verificaSenhaAtual() {
	usu_senha = $('#usu_senha').val();
	validaSenhaAtual = 1;
	$.ajax({
		type: "POST",
		url: "alterarsenha_ajax",
		data: {usu_senha:usu_senha,validaSenhaAtual:validaSenhaAtual},
		dataType: "html",
		success: function(res){
					$('#confSenhaAtual').html('');
					$('#confSenhaAtual').append(res);
				}
		});			
}

jQuery(function($) {
$("#fone_celular").mask("(00) 00000-0000");
$("#fone_fixo").mask("(00) 0000-0000");
$("#fone_comercial").mask("(00) 0000-0000");
$("#usu_cpf").mask("000.000.000-00");



	
	$('#fone_celular').focusout(function(){
		var phone, element;
		element = $(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if(phone.length > 10) {
		element.mask("(99) 99999-9999");
		} else {
		element.mask("(99) 9999-999999");
		}
	}).trigger('focusout');
		
	$('#fone_whatsapp').focusout(function(){
		var phone, element;
		element = $(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if(phone.length > 10) {
		element.mask("(99) 99999-9999");
		} else {
		element.mask("(99) 9999-999999");
		}
	}).trigger('focusout');
	
	
	
	$("#usu_senha").keyup(function(){
		// começa a contar o tempo  
		clearInterval(interval); 

		// 500ms após o usuário parar de digitar a função é chamada  
		interval = window.setTimeout(function(){  
			verificaSenhaAtual();
		}, 500);  

	});
	
	$("#cadastrar").click(function(){
		// começa a contar o tempo  
		clearInterval(interval); 
		
		var senhaAtual = $('#usu_senha').val();
		var novaSenha = $('#n_usu_senha').val();
		var confNovaSenha = $('#c_usu_senha').val();
		var alterarSenha = 1;
		
		// 500ms após o usuário parar de digitar a função é chamada  
		interval = window.setTimeout(function(){  
			$.ajax({
				type: "POST",
				url: "alterarsenha_ajax",
				data: {senhaAtual:senhaAtual,novaSenha:novaSenha,confNovaSenha:confNovaSenha,alterarSenha:alterarSenha},
				dataType: "html",
				success: function(res){
							$('#resSenha').html('');
							$('#resSenha').append(res);
						}
				});
		}, 200);  

	});	
	
	$("#n_usu_senha").keyup(function(){
		
		var senha = $('#n_usu_senha').val();
		// começa a contar o tempo  
		clearInterval(interval); 

		// 1000ms após o usuário parar de digitar a função é chamada  
		interval = window.setTimeout(function(){  
			var value = securepass(senha);
			var w = Math.round((value*50)/100);
			if( w <= 0 ) {
				$('#login-secure-important').stop().animate({width: '0px', opacity: 0}, 1000);
				$('#login-secure-warning').stop().animate({width: '0px', opacity: 0}, 1000);
				$('#login-secure-success').stop().animate({width: '0px', opacity: 0}, 1000);
				$('#login-secure-important').html('');
				$('#login-secure-warning').html('');
				$('#login-secure-success').html('');
			}else if (w<=15) {
				$('#login-secure-important').stop().animate({width: '50px', opacity: 1}, 1000);
				$('#login-secure-warning').stop().animate({width: '0px', opacity: 0}, 1000);
				$('#login-secure-success').stop().animate({width: '0px', opacity: 0}, 1000);
				$('#login-secure-important').html('FRACA');
				$('#login-secure-warning').html('');
				$('#login-secure-success').html('');
			} else if (w>=16 && w<=30) {
				//aplica transparência a div vermelha
				$('#login-secure-important').stop().animate({width: '50px', opacity: 1}, 1000);
				$('#login-secure-warning').stop().animate({width: '50px', opacity: 1}, 1000);
				$('#login-secure-success').stop().animate({width: '0px', opacity: 0}, 1000);
				$('#login-secure-warning').html('MÉDIA');
				$('#login-secure-important').html('');
				$('#login-secure-success').html('');
			} else {
				//aplica transparência a div vermelha e amarela
				$('#login-secure-important').stop().animate({width: '50px', opacity: 1}, 1000);
				$('#login-secure-warning').stop().animate({width: '50px', opacity: 1}, 1000);
				$('#login-secure-success').stop().animate({width: '50px', opacity: 1}, 1000);
				$('#login-secure-success').html('FORTE');
				$('#login-secure-important').html('');
				$('#login-secure-warning').html('');
			}
			
			if( verificaSenhaIgual() ) {
				$('#confSenhaNovaAgain').html('<span class="label label-success">OK</span>');
			} else {
				$('#confSenhaNovaAgain').html('<span class="label label-important">AS SENHAS ESTÃO DIFERNTES</span>');	
			}
		}, 100);  
	});
	
	$("#c_usu_senha").keyup(function(){
		// começa a contar o tempo  
		clearInterval(interval); 

		// 500ms após o usuário parar de digitar a função é chamada  
		interval = window.setTimeout(function(){  
			if( verificaSenhaIgual() ) {
				$('#confSenhaNovaAgain').html('<span class="label label-success">OK</span>');
			} else {
				$('#confSenhaNovaAgain').html('<span class="label label-important">AS SENHAS ESTÃO DIFERNTES</span>');	
			}
		}, 100);  

	});	
});


function verificaSenhaIgual() {
	var nova = $("#n_usu_senha").val();
	var novaConf = $("#c_usu_senha").val();
	
	if( nova == novaConf ) {
		$('#cadastrar').css('display', 'inline');
		return true;
	} else {
		$('#cadastrar').css('display', 'none');
		return false;
	}
}
//+------------------------------------------------------------------------+
//| Função para informar o nível de segurança da senha digitada            |
//| Verifica se a senha é fácil                                            |
//+------------------------------------------------------------------------+

function securepass(_value) {
	
	//+-------------------------+
	//| Declaração de variaveis |
	//+-------------------------+
	var level = 0;
	var value = _value.replace(/\s/g,''); 
	var lowerCase = value.search(/[a-z]/);
	var upperCase = value.search(/[A-Z]/);
	var numbers = value.search(/[0-9]/);
  	var specialChars = value.search(/[@!#$%&*+=?|-]/);
  	var aLowerCase = value.split(/[a-z]/);
	var aUpperCase = value.split(/[A-Z]/);
	var aNumbers = value.split(/[0-9]/);
  	var aSpecialChars = value.split(/[@!#$%&*+=?|-]/) ;

	//+------------------------------------+
	//| Verifica o nivel da senha digitada |
	//+------------------------------------+
 	if (_value.length!=0) {
    	if (lowerCase>=0) {level += 10;}
    	if (upperCase>=0) {level += 10;} 
    	if (numbers>=0) {level += 10;}
		if (specialChars>=0) {level += 10;}

		if (aLowerCase.length>2) {level += 5;}
		if (aUpperCase.length>2) {level += 5;}
		if (aNumbers.length>2) {level += 5;}
		if (aSpecialChars.length>2) {level += 10;}
	    
	    if (value.length >= 4) {level += 5;}
      	if (value.length >= 6) {level += 10;}
        if (value.length > 8) {level += 20;}
    }
  
  	return level;
}

//+-------------------------------------------------------+
//| Verifica se a senha pertence a lista de senhas obvias | 
//+-------------------------------------------------------+
function obviuspass(_value) {

	var aPass = new Array('111111','11111111','112233','121212','123123','123456','1234567','12345678','131313','232323','654321','666666','696969','777777','7777777','8675309','987654','aaaaaa','abc123','abc123','abcdef','abgrtyu','access','access14','action','albert','alexis','amanda','amateur','andrea','andrew','angela','angels','animal','anthony','apollo','apples','arsenal','arthur','asdfgh','asdfgh','ashley','asshole','august','austin','badboy','bailey','banana','barney','baseball','batman','beaver','beavis','bigcock','bigdaddy','bigdick','bigdog','bigtits','birdie','bitches','biteme','blazer','blonde','blondes','blowjob','blowme','bond007','bonnie','booboo','booger','boomer','boston','brandon','brandy','braves','brazil','bronco','broncos','bulldog','buster','butter','butthead','calvin','camaro','cameron','canada','captain','carlos','carter','casper','charles','charlie','cheese','chelsea','chester','chicago','chicken','cocacola','coffee','college','compaq','computer','cookie','cooper','corvette','cowboy','cowboys','crystal','cumming','cumshot','dakota','dallas','daniel','danielle','debbie','dennis','diablo','diamond','doctor','doggie','dolphin','dolphins','donald','dragon','dreams','driver','eagle1','eagles','edward','einstein','erotic','extreme','falcon','fender','ferrari','firebird','fishing','florida','flower','flyers','football','forever','freddy','freedom','fucked','fucker','fucking','fuckme','fuckyou','gandalf','gateway','gators','gemini','george','giants','ginger','golden','golfer','gordon','gregory','guitar','gunner','hammer','hannah','hardcore','harley','heather','helpme','hentai','hockey','hooters','horney','hotdog','hunter','hunting','iceman','iloveyou','internet','iwantu','jackie','jackson','jaguar','jasmine','jasper','jennifer','jeremy','jessica','johnny','johnson','jordan','joseph','joshua','junior','justin','killer','knight','ladies','lakers','lauren','leather','legend','letmein','letmein','little','london','lovers','maddog','madison','maggie','magnum','marine','marlboro','martin','marvin','master','matrix','matthew','maverick','maxwell','melissa','member','mercedes','merlin','michael','michelle','mickey','midnight','miller','mistress','monica','monkey','monkey','monster','morgan','mother','mountain','muffin','murphy','mustang','naked','nascar','nathan','naughty','ncc1701','newyork','nicholas','nicole','nipple','nipples','oliver','orange','packers','panther','panties','parker','password','password','password1','password12','password123','patrick','peaches','peanut','pepper','phantom','phoenix','player','please','pookie','porsche','prince','princess','private','purple','pussies','qazwsx','qwerty','qwertyui','rabbit','rachel','racing','raiders','rainbow','ranger','rangers','rebecca','redskins','redsox','redwings','richard','robert','rocket','rosebud','runner','rush2112','russia','samantha','sammy','samson','sandra','saturn','scooby','scooter','scorpio','scorpion','secret','sexsex','shadow','shannon','shaved','sierra','silver','skippy','slayer','smokey','snoopy','soccer','sophie','spanky','sparky','spider','squirt','srinivas','startrek','starwars','steelers','steven','sticky','stupid','success','suckit','summer','sunshine','superman','surfer','swimming','sydney','taylor','tennis','teresa','tester','testing','theman','thomas','thunder','thx1138','tiffany','tigers','tigger','tomcat','toutcard','topgun','toyota','travis','trouble','trustno1','tucker','turtle','twitter','united','vagina','victor','victoria','viking','voodoo','voyager','walter','warrior','welcome','whatever','william','willie','wilson','winner','winston','winter','wizard','xavier','xxxxxx','xxxxxxxx','yamaha','yankee','yankees','yellow','zxcvbn','zxcvbnm','zzzzzz');
	for (var i = 0; i < aPass.length; i++) {
        if (aPass[i] == _value) return true;
    }
    return false;
}