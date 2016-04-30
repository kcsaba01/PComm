<?php
/**
 * Created by PhpStorm.
 * User: Csaba
 */

function xsssafe($data,$encoding='UTF-8') //function to clear user input
{
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
}


function xecho($data) //function to clear output
{
    echo(xsssafe($data));
}

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
