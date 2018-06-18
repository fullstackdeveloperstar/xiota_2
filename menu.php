<?php
require "global.php";
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
$host = shell_exec('os-scripts/osnet.sh hostname r');
#mode - master or remote
$mode = shell_exec('os-scripts/osnet.sh mode');
#status - this will be a radio button of enabled or disabled-check process -need process
$checkstatus = shell_exec('ps -ef | grep runproc.sh | grep -v grep');
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
$eth0ip = shell_exec('os-scripts/osnet.sh intIP r eth0');
#ethernet 1 IP Address
$eth1ip = "";
#ethernet 0 net mask
$eth0mask = shell_exec('os-scripts/osnet.sh intmask r eth0');
#ethernet 1 net mask
$eth1mask = "";
#ethernet 0 def gw
$eth0gw = shell_exec('os-scripts/osnet.sh gateway r eth0');
#ethernet 1 def gw
$eth1gw = "";
#ethernet 0 dns
$eth0dns = shell_exec('os-scripts/osnet.sh dns r eth0');
#ethernet 1 dns
$eth1dns = "";
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
		<img src="images/racworc.png" class="content"/>
	</div>

	<div class="content">
		
		<div class="top-menu">
			<div class="top-menu-item">Home</div>

			<?php
				if (file_exists($mode_file_path)) 
				{
					// get all the lines in the file
					$line = file_get_contents($mode_file_path, true);
					if ($line == "Master")
					{
						//echo "<div class=\"top-menu-item-lg\">MIOTA</div>";
						echo "<div style=\"color: #FF0000;\"><h1><b>MIOTA</b></h1></div>";
					}
					else
					{
						//echo "<div class=\"top-menu-item-lg\">RIOTA</div>";
						echo "<div style=\"color: #FF0000;\"><h1><b>RIOTA</b></h1></div>";
					}
				}
			?>

			<div class="top-menu-item">
				<a href="logout.php">Logout</a>
			</div>	
		</div>

		<div style="color: #000;font-size: 13px;font-weight: 600;text-align: left;">User Name : <?=$_SESSION['username']?></div>

		<div class="xiota-content">
			<ul class="nav nav-tabs">
			  <li class="active"><a data-toggle="tab" href="#menu-status">Status</a></li>
  			  <li><a data-toggle="tab" href="#menu-settings">Settings</a></li>
			  <li><a data-toggle="tab" href="#menu-network">Network</a></li>
			  <li><a data-toggle="tab" href="#menu-connections">Connections</a></li>
			  <li><a data-toggle="tab" href="#menu-alerts">Alerts</a></li>
			</ul>

			<form name="myform" method="POST" action="savesetting.php">
			<div class="tab-content">
			<!-- status tab --> 
			 <div id="menu-status" class="tab-pane fade in active">
				<!--
			    <p>Some content in menu 1.</p>
			    <p>Some content in menu 2.</p>
			    <p>Some content in menu 3.</p>
			    <p>etc...</p>
				<div class="col-md-8"></div>
				<button type="submit" class="col-md-3 save-btn">
			   		Refresh
			   	</button>
			   </div>
			   -->
			  </div>
			  
			  <!-- settings tab --> 
			<div class="tab-content">
			  <div id="menu-settings" class="tab-pane fade">
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
				<div class="col-md-3">Enabled<input type="radio" name="boostenabled" value="enabled" <?php print $enabledstatus; ?> ></div>
				<div class="col-md-3">Disabled<input type="radio" name="boostdisabled" value="disabled" <?php print $disabledstatus; ?> ></div>
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
				<button type="submit" class="col-md-3 save-btn">
			   		Refresh
			   	</button>
			   </div>
			  </div>
			  
			  <!-- network tab --> 
			  <div id="menu-network" class="tab-pane fade">
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
				<button type="submit" class="col-md-3 save-btn">
			   		Refresh
			   	</button>
			   </div>
			  </div>
			  <div id="menu-alerts" class="tab-pane fade">
				<div class="col-md-8"></div>
				<button type="submit" class="col-md-3 save-btn">
			   		Refresh
			   	</button>
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
			 <div id="menu-connections" class="tab-pane fade">
				<!--
				<p>Some content in menu 1.</p>
			    <p>Some content in menu 2.</p>
			    <p>Some content in menu 3.</p>
			    <p>etc...</p>
				
				<div class="col-md-8"></div>
				<button type="submit" class="col-md-3 save-btn">
			   		Refresh
			   	</button>
			   </div>
			   -->
			  </div>
			  
			</div>
			</form>
		</div>
	</div>

</body>

</html>