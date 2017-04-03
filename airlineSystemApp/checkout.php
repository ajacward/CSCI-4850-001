<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Airline System App</title>
</head>
<body>
	<h1> Checkout </h1>
	<form method="post" action="complete.php">
		<fieldset>
			<h2>Customer Info</h2>
			<ul>
				<li>
					<label for="cust_first_name">First Name:</label>
					<input type="text" id="cust_first_name" name="cust_first_name" required="required">
				</li>
				<li>
					<label for="cust_last_name">Last Name:</label>
					<input type="text" id="cust_last_name" name="cust_last_name" required="required">
				</li>
				<li>
					<label for="cust_phone_number">Phone Number:</label>
					<input type="tel" id="cust_phone_number" name="cust_phone_number" pattern="[0-9]{10}"
							title="Numbers only" required="required">
				</li>
				<li>
					<label for="cust_email">Email:</label>
					<input type="email" id="cust_email" name="cust_email" required="required">
				</li>
				<li>
					<label for="cust_street_number">Street Number:</label>
					<input type="number" id="cust_street_number" name="cust_street_number" required="required">
				</li>
				<li>
					<label for="cust_street_name">Street Name:</label>
					<input type="text" id="cust_street_name" name="cust_street_name" required="required">
				</li>
				<li>
					<label for="cust_apt_number">Apt Number:</label>
					<input type="number" id="cust_apt_number" name="cust_apt_number">
				</li>			
				<li>
					<label for="cust_city">City:</label>
					<input type="text" id="cust_city" name="cust_city" required="required">
				</li>
				<li>
					<label for="cust_state">State Abbreviation:</label>
					<input type="text" id="cust_state" name="cust_state" pattern="[A-Z]{2}" maxlength="2" required="required">
				</li>
				<li>
					<label for="cust_zip">Zip Code:</label>
					<input type="number" id="cust_zip" name="cust_zip" pattern="[0-9]{5}" max="99999" required="required">
				</li>
				<li>
					<label for="cust_birth_date">Birth Date:</label>
					<input type="date" id="cust_birth_date" name="cust_birth_date" required="required">
				</li>
				<li>
				<label for="cust_gender">Gender:</label>
					<input type="text" id="cust_gender" name="cust_gender" pattern="[FM]{1}" maxlength="1" required="required">
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<h2>Passenger Info</h2>
			<ul>
				<li>
					<input type="checkbox" id="passenger_is_customer" name="isSame" value="isSame">
					<label for="passenger_is_customer">Is the customer also the passenger?<label>
				</li>
				<p> If passenger is different from customer then please fill in passenger details </p>
				<li>
					<label for="pass_first_name">First Name:</label>
					<input type="text" id="pass_first_name" name="pass_first_name">
				</li>
				<li>
					<label for="pass_last_name">Last Name:</label>
					<input type="text" id="pass_last_name" name="pass_last_name">
				</li>
				<li>
					<label for="pass_phone_number">Phone Number:</label>
					<input type="tel" id="pass_phone_number" name="pass_phone_number" pattern="[0-9]{10}"
							title="Numbers only">
				</li>
				<li>
					<label for="pass_email">Email:</label>
					<input type="email" id="pass_email" name="pass_email">
				</li>
				<li>
					<label for="pass_birth_date">Birth Date:</label>
					<input type="date" id="pass_birth_date" name="pass_birth_date">
				</li>
				<li>
					<label for="pass_gender">Gender:</label>
					<input type="text" id="pass_gender" name="pass_gender" pattern="[FM]{1}" maxlength="1">
				</li>
			</ul>
		</fieldset>
		<?php 
			$ticket_id = $_POST["ticket_id"];
			echo "<input type=\"hidden\" name=\"ticket_id\" value=" . $ticket_id . ">";
		?>
		<input type="submit">
	</form>
</body>
</html>