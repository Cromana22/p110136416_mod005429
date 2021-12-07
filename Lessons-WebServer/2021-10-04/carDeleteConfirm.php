<?php

#get passed in variables
if(!isset($_GET['carIndex'])) { $carIndex = "?";}
else {$carIndex = $_GET['carIndex'];}

require 'databaseTemplate.php';

echo "Are you sure you want to delete this car? : <br /><br />";

#load the car details
$loadCar = $pdo->prepare("SELECT * FROM cars WHERE carIndex = :carIndex");
$loadCar->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
$loadCar->execute();

while($row = $loadCar->fetch())
{
    echo $row['carIndex'];
    echo $row['make'].", ";
    echo $row['model'].", ";
    echo $row['Reg'].", ";
    echo $row['colour'].". &nbsp ";
    echo "<img src='pictures/" . $row['picture'] . "' width='100'>";
}
echo "<br /><br />";
echo "<a href='carDelete.php?carIndex=" . $carIndex . "'>CONFIRM</a>";
echo "&nbsp&nbsp&nbsp&nbsp";
echo "<a href='carall.php'>CANCEL</a>";

?>