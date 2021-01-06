<?php 
	include_once (__DIR__.'/../inc/header.php'); 
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		

		//echo '<div class="alert alert-success">Entries saved!</div>';
	}
?>
		<div class="container">
			<div class="page-header">
				<h1>Transaction: <small style="color: green;">Request Payment</small></h1>
			</div>
			<hr />
				<form id="newTransaction">
					<fieldset>
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="email">To</label>
							<div class="col-md-6">
								<input  name="receiverEmail" type="email" placeholder="Email" class="form-control input-md" required="" id="receiverEmail" /><i style="display: none;" class="form-control-feedback" data-bv-icon-for="transTo"></i>
							</div>
						</div>		
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="note">For</label>
							<div class="col-md-6">
								<input name="note" type="text" placeholder="Add a note" class="form-control input-md" required="" id="note" />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="DocNation"></i>

								<small style="display: none;" data-bv-validator="notEmpty" class="help-block">required</small>
							</div>
						</div>	

						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="transValue">How Much</label>
							<div class="col-md-6">
								<input name="transValue" type="text" placeholder="$" class="form-control" id="transValue" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="transValue"></i>
							</div>
						</div>					
					</fieldset>
				
				<div class="form-group form-inline">
					<label class="col-md-4 control-label" for="start"></label>
					<div class="col-md-6">
						<button type="submit" class="btn btn-primary btn-success" style="">Request Payment</button>
					</div>
				</div>	
			</form>				
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="confirmationBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Confirm Request</h5>
				<div class="modal-body">	
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
			  </div>
					<center>
					  <h5>Payment Request From <span id="reqEmail"></span></h5>
					  <p><span class="money">$<span id="reqAmount"></span></p>
					  <p id="reqNote" class="subT"></p>
					  <hr>
					  <p class="subT">This amount will be deposited into your bank account.</p>
					</center>
			  <div class="modal-footer">
				<button type="button" class="btn btn-success" id="confirmTrans">Confirm</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Edit</button>
			  </div>
			</div>
		  </div>
		</div>		

		
    <?php include_once (__DIR__.'/../inc/footer.php'); ?>