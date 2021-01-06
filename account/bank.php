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
	$fundingSource = json_decode($dwolla_service->getFundingSource($user['fundingSourceId']));
	//print_r($fundingSource);
	
	$balance = "0";
	$balance_obj = getCustomerbalance();
	if(!empty($balance_obj) && isset($balance_obj->accounts)){
		$balance = $balance_obj->accounts[0]->balances->available;
	}	

?>
		<div class="container">
			<div class="page-header">
				<h1>Funding Source</h1>
			</div>
			<hr />
				<div>
				<?php
				if($fundingSource->status == 0){
				?>
					<fieldset>
						<legend>Bank:</legend>
						  <table class="table table-user-information">
							<tbody>
							
							  <tr>
								<td>Bank Name:</td>
								<td><strong><?php echo $fundingSource->data->bank_name; ?></strong></td>
							  </tr>
							  <tr>
								<td>Name:</td>
								<td><strong><?php echo $fundingSource->data->name; ?></strong></td>
							  </tr>
							  <tr>
								<td>Type:</td>
								<td><strong><?php echo $fundingSource->data->bank_account_type; ?></strong></td>
							  </tr>							  
							  <tr>
								<td>Status</td>
								<td><strong><?php echo $fundingSource->data->status; ?></strong></td>
							  </tr>
						   
								 <tr>
								<tr>
								<td>Balance</td>
								<td><strong><?php echo empty($fundingSource->data->balance)?format_money($balance):$fundingSource->data->balance; ?></strong></td>
							  </tr>
							  </tr>
							  <tr>								   
							  </tr>
							 
							</tbody>
						  </table>						
					</fieldset>
				<?php
				}
				?>					

				<div class="form-group form-inline">
					<label class="col-md-4 control-label" for="start"></label>
					<div class="col-md-6">
						<button class="btn btn-primary btn-success" style=""  id="fndSRC">Add Funding Source</button>
					</div>
				</div>	
			</div>				
		</div>

		
    <?php include_once (__DIR__.'/../inc/footer.php'); ?>