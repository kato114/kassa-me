<?php
include_once("php_includes/db_conx.php");
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/Exception.php');
require_once('PHPMailer/src/SMTP.php');
require_once('PHPMailer/src/POP3.php');
include_once("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function get_user_id($email, $password, $enconding_pwd=""){
	
		global $db_conx;	
		$result= 0;
		
		$sql = "SELECT ID FROM `users`  where email='$email' and (password='$password' or password='$enconding_pwd')";
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			return 0;
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result=$row["ID"];
			return $result;
		}
			   
		return $result;	
}
function get_transaction($email, $condition){
	
		global $db_conx;	
		$result= "";
		$email = mysqli_escape_string($db_conx, $email);
		
		$sql = "SELECT * FROM `transactions`  where (email='$email') AND $condition ";
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			return $result;
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result=$row;
			return $result;
		}
			   
		return $result;	
}
function get_user_role($user_id){
	
		global $db_conx;	
		$result= 0;
		
		$sql = "SELECT user_role FROM `users`  where ID=$user_id";
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			return 0;
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result=$row["user_role"];
			return $result;
		}
			   
		return $result;	
}
function get_user_profile($user_id, $table='profile_patients'){
	
		global $db_conx;	
		$result= array("full_name"=>"", "age"=>"", "gender"=>"", "height"=>"", "weight"=>"");
		
		$sql = "SELECT * FROM `$table`  where user_id='$user_id'";
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			return $result;
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result=$row;
			return $result;
		}
			   
		return $result;	
}
function find_user($keyword, $condition=""){
	
		global $db_conx;	
		$result= "";
		$keyword = mysqli_escape_string($db_conx, $keyword);
		
		$sql = "SELECT * FROM `users`  where (username='$keyword' or email='$keyword') AND $condition ";
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			return $result;
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result=$row;
			return $result;
		}
			   
		return $result;	
}
function get_users($user_role){
	
		global $db_conx;	
		$result= array();
		
		$sql = "SELECT * FROM `users` WHERE  user_role=$user_role";
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			return $result;
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result[]=$row;			
		}
			   
		return $result;	
}
function add_parent($userid, $parent_id){
	
		global $db_conx;	
		$result= false;
		
		$sql = "UPDATE `profile_patients`  set parent_id=$parent_id where user_id=$userid";
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			return $result;
			exit;
		}else{
			return true;
		}
			   
		return $result;	
}
function get_parent($user_id){
	
		global $db_conx;	
		$result= array();
		
		$sql = "SELECT * FROM `users`  where ID=$user_id";
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			return $result;
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result=array("ID"=>$row["ID"], "username"=>$row["username"]);
			return $result;
		}
			   
		return $result;	
}
function get_childs($user_id){
	
		global $db_conx;	
		$result= array();
		
		$sql = "SELECT * FROM `users`  where ID in(select user_id from profile_patients WHERE parent_id=$user_id)";
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			return $result;
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result[]=array("ID"=>$row["ID"], "uniqid"=>$row["uniqid"], "username"=>$row["username"]);
			return $result;
		}
			   
		return $result;	
}
function upload_sensor($single_zip, $user_id, $subjectCode, $StartedAt, $trialNumber, $SensorLeft, $SensorRight){
	
	if($single_zip !=""){
		
		$zip = new ZipArchive;
		if ($zip->open($single_zip) === TRUE) {	
			$des_folder = str_replace(".zip", "", $single_zip);
			$zip->extractTo($des_folder);
			$zip->close();
			$csv_file_left = $des_folder."/data_left.csv";
			$csv_data_left = load_csv($csv_file_left);
			$csv_file_right = $des_folder."/data_right.csv";
			$csv_data_right = load_csv($csv_file_right);	
			$path = getcwd();
			$output = shell_exec($path.'/shell/algo/ClinicApp.exe 2>&1 '.$path.'/'.$csv_file_left.' left');			
			$chart_data_left = $output;
			$output = shell_exec($path.'/shell/algo/ClinicApp.exe 2>&1 '.$path.'/'.$csv_file_right.' right');
			$chart_data_right = $output;
			save_sensor_data($user_id, $subjectCode, $StartedAt, $trialNumber, $SensorLeft, $SensorRight, json_encode($csv_data_left), json_encode($csv_data_right), $chart_data_left, $chart_data_right);
			error_log("Unzipped file '$single_zip'");
			//unlink($single_zip);
		} else {
			//echo 'failed';
			error_log("Filed to unzip file '$single_zip'");
		}
		return;
	}	
}

