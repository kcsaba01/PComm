<?php
session_start();
if(session_destroy())
{
mysqli_close($db); //closing the connection
header("Location: index.php");
}
?>