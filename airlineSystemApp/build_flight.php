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
			let senPilot = document.forms["myForm"]["select_senior_pilot"].value;
			let coPilot = document.forms["myForm"]["select_copilot"].value;
			let leadAttend = document.forms["myForm"]["lead_attendant"].value;
			let attendOne = document.forms["myForm"]["flight_attendant_one"].value;
			let attendTwo = document.forms["myForm"]["flight_attendant_two"].value;
				
			let pilotsSame = (senPilot === coPilot) ? true : false;
			let attendsSame = (leadAttend === attendOne || leadAttend === attendTwo || attendOne === attendTwo)
								? true : false;
				
			if (pilotsSame || attendsSame) {
				alert("Each pilot or flight attendant must be filled by a different employee");
				return false;
			}
		}
	</script>
</head>
<body>
	<form name="myForm" method="post" action="finalize.php" onsubmit="return validateForm()">
		<fieldset>
			<h2>Build Flight</h2>
			<ul>
				<li>
					<label for="select_airplane">Select Airplane:</label>
					<select id="select_airplane" name="select_airplane" required>
					<?php
						$dep_date = "";
				
						$dep_date = $_POST["dep_date"];

						$sql = "select *
								from airplane
								where airplane_id not in (
								select airplane_id
								from flight natural join plane_scheduled
								WHERE departure_date = '$dep_date')";
						
						$result = $conn->query($sql);
									
						if ($result->num_rows > 0) {
							echo "<option value=\"\">" . "-" . "</option>";
								
							while($row = $result->fetch_assoc()) {
								echo "<option value=" . $row["airplane_id"] . ">" . $row["make"]. "-" . 
										$row["model"]. ": " . $row["passenger_capacity"] . " seats</option>";								
							}
						} else {
							echo "ERROR retrieving values";
						}			
					?>
					</select>
				</li>
				<li>
					<label for="select_senior_pilot">Select Flight Captain:</label>
					<select id="select_senior_pilot" name="select_senior_pilot" required>
					<?php
						$dep_date = "";
				
						$dep_date = $_POST["dep_date"];

						$sql = "select *
								from pilot join person on pilot_id = person_id
								where rank = 'senior' and pilot_id not in (
								select senior_pilot_id
								from senior_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew) and pilot_id not in (
								select copilot_id
								from copilot_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew)";
						
						$result = $conn->query($sql);
									
						if ($result->num_rows > 0) {
							echo "<option value=\"\">" . "-" . "</option>";
								
							while($row = $result->fetch_assoc()) {
								echo "<option value=" . $row["pilot_id"] . ">" . $row["rank"] . " " . $row["first_name"]. " " . 
										$row["last_name"]. ": " . $row["pilot_hours"] . " hours</option>";								
							}
						} else {
							echo "ERROR retrieving values";
						}			
					?>
					</select>
				</li>
				<li>
					<label for="select_copilot">Select Copilot:</label>
					<select id="select_copilot" name="select_copilot" required>
					<?php
						$dep_date = "";
				
						$dep_date = $_POST["dep_date"];

						$sql = "select *
								from pilot join person on pilot_id = person_id
								where pilot_id not in (
								select senior_pilot_id
								from senior_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew) and pilot_id not in (
								select copilot_id
								from copilot_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew)";
						
						$result = $conn->query($sql);
									
						if ($result->num_rows > 0) {
							echo "<option value=\"\">" . "-" . "</option>";
								
							while($row = $result->fetch_assoc()) {
								echo "<option value=" . $row["pilot_id"] . ">" . $row["rank"] . " " . $row["first_name"]. " " . 
										$row["last_name"]. ": " . $row["pilot_hours"] . " hours</option>";								
							}
						} else {
							echo "ERROR retrieving values";
						}			
					?>
					</select>
				</li>
				<li>
					<label for="lead_attendant">Select Lead Attendant:</label>
					<select id="lead_attendant" name="lead_attendant" required>
					<?php
						$dep_date = "";
				
						$dep_date = $_POST["dep_date"];

						$sql = "select *
								from flight_attendant join person on attendant_id = person_id
								where rank = 'senior' and attendant_id not in (
								select lead_attendant_id
								from lead_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew) and attendant_id not in (
								select attendant_id1
								from attendants_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew) and attendant_id not in (
								select attendant_id2
								from attendants_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew)";
						
						$result = $conn->query($sql);
									
						if ($result->num_rows > 0) {
							echo "<option value=\"\">" . "-" . "</option>";
								
							while($row = $result->fetch_assoc()) {
								echo "<option value=" . $row["attendant_id"] . ">" . $row["rank"] . " " . $row["first_name"]. " " . 
										$row["last_name"]. ": " . $row["flight_hours"] . " hours</option>";								
							}
						} else {
							echo "ERROR retrieving values";
						}			
					?>
					</select>
				</li>
				<li>
					<label for="flight_attendant_one">Select Flight Attendant one:</label>
					<select id="flight_attendant_one" name="flight_attendant_one" required>
					<?php
						$dep_date = "";
				
						$dep_date = $_POST["dep_date"];

						$sql = "select *
								from flight_attendant join person on attendant_id = person_id
								where attendant_id not in (
								select lead_attendant_id
								from lead_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew) and attendant_id not in (
								select attendant_id1
								from attendants_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew) and attendant_id not in (
								select attendant_id2
								from attendants_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew)";
						
						$result = $conn->query($sql);
									
						if ($result->num_rows > 0) {
							echo "<option value=\"\">" . "-" . "</option>";
								
							while($row = $result->fetch_assoc()) {
								echo "<option value=" . $row["attendant_id"] . ">" . $row["rank"] . " " . $row["first_name"]. " " . 
										$row["last_name"]. ": " . $row["flight_hours"] . " hours</option>";								
							}
						} else {
							echo "ERROR retrieving values";
						}			
					?>
					</select>
				</li>
				<li>
					<label for="flight_attendant_two">Select Flight Attendant two:</label>
					<select id="flight_attendant_two" name="flight_attendant_two" required>
					<?php
						$dep_date = "";
				
						$dep_date = $_POST["dep_date"];

						$sql = "select *
								from flight_attendant join person on attendant_id = person_id
								where attendant_id not in (
								select lead_attendant_id
								from lead_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew) and attendant_id not in (
								select attendant_id1
								from attendants_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew) and attendant_id not in (
								select attendant_id2
								from attendants_scheduled natural join (
								select crew_manifest_id
								FROM flight natural join crew_scheduled
								where departure_date = '$dep_date') as flight_crew)";
						
						$result = $conn->query($sql);
									
						if ($result->num_rows > 0) {
							echo "<option value=\"\">" . "-" . "</option>";
								
							while($row = $result->fetch_assoc()) {
								echo "<option value=" . $row["attendant_id"] . ">" . $row["rank"] . " " . $row["first_name"]. " " . 
										$row["last_name"]. ": " . $row["flight_hours"] . " hours</option>";								
							}
						} else {
							echo "ERROR retrieving values";
						}		
						
						$conn->close();
					?>
					</select>
				</li>
			</ul>
			<?php 
				$dep_date = $dep_time = $departure_airport = "";
				$arr_date = $arr_time = $arrival_airport = "";
		
				$dep_date = $_POST["dep_date"];
				$dep_time = $_POST["dep_time"];
				$departure_airport = $_POST["departure_airport"];
				$arr_date = $_POST["arr_date"];
				$arr_time = $_POST["arr_time"];
				$arrival_airport = $_POST["arrival_airport"];
				
				echo "<input type=\"hidden\" name=\"dep_date\" value=" . $dep_date . ">";
				echo "<input type=\"hidden\" name=\"dep_time\" value=" . $dep_time . ">";
				echo "<input type=\"hidden\" name=\"departure_airport\" value=" . $departure_airport . ">";
				echo "<input type=\"hidden\" name=\"arr_date\" value=" . $arr_date . ">";
				echo "<input type=\"hidden\" name=\"arr_time\" value=" . $arr_time . ">";
				echo "<input type=\"hidden\" name=\"arrival_airport\" value=" . $arrival_airport . ">";				
			?>
			<input type="submit">	
		</fieldset>	
	</form>
</body>
</html>