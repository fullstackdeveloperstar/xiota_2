<?php

// read in globals
require "global.php";

// set the refresh or default tab 
if(isset($_GET['refresh']))
{
	$refresh_tab = $_GET['refresh'];
	// echo $refresh_tab;
}
else{
	$refresh_tab = 'status';
}
// ensure that we are logged in first
if(!isset($_SESSION['is_logged_in']) ||  $_SESSION['is_logged_in'] != "loggedin" ){
	header("Location:index.php");
}
// verify the setting file so we can write current out - we then can compare memory vars to see if changes
if (!file_exists($setting_file_path)) 
{
    echo "The file $filename does not exist, failure and exiting....";
    exit(1);
}
else
{
	// read in the settings for now - this else may be deleted after testing
	$lines = file($setting_file_path, FILE_IGNORE_NEW_LINES);
}

// *********** RUN Scripts and load up memory variables
#hostname
$host = shell_exec('os-scripts/osnet.sh hostname r');

#mode - master or remote
$mode = shell_exec('os-scripts/osnet.sh mode');

#status - this will be a radio button of enabled or disabled..need to read file setting from ivan
$checkstatus = shell_exec('ps -ef | grep runproc.sh | grep -v grep');
if ($checkstatus == "") 
{
	$disabledstatus = "checked";
	$enabledstatus = "";
	$checkstatus = "";
}
else
{
	$enabledstatus = "checked";
	$disabledstatus = "";
	$checkstatus = "checked";
}

// boost status
$checkstatus = shell_exec('ps -ef | grep runproc.sh | grep -v grep');
if ($checkstatus == "") 
{
	$booststatus = "NOT Running....";
}
else
{
	$booststatus = "Running....";
}


#ethernet 0 IP Address
$eth0ip = shell_exec('os-scripts/osnet.sh intIP r eth0');
#ethernet 1 IP Address
$eth1ip = "";

#ethernet 0 net mask
$eth0mask = shell_exec('os-scripts/osnet.sh intmask r eth0');
#ethernet 1 net mask
$eth1mask = "";

#ethernet 0 def gw
$eth0gw  = shell_exec('os-scripts/osnet.sh gateway r eth0');
#ethernet 1 def gw
$eth1gw = "";

#ethernet 0 dns
$eth0dns = shell_exec('os-scripts/osnet.sh dns r eth0');
#ethernet 1 dns
$eth1dns = "";

//#### passwords for entry if they want to change them
$newpass1 = "";
$newpass2 = "";

// iota patch selection initial null
$iotapatchname = "";

// *** cpu util
$cpuutil = shell_exec('os-scripts/osnet.sh cpuutil');

// *** mem util
$memutil = shell_exec('os-scripts/osnet.sh memutil');

// **** think we should always write these out.. commenting out if statement
// save settings
//if(isset($_GET['refresh']) || (isset($_SESSION['is_first_into']) && $_SESSION['is_first_into'] == 'yes'))
//{
	// these MUST be in the exact order here AND read in the same order read in in the savesettings.php
	// this shouldn't have any problems opening as the test was done already for its existing
	$settingfile = fopen($setting_file_path, "w") or die("Unable to open file!");
    fwrite($settingfile, $host);fwrite($settingfile, "\n");
    fwrite($settingfile, $mode);fwrite($settingfile, "\n");
    fwrite($settingfile, $checkstatus);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth0ip);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth1ip);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth0mask);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth1mask);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth0gw);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth1gw);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth0dns);fwrite($settingfile, "\n");
    fwrite($settingfile, $eth1dns);fwrite($settingfile, "\n");
    $_SESSION['is_first_into'] = 'no';
//}

