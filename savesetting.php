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
</head>

<body>
	<div id="content">
		<img src="images/racworc.png" class="content"/>
	</div>
	<?php
		if (file_exists($mode_file_path)) 
		{
			// get all the lines in the file
			$line = file_get_contents($mode_file_path, true);
			if ($line == "Master")
			{
				echo"<h1>MIOTA</h1>";
			}
			else
			{
				echo"<h1>RIOTA</h1>";
			}
		}
	?>
	<div class="w3ls-login">
		<!-- form starts here -->
		<form name="myform" method="POST" action="menu.php" style="display: initial;text-align: left;">


<?php
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
		echo "<p>Changing hostname from [".$old_host."] to [".$host."]</p>";
        //echo 'old_host';
		// if successful...this
		echo "<p>[Completed]</p>";
		// if fail....put mesg out
    }
	// mode changed - this should never happen today -- need to modify radio checks boxes
    if($old_mode != $mode)
    {
     echo '<p>old_mode</p>';   
    }
	// check to see if we should enable or disable boosting
    if($old_checkstatus != $status)
    {
      echo '<p>old_status</p>';
    }
	// change the IP for eth0
    if($old_eth0ip != $eth0ip)
    {
		echo '<p>Changing Eth0 IP Address from ['.$old_eth0ip.'] to ['.$eth0ip.']</p>';
		//echo 'old_eth0ip';
    }
	// change the IP for eth1
    if($old_eth1ip != $eth1ip)
    {
       echo '<p>old_eth1ip</p>';
    }
	// change the mask for eth0
    if($old_eth0mask != $eth0mask)
    {
        echo '<p>old_eth0mask</p>';
    }
	// change the mask for eth1
    if($old_eth1mask != $eth1mask)
    {
        echo '<p>old_eth1mask</p>';
    }
	// change eth0 def gw
    if($old_eth0gw != $eth0gw)
    {
        echo '<p>old_eth0gw</p>';
    }
	// change eht1 def gw
    if($old_eth1gw != $eth1gw)
    {
        echo '<p>old_eth1gw</p>';
    }
	// change eth0 dns
    if($old_eth0dns != $eth0dns)
    {
		echo '<p>Changing Eth0 DNS from ['.$old_eth0dns.'] to ['.$eth0dns.']</p>';
		//echo 'old_eth0dns';
    }
	// change eth1 dns
    if($old_eth1dns != $eth1dns)
    {
		echo '<p>Changing Eth1 DNS from ['.$old_eth1dns.'] to ['.$eth1dns.']</p>';
		//echo 'old_eth1dns';
    }

	// check to see if the newpass1 and newpass2 match
	if(($newpass1 == $newpass2) && ($newpass1 != ""))
	{
		echo "<p>Changing Password for [".$usernameis."]</p>";
		// if successful...this
		echo "<p>[Completed]</p>";

		}
	if($newpass1 != $newpass2) 
	{
		// probably need a dialog here - javascript alert maybe
		echo '<p>Password entries do NOT match. Try again.</p>';
	}
	
	// now redirect to the menu for refresh
  //  header("Location:menu.php");
   // exit();



}
//
//else{
//    echo "Mode set error, contact RACWorc support";    
//}
?>

<!--- end of form -->
			
			<div class="w3ls-login  w3l-sub">
				<input type="submit" name="submit" value="Continue" >
			</div>
		</form>
	</div>
	<!-- //form ends here -->
</body>

</html>
