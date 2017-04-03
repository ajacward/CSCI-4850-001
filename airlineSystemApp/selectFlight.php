<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Airline System App</title>
</head>
<body>
	<h2> Search results </h2>
	<form method="post" action="viewPassengers.php">
	<table>
		<tr>
			<th>Select</th>
			<th>Departure airport</th>
			<th>Departure city</th>
			<th>Departure state</th>
			<th>Departure date</th>
			<th>Departure time</th>
			<th>Arrival airport</th>
			<th>Arrival city</th>
			<th>Arrival state</th>
			<th>Arrival date</th>
			<th>Arrival time</th>
		</tr>
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
		
		$dep_date = $departure_airport = $arrival_airport = "";
		
		$dep_date = $_POST["dep_date"];
		$departure_airport = $_POST["departure_airport"];
		$arrival_airport = $_POST["arrival_airport"];		
		
		$sql = "";
		
		if ($dep_date != "" && $departure_airport != "" && $arrival_airport != "") {
			$sql = "select flight.flight_id, dep.airport_id as depAir, dep.city as depCity, dep.state as depState, 
							flight.departure_date, flight.departure_time, arr.airport_id as arrAir, 
							arr.city as arrCity, arr.state as arrState, flight.arrival_date, flight.arrival_time
					from flight
						join arrival natural join airport as arr on flight.flight_id = arrival.flight_id
						join departure natural join airport as dep on flight.flight_id = departure.flight_id
					where flight.departure_date = '$dep_date'
						   and departure.airport_id = '$departure_airport'
						   and arrival.airport_id = '$arrival_airport'";
		} elseif ($dep_date != "" && $departure_airport != "") {
			$sql = "select flight.flight_id, dep.airport_id as depAir, dep.city as depCity, dep.state as depState, 
							flight.departure_date, flight.departure_time, arr.airport_id as arrAir, 
							arr.city as arrCity, arr.state as arrState, flight.arrival_date, flight.arrival_time
					from flight
						join arrival natural join airport as arr on flight.flight_id = arrival.flight_id
						join departure natural join airport as dep on flight.flight_id = departure.flight_id
					where flight.departure_date = '$dep_date'
						   and departure.airport_id = '$departure_airport'";
		} elseif ($dep_date != "" && $arrival_airport != "") {
			$sql = "select flight.flight_id, dep.airport_id as depAir, dep.city as depCity, dep.state as depState, 
							flight.departure_date, flight.departure_time, arr.airport_id as arrAir, 
							arr.city as arrCity, arr.state as arrState, flight.arrival_date, flight.arrival_time
					from flight
						join arrival natural join airport as arr on flight.flight_id = arrival.flight_id
						join departure natural join airport as dep on flight.flight_id = departure.flight_id
					where flight.departure_date = '$dep_date'
						   and arrival.airport_id = '$arrival_airport'";			
		} elseif ($departure_airport != "" && $arrival_airport != "") {
			$sql = "select flight.flight_id, dep.airport_id as depAir, dep.city as depCity, dep.state as depState, 
							flight.departure_date, flight.departure_time, arr.airport_id as arrAir, 
							arr.city as arrCity, arr.state as arrState, flight.arrival_date, flight.arrival_time
					from flight
						join arrival natural join airport as arr on flight.flight_id = arrival.flight_id
						join departure natural join airport as dep on flight.flight_id = departure.flight_id
					where departure.airport_id = '$departure_airport'
						   and arrival.airport_id = '$arrival_airport'";			
		} elseif ($dep_date != "") {
			$sql = "select flight.flight_id, dep.airport_id as depAir, dep.city as depCity, dep.state as depState, 
							flight.departure_date, flight.departure_time, arr.airport_id as arrAir, 
							arr.city as arrCity, arr.state as arrState, flight.arrival_date, flight.arrival_time
					from flight
						join arrival natural join airport as arr on flight.flight_id = arrival.flight_id
						join departure natural join airport as dep on flight.flight_id = departure.flight_id
					where flight.departure_date = '$dep_date'";			
		} elseif ($departure_airport != "") {
			$sql = "select flight.flight_id, dep.airport_id as depAir, dep.city as depCity, dep.state as depState, 
							flight.departure_date, flight.departure_time, arr.airport_id as arrAir, 
							arr.city as arrCity, arr.state as arrState, flight.arrival_date, flight.arrival_time
					from flight
						join arrival natural join airport as arr on flight.flight_id = arrival.flight_id
						join departure natural join airport as dep on flight.flight_id = departure.flight_id
					where departure.airport_id = '$departure_airport'";			
		} elseif ($arrival_airport != "") {
			$sql = "select flight.flight_id, dep.airport_id as depAir, dep.city as depCity, dep.state as depState, 
							flight.departure_date, flight.departure_time, arr.airport_id as arrAir, 
							arr.city as arrCity, arr.state as arrState, flight.arrival_date, flight.arrival_time
					from flight
						join arrival natural join airport as arr on flight.flight_id = arrival.flight_id
						join departure natural join airport as dep on flight.flight_id = departure.flight_id
					where arrival.airport_id = '$arrival_airport'";			
		} else {
			$sql = "select flight.flight_id, dep.airport_id as depAir, dep.city as depCity, dep.state as depState, 
							flight.departure_date, flight.departure_time, arr.airport_id as arrAir, 
							arr.city as arrCity, arr.state as arrState, flight.arrival_date, flight.arrival_time
					from flight
						join arrival natural join airport as arr on flight.flight_id = arrival.flight_id
						join departure natural join airport as dep on flight.flight_id = departure.flight_id";			
		}
				
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {			
			while($row = $result->fetch_assoc()) {
				echo "<tr><td><input type=\"radio\" name=\"flight\" value=" . $row["flight_id"] . " required></td>" .
					"<td>" . $row["depAir"] . "</td>" .
					"<td>" . $row["depCity"] . "</td>" .
					"<td>" . $row["depState"] . "</td>" .
					"<td>" . $row["departure_date"] . "</td>" .
					"<td>" . $row["departure_time"] . "</td>" .
					"<td>" . $row["arrAir"] . "</td>" .
					"<td>" . $row["arrCity"] . "</td>" .
					"<td>" . $row["arrState"] . "</td>" .
					"<td>" . $row["arrival_date"] . "</td>" .
					"<td>" . $row["arrival_time"] . "</td>" .
					"</tr>";
			}
			
			echo "</table><input type=\"submit\">";
			
		} else {
			echo "</table>
				  <p>No flights found from search input</p>
				  <a href=\"filterFlights.php\">Go back</a>";
		}

		$conn->close();
	?>
</body>
</html>