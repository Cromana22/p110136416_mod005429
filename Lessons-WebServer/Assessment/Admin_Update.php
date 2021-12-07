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

    <section>
        <?php
            require 'Templates/databaseTemplate.php';

            $carIndex = $_GET['carIndex'];

            #region - load car and set form variables
            $loadCar = $pdo->prepare("SELECT * FROM cars WHERE carIndex = :carIndex");
            $loadCar->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
            $loadCar->execute();

            while($row = $loadCar->fetch())
            {
                if (isset($_POST['make'])) { $make = $_POST['make']; } else { $make = $row['make']; }
                if (isset($_POST['model'])) { $model = $_POST['model']; } else { $model = $row['model']; }
                if (isset($_POST['reg'])) { $reg = $_POST['reg']; } else { $reg = $row['Reg']; }
                if (isset($_POST['colour'])) { $colour = $_POST['colour']; } else { $colour = $row['colour']; }
                if (isset($_POST['miles'])) { $miles = $_POST['miles']; } else { $miles = $row['miles']; }
                if (isset($_POST['price'])) { $price = $_POST['price']; } else { $price = $row['price']; }
                if (isset($_POST['dealer'])) { $dealer = $_POST['dealer']; } else { $dealer = $row['dealer']; }
                if (isset($_POST['town'])) { $town = $_POST['town']; } else { $town = $row['town']; }
                if (isset($_POST['telephone'])) { $telephone = $_POST['telephone']; } else { $telephone = $row['telephone']; }
                if (isset($_POST['description'])) { $description = $_POST['description']; } else { $description = $row['description']; }
                if (isset($_POST['region'])) { $region = $_POST['region']; } else { $region = $row['region']; }
                if (isset($_POST['picture'])) { $picture = $_POST['picture']; } else { $picture = $row['picture']; }
                if (isset($_POST['available'])) { $available = $_POST['available']; } else { $available = $row['available']; }
            }
            if ($available == "Y")
            {
                $availableYes = "selected";
                $availableNo = "";
            }
            else
            {
                $availableYes = "";
                $availableNo = "selected";
            }
            #endregion

            echo "<div class='block'></div>";
            echo "<h2 class='is-size-3 has-text-centered'><u>Updating Car</u></h2><br />";
            echo "<div class='container'>";
            #region - input form
            echo "<form method='POST'>";
            echo "<div class='container columns is-centered'>";

            echo "<div class='column'>";
            echo "<label class='label is-small'>Make: </label>";
            echo "<input class='input' type='text' name='make' value='".$make."' required>";
            echo "<label class='label is-small'>Model: </label>";
            echo "<input class='input' type='text' name='model' value='".$model."' required>";
            echo "<label class='label is-small'>Reg: </label>";
            echo "<input class='input' type='text' name='reg' value='".$reg."' required>";
            echo "<label class='label is-small'>Colour: </label>";
            echo "<input class='input' type='text' name='colour' value='".$colour."' required>";
            echo "<label class='label is-small'>Miles: </label>";
            echo "<input class='input' type='text' name='miles' value='".$miles."' required>";
            echo "<label class='label is-small'>Description: </label>";
            echo "<input class='input' type='text' name='description' value='".$description."' required>";
            echo "<label class='label is-small'>Picture: </label>";
            echo "<input class='input' type='text' name='picture' value='".$picture."' required>";
            echo "</div>";

            echo "<div class='column'>";
            echo "<label class='label is-small'>Price: </label>";
            echo "<input class='input' type='text' name='price' value='".$price."' required><br />";
            echo "<label class='label is-small'>Dealer: </label>";
            echo "<input class='input' type='text' name='dealer' value='".$dealer."' required><br />";
            echo "<label class='label is-small'>Town: </label>";
            echo "<input class='input' type='text' name='town' value='".$town."' required><br />";
            echo "<label class='label is-small'>Telephone: </label>";
            echo "<input class='input' type='text' name='telephone' value='".$telephone."' required><br />";
            echo "<label class='label is-small'>Region: </label>";
            echo "<input class='input' type='text' name='region' value='".$region."' required><br />";
            echo "<label class='label is-small'>Available: </label>";
            echo "<select class='input has-text-centered' name='available'>";
            echo "<option value='Y' ".$availableYes.">Yes</option>";
            echo "<option value='N' ".$availableNo.">No</option>";
            echo "</select>";
            echo "<label class='label is-invisible is-small'>save button</label>";
            echo "<input class='button is-primary' type='submit' name='submit' value='Save'>";
            echo "</div>";

            echo "</div>";
            echo "</form>";
            #endregion
            
            if (isset($_POST['submit']))
            {
                #region - update car
                $update = $pdo->prepare("UPDATE cars SET make = :make, model = :model, Reg = :reg, colour = :colour, 
                miles = :miles, price = :price, dealer = :dealer, town = :town, telephone = :telephone, 
                description = :description, region = :region, picture = :picture, available = :available WHERE carIndex = :carIndex");
                $update->bindParam(':make', $_POST['make'], PDO::PARAM_STR);
                $update->bindParam(':model', $_POST['model'], PDO::PARAM_STR);
                $update->bindParam(':reg', $_POST['reg'], PDO::PARAM_STR);
                $update->bindParam(':colour', $_POST['colour'], PDO::PARAM_STR);
                $update->bindParam(':miles', $_POST['miles'], PDO::PARAM_STR);
                $update->bindParam(':price', $_POST['price'], PDO::PARAM_INT);
                $update->bindParam(':dealer', $_POST['dealer'], PDO::PARAM_STR);
                $update->bindParam(':town', $_POST['town'], PDO::PARAM_STR);
                $update->bindParam(':telephone', $_POST['telephone'], PDO::PARAM_STR);
                $update->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
                $update->bindParam(':carIndex', $carIndex, PDO::PARAM_INT);
                $update->bindParam(':region', $_POST['region'], PDO::PARAM_STR);
                $update->bindParam(':picture', $_POST['picture'], PDO::PARAM_STR);
                $update->bindParam(':available', $_POST['available'], PDO::PARAM_STR);
                $update->execute();
                #endregion

                echo "<br /><br />";
                echo "<div class='columns is-centered'>";
                echo "<div class='column is-one-quarter'>";
                echo "<div class='message is-success has-text-centered'><div class='message-body'>Changes saved.</div></div>";
                echo "</div></div>";
                #endregion
            }
            echo "</div>";

        ?>
    </section>

</body>

</html>