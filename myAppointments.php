<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>

<style>
	
	body{
		background-color: #ffccff;
	}

	table#t1{
		width: 100%;
		text-align: center;
		background-color: #ffb3ff;
	}

	table#t2{
		width: 50%;
		text-align: center;
		background-color: #ffb3ff;
		border: 4px solid white;
	}
	tr#t3{
		background-color: #ff80ff;
		border-bottom: thin solid;
	}

	a{
		text-decoration: none;
		font-family: Cursive, serif;
		font-weight: bold;
		font-size: 18pt;
		color: #eb2d53;
	}



	h1{
		font-size: 18pt;
		font-family: "Comic Sans MS", cursive, sans-serif;
		color: #cc0066;
	}

</style>

	<title>User Page</title>

</head>

<body>
	<?php
		date_default_timezone_set('America/Chicago');
		session_start();
		$dsn = 'mysql:host=courses;dbname=z1779093';
		$username = 'z1779093';
		$password = '1993Aug03';
		$link = new PDO($dsn,$username,$password);

		if (!$link) {
		    #die('Something went wrong while connecting to MSSQL');
		 }

	?>
<table id="t1" style="width: 100%">
	<tr>
		<td><a href="ScheduleAppointent.php">New Appointment</a></td>
		<td><a href="myAppointments.php"">My Appointments</a></td>
		<td><a href="UserPage.php"">My Pets</a></td>
	</tr>
</table>
<br>

<div align="right">
	<a href="GradAssignment.php" style="font-family: serif; color: black; font-weight: bold; background-color: #ffb3ff;">LOGOUT</a>
</div>

<br><br>
<h1>Your Appointments</h1>
<?php
$CustomerVar = $link->query("select CustId from z1779093.Customer where Customer.email ='".$_SESSION['USERNAME']."' LIMIT 1");
$CustomerVar2 = $CustomerVar->fetch(PDO::FETCH_ASSOC);
$CustEmail = $CustomerVar2['CustId'];
#error_reporting(E_ERROR | E_PARSE);
echo "<table id='t2'>";
	echo "<tr id='t3'>";
		echo "<td>Date</td>";
		echo "<td>Start Time</td>";
		echo "<td>Pet Name</td>";
		echo "<td>Service</td>";
	echo "</tr>";
	$input = "select Appointment.appDate, Appointment.start_time, Pet.petName, Appointment.Sid from z1779093.Appointment, z1779093.Pet where Appointment.PetId = Pet.PetId and Pet.CustId = '".$CustEmail."' order by Appointment.start_time";
	$stmt = $link->query($input);
	if(!$stmt){
		echo $input;
		echo "FAILED";
	}
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>";
			$statement = "Select * from z1779093.Services where Sid = '".$row['Sid']."' ";
			$getService = $link->query($statement);
			$serviceTable = $getService->fetch(PDO::FETCH_ASSOC);
			$phpdate = strtotime($row['appDate']);
			$mysqldate = date( 'F d, Y', $phpdate );
			$mysqltime = date( 'g:i a', $phpdate );
			echo "<td>".$mysqldate."</td>";
			echo "<td>".$mysqltime."</td>";
			echo "<td>".$row['petName']."</td>";
			echo "<td>".$serviceTable['description']."</td>";
		echo "</tr>";
	}

echo "</table>";
 ?>
</body>
</html>