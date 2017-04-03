<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Airline System App</title>
</head>
<body>
	<h1> Choose your seat </h1>
	<form method="post" action="checkout.php">
	<table>
		<tr>
			<th>Select</th>
			<th>seat number</th>
			<th>price ($)</th>
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
		
		$flight = "";
		
		$flight = $_POST["flight"];
		
		$sql = "select seats_filled.flight_id, seats_filled.ticket_id, ticket.seat_number, ticket.price
				from seats_filled natural join ticket
				where seats_filled.flight_id = '$flight' AND
				seats_filled.ticket_id not in (
					select has.ticket_id
					from has);";
					
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {			
			while($row = $result->fetch_assoc()) {				
				echo "<tr><td><input type=\"radio\" name=\"ticket_id\" value=" . $row["ticket_id"] . " required></td>" .
					"<td>" . $row["seat_number"] . "</td>" .
					"<td>" . $row["price"] . "</td>" .				
					"</tr>";
			}
			
			echo "</table><input type=\"submit\">";
			
		} else {
			echo "</tr></table>
				  <p>Sorry, all seats are sold out</p>
				  <a href=\"customer.php\">Go back</a>";
		}

		$conn->close();
	?>
</body>
</html>