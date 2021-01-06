<?php
	include_once("php_includes/check_login_status.php");
	include_once("php_includes/config.php");
	if($user_ok == true){

		header("location: account/");

		exit();

	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&amp;display=swap" rel="stylesheet" />
        <link href="assets/images/nprogress.css" rel="stylesheet" />
        <meta charset="utf-8" />
        <meta name="viewport" content="minimum-scale=1, initial-scale=1, width=device-width" />
		<link rel="icon" type="image/png" href="../assets/images/favicon.png"/>
        <title>Login | Kassa Me</title>
        <meta name="next-head-count" content="3" />
		 <link rel="stylesheet" type="text/css" href="assets/css/jquery.toast.min.css" />
		<link rel="stylesheet" href="assets/css/style.css">
		
        <style id="jss-server-side">
        </style>
        <style data-styled="" data-styled-version="5.1.1">
        </style>
    </head>
    <body>