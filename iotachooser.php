<?php
require "global.php";
require "logincheck.php";
// $filename = 'Mode.txt';
// set defaults
if (isset($_POST['Master']))
{
    $master = $_POST['Master'];
    file_put_contents($mode_file_path, $master);
    // navigate to new page
    header("Location:index.php");
}
if (isset($_POST['Remote']))
{
    $remote = $_POST['Remote'];
    file_put_contents($mode_file_path, $remote);
    // navigate to new page
    header("Location:index.php");
}
// failsafe comment
echo "Mode set error, contact RACWorc support";
