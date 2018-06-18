<?php
require "global.php";

if(isset($_GET['refresh']))
{
	$refresh_tab = $_GET['refresh'];
	// echo $refresh_tab;
}
else{
	$refresh_tab = 'status';
}



if(!isset($_SESSION['is_logged_in']) ||  $_SESSION['is_logged_in'] != "loggedin" ){
	header("Location:index.php");
}

if (!file_exists($setting_file_path)) {
    echo "The file $filename does not exist, failure and exiting....";
        exit(1);
}

$lines = file($setting_file_path, FILE_IGNORE_NEW_LINES);

//$host = $lines[0];
#hostname
$host = $lines[0];
shell_exec('os-scripts/osnet.sh hostname r');
#mode - master or remote
$mode = $lines[1];
shell_exec('os-scripts/osnet.sh mode');
#status - this will be a radio button of enabled or disabled-check process -need process
$checkstatus = $lines[2] == "checked" ? "checked":"";
shell_exec('ps -ef | grep runproc.sh | grep -v grep');
if ($checkstatus == "") 
{
	$disabledstatus = "checked";
	$enabledstatus = "";
}
else
{
	$enabledstatus = "checked";
	$disabledstatus = "";
}
#ethernet 0 IP Address
$eth0ip = $lines[3];
shell_exec('os-scripts/osnet.sh intIP r eth0');
#ethernet 1 IP Address
$eth1ip = $lines[4];
#ethernet 0 net mask
$eth0mask = $lines[5];
shell_exec('os-scripts/osnet.sh intmask r eth0');
#ethernet 1 net mask
$eth1mask = $lines[6];
#ethernet 0 def gw
$eth0gw  = $lines[7];
shell_exec('os-scripts/osnet.sh gateway r eth0');
#ethernet 1 def gw
$eth1gw = $lines[8];
#ethernet 0 dns
$eth0dns = $lines[9];
shell_exec('os-scripts/osnet.sh dns r eth0');
#ethernet 1 dns
$eth1dns = $lines[10];
##### passwords
$newpass1 = "";
$newpass2 = "";
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
			width: 500px;
		    max-width: 500px;
		    margin: 50px auto;
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

		
			<?php
				if (file_exists($mode_file_path)) 
				{
					// get all the lines in the file
					$line = file_get_contents($mode_file_path, true);
					if ($line == "Master")
					{
						//echo "<div class=\"top-menu-item-lg\">MIOTA</div>";
						echo "<div><h1 style=\"color: #CA291E;font-size: 3.5vw;\"><b>MIOTA</b></h1></div>";
					}
					else
					{
						//echo "<div class=\"top-menu-item-lg\">RIOTA</div>";
						echo "<div ><h1 style=\"color: #CA291E;font-size: 3.5vw;\"><b>RIOTA</b></h1></div>";
					}
				}
			?>
		<div class="xiota-content">
			<ul class="nav nav-tabs">
			  <li class="<?php if($refresh_tab=="status")echo 'active';?>"><a data-toggle="tab" href="#menu-status">Status</a></li>
  			  <li class="<?php if($refresh_tab=="settings")echo 'active';?>"><a data-toggle="tab" href="#menu-settings">Settings</a></li>
			  <li class="<?php if($refresh_tab=="network")echo 'active';?>"><a data-toggle="tab" href="#menu-network">Network</a></li>
			  <li class="<?php if($refresh_tab=="connections")echo 'active';?>"><a data-toggle="tab" href="#menu-connections">Connections</a></li>
			  <li class="<?php if($refresh_tab=="alerts")echo 'active';?>"><a data-toggle="tab" href="#menu-alerts">Alerts</a></li>
			</ul>

			<form name="myform" method="POST" action="savesetting.php">
			<div class="tab-content">
			<!-- status tab --> 
			 <div id="menu-status" class="tab-pane fade in <?php if($refresh_tab=="status")echo 'active';?>">
				
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
					<div class="col-md-8"></div>
					<a type="submit" class="col-md-3 save-btn"  href="<?=$base_url?>menu.php?refresh=alerts">
				   		Refresh
				   	</a>
				  <?php
					//if (!file_exists($alerts_file_path)) 
					//{
					//	echo "The file $alerts_file_path does not exist, can not display....";
					//}
					//$lines = file_get_contents($alerts_file_path, true);
					//echo $lines;
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
			  </div>
			  <!-- connections tab --> 
			 <div id="menu-connections" class="tab-pane fade  in  <?php if($refresh_tab=="connections")echo 'active';?>">
				
			  </div>
			  
			</div>
			</form>
		</div>
	</div>

</body>

</html>