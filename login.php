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

			if ($stmt = mysqli_prepare($db,"SELECT userID, attempt FROM users WHERE username='?' and password='?'")) //Preparing the statement
			{
				mysqli_stmt_bind_param($stmt, "ss", $username, $password); //Binding the variables
				if (mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_bind_result($stmt, $result);
					$row=mysqli_fetch_array($result,MYSQLI_ASSOC) ;
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
				else
				{
					$msg =mysqli_stmt_error($stmt) . " There was an error"; //Displaying the reason why the adding has failed
				}

			}
		}
		mysqli_stmt_close($stmt); //closing the statement
		mysqli_close($db); //closing the connection
	}

?>
