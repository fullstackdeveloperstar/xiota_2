<?php
require "global.php";

$zip = new ZipArchive();


$zip = new ZipArchive;
if ($zip->open($download_file_path, ZipArchive::CREATE) === TRUE)
{
    // Add files to the zip file
   
    $zip->addFile('logs/alerts.log');
    $zip->close();
    
    if(file_exists($download_file_path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="alerts.zip"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($download_file_path));
        flush(); // Flush system output buffer
        readfile($download_file_path);
        exit;
    }
}
else {
	
}