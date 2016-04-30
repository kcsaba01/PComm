<?php
include("connection.php"); //Establishing connection with our database
include("sessioncheck.php");
include("utilities.php");
session_start();
$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"]))
{
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $url = "test";
    $name = $_SESSION["username"];

    //Sanitising the input
    $desc = xsssafe($desc);
    $title = xsssafe($title);
    $desc = mysqli_real_escape_string($db, $desc);
    $title = mysqli_real_escape_string($db, $title);
    
    //Setting the path
    $target_dir = "uploads/";
    $targetfile= xsssafe(basename($_FILES["fileToUpload"]["name"]));
    $targetfile = mysqli_real_escape_string($db, $targetfile);
    $target_file = $target_dir . $targetfile;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $uploadOk = 1;
    

    if($_SESSION['userid'] != "") { //retrieving the user id from session
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $id = $_SESSION['userid'];
            if ($stmt = mysqli_prepare($db,"INSERT INTO photos (title, description, postDate, url, userID) VALUES (?, ?, NOW(), ?, ?)")) //Preparing the statement
            {
                mysqli_stmt_bind_param($stmt, "sssi", $title, $desc, $target_file, $id); //Binding the variables
                if (mysqli_stmt_execute($stmt))
                {
                    $msg="Thank You! The file ". $target_file. " has been uploaded";
                }
                else
                {
                    $msg ="There was an error uploading your file."; //Displaying the reason why the adding has failed
                }
                mysqli_stmt_close($stmt); //closing the statement
            }
        }
    }
    else{
        $msg = "You need to login first";
    }
    mysqli_close($db); //closing the connection
}

?>