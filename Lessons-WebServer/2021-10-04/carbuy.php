<?php

#get passed in variable
if(!isset($_GET['carIndex']))
{
	$carIndex = "?";
}
else
{
	$carIndex = $_GET['carIndex'];
}

require 'databaseTemplate.php';

#load the car details
$loadCar = $pdo->prepare("SELECT * FROM cars WHERE carIndex = :carIndex");
$loadCar->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
$loadCar->execute();

#check availability
while($row = $loadCar->fetch())
{
    if($row['available']=="Y")
    {  
        #take in new variables
        if(!isset($_POST['firstname']))
        {
            $firstname = "?";
        }
        else
        {
            $firstname = $_POST['firstname'];
        }
        if(!isset($_POST['surname']))
        {
            $surname = "?";
        }
        else
        {
            $surname = $_POST['surname'];
        }
        if(!isset($_POST['cardnumber']))
        {
            $cardnumber = "?";
        }
        else
        {
            $cardnumber = $_POST['cardnumber'];
        }
        if(!isset($_POST['cvv']))
        {
            $cvv = "?";
        }
        else
        {
            $cvv = $_POST['cvv'];
        }
    
        $amount = $row['price'];   
        
        #insert to orders
        $insertOrder = $pdo->prepare("INSERT INTO orders (firstname, surname, cardnumber, cvv, carIndex, amount)
        VALUES (:firstname, :surname, :cardnumber, :cvv, :carIndex, :amount)");
        $insertOrder->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $insertOrder->bindParam(':surname', $surname, PDO::PARAM_STR);
        $insertOrder->bindParam(':cardnumber', $cardnumber, PDO::PARAM_STR);
        $insertOrder->bindParam(':cvv', $cvv, PDO::PARAM_STR);
        $insertOrder->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
        $insertOrder->bindParam(':amount', $amount, PDO::PARAM_INT);
        $insertOrder->execute();
    
        #update cars table
        $updateAvail = $pdo->prepare("UPDATE cars SET available = 'N' WHERE carIndex = :carIndex");
        $updateAvail->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
        $updateAvail->execute();
    
        echo "Successful Sale!";
    }
    
    else
    {
        echo "Sorry, this car is no longer for sale.";
    }
}

?>