<?php

if(!isset($_POST['price']))
{
	$price = "?";
}
else
{
	$price = $_POST['price'];
}

require 'databaseTemplate.php';

$prepare = $pdo->prepare("SELECT count(*) FROM cars WHERE price > ?");
$prepare->execute([$price]);

$rowcount = $prepare->fetchColumn();

echo "Number of Results: " . $rowcount;
echo "<br><br>";

$prepare = $pdo->prepare("SELECT * FROM cars WHERE price > ?");
$prepare->execute([$price]);

while($row = $prepare->fetch())
{
	echo $row['make'].", ";
	echo $row['model'].", ";
	echo $row['Reg'].", ";
	echo $row['colour'].", ";
	echo $row['price'].".";
	echo "<hr />";
}

?>