<?php
ini_set('display_errors',1);
require_once('class.phpmailer.php');

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
$mail->FromName = 'Mohammad Masoudian';
$mail->AddAddress('designimpressoes@hotmail.com');
$mail->AddReplyTo('designimpressoes@hotmail.com', 'Information');

$mail->IsHTML(true);
$mail->Subject    = "PHPMailer Test Subject via Sendmail, basic";
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$mail->Body    = "Hello";

if(!$mail->Send())
{
  echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
  echo "Message sent!";
}
?>