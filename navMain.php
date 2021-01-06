<nav class="navbar navbar-expand-lg navbar-light bg-light">
 <div class="container">
 		   <?php
			if($user_ok == true) {
			?>	
				<a class="navbar-brand" href="#"><img src="../assets/account/images/Kassa-Me-Logo.png" width=32 height=32/></a>
		   <?php
			}else{
			?>		
				<a class="navbar-brand" href="#"><img src="images/logo.jpg" width=32 height=32/></a>
		   <?php
			}
			?>					
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
		   <?php
			if($user_ok == true) {
			?>				
				  <li class="nav-item active">
					<a class="nav-link" href="<?php echo $home_url; ?>/account/">Home <span class="sr-only">(current)</span></a>
				  </li>
				  <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  Account 
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					  <a class="dropdown-item" href="<?php echo $home_url; ?>/account/bank.php">Funding Source</a>
					  <a class="dropdown-item" href="<?php echo $home_url; ?>/account/verify.php">Upgrade</a>				
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item" href="<?php echo $home_url; ?>/account/logout.php">Logout</a>	
					</div>
				  </li>
				  <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  My Profile
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					  <a class="dropdown-item" href="<?php echo $home_url; ?>/account/profile.php">My Profile</a>
					  <a class="dropdown-item" href="<?php echo $home_url; ?>/account/upload.php">Upload document</a>		
					</div>
				  </li>				  
				  <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  Kassa Me
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					  <a class="dropdown-item" href="https://kassameapp.com/terms-of-service/">Kassa Me TOS</a>
					  <a class="dropdown-item" href="https://kassameapp.com/privacy-policy">Kassa Me PP</a>	
					 <?php
						if($_SESSION['user_role'] !=='RECEIVE_ONLY'){
					 ?>
							  <div class="dropdown-divider"></div>
							  <a class="dropdown-item" href="https://www.dwolla.com/legal/tos/">Dwolla TOS</a>
							  <a class="dropdown-item" href="https://www.dwolla.com/legal/privacy/">Dwolla PP</a>
					<?php
						}
					?>
					</div>
				  </li>
		   <?php
			}
			?>								  
		</ul>
		   <?php
			if($user_ok == true) {
				//echo '<p class="navbar-text navbar-right">Signed in as '.$_SESSION['email'].'&nbsp;</p>';
				$balance = "0";
				$balance_obj = getCustomerbalance();
				if(!empty($balance_obj) && isset($balance_obj->accounts)){
					$balance = $balance_obj->accounts[0]->balances->available;
				}
			?>	
			<div  class="form-inline my-2 my-lg-0">	
				<h5 class="subT">Balance:   </h5>
				<span class="money"><?php echo format_money($balance); ?></span>
				<!--small><a href="#" class="fndSRCUpdate"> Update Account </a></small-->
			</div>
		   <?php
			}
			?>				
	  </div>
	</div>
</nav>