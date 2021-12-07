<?php
    require 'Templates/session.php';
    require 'Templates/header.php';
?>

<body>
    <?php
        require 'Templates/navbar.php';
    ?>

    <section class="container">
        <h1 class="has-text-centered block"></h1>
        <h1 class="has-text-centered block"></h1>

        <?php

        #region - Set Car Index and Get Details
        //if input was blank, input default placeholder, otherwise take the input from the POST and set variable to its value
        if(!isset($_GET['carIndex']))
        {
            $carIndex = "?";
        }
        else
        {
            $carIndex = $_GET['carIndex'];
        }

        require 'Templates/databaseTemplate.php';

        //prepare and run the SQL query
        $loadCar = $pdo->prepare("SELECT * FROM cars WHERE carIndex = :carIndex");
        $loadCar->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
        $loadCar->execute();
        #endregion

        #region - Write Query Results To Screen
        while($row = $loadCar->fetch())
        {
            echo "<section class='columns is-centered'>";
            
            echo "<div class='column'>";
            echo "<img src='pictures/" . $row['picture'] . "' width='500'>";
            echo "</div>";

            echo "<div class='column'>";
            echo "<b>Car: </b>" . $row['make'] . " " . $row['model'];
            echo "<br />";
            echo "<b>Registration: </b>" . $row['Reg'];
            echo "<br />";
            echo "<b>Colour: </b>" . $row['colour'];
            echo "<br /><br />";
            echo "<b>Price: </b>£" . $row['price'];
            echo "<br />";
            echo "<b>Dealer: </b>" . $row['dealer'] .", " . $row['town'] .", " . $row['telephone'];
            echo "<br /><br />";
            echo "<b>Description: </b>" . $row['description'];
            echo "<br /><br />";

            if ($row['available'] == "Y")
            {
                echo "<a class='button is-primary' href='Car_Purchase.php?carIndex=" . $row['carIndex'] . "' method='GET' target='purchasing'>Buy Now!</a>";
            }
            else
            {
                echo "Sorry, this car is no longer for sale.";
            }

            echo "</div>";

            echo "</section>";

            echo "<h1 class='block'></h1>";
            echo "<div class='has-text-centered block'>";
           
        }
        #endregion
        ?>
    </section>

    <section class="container">
        <iframe name="purchasing" title="purchasing" style="border:none;" width="100%" height="500px"></iframe>
    </section>

</body>

</html>