function load_csv($csv_file){
	$result = array();
	$row = 1;
	if (($handle = fopen($csv_file, "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			if($row == 1){
				$row++;
				continue;
			}
			$row++;
			$result[] = $data;
		}
		fclose($handle);
	}
		return $result;
}
function save_sensor_data($user_id, $subjectCode, $StartedAt, $trialNumber, $SensorLeft, $SensorRight, $sensor_data_left, $sensor_data_right, $chart_data_left, $chart_data_right){
	global $db_conx;
	$sql = "INSERT INTO sensor_data(`user_id`, `subjectCode`, `StartedAt`, `trialNumber`, `SensorLeft`, `SensorRight`, `sensor_data_left`, `sensor_data_right`, `chart_data_left`, `chart_data_right`)VALUES('$user_id', '$subjectCode', '$StartedAt', '$trialNumber', '$SensorLeft', '$SensorRight', '$sensor_data_left', '$sensor_data_right', '$chart_data_left', '$chart_data_right')";
	$query = mysqli_query($db_conx, $sql);
	if (!$query) 
	{
		echo mysqli_error($db_conx)."=>".$sql;
		error_log(mysqli_error($db_conx));
		exit;
	}	
}
function get_chart_data($user_id, $field, $date="")
{
		global $db_conx;
		
		$result=array();
		
		$sql = "SELECT $field FROM `sensor_data`  where user_id=$user_id and date='$date' LIMIT 1";
		if(empty($date))
			$sql = "SELECT $field FROM `sensor_data` where user_id=$user_id LIMIT 1";
		
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			echo "DB Error, could not query the database\n";
			echo 'MySQL Error: ' . mysqli_error($db_conx);
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$json_data = json_decode($row[$field]);
			foreach($json_data as $elem){
				$result [] = array(floatval($elem[1]), floatval($elem[2]));
			}
			//$result[]=$row;
		}
			   
		return json_encode($result);
}
function get_chart_date($user_id)
{
		global $db_conx;
		
		$result=array();
		
		$sql = "SELECT date FROM `sensor_data` WHERE user_id=$user_id";
		
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			echo "DB Error, could not query the database\n";
			echo 'MySQL Error: ' . mysqli_error($db_conx);
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result[]=$row["date"];
		}
			   
		return $result;
}
function get_user_messages($user_id)
{
		global $db_conx;
		
		$result=array();
		
		if(!$user_id)
			return $result;
		
		$sql = "SELECT * FROM `pm`  where user2=$user_id";
		
		//echo $sql;
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			echo "DB Error, could not query the database\n";
			echo 'MySQL Error: ' . mysqli_error($db_conx);
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result[]=$row;
		}
			   
		return $result;
}
function get_user_single_messages($user_id, $message_id)
{
		global $db_conx;
		
		$result=array();
		
		if(!$user_id)
			return $result;		

		$sql = "SELECT * FROM `pm`  where user2=$user_id and id=$message_id";
		
		//echo $sql;
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			echo "DB Error, could not query the database\n";
			echo 'MySQL Error: ' . mysqli_error($db_conx);
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result[]=$row;
		}
			   
		return $result;
}
function get_reviews($user_id)
{
		global $db_conx;
		
		$result=array();
		
		if(!$user_id)
			return $result;

		$sql = "SELECT * FROM `review`  where ID_user=$user_id";
		
		//echo $sql;
		$query = mysqli_query($db_conx, $sql);
		if (!$query) 
		{
			echo "DB Error, could not query the database\n";
			echo 'MySQL Error: ' . mysqli_error($db_conx);
			exit;
		}
		while ($row = mysqli_fetch_assoc($query)) 
		{
			$result[]=$row;
		}
			   
		return $result;
}
function send_email2($subject, $message, $to)
{


	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);
	$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = $smtp_server;
	$mail->Port = $smtp_port; // or 587
	$mail->IsHTML(true);
	$mail->Username = $smtp_username;
	$mail->Password = $smtp_password;
	$mail->SetFrom($smtp_username, "Clinic App");
	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->AddAddress($to);

	 if(!$mail->Send()) {
		return 0;
	 } else {
		return 1;		
		exit;

	}
}