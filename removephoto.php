<?php
session_start();
include("connection.php"); //Establishing connection with our database
include("sessioncheck.php");
include("utilities.php");


if(isset($_GET['id']) and is_numeric($_GET['id']))
{
    $photoID = $_GET['id'];
    if ($stmt2 = mysqli_prepare($db,"DELETE FROM photos WHERE photoID='?'")) //Preparing the statement
    {
        mysqli_stmt_bind_param($stmt2, "i", $photoID); //Binding the variables
        if (mysqli_stmt_execute($stmt))
        {
            header("Location: photos.php");
        }
        else
        {
            xecho ("Sorry, there was an error deleting the file.");
        }
        mysqli_stmt_close($stmt2); //closing the statement
    }
}

?>