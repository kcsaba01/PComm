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
    if ($stmt = mysqli_prepare($db,"INSERT INTO users (username, email, password, admin, attempt) VALUES (?, ?, ?, ?, ?)" ))
    {
        mysqli_stmt_bind_param($stmt, "s", $name, $email, $password, $admin, $attempt);
        if (mysqli_stmt_execute($stmt))
        {
            $msg="Success";
        }
        else
        {
            $msg =$name;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($db);
    //checking for illegal characters
    //$username = mysqli_real_escape_string($db, $username);
    //$password = mysqli_real_escape_string($db, $password);
    //$email = mysqli_real_escape_string($db, $email);

    //storing the hash instead of the password
    //$password = md5($password);

    //Prepared statement
    //$query= "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    //$reguser = $conn->prepare($query);

    //Binding the parameter
    //if (!($reguser->bind_param("reguser", $name, $email, $password))) {
     //   xecho("Binding has failed" . $reguser->errno . " " . $reguser->error);
    //}

    //Executing, error will be returned if the email already exists
//    if (!$reguser->execute()) {
  //      xecho ("Execute has failed" . $reguser->errno . " " . $reguser->error);
    //} else {
      //  $msg = "Thank You! you are now registered. click <a href='index.php'>here</a> to login";
        //$reguser->close();
        //$conn->close();
    //}
}
?>