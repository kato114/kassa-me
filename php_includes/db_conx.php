<?php
include("config.php");
$db_conx = mysqli_init();
if (!$db_conx) {
    die('mysqli_init failed');
}

if (!$db_conx->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 1')) {
    die('Setting MYSQLI_INIT_COMMAND failed');
}

if (!$db_conx->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
    die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
}

$res_conx = $db_conx->real_connect(null, $db_username, $db_password, $db_name, null, sprintf("/cloudsql/%s", $cloud_sql_connection_name));
if (!$res_conx) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}
/* change character set to utf8 */
/*if (!$db_conx->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $db_conx->error);
}*/
 function checkUserStatus($staus)
{
			global $db_conx;
			global $log_username;
			$sql = "SELECT `ID` from users where (user_role=1 and username='$log_username') or (`$staus`=1 and username='$log_username')";
			//echo $sql;
			$query = mysqli_query($db_conx, $sql);
			if (!$query) 
			{
				echo "DB Error, could not query the database\n";
				echo 'MySQL Error: ' . mysqli_error($db_conx);
				exit;
			}
			if (mysqli_num_rows($query)>0)
			{
                    return true;															
            }	
            return false;															
}
?>