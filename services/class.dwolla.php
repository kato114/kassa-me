<?php
require "vendor/autoload.php";

class SA_dwolla {
	
	private $client_id = "";
	private $client_secret = "";
    function __construct($endpoint, $client_id, $client_secret) {
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
        $this->endpoint = $endpoint;
		
		$access_token = $this->get_token();
		DwollaSwagger\Configuration::$access_token = $access_token;
		$this->apiClient = new DwollaSwagger\ApiClient($this->endpoint);		
    }	
	function get_token(){
		
		$curl = curl_init();

		//$client_id = "yze52MHs8wFFGNTtk9JXf4kdZ9bjqQsczzeHNXFph6K9u3KZTN";
		//$client_secret = "0ZHxrUzzMzyCDj7rEPSdvmHq0Tq8HxVklUynSSTrvlgDtRIrMB";

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api-sandbox.dwolla.com/token",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 10,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "grant_type=client_credentials",
		  CURLOPT_HTTPHEADER => array(
			"Authorization: Basic ".base64_encode($this->client_id .":". $this->client_secret),
			"Content-Type: application/x-www-form-urlencoded"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		//echo $response;
		$json_date = json_decode($response);
		$token = "";
		if(isset($json_date->access_token)){
			
			$token = $json_date->access_token;
		}
		return $token;		
	}
	function addFundingSource($customer_id, $plaid_token, $name){
		try{
			  $bankData=array(
				"name"=>$name,
				"plaidToken"=> $plaid_token
			  );

				$fsApi = new DwollaSwagger\FundingsourcesApi($this->apiClient);

				$create_customer_fundSrc = $fsApi->createCustomerFundingSource($bankData, $customer_id);
				
				//return $updated_customer ;
				$result = array("status"=>0, "message"=>"success", "data"=>$create_customer_fundSrc);
				return json_encode($result);				
		}catch(\Exception $err){
			//return $err->getMessage();
			$result = $err->getResponseBody();
			error_log($result);
			return $result;			
		}		
	}
	function deleteFundingSource($id){
		try{
				//$bankData=['removed' => true ];

				$fsApi = new DwollaSwagger\FundingsourcesApi($this->apiClient);

				$del_fundSrc = $fsApi->softDelete(['removed' => true ] ,$id);
				
				//return $updated_customer ;
				$result = array("status"=>0, "message"=>"success", "data"=>$del_fundSrc);
				return json_encode($result);				
		}catch(\Exception $err){
			//return $err->getMessage();
			$result = $err->getResponseBody();
			return $result;			
		}		
	}	
	function getFundingSource($id){
		try{
			
			if(empty($id))
			{
				$result = array("status"=>1, "message"=>"No Liked account");
				return json_encode($result);				
			}

				$fsApi = new DwollaSwagger\FundingsourcesApi($this->apiClient);

				$fundingSource = $fsApi->id($id);
				//$fundingSource->name; # => "Test checking account"
				
				//return $updated_customer ;
				$result = array("status"=>0, "message"=>"success", "data"=>$fundingSource);
				return json_encode($result);				
		}catch(\Exception $err){
			//return $err->getMessage();
			error_log($err);
			$result = array("status"=>1, "message"=>$err->getResponseBody());
			return json_encode($result);			
		}		
	}
	function getCusromerSource($id){
		try{
			

				$fsApi = new DwollaSwagger\FundingsourcesApi($this->apiClient);

				$fundingSource = $fsApi->getCustomerFundingSources($id);
				//$fundingSource->name; # => "Test checking account"
				
				//return $updated_customer ;
				$result = array("status"=>0, "message"=>"success", "data"=>$fundingSource);
				return json_encode($result);				
		}catch(\Exception $err){
			//return $err->getMessage();
			error_log($err);
			$result = array("status"=>1, "message"=>$err->getResponseBody(), "more"=>$err->getMessage());
			return json_encode($result);			
		}		
	}	
	function createTransaction($src_foundSourceId, $dst_foundSourceId, $amount, $fee){
		try{
			
				$transfer_request = array (
				  '_links' =>
				  array (
					'source' =>
					array (
					  'href' => 'https://api-sandbox.dwolla.com/funding-sources/'.$src_foundSourceId,
					),
					'destination' =>
					array (
					  'href' => 'https://api-sandbox.dwolla.com/funding-sources/'.$dst_foundSourceId,
					),
				  ),
				  'amount' =>
				  array (
					'currency' => 'USD',
					'value' => $amount,
				  )
				);
				//error_log(print_r($transfer_request, true));
				$transferApi = new DwollaSwagger\TransfersApi($this->apiClient);
				$transfer = $transferApi->create($transfer_request);
				
				$result = array("status"=>0, "message"=>"success", "data"=>$transfer);
				return json_encode($result);				
		}catch(\Exception $err){
			error_log($err->getResponseBody());	
			return $err->getResponseBody();				
		}		
	}
	function createCustomerUnverRecev($firstName, $lastName, $email, $type){
		try{
				$customersApi = new DwollaSwagger\CustomersApi($this->apiClient);
				$customer = null;
				if($type === 'receive_only'){
					$customer = $customersApi->create([
					  'firstName' => $firstName,
					  'lastName' => $lastName,
					  'email' => $email,
					  'type' => 'receive-only'
					]);	
				}if($type === 'unverified'){
					$customer = $customersApi->create([
					  'firstName' => $firstName,
					  'lastName' => $lastName,
					  'email' => $email,
					  'type'=> 'unverified'
					]);					
				}
		
				$result = array("status"=>0, "message"=>"success", "data"=>$customer);
				return json_encode($result);				
		}catch(\Exception $err){
			//return $err->getMessage();
			/*$result = array("status"=>1, "message"=>$err);
			return json_encode($result);
			*/
			return $err->getResponseBody();		
		}
		
	}	
	function createCustomerPersoBusi($firstName, $lastName, $email, $type, $data){
		try{
				$originalDate = $data["dateOfBirth"];
				$dateOfBirth = date("Y-m-d", strtotime($originalDate));
				error_log($dateOfBirth);
				
				$customersApi = new DwollaSwagger\CustomersApi($this->apiClient);
				$customer = null;
				if($type === 'personal'){
					$customer = $customersApi->create([
					  'firstName' => $firstName,
					  'lastName' => $lastName,
					  'email' => $email,
					  'type' => 'personal',
					  'address1' => $data['address1'],
					  'city' => $data['city'],
					  'state' => $data['state'],
					  'postalCode' => $data['postalCode'],
					  'dateOfBirth' => $dateOfBirth,
					  'ssn' => $data['ssn']					  
					]);	
				}if($type === 'business'){
					$customer = $customersApi->create([
					  'firstName' => $firstName,
					  'lastName' => $lastName,
					  'email' => $email,
					  'type' => 'business',
					  'address1' => $data['address1'],
					  'city' => $data['city'],
					  'state' => $data['state'],
					  'postalCode' => $data['postalCode'],
					  'dateOfBirth' => $dateOfBirth,
					  'ssn' => $data['ssn'],
					  'businessClassification' => $data['businessClassification'],
					  'businessType' => 'soleProprietorship',//$data['ssn'],
					  'businessName' => $data['businessName'],
					  'ein' => $data['ein']					  
					]);					
				}
		
				$result = array("status"=>0, "message"=>"success", "data"=>$customer);
				return json_encode($result);				
		}catch(\Exception $err){
			//return $err->getMessage();
			/*$result = array("status"=>1, "message"=>$err);
			return json_encode($result);
			*/
			return $err->getResponseBody();		
		}
		
	}	
	function getCustomer($customerID){
		try{
				$customerAPI = new DwollaSwagger\CustomersApi($this->apiClient);
				$customer = $customerAPI->getCustomer($customerID);			
		
				$result = array("status"=>0, "message"=>"success", "data"=>$customer);
				return json_encode($result);				
		}catch(\Exception $err){
			//return $err->getMessage();
			return $err->getResponseBody();			
		}
		
	}
	function dwolla_verify_lite($customerId, $resources){
		try{
				
				$customersApi = new DwollaSwagger\CustomersApi($this->apiClient);
				$updated_customer = $customersApi->updateCustomer([
					'phone' => '3334447777',
					'email' => $resources["email"],
					'address1' => '99-99 33rd St',
					'address2' => '',
					'city' => 'Some City',
					'state' => 'NY',
					'postalCode' => '11101',
					'ipAddress' => '143.156.7.8',
					'type'=>'personal',
					'firstName' => $resources["firstName"],
					'lastName' => $resources["lastName"],
					'dateOfBirth' => '1970-01-01',
					'ssn' => '1234'],					
					$customerId);
			
					//return $updated_customer ;
					$result = array("status"=>0, "message"=>"success");
					error_log(print_r($result, true));
					return json_encode($result);				
		}catch(\Exception $err){
			//return $err->getMessage();
			error_log($err->getResponseBody());
			$result = $err->getResponseBody(); //array("status"=>1, "message"=>$err->getResponseBody());
			//$result["status"] = 1;
			return $result; //json_encode($result);			
		}
		
	}	
	function dwolla_verify($customerId, $resources){
		try{
				
				//$customerUrl = $this->endpoint."/".$path; //'https://api-sandbox.dwolla.com/customers/'.$_POST["customer_id"];
				/*	
					error_log(print_r(array(
					'firstName' => $resources["firstName"],
					'lastName' => $resources["lastName"],
					'email' => $resources["email"],
					'ipAddress' => $resources["ipAddress"],
					'type' => 'business',
					'dateOfBirth' => $resources["dateOfBirth"],
					'ssn' => $resources["ssn"],
					'address1' => $resources["address"],
					'city' => $resources["city"],
					'state' => $resources["state"],
					'postalCode' => $resources["postalCode"],
					'businessClassification' => $resources["businessClassification"],
					'businessType' => $resources['businessType'],
					'businessName' => $resources["businessName"],
					'ein' => $resources["ein"]), true));				
				*/
				$customersApi = new DwollaSwagger\CustomersApi($this->apiClient);
				$updated_customer = $customersApi->updateCustomer([
					'firstName' => $resources["firstName"],
					'lastName' => $resources["lastName"],
					'email' => $resources["email"],
					'ipAddress' => $resources["ipAddress"],
					//'type' => 'business',
					//'dateOfBirth' => $resources["dateOfBirth"],
					//'ssn' => $resources["ssn"],
					'address1' => $resources["address"],
					'city' => $resources["city"],
					'state' => $resources["state"],
					'postalCode' => $resources["postalCode"],
					'businessClassification' => $resources["businessClassification"],
					'businessType' => $resources['businessType'],
					'businessName' => $resources["businessName"],
					'ein' => $resources["ein"],
					'controller' =>
					  [
						  'firstName' => $resources['contr_firstName'],
						  'lastName'=> $resources['contr_lastName'],
						  'title' => $resources['contr_title'],
						  'dateOfBirth' => $resources['contr_dob'],
						  'ssn' => '1234', //$resources['1234'],
						  'address' =>
						  [
							  'address1' => $resources['contr_address'],
							  'address2' => '',
							  'city' => $resources['contr_city'],
							  'stateProvinceRegion' => $resources['contr_state'],
							  'postalCode' => $resources['contr_postalCode'],
							  'country' => 'US'
						  ],
					  ]], $customerId);
			
					//return $updated_customer ;
					$result = array("status"=>0, "message"=>"success");
					return json_encode($result);				
		}catch(\Exception $err){
			//return $err->getMessage();
			error_log($err->getResponseBody());
			$result = $err->getResponseBody(); //array("status"=>1, "message"=>$err->getResponseBody());
			//$result["status"] = 1;
			return $result; //json_encode($result);			
		}
		
	}
	function list_business_classfied(){
		
		try{
			$businessClassificationsApi = new DwollaSwagger\BusinessclassificationsApi($this->apiClient);

			$busClassifications = $businessClassificationsApi->_list();
			$busClassifications->_embedded->{'business-classifications'}[0]->name; # => "Food retail and service"
			/*foreach($busClassifications->_embedded->{'business-classifications'} as $bc){
				echo $bc->name."<br />";
			}
			
			print_r($busClassifications);
			*/
			return $busClassifications;
		}catch(\Exception $err){
			//return $err->getMessage();
			error_log($err->getResponseBody());
			$result = $err->getResponseBody(); //array("status"=>1, "message"=>$err->getResponseBody());
			//$result["status"] = 1;
			echo $err->getResponseBody();
			return array(); //json_encode($result);			
		}			
	}
	
}