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
//Prepared statement to add a comment
$addcomment = $conn->prepare("INSERT INTO comments (description, postDate, userID, photoID) VALUES (?,NOW(), ?, ?)");
$insertphotos = $conn->prepare("INSERT INTO photos (title, description, postDate, url, userID) VALUES (?,?,NOW(),?,?)");
?>

INSERT INTO photos (title, description, postDate, url, userID) VALUES ('$title','$desc',now(),'$target_file','$id')";