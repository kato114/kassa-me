<?php 
	include_once (__DIR__.'/../inc/header.php'); 
	include_once (__DIR__.'/../services/class.dwolla.php'); 
?>
    <div id="sa_content">
		<div class="container">
		<div class="page-header">
	  <!--h1>List of Clients <small>Click Client Name for Report</small>  <a href="clients/export.php"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-download"></span> Export</button></a></h1-->
		</div>
		<?php

		 if(!isset($_SESSION['fundingSourceId'])){
			echo '<div class="alert alert-danger">You need to connect a funding source to use Kassa Me. Click <a href="#" id="fndSRC">here</a> to Add your Bank.</div>';
		 }
		 if(isset($_SESSION['document'])){
			echo '<div class="alert alert-danger">You need to upload your document to use Kassa Me. Click <a href="upload">here</a> to add the required document(s).</div>';
		 }
		 $transactions = get_user_transactions($_SESSION['email'], 'ORDER BY ID DESC');
		 //print_r($transactions);
	 ?> 
			<div class="page-header">
				<h1>
					Transactions History
				<?php
					if(strtoupper($_SESSION['user_role']) !== 'RECEIVE_ONLY'){
				?>							
						<span style="float:right"><button type="button" class="btn btn-outline-primary" onClick="javascript:window.location.href='transaction-new';">Request Payment</button></span>
				<?php
					}
				?>
				</h1>
			</div>
			<hr />
			<table id="example" class="table table-striped table-bordered" style="">
					<thead>
						<tr>
							<th>Date</th>
							<th>Status</th>							
							<th>From</th>
							<th>To</th>
							<th>Amount</th>
							<th>Fee</th>
							<th>Net</th>
							<th>Note</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>		
							<?php
								foreach($transactions as $transaction){
									$date=date_create($transaction["createdAt"]);
									$amount = $transaction["amount"]/100;
									$fee = $transaction["fee"]/100;
									$net= $amount - $fee;
							?>
								<tr>
									<td><?php echo date_format($date,"Y/m/d");?></td>
									<td><span class="badge badge-pill <?php echo $BADAGES[$transaction["status"]];?>"><?php echo $transaction["status"];?></span></td>
									<td><?php echo $transaction["senderEmail"];?></td>
									<td><?php echo $transaction["receiverEmail"];?></td>
									<td class="money"><?php echo format_money($amount); ?></td>
									<td class="money"><?php echo format_money($fee);?></td>
									<td class="money"><?php echo format_money($net);?></td>
									<td><?php echo $transaction["name"];?></td>
									<td><a href="transaction?id=<?php echo $transaction["id"];?>">details</a></td>
								</tr>
							<?php
								}
							?>								
					</tbody>
			</table>
<script>


</script>

		</div>	
	</div>     
			<?php include(__DIR__.'/../inc/footer.php'); ?> 	
   