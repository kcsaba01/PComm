<?php
$msg = "";
include("connection.php");
if(isset($_POST["submit"]))
{
    $name = $_POST["username"];
    $email = $_POST["email"]; //changed the database so it will need to be unique
    $password = $_POST["password"];

    //checking for illegal characters
    $username = mysqli_real_escape_string($db, $username);
    $password = mysqli_real_escape_string($db, $password);
    $email = mysqli_real_escape_string($db, $email);

    //storing the hash instead of the password
    $password = md5($password);

    //Prepared statement
    $reguser = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    //Binding the parameter
    if (!($reguser->bind_param("reguser", $name, $email, $password))) {
        xecho("Binding has failed" . $reguser->errno . " " . $reguser->error);
    }

    //Executing, error will be returned if the email already exists
    if (!$reguser->execute()) {
        xecho ("Execute has failed" . $reguser->errno . " " . $reguser->error);
    } else {
        $msg = "Thank You! you are now registered. click <a href='index.php'>here</a> to login";
        $reguser->close();
        $conn->close();
    }
}
?>