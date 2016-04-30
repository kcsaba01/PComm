<?php
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
			$result=0;
			$resetattempt=1;
			$username=$_POST['username'];
			$password=$_POST['password'];
			//validating input
			$username=mysqli_real_escape_string($db, $username);
			$password=mysqli_real_escape_string($db, $password);
			$password = md5($password);

			if ($stmt = mysqli_prepare($db,"SELECT userID, attempt FROM users WHERE username=? and password=?")) //Preparing the statement
			{
				mysqli_stmt_bind_param($stmt, "ss", $username, $password); //Binding the variables
				if (mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_bind_result($stmt, $result);
					mysqli_stmt_fetch($stmt);

					if(($result['attempt'] < 4) and ($result['attempt']>0)) //checking whether the user exist and there were less than 4 login attempts
					{
						session_start();
						$_SESSION['userID'] = $result['userID'];
						$_SESSION['username'] = $username;// Initializing Session
						$IP = getenv("REMOTE_ADDR");
						$_SESSION['IP'] = $IP;
						$_SESSION['timeout'] = time();
						//If login was successful the attempt field is changed to 1
						mysqli_stmt_close($stmt);
						$stmt2 = mysqli_prepare($db,"UPDATE users SET attempt=1, remoteip='$IP' WHERE username='$username'");
						mysqli_stmt_execute($stmt2);
						mysqli_stmt_close($stmt2);
						header("location: photos.php"); // Redirecting To Other Page
					}else
					{
						$error = "Incorrect username/password or the acount is blocked" . $result['attempt'] . $result['userID'];
						//Login unsuccessful, increasing attempt with 1
						mysqli_stmt_close($stmt);
						$stmt2 = mysqli_prepare($db,"UPDATE users SET attempt=attempt+1 WHERE username='$username'");
						mysqli_stmt_execute($stmt2);
						mysqli_stmt_close($stmt2);
					}
				}
				else
				{
					$error ="There was an error"; //The reason has been omited as the user should not be provided with information of the DB
				}

			}
		}
		mysqli_close($db); //closing the connection
	}

?>
