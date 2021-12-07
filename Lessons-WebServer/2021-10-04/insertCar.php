<?php

#get passed in variables
if(!isset($_POST['make'])) { $make = "?";}
else {$make = $_POST['make'];}
if(!isset($_POST['model'])) { $model = "?";}
else {$model = $_POST['model'];}
if(!isset($_POST['reg'])) { $reg = "?";}
else {$reg = $_POST['reg'];}
if(!isset($_POST['colour'])) { $colour = "?";}
else {$colour = $_POST['colour'];}
if(!isset($_POST['miles'])) { $miles = "?";}
else {$miles = $_POST['miles'];}
if(!isset($_POST['price'])) { $price = "?";}
else {$price = $_POST['price'];}
if(!isset($_POST['dealer'])) { $dealer = "?";}
else {$dealer = $_POST['dealer'];}
if(!isset($_POST['town'])) { $town = "?";}
else {$town = $_POST['town'];}
if(!isset($_POST['telephone'])) { $telephone = "?";}
else {$telephone = $_POST['telephone'];}
if(!isset($_POST['description'])) { $description = "?";}
else {$description = $_POST['description'];}
if(!isset($_POST['region'])) { $region = "?";}
else {$region = $_POST['region'];}
if(!isset($_POST['picture'])) { $picture = "?";}
else {$picture = $_POST['picture'];}

require 'databaseTemplate.php';

$carIndex = $pdo->lastInsertId() + 1;

#insert details
$insert = $pdo->prepare("INSERT INTO cars (make, model, Reg, colour, miles, price, dealer, town,
telephone, description, carIndex, region, picture) VALUES (:make, :model, :reg, :colour, :miles, 
:price, :dealer, :town, :telephone, :description, :carIndex, :region, :picture)");
$insert->bindParam(':make', $make, PDO::PARAM_STR);
$insert->bindParam(':model', $model, PDO::PARAM_STR);
$insert->bindParam(':reg', $reg, PDO::PARAM_STR);
$insert->bindParam(':colour', $colour, PDO::PARAM_STR);
$insert->bindParam(':miles', $miles, PDO::PARAM_STR);
$insert->bindParam(':price', $price, PDO::PARAM_INT);
$insert->bindParam(':dealer', $dealer, PDO::PARAM_STR);
$insert->bindParam(':town', $town, PDO::PARAM_STR);
$insert->bindParam(':telephone', $telephone, PDO::PARAM_STR);
$insert->bindParam(':description', $description, PDO::PARAM_STR);
$insert->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
$insert->bindParam(':region', $region, PDO::PARAM_STR);
$insert->bindParam(':picture', $picture, PDO::PARAM_STR);
$insert->execute();

#load the car details
$loadCar = $pdo->prepare("SELECT * FROM cars WHERE carIndex = :carIndex");
$loadCar->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
$loadCar->execute();

#write details
while($row = $loadCar->fetch())
{
    echo "Car Added: ";
    echo $row['carIndex'];
    echo $row['make'].", ";
    echo $row['model'].", ";
    echo $row['Reg'].", ";
    echo $row['colour'].". &nbsp ";
    echo "<img src='pictures/" . $row['picture'] . "' width='100'>";
    echo "<br /><hr />";
}

?>