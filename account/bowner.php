<?php 
	include_once (__DIR__.'/../inc/header.php'); 
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		

		//echo '<div class="alert alert-success">Entries saved!</div>';
	}
	include_once(__DIR__."/../services/class.dwolla.php");
?>
		<div class="container">
			<div class="page-header">
				<h1>Beneficial owners</h1>
			</div>
			<hr />
				<form id="newBOwner">
					<fieldset>
						<legend>Details</legend>
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="firstName">First Name</label>
							<div class="col-md-6">
								<input name="firstName" type="text" placeholder="" class="form-control" id="firstName"  required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="ein"></i>
							</div>
						</div>	
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_lastName">Last Name</label>
							<div class="col-md-6">
								<input name="lastName" type="text" placeholder="" class="form-control" id="contr_lastName"  required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="contr_lastName"></i>
							</div>
						</div>		
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="ssn">ssn</label>
							<div class="col-md-6">
								<input name="ssn" type="text" placeholder="ssn" class="form-control" id="ssn" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="ein"></i>
							</div>
						</div>			
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_dob">Date Of Birth</label>
							<div class="col-md-6">
								<input name="dateOfBirth" type="text" placeholder="" class="form-control" id="contr_dob" data-mask="00/00/0000" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="contr_dob"></i>
							</div>
						</div>						
						<!--div class="form-group form-inline">
							<label class="col-md-4 control-label" for="dateOfBirth">Date Of Birth</label>
							<div class="col-md-6">
								<input name="dateOfBirth" type="text" placeholder="" class="form-control" id="dateOfBirth" data-inputmask="'mask': '9999-99-99'" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="dateOfBirth"></i>
							</div>
						</div-->								
					</fieldset>
					<fieldset>
						<legend>Address</legend>					
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_address">Address 1</label>
							<div class="col-md-6">
								<input name="address1" type="text" placeholder="" class="form-control" id="contr_address" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="contr_address"></i>
							</div>
						</div>	
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_address">Address 2</label>
							<div class="col-md-6">
								<input name="address2" type="text" placeholder="" class="form-control" id="contr_address"  required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="contr_address"></i>
							</div>
						</div>							
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="city">City</label>
							<div class="col-md-6">
								<input name="city" type="text" placeholder="City" class="form-control input-md" " id="city" required  />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="DocNation"></i>

								<small style="display: none;" data-bv-validator="notEmpty" class="help-block">required</small>
							</div>
						</div>	

						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="state">State Province Region</label>
							<div class="col-md-6">
								<input name="stateProvinceRegion" type="text" placeholder="State" class="form-control" id="state"  required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="state"></i>
							</div>
						</div>		
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="postalCode">Postal Code</label>
							<div class="col-md-6">
								<input name="postalCode" type="text" placeholder="Postal Code" class="form-control" id="postalCode"   	required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="postalCode"></i>
							</div>
						</div>			
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_country">Country</label>
							<div class="col-md-6">
								<select name="country" class="form-control">
									<option value="usa">United State</option>
									<option value="canada">CANADA</option>>
								</select>
							</div>
						</div>								
					</fieldset>
					<div class="form-group form-inline">
						<label class="col-md-4 control-label" for="start"></label>
						<div class="col-md-6">
							<button type="submit" class="btn btn-primary btn-success" style="" id="newBOwnerbtn">Save</button>
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