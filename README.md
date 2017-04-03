# CSCI-4850-001
To set up this web application please observe the following steps.

1. Copy the airlineSystemApp folder into your wamp64/www/ folder.
2. Create a database in your localhost/phpmyadmin called airlinesystem and select it for use.
    
  CREATE DATABASE airlinesystem;
  USE airlinesystem;
  
3. Access the file andres-ward.txt in this repo and copy/paste all the statements from part 2.
   This will include the create tables, alter tables, and inserts.

4. Include the following triggers also. You may need to do these one at a time.

  CREATE TRIGGER schedule_flight after insert on plane_scheduled
	  FOR EACH ROW
      UPDATE airplane 
      set miles = miles + 1000 
      where airplane_id = NEW.airplane_id;

  CREATE TRIGGER schedule_flight_captain after insert on senior_scheduled
    FOR EACH ROW
      UPDATE pilot 
      set pilot_hours = pilot_hours + 4
      where pilot_id = NEW.senior_pilot_id;

  CREATE TRIGGER schedule_copilot after insert on copilot_scheduled
    FOR EACH ROW
      UPDATE pilot 
      set pilot_hours = pilot_hours + 4
      where pilot_id = NEW.copilot_id;
  
5. Create a user in the airlinesystem database with username = "user" and password = "passwd".
   It is important that the database be called airlinesystem and that the user info be the above.
   This is because the following information is checked for connecting to the database in the php scripts.
   
  $serverName = "localhost";
	$userName = "user";
	$password = "passwd";
	$dbName = "airlinesystem";
	
	$conn = new mysqli($serverName, $userName, $password, $dbName);
  
----------------------------------------------------------------------------------------------------------------
  Please use a recent version of Chrome when testing for a similar environment.
  
  The application allows two sides of functionality. There is a customer side and an employee side.
The customer side allows a user to search for flights by departure date and/or airports. There is a query to retrieve all
the airports. The script then uses the user input data to present the flights that match. There are many queries here.
Each acts on a different combination of the date/airports to filter down flights or show all.

  From here a user can select a flight. This calls another query to return all the non-reserved seats for the flight.
The user can select their seat and then be taken to a page to enter customer/passenger data. This form data is used to
perform inserts into the person, customer and passenger tables as well as create a row in the has and seats filled tables.

  The other side of the app is the employee side. An employee has two options. They may view all the passengers for any
flight or add a new flight. Viewing all passengers again allows the employee to filter flights. From here the employee selects
a flight. A query is ran to find all passengers of the selected flight.

  The other option is add a flight. The form collects the choice of departure/arrival and airports. The departure date is
used to perfrom multiple queries to determine which airplanes and crew members are available on that date. The next screen
runs the many insertions for creating a flight and manifest. This involves assigning an aircraft, senior pilot, copilot,
lead flight attendant, and two other flight attendants. This also creates as many tickets as the plane is able to carry which
means another query must be run to determine that number. A php for loop is used to perform the number of seats worth of inserts
for new tickets and linking the tickets to the flight.

  This last block is also where the three triggers added in step 4 above come into play. I already used foreign keys to
enforce referential integrity. I chose to use the triggers to perform background actions when a plane or pilot was
scheduled. The triggers increment the number of miles on the scheduled airplane or increments the number of pilot hours
for the scheduled pilots. This saves update statements that a developer would have to write by having the business logic
of updating attributes related to the enterprise be handled by the database globally.
