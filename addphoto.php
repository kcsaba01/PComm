<?php
session_start();
include("connection.php"); //Establishing connection with our database
include("utilities.php"); //contains the prepared statements
$msg = ""; //Variable for storing our errors.
$title="title1";
$desc="desc1";
$target_file="targetfile1";
$id=1;
if(isset($_POST["submit"])) {
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $url = "test";
    $name = $_SESSION["username"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $uploadOk = 1;

    $sql = "SELECT userID FROM users WHERE username='$name'";
    $result = $conn->query($sql);
    if ($result->num_rows = 1) {
        $id = $row['userID'];
    } else {
        $msg = "You need to login first";
    }


//Binding the parameter, the statement is contained in utilities.php
    if (!($insertphotos->bind_param("ssst", $title, $desc, $target_file, $id))) {
        xecho("Binding has failed" . $insertphotos->errno . " " . $insertphotos->error);
        xecho($title . $desc . $target . $id);
    }
//Executing
    if (!$insertphotos->execute()) {
        xecho("Execute has failed" . $insertphotos->errno . " " . $insertphotos->error);
    }
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        $msg = "Thank You! The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded. click <a href='photos.php'>here</a> to go back";
    } else {
        $msg = "Sorry, there was an error uploading your file.";
    }
}
?>