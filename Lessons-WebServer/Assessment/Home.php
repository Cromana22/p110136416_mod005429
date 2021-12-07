<?php
    require 'Templates/session.php';
    require 'Templates/header.php';
?>

<body>
    <?php
        require 'Templates/navbar.php';
    ?>

    <section class="columns">
        <div class="column is-narrow" style="margin-left: 10px">
            <div class="block"></div>
            <h1 class="has-text-centered block"><strong><u>Search</u></strong></h1>
            <?php
                #region - Create Select Lists
                require 'Templates/databaseTemplate.php';
                $makeList = $pdo->query('SELECT DISTINCT make FROM cars ORDER BY make');
                $modelList = $pdo->query('SELECT DISTINCT model FROM cars ORDER BY model');
                $regList = $pdo->query('SELECT DISTINCT Reg FROM cars ORDER BY Reg');
                $colourList = $pdo->query('SELECT DISTINCT colour FROM cars ORDER BY colour');
                $regionList = $pdo->query('SELECT DISTINCT region FROM cars ORDER BY region');
                #endregion

                #region - Form
                echo "<form action='Car_Search.php' method='GET' target='searchResults'>";
                
                echo "<div class='field is-horizontal'>";
                echo "<div class='field-label is-small'><label class='label is-small'>Make:</label></div>";
                echo "<div class='field-body'><div class='field'><div class='control'><select class='input has-text-centered' name='make'>";
                echo "<option value='%' selected>---make---</option>";
                while ($row = $makeList->fetch())
                {
                    echo "<option value='".$row['make']."'>".$row['make']."</option>";
                }
                echo "</select></div></div></div></div>";

                echo "<div class='field is-horizontal'>";
                echo "<div class='field-label is-small'><label class='label is-small'>Model:</label></div>";
                echo "<div class='field-body'><div class='field'><div class='control'><select class='input has-text-centered' name='model'>";
                echo "<option value='%' selected>---model---</option>";
                while ($row = $modelList->fetch())
                {
                    echo "<option value='".$row['model']."'>".$row['model']."</option>";
                }
                echo "</select></div></div></div></div>";

                echo "<div class='field is-horizontal'>";
                echo "<div class='field-label is-small'><label class='label is-small'>Year:</label></div>";
                echo "<div class='field-body'><div class='field'><div class='control'><select class='input has-text-centered' name='reg'>";
                    echo "<option value='%' selected>---year---</option>";
                    while ($row = $regList->fetch())
                    {
                        echo "<option value='".$row['Reg']."'>".$row['Reg']."</option>";
                    }
                echo "</select></div></div></div></div>";

                echo "<div class='field is-horizontal'>";
                echo "<div class='field-label is-small'><label class='label is-small'>Colour:</label></div>";
                echo "<div class='field-body'><div class='field'><div class='control is-expanded'><select class='input has-text-centered' name='colour'>";
                    echo "<option value='%' selected>---colour---</option>";
                    while ($row = $colourList->fetch())
                    {
                        echo "<option value='".$row['colour']."'>".$row['colour']."</option>";
                    }
                echo "</select></div></div></div></div>";

                echo "<div class='field is-horizontal'>";
                echo "<div class='field-label is-small'><label class='label is-small'>Miles:</label></div>";
                echo "<div class='field-body'><div class='field'><div class='control'><input class='input' type='number' name='miles'></div></div></div></div>";
                
                echo "<div class='field is-horizontal'>";
                echo "<div class='field-label is-small'><label class='label is-small'>Price From:</label></div>";
                echo "<div class='field-body'><div class='field'><div class='control'><input class='input' type='number' name='priceFrom'></div></div></div></div>";

                echo "<div class='field is-horizontal'>";
                echo "<div class='field-label is-small'><label class='label is-small'>Price To:</label></div>";
                echo "<div class='field-body'><div class='field'><div class='control'><input class='input' type='number' name='priceTo'></div></div></div></div>";

                echo "<div class='field is-horizontal'>";
                echo "<div class='field-label is-small'><label class='label is-small'>Region:</label></div>";
                echo "<div class='field-body'><div class='field'><div class='control'><select class='input has-text-centered' name='region'>";
                    echo "<option value='%' selected>---region---</option>";
                    while ($row = $regionList->fetch())
                    {
                        echo "<option value='".$row['region']."'>".$row['region']."</option>";
                    }
                echo "</select></div></div></div></div>";

                echo "<div class='field is-horizontal'>";
                echo "<div class='field-label is-small'></div>";
                echo "<div class='field-body'><div class='field'><div class='control centered'><input class='button is-primary' type='submit' value='Search'></div></div></div></div>";

                echo "</form>";
                #endregion
            ?>
        </div>
        
        <div class="column" style="border-left: solid 1px">
            <div class="block"></div>
            <h1 class="has-text-centered block"><strong><u>Results</u></strong></h1>
            <iframe name="searchResults" title="searchResults" style="border:none;" width="100%" height="175%"></iframe>
        </div>
    </section>
</body>

</html>