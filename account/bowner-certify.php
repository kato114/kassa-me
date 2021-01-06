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
	$customer = json_decode($dwolla_service->getCustomer($user['customerId']));
	if(!isset($customer->data->_links->{"certify-beneficial-ownership"})){
		echo "No certification is required";
		return;
	}else{
	?>
		<div class="container">
			<div class="page-header">
				<h1>Certification needed: <small style="color: green;"><?php echo $full_name; ?></small></h1>
			</div>
			<hr />
				<div>
					<i>I,__<strong><?php echo $full_name; ?></strong>__, hereby certify, to the best of my knowledge, that the information provided <a href="profile.php"> Above </a> is complete and correct</i>
				</div>
				<br />
				<center>
					<form id="bownCertify">
						<input type="hidden" name="certify-beneficial-ownership-url"></input>
						<button type="submit" class="btn btn-primary btn-success" style="" id="bownCertifybtn">Ceritify</button>
					</form>
				</center>
		</div>
	
	
	<?php
		
	}
	?>
    <?php include_once '../inc/footer.php'; ?>	