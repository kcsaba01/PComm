<?php
session_start();
include("connection.php"); //Establishing connection with our database

$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"]))
{
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $title = mysqli_real_escape_string($db, $title);
    $desc = mysqli_real_escape_string($db, $desc);
    $url = "test";
    $name = $_SESSION["username"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $uploadOk = 1;

    $sql="SELECT userID FROM users WHERE username='$name'";
    $result=mysqli_query($db,$sql);
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

    if(mysqli_num_rows($result) == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $id = $row['userID'];
            //$addsql = "INSERT INTO photos (title, description, postDate, url, userID) VALUES ('$title','$desc',now(),'$target_file','$id')";
            //$query = mysqli_query($db, $addsql) or die(mysqli_error($db));
            //if ($query) {
            //    $msg = "Thank You! The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded. click <a href='photos.php'>here</a> to go back";
            //}

        } else {
            $msg = "Sorry, there was an error uploading your file.";
        }
    }
    else{
        $msg = "You need to login first";
    }
}
//Binding the parameter, the statement is contained in utilities.php
if(!($insertphotos->bind_param("ssst", $title,$desc,$target_file,$id)))
{
    xecho("Binding has failed" . $insertphotos->errno . " " . $insertphotos->error);
}
//Executing
if (!$insertphotos->execute())
{
    xecho("Execute has failed" . $insertphotos->errno . " " . $insertphotos->error);
}
else
{
    $msg = "Thank You! The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded. click <a href='photos.php'>here</a> to go back";
}
?>