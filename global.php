<?php
session_start();
$base_url = "http://".$_SERVER['HTTP_HOST']."/";
// echo $base_url;
$basePath = dirname ( __FILE__ );
$mode_file_path = $basePath."/Mode.txt";
$userdata_file_path = $basePath."/UserData.txt";
$setting_file_path = $basePath."/setting.txt";
$alerts_file_path = $basePath."/logs/alerts.log";
$version_file_path = $basePath."/version.txt";
$upload_file_path = $basePath."/upload/";
$download_file_path = $basePath."/logs/alerts.zip";