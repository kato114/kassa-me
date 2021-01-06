<?php
	use TomorrowIdeas\Plaid\Plaid;
	
	include_once(__DIR__."/../php_includes/check_login_status.php");
	include_once(__DIR__."/../php_includes/config.php");
	if($user_ok == false){

		exit();

	}
	
	include_once (__DIR__.'/../services/class.dwolla.php'); 
	
	//print_r($_POST);
	if(isset($_POST["public_token"]) && isset($_POST["metadata"])){
		$public_token = $_POST["public_token"];
		$metadata = $_POST["metadata"];
		
		$institution_name = $metadata["institution"]["name"];
		$account_id = $metadata["account"]["id"];
		$account_name = $metadata["account"]["name"];
		$account_type = $metadata["account"]["type"];
		
		$plaid = new Plaid($PLAID_CLIENT_ID,$PLAID_SECRET,$PLAID_PUBLIC_KEY);
		$plaid->setEnvironment($PLAID_ENV);
		$access_token_req = $plaid->exchangeToken($public_token);
		//print_r($access_token_req);
		if(isset($access_token_req->access_token)){
			try{
				$access_token = $access_token_req->access_token;
				
				$dwolla_plaid_token_req = $plaid->createDwollaToken($access_token, $account_id);
				//print_r($dwolla_plaid_token_req);
				
				if(isset($dwolla_plaid_token_req->processor_token)){
					
				   $dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
				   
				   /*$data = $dwolla_service->getCusromerSource($_SESSION['customerId']);
					$json_data = json_decode($data);
					if(isset($json_data->data->{"_embedded"}->{"funding-sources"})){
						foreach($json_data->data->{"_embedded"}->{"funding-sources"} as $fndSrc){		
							$funSrc_id = $fndSrc->id;
						   $del_funSrc = json_decode($dwolla_service->deleteFundingSource($funSrc_id));
						   if(!isset($del_funSrc->status)){
							   //echo $json_result->message;
								$result = array("status"=>1, "message"=>$del_funSrc->message);
								echo json_encode($result);				   
								exit;
						   }
						}
						
					}*/						   
				   $existing_id = "";
				   $fundingSource_result = $dwolla_service->addFundingSource($_SESSION['customerId'], $dwolla_plaid_token_req->processor_token, $account_name);
				   $json_result = json_decode($fundingSource_result);
				   if(!isset($json_result->status)){
					   //echo $json_result->message;
					   if(isset($json_result->code) && $json_result->code==='DuplicateResource'){
						   $message = $json_result->message;
						   $existing_id = substr($message, strpos($message, "id="));
						   $existing_id = str_replace("id=", "", $existing_id );
						   //$existing_id = $json_result->id;
						   
					   }else{
						$result = array("status"=>1, "message"=>$json_result->message);
						echo json_encode($result);				   
						exit;
					  }
				   }
				   
				   
				   $sql = "Update users set fundingSourceId='".(empty($existing_id)?$json_result->data:$existing_id)."', updatedAt=now(), plaidAccountId='$account_id', plaidToken ='".$access_token."'
				     where email='".$_SESSION["email"]."'";
				   $query = mysqli_query($db_conx, $sql);
				   if (!$query) 
				   {
						$result = array("status"=>1, "message"=>"data error");
						error_log(mysqli_error($db_conx));
						error_log($sql);
						echo json_encode($result);
						exit;
				   }
				   if(mysqli_affected_rows($db_conx)>0)
				   {
					   $_SESSION['fundingSourceId'] = (empty($existing_id)?$json_result->data:$existing_id);
					   unset($_SESSION['balance_obj']);
					   $message="Your Funding source '$institution_name' has been added";

					   $result = array("status"=>0, "message"=>$message);
					   echo json_encode($result);
					   exit;	
				   }else{
					   $message="Incorrect user details.";

					   $result = array("status"=>1, "message"=>$message);
					   echo json_encode($result);
					   exit;				   
				   }			   
				   //echo "fundingSource_result";
				   //print_r($json_result);
				}else{
					   $result = array("status"=>1, "message"=>"Can't access PLAID");
					   echo json_encode($result);
					   exit;				
				}
			}catch(\Exception $err){
				//print_r($err->getResponse());
				error_log("Error Global");
				$result = array("status"=>1, "message"=>$err->getMessage()/*$err->getResponse()->error_message*/);
				echo json_encode($result);
				exit;						
			}				
		 
		}else{
				   $result = array("status"=>1, "message"=>"Can't access PLAID token");
				   echo json_encode($result);
				   exit;				
			}
		
		
	}
