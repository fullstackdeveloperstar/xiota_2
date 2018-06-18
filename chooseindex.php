<?php
require "global.php";
require "logincheck.php";
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
	<!--<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">-->
	<!--//fonts-->
	<style type="text/css">
		#login-form{
			max-width: 400px;
		    margin: auto;
		    border: solid 1px #8c8a8a;
		    padding: 10px;
		    box-shadow: 4px 4px 25px 6px #868686;
		    background: #fdfdfd;
		}

		#title-for-selection{
			font-size: 27px;
    		font-weight: 700;
		}

		.btn-option{
			font-size: 15pt;
		    color: white;
		    background-color: #c11515;
		    padding: 3px;
		    width: 100%;
		    height: 50px;
		    border: 0;
		    cursor: pointer;
		    box-shadow: 1px 1px 16px -3px #4e4646;
		}
		.btn-option:hover{
			
		    background-color: #d04f4f;
		    
		}
	</style>
</head>

<body>
	<div id="content">
		<img src="images/racworc.png" style="width: 100%; min-width: 50px; max-width: 150px;" class="content"/>
	</div>
	<h1>XIOTA</h1>
		<form name="myform" method="POST" action="iotachooser.php" id="login-form">
			<h2 id="title-for-selection">Please select which function for this installation</h2><br/><br/>
			<input type="submit" name="Master" value="Master"  class="btn-option"><br/><br/>
			<input type="submit" name="Remote" value="Remote"  class="btn-option">
		</form>
	<!-- //form ends here -->
</body>

</html>
