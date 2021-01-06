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
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			include_once (__DIR__.'/../services/class.dwolla.php');
			
			$senderEmail = $_SESSION['email'];
			$transaction_id = $_POST['id'];
			$transactions = get_transaction($transaction_id);
			if(empty($transactions)){
				$result = array("status"=>1, "message"=>"Can't find transaction");
				echo json_encode($result);
				exit;						
			}
			$transaction = $transactions[0];
			$transactionName = $transaction["name"];
			$amount = $transaction['amount'];			
			$fee = $transaction['fee'];			
			$netAfterFees = $amount - $fee;
			$amount = $amount / 100;
			$fee = $fee / 100;
			$netAfterFees = $netAfterFees/100;
			$status = $transaction['status'];	
			$senderEmail = $transaction['senderEmail'];
			$receiverEmail = $transaction['receiverEmail'];
					
			
			$user_sender = get_user_by("email", $senderEmail);
			if(empty($user_sender) || empty($user_sender["fundingSourceId"])){
				$result = array("status"=>1, "message"=>"Could not accept transaction because Merchant  is not available.");
				echo json_encode($result);
				exit;					
			}
			$user_receiver = get_user_by("email", $receiverEmail);
			if(empty($user_receiver) || empty($user_receiver["fundingSourceId"])){
				$result = array("status"=>1, "message"=>"Could not accept transaction because you don't have funding source/bank attached to your accound.");
				echo json_encode($result);
				exit;					
			}

			$dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
			$transf_res = json_decode($dwolla_service->createTransaction($user_receiver["fundingSourceId"], $user_sender["fundingSourceId"], $amount, 0));
			if(!isset($transf_res->status)){
				//error_log(print_r($transf_res, true));
				echo json_encode($transf_res);
				exit;
			}				
			$req = sprintf("UPDATE transaction set transferId='%s', status='PROCESSING' WHERE id=%d", $transf_res->data, $transaction_id);
			$query = mysqli_query($db_conx, $req);
			if (!$query) {
				error_log("Failed to save transaction". mysqli_error($db_conx));						
				$result = array("status"=>1, "message"=>"Failed to save transaction");
				echo json_encode($result);
				exit;								
			}else{						
				//sendTransactionAcceptedEmailBuyer ($amount, $fee,  "adamafitini@hotmail.com", "0000");				
				$user = get_user_by("email", $senderEmail);
				$full_name = "";
				if(!empty($user)){
					$full_name = $user["firstName"]." ".$user["lastName"];
					//$transactionName = $user["name"];
				}
				sendTransactionAcceptedEmailMerchant($netAfterFees, $fee, $transactionName, $full_name, $senderEmail, $receiverEmail);				
				sendTransactionAcceptedEmailCustomer($amount, $fee, $transactionName, $full_name, $senderEmail, $receiverEmail);	
				
				$result = array("status"=>0, "message"=>"Payment has been sent successfully");
				echo json_encode($result);
				exit;
			}			
			/*$senderEmail = mysqli_real_escape_string($db_conx, $senderEmail);
			$receiverEmail = mysqli_real_escape_string($db_conx, $receiverEmail);
			$note = mysqli_real_escape_string($db_conx, $note);
			
			$transportation_req = sprintf("INSERT INTO `transaction` (`senderEmail`, `receiverEmail`, `name`, `amount`, `fee`, `status`) VALUES('%s', '%s', '%s', '%s', '%s', '%s')"
			, $senderEmail, $receiverEmail, $note, $amount, $fee, $status);
			$query = mysqli_query($db_conx, $transportation_req);
			if (!$query) {
				error_log("Failed to save transaction". mysqli_error($db_conx)."<br />");						
				$result = array("status"=>1, "message"=>"Failed to save transaction");
				echo json_encode($result);
				exit;								
			}else{						
				sendTransactionCreatedEmail ($amount, $fee,  "adamafitini@hotmail.com", "0000");
				$user = get_user_by("email", "adamafitiniho@gmail.com");
				$full_name = "";
				if(!empty($user)){
					$full_name = $user["firstName"]." ".$user["lastName"];
				}
				sendTransactionCreatedEmailCustomer ($amount, $fee, $full_name, "adamafitini@hotmail.com", $receiverEmail, "0000");			
				$result = array("status"=>0, "message"=>"Request sent successfully");
				echo json_encode($result);
				exit;
			}*/
		}
	}