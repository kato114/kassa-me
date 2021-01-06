<?php 
	include_once(__DIR__."/../inc/header.php"); 
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		

		//echo '<div class="alert alert-success">Entries saved!</div>';
	}
	include_once(__DIR__."/../services/class.dwolla.php");
?>
		<div class="container">
			<div class="page-header">
				<h1>Account Verfication</h1>
			</div>
			<hr />
				<form id="newUpgrade">
					<fieldset>
						<legend>Personal</legend>
						<!--div class="form-group form-inline">
							<label class="col-md-4 control-label" for="dateOfBirth">Date Of Birth</label>
							<div class="col-md-6">
								<input name="dateOfBirth" type="text" placeholder="" class="form-control" id="dateOfBirth" data-inputmask="'mask': '9999-99-99'" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="dateOfBirth"></i>
							</div>
						</div-->							
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="address">Address</label>
							<div class="col-md-6">
								<input  name="address" type="text" placeholder="Address" class="form-control input-md" required="" id="address" /><i style="display: none;" class="form-control-feedback" data-bv-icon-for="transTo"></i>
							</div>
						</div>		
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="city">City</label>
							<div class="col-md-6">
								<input name="city" type="text" placeholder="City" class="form-control input-md" required="" id="city" />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="DocNation"></i>

								<small style="display: none;" data-bv-validator="notEmpty" class="help-block">required</small>
							</div>
						</div>	

						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="state">State</label>
							<div class="col-md-6">
								<input name="state" type="text" placeholder="State" class="form-control" id="state" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="state"></i>
							</div>
						</div>		
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="postalCode">Postal Code</label>
							<div class="col-md-6">
								<input name="postalCode" type="text" placeholder="Postal Code" class="form-control" id="postalCode" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="postalCode"></i>
							</div>
						</div>		
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="businessName">Business Name</label>
							<div class="col-md-6">
								<input name="businessName" type="text" placeholder="Business Name" class="form-control" id="businessName" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="businessName"></i>
							</div>
						</div>	
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="businessType">Business Type</label>
							<div class="col-md-6">
								<select name="businessType" class="form-control">
									<option value="corporation">Corporation</option>
									<option value="llc">llc</option>
									<option value="partnership">Partnership</option>
								</select>
							</div>
						</div>	
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="ein">EIN</label>
							<div class="col-md-6">
								<input name="ein" type="text" placeholder="ein" class="form-control" id="ein" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="ein"></i>
							</div>
						</div>	
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="ssn">SSN</label>
							<div class="col-md-6">
								<input name="ssn" type="text" placeholder="ssn" class="form-control" id="ssn" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="ein"></i>
							</div>
						</div>							
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="businessClassification">Business Classification</label>
							<div class="col-md-6">
								<!--
								<input name="businessClassification" type="text" placeholder="Business Classification" class="form-control" id="businessClassification" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="businessClassification"></i>
								-->
								<?php
									$dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
									$list_business_classfied = $dwolla_service->list_business_classfied();
									echo '<select name="businessClassification" class="form-control" id="businessClassification">';
									foreach($list_business_classfied->_embedded->{'business-classifications'} as $cb){
										//echo '<option value="'.$cb->id.'">'.$cb->name.'</option>';
										foreach($cb->_embedded->{'industry-classifications'} as $elem){
											echo '<option value="'.$elem->id.'">'.$elem->name.'</option>';
										}
									}
									echo "</select>";								
								?>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="ssn">Are there  any other beneficial owners having more than 25% ownership? </label>
							<div class="col-md-2">								
								<input name="more_ownership" type="radio" class="form-control" id="new_ownership_yes" Value="yes"/>
								<span class="" for="new_ownership_yes">Yes</span>
							</div>						
							<div class="col-md-2">
								<input name="more_ownership" type="radio" class="form-control" id="new_ownership_no" value="no" checked />
								<span class="" for="new_ownership_no">No</span>
							</div>							
						</div>
						<div class="form-group form-inline" id="div_bo_count" style="display:none">
							<label class="col-md-4 control-label" for="bo_count">How Many Benicial Owner ?</label>
							<div class="col-md-2">								
								<input name="bo_count" type="radio" class="form-control" id="bo_count_one" Value="1"/>
								<span class="" for="bo_count_one">1</span>
							</div>						
							<div class="col-md-2">
								<input name="bo_count" type="radio" class="form-control" id="bo_count_two" value="2"/>
								<span class="" for="bo_count_two">2</span>
							</div>							
							<div class="form-group form-inline" id="div_1st_bo" style="display:none">
								<label class="col-md-4 control-label" for="firstName">1st Benecial Owner</label>
								<div class="col-md-2">
									<input name="bo1_firstName" type="text" placeholder="First Name" class="form-control" id="bo1_firstName" />
								</div>
								<div class="col-md-2">
									<input name="bo1_lastName" type="text" placeholder="Last Name" class="form-control" id="bo1_lastName" />
								</div>		
								<div class="col-md-2">
									<input name="bo1_address" type="text" placeholder="Address" class="form-control" id="bo1_address" />
								</div>								
							</div>		
							<div class="form-group form-inline" id="div_2st_bo" style="display:none">
								<label class="col-md-4 control-label" for="firstName">2nd Benecial Owner</label>
								<div class="col-md-2">
									<input name="bo2_firstName" type="text" placeholder="First Name" class="form-control" id="bo2_firstName" />
								</div>
								<div class="col-md-2">
									<input name="bo2_lastName" type="text" placeholder="Last Name" class="form-control" id="bo2_lastName" />
								</div>		
								<div class="col-md-2">
									<input name="bo2_address" type="text" placeholder="Address" class="form-control" id="bo2_address" />
								</div>								
							</div>		
						</div>								
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="ssn">Is the controller the same person as the beneficiary owner? </label>
							<div class="col-md-2">
								<input name="new_controller" type="radio" class="form-control" id="dropcontroller_yes" value="yes" checked />
								<span class="" for="dropcontroller_yes">Yes</span>
							</div>
							<div class="col-md-2">
								<input name="new_controller" type="radio" class="form-control" id="dropcontroller_no" value="no" />
								<span class="" for="dropcontroller_no">No</span>
							</div>							
						</div>							
					</fieldset>
					<fieldset style="display:none;" id="controller_fields">
						<legend>Controller</legend>
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="firstName">First Name</label>
							<div class="col-md-6">
								<input name="contr_firstName" type="text" placeholder="" class="form-control" id="firstName" />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="ein"></i>
							</div>
						</div>	
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_lastName">Last Name</label>
							<div class="col-md-6">
								<input name="contr_lastName" type="text" placeholder="" class="form-control" id="contr_lastName" />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="contr_lastName"></i>
							</div>
						</div>		
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_title">Title</label>
							<div class="col-md-6">
								<input name="contr_title" type="text" placeholder="" class="form-control" id="contr_title" />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="contr_title"></i>
							</div>
						</div>
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_dob">Date Of Birth</label>
							<div class="col-md-6">
								<input name="contr_dob" type="text" placeholder="" class="form-control" id="contr_dob" data-mask="00/00/0000" required />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="contr_dob"></i>
							</div>
						</div>						
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_address">Address</label>
							<div class="col-md-6">
								<input name="contr_address" type="text" placeholder="" class="form-control" id="contr_address" />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="contr_address"></i>
							</div>
						</div>	
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="city">City</label>
							<div class="col-md-6">
								<input name="contr_city" type="text" placeholder="City" class="form-control input-md" " id="city" />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="DocNation"></i>

								<small style="display: none;" data-bv-validator="notEmpty" class="help-block">required</small>
							</div>
						</div>	

						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="state">State</label>
							<div class="col-md-6">
								<input name="contr_state" type="text" placeholder="State" class="form-control" id="state" />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="state"></i>
							</div>
						</div>		



						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="postalCode">Postal Code</label>
							<div class="col-md-6">
								<input name="contr_postalCode" type="text" placeholder="Postal Code" class="form-control" id="postalCode"  />
								<i style="display: none;" class="form-control-feedback" data-bv-icon-for="postalCode"></i>
							</div>
						</div>			
						<div class="form-group form-inline">
							<label class="col-md-4 control-label" for="contr_country">Country</label>
							<div class="col-md-6">
								<select name="contr_country" class="form-control">
									<option value="usa">United State</option>
									<option value="canada">CANADA</option>>
								</select>
							</div>
						</div>								
					</fieldset>
					<div class="form-group form-inline">
						<label class="col-md-4 control-label" for="start">I hereby certify that the information provided is accurate and complete to the best of my knowledge.</label>						
						<div class="col-md-6">
							<input type="checkbox" name="hereby" id="hereby" required="">
						</div>
					</div>						
					<div class="form-group form-inline">
						<label class="col-md-4 control-label" for="start"></label>
						<div class="col-md-6">
							<button type="submit" class="btn btn-primary btn-success" style="" id="newUpgradebtn">Upgrade Account</button>
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

		
    <?php include_once(__DIR__."/../inc/footer.php"); ?>