<?php
use TomorrowIdeas\Plaid\Plaid;
include_once(__DIR__."/../php_includes/config.php");
include_once(__DIR__."/../php_includes/check_login_status.php");
include_once(__DIR__."/../inc/functions.php");
/*
sendTransactionCreatedEmail (120, 3, "adamafitiniho@gmail.com", "1110000");
sendTransactionCreatedEmailCustomer (120, 3, "Sako Adams", "adamafitiniho@gmail.com", "adamafitini@hotmail.com", "1110000");
*/
/*
			include_once '../services/class.dwolla.php';
			$dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
			$resources = array();
			$verify = $dwolla_service->dwolla_verify("0000", $resources);			
			echo $verify;
			*/
			/*
		try{
			$plaid = new Plaid($PLAID_CLIENT_ID,$PLAID_SECRET,$PLAID_PUBLIC_KEY);
			$plaid->setEnvironment($PLAID_ENV);		
			//print_r($plaid);
			$user = get_user_by("email", $_SESSION["email"]);
			//print_r($user);
			$plaidToken  = $user['plaidToken'];
			$plaidAccountId = $user['plaidAccountId'];
			$balance = $plaid->getBalance($plaidToken);
			print_r($balance);
		}catch(\Exception $err){
			print_r($err->getResponse());
		}
		*/
/*
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.demo.convergepay.com/hosted-payments/transaction_token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "ssl_merchant_id=011493&ssl_user_id=webpage&ssl_pin=MDA2H3&ssl_transaction_type=ccsale&ssl_amount=10",
  CURLOPT_HTTPHEADER => array(
    "origin: ",
    "Content-Type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);
if (!curl_errno($curl)) {
  $info = curl_getinfo($curl);
  echo 'Took ', $info['total_time'], ' seconds to send a request to ', $info['url'], "\n";
  print_r($info);
}
curl_close($curl);
echo $response;
*/
	/*
			include_once '../services/class.dwolla.php';
			$dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
			$resources = array();
			$data = $dwolla_service->getCusromerSource($_SESSION['customerId']);			
			print_r($data);
			$json_data = json_decode($data);
			if(isset($json_data->data->{"_embedded"}->{"funding-sources"})){
				foreach($json_data->data->{"_embedded"}->{"funding-sources"} as $fndSrc){
					echo "fndSrc=>".$fndSrc->id."<br />";
				}
				
			}
			*/
			/*$req = sprintf("UPDATE users set is_active=%d", 1);
			$query = mysqli_query($db_conx, $req);
			if (!$query) {
				error_log("Failed to save transaction". mysqli_error($db_conx));
				echo "Failed to save transaction". mysqli_error($db_conx);		
			}else{				
				echo "all user activated!";
			}*/
			$email = "jessica@360bizvue.com";
			/*
			$condition = "AND (senderEmail='$email' or receiverEmail='$email' or moneySenderEmail='$email')";
			$transactions = get_transaction(52, $condition);	
			print_r($transactions);		
			*/
			/*$req = sprintf("UPDATE users set is_active=%d", 1);
			$query = mysqli_query($db_conx, $req);
			if (!$query) {
				error_log("Failed to save transaction". mysqli_error($db_conx));
				echo "Failed to save transaction". mysqli_error($db_conx);		
			}else{				
				echo "all user activated!";
			}			
			$user = get_user_by("email", $email);
			print_r($user);			
			*/
			$transactions = get_transaction(67, $condition);	
			print_r($transactions);				