<?php
	ob_start();
	session_start();
	$dsn = 'mysql:host=courses;dbname=z1779093';
	$username = 'z1779093';
	$password = '1993Aug03';
	$link = new PDO($dsn,$username,$password);
	if (!$link) {
	    die('Something went wrong while connecting to MSSQL');
	 }

	if(!isset($_POST['check'])){
	 	echo "Please make a selection and try again";
	 	header("Refresh:2; url='UserPage.php'");
	 	ob_end_flush();
	 }
else{
	$link->query("START TRANSACTION");
	$check = $_POST['check'];
	$Dog = $_POST['Dog'];
	$Serv = $_POST['Service'];
	$time = date("H:i:s",strtotime($check));


	// echo $Dog;
	// echo "<br>";
	// echo $check;
	// echo "<br>";
	// echo $Serv;
	// echo "<br>";
	// echo $time;
	// echo "<br>";
	$serviceQ = $link->query("Select * from z1779093.Services where Services.description = '$Serv'");
	$row = $serviceQ->fetch(PDO::FETCH_ASSOC);
	// echo "ROW : ";
	// echo $row['SID'];

	$statement = "Insert into z1779093.Appointment (appDate, start_time, PetId, Sid) VALUES('".$check."', '".$time."', '".$Dog."', '".$row['SID']."')";
	$link->query($statement);
	$stmt2 = "delete from z1779093.Timeslot where slot_time = '".$check."'";
	$link->query($stmt2);
	$link->query("COMMIT");
	header("Refresh:2; url='ScheduleAppointent.php'");
	echo "Success!";
	ob_end_flush();
}
?>