<?php
include("sessioncheck.php");
include("utilities.php");
$resultText = "";
if(isset($_SESSION['username']))
{
    $name = $_SESSION["username"];
    $sql="SELECT userID FROM users WHERE username='$name'";
    $result=mysqli_query($db,$sql);
    $row=mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1)
    {
        $searchID = $row['userID'];
        $searchSql="SELECT title, photoID,url FROM photos WHERE userID='$searchID'";
        $searchresult=mysqli_query($db,$searchSql);

        if(mysqli_num_rows($searchresult)>0){
            while($searchRow = mysqli_fetch_assoc($searchresult)){
                $line = "<p><img src='".xssafe(mysqli_real_escape_string($db,$searchRow['url']))."' style='width:100px;height:100px;'><a href='photo.php?id=".$searchRow['photoID']."'>".xssafe(mysqli_real_escape_string($db,$searchRow['title']))."</a></p>";
                $resultText = $resultText.$line;
            }
        }
        else{
            $resultText = "no photos by you!";
        }
    }
    else
    {
        $resultText = "no user with that username";

    }
}
?>