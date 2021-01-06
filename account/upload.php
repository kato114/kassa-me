<?php 
	include_once (__DIR__.'/../inc/header.php'); 
	include_once (__DIR__.'/../services/class.dwolla.php'); 
	
	//echo '<div class="alert alert-success">Entries saved!</div>';
	$user_id = $_SESSION['user_id'] ;
	$user = get_user_by("id",$user_id);
	$full_name = $user["firstName"]." ".$user["lastName"];
	$email = $user["email"];
	$createdAt = $user["createdAt"];
	
	$dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
	
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		/*
		print_r($_POST);
		print_r($_FILES["file"]);
		*/
		$uploadfile = $UPLOADDIR .'/'. basename($_FILES['file']['name']);
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			$accessToken = $dwolla_service->get_token();
			//echo $accessToken;
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api-sandbox.dwolla.com/customers/72e17594-aa2e-4434-9945-22fc74bee10a/documents",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($uploadfile), 'documentType'=>$_POST["type"]),
			  CURLOPT_HTTPHEADER => array(
				"Accept: application/vnd.dwolla.v1.hal+json",
				"Authorization: Bearer $accessToken",
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			//echo $response;
			$json_data = json_decode($response);
			if(isset($json_data->status) || empty($json_data)){
				echo '<div class="alert alert-success" role="alert">Your document has been sent successfully</div>';
			}else{
				$message = $json_data->message;
				if(isset($json_data->_embedded))
					$message = $json_data->_embedded->errors[0]->message;
				echo '<div class="alert alert-danger" role="alert">Upload failed: '.$message.'</div>';
			}
			unlink($uploadfile);
			//return;
		}else{
			echo "File upload failed<br />";	
			//print_r($_FILES);
		}
		
	}	
	$customer = json_decode($dwolla_service->getCustomer($user['customerId']));
	//echo "Status: ".$customer->data->status;	
	if($customer->data->status !="document"){
		echo "No document is required";
		return;
	}else{
	?>
		<div class="container">
			<div class="page-header">
				<h1>Document needed: <small style="color: green;"><?php echo $full_name; ?></small></h1>
			</div>
			<hr />
				<br />
				<center>
					<form id="" method="POST" enctype="multipart/form-data">
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="type">document type</label>
							<div class="col-md-6">
								<select name="type" class="form-control">
									<option value="passport">Passport</option>
									<option value="license">License</option>
									<option value="idCard">idCard</option>
									<option value="other">Other</option>
								</select>
							</div>
						</div>		
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_lastName">File</label>
							<div class="col-md-6">
								<input name="file" type="file" placeholder="" class="" id="file"  required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="contr_lastName"></i>
							</div>
						</div>							
						<input type="hidden" name="certify-beneficial-ownership-url"></input>
						<button type="submit" class="btn btn-primary btn-success" style="" id="bownCertifybtn">Upload document</button>
					</form>
				</center>
		</div>
	
	
	<?php
		
	}
	?>
    <?php include_once (__DIR__.'/../inc/footer.php'); ?>	