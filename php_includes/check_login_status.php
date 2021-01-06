<?php
session_start(); 
include_once("db_conx.php");
include_once("config.php");

$user_ok = false;

$log_id = "";

$log_username = "";

$log_password = "";

$user_code="";

$user_role="0";

// User Verify function

function evalLoggedUser($conx,$u,$p,$user_code){

	$sql = "SELECT ip FROM users WHERE activation_code='$user_code' AND username='$u' AND password='$p' AND is_active='1' LIMIT 1";
    Global $db_conx;
    $query = mysqli_query($conx, $sql);
    if (!$query)
	{
		echo "DB Error, could not query the database\n";
		echo 'MySQL Error: ' . mysqli_error($db_conx);
		exit;
   }
    $numrows = mysqli_num_rows($query);
	if($numrows > 0){

		return true;

	}else
	{
	  return false;
	}

}

if(isset($_SESSION["user_code"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])) {

	$user_code = preg_replace('#[^\P{Cyrillic}0-9]#', '', $_SESSION['user_code']);

	$log_username = preg_replace('#[^\P{Cyrillic}a-z0-9]#i', '', $_SESSION['username']);

	$log_password = preg_replace('#[^\P{Cyrillic}a-z0-9]#i', '', $_SESSION['password']);

	// Verify the user
	$user_ok = evalLoggedUser($db_conx,$log_username,$log_password,$user_code);
	$user_role=$_SESSION['user_role'];
	

} else if(isset($_COOKIE["user_code"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])){

	$_SESSION['user_code'] = preg_replace('#[^\P{Cyrillic}0-9]#', '', $_COOKIE['user_code']);

    $_SESSION['username'] = preg_replace('#[^\P{Cyrillic}a-z0-9]#i', '', $_COOKIE['user']);

    $_SESSION['password'] = preg_replace('#[^\P{Cyrillic}a-z0-9]#i', '', $_COOKIE['pass']);
	
	$_SESSION['user_role']=$_COOKIE['user_role'];
	$_SESSION['user_id']=$_COOKIE['user_id'];
	$_SESSION['email'] = $_COOKIE['email'];	
	$_SESSION['customerId'] = $_COOKIE['customerId'];	
	$_SESSION['fundingSourceId'] = $_COOKIE['fundingSourceId'];	
	$_SESSION['balance_obj'] = $_COOKIE['balance_obj'];	

	$user_code = $_SESSION['user_code'];

	$log_username = $_SESSION['username'];

	$log_password = $_SESSION['password'];
	$user_role=$_SESSION['user_role'];
	// Verify the user

	$user_ok = evalLoggedUser($db_conx,$log_id,$log_username,$log_password);

	if($user_ok == true){

		// Update their lastlogin datetime field

		$sql = "UPDATE users SET lastlogin=now() WHERE activation_code='$user_code' LIMIT 1";

        $query = mysqli_query($db_conx, $sql);

	}

}

?>