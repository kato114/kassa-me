<?php
use TomorrowIdeas\Plaid\Plaid;
require (__DIR__.'/../services/vendor/autoload.php'); 
use \SendGrid\Mail\From as From;
use \SendGrid\Mail\To as To;
use \SendGrid\Mail\Subject as Subject;
use \SendGrid\Mail\PlainTextContent as PlainTextContent;
use \SendGrid\Mail\HtmlContent as HtmlContent;
use \SendGrid\Mail\Mail as Mail;

function get_user_transactions($email, $db_conxdition=""){
	
		global $db_conx;	
		$result= array();
		$email = mysqli_escape_string($db_conx, $email);
		
		$sql = "SELECT * FROM `transaction`  where (senderEmail='$email' or receiverEmail='$email' or moneySenderEmail='$email')  $db_conxdition ";
		//echo $sql;
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			error_log(mysqli_error($db_conx));
			return $result;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result[]=$row;
		}
			   
		return $result;	
}
function get_transaction($id, $db_conxdition=""){
	
		global $db_conx;	
		$result= array();
		
		$sql = "SELECT * FROM `transaction`  where id=$id  $db_conxdition ";
		//echo $sql;
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			error_log(mysqli_error($db_conx));
			return $result;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result[]=$row;
		}
			   
		return $result;	
}
function get_user_by($field, $value, $db_conxdition=""){
	
		global $db_conx;	
		$result= array();
		$value = mysqli_escape_string($db_conx, $value);
		
		$sql = "SELECT * FROM `users`  where $field='$value'  $db_conxdition ";
		//echo $sql;
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			error_log(mysqli_error($db_conx));
			return $result;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result=$row;
			return $result;	
		}
			   
		return $result;	
}
function format_money($value, $currency="$"){
	
	return sprintf("%s%.2f", $currency, $value);
}
function sendTransactionCreatedEmail ($amount, $fee, $moneyReceiverEmail, $moneySenderEmail, $transactionId){

  global $SENDGRID_API_KEY;
  $total = $amount - $fee;
  $netAfterFees = format_money($total);
  $amount = format_money($amount);


  $from = new From("support@kassame.com", "Kassa Me Support");  
  $tos = [
		new To(
			$moneySenderEmail,
			$moneySenderEmail,
			[
				'receiverEmail' => $moneyReceiverEmail,
				'amount' => $amount,
				'transactionId'=>$transactionId
			]
		)
	];
	$email = new Mail(
		$from,
		$tos
	);
	$sendgrid = new \SendGrid($SENDGRID_API_KEY);	
	$email->setTemplateId("d-0ad339b7f77241de85806a298b9678d2");
	//$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
	try {
		$response = $sendgrid->send($email);
		/*print $response->statusCode() . "\n";
		print_r($response->headers());
		print $response->body() . "\n";
		*/
		//echo "Message sent<br />";
	} catch (Exception $e) {
		//echo 'Caught exception: '.  $e->getMessage(). "\n";
		error_log('Caught exception: '.  $e->getMessage(). "\n");
	}
}
function sendTransactionCreatedEmailCustomer($amount, $fee, $moneyReceiverName, $moneyReceiverEmail, $moneySenderEmail, $transactionId){

  global $SENDGRID_API_KEY;
  $total = $amount - $fee;
  $netAfterFees = format_money($total);
  $amount = format_money($amount);
  //$moneySenderEmail = "adamafitini@hotmail.com";
  //return;
  $from = new From("support@kassame.com", "Kassa Me Support");  
  $tos = [
		new To(
			$moneySenderEmail,
			$moneySenderEmail,
			[
				'senderName' => $moneyReceiverName,
				'senderEmail' => $moneyReceiverEmail,
				'amount' => $amount,
				'transactionId'=>$transactionId
			]
		),
	];
	$email = new Mail(
		$from,
		$tos
	);
	$sendgrid = new \SendGrid($SENDGRID_API_KEY);	
	$email->setTemplateId("d-89a3dee5f08d488c801da51dffb247e7");
	//$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
	try {
		$response = $sendgrid->send($email);
		//echo "Message sent<br />";
		/*print $response->statusCode() . "\n";
		print_r($response->headers());
		print $response->body() . "\n";
		*/
	} catch (Exception $e) {
		//echo 'Caught exception: '.  $e->getMessage(). "\n";
		error_log('Caught exception: '.  $e->getMessage(). "\n");
	}
}
function sendVerificationCode($verificationCode, $to_email){

  global $SENDGRID_API_KEY;
  $from = new From("support@kassame.com", "Kassa Me Support"); 	
  $tos = [
		new To(
			$to_email,
			$to_email,
			[
				'verificationCode' => $verificationCode,
			]
		),
	];
	$email = new Mail(
		$from,
		$tos
	); 
	$sendgrid = new \SendGrid($SENDGRID_API_KEY);	
	$email->setTemplateId("d-9f8e5df89e244f3885195f63f92b7a42");
	try {
		$response = $sendgrid->send($email);
		$result = array("status"=>0, "message"=>"The email has been sent");
		return json_encode($result);		

	} catch (Exception $e) {
		error_log('Caught exception: '.  $e->getMessage(). "\n");
		$result = array("status"=>1, "message"=>"The email was not sent");
		return json_encode($result);		
	}	
}
function sendPasswordResetToken($token, $to_email){

  global $SENDGRID_API_KEY;
  $from = new From("support@kassame.com", "Kassa Me Support"); 	
  $tos = [
		new To(
			$to_email,
			$to_email,
			[
				'passwordResetToken' => $token,
			]
		),
	];
	$email = new Mail(
		$from,
		$tos
	); 
	$sendgrid = new \SendGrid($SENDGRID_API_KEY);	
	$email->setTemplateId("d-af2a98eb62e84c6a8b38cb7e6de7210c");
	try {
		$response = $sendgrid->send($email);
		$result = array("status"=>0, "message"=>"The email has been sent");
		return json_encode($result);		

	} catch (Exception $e) {
		error_log('Caught exception: '.  $e->getMessage(). "\n");
		$result = array("status"=>1, "message"=>"The email was not sent");
		return json_encode($result);		
	}	
}
function sendTransactionAcceptedEmailCustomer($amount, $fee, $transactionName, $moneyReceiverName, $moneyReceiverEmail, $moneySenderEmail){

  global $SENDGRID_API_KEY;
  $from = new From("support@kassame.com", "Kassa Me Support"); 	
  $tos = [
		new To(
			$moneySenderEmail,
			$moneySenderEmail,
			[
				'senderName' => $moneyReceiverName,
				'senderEmail' => $moneyReceiverEmail,
				'amount' => $amount,
				'transactionName'=> $transactionName
			]
		),
	];
	$email = new Mail(
		$from,
		$tos
	); 
	$sendgrid = new \SendGrid($SENDGRID_API_KEY);	
	$email->setTemplateId("d-f83c3b2bbf6d451e84538265895e8d1c");
	try {
		$response = $sendgrid->send($email);
		$result = array("status"=>0, "message"=>"The email has been sent");
		return json_encode($result);		

	} catch (Exception $e) {
		error_log('Caught exception: '.  $e->getMessage(). "\n");
		$result = array("status"=>1, "message"=>"The email was not sent");
		return json_encode($result);		
	}	
}
function sendTransactionAcceptedEmailMerchant($amount, $fee, $transactionName, $moneyReceiverName, $moneyReceiverEmail, $moneySenderEmail){

  global $SENDGRID_API_KEY;
  $from = new From("support@kassame.com", "Kassa Me Support"); 	
  $tos = [
		new To(
			$moneyReceiverEmail,
			$moneyReceiverEmail,
			[
				'receiverEmail'=> $moneySenderEmail,
				'transactionName'=>$transactionName,
				'amount'=> $amount,				
			]
		),
	];
	$email = new Mail(
		$from,
		$tos
	); 
	$sendgrid = new \SendGrid($SENDGRID_API_KEY);	
	$email->setTemplateId("d-af74eb3233594f2691ac2c79f26e9c8b");
	try {
		$response = $sendgrid->send($email);
		$result = array("status"=>0, "message"=>"The email has been sent");
		return json_encode($result);		

	} catch (Exception $e) {
		error_log('Caught exception: '.  $e->getMessage(). "\n");
		$result = array("status"=>1, "message"=>"The email was not sent");
		return json_encode($result);		
	}	
}
function getCustomerbalance($email=""){
		if(isset($_SESSION['balance_obj']))
		{
			return $_SESSION['balance_obj'];
		}
		global $PLAID_CLIENT_ID,$PLAID_SECRET,$PLAID_PUBLIC_KEY, $PLAID_ENV;
		try{
			$plaid = new Plaid($PLAID_CLIENT_ID,$PLAID_SECRET,$PLAID_PUBLIC_KEY);
			$plaid->setEnvironment($PLAID_ENV);		
			//print_r($plaid);
			if(empty($email))
				$email = $_SESSION["email"];
			$user = get_user_by("email", $email);
			//print_r($user);
			$plaidToken  = $user['plaidToken'];
			if(empty($plaidToken)){
				return array();
			}
			$plaidAccountId = $user['plaidAccountId'];
			$balance = $plaid->getBalance($plaidToken, array("account_ids"=>[$plaidAccountId]));
			$_SESSION['balance_obj'] = $balance;
			return $balance;	
		}catch(\Exception $err){
			error_log(print_r($err->getResponse(), true));
			return array();
		}
}