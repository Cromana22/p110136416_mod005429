<?php

#if input was blank, in put "default placeholder?", otherwise take the input from the POST and set variable to its value
if(!isset($_GET['make']))
{
	$make = "?";
}
else
{
	$make = $_GET['make'];
}
if (!isset($_GET['model']))
{
	$model = "?";
}
else
{
	$model = $_GET['model'];
}

#to run a piece of code saved in another file (e.g. database connection)
#"include" it will continue running further code if it errors. "require" it will stop running code if it errors

require 'databaseTemplate.php';

#direct run a query (only if you don't need variables used)
#$stmt = $pdo->query('SELECT * FROM cars');

# "->" means populate with the stuff from the right. e.g. $pdo->query() means populate $pdo variable with results of the query

#prepare the SQL statement to run, "?" are placeholders for whatever variables you then put in the execute()
$prepare = $pdo->prepare("SELECT * FROM cars WHERE make = :make AND model = :model");

#bind the variables and parameters together
$prepare->bindParam(':make', $make, PDO::PARAM_INT);
$prepare->bindParam(':model', $model, PDO::PARAM_INT);

#run the statement with the variables as inputs, which replace the ? placeholders in the order they appear in the statement
$prepare->execute();

#write out the table to screen
while($row = $prepare->fetch())
{
	if ($row['available']=="Y")
	{
		echo $row['carIndex'];
		echo $row['make'].", ";
		echo $row['model'].", ";
		echo $row['Reg'].", ";
		echo $row['colour'].". &nbsp ";
		echo "<img src='pictures/" . $row['picture'] . "' width='100'>";
		echo "<a href='cardetail.php?carIndex=" . $row['carIndex'] . "' target='_blank'>More Details</a>";
	
		#hr means horizontal rule
		echo "<hr />";
	}
}

?>