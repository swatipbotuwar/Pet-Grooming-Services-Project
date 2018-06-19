<?php  
	ob_start();
	session_start();
	if(isset($_POST['Filter'])){
		$thisFilter = $_POST['Filter'];
		echo $thisFilter;
		echo "<br>";
		$mysqldate = date('F d, Y', strtotime($thisFilter));
		$_SESSION['Filter'] = $thisFilter;
		header("Refresh:10; url='ScheduleAppointent.php'");
	}
	header("Refresh:0; url='ScheduleAppointent.php'");

?>