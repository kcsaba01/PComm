<?php
/**
 * Created by PhpStorm.
 * User: Csaba Keresztessy <0811994@rgu.ac.uk>
 * Date: 01/05/2016
 * PHP page where a user can register
 */
	include("connection.php");
	include("submit.php");
	include("utilities.php");

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Registration Form</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<div class="main">
	<h1 style="font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif; font-size:32px;">Photo Commenter Registration</h1>
	<div class="formbox">
		<h3>Registration Form</h3>
		<br><br>
		<form method="post" action="">
			<label>Username:</label><br>
			<input type="text" name="username" placeholder="username" required/><br><br>
			<label>Email:</label><br>
			<input type="email" name="email" placeholder="email" required />  <br><br>
			<label>Password:</label><br>
			<input type="password" name="password" placeholder="password" required/>  <br><br>
			<input type="submit" name="submit" value="Register!" />
		</form>
		<div class="error"><?php xecho ($msg);?><p> Click <a href='index.php'>here</a> to login</p> </div>
	</div>
</body>
</html>
