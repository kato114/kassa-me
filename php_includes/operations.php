<?php
include_once("php_includes/config.php");
include_once("db_conx.php");
//include_once("emails.php");
include_once("check_login_status.php");
	
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/Exception.php');
require_once('PHPMailer/src/SMTP.php');
require_once('PHPMailer/src/POP3.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
	

function append_log($text)
{
			$extra='['.date("l jS \of F Y h:i:s A").'] ';
			$myfile = file_put_contents('../logs.txt', $extra.'' .$text.PHP_EOL , FILE_APPEND);	
}	
function update_session_message($session_title, $session_content)
{
	
	 $_SESSION["message_title"]=$session_title;
	 $_SESSION["message_content"]=$session_content;	
}
function send_email($subject, $message, $to)
{


	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);
	$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = $smtp_server;
	$mail->Port = $smtp_port; // or 587
	$mail->IsHTML(true);
	$mail->Username = $smtp_username;
	$mail->Password = $smtp_password;
	$mail->SetFrom($smtp_username, "Clinic App");
	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->AddAddress($to);

	 if(!$mail->Send()) {
		append_log("Mailer Error: " . $mail->ErrorInfo);
		return 0;
	 } else {
		append_log("Message has been sent");
		return 1;
	}
}
?>