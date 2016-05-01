<?php
include("connection.php"); //Establishing connection with our database
include("sessioncheck.php");
include("utilities.php");
session_start();
$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"]))
{
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $url = "test";
    $name = $_SESSION["username"];

    //Sanitising the input
    $desc = xsssafe($desc);
    $title = xsssafe($title);
    $desc = mysqli_real_escape_string($db, $desc);
    $title = mysqli_real_escape_string($db, $title);
    
    //Setting the path
    $target_dir = "uploads/";
    $targetfile= xsssafe(basename($_FILES["fileToUpload"]["name"]));
    $targetfile = mysqli_real_escape_string($db, $targetfile);
    $target_file = $target_dir . $targetfile;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $uploadOk = 1;
    //check for file content
    $file_type = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);
    $image_types = array(
        'image/png',
        'image/jpeg',
        'image/gif',
        'image/bmp',
        'image/tiff');

    if (!in_array($file_type,$image_types)) //checking if a file is an image
    {
        $uploadOk = 0;
        $msg = "Only image files are allowed ";
    }

    // Check if file already exists
    if (file_exists($target_file))
    {
        $msg = "Sorry, file already exists ";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 100000)
    {
        $msg = "Sorry, your file is too large ";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $imageFileType = mb_strtolower($imageFileType);
    if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType= 'png' && $imageFileType='gif' && $imageFileType='bmp' && $imageFileType='tiff' )
    {
        $msg = "Sorry, only files with jpg, jpeg, png, gif, bmp, tiff are allowed ";
        $uploadOk = 0;
    }

    //Check how many dots are in the file name, protection against double extensions
    if( substr_count($target_file, '.') > 1 )
    {
        $msg = "Sorry, no double extensions ";
        $uploadOk = 0;
    }

        if(($_SESSION['userid'] != "") and ($uploadOk != 0)) { //retrieving the user id from session and checking whether the file can be uploaded
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $id = $_SESSION['userid'];
            if ($stmt = mysqli_prepare($db,"INSERT INTO photos (title, description, postDate, url, userID) VALUES (?, ?, NOW(), ?, ?)")) //Preparing the statement
            {
                mysqli_stmt_bind_param($stmt, "sssi", $title, $desc, $target_file, $id); //Binding the variables
                if (mysqli_stmt_execute($stmt))
                {
                    $msg="Thank You! The file ". $target_file. " has been uploaded";
                    //removing EXIF data for jpg
                    $img = imagecreatefromjpeg($target_file);
                    imagejpeg($img,$target_file,100);
                    imagedestroy($img);

                    //removing EXIF data fro GIF
                    $img = imagecreatefromgif($target_file);
                    imagegif($img,$target_file);
                    imagedestroy($img);

                }
                else
                {
                    $msg ="There was an error uploading your file."; //there was an error in uploading
                }
                mysqli_stmt_close($stmt); //closing the statement
            }
        }
    }
    else{
        $msg = $msg . " or you are not logged in";
    }
}

?>