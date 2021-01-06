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
	//print_r($customer);
	/**/
?>
		<div class="container">
			<div class="page-header">
				<h1>Profile: <small style="color: green;"><?php echo $full_name; ?></small></h1>
			</div>
			<hr />
				<div>
					<fieldset>
						<legend>Personal:</legend>
						  <table class="table table-user-information">
							<tbody>
							  <tr>
								<td>Name:</td>
								<td><strong><?php echo $full_name; ?></strong></td>
							  </tr>
							  <tr>
								<td>Email:</td>
								<td><strong><?php echo $email; ?></strong></td>
							  </tr>
							  <tr>
								<td>Signup</td>
								<td><strong><?php echo $createdAt; ?></strong></td>
							  </tr>
							   <tr>									
								<td>Status</td>
								<td><strong>Active</strong></td>
							  </tr>
							
						   
							<?php
								if(isset($customer->data)){
							?>							
								   <tr>
									<td>dwolla Status</td>
									<td><strong><?php echo $customer->data->status; ?></strong></td>
								  </tr>							  							  
								  <tr>	
									<td>Type</td>
									<td><strong><?php echo $customer->data->type; ?></strong></td>							  
								  </tr>
							<?php
								}
							?>
							</tbody>
						  </table>						
					</fieldset>
				<?php
					if($_SESSION['user_role'] === 'MERCHANT'){
							
						if($customer->status ==1){      
						echo "Can't find MERCHANT";
						}else{
				?>		
					<fieldset>
						<legend>Business:</legend>
						  <table class="table table-user-information">
							<tbody>
							  <tr>
								<td>Name:</td>
								<td><strong><?php echo $customer->data->business_name; ?></strong></td>
							  </tr>
							  <tr>
								<td>Type:</td>
								<td><strong><?php echo isset($customer->data->businessType)?$customer->data->businessType:"--"; ?></strong></td>
							  </tr>
							  <tr>
								<td>Address</td>
								<td><strong><?php echo $customer->data->address1." ".$customer->data->address2." ".$customer->data->city.", ".$customer->data->state." ".$customer->data->postal_code; ?></strong></td>
							  </tr>
						   
								 <tr>
									 <tr>
								<td>Controller</td>
								<td><strong><?php echo isset($customer->data->controller)?$customer->data->controller->firstName." ".$customer->data->controller->lastName."(".$customer->data->controller->title.")":"---"; ?></strong></td>
							  </tr>
							  </tr>
							  <tr>								   
							  </tr>
							 
							</tbody>
						  </table>						
					</fieldset>
				<?php
						}
					}
				?>
				<div class="form-group form-inline">
					<label class="col-md-4 control-label" for="start"></label>
					<div class="col-md-6">
						<button class="btn btn-primary btn-success" style="" onClick="javascript:window.location.href='verify.php'">Upgrade</button>
					</div>
				</div>	
			</div>				
		</div>

		
    <?php include_once (__DIR__.'/../inc/footer.php'); ?>