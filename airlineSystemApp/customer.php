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
</head>
<body>
	<nav>
		<ul>
			<li><a href = "index.html"> Home </a></li>
		</ul>
	</nav>
	<h1> Welcome Customer! </h1>
	<form method="post" action="flight_search.php">
		<fieldset>
			<h2>Select airports and dates</h2>
			<ul>
				<li>
					<label for="dep_date">Departure Date:</label>
					<input type="date" id="dep_date" name="dep_date">
				</li>
				<li>
					<label for="departure_airport">Departure Airport:</label>
					<select id="departure_airport" name="departure_airport">
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
					<label for="arrival_airport">Arrival Airport:</label>
					<select id="arrival_airport" name="arrival_airport">
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