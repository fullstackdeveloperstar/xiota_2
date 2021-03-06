<?php
require "global.php";
require "logincheck.php";
// display a form to give them updates of what we are doing (if any)
?>

<!--
// to dos
// - download support log
// upload iota patch
-->

<!DOCTYPE HTML>
<html>

<head>
	<title>RACWorc</title>
	<!-- Meta-Tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //Meta-Tags -->
	<!-- Stylesheets -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<link href="css/style.css" rel='stylesheet' type='text/css' />

	<!--// Stylesheets -->
		<style type="text/css">
		.content{
			padding: 30px 50px;
			padding-top: 10px; 
		}

		.top-menu{
			display: flex;
			justify-content: space-between;
		}

		.top-menu-item, .top-menu-item a{
			color: #b90b0b;
		    font-size: 20px;
		    font-weight: 600;
		}

		.top-menu-item-lg, .top-menu-item-lg a{
			color: #b90b0b;
		    font-size: 40px;
		    font-weight: 600;
		}
		
		.xiota-content{
			width: 700px;
		    max-width: 700px;
		    margin: 20px auto;
		    background: #f2f2f2;
		    padding: 10px;
		    box-shadow: 3px 3px 20px 3px #585858;
		    text-align: left;
		}

		.xiota-content .nav a{
			color: #000;
    		font-size: 15px;
    		border-radius: 0;
    		margin-right: 0;
    		padding-bottom: 3px;
    		padding-top: 3px;
		}

		.xiota-content .nav .active{
		    
			border: 1px solid #000;
			border-bottom:0;
		}

		.xiota-content .nav .active a,
		.xiota-content .nav .active a:hover,
		.xiota-content .nav .active a:focus{
			background-color: #f2f2f2;
		}

		.xiota-content .nav-tabs {
		    border-bottom: 1px solid #000;
		}

		#menu-settings{

		}

		#menu-settings input{
			width: 100%;
		}

		#menu-settings .row{
			margin-top: 10px;
		}

		#menu-status{

		}

		#menu-status input{
			width: 100%;
		}

		#menu-status .row{
			margin-top: 10px;
		}

		#menu-network{

		}

		#menu-network input{
			width: 100%;
		}

		#menu-network .row{
			margin-top: 10px;
		}

		#menu-connections{

		}

		#menu-connections input{
			width: 100%;
		}

		#menu-connections .row{
			margin-top: 10px;
		}

		#menu-support{

		}

		#menu-support input{
			width: 100%;
		}

		#menu-support .row{
			margin-top: 10px;
		}

		.save-btn{
			background: #dc2424;
		    margin: 8px;
		    text-align: center;
		    color: white;
		    padding: 3px 8px;
		    font-size: 16px;
		    border-radius: 2px;
		    border: 0;
		}
	</style>
</head>

<body>
	<div id="content">
		<img src="images/racworc.png" class="content"/>
	</div>
	<div style="margin-top: -55px;">
	<?php
		if (file_exists($mode_file_path)) 
		{
			// get all the lines in the file
			$line = file_get_contents($mode_file_path, true);
			if ($line == "Master")
			{
				echo "<h1 style=\"color: #CA291E;font-size: 3.5vw;margin-bottom: 0px;\"><b>MIOTA</b></h1>";
			}
			else
			{
				echo "<h1 style=\"color: #CA291E;font-size: 3.5vw;margin-bottom: 0px;\"><b>RIOTA</b></h1>";
			}
		}
		// get version number_format
		if (file_exists($version_file_path))
		{
			$verno = file_get_contents($version_file_path, true);
		}
		else
		{
			$verno = "Version Descriptor Missing.";
		}
	?>
	<!-- pump out version number --> 
	<h4 style="margin: 0;">Version: <?=$verno?></h4>
	</div>
	<div class="w3ls-login">
		<!-- form starts here -->
		<form name="myform" method="POST" action="menu.php" style="display: initial;text-align: left;">


<?php
// any changes flag
$anychanges = false;

