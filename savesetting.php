<?php
require "global.php";
require "logincheck.php";
$lines = file($setting_file_path, FILE_IGNORE_NEW_LINES);

$old_host = $lines[0];
$old_mode = $lines[1];
$old_checkstatus = $lines[2] == "checked" ? "checked":"";
$old_eth0ip = $lines[3];
$old_eth1ip = $lines[4];
$old_eth0mask = $lines[5];
$old_eth1mask = $lines[6];
$old_eth0gw  = $lines[7];
$old_eth1gw = $lines[8];
$old_eth0dns = $lines[9];
$old_eth1dns = $lines[10];

if (isset($_POST['host']) 
    && isset($_POST['mode']) && isset($_POST['status'])
    && isset($_POST['eth0ip']) 
    && isset($_POST['eth1ip']) 
    && isset($_POST['eth0mask']) 
    && isset($_POST['eth1mask'])
    && isset($_POST['eth0gw']) 
    && isset($_POST['eth1gw'])
    && isset($_POST['eth0dns']) 
    && isset($_POST['eth1dns'])
)
{
    $host = $_POST['host'];
    $mode = $_POST['mode'];
    $status = $_POST['status'];
    if($status == 'enabled'){
        $status = 'checked';
    }
    else {
        $status = "";
    }

    $th0ip = $_POST['eth0ip'];
    $th1ip = $_POST['eth1ip'];
    $th0mstr = $_POST['eth0mask'];
    $th1mstr = $_POST['eth1mask'];
    $eth0gw = $_POST['eth0gw'];
    $eth1gw = $_POST['eth1gw'];
    $eth0dns = $_POST['eth0dns'];
    $eth1dns = $_POST['eth1dns'];

	$settingfile = fopen($setting_file_path, "w") or die("Unable to open file!");
    fwrite($settingfile, $host);fwrite($settingfile, "\n");
    fwrite($settingfile, $mode);fwrite($settingfile, "\n");
    fwrite($settingfile, $status);fwrite($settingfile, "\n");
    fwrite($settingfile, $th0ip);fwrite($settingfile, "\n");
    fwrite($settingfile, $th1ip);fwrite($settingfile, "\n");
    fwrite($settingfile, $th0mstr);fwrite($settingfile, "\n");
    fwrite($settingfile, $th1mstr);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth0gw);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth1gw);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth0dns);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth1dns);fwrite($settingfile, "\n");
    
    // run scripts here

    if($old_host != $host){
        echo 'old_host';
    }

    if($old_mode != $mode)
    {
     echo 'old_mode';   
    }

    if($old_checkstatus != $status)
    {
      echo 'old_status';
    }

    if($old_eth0ip != $th0ip)
    {
       echo 'old_eth0ip';
    }

    if($old_eth1ip != $th1ip)
    {
       echo 'old_eth1ip';
    }

    if($old_eth0mask != $th0mstr)
    {
        echo 'old_eth0mask';
    }

    if($old_eth1mask != $th1mstr)
    {
        echo 'old_eth1mask';
    }

    if($old_eth0gw != $eth0gw)
    {
        echo 'old_eth0gw';
    }

    if($old_eth1gw != $eth1gw)
    {
        echo 'old_eth1gw';
    }

    if($old_eth0dns != $eth0dns)
    {
        echo 'old_eth0dns';
    }

    if($old_eth1dns != $eth1dns)
    {
        echo 'old_eth1dns';
    }

    header("Location:menu.php");
    exit();



}
else{
    echo "Mode set error, contact RACWorc support";    
}
