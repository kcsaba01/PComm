<?php
/**
 * Created by PhpStorm.
 * User: Csaba Keresztessy <0811994@rgu.ac.uk>
 * Date: 01/05/2016
 * Index page, this is the main landing page when a user is accessing the page
 */
	include('login.php'); // Include Login Script
    include('utilities.php'); //Include utilities (xsssafe and xecho)

	if ((isset($_SESSION['username']) != '')) 
	{
		header('Location: photos.php');
	}	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PHP Login Form with Session</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<div class="main">
<h1 style="font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif; font-size:32px;">Welcome to Photo Commenter</h1>
    <div class="formbox">
        <h3>Login Form</h3>
        <br><br>
        <form method="post" action="">
            <label>Username:</label><br>
            <input type="text" name="username" placeholder="Username" /><br><br>
            <label>Password:</label><br>
            <input type="password" name="password" placeholder="Password" />  <br><br>
            <input type="submit" name="submit" value="Login" />
        </form>
        <div class="error"><?php xecho($error);?></div>
        <div class="register">You can register <a href="register.php"> here </a> </div>
    </div>

</div>
</body>
</html>