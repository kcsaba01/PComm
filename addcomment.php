<?php
include("connection.php"); //Establishing connection with our database
include("sessioncheck.php");
include("utilities.php");

session_start();
$msg = ""; //Variable for storing our errors.

if(isset($_POST["submit"])) {
    $desc = $_POST["desc"];
    $photoID = $_POST["photoID"];
  
    //Sanitising the input

    $desc=xsssafe($desc);
    $photoID = xsssafe($photoID);
    $desc = mysqli_real_escape_string($db, $desc);
    $photoID = mysqli_real_escape_string($db, $photoID);

    //getting the userID from session

    if ($_SESSION['userid'] !="")
    {
        $id = $_SESSION['userid'];
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
            $msg ="Adding comment failed"; //Displaying the reason why the adding has failed
        }
        mysqli_stmt_close($stmt); //closing the statement
    }
    mysqli_close($db); //closing the connection
}

?>