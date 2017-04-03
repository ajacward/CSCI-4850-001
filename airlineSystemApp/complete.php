<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Airline System App</title>
</head>
<body>
	<a href = "index.html"> Home </a>
	<h1> Confirmation </h1>
	
	<?php
		$serverName = "localhost";
		$userName = "user";
		$password = "passwd";
		$dbName = "airlinesystem";
		
		$conn = new mysqli($serverName, $userName, $password, $dbName);
		
		if ($conn->connect_error) {
			echo "connection failed";
			die("Connection failed: " . $conn->connect_error);
		}
		
		$custFirstName = $custLastName = $custPhoneNum = $custEmail = $custStreetNum = $custStreetName = "";
		$custAptNum = $custCity = $custState = $custZip = $custBirthDate = $custGender = "";
		
		$passFirstName = $passLastName = $passPhoneNum = $passEmail = $passBirthDate = $passGender = "";
		
		$ticketId = $isSame = "";
		
		$custFirstName = $_POST["cust_first_name"];
		$custLastName =$_POST["cust_last_name"];
		$custPhoneNum = $_POST["cust_phone_number"];
		$custEmail = $_POST["cust_email"];
		$custStreetNum = $_POST["cust_street_number"];
		$custStreetName = $_POST["cust_street_name"];
		$custAptNum = $_POST["cust_apt_number"];
		$custCity = $_POST["cust_city"];
		$custState = $_POST["cust_state"];
		$custZip = $_POST["cust_zip"];
		$custBirthDate = $_POST["cust_birth_date"];
		$custGender = $_POST["cust_gender"];
		$ticketId = $_POST["ticket_id"];
		
		if (isset($_POST["isSame"])) {
			$isSame = $_POST["isSame"];
		}
		
		if ($isSame == "") {
			$passFirstName = $_POST["pass_first_name"];
			$passLastName =$_POST["pass_last_name"];
			$passPhoneNum = $_POST["pass_phone_number"];
			$passEmail = $_POST["pass_email"];
			$passBirthDate = $_POST["pass_birth_date"];
			$passGender = $_POST["pass_gender"];		
		}
		
		$sql = "INSERT INTO `person` (`person_id`, `first_name`, `last_name`, `phone_number`, `email`) 
				VALUES (NULL, '$custFirstName', '$custLastName', '$custPhoneNum', '$custEmail');";		
		
		if ($conn->query($sql) === TRUE) {
			echo $custFirstName . " " . $custLastName . " inserted into person <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		if ($custAptNum == "") {
			$sql = "INSERT INTO `customer` (`customer_id`, `street_number`, `street_name`, `apt_number`, `city`, `state`, `zip`) 
				VALUES (LAST_INSERT_ID(), '$custStreetNum', '$custStreetName', NULL, '$custCity', '$custState', '$custZip');";	
		} else {
			$sql = "INSERT INTO `customer` (`customer_id`, `street_number`, `street_name`, `apt_number`, `city`, `state`, `zip`) 
				VALUES (LAST_INSERT_ID(), '$custStreetNum', '$custStreetName', '$custAptNum', '$custCity', '$custState', '$custZip');";
		}		
		
		if ($conn->query($sql) === TRUE) {
			echo $custFirstName . " " . $custLastName . " insterted into customer <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		if ($isSame != "") {
			$sql = "INSERT INTO `passenger` (`passenger_id`, `birth_date`, `gender`) 
					VALUES (LAST_INSERT_ID(), '$custBirthDate', '$custGender');";
			
			if ($conn->query($sql) === TRUE) {
				echo $custFirstName . " " . $custLastName . " inserted into passenger <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}			
		} else {
			$sql = "INSERT INTO `person` (`person_id`, `first_name`, `last_name`, `phone_number`, `email`) 
					VALUES (NULL, '$passFirstName', '$passLastName', '$passPhoneNum', '$passEmail');";	
				
			if ($conn->query($sql) === TRUE) {
				echo $passFirstName . " " . $passLastName . " inserted into person <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}		
			
			$sql = "INSERT INTO `passenger` (`passenger_id`, `birth_date`, `gender`) 
					VALUES (LAST_INSERT_ID(), '$passBirthDate', '$passGender');";
				
			if ($conn->query($sql) === TRUE) {
				echo $passFirstName . " " . $passLastName . " inserted into passenger <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		
		$sql = "INSERT INTO `has` (`ticket_id`, `passenger_id`) 
				VALUES ('$ticketId', LAST_INSERT_ID());";
				
		if ($conn->query($sql) === TRUE) {
			echo "New entry in HAS table <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		$conn->close();
	?>
</body>
</html>