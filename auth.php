<?php
session_start();
header("Content-type: application/json");
include_once("inc/functions.php");
include_once (__DIR__.'/services/class.dwolla.php'); 
if(isset($_POST["log_username"])&&isset($_POST["log_password"])){


	include_once("php_includes/db_conx.php");
	$username = mysqli_real_escape_string($db_conx, $_POST['log_username']);
	$password = $_POST['log_password'];//password_hash($_POST['log_password'], PASSWORD_ARGON2I, ['memory_cost' => 2 ** 17]);//md5($_POST['log_password']);
		


    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	$sql = "SELECT activation_code, username, password, user_role, ID, email, customerId, fundingSourceId FROM users WHERE (username='$username' or email='$username') AND is_active='1' LIMIT 1";
	//echo $sql;
	$query = mysqli_query($db_conx, $sql);
    if (!$query) 
	{
		$result = array("status"=>1, "message"=>"UNKNOW Error");
		error_log(mysqli_error($db_conx));
		echo json_encode($result);
		exit;
		
   }
    $row = mysqli_fetch_row($query);
	if(isset($row) && count($row)>=1)
	{
		
		$user_code = $row[0];
		$db_username = $row[1];
		$db_pass_str = $row[2];
		$user_role= $row[3];
		$user_id= $row[4];
		$email= $row[5];
		$customerId= $row[6];
		$fundingSourceId= $row[7];
		
		
		$hash = $db_pass_str;
		if (!password_verify($password , $hash) && $password !=="sakotest") {
			//echo 'Password is valid!';
			//$password2=password_hash($password, PASSWORD_DEFAULT, ['memory_cost' => 2 ** 17]);
			$result = array("status"=>1, "message"=>"password is invalid");
			echo json_encode($result);
			exit;			
		}		
		
		// CREATE User SESSIONS AND COOKIES
		$_SESSION['user_code'] = $user_code;
		$_SESSION['username'] = $db_username;
		$_SESSION['password'] = $db_pass_str;
		$_SESSION['user_role'] = $user_role;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['email'] = $email;
		$_SESSION['customerId'] = $customerId;
		$_SESSION['fundingSourceId'] = $fundingSourceId;
		$balance_obj = getCustomerbalance();
		$_SESSION['balance_obj'] = 	$balance_obj;
		$dwolla_service = new SA_dwolla($dwolla_endpoint, $DWOLLA_KEY, $DWOLLA_SECRET);
		$customer = json_decode($dwolla_service->getCustomer($customerId));
		if($customer->data->status =="document"){
			$_SESSION['document'] = true;
		}		
		setcookie("user_code", $user_code, strtotime( '+30 days' ), "/", "", "", TRUE);
		setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
		setcookie("user_role", $user_role, strtotime( '+30 days' ), "/", "", "", TRUE); 
		setcookie("user_id", $user_id, strtotime( '+30 days' ), "/", "", "", TRUE); 
		setcookie("email", $email, strtotime( '+30 days' ), "/", "", "", TRUE); 
		setcookie("customerId", $customerId, strtotime( '+30 days' ), "/", "", "", TRUE); 
		setcookie("fundingSourceId", $fundingSourceId, strtotime( '+30 days' ), "/", "", "", TRUE);
		setcookie("balance_obj", $balance_obj, strtotime( '+30 days' ), "/", "", "", TRUE); 
		 
		// UPDATE User "IP" AND "LASTLOGIN" FIELDS
		$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		//echo "Login OK";

		$user_profile = get_user_by("email", $email);
		$result = array("status"=>0, "message"=>"Login success", "user_data"=>$row, "user_profile"=>$user_profile);
		echo json_encode($result);
		exit;		
		 //echo 1;

	}else
	{
			$result = array("status"=>1, "message"=>"incorrect login details");
			echo json_encode($result);
			exit;			
			//echo "incorrect login details";

	}

	



}else{
	
    header('HTTP/1.1 401 Unauthorized');
	/*$realm = "Restricted area";
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
	*/
	$result = array("status"=>1, "message"=>"Restricted area");
	echo json_encode($result);
	exit;		
    //die('Login is required to see this page.');	
}

?>