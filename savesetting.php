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
    // header("Location:menu.php");
    // exit();
}

echo "Mode set error, contact RACWorc support";



// //$host = $lines[0];
// #hostname
// $host = shell_exec('os-scripts/osnet.sh hostname r');
// #mode - master or remote
// $mode = shell_exec('os-scripts/osnet.sh mode');
// #status - this will be a radio button of enabled or disabled-check process -need process
// $checkstatus = shell_exec('ps -ef | grep runproc.sh | grep -v grep');
// if ($checkstatus == "") 
// {
//     $disabledstatus = "checked";
//     $enabledstatus = "";
// }
// else
// {
//     $enabledstatus = "checked";
//     $disabledstatus = "";
// }
// #ethernet 0 IP Address
// $eth0ip = shell_exec('os-scripts/osnet.sh intIP r eth0');
// #ethernet 1 IP Address
// $eth1ip = "";
// #ethernet 0 net mask
// $eth0mask = shell_exec('os-scripts/osnet.sh intmask r eth0');
// #ethernet 1 net mask
// $eth1mask = "";
// #ethernet 0 def gw
// $eth0gw = shell_exec('os-scripts/osnet.sh gateway r eth0');
// #ethernet 1 def gw
// $eth1gw = "";
// #ethernet 0 dns
// $eth0dns = shell_exec('os-scripts/osnet.sh dns r eth0');
// #ethernet 1 dns
// $eth1dns = "";
// ##### passwords
// $newpass1 = "";
// $newpass2 = "";