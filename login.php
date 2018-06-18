<?php
require "global.php";
$user = $_POST['user'];
$password = $_POST['password'];

if (!file_exists($userdata_file_path)) {
    echo "The file $filename does not exist, failure and exiting....";
        exit(1);
}
// get all the lines in the file
$lines = file($userdata_file_path, FILE_IGNORE_NEW_LINES);

// loop through all files
foreach ($lines as $line)
{
    
    $arr = explode('|', $line);
    
    if (($arr[0] == $user) && ($arr[1] == $password))
    {
        $_SESSION['is_logged_in'] = 'loggedin';
        $_SESSION['username'] = $user;
        
        header("Location:menu.php");
        exit(0);
    }
}

// redirect back to login as if failed
header("Location:index.php");

