<?php
define('DB_SERVER', 'ap-cdbr-azure-east-c.cloudapp.net');
define('DB_USERNAME', 'bed4ebe251b726');
define('DB_PASSWORD', '1370829c');
define('DB_DATABASE', 'pcommdb');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
//$conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
?>
