<?php
session_start();
include("connection.php"); //Establishing connection with our database
include("utilities.php");
$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"]))
{
    $desc = $_POST["desc"];
    $photoID = $_POST["photoID"];
    $desc = mysqli_real_escape_string($db, $desc);
    $photoID = mysqli_real_escape_string($db, $photoID);
    $name = $_SESSION["username"];

    $sql="SELECT userID FROM users WHERE username='$name'";
    $result=mysqli_query($db,$sql);
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(mysqli_num_rows($result) == 1) {
        //echo $name." ".$email." ".$password;
        $id = $row['userID'];
        //$addsql = "INSERT INTO comments (description, postDate,photoID,userID) VALUES ('$desc',now(),'$photoID','$id')";
        //$query = mysqli_query($db, $addsql) or die(mysqli_error($db));
        if(!$addcomm->bind_param("addcomm", $desc,$photoID,$id))
        {
            echo("Binding parameters failed " . $addcomm->errno . " " . $addcomm->error);
        }
        if (!$addcomm ->execute())
        {
            echo("Execute failed");
        }
        if ($query) {
            $msg = "Thank You! comment added. click <a href='photo.php?id=".$photoID."'>here</a> to go back";
        }
    }
    else{
        $msg = "You need to login first";
    }
}

?>