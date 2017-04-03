<!DOCTYPE html>

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
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Airline System App</title>
	<script>
		function validateForm() {
			let x = document.forms["myForm"]["departure_airport"].value;
			let y = document.forms["myForm"]["arrival_airport"].value;
			
			if (x === y) {
				alert("Departure and arrival airports must be different");
				return false;
			}
		}
	</script>
</head>
<body>
	<form name="myForm" method="post" action="build_flight.php" onsubmit="return validateForm()">
		<fieldset>
			<h2>Select airports and dates</h2>
			<ul>
				<li>
					<label for="dep_date">Departure Date:</label>
					<input type="date" id="dep_date" name="dep_date" required>
				</li>
				<li>
					<label for="dep_time">Departure Time:</label>
					<input type="time" id="dep_time" name="dep_time" required>
				</li>
				<li>
					<label for="departure_airport">Departure Airport:</label>
					<select id="departure_airport" name="departure_airport" required>
						<?php
							$sql = "SELECT * FROM airport";
							$result = $conn->query($sql);
							
							if ($result->num_rows > 0) {
								echo "<option value=\"\">" . "-" . "</option>";
								
								while($row = $result->fetch_assoc()) {
									echo "<option value=" . $row["airport_id"] . ">" . $row["airport_id"]. " - " . $row["city"]. ", " . $row["state"]. "</option>";
								}
							} else {
								echo "ERROR retrieving values";
							}
						?>
					</select>
				</li>
				<li>
					<label for="arr_date">Arrival Date:</label>
					<input type="date" id="arr_date" name="arr_date" required>
				</li>
				<li>
					<label for="arr_time">Arrival Time:</label>
					<input type="time" id="arr_time" name="arr_time" required>
				</li>
				<li>
					<label for="arrival_airport">Arrival Airport:</label>
					<select id="arrival_airport" name="arrival_airport" required>
						<?php
							$sql = "SELECT * FROM airport";
							$result = $conn->query($sql);
							
							if ($result->num_rows > 0) {
								echo "<option value=\"\">" . "-" . "</option>";
								
								while($row = $result->fetch_assoc()) {
									echo "<option value=" . $row[airport_id] . ">" . $row["airport_id"]. " - " . $row["city"]. ", " . $row["state"]. "</option>";
								}
							} else {
								echo "ERROR retrieving values";
							}
							
							$conn->close();
						?>
					</select>
				</li>
			</ul>
			<input type="submit">
		</fieldset>
	</form>
</body>
</html>