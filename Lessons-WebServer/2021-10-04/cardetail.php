<?php

#if input was blank, in put "default placeholder?", otherwise take the input from the POST and set variable to its value
if(!isset($_GET['carIndex']))
{
	$carIndex = "?";
}
else
{
	$carIndex = $_GET['carIndex'];
}

require 'databaseTemplate.php';

#prepare the SQL statement to run, "?" are placeholders for whatever variables you then put in the execute()
$loadCar = $pdo->prepare("SELECT * FROM cars WHERE carIndex = :carIndex");

#bind the variables and parameters together
$loadCar->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);

#run the statement with the variables as inputs, which replace the ? placeholders in the order they appear in the statement
$loadCar->execute();

#write out the table to screen
while($row = $loadCar->fetch())
{
	echo "Car: " . $row['make'] . " " . $row['model'];
    echo "<br />";
	echo "Registration: " . $row['Reg'];
    echo "<br />";
    echo " Colour: " . $row['colour'];
    echo "<br /><br />";
    echo "Price: £" . $row['price'];
    echo "<br />";
    echo "Dealer: " . $row['dealer'] .", " . $row['town'] .", " . $row['telephone'];
    echo "<br /><br />";
    echo "Description: " . $row['description'];
        echo "<br /><br />";
    echo "<img src='pictures/" . $row['picture'] . "' width='500'>";
    echo "<br /><br />";
    
    if ($row['available'] == "Y")
    {
        echo "<form action='carbuy.php?carIndex=" . $row['carIndex'] . "' method='POST'>";
        echo "<label>First Name: </label>";
        echo "<input type='text' name='firstname'>";
        echo "<label>Surname: </label>";
        echo "<input type='text' name='surname'>";
        echo "<br>";
        echo "<label>Card Number: </label>";
        echo "<input type='text' name='cardnumber'>";
        echo "<label>CVV: </label>";
        echo "<input type='text' name='cvv'>";
        echo "<br><br>";
        echo "<input type='submit' value='Buy'>";
        echo "</form>";
     
    }
    else
    {
        echo "Sorry, this car is no longer for sale.";
    }
}

?>