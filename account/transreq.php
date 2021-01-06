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
			if(strtoupper($_SESSION['user_role']) === 'RECEIVE_ONLY'){
				error_log("You are not allowed to send this request");						
				$result = array("status"=>1, "message"=>"You are not allowed to send this request");
				echo json_encode($result);
				exit;				
			}			
			$senderEmail = $_SESSION['email'];
			$receiverEmail = $_POST['receiverEmail'];
			$note = $_POST["note"];
			$amount = $_POST['transValue'];
			$amount = floatval($amount);
			//$amount = str_replace(",", "", $amount);
			//$amount = str_replace(".", "", $amount);
			$amount = $amount * 100;
			$fee = 1;
			$fee = $fee * 100;
			$status = "PENDING";	
			
			$senderEmail = mysqli_real_escape_string($db_conx, $senderEmail);
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
				$transactionId = mysqli_insert_id($db_conx);
				$amount = $amount/100;
				$fee = $fee / 100;				
				sendTransactionCreatedEmail ($amount, $fee,  $receiverEmail, $senderEmail, $transactionId);
				$user = get_user_by("email", $senderEmail);
				$full_name = "";
				if(!empty($user)){
					$full_name = $user["firstName"]." ".$user["lastName"];
				}
				sendTransactionCreatedEmailCustomer ($amount, $fee, $full_name, $senderEmail, $receiverEmail, $transactionId);			
				$result = array("status"=>0, "message"=>"Request sent successfully");
				echo json_encode($result);
				exit;
			}
		}
	}