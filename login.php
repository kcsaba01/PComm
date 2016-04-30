<?php
		include("connection.php");//Establishing connection with our database
		include("utilities.php");
	
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
			//validating input
			$username=$_POST['username'];
			$password=$_POST['password'];
			$username = xsssafe($username);
			$password = xsssafe($password);
			$username=mysqli_real_escape_string($db, $username);
			$password = mysqli_real_escape_string($db, $password);
			$password = md5($password); //storing the password as hash

			if ($stmt = mysqli_prepare($db,"SELECT attempt FROM users WHERE username=? and password=?")) //Preparing the statement
			{
				mysqli_stmt_bind_param($stmt, "ss", $username, $password); //Binding the variables
				if (mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_bind_result($stmt, $result);
					mysqli_stmt_fetch($stmt);

					if(($result < 4) and ($result>0)) //checking whether the user exist and there were less than 4 login attempts
					{
						session_start();
						$_SESSION['username'] = $username;// Initializing Session
						$IP = getenv("REMOTE_ADDR");
						$_SESSION['IP'] = $IP;
						$_SESSION['timeout'] = time();
						//If login was successful the attempt field is changed to 1
						mysqli_stmt_close($stmt);
						$stmt2 = mysqli_prepare($db,"UPDATE users SET attempt=1 WHERE username=?");
						mysqli_stmt_bind_param($stmt2, "ss", $username);
						mysqli_stmt_execute($stmt2);
						mysqli_stmt_close($stmt2);
						//Retrieving the user id for the logge din user and attach it to the session
						$stmt3 = mysqli_prepare($db,"SELECT userID FROM users WHERE username=?");
						mysqli_stmt_bind_param($stmt3, "s", $username);
						mysqli_stmt_execute($stmt3);
						mysqli_stmt_bind_result($stmt3, $result3);
						mysqli_stmt_fetch($stmt3);
						$_SESSION['userid'] = $result3;
						mysqli_stmt_close($stmt3);
						header("location: photos.php"); // Redirecting to photos Page
					}else
					{
						$error = "Incorrect username/password or the acount is blocked";
						//Login unsuccessful, increasing attempt with 1
						mysqli_stmt_close($stmt);
						$stmt2 = mysqli_prepare($db,"UPDATE users SET attempt=attempt+1 WHERE username=?");
						mysqli_stmt_bind_param($stmt2, "s", $username);
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
