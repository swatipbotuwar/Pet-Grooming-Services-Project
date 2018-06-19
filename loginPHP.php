<?php
	ob_start();
	session_start();
	$dsn = 'mysql:host=courses;dbname=z1779093';
	$username = 'z1779093';
	$password = '1993Aug03';
	$link = new PDO($dsn,$username,$password);
	$USERNAME = $_POST['username'];
	if($USERNAME == "Admin"){
		echo "Redirecting to Admin Page";
		header("Location: AdminPage.php");
	}
	else{
		$mysqlStmt = "select * from z1779093.Customer where '".$USERNAME."' = Customer.email";
		echo $mysqlStmt;
		$stmt = $link->query($mysqlStmt);
		if($stmt->fetchColumn() == 0){
			header("Location: GradAssignment.php");
		}
		else{
			$_SESSION['USERNAME'] = $USERNAME;
			echo "Redirecting to User Page" ;
			echo $USERNAME;
			header("Location: UserPage.php");
		}
	}
?>