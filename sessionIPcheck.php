<?php
/**
 * Created by PhpStorm.
 * User: Csaba
 * Date: 30/04/16
 * Time: 16:18
 */
session_start();
$sessionIP = $_SESSION["IP"];
echo($sessionIP . "123");
$currentIP = getenv("REMOTE_ADDR");
if ($currentIP != $sessionIP)
{
    $error = "Your IP address has changed, please login again!";
    session_destroy();
    header("Location: index.php");
}
?>