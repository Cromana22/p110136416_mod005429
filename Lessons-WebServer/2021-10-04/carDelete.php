<?php

#get passed in variables
if(!isset($_GET['carIndex'])) { $carIndex = "?";}
else {$carIndex = $_GET['carIndex'];}

require 'databaseTemplate.php';

#delete details
$delete = $pdo->prepare("DELETE FROM cars WHERE carIndex = :carIndex");
$delete->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
$delete->execute();

#write success
echo "Delete Successful.";

?>