// first check for download request
if(array_key_exists('DownloadSupportLog', $_POST))
{
	echo "<p>Download clicked..implement here</p>";
}
elseif(array_key_exists('file-iotapatchname', $_FILES) &&  $_FILES["file-iotapatchname"]["name"] != "")
{
	// echo "<p>Upload IOTA Patch clicked..implement here</p>";

	$target_file = $upload_file_path .'IOTAPatch.zip';
	
    if (move_uploaded_file($_FILES["file-iotapatchname"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["file-iotapatchname"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
	
	
}
elseif(array_key_exists('DiscoverRemotes', $_POST))
{
	echo "<p>Discover Remotes clicked..implement here</p>";
}
else
{
	echo "<p>Checking for changes...</p>";
	// read in the lines of the settings
	$lines = file($setting_file_path, FILE_IGNORE_NEW_LINES);

	// read these lines in - in the exact order they are written out - sync writing with menu.php
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

	// get username
	$usernameis = $_SESSION['username'];

	// now get the forms memory variables to compare with the ones in the settings
	if (isset($_POST['host']) && isset($_POST['mode']) && isset($_POST['status'])
		&& isset($_POST['eth0ip']) && isset($_POST['eth1ip']) && isset($_POST['eth0mask']) 
		&& isset($_POST['eth1mask']) && isset($_POST['eth0gw'])  && isset($_POST['eth1gw'])
		&& isset($_POST['eth0dns']) && isset($_POST['eth1dns']) && isset($_POST['newpass1'])
		&& isset($_POST['newpass2'])
		)
	{
		// set the local variables so we know what came from the form
		$host = $_POST['host'];
		$mode = $_POST['mode'];
		$status = $_POST['status'];

		if($status == 'enabled')
		{
			$status = 'checked';
		}
		else 
		{
			$status = "";
		}

		$eth0ip = $_POST['eth0ip'];
		$eth1ip = $_POST['eth1ip'];
		$eth0mask = $_POST['eth0mask'];
		$eth1mask = $_POST['eth1mask'];
		$eth0gw = $_POST['eth0gw'];
		$eth1gw = $_POST['eth1gw'];
		$eth0dns = $_POST['eth0dns'];
		$eth1dns = $_POST['eth1dns'];
		// password checks for new
		$newpass1 = $_POST['newpass1'];
		$newpass2 = $_POST['newpass2'];

		// this is assuming something changed. This should be the same as what was in the form
		// this is ok to do it again - it's redundant as menu.php writes it back again anyway.
		// possibly could remove this
	//	$settingfile = fopen($setting_file_path, "w") or die("Unable to open file!");
	//    fwrite($settingfile, $host);fwrite($settingfile, "\n");
	//    fwrite($settingfile, $mode);fwrite($settingfile, "\n");
	//    fwrite($settingfile, $status);fwrite($settingfile, "\n");
	//    fwrite($settingfile, $eth0ip);fwrite($settingfile, "\n");
	//    fwrite($settingfile, $eth1ip);fwrite($settingfile, "\n");
	//    fwrite($settingfile, $eth0mask);fwrite($settingfile, "\n");
	//    fwrite($settingfile, $eth1mask);fwrite($settingfile, "\n");
	//    fwrite($settingfile, $eth0gw);fwrite($settingfile, "\n");
	//    fwrite($settingfile, $eth1gw);fwrite($settingfile, "\n");
	//    fwrite($settingfile, $eth0dns);fwrite($settingfile, "\n");
	//    fwrite($settingfile, $eth1dns);fwrite($settingfile, "\n");
		
		// now check to see if anything has changed from in the form vs was loaded
		// temporarily just echo until I get commands in place to update
		// hostname check
	//	echo 'old host = '. $old_host;
	//	echo 'new host = '. $host;
		if($old_host != $host)
		{
			// changes made
			$anychanges = true;
			echo "<p>Changing hostname from [".$old_host."] to [".$host."]</p>";
			//echo 'old_host';
			// if successful...this
			echo "<p>[Completed]</p>";
			// if fail....put mesg out
		}
		// mode changed - this should never happen today -- need to modify radio checks boxes
		if($old_mode != $mode)
		{
			// changes made
			$anychanges = true;
			echo '<p>old_mode</p>';   
		}
		// check to see if we should enable or disable boosting
		if($old_checkstatus != $status)
		{
			// changes made
			$anychanges = true;
			echo '<p>old_status</p>';
		}
		// change the IP for eth0
		if($old_eth0ip != $eth0ip)
		{
			// changes made
			$anychanges = true;
			echo '<p>Changing Eth0 IP Address from ['.$old_eth0ip.'] to ['.$eth0ip.']</p>';
			//echo 'old_eth0ip';
		}
		// change the IP for eth1
		if($old_eth1ip != $eth1ip)
		{
			// changes made
			$anychanges = true;

			echo '<p>old_eth1ip</p>';
		}
		// change the mask for eth0
		if($old_eth0mask != $eth0mask)
		{
			// changes made
			$anychanges = true;
			echo '<p>old_eth0mask</p>';
		}
		// change the mask for eth1
		if($old_eth1mask != $eth1mask)
		{
			// changes made
			$anychanges = true;
			echo '<p>old_eth1mask</p>';
		}
		// change eth0 def gw
		if($old_eth0gw != $eth0gw)
		{
			// changes made
			$anychanges = true;
			echo '<p>old_eth0gw</p>';
		}
		// change eht1 def gw
		if($old_eth1gw != $eth1gw)
		{
			// changes made
			$anychanges = true;
			echo '<p>old_eth1gw</p>';
		}
		// change eth0 dns
		if($old_eth0dns != $eth0dns)
		{
			// changes made
			$anychanges = true;
			echo '<p>Changing Eth0 DNS from ['.$old_eth0dns.'] to ['.$eth0dns.']</p>';
			//echo 'old_eth0dns';
		}
		// change eth1 dns
		if($old_eth1dns != $eth1dns)
		{
			// changes made
			$anychanges = true;
			echo '<p>Changing Eth1 DNS from ['.$old_eth1dns.'] to ['.$eth1dns.']</p>';
			//echo 'old_eth1dns';
		}

		// check to see if the newpass1 and newpass2 match
		if(($newpass1 == $newpass2) && ($newpass1 != ""))
		{
			// changes made
			$anychanges = true;
			echo "<p>Changing Password for [".$usernameis."]</p>";
			// if successful...this
			echo "<p>[Completed]</p>";
		}
		if($newpass1 != $newpass2) 
		{
			// changes made
			$anychanges = true;
			// probably need a dialog here - javascript alert maybe
			echo '<p>Password entries do NOT match. Try again.</p>';
		}




	} // end if changes made
	if (!$anychanges)
	{
		// no changes made
		echo "<p>No Changes Detected.</p>";
	}


	
} // end of big else 
	//put out all the time
	echo "<div class=\"w3ls-login  w3l-sub\">";
	echo "<input type=\"submit\" name=\"submit\" value=\"Continue\" >";
	echo "	</div>";
	echo "</form>";
	echo "</div>";
	echo "</body>";
	echo "</html>";
	
?>

