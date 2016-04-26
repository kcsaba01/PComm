<?php
/**
 * Created by PhpStorm.
 * User: Csaba
 */
include("connection.php");



function xsssafe($data,$encoding='UTF-8') //function to clear user input
{
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
}


function xecho($data) //function to clear output
{
    echo(xsssafe($data));
}

//SQL Prepared statements
if (!($addcomm=$mysqli->prepare("INSERT INTO comments (description, postDate,photoID,userID) VALUES (?,?,?,?)")))
{
    xecho("Prepare failed: (" . $mysqli ->errno . ") " . $mysqli->error);
}
?>