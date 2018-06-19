<?php
	session_start();
	$dsn = 'mysql:host=courses;dbname=z1779093';
	$username = 'z1779093';
	$password = '1993Aug03';
	$link = new PDO($dsn,$username,$password);
	if (!$link) {
	    #die('Something went wrong while connecting to MSSQL');
	 }
?>
<!DOCTYPE html>
<html>
<head>

<style>
	
	body{
		background-color: #ffccff;
	}

	h1{
		text-align: center;
		color: #ff00ff;
		font-family: Cursive, serif;
		font-size: 55px;
		white-space: nowrap;
	}

	form{
		text-align: center;
	}

	label{
		text-align: right;
		padding-right: 29px;
		display: inline-block;
		min-width:150px;
	}

	label{
		text-align: right;
		padding-right: 29px;
		display: inline-block;
		min-width:150px;
	}
	input[type=submit] {
    	background-color: #4CAF50; /* Green */
    	border: none;
    	color: #ffccff;
    	padding: 10px 16px;
    	text-align: center;
    	text-decoration: none;
    	display: inline-block;
    	font-size: 16px;
	}

	table{
		width: 100%;
		text-align: center;
	}

	img{
		width: 304px;
		height:228px;
		padding: 10px 20%;
	}
.footer{
    position: absolute;
    text-align: center;
    bottom: 0;
    left: 0;
    right: 0;
    height:20px;
    background:#ffb3ff;
}
}

</style>

	<title>The Groomer</title>
</head>
<body>
<h1>The At-Home Dog Groomer</h1>
<br><br><br>
<form action="loginPHP.php" method="post">
	<label>Username</label><input type="username" name="username"><br>
	<label>Password</label><input type="Password" name="Password"><br><br>
	<input type="submit" value="Submit">
</form>

<br><br><br>
<img src="HomePagePic.png">
<div class = "footer">
	<table><tr><th><a href="About.html">About</a></th><th><a href="GradAssignment.php">Career</a></th><th><a href="GradAssignment.php">Contact</a></th><th><a href="GradAssignment.php">FAQ's</a></th></tr></table>
</div>
</body>
</html>