?>
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
	<!--fonts-->
	<link href="css/font-awesome.css" rel="stylesheet">
	<!--//fonts-->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<!-- jQuery library -->
	<script src="js/jquery.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="js/bootstrap.js"></script>
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
			width: 600px;
		    max-width: 600px;
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
		<img src="images/racworc.png"/>
	</div>

	<div class="content">
		
		<div class="top-menu">
			<div class="top-menu-item">Username : <?=$_SESSION['username']?></div>

			<div class="top-menu-item">
				<a href="logout.php">Logout</a>
			</div>	
		</div>

		<div style="margin-top: -60px;">
			<?php
				if (file_exists($mode_file_path)) 
				{
					// get all the lines in the file
					$line = file_get_contents($mode_file_path, true);
					if ($line == "Master")
					{
						echo "<h1 style=\"color: #CA291E;font-size: 3.5vw;\"><b>MIOTA</b></h1>";
					}
					else
					{
						echo "<h1 style=\"color: #CA291E;font-size: 3.5vw;\"><b>RIOTA</b></h1>";
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

		<div class="xiota-content">
			<ul class="nav nav-tabs">
			  <li class="<?php if($refresh_tab=="status")echo 'active';?>"><a data-toggle="tab" href="#menu-status">Status</a></li>
			  <li class="<?php if($refresh_tab=="settings")echo 'active';?>"><a data-toggle="tab" href="#menu-settings">Settings</a></li>
			  <li class="<?php if($refresh_tab=="network")echo 'active';?>"><a data-toggle="tab" href="#menu-network">Network</a></li>
			  <li class="<?php if($refresh_tab=="connections")echo 'active';?>"><a data-toggle="tab" href="#menu-connections">Connections</a></li>
			  <li class="<?php if($refresh_tab=="alerts")echo 'active';?>"><a data-toggle="tab" href="#menu-alerts">Alerts</a></li>
			  <li class="<?php if($refresh_tab=="support")echo 'active';?>"><a data-toggle="tab" href="#menu-support">Support</a></li>
			</ul>

			<form name="myform" method="POST" action="savesetting.php" enctype="multipart/form-data">
			<div class="tab-content">
			<!-- status tab --> 
			 <div id="menu-status" class="tab-pane fade in <?php if($refresh_tab=="status")echo 'active';?>">
				   <div class="row">
					<div class="col-md-6"><big><u><b>SYSTEM STATUS</b></u></big></div>
				   </div>
				   
				   <div class="row">
				   	<div class="col-md-3">Boost Status:</div>
				   	<div class="col-md-6"><?=$booststatus?></div>
				   </div>

				   <div class="row">
				   	<div class="col-md-3">CPU Util:</div>
					<div class="col-md-6"><?=$cpuutil?></div>
				   </div>

   				   <div class="row">
				   	<div class="col-md-3">MEM Util:</div>
					<div class="col-md-6"><?=$memutil?></div>
				   </div>

				   <div class="row">
					<div class="col-md-8"></div>
					<a type="submit" class="col-md-3 save-btn"  href="<?=$base_url?>menu.php?refresh=status">
				   		Refresh
				   	</a>
				   </div>
			 </div>
			  
			
			  <div id="menu-settings" class="tab-pane fade in <?php if($refresh_tab=="settings")echo 'active';?>">
				   <div class="row">
				   	<div class="col-md-3 ">Hostname:</div>
				   	<div class="col-md-9"><input value="<?=$host?>" name="host"></div>
				   </div>

				   <div class="row">
				   	<div class="col-md-3">Mode:</div>
				   	<div class="col-md-9"><input value="<?=$mode?>" name="mode"></div>
				   </div>

				   <div class="row">
				   	<div class="col-md-3">Boost Status:</div>
				   	<!-- <div class="col-md-9"><input value="<?=$status?>" name="status"></div> -->
					<div class="col-md-3">Enabled<input type="radio" name="status" value="enabled" <?php print $enabledstatus; ?> ></div>
					<div class="col-md-3">Disabled<input type="radio" name="status" value="disabled" <?php print $disabledstatus; ?> ></div>
					</div>

				 <hr style="border: solid 1px #545050;"> 
				   <div class="row">
					<div class="col-md-6"><big><u><b>Change Password</b></u></big></div>
				   </div>
				   
				   <div class="row">
				   	<div class="col-md-3">New Password:</div>
				   	<div class="col-md-3"><input value="<?=$newpass1?>" name="newpass1"></div>
				   	<div class="col-md-3">Confirm Password:</div>
				   	<div class="col-md-3"><input value="<?=$newpass2?>" name="newpass2"></div>
				   </div>

				   <div class="row">
				   	<button type="submit" class="col-md-3 save-btn">
				   		Save
				   	</button>
					<div class="col-md-5"></div>
					<!-- this button needs to call menu.php to refresh itself -->
					<a type="submit" class="col-md-3 save-btn" href="<?=$base_url?>menu.php?refresh=settings">
				   		Refresh
				   	</a>
				   </div>
			  </div>
			  
			  <!-- network tab --> 
			  <div id="menu-network" class="tab-pane fade in  <?php if($refresh_tab=="network")echo 'active';?>">
				   <div class="row">
					<div class="col-md-6"><big><u><b>NETWORK SETTINGS</b></u></big></div>
				   </div>

				   <div class="row">
					<div class="col-md-3"><big><u><b>Eth0</b></u></big></div>
					<div class="col-md-3"></div>
					<div class="col-md-3"><big><u><b>Eth1</b></u></big></div>
				   </div>

				   <div class="row">
				   	<div class="col-md-3">IP:</div>
				   	<div class="col-md-3"><input value="<?=$eth0ip?>" name="eth0ip"></div>
				   	<div class="col-md-3">IP:</div>
				   	<div class="col-md-3"><input value="<?=$eth1ip?>" name="eth1ip"></div>
				   </div>

				   <div class="row">
				   	<div class="col-md-3">Mask:</div>
				   	<div class="col-md-3"><input value="<?=$eth0mask?>" name="eth0mask"></div>
				   	<div class="col-md-3">Mask:</div>
				   	<div class="col-md-3"><input value="<?=$eth1mask?>" name="eth1mask"></div>
				   </div>

				   <div class="row">
				   	<div class="col-md-3">Default GW:</div>
				   	<div class="col-md-3"><input value="<?=$eth0gw?>" name="eth0gw"></div>
				   	<div class="col-md-3">Default GW:</div>
				   	<div class="col-md-3"><input value="<?=$eth1gw?>" name="eth1gw"></div>
				   </div>

	   			   <div class="row">
				   	<div class="col-md-3">DNS Servers:</div>
				   	<div class="col-md-3"><input value="<?=$eth0dns?>" name="eth0dns"></div>
				   	<div class="col-md-3">DNS Servers:</div>
				   	<div class="col-md-3"><input value="<?=$eth1dns?>" name="eth1dns"></div>
				   </div>

				   <div class="row">
				   	<button type="submit" class="col-md-3 save-btn">
				   		Save
				   	</button>
					<div class="col-md-5"></div>
					<!-- this button needs to call menu.php to refresh itself -->
					<a type="submit" class="col-md-3 save-btn"  href="<?=$base_url?>menu.php?refresh=network">
				   		Refresh
				   	</a>
				   </div>
			  </div>

			  <div id="menu-alerts" class="tab-pane fade in  <?php if($refresh_tab=="alerts")echo 'active';?>" style="max-height: 300px;overflow-y: scroll;">
					<!-- <div class="col-md-3"></div> -->
					<div class ="row">
					<a type="submit" class="col-md-3 save-btn"  href="<?=$base_url?>menu.php?refresh=alerts">
				   		Refresh
				   	</a>
					</div>
				  <?php
					if (!file_exists($alerts_file_path)) 
					{
						echo "The file $alerts_file_path does not exist, can not display....";
					}
					if ($file = fopen($alerts_file_path, "r")) 
					{
						while(!feof($file)) 
						{
							$line = fgets($file);
							# do same stuff with the $line
							echo "<p>".$line."</p>";
						}
						fclose($file);
					}
					?>
				<!-- support tab -->
			  </div>
			  <div id="menu-support" class="tab-pane fade in  <?php if($refresh_tab=="support")echo 'active';?>">
			  	<div class="row">
					<!-- add catch for this download in savesetting.php - we'll use the same codebase -->
					<a href="download.php" name="DownloadSupportLog" class="col-md-5 save-btn" target="_blank">
						Download Support Log
					</a>
				</div>
				<hr style="border: solid 1px #545050;">

				   <div class="row">
					<div class="col-md-4">Select Patch to Load.</div>
					<div class="col-md-5"><input value="<?=$iotapatchname?>" name="iotapatchname"></div>
					<div class="col-md-3"><input type="file" name="file-iotapatchname" accept=".zip"></div>
				   </div>

				<div class="row">
					<!-- add catch for this download in savesetting.php - we'll use the same codebase -->
					<button type="submit" name="UploadIOTAPatch" class="col-md-5 save-btn">
						Upload IOTA Patch
					</button>
				</div>
			  </div>
			  <!-- connections tab --> 
			 <div id="menu-connections" class="tab-pane fade  in  <?php if($refresh_tab=="connections")echo 'active';?>">
				<?php
				// read in globals
				// require "global.php";

				if (file_exists($mode_file_path)) 
				{
					// get all the lines in the file
					$line = file_get_contents($mode_file_path, true);
					if ($line == "Master")
					{
						// display Discover Remotes button
						echo "<div class=\"row\">";
						echo "<button type=\"submit\" name=\"DiscoverRemotes\" class=\"col-md-5 save-btn\">";
						echo "Discover Remotes";
						echo "</button>";
						echo "</div>";
						// line 
						echo "<hr style=\"border: solid 1px #545050;\">";
						// now print out remotes
						echo "<div class=\"row\">";
						echo "<div class=\"col-md-8\"><b><u>Remotes Connected</u></b></div>";
						echo "<a type=\"submit\" class=\"col-md-3 save-btn\"  href=\"$base_url/menu.php?refresh=connections\">";
						echo "Refresh";
						echo "</a>";
						echo "</div>";
						echo "<div class=\"row\">";
						echo "<div class=\"col-md-6\">TO BE DONE</div>";
						echo "</div>";
					}
					else
					{
						// display Connect to Master button
						echo "<div class=\"row\">";
						echo "<button type=\"submit\" name=\"ConnectToMaster\" class=\"col-md-5 save-btn\">";
						echo "Connect To Master";
						echo "</button>";
						echo "</div>";
						// line 
						echo "<hr style=\"border: solid 1px #545050;\">";
						// show connected master
						echo "<div class=\"row\">";
						echo "<div class=\"col-md-3\">Master Connected:</div>";
						echo "<div class=\"col-md-1\"></div>";
						echo "<div class=\"col-md-5\">TO BE DONE</div>";
						echo "</div>";
						echo "<div class=\"row\">";
						echo "<div class=\"col-md-8\"></div>";
						echo "<a type=\"submit\" class=\"col-md-3 save-btn\"  href=\"$base_url/menu.php?refresh=connections\">";
						echo "Refresh";
						echo "</a>";
						echo "</div>";
					}
				}
				?>
				
			</div>
			  <!-- end connections tab -->
			  
			  
			</div>
			</form>
		</div>
	</div>

</body>

</html>