<?php 
ob_start();
	$dsn = 'mysql:host=courses;dbname=z1779093';
	$username = 'z1779093';
	$password = '1993Aug03';
	$link = new PDO($dsn,$username,$password);
	if (!$link) {
	    die('Something went wrong while connecting to MSSQL');
	 }
	 $link->query("START TRANSACTION"); 				
	 $thisElement = $_POST['deleteItem'];

	 $deleteAppointments = "DELETE FROM z1779093.Appointment where Appointment.PetId = $thisElement";
	 $del = $link->query($deleteAppointments);
	 if(!$del){
	 echo "Something went wrong";
	 }

	$text_query = "DELETE FROM z1779093.Pet where Pet.PetId = $thisElement";
	$stmt = $link->query($text_query);
		 if(!$stmt){
	 	echo "Something went wrong";
	 }

	 else{
	 	echo "Success";
	 }
	 $link->query("COMMIT");
	header("Refresh:1; url='UserPage.php'");
	 ob_end_flush();


 ?>