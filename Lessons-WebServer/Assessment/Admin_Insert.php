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
        require 'Templates/navbar.php';
    ?>

    <section class="container has-text-centered">
        <div class="block"></div>
        <h1 class="is-size-3"><u>Add New Car</u></h1>
        <div class="block"></div>

        <?php
            require 'Templates/databaseTemplate.php';

            #region - set all form variables
            if (isset($_POST['make'])) { $make = $_POST['make']; } else { $make = ""; }
            if (isset($_POST['model'])) { $model = $_POST['model']; } else { $model = ""; }
            if (isset($_POST['reg'])) { $reg = $_POST['reg']; } else { $reg = ""; }
            if (isset($_POST['colour'])) { $colour = $_POST['colour']; } else { $colour = ""; }
            if (isset($_POST['miles'])) { $miles = $_POST['miles']; } else { $miles = ""; }
            if (isset($_POST['price'])) { $price = $_POST['price']; } else { $price = ""; }
            if (isset($_POST['dealer'])) { $dealer = $_POST['dealer']; } else { $dealer = ""; }
            if (isset($_POST['town'])) { $town = $_POST['town']; } else { $town = ""; }
            if (isset($_POST['telephone'])) { $telephone = $_POST['telephone']; } else { $telephone = ""; }
            if (isset($_POST['description'])) { $description = $_POST['description']; } else { $description = ""; }
            if (isset($_POST['region'])) { $region = $_POST['region']; } else { $region = ""; }
            if (isset($_POST['picture'])) { $picture = $_POST['picture']; } else { $picture = ""; }
            $carIndex = 0;
            $result = $pdo->query("SELECT MAX(carIndex) FROM cars");
            while($row = $result->fetch())
            {
                $carIndex = $row['MAX(carIndex)'] + 1;
            }
            #endregion

            #region - input form
            if (!isset($_POST['submit']))
            {
                echo "<form method='POST'>";
                echo "<div class='columns'>";

                echo "<div class='column'>";
                echo "<label class='label'>Make: &nbsp;</label>";
                echo "<input class='input' type='text' name='make' value='".$make."' required>";
                echo "<label class='label'>Model: </label>";
                echo "<input class='input' type='text' name='model' value='".$model."' required>";
                echo "<label class='label'>Reg: &nbsp;</label>";
                echo "<input class='input' type='text' name='reg' value='".$reg."' required>";
                echo "<label class='label'>Colour: </label>";
                echo "<input class='input' type='text' name='colour' value='".$colour."' required>";
                echo "<label class='label'>Miles: &nbsp;</label>";
                echo "<input class='input' type='text' name='miles' value='".$miles."' required>";
                echo "<label class='label'>Price: </label>";
                echo "<input class='input' type='text' name='price' value='".$price."' required>";
                echo "</div>";
                
                echo "<div class='column'>";
                echo "<label class='label'>Dealer: &nbsp;</label>";
                echo "<input class='input' type='text' name='dealer' value='".$dealer."' required>";
                echo "<label class='label'>Town: </label>";
                echo "<input class='input' type='text' name='town' value='".$town."' required>";
                echo "<label class='label'>Telephone: &nbsp;</label>";
                echo "<input class='input' type='text' name='telephone' value='".$telephone."' required>";
                echo "<label class='label'>Description: </label>";
                echo "<input class='input' type='text' name='description' value='".$description."' required>";
                echo "<label class='label'>Region: &nbsp;</label>";
                echo "<input class='input' type='text' name='region' value='".$region."' required>";
                echo "<label class='label'>Picture: </label>";
                echo "<input class='input' type='text' name='picture' value='".$picture."' required>";
                echo "</div>";
                echo "</div>";

                echo "<input class='button is-primary' type='submit' name = 'submit' value='Add'>";
                echo "</form>";
            }   
            #endregion

            if (isset($_POST['submit']))
            {
                #region - insert car
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
                #endregion

                #region - load and display the car details
                $loadCar = $pdo->prepare("SELECT * FROM cars WHERE carIndex = :carIndex");
                $loadCar->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
                $loadCar->execute();

                echo "<br /><br /><br />";
                while($row = $loadCar->fetch())
                {
                    echo "<br /><br />";
                    echo "<div class='columns is-centered'>";
                    echo "<div class='column is-one-half'>";
                    echo "<div class='message is-success has-text-centered'><div class='message-body'>";
                    echo "Car Added: ".$row['make']." ".$row['model']." (".$row['colour']."), Registration ".$row['Reg'];
                    echo "</div></div>";
                    echo "</div></div>";
                }
                #endregion

                echo "<br />";
                echo "Add another? ";
                echo "<a class='button is-primary' href='Admin_Insert.php' target='_self'>Yes</a> ";
                echo "<a class='button is-info' href='Admin_Main.php' target='_self'>No</a>";
            }

        ?>
    </section>

</body>

</html>