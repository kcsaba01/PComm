<?php
/**
 * Created by PhpStorm.
 * User: Csaba Keresztessy <0811994@rgu.ac.uk>
 * Date: 01/05/2016
 * PHP script that logs a user off after 3 minutes innactivity
 */
//checking sesssion information
session_start();
$sessionIP = $_SESSION["IP"];
$currentIP = getenv("REMOTE_ADDR");
if (($currentIP != $sessionIP) or ($_SESSION['timeout'] + 180 < time())) //checking if the IP has changed or if the session if no action was performed in the last 13 minutes
{
    session_destroy();
    header("Location: index.php");
}
?>