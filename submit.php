<?php
$msg = "";
include("connection.php");
include("utilities.php");
//include("sessioncheck.php");
if(isset($_POST["submit"]))
{

    $name = $_POST["username"];
    $email = $_POST["email"]; //changed the database so it will need to be unique
    $password = $_POST["password"];
    $name = xsssafe($name);
    $email = xsssafe($email);
    $password = md5($password);
    $admin=0;
    $attempt=1;
        if ($stmtr = mysqli_prepare($db,"INSERT INTO users (username, password, email, admin, attempt) VALUES (?, ?, ?, ?, ?)" )) //Preparing the statement
    {
        mysqli_stmt_bind_param($stmtr, "sssii", $name, $password, $email, $admin, $attempt); //Binding the variables
        if (mysqli_stmt_execute($stmtr))
        {
            $msg="Thank You! you are now registered";
        }
        else
        {
            $msg = "Adding user failed"; //Keeping the message intentionally vague to not give out extra information about the DB
        }
        mysqli_stmt_close($stmtr); //closing the statement
    }
}
?>