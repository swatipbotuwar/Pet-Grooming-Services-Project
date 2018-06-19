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
		width: 75%;
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
		white-space: nowrap;
	}

	td{
		white-space: nowrap;
	}

</style>

	<title>User Page</title>

</head>

<body>
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
 	<h1>Schedule New Appointment - Appointments Must be Made 24 hours in Advance</h1>
  <br>
  <h1 style="padding-right: 10px">Choose A Time Slot or Search by Date: </h1><br>
  <form action="getFilter.php" method="post">
  <?php 
  $stmt = $link->query("select DISTINCT DATE_FORMAT(DATE(Timeslot.slot_time), '%b %d, %Y') from z1779093.Timeslot");
  echo "Select Filter: ".'<select name="Filter" style="width: 110">';
  	echo '<option value="None">No Filter</option>';
    while ($thisrow = $stmt->fetch(PDO::FETCH_ASSOC)){
  		echo '<option value="'.$thisrow["DATE_FORMAT(DATE(Timeslot.slot_time), '%b %d, %Y')"].'">'.$thisrow["DATE_FORMAT(DATE(Timeslot.slot_time), '%b %d, %Y')"].'</option>';
  	}
  echo "</select>";
  echo "<button type='submit' value='Submit'>Submit</button>";
	$filter = $_SESSION['Filter'];
  	?>
  </form>
<br>
 <form name='form' action='addAppointment.php' method='post'>
 	Which Dog Is This Appointment For?
 	<?php
 	$CustomerVar = $link->query("select * from z1779093.Customer where Customer.email ='".$_SESSION['USERNAME']."' LIMIT 1");
	$CustomerVar2 = $CustomerVar->fetch(PDO::FETCH_ASSOC);
	$CustEmail = $CustomerVar2['CustId'];
	#error_reporting(E_ERROR | E_PARSE);
 	$stmt = $link->query("Select * from z1779093.Pet where '".$CustEmail."' = Pet.CustId");
 	
 	echo '<select name="Dog" style="width: 100px">';
 		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
 			echo '<option value="'.$row['PetId'].'">'.$row['petName'].'</option>';
 		}
  	echo "</select>";

   ?>

  <table id="t1">
  	<tr>
  		<td>Day</td>
  		<td>Time Start</td>
  		<td>Time End</td>
  		<td>Select</td>
  	</tr>	
  	<?php 
  		$stmt = $link->query("select * from z1779093.Timeslot where (select DATE_FORMAT(slot_time, '%b %d, %Y') = '$filter') order by slot_time;");
  		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  			echo '<tr>';

  			$phpdate = strtotime( $row['slot_time'] );
			$mysqldate = date( 'F d, Y', $phpdate );
			#$mysqltime=mysql_query("SELECT TIME_FORMAT('100:00:00', '%H %k %h %I %l')");
			$mysqltime = $link->query("select time_format('".$row['slot_time']."','%l:%i %p')");
			$mysqltimeVal = $mysqltime->fetch(PDO::FETCH_ASSOC);
  			echo "<td>".$mysqldate."</td>";
  			$EndTime = date('g:i A', strtotime($mysqltimeVal["time_format('".$row['slot_time']."','%l:%i %p')"])+7200);
  			echo "<td>".$mysqltimeVal["time_format('".$row['slot_time']."','%l:%i %p')"]."</td>";
  			echo "<td>".$EndTime."</td>";
  			  echo '<td><input type="radio" name="check" value="'.$row['slot_time'].'"></td>';
  			echo '</tr>';
  		}

   			echo "</table>";
  			echo '<select name="Service" style="width: 140px">';
			$services = $link->query("select * from z1779093.Services");
 				while ($rowTwo = $services->fetch(PDO::FETCH_ASSOC)) {
 					echo '<option value="'.$rowTwo['description'].'">'.$rowTwo['description'].' $'.$rowTwo['price'].'</option>';
 				}
		  	echo "</select>"; 
		 ?>
  <br><br>
<input name= "Create" type='submit' value='Done'>
 </form>

<br><br>
</body>
</html>
