<?php
// Campos vazios
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }

$name = $_POST['name'];
$email_address = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

// Create the email and send the message
$to = 'contato@dcecatolicasc.com.br'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Robótica de Jaraguá do Sul:  $name";
$email_body = "Você recebeu uma nova mensagem de seu site formulário de contato .\n\n"."Detalhes do Usuario:\n\Nome: $name\n\nE-mail: $email_address\n\nTelefone: $phone\n\nMenssagem:\n$message";
$headers = "Dominio\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Replicação: $email_address";
mail($to,$email_subject,$email_body,$headers);
return true;
?>
