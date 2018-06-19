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

	 else if(!isset($_POST['dogName'])){
	 	echo "Please Enter a Dog Name and try again";
	 	header("Refresh:2; url='UserPage.php'");
	 	ob_end_flush();
	 }
	 else if(!isset($_POST['dogBreed'])){
	 	echo "Please Enter a Dog Breed and try again";
	 	header("Refresh:2; url='UserPage.php'");
	 	ob_end_flush();
	 }
	 else if(!isset($_POST['gender'])){
	 	echo "Please select a Dog gender and try again";
	 	header("Refresh:2; url='UserPage.php'");
	 	ob_end_flush();
	 }
else{
	 $link->query("START TRANSACTION");
	 $Name = $_POST['dogName'];
	 $dogBreed = $_POST['dogBreed'];
	 $gender = $_POST['gender'];
	 $custId = $_SESSION['custId'];
	 $dogBreedLetter = "M";


	 if($gender == "female"){
	 	$dogBreedLetter = "F";
	 }
	 $text_query = "INSERT INTO z1779093.Pet (petName, petBreed, petGender, custId) VALUES ('$Name', '$dogBreed', '$dogBreedLetter', '$custId')";
	 $stmt = $link->query($text_query);
	 echo "<br>";
	 if(!$stmt){
	 	echo "Something went wrong";
	 }

	 else{
	 	echo "Success";
	 }
	 $link->query("COMMIT");
	 header("Refresh:2; url='UserPage.php'");
	 ob_end_flush();
	}
?>
