<?php
$username = 'root';
$password = 'B9AJqjustrucFtzF';
$dbName = 'kassame';
$cloud_sql_connection_name = "kassa-me:us-west2:kassamephp2";//getenv("CLOUD_SQL_CONNECTION_NAME");
// // $hostname = "127.0.0.1"; // Only used in TCP mode.

$hostname = false;
if ($hostname) {
    // Connect using TCP
    $dsn = sprintf('mysql:dbname=%s;host=%s', $dbName, $hostname);
} else {
    // Connect using UNIX sockets
    $dsn = sprintf(
        'mysql:dbname=%s;unix_socket=/cloudsql/%s',
        $dbName,
        $cloud_sql_connection_name
    );
}

// Connect to the database.
// Here we set the connection timeout to five seconds and ask PDO to
// throw an exception if any errors occur.
$conn = new PDO($dsn, $username, $password, [
    PDO::ATTR_TIMEOUT => 5,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
print_r($conn);
echo "<br />*****************************<br />";

$db_conx = mysqli_connect(null, $username, $password , $dbName, null, sprintf("/cloudsql/%s", $cloud_sql_connection_name));
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();

}
print_r($db_conx);