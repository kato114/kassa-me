<?php
include_once("php_includes/db_conx.php");
include_once("inc/functions.php");

     if(isset($_POST['email'])){

		   $email=$_POST['email'];
		   $p_hash = md5($email."->".uniqid());
		   $sql = "Update users set recovery_code='$p_hash' where email='$email'";
		   $query = mysqli_query($db_conx, $sql);
		   if (!$query) 
		   {
				$result = array("status"=>1, "message"=>"Unknow error");
				echo json_encode($result);
				exit;
		   }
		   if(mysqli_affected_rows($db_conx)>0)
		   {
			   
			    sendPasswordResetToken($p_hash, $email);

		   }
		   $message="You will receive a reset email if you have an account
		   <br /> Please, click on the link to recover your password";

		   $result = array("status"=>0, "message"=>$message);
		   echo json_encode($result);
		   exit;			   		   		
		}else if(isset($_POST['new_password']) && isset($_POST['token'])){
		   $password=password_hash($_POST['new_password'], PASSWORD_DEFAULT/*PASSWORD_ARGON2I*/, ['memory_cost' => 2 ** 17]);
		   $token = $_POST['token'];
		   $p_hash = md5(uniqid());
		   $sql = "Update users set password='$password', updatedAt=now(), recovery_code='$p_hash' where recovery_code='$token'";
		   $query = mysqli_query($db_conx, $sql);
		   if (!$query) 
		   {
				$result = array("status"=>1, "message"=>"Unknow error");
				echo json_encode($result);
				exit;
		   }
		   if(mysqli_affected_rows($db_conx)>0)
		   {
			   $message="Password has been changed";

			   $result = array("status"=>0, "message"=>$message);
			   echo json_encode($result);
			   exit;	
		   }else{
			   $message="Incorrect user details.";

			   $result = array("status"=>1, "message"=>$message);
			   echo json_encode($result);
			   exit;				   
		   }			
		}else{
			$result = array("status"=>1, "message"=>"Missing field(s)");
			echo json_encode($result);
			exit;		
		}
		