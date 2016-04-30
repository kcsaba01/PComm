<?php
include("sessioncheck.php");
include("utilities.php");
$resultText = "";
if(isset($_POST["submit"]))
{
    $name = $_POST["username"];
    $name = mysqli_real_escape_string($db, $name);
    $name = xsssafe($name);
    //getting the user id from the username
    $stmt3 = mysqli_prepare($db,"SELECT userID FROM users WHERE username=?");
    mysqli_stmt_bind_param($stmt3, "s", $name);
    mysqli_stmt_execute($stmt3);
    mysqli_stmt_bind_result($stmt3, $result3);
    mysqli_stmt_fetch($stmt3);
    $searchID = $result3;
    mysqli_stmt_close($stmt3);
    if ($searchID != "")
    {
        $searchSql= mysqli_prepare($db,"SELECT title, photoID FROM photos WHERE userID=?");
        mysqli_stmt_bind_param($searchSql, "s", $searchID);
        mysqli_stmt_execute($searchSql);
        mysqli_stmt_bind_result($searchSql, $title, $photo);
        if ($searchSql != "") {
            while (mysqli_stmt_fetch($searchSql)) {
                $line = "<p><a href='photo.php?id=" . xsssafe($photo) . "'>" . xsssafe($title) . "</a></p>";
                $resultText = $resultText . $line;
            }
        }
        else{
            $resultText = "no photos by user";
        }
    }
    else
    {
        $resultText = "no user with that username";

    }
}
?>