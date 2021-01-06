<?php 
	include_once (__DIR__.'/../inc/header.php'); 
	include_once (__DIR__.'/../services/class.dwolla.php');
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		

		echo '<div class="alert alert-success">Entries saved!</div>';
	}
	if(isset($_GET["id"])){
		$transaction_id = $_GET["id"];
		$email= $_SESSION['email'];
		//echo "Your Session email: $email<br />";
		$condition = "AND (senderEmail='$email' or receiverEmail='$email' or moneySenderEmail='$email')";
		$transactions = get_transaction($transaction_id, $condition);
		//print_r($transactions);
	}else{
		exit;
	}
	if(empty($transactions))
	{
		$email= $_SESSION['email'];
		echo '<div class="alert alert-warning">Transaction not found! => Your Session email: '.$email.'</div>';
		exit;
	}
	$transaction= $transactions[0];
	$sender_email = $transaction["senderEmail"];
	if(empty($sender_email))
	{
		$sender_email = $transaction["moneySenderEmail"];		
	}
	$receiverEmail = $transaction["receiverEmail"];
	$user = get_user_by("email", $sender_email);
	if(!empty($user)){
		$id=$transaction["id"];
		$full_name = $user["firstName"]." ".$user["lastName"];
		$amount=$transaction["amount"]/100;
		$fee=$transaction["fee"]/100;
		$net= $amount - $fee;
		$name=$transaction["name"];
		$date = $transaction["createdAt"];
		$status = $transaction["status"];
	}else{
		//header("location: index.php");
		echo "ERROR: UNAUTHORIZED";
		exit(0);
	}

?>
		<div class="container">
			<div class="page-header">
				<h1>Transaction: <small style="color: green;">#<?php echo $id ;?></small></h1>
			</div>
			<hr />
			<center>
				<h1><small style="color: black;">Requested payment from <?php echo $full_name ;?></small></h1>
				<h4 class="money"><?php echo  format_money($amount); ?></h4>
				<?php
					if($_SESSION['user_role'] === 'MERCHANT'){
				?>				
					<h5><?php echo  "Net after fees: ".format_money($net); ?></h5>
				<?php
					}
				?>					
				<span  class="subT"> <?php echo $name; ?></span>
				<small class="subT"><?php echo $date; ?></small><br /><br />
				<span class="badge <?php echo $BADAGES[$status];?>"><?php echo $status; ?></span><br /><br />
				<?php
					 //echo "Status: $status=> receiverEmail:$receiverEmail";
					if(/*$_SESSION['user_role'] !== 'MERCHANT' &&*/ $status==='PENDING' && strtolower($receiverEmail)===strtolower($_SESSION['email'])){
				?>
						<button type="button" class="btn btn-outline-primary"  data-toggle="modal" data-target="#confirmationPayBox">Accept and Payment</button>				
				<?php
					}else if(strtoupper($status)==='PENDING' && $sender_email===$_SESSION['email']){
				?>
						<form id="resendTransForm">
							<input type="hidden" name="transactionId" value="<?php echo $transaction_id; ?>" />
							<button type="submit" class="btn btn-outline-primary"  id="resendPending">Resend Email</button>
						</form>
				<?php
					}
					//echo "Stat: ".strtoupper($status)."=>".(strtoupper($status)==='PENDING');
				?>
				<br />
				<br />
				<br />
			<h6  class="subT">Please contact KassaMe support at <a href="mailto:msp@360bizvue.net">msp@360bizvue.net</a> or <a href="tel:+15615995922">(561) 599-5922</a> to cancel the transaction.</h6>				
			</center>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="confirmationPayBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Confirm Payment</h5>
				<div class="modal-body">	
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
			  </div>
					<center>
					  <h5>Your are sending <span class="money">$<?php echo $amount; ?></span> to <?php echo $full_name; ?></h5>
					  <p id="reqNote" class="subT">For "<?php echo $name; ?>"</p>
					  <hr>
					  <?php
					  if(!empty($_SESSION['fundingSourceId'])){
					  ?>
						   <?php
								//echo '<p class="navbar-text navbar-right">Signed in as '.$_SESSION['email'].'&nbsp;</p>';
								$balance = "0";
								$balance_obj = getCustomerbalance();
								if(!empty($balance_obj) && isset($balance_obj->accounts)){
									$balance = $balance_obj->accounts[0]->balances->available;
								}
								$dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
								$fundingSource = json_decode($dwolla_service->getFundingSource($_SESSION['fundingSourceId']));								
							?>					  
						  <p class="subT">Your Bank account "<?php echo $fundingSource->data->name;?>" has <?php echo format_money($balance); ?> available.</p>
					<?php
					  }
					?>
					</center>
			  <div class="modal-footer">
				<button type="button" class="btn btn-success" id="confirmPay">Pay with Bank Account</button>
				<button type="button" class="btn btn-info" id="confirmCC">Pay with Credit Card</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Back</button>
				<input type="hidden" id="transid" value="<?php echo $_GET["id"];?>" />
			  </div>
			</div>
		  </div>
		</div>			
    <?php include_once (__DIR__.'/../inc/footer.php'); ?>