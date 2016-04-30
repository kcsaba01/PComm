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
    //checking for illegal characters
    $desc = xsssafe($desc);
    $title = xsssafe($title);
    $desc = mysqli_real_escape_string($db, $desc);
    $title = mysqli_real_escape_string($db, $title);
    
    //Setting the path
    $target_dir = "uploads/";
    $target_file = $target_dir . xsssafe(basename($_FILES["fileToUpload"]["name"]));
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $uploadOk = 1;

    //Finding the userID of the logged in user
    $sql="SELECT userID FROM users WHERE username='$name'";
    $result=mysqli_query($db,$sql);
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

    if(mysqli_num_rows($result) == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $id = $row['userID'];
            if ($stmt = mysqli_prepare($db,"INSERT INTO photos (title, description, postDate, url, userID) VALUES (?, ?, NOW(), ?, ?)")) //Preparing the statement
            {
                mysqli_stmt_bind_param($stmt, "sssi", $title, $desc, $target_file, $id); //Binding the variables
                if (mysqli_stmt_execute($stmt))
                {
                    $msg="Thank You! The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded";
                }
                else
                {
                    $msg =mysqli_stmt_error($stmt) . ". There was an error uploading your file."; //Displaying the reason why the adding has failed
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