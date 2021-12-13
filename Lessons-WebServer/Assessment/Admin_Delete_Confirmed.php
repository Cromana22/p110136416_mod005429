<?php
    require 'Templates/session.php';
    require 'Templates/header.php';
    
    #region - Admin Login Check, if not admin, redirect to home page.
    if ($_SESSION['utype'] != "Admin")
    {
        header("Location: Home.php");
    }
    #endregion
?>

<body>
    <?php

    //get passed in variables
    if(!isset($_GET['carIndex'])) { $carIndex = "?";}
    else {$carIndex = $_GET['carIndex'];}

    require 'Templates/databaseTemplate.php';

    //delete details
    $delete = $pdo->prepare("DELETE FROM cars WHERE carIndex = :carIndex");
    $delete->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
    $delete->execute();

    //redirect back to previous location
    $redirect = $_SESSION['backUrl'];
    header("Location: ./pictures/shake-hand-3677534_1280.jpg");

    ?>
</body>

</html>