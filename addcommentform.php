<?php
/**
 * Created by PhpStorm.
 * User: Csaba Keresztessy <0811994@rgu.ac.uk>
 * Date: 01/05/2016
 * Add comment form and page
 */
include("check.php");
include("addcomment.php");
include("sessioncheck.php");
include("utilities.php");
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Comment</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<h4>Welcome <?php xecho($login_user);?> <a href="photos.php" style="font-size:18px">Photos</a>||<a href="searchphotos.php" style="font-size:18px">Search</a>||<a href="logout.php" style="font-size:18px">Logout</a></h4>

<div class="main">

<div class="formbox">
    <form method="post" action="">
        <label>Comment:</label><br>
        <textarea name="desc" cols="40" rows="5"  ></textarea><br><br>
        <label>Photo:</label>
        <input type="text" name="photoID" value="<?php xecho ($_GET['id']) ?>" /><br><br>
        <input type="submit" name="submit" value="Submit Comment" />
    </form>
    <div class="msg"><?php xecho ($msg);?></div>
</div>
    </div>
</body>
</html>