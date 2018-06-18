<?php
require "global.php";
require "logincheck.php";

	if (!file_exists($mode_file_path)) {
        header("Location:chooseindex.php");
	}
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
		<form name="myform" method="POST" action="login.php">
			<div class="agile-field-txt">
				<label>
					<i class="fa fa-user" aria-hidden="true"></i> Username :</label>
				<input type="text" name="user" value="" placeholder=" " required="" />
			</div>
			<div class="agile-field-txt">
				<label>
					<i class="fa fa-lock" aria-hidden="true"></i> password :</label>
				<input type="password" name="password" value="" placeholder=" " required="" id="myInput" />
				<div class="agile_label">
					<input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
					<label class="check" for="check3">Show password</label>
				</div>
			</div>
			<script>
				function myFunction() {
					var x = document.getElementById("myInput");
					if (x.type === "password") {
						x.type = "text";
					} else {
						x.type = "password";
					}
				}
			</script>
			<!-- //script for show password -->
			<div class="w3ls-login  w3l-sub">
				<input type="submit" name="submit" value="Log In" >
			</div>
		</form>
	</div>
	<!-- //form ends here -->
</body>

</html>
