<?php
/**
 * Created by PhpStorm.
 * User: Csaba Keresztessy <0811994@rgu.ac.uk>
 * Date: 01/05/2016
 * PHP script that clears a session and closes the database link on logout
 */
session_start();
if(session_destroy())
{
mysqli_close($db); //closing the connection
header("Location: index.php");
}
?>