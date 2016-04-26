<?php
	session_start();
	include("connection.php"); //Establishing connection with our database
	
	$error = ""; //Variable for storing our errors.
	if(isset($_POST["submit"]))
	{
		if(empty($_POST["username"]) || empty($_POST["password"]))
		{
			$error = "Both fields are required.";
		}else
		{
			// Define $username and $password
			$username=$_POST['username'];
			$password=$_POST['password'];
			//validating input
			$username=mysqli_real_escape_string($db, $username);
			$password=mysqli_real_escape_string($db, $password);
			$password = md5($password);
			
			//Check username and password from database
			$sql="SELECT userID, attempt FROM users WHERE username='$username' and password='$password'";
			$result=mysqli_query($db,$sql);
			$row=mysqli_fetch_array($result,MYSQLI_ASSOC) ;
			
			//If username and password exist in our database then create a session.
			//Otherwise echo error.
			
			if(mysqli_num_rows($result) == 1 and $row[attempt] < 4) //checking whether the user exist and there were less than 4 login attempts
			{
				$_SESSION['username'] = $username; // Initializing Session
				//If login was successful the attempt field is changed to 1
				$query = mysqli_query($db, "UPDATE users SET attempt=1 WHERE username='$username'") or die(mysqli_error($db));
				header("location: photos.php"); // Redirecting To Other Page
			}else
			{
				$error = "Incorrect username/password or the acount is blocked";
				//If the login was unsuccessful the attempt field is incremented with 1
				$query = mysqli_query($db, "UPDATE users SET attempt=attempt+1 WHERE username='$username'") or die(mysqli_error($db));
			}

		}
	}

?>
