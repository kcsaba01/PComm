<?php
include('connection.php');
session_start();
$user_check=$_SESSION['username'];

$ses_sql = mysqli_query($db,"SELECT username, admin, userID FROM users WHERE username='$user_check'");
$row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
$login_user= $row['username']; //Variable to store the logged in username
$login_userid = $row['userID']; //Variable to store the logged in username
if($row['admin']==1){
    $adminuser = true;
}

if(!isset($user_check))
{
header("Location: index.php");
}
?>