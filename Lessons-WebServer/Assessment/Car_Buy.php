<?php
    require 'Templates/session.php';
    echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css'>";
?>

<?php

#region - Get Car Index and Load Car Details
if(!isset($_GET['carIndex']))
{
	$carIndex = "?";
}
else
{
	$carIndex = $_GET['carIndex'];
}

require 'Templates/databaseTemplate.php';

$loadCar = $pdo->prepare("SELECT * FROM cars WHERE carIndex = :carIndex");
$loadCar->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
$loadCar->execute();
#endregion

//check availability
while($row = $loadCar->fetch())
{
    if($row['available']=="Y")
    {  
        #region - Take In Variables
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $address1 = $_POST['address1'];
        $town = $_POST['town'];
        $postcode = $_POST['postcode'];
        $email = $_POST['email'];

        if (isset ($_POST['address2']))
        {
            $address2 = $_POST['address2'];
        }

        $cardnumber = $_POST['cardnumber'];
        $expiry = $_POST['expiry'];
        $cvv = $_POST['cvv'];
    
        $amount = $row['price'];   
        #endregion

        if ($_SESSION['loggedin'] == "N")
        {
            #region - Insert Customer If Not Logged In
            $insertCustomer = $pdo->prepare("INSERT INTO customers (firstname, surname, address1, address2, town, postcode, email, cardnumber, expiry, cvv)
            VALUES (:firstname, :surname, :address1, :address2, :town, :postcode, :email, :cardnumber, :expiry, :cvv)");
            $insertCustomer->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $insertCustomer->bindParam(':surname', $surname, PDO::PARAM_STR);
            $insertCustomer->bindParam(':address1', $address1, PDO::PARAM_STR);
            $insertCustomer->bindParam(':address2', $address2, PDO::PARAM_STR);
            $insertCustomer->bindParam(':town', $town, PDO::PARAM_STR);
            $insertCustomer->bindParam(':postcode', $postcode, PDO::PARAM_STR);
            $insertCustomer->bindParam(':email', $email, PDO::PARAM_STR);
            $insertCustomer->bindParam(':cardnumber', $cardnumber, PDO::PARAM_STR);
            $insertCustomer->bindParam(':expiry', $expiry, PDO::PARAM_INT);
            $insertCustomer->bindParam(':cvv', $cvv, PDO::PARAM_STR);
            $insertCustomer->execute();

            //load the customer id for order logging
            $_SESSION['custid'] = $pdo->lastInsertId();
            #endregion
        }
        else
        {
            #region - Update Customer If Logged In
            $updateCustomer = $pdo->prepare("UPDATE customers SET firstname = :firstname, surname = :surname, address1 = :address1, address2 = :address2, town = :town, postcode = :postcode, email = :email, cardnumber = :cardnumber, expiry = :expiry, cvv = :cvv WHERE id = :custid");
            $updateCustomer->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $updateCustomer->bindParam(':surname', $surname, PDO::PARAM_STR);
            $updateCustomer->bindParam(':address1', $address1, PDO::PARAM_STR);
            $updateCustomer->bindParam(':address2', $address2, PDO::PARAM_STR);
            $updateCustomer->bindParam(':town', $town, PDO::PARAM_STR);
            $updateCustomer->bindParam(':postcode', $postcode, PDO::PARAM_STR);
            $updateCustomer->bindParam(':email', $email, PDO::PARAM_STR);
            $updateCustomer->bindParam(':cardnumber', $cardnumber, PDO::PARAM_STR);
            $updateCustomer->bindParam(':expiry', $expiry, PDO::PARAM_INT);
            $updateCustomer->bindParam(':cvv', $cvv, PDO::PARAM_STR);
            $updateCustomer->bindParam(':custid', $_SESSION['custid'], PDO::PARAM_STR);
            $updateCustomer->execute();
            #endregion
        }

        #region - Insert Order and Make Car Unavailable
        //insert to orders table
        $insertOrder = $pdo->prepare("INSERT INTO orders (carIndex, amount, customerId)
        VALUES (:carIndex, :amount, :custid)");
        $insertOrder->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
        $insertOrder->bindParam(':amount', $amount, PDO::PARAM_INT);
        $insertOrder->bindParam(':custid', $_SESSION['custid'], PDO::PARAM_STR);
        $insertOrder->execute();
    
        //update cars table
        $updateAvail = $pdo->prepare("UPDATE cars SET available = 'N' WHERE carIndex = :carIndex");
        $updateAvail->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
        $updateAvail->execute();
        #endregion

        #region - Output Success Text
        echo "<div class='container has-text-centered'>";

        echo "<h1 class='is-size-2'><b>Purchase Complete!</b></h1><br />";
        echo "Thank you " . $firstname . " " . $surname . " for purchasing your new " . $row['make'] . " " . $row['model'] . "! <br />";
        echo "Your car can be collected in 3 working days from " . $row['dealer'] . ", " . $row['town'] . " (" . $row['telephone'] . ").<br />";
        echo "Please bring your driving license, proof of insurance, and payment card with you to collect.";
        echo "Happy driving!";

        echo "<br /><br /><br />";
        echo "<div class='columns'>";
        echo "<div class='column'>";
        echo "<a href='https://www.nfumutual.co.uk/insurance/motor-insurance/car-insurance/' target='_blank'>";
        echo "<img src='https://media.nfuonline.com/Uploaded_Files/_media/8/f0bab6ad-1220-4a9d-a6d9-f30ac43a496a_275.jpg'></img>";
        echo "</a></div>";
        echo "<div class='column'>";
        echo "<a href='https://www.rias.co.uk/car-insurance' target='_blank'>";
        echo "<img src='https://www.rias.co.uk/globalassets/rias/assets/rias-logo-global-social-sharing-image.jpg'></img>";
        echo "</a></div>";
        echo "<div class='column'>";
        echo "<a href='https://www.privilege.com/car-insurance' target='_blank'>";
        echo "<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSVSe77sHta0bRQAM82qS22llA8P-3NNRHGgOh0BjXAazxuZ5xFKIIVcThD6fGWp-yx0qI&usqp=CAU'></img>";
        echo "</a></div>";
        echo "</div>";

        echo "</div>";

        #endregion
    }
    
    else
    {
        echo "Sorry, this car is no longer for sale.";
    }
}

?>