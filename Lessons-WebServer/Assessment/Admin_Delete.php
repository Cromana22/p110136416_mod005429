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
    <section class="container has-text-centered">
        <div class="block"></div>
        <p class="is-size-4 has-text-danger">Are you sure you want to delete this car?</p><br /><br />

        <?php

        if(!isset($_GET['carIndex'])) { $carIndex = "?";}
        else {$carIndex = $_GET['carIndex'];}
        
        require 'Templates/databaseTemplate.php';
        
        #load the car details
        $loadCar = $pdo->prepare("SELECT * FROM cars WHERE carIndex = :carIndex");
        $loadCar->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
        $loadCar->execute();
        
        while($row = $loadCar->fetch())
        {
            echo $row['make']." ".$row['model']." (".$row['colour']."), Registration Year: ".$row['Reg'];
            echo "<br /><br /><img width='50%' src='pictures/" . $row['picture'] . "'>";
        }

        echo "<br /><br />";
        echo "<a class='button is-danger' href='Admin_Delete_Confirmed.php?carIndex=" . $carIndex . "'>CONFIRM</a>";
        echo "&nbsp&nbsp&nbsp&nbsp";
        echo "<a class='button is-info' href='".$_SESSION['backUrl']."' target='_parent'>CANCEL</a>";
        ?>

    </section>

</body>

</html>