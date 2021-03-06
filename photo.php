<?php
/**
 * Created by PhpStorm.
 * User: Csaba Keresztessy <0811994@rgu.ac.uk>
 * Date: 01/05/2016
 * user is redirected to this page after login. The page displays the available pictures 
 */
	include("check.php");
    include("connection.php");
    include("sessioncheck.php");
    include("utilities.php");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<h4>Welcome <?php xecho($login_user);?> <a href="photos.php" style="font-size:18px">Photos</a>||<a href="searchphotos.php" style="font-size:18px">Search</a>||<a href="logout.php" style="font-size:18px">Logout</a></h4>
<div id="photo">
    <?php
    include("check.php");
    if(isset($_GET['id'])and is_numeric($_GET['id']))//checking whether the id is numeric
        {
            $photoID = $_GET['id'];
            $photoSql = "SELECT * FROM photos WHERE photoID='$photoID'";
            $photoresult = mysqli_query($db,$photoSql) or die(mysqli_error($db));
            if((mysqli_num_rows($photoresult)==1))
            {
                $photoRow = mysqli_fetch_assoc($photoresult);
                $logedinuserstr = strval($_SESSION['userid']);
                if ( $logedinuserstr != $photoRow['userID'] and !$adminuser) //protection against URL guessing, if the logged in user is not the same as the picture's owner or admin, the user is logged out
                {
                    header("Location: logout.php");
                }

                echo ("<h1>".xsssafe($photoRow['title'])."</h1>");
                echo "<h3>".xsssafe($photoRow['postDate'])."</h3>";
                echo "<img src='".xsssafe($photoRow['url'])."'/>";
                echo " <p>".xsssafe($photoRow['description'])."</p>";
                $commentSql="SELECT * FROM comments WHERE photoID='$photoID'";
                $commentresult=mysqli_query($db,$commentSql) or die(mysqli_error($db));

                if(mysqli_num_rows($commentresult)>1)
                {

                    echo "<h2> Comments </h2>";
                    while($commentRow = mysqli_fetch_assoc($commentresult))
                    {
                        echo "<div class = 'comments'>";
                        echo "<h3>".xsssafe($commentRow['postDate'])."</h3>";
                        echo "<p>".xsssafe($commentRow['description'])."</p>";
                        echo "</div>";
                    }

                }
                echo "<a href='addcommentform.php?id=".xsssafe($photoID)."'> Add Comment</a><br>";

                if($adminuser){
                    echo "<div class='error'><a href='removephoto.php?id=".$photoID."'> Delete Photo</a></div>";
                }

            }
            else
            {
                echo "<h1>No Photos Found</h1>";
            }

        }
        else
        {

        echo "<h1>No User Selected</h1>";
        }

    ?>
</div>

</body>
</html>
