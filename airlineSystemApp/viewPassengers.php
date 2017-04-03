<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Airline System App</title>
</head>
<body>
	<a href="employee.php">Back to Employee</a>
	<h2>Passenger Details</h2>
	<table>
		<tr>
			<th>Seat Number</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Phone Number</th>
			<th>Email</th>
			<th>Gender</th>
			<th>Birth Date</th>
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
			
			$flightId = "";
			
			$flightId = $_POST["flight"];
			
			$sql = "select *
					from passenger join person on passenger_id = person_id 
						 join has on has.passenger_id = passenger.passenger_id 
						 join ticket on ticket.ticket_id = has.ticket_id
					where passenger.passenger_id in (
						select passenger_id
						from has natural join seats_filled
						where flight_id = $flightId) AND
                        ticket.ticket_id in (
						select ticket_id
						from flight natural join seats_filled
						where flight_id = $flightId)";
											
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {			
				while($row = $result->fetch_assoc()) {
					echo "<tr>" .
						"<td>" . $row["seat_number"] . "</td>" .
						"<td>" . $row["first_name"] . "</td>" .
						"<td>" . $row["last_name"] . "</td>" .
						"<td>" . $row["phone_number"] . "</td>" .
						"<td>" . $row["email"] . "</td>" .
						"<td>" . $row["gender"] . "</td>" .
						"<td>" . $row["birth_date"] . "</td>" .
						"</tr>";
				}				
				
				echo "</table>";
			} else {
				echo "</table>
					  <p>No passengers found for chosen flight</p>
					  <a href=\"filterFlights.php\">Return to flight selection</a>";
			}

			$conn->close();
		?>
</body>
</html>