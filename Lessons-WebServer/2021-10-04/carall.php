<?php

require 'databaseTemplate.php';

$stmt = $pdo->query('SELECT * FROM cars');
while($row = $stmt->fetch())
{
	if ($row['available']=="Y")
	{
		echo $row['carIndex'].", ";
		echo $row['make'].", ";
		echo $row['model'].", ";
		echo $row['Reg'].", ";
		echo $row['colour'].". &nbsp ";
		echo "<img src='pictures/" . $row['picture'] . "' width='100'>";
		echo "<a href='carDeleteConfirm.php?carIndex=" . $row['carIndex'] . "'>Delete</a>";
	
		#hr means horizontal rule
		echo "<hr />";
	}
}
?>