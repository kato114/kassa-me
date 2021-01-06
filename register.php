<?php
header("Content-type: application/json");
include_once("php_includes/db_conx.php");
include_once("inc/functions.php");
include_once("services/class.dwolla.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$user_roles = array("receive_only", "unverified", "business", "personal");
	$requires_fields = array("email", "password", "type", "firstName", "lastName");
	$res = array_diff($requires_fields, array_keys($_POST));
	/*print_r(json_encode(array_keys($_POST)));
	exit;*/
	if(count($res) > 0){
		$result = array("status"=>1, "message"=>"Missing field(s): ".implode(", ", $res));
		echo json_encode($result);
		exit;			
	}
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$username=$_POST['email'];
	$email=$_POST['email'];
	$password=password_hash($_POST['password'], PASSWORD_DEFAULT/*PASSWORD_ARGON2I*/, ['memory_cost' => 2 ** 17]);//md5($_POST['password']);
	$user_role= $_POST['type'];
	$uniq_id = uniqid('00', true);
	$ip = "";
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}	
	if(!in_array($user_role, $user_roles)){
		$result = array("status"=>1, "message"=>"incorrect value - user role - ");
		echo json_encode($result);
		exit;		
	}
	if(check_user($username, $email))
	{
		$result = array("status"=>1, "message"=>"user already exists");
		echo json_encode($result);
		exit;
	}
	$dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
	if($user_role === 'receive_only' || $user_role === 'unverified')
		$dwolla_customer = json_decode($dwolla_service->createCustomerUnverRecev($firstName, $lastName, $email, $user_role));
	else
		$dwolla_customer = json_decode($dwolla_service->createCustomerPersoBusi($firstName, $lastName, $email, $user_role, $_POST));
	if(!isset($dwolla_customer->status) || $dwolla_customer->status != 0){
		$message = $dwolla_customer->message;
		if(isset($dwolla_customer->_embedded)){
			$message = $dwolla_customer->_embedded->errors[0]->message;
		}
		//response._embedded.errors[0].message
		$result = array("status"=>1, "message"=>$message);
		echo json_encode($result);
		exit;		
	}/**/	
	$p_hash = md5($username);
	$sql = "INSERT INTO users (username, password, is_active, activation_code, email, user_role, `uniqid`, ip, lastlogin, firstName, lastName, customerId)
		   VALUES('$username',	'$password', '0', '$p_hash', '$email', '$user_role', '$uniq_id', '$ip', '', '$firstName', '$lastName', '".$dwolla_customer->data."' )";
	$query = mysqli_query($db_conx, $sql);
	if (!$query) {
		$result = array("status"=>1, "message"=>"Registration failed. Please, try again later ".mysqli_error($db_conx));
		echo json_encode($result);		
		exit;				
	}
	/* Send email */   
	//send_email2($subject, $message, $email);	
	sendVerificationCode($p_hash, $email);
	$result = array("status"=>0, "message"=>"Registration success.<br />We have sent activation link to $email<br />Click on the link below to activate your account", "hash"=>$p_hash);
	echo json_encode($result);
	exit;		
	
}else{
	
    header('HTTP/1.1 401 Unauthorized');
	$realm = "Restricted area";
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
			
	$result = array("status"=>1, "message"=>"Restricted area");
	echo json_encode($result);
	exit;			
}

function check_user($username, $email)
{
    global $db_conx;
	
    $sql = "SELECT ID FROM users WHERE username='$username' or email='$email'";
	$query = mysqli_query($db_conx, $sql);
    if (!$query) 
	{
		return false;
		exit;
   }
   $row = mysqli_fetch_row($query);
   if($row && count($row)>=1)
   {
	  return true;
   }else
   {
	  return false;
   }
 
 }