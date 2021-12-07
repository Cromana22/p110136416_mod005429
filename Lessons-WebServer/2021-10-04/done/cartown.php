<?php

if(!isset($_POST['town']))
{
	$town = "?";
}
else
{
	$town = $_POST['town'];
}

require 'databaseTemplate.php';

$prepare = $pdo->prepare("SELECT count(*) FROM cars WHERE town = ?");
$prepare->execute([$town]);

$rowcount = $prepare->fetchColumn();

echo "Number of Results: " . $rowcount;
echo "<br><br>";

$prepare = $pdo->prepare("SELECT * FROM cars WHERE town = ?");
$prepare->execute([$town]);

while($row = $prepare->fetch())
{
	echo $row['make'].", ";
	echo $row['model'].", ";
	echo $row['Reg'].", ";
	echo $row['colour'].", ";
	echo $row['town'].".";
	echo "<hr />";
}

?>