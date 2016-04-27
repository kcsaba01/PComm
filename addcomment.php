<?php
session_start();
include("connection.php"); //Establishing connection with our database
include("utilities.php"); //contains the prepared statements
$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"])) {
    $desc = $_POST["desc"];
    $photoID = $_POST["photoID"];

    //Sanitising the input
    $desc = mysqli_real_escape_string($db, $desc);
    $photoID = mysqli_real_escape_string($db, $photoID);

    //getting the userID from session
    $name = $_SESSION["username"];
    $sql = "SELECT userID FROM users WHERE username='$name'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) == 1) {
        $id = $row['userID'];
    } else {
        $msg = "You need to login first";
    }

    if ($stmt = mysqli_prepare($db,"INSERT INTO comments (description, postDate, userID, photoID) VALUES (?,NOW(), ?, ?)")) //Preparing the statement
    {
        mysqli_stmt_bind_param($stmt, "sii", $desc, $id, $photoID); //Binding the variables
        if (mysqli_stmt_execute($stmt))
        {
            $msg="Comment added successfully";
        }
        else
        {
            $msg =mysqli_stmt_error($stmt) . " Adding comment failed"; //Displaying the reason why the adding has failed
        }
        mysqli_stmt_close($stmt); //closing the statement
    }
    mysqli_close($db); //closing the connection
}

?>