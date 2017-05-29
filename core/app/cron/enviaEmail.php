<?php
include_once( '../../../core/config/DataMapper.php' );
include_once( '../../../core/config/Banco.php' );
include_once( '../../../core/app/Model/Repository/PedidosRepository.php' );
include_once( '../../../core/app/Model/Entity/TbPedidos.php' );

require_once('phpmailer/class.phpmailer.php');

$path = "config/";
$diretorio = dir($path);

$logPontos['pontos_e'] = 0;
$logPontos['pontos_d'] = 0;
$logPontos['media_perc'] = 0;
$logPontos['valor_bonus'] = 0;
$logPontos['valor_credito'] = 0;
$contaMedia = 0;
$totalMedia = 0;


//executa a pontuaï¿½ï¿½o em cada cliente configurado no diretorio config
while($arquivo = $diretorio -> read()){ //loop no diretorio de configuraï¿½ï¿½o, por cliente
	if( ( $arquivo != '.' ) and ( $arquivo != '..' ) ) { //ignora os index do diretorio
		include_once( 'config/'.$arquivo ); //inclui o arquivo de config do cliente

		$pedidos = new TbPedidos;
		$dadosPedidos = $pedidos->selecionaPedidos();
		
		foreach( $dadosPedidos as $linhaPedido ) {
			$msg = '
                	<table>
                    	<tr>
                        	<td>
                            	<img src="http://mmn.futurusempreendedor.com/module/futurus/View/img/logo.png" border="0"/>
                                <br /><br />
                                Palavra do Presidente
                                <br /><br />
                                Olá '.$linhaPedido['usu_nome'].', parabéns pela decisão em reescrever a sua história, e de nos deixar fazer parte neste processo de novas conquistas.
                                <br /><br />
                                A Futurus Empreendedor estará ao seu lado com o compromisso de auxilia-lo rumo a esta mudança. Saiba que toda mudança exige algum sacrifício, esteja disposto a virar a mesa e juntos construiremos uma bela história de superação e sucesso.
                                <br /><br />
                                Seu passado são páginas viradas e o seu futuro são apenas páginas em branco onde iremos escrever  uma nova história com a sua própria caligrafia.
                                <br /><br />
                                Não perca os treinamentos e decida VENCER!             
                                <br /><br />
                                 "A melhor maneira de recuperar o tempo perdido é não perder mais tempo"
                                <br /><br />
                                Então corra e se qualifique ativando seu binário ainda hoje.
                                <br /><br />
                                Seja muito bem vindo, aos melhores anos de sua vida.
                                <br /><br />
                                <br /><br />                                
                                Seu link de divulgação http://www.futurusempreendedor.com/'.$linhaPedido['usu_usuario'].'
                                <br /><br />
                                <br /><br />
                                <br /><br />                                
                                Click <a href="http://www.httpag.com.br/boleto/?token=MDU0NWE2M2ZhNjczOTZjNjM3NjY2OGZjMWY4ZmI2MDY=&cli=futurus&ped='.$linhaPedido['ped_transid'].'">aqui</a> e gere seu boleto.
                                <br /><br />
                                <br /><br />
                                <br /><br />                                
	                            Humberto Mendes
                                <br /><br />                            
                                Pres. Futurus Empreendedor 
                            </td>
						</tr>
                    </table>';
			echo $linhaPedido['usu_email'];
			echo $msg;
			echo "<br>";
			echo "<hr noshade>";
			echo "<br>";
			
			
			
		/*
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet="UTF-8";
		$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->Username = 'contato@futurusempreendedor.com';
		$mail->Password = 'maconaria1';
		$mail->SMTPAuth = true;
		
		$mail->From = 'contato@futurusempreendedor.com';
		$mail->FromName = 'Futurus Empreendedor';
		$mail->AddAddress($email);
		$mail->AddReplyTo($email, 'Bem Vindo');
		
		$mail->IsHTML(true);
		$mail->Subject    = "Bem Vindo a Futurus";
		$mail->AltBody    = $msg;
		$mail->Body    = $msg;
		
		if(!$mail->Send())
		{
		  echo "Nao enviado: " . $mail->ErrorInfo;
		}
		else
		{
		  echo "Enviado com sucesso!";
		}
		*/
			
			
			
			
			
			
		}
	}
}
?>