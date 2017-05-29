<?php 

require_once('phpmailer/class.phpmailer.php');

class Email
{

	public function enviar(array $dados)
{
	
		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->CharSet="UTF-8";
		$mail->SMTPSecure = 'tls';
		$mail->Host = 'mktcash.com.br';
		$mail->Port = 587;
		$mail->Username = 'contato';
		$mail->Password = 'feedb51e6';
		$mail->SMTPAuth = true;
		
		$mail->From = $dados['usu_email'];
		$mail->FromName = 'Olá '.$dados['usu_usuario'];
		$mail->AddAddress($dados['usu_email']);
		$mail->AddReplyTo($dados['usu_email'], $dados['assunto']);
	
		$mail->IsHTML(true);
		$mail->Subject    = $dados['assunto'];
		$mail->AltBody    = "Seu Visualisador de Email nao suporta HTML, favor visualise em outro Browser!";
		$mail->Body    = $dados['msg'];
	
		if(!$mail->Send())
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function msg_esqueceu_senha(array $dados)
	{
	
		$msg = '
		<table>
		<tr>
		<td>
		  <p><img src="http://'.$_SERVER['HTTP_HOST'].'/module/'.$_SESSION['cliente']['usu_usuario'].'/View/img/logo.png" border="0"/>
		<br /><br />
		Olá <strong>'.$dados['usu_usuario'].'</strong>, </p>
		  <p>você solicitou a mudança de senha, nunca forneça sua senha para terceiros.		  </p>
		  <p>Caso você não tenha feito esta solicitação, por favor ignore este e-mail.</p>
		  <p><br />
		    <strong>Login:</strong> '.$dados['usu_usuario'].' <br /><br />
	      <strong>Nova Senha:</strong> '.$dados['senha'].'</p>
		  <p>Sempre que precisar, entre em contato conosco, estaremos ao seu dispor!		  </p>
		  <p>Atenciosamente,</p>
		  <p>G3Money - Ajuda Mútua Financeira<br>
		    http://g3money10.com.br
          </p>
		  <p><br />
		    <br />
	      </p>
		</td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
  </tr>
		</table>
';

		return $msg;
	
	}
}
