<?php
$msg = "";
include("connection.php");
include("utilities.php");

if(isset($_POST["submit"]))
{

    $name = $_POST["username"];
    $email = $_POST["email"]; //changed the database so it will need to be unique
    $password = $_POST["password"];
    $admin=0;
    $attempt=1;
    
    if ($stmt = mysqli_prepare($db,"INSERT INTO users (username, password, email, admin, attempt) VALUES (?, ?, ?, ?, ?)" )) //Preparing the statement
    {
        mysqli_stmt_bind_param($stmt, "sssii", $name, $password, $email, $admin, $attempt); //Binding the variables
        if (mysqli_stmt_execute($stmt))
        {
            $msg="Thank You! you are now registered. click <a href='index.php'>here</a> to login";
        }
        else
        {
            $msg =mysqli_stmt_error($stmt) . " Adding user failed"; //Displaying the reason why the adding has failed
        }
        mysqli_stmt_close($stmt); //closing the statement
    }
    mysqli_close($db); //closing the connection
}
?>