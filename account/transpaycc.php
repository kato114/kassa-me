<?php
/*
  Change static email later

*/
	sleep(2);
	include_once(__DIR__."/../php_includes/check_login_status.php");
	include_once(__DIR__."/../php_includes/config.php");
	include_once(__DIR__."/../inc/functions.php");
	if($user_ok == false){

		exit();

	}
	if($user_ok ===true){
		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["id"])){
			$transactionId = $_POST["id"];
			$transactions = get_transaction($transactionId);
			if(empty($transactions)){
				$result = array("status"=>1, "message"=>"Can't find transaction");
				echo json_encode($result);
				exit;				
			}
			$transaction = $transactions[0];
			$senderEmail = $_SESSION['email'];
			$receiverEmail = $transaction['receiverEmail'];
			$note = $transaction["name"];
			$amount = $transaction['amount'];
			$amount = $amount/100;
			$fee = $transaction['fee'];
			$fee = $fee / 100;
			$status = $transaction['status'];	
			
			$senderEmail = mysqli_real_escape_string($db_conx, $senderEmail);
			$receiverEmail = mysqli_real_escape_string($db_conx, $receiverEmail);
			$note = mysqli_real_escape_string($db_conx, $note);
			

			if ($status !== 'PENDING') {					
				$result = array("status"=>1, "message"=>"Incorrect request");
				echo json_encode($result);
				exit;								
			}else{		
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
				  CURLOPT_POSTFIELDS => "ssl_merchant_id=".$SSL_MERCHANT_ID."&ssl_user_id=".$SSL_USER_ID."&ssl_pin=".$SSL_PIN."&ssl_transaction_type=".$SSL_TRANSACTION_TYPE."&ssl_amount=".$amount,
				  CURLOPT_HTTPHEADER => array(
					"origin: ",
					"Content-Type: application/x-www-form-urlencoded"
				  ),
				));

				$response = curl_exec($curl);
				if (!curl_errno($curl)) {
					$info = curl_getinfo($curl);
					
					$http_code = $info["http_code"];
					$message = $http_code;
					if($http_code  == 403){
						$message = $http_code. " Forbidden";
					}
					//print_r($info);
					$result = array("status"=>1, "message"=>$message);
					echo json_encode($result);
					exit;				  
				}
				curl_close($curl);
				//echo $response;			
				
				$result = array("status"=>0, "message"=>"Token generated successfully", "token"=>$response);
				echo json_encode($result);
				exit;					
				/*
				sendTransactionCreatedEmail ($amount, $fee,  $senderEmail, "0000");
				$user = get_user_by("email", $senderEmail);
				$full_name = "";
				if(!empty($user)){
					$full_name = $user["firstName"]." ".$user["lastName"];
				}
				sendTransactionCreatedEmailCustomer ($amount, $fee, $full_name, $senderEmail, $receiverEmail, "0000");			
				$result = array("status"=>0, "message"=>"Request sent successfully");
				echo json_encode($result);
				exit;
				*/
			}
		}else{
				$result = array("status"=>1, "message"=>"Unknow error");
				echo json_encode($result);
				exit;				
		}
	}