<?php
	include_once("header.php");
?>
       <div id="__next">
            <svg class="global__BackgroundSVG-sc-1s86p61-0 fuBaFi" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 383.55 446.3">
                <defs>
                    <linearGradient id="a" x1="247.47" y1="486.42" x2="136.35" y2="37.83" gradientTransform="matrix(1 0 0 -1 0 448)" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#9f007e"></stop>
                        <stop offset="1" stop-color="#09c4ef"></stop>
                    </linearGradient>
                    <linearGradient id="b" x1="225.19" y1="444.82" x2="121.87" y2="-1.84" xlink:href="#a"></linearGradient>
                </defs>
                <title>bg</title>
                <path
                    d="M375.07 14.89c-11 33.5-51.85 0-84.39 11-53.61 18.11-57.36 89.5-87.68 107.5s-82-8-111.41 0c-33.09 9-37 45.5-58.47 47-11.48.8-24.18-2.36-33.1-5v216.39c27.6 9.35 105.85 16.44 144.52-6.39 47.43-28 37.5-68 67.84-108s75.56-29 100.93-32c22.19-2.62 56.17-12.14 70.26-47.91V.48c-3.82 2.52-8.5 14.41-8.5 14.41z"
                    style="isolation: isolate;"
                    opacity=".6"
                    fill="url(#a)"
                ></path>
                <path
                    d="M345.12 52c-62.59-13.15-82.57 27.58-117.87 33.87s-62.88-10.46-103.69 0c-31.14 8-41 36.54-79.42 36.54C23.42 122.39 9.28 109.12 0 98.57V422.9c25 24.35 148.2 36.34 192 2.49 45.23-35 37.51-122 47.44-155 9.24-30.73 30-65.79 144.16-73.7V56.21c-15.41 2.17-31.07-1.44-38.48-4.21z"
                    style="isolation: isolate;"
                    opacity=".5"
                    fill="url(#b)"
                ></path>
                <path d="M246 66a3.32 3.32 0 1 1-3.31-3 3.16 3.16 0 0 1 3.31 3z" fill="#fff" fill-opacity=".8"></path>
                <path d="M276.89 70.5a5 5 0 1 1-5-4.5 4.74 4.74 0 0 1 5 4.5z" fill="#fff" fill-opacity=".2"></path>
                <path d="M239.39 88a2.22 2.22 0 1 1-2.21-2 2.12 2.12 0 0 1 2.21 2z" fill="#fff" fill-opacity=".5"></path>
                <path d="M204.09 85a1.11 1.11 0 1 1-1.09-1 1.06 1.06 0 0 1 1.09 1z" fill="#fff" fill-opacity=".4"></path>
                <path d="M226.15 80a2.22 2.22 0 1 1-2.21-2 2.12 2.12 0 0 1 2.21 2z" fill="#fff" fill-opacity=".6"></path>
                <path fill="none" d="M1.71 0H383v446.3H1.71z"></path>
            </svg>
            <div class="MuiContainer-root MuiContainer-fixed MuiContainer-maxWidthLg">
                <div style="position: relative;">
                    <div class="form__Container-sc-1clt5p5-5 hjVoiM">
                        <div class="Logo__Container-is3hb2-0 hRrNui"><img src="assets/images/logo.png" alt="" /></div>
                        <div class="typography__HeadingText-sqf0j0-0 fhgaIb">Fill the form to create your account</div>
                        <form class="form__Form-sc-1clt5p5-2 deFwsi" id="signupForm">
							<?php
								if(!isset($_GET["type"])){
							?>						
									<div class="form__Input-sc-1clt5p5-3 ksXRcz">
										<ul>
											<li><a href="?type=unverified">Unverified Account</a></li>
											<li><a href="?type=personal">Personal Account</a></li>
											<li><a href="?type=business">Business Account</a></li>
											<li><a href="?type=receive_only">Receive Only Account</a></li>
										</ul>
									</div>	
							<?php
								}else{
							?>										
									<div class="form__Input-sc-1clt5p5-3 ksXRcz">
										<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" size="17" height="17" width="17" xmlns="http://www.w3.org/2000/svg">
											<path
												d="M858.5 763.6a374 374 0 0 0-80.6-119.5 375.63 375.63 0 0 0-119.5-80.6c-.4-.2-.8-.3-1.2-.5C719.5 518 760 444.7 760 362c0-137-111-248-248-248S264 225 264 362c0 82.7 40.5 156 102.8 201.1-.4.2-.8.3-1.2.5-44.8 18.9-85 46-119.5 80.6a375.63 375.63 0 0 0-80.6 119.5A371.7 371.7 0 0 0 136 901.8a8 8 0 0 0 8 8.2h60c4.4 0 7.9-3.5 8-7.8 2-77.2 33-149.5 87.8-204.3 56.7-56.7 132-87.9 212.2-87.9s155.5 31.2 212.2 87.9C779 752.7 810 825 812 902.2c.1 4.4 3.6 7.8 8 7.8h60a8 8 0 0 0 8-8.2c-1-47.8-10.9-94.3-29.5-138.2zM512 534c-45.9 0-89.1-17.9-121.6-50.4S340 407.9 340 362c0-45.9 17.9-89.1 50.4-121.6S466.1 190 512 190s89.1 17.9 121.6 50.4S684 316.1 684 362c0 45.9-17.9 89.1-50.4 121.6S557.9 534 512 534z"
											></path>
										</svg>
										<input type="text" class="form__Input-sc-1clt5p5-3 ksXRcz" name="firstName" placeholder="First name" value=""  required />
									</div>
									<div class="form__Input-sc-1clt5p5-3 ksXRcz">
										<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" size="17" height="17" width="17" xmlns="http://www.w3.org/2000/svg">
											<path
												d="M858.5 763.6a374 374 0 0 0-80.6-119.5 375.63 375.63 0 0 0-119.5-80.6c-.4-.2-.8-.3-1.2-.5C719.5 518 760 444.7 760 362c0-137-111-248-248-248S264 225 264 362c0 82.7 40.5 156 102.8 201.1-.4.2-.8.3-1.2.5-44.8 18.9-85 46-119.5 80.6a375.63 375.63 0 0 0-80.6 119.5A371.7 371.7 0 0 0 136 901.8a8 8 0 0 0 8 8.2h60c4.4 0 7.9-3.5 8-7.8 2-77.2 33-149.5 87.8-204.3 56.7-56.7 132-87.9 212.2-87.9s155.5 31.2 212.2 87.9C779 752.7 810 825 812 902.2c.1 4.4 3.6 7.8 8 7.8h60a8 8 0 0 0 8-8.2c-1-47.8-10.9-94.3-29.5-138.2zM512 534c-45.9 0-89.1-17.9-121.6-50.4S340 407.9 340 362c0-45.9 17.9-89.1 50.4-121.6S466.1 190 512 190s89.1 17.9 121.6 50.4S684 316.1 684 362c0 45.9-17.9 89.1-50.4 121.6S557.9 534 512 534z"
											></path>
										</svg>
										<input type="text" class="form__Input-sc-1clt5p5-3 ksXRcz" name="lastName" placeholder="Last name" value=""  required />
									</div>
									
									
									<?php
										if(isset($_GET["type"]) && ($_GET["type"]==='business' || $_GET["type"]==='personal') ){
									?>																			
											<div class="form__Input-sc-1clt5p5-3 ksXRcz">										
												<input type="text" class="form__Input-sc-1clt5p5-3 ksXRcz" name="dateOfBirth" placeholder="Date Of birth" value=""  data-mask="00/00/0000"  required />
											</div>		
											<div class="form__Input-sc-1clt5p5-3 ksXRcz">										
												<input type="text" class="form__Input-sc-1clt5p5-3 ksXRcz" name="ssn" placeholder="SSN" value=""  required />
											</div>	
											<div class="form__Input-sc-1clt5p5-3 ksXRcz">										
												<input type="text" class="form__Input-sc-1clt5p5-3 ksXRcz" name="address1" placeholder="Address1" value=""  required />
											</div>	
											<div class="form__Input-sc-1clt5p5-3 ksXRcz">										
												<input type="text" class="form__Input-sc-1clt5p5-3 ksXRcz" name="city" placeholder="City" value=""  required />
											</div>		
											<div class="form__Input-sc-1clt5p5-3 ksXRcz">										
												<input type="text" class="form__Input-sc-1clt5p5-3 ksXRcz" name="state" placeholder="State" value=""  required />
											</div>		
											<div class="form__Input-sc-1clt5p5-3 ksXRcz">										
												<input type="text" class="form__Input-sc-1clt5p5-3 ksXRcz" name="postalCode" placeholder="Postal Code" value=""  required />
											</div>													
									<?php
										}
										if(isset($_GET["type"]) && $_GET["type"]==='business' ){
									?>
									
											<div class="form__Input-sc-1clt5p5-3 ksXRcz">										
												<input type="text" class="form__Input-sc-1clt5p5-3 ksXRcz" name="ein" placeholder="ein" value=""  required />
											</div>	
											<div class="form__Input-sc-1clt5p5-3 ksXRcz">										
												<input type="text" class="form__Input-sc-1clt5p5-3 ksXRcz" name="businessName" placeholder="Business Name" value=""  required />
											</div>						
											<div class="form__Input-sc-1clt5p5-3 ksXRcz">										
												<select class="form__Input-sc-1clt5p5-3 ksXRcz" name="businessClassification" required>	
													<option value="">Business Classification</option>
													<?php
														include_once(__DIR__."/services/class.dwolla.php");
														$dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
														$list_business_classfied = $dwolla_service->list_business_classfied();
														foreach($list_business_classfied->_embedded->{'business-classifications'} as $cb){
															//echo '<option value="'.$cb->id.'">'.$cb->name.'</option>';
															foreach($cb->_embedded->{'industry-classifications'} as $elem){
																echo '<option value="'.$elem->id.'">'.$elem->name.'</option>';
															}
														}						
													?>												
												
												</select>
											</div>												
									<?php
									
										}
									?>
									
									<div class="form__Input-sc-1clt5p5-3 ksXRcz">
										<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" size="17" height="17" width="17" xmlns="http://www.w3.org/2000/svg">
											<path
												d="M928 160H96c-17.7 0-32 14.3-32 32v640c0 17.7 14.3 32 32 32h832c17.7 0 32-14.3 32-32V192c0-17.7-14.3-32-32-32zm-40 110.8V792H136V270.8l-27.6-21.5 39.3-50.5 42.8 33.3h643.1l42.8-33.3 39.3 50.5-27.7 21.5zM833.6 232L512 482 190.4 232l-42.8-33.3-39.3 50.5 27.6 21.5 341.6 265.6a55.99 55.99 0 0 0 68.7 0L888 270.8l27.6-21.5-39.3-50.5-42.7 33.2z"
											></path>
										</svg>
										<input type="email" class="form__Input-sc-1clt5p5-3 ksXRcz" name="email" placeholder="Email" value="" required />
									</div>
									<div class="form__Input-sc-1clt5p5-3 ksXRcz">
										<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" size="17" height="17" width="17" xmlns="http://www.w3.org/2000/svg">
											<path
												d="M832 464h-68V240c0-70.7-57.3-128-128-128H388c-70.7 0-128 57.3-128 128v224h-68c-17.7 0-32 14.3-32 32v384c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V496c0-17.7-14.3-32-32-32zM332 240c0-30.9 25.1-56 56-56h248c30.9 0 56 25.1 56 56v224H332V240zm460 600H232V536h560v304zM484 701v53c0 4.4 3.6 8 8 8h40c4.4 0 8-3.6 8-8v-53a48.01 48.01 0 1 0-56 0z"
											></path>
										</svg>
										<input type="password" class="form__Input-sc-1clt5p5-3 ksXRcz" name="password" placeholder="Password" value="" required  />
										<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" size="17" height="17" width="17" xmlns="http://www.w3.org/2000/svg">
											<path
												d="M942.2 486.2C847.4 286.5 704.1 186 512 186c-192.2 0-335.4 100.5-430.2 300.3a60.3 60.3 0 0 0 0 51.5C176.6 737.5 319.9 838 512 838c192.2 0 335.4-100.5 430.2-300.3 7.7-16.2 7.7-35 0-51.5zM512 766c-161.3 0-279.4-81.8-362.7-254C232.6 339.8 350.7 258 512 258c161.3 0 279.4 81.8 362.7 254C791.5 684.2 673.4 766 512 766zm-4-430c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176zm0 288c-61.9 0-112-50.1-112-112s50.1-112 112-112 112 50.1 112 112-50.1 112-112 112z"
											></path>
										</svg>
									</div>								
									<div class="form__Checkbox-sc-1clt5p5-4 bleIyZ">
										<input type="checkbox" name="terms" id="terms"  required />
										<label for="terms">
										<?php
											if(isset($_GET["type"]) && strtoupper($_GET["type"])==='RECEIVE_ONLY'){
										?>
											By checking this box you agree to <a href="https://kassameapp.com/terms-of-service/">Our Terms of Service</a> and <a href="https://kassameapp.com/privacy-policy/">Privacy Policy</a>	
										<?php
											}else{
										?>
											By checking this box you agree to <a href="https://kassameapp.com/terms-of-service/">Our Terms of Service</a> and <a href="https://kassameapp.com/privacy-policy/">Privacy Policy</a>, as well as our
											partner <a href="https://www.dwolla.com/legal/tos/">Dwolla's Terms of Service</a> and <a href="https://www.dwolla.com/legal/privacy/">Privacy Policy</a>											
											
										<?php
											}
										?>									
										</label>
									</div>
									<input type="hidden" name="type" value="<?php echo isset($_GET["type"])?$_GET["type"]:"unverified"; ?>" />
									<button class="form__Button-sc-1clt5p5-0 jrOeAQ" type="submit">Sign up</button>
									<a class="form__ButtonUnstyled-sc-1clt5p5-1 TlXWl" href="index">Log in</a>
							<?php
								}
							?>									
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php
	include_once('footer.php');
?>
