<?php
/**
 * Created by PhpStorm.
 * User: Csaba
 * Date: 30/04/16
 * Time: 16:18
 */
include("connection.php");
session_start();
$sessionIP = $_SESSION["IP"];
echo($sessionIP . "123");

$uname = $_SESSION["username"];
$uname = mysqli_real_escape_string($db, $uname);

//retrieving the stored IP address
if ($stmtIP = mysqli_prepare($db,"SELECT remoteip FROM users WHERE uname=?")) //Preparing the statement
{
    mysqli_stmt_bind_param($stmtIP, "s", $uname); //Binding the variable
    if (mysqli_stmt_execute($stmtIP))
    {
        mysqli_stmt_bind_result($stmtIP, $result);
        mysqli_stmt_fetch($stmtIP);
        if (!($result ==$sessionIP))
        {
            session_destroy();
            $error="Your IP has changed, please login again";
            header("Location: index.php");
        }
    }
}