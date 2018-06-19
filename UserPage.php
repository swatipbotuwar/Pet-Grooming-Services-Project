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
<?php
	echo "<h1>Welcome ".$_SESSION['USERNAME']."!</h1>"
?>
<br><br>
<h1>Your Dogs</h1>
<?php
$CustomerVar = $link->query("select * from z1779093.Customer where Customer.email ='".$_SESSION['USERNAME']."' LIMIT 1");
$CustomerVar2 = $CustomerVar->fetch(PDO::FETCH_ASSOC);
$CustomerID = $CustomerVar2['CustId'];
#error_reporting(E_ERROR | E_PARSE);
echo "<form action='deletePet.php' method='post'>";
echo "<table id='t2'>";
	echo "<tr id='t3'>";
		echo "<td>Name</td>";
		echo "<td>Breed</td>";
		echo "<td>Gender</td>";
		echo "<td>Next Appointment</td>";
	echo "</tr>";
	$stmt = $link->query("select * from z1779093.Pet where Pet.CustId = '".$CustomerID."' order by petBreed ");
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>";
			echo "<td>".$row['petName']."</td>";
			echo "<td>".$row['petBreed']."</td>";
			echo "<td>".$row['petGender']."</td>";
			$stmt2 = $link->query("select * from z1779093.Pet, z1779093.Appointment where Pet.PetId = '".$row['PetId']."' AND z1779093.Appointment.PetId = z1779093.Pet.PetId order by appDate");
			$ID = $stmt2->fetch(PDO::FETCH_ASSOC);
			if(!$ID){
				echo "<td>No Upcoming</td>";
			}
			else{
				$phpdate = strtotime($ID['appDate']);
				$mysqldate = date( 'F d, Y', $phpdate );
				$mysqltime = date( 'g:i a', $phpdate );
					
				echo "<td>".$mysqldate." at ".$mysqltime."</td>";
			}
			echo '<td><button type="submit" name="deleteItem" value="'.$row['PetId'].'"/>Delete</td>';
		echo "</tr>";
	}
echo "</table>";
echo "</form>";
 ?>

 <br>
 <h1>Add New Dog</h1>
<form name='form' action='addDog.php' method='post'>
<?php  
		session_start();
		$temp = $CustomerVar2['CustId'];
		$_SESSION['custId'] = "$temp";
?>
	Name:
	<input type='text' name='dogName' id='dogName'> <br>
	Breed: 
	<input type='text' name='dogBreed' id='dogBreed'> <br>
	Gender: 
	<input type="radio" name="gender" value="male"> Male
	<input type="radio" name="gender" value="female"> Female<br>
	<input name= "Create" type='submit' value='Finish'>
	<input name="Create" type="submit" value="Finish and Create Appointment">
</form>
</body>
</html>











