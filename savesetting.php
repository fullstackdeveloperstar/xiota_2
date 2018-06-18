<?php
require "global.php";
require "logincheck.php";

if (isset($_POST['host']) && isset($_POST['mode']) && isset($_POST['status']) && isset($_POST['th0ip']) && isset($_POST['th1ip']) && isset($_POST['th0mstr']) && isset($_POST['th0rem']))
{
    $host = $_POST['host'];
    $mode = $_POST['mode'];
    $status = $_POST['status'];
    $th0ip = $_POST['th0ip'];
    $th1ip = $_POST['th1ip'];
    $th0mstr = $_POST['th0mstr'];
    $th0rem = $_POST['th0rem'];
	$settingfile = fopen($setting_file_path, "w") or die("Unable to open file!");
    fwrite($settingfile, $host);fwrite($settingfile, "\n");
    fwrite($settingfile, $mode);fwrite($settingfile, "\n");
    fwrite($settingfile, $status);fwrite($settingfile, "\n");
    fwrite($settingfile, $th0ip);fwrite($settingfile, "\n");
    fwrite($settingfile, $th1ip);fwrite($settingfile, "\n");
    fwrite($settingfile, $th0mstr);fwrite($settingfile, "\n");
    fwrite($settingfile, $th0rem);fwrite($settingfile, "\n");
    header("Location:menu.php");
    exit();
}

echo "Mode set error, contact RACWorc support";
