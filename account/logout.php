<?php

session_start();

// Set Session data to an empty array

$_SESSION = array();


if(isset($_COOKIE["user_code"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {

	setcookie("user_code", '', strtotime( '-5 days' ), '/');

    setcookie("user", '', strtotime( '-5 days' ), '/');

	setcookie("pass", '', strtotime( '-5 days' ), '/');

}

// Destroy the session variables

session_destroy();

// Double check to see if their sessions exists

if(isset($_SESSION['username'])){

	header("location: message.php?msg='Logout Failed'");

} else {

	header("location: ../index.php");

	exit();

} 

?>