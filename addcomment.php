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
//Prepared statement
    $addcomment = $conn->prepare("INSERT INTO comments (description, postDate, userID, photoID) VALUES (?,NOW(), ?, ?)");
//Binding the parameter, the statement is contained in utilities.php
    if (!($addcomment->bind_param("sss", $desc, $id, $photoID))) {
        xecho("Binding has failed" . $addcomment->errno . " " . $addcomment->error);
    }
//Executing
    if (!$addcomment->execute()) {
        xecho("Execute has failed" . $addcomment->errno . " " . $addcomment->error);
    } else {
        $msg = "Comment added successfully";
    }
    
}
$addcomment->close();
$conn->close();
?>