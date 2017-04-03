<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Airline System App</title>
</head>
<body>
	<a href = "employee.php">Back to Employee Page</a>
	<h1>Finalize New Flight</h1>
	
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
		
		$airplane = $seniorPilot = $copilot = $leadAttendant = $attendantOne = $attendantTwo = "";			
		$depDate = $depTime = $depAirport = "";
		$arrDate = $arrTime = $arrAirport = "";
		
		$airplane = $_POST["select_airplane"];
		$seniorPilot =$_POST["select_senior_pilot"];
		$copilot = $_POST["select_copilot"];
		$leadAttendant = $_POST["lead_attendant"];
		$attendantOne = $_POST["flight_attendant_one"];
		$attendantTwo = $_POST["flight_attendant_two"];
		$depDate = $_POST["dep_date"];
		$depTime = $_POST["dep_time"] . ":00";
		$depAirport = $_POST["departure_airport"];
		$arrDate = $_POST["arr_date"];
		$arrTime = $_POST["arr_time"] . ":00";
		$arrAirport = $_POST["arrival_airport"];
		
		$manifestId = $flightId = "";
		
		// Create new crew manifest (store manifest id to var)
		$sql = "INSERT INTO `crew_manifest` (`crew_manifest_id`) VALUES (NULL)";
		
		if ($conn->query($sql) === TRUE) {
			$manifestId = $conn->insert_id;
			echo "New manifest created in crew_manifest table <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}		
		
		// Add crew members to manifest
		// Make sure no duplicates in pilots or attendants
		$sql = "INSERT INTO `senior_scheduled` (`crew_manifest_id`, `senior_pilot_id`) 
				VALUES ($manifestId, $seniorPilot)";
		
		if ($conn->query($sql) === TRUE) {
			echo "Flight captain tied to manifest <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		$sql = "INSERT INTO `copilot_scheduled` (`crew_manifest_id`, `copilot_id`) 
				VALUES ($manifestId, $copilot)";
		
		if ($conn->query($sql) === TRUE) {
			echo "Copilot tied to manifest <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		$sql = "INSERT INTO `lead_scheduled` (`crew_manifest_id`, `lead_attendant_id`) 
				VALUES ($manifestId, $leadAttendant)";
		
		if ($conn->query($sql) === TRUE) {
			echo "Lead attendant tied to manifest <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		$sql = "INSERT INTO `attendants_scheduled` (`crew_manifest_id`, `attendant_id1`, `attendant_id2`) 
				VALUES ($manifestId, $attendantOne, $attendantTwo)";
		
		if ($conn->query($sql) === TRUE) {
			echo "Assistant attendants tied to manifest <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		// Create flight (store flight id to var)
		// Make sure no duplicate in airports
		$sql = "INSERT INTO `flight` (`flight_id`, `departure_date`, `departure_time`, `arrival_date`, `arrival_time`) 
				VALUES (NULL, '$depDate', '$depTime', '$arrDate', '$arrTime')";
		
		if ($conn->query($sql) === TRUE) {
			$flightId = $conn->insert_id;
			echo "New flight created in flight table <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		$sql = "INSERT INTO `departure` (`flight_id`, `airport_id`) VALUES ('$flightId', '$depAirport')";
		
		if ($conn->query($sql) === TRUE) {
			echo "Departure tied to flight <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$sql = "INSERT INTO `arrival` (`flight_id`, `airport_id`) VALUES ('$flightId', '$arrAirport')";
		
		if ($conn->query($sql) === TRUE) {
			echo "Arrival tied to flight <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		$sql = "INSERT INTO `plane_scheduled` (`flight_id`, `airplane_id`) 
				VALUES ('$flightId', '$airplane')";
		
		if ($conn->query($sql) === TRUE) {
			echo "Airplane tied to flight <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		$sql = "INSERT INTO `crew_scheduled` (`flight_id`, `crew_manifest_id`) 
				VALUES ('$flightId', '$manifestId')";
		
		if ($conn->query($sql) === TRUE) {
			echo "Manifest tied to flight <br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}		
		
		// Create tickets and Tie tickets to flight
		$sql = "SELECT passenger_capacity from airplane where airplane_id = $airplane";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$numSeats = (int) $row["passenger_capacity"];
		
		$seat = 0;
		$price = 0;
		$first = 900.00;
		$business = 600.00;
		$coach = 300.00;
		
		$ticketId = "";
		
		$ticketInsert = "INSERT INTO `ticket` (`ticket_id`, `seat_number`, `price`) VALUES (NULL, $seat, $price)";
						
		$ticketTie = "INSERT INTO `seats_filled` (`ticket_id`, `flight_id`) VALUES ($ticketId, $flightId)";					
				
		for ($i = 0; $i < $numSeats; $i++) {
			$seat = $i + 1;
			
			if ($seat < $numSeats / 3) {
				$price = $first;
			} elseif ($seat < 2 * $numSeats / 3) {
				$price = $business;
			} else {
				$price = $coach;
			}
			
			$ticketInsert = "INSERT INTO `ticket` (`ticket_id`, `seat_number`, `price`) VALUES (NULL, $seat, $price)";
			
			if ($conn->query($ticketInsert) === TRUE) {
				$ticketId = $conn->insert_id;
				echo "New ticket created <br>";
			} else {
				echo "Error: " . $ticketInsert . "<br>" . $conn->error;
			}
			
			$ticketTie = "INSERT INTO `seats_filled` (`ticket_id`, `flight_id`) VALUES ($ticketId, $flightId)";					
			
			if ($conn->query($ticketTie) === TRUE) {
				echo "Ticket tied to flight <br>";
			} else {
				echo "Error: " . $ticketTie . "<br>" . $conn->error;
			}
		}				
		
		$conn->close();
	?>
</body>
</html>