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
		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["transactionId"])){
			$transactionId = $_POST["transactionId"];
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
			}
		}
	}