<?php
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
			
			$email = $_SESSION['email'];
			$resources = $_POST;
			$user = get_user_by("email", $email);
			
			$dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
			$bowner = $dwolla_service->dwolla_certify_beneficial_owner($user["customerId"], $resources);			
			echo $bowner;			
		}
	}