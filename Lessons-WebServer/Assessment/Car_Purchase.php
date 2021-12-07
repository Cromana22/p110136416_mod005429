<?php
    require 'Templates/session.php';
	echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css'>";

	$carIndex = $_GET['carIndex'];

    require 'Templates/databaseTemplate.php';

    #region - Set Default Variables
    $firstname = "";
    $surname = "";
    $address1 = "";
    $address2 = "";
    $town = "";
    $postcode = "";
    $email = "";
    $cardnumber = "";
    $expiry = "";
    $cvv = "";
    #endregion 

    #region - If Logged In, Load Customer Details
    if ($_SESSION['loggedin'] == "Y" and isset($_SESSION['custid']))
    {
        $loadCustomer = $pdo->prepare("SELECT * FROM customers WHERE id = :custid");
        $loadCustomer->bindParam(':custid', $_SESSION['custid'], PDO::PARAM_INT);
        $loadCustomer->execute();

        while($row = $loadCustomer->fetch())
        {
            $firstname = $row['firstname'];
            $surname = $row['surname'];
            $address1 = $row['address1'];
            $address2 = $row['address2'];
            $town = $row['town'];
            $postcode = $row['postcode'];
            $email = $row['email'];
            $cardnumber = $row['cardnumber'];
            $expiry = $row['expiry'];
            $cvv = $row['cvv'];
        }
    }
    #endregion

    #region - Load Car Details
    $loadCar = $pdo->prepare("SELECT * FROM cars WHERE carIndex = :carIndex");
    $loadCar->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
    $loadCar->execute();
    #endregion

    #region - Personal Details and Payment Form
    while($row = $loadCar->fetch())
    {
        echo "<form action='Car_Buy.php?carIndex=" . $row['carIndex'] . "' method='POST'>";

        echo "<fieldset>";
        echo "<legend><u>Personal Details</u></legend>";
        echo "<div class='container columns is-centered'>";
        
        echo "<div class='column'>";
        echo "<label class='label'>First Name: </label>";
        echo "<input class='input' type='text' name='firstname' required value='" . $GLOBALS['firstname'] . "'>";
        echo "<label class='label'>Surname: </label>";
        echo "<input class='input' type='text' name='surname' required value='" . $GLOBALS['surname'] . "'>";
        echo "<label class='label'>Email Address: </label>";
        echo "<input class='input' type='email' name='email' required value='" . $GLOBALS['email'] . "'>";
        echo "</div>";

        echo "<div class='column'>";
        echo "<label class='label'>Address Line 1: </label>";
        echo "<input class='input' type='text' name='address1' required value='" . $GLOBALS['address1'] . "'>";
        echo "<label class='label'>Address Line 2: </label>";
        echo "<input class='input' type='text' name='address2' value='" . $GLOBALS['address2'] . "'>";
        echo "<label class='label'>Town: </label>";
        echo "<input class='input' type='text' name='town' required value='" . $GLOBALS['town'] . "'>";
        echo "<label class='label'>Postcode: </label>";
        echo "<input class='input' type='text' name='postcode' required value='" . $GLOBALS['postcode'] . "'>";
        echo "</div>";

        echo "</div>";
        echo "</fieldset>";

        echo "<fieldset>";
        echo "<legend><u>Payment Details</u></legend>";
        echo "<div class='container columns'>";
        
        echo "<div class='column'>";
        echo "<label class='label'>Card Number: </label>";
        echo "<input class='input' type='text' name='cardnumber' required value='" . $GLOBALS['cardnumber'] . "'>";
        echo "</div>";

        echo "<div class='column'>";
        echo "<label class='label'>Expiry Date: </label>";
        echo "<input class='input' type='date' name='expiry' required value='" . $GLOBALS['expiry'] . "'>";
        echo "</div>";

        echo "<div class='column'>";
        echo "<label class='label'>CVV: </label>";
        echo "<input class='input' type='password' name='cvv' required value='" . $GLOBALS['cvv'] . "'>";
        echo "</div>";

        echo "<br /><br />";
        echo "</div>";
        echo "</fieldset>";

        echo "<br />";
        echo "<div class='has-text-centered'>";
        echo "<input class='button is-primary' type='submit' value='Submit'>";
        echo "</div>";
        echo "</form>";
    }
    #endregion

?>