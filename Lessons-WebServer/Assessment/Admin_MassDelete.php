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

            #region - set page variables
            $count = 0;
            if (isset($_POST['findmake'])) { $findmake = $_POST['findmake']; } else { $findmake = ""; }
            if (isset($_POST['findmodel'])) { $findmodel = $_POST['findmodel']; } else { $findmodel = ""; }
            if (isset($_POST['findreg'])) { $findreg = $_POST['findreg']; } else { $findreg = ""; }
            if (isset($_POST['findcolour'])) { $findcolour = $_POST['findcolour']; } else { $findcolour = ""; }
            if (isset($_POST['findmiles'])) { $findmiles = $_POST['findmiles']; } else { $findmiles = ""; }
            if (isset($_POST['findprice'])) { $findprice = $_POST['findprice']; } else { $findprice = ""; }
            if (isset($_POST['finddealer'])) { $finddealer = $_POST['finddealer']; } else { $finddealer = ""; }
            if (isset($_POST['findtown'])) { $findtown = $_POST['findtown']; } else { $findtown = ""; }
            if (isset($_POST['findtelephone'])) { $findtelephone = $_POST['findtelephone']; } else { $findtelephone = ""; }
            if (isset($_POST['finddescription'])) { $finddescription = $_POST['finddescription']; } else { $finddescription = ""; }
            if (isset($_POST['findregion'])) { $findregion = $_POST['findregion']; } else { $findregion = ""; }
            if (isset($_POST['findpicture'])) { $findpicture = $_POST['findpicture']; } else { $findpicture = ""; }
            if (isset($_POST['findavailable'])) { $findavailable = $_POST['findavailable']; } else { $findavailable = ""; }
            #endregion
            echo "<div class='block'></div>";
            echo "<h2 class='is-size-3 has-text-centered'><u>Mass Deletion</u></h2><br />";
            echo "<div class='container'>";

            if (!isset($_POST['submit']))
            {
                echo "<div class='columns is-centered'>";
                echo "<div class='column is-narrow'>";
                echo "<div class='message is-danger has-text-centered'><div class='message-body is-size-5'>";
                echo "Warning! This feature is very dangerous!</div></div></div></div>";


                #region - find input form
                echo "<form method='POST'>";
                echo "<fieldset><legend>Find Cars Matching:<br /><br /></legend>";
                echo "<div class='container columns is-centered'>";

                echo "<div class='column is-one-third'>";
                echo "<label class='label is-small'>Make: </label>";
                echo "<input class='input' type='text' name='findmake' value='".$findmake."'>";
                echo "<label class='label is-small'>Model: </label>";
                echo "<input class='input' type='text' name='findmodel' value='".$findmodel."'>";
                echo "<label class='label is-small'>Reg: </label>";
                echo "<input class='input' type='text' name='findreg' value='".$findreg."'>";
                echo "<label class='label is-small'>Colour: </label>";
                echo "<input class='input' type='text' name='findcolour' value='".$findcolour."'><br />";
                echo "<label class='label is-small'>Available: </label>";
                echo "<select class='input has-text-centered' name='findavailable'>";
                echo "<option value='' selected>--select--</option>";
                echo "<option value='Y'>Yes</option>";
                echo "<option value='N'>No</option>";
                echo "</select>";
                echo "</div>";
                
                echo "<div class='column is-one-third'>";
                echo "<label class='label is-small'>Miles: </label>";
                echo "<input class='input' type='text' name='findmiles' value='".$findmiles."'>";
                echo "<label class='label is-small'>Price: </label>";
                echo "<input class='input' type='text' name='findprice' value='".$findprice."'>";
                echo "<label class='label is-small'>Dealer: </label>";
                echo "<input class='input' type='text' name='finddealer' value='".$finddealer."'>";
                echo "<label class='label is-small'>Town: </label>";
                echo "<input class='input' type='text' name='findtown' value='".$findtown."'>";
                echo "<label class='label is-invisible is-small'>delete button</label>";
                echo "<input class='button is-danger' type='submit' name='submit' value='Delete'>";
                echo "</div>";

                echo "<div class='column is-one-third'>";
                echo "<label class='label is-small'>Telephone: </label>";
                echo "<input class='input' type='text' name='findtelephone' value='".$findtelephone."'>";
                echo "<label class='label is-small'>Description: </label>";
                echo "<input class='input' type='text' name='finddescription' value='".$finddescription."'>";
                echo "<label class='label is-small'>Region: </label>";
                echo "<input class='input' type='text' name='findregion' value='".$findregion."'>";
                echo "<label class='label is-small'>Picture: </label>";
                echo "<input class='input' type='text' name='findpicture' value='".$findpicture."'>";
                echo "</div></div>";

                echo "</fieldset>";
                echo "</form>";
                #endregion
            }

            if (isset($_POST['submit']))
            {
                #region - create the find sql
                $findsql = "";
                if($findmake !="" && $findsql=="") { $findsql = $findsql."make='".$findmake."'"; }
                elseif($findmake !="" && $findsql!="") { $findsql = $findsql.", make='".$findmake."'"; }
                if($findmodel !="" && $findsql=="") { $findsql = $findsql."model='".$findmodel."'"; }
                elseif($findmodel !="" && $findsql!="") { $findsql = $findsql.", model='".$findmodel."'"; }
                if($findreg !="" && $findsql=="") { $findsql = $findsql."Reg='".$findreg."'"; }
                elseif($findreg !="" && $findsql!="") { $findsql = $findsql.", Reg='".$findreg."'"; }
                if($findcolour !="" && $findsql=="") { $findsql = $findsql."colour='".$findcolour."'"; }
                elseif($findcolour !="" && $findsql!="") { $findsql = $findsql.", colour='".$findcolour."'"; }
                if($findmiles !="" && $findsql=="") { $findsql = $findsql."miles='".$findmiles."'"; }
                elseif($findmiles !="" && $findsql!="") { $findsql = $findsql.", miles='".$findmiles."'"; }
                if($findprice !="" && $findsql=="") { $findsql = $findsql."price='".$findprice."'"; }
                elseif($findprice !="" && $findsql!="") { $findsql = $findsql.", price='".$findprice."'"; }
                if($finddealer !="" && $findsql=="") { $findsql = $findsql."dealer='".$finddealer."'"; }
                elseif($finddealer !="" && $findsql!="") { $findsql = $findsql.", dealer='".$finddealer."'"; }
                if($findtown !="" && $findsql=="") { $findsql = $findsql."town='".$findtown."'"; }
                elseif($findtown !="" && $findsql!="") { $findsql = $findsql.", town='".$findtown."'"; }
                if($findtelephone !="" && $findsql=="") { $findsql = $findsql."telephone='".$findtelephone."'"; }
                elseif($findtelephone !="" && $findsql!="") { $findsql = $findsql.", telephone='".$findtelephone."'"; }
                if($finddescription !="" && $findsql=="") { $findsql = $findsql."description='".$finddescription."'"; }
                elseif($finddescription !="" && $findsql!="") { $findsql = $findsql.", description='".$finddescription."'"; }
                if($findregion !="" && $findsql=="") { $findsql = $findsql."region='".$findregion."'"; }
                elseif($findregion !="" && $findsql!="") { $findsql = $findsql.", region='".$findregion."'"; }
                if($findpicture !="" && $findsql=="") { $findsql = $findsql."picture='".$findpicture."'"; }
                elseif($findpicture !="" && $findsql!="") { $findsql = $findsql.", picture='".$findpicture."'"; }
                if($findavailable !="" && $findsql=="") { $findsql = $findsql."available='".$findavailable."'"; }
                elseif($findavailable !="" && $findsql!="") { $findsql = $findsql.", available='".$findavailable."'"; }
                #endregion

                #region - create and run count then update
                if ($findsql != "")
                {
                    $countsql = "SELECT COUNT(*) FROM cars WHERE ".$findsql.";";
                    $countMassUpdate = $pdo->prepare($countsql);
                    $countMassUpdate->execute();
                    $count = $countMassUpdate->fetchColumn();

                    $fullsql = "DELETE FROM cars WHERE ".$findsql.";";
                    $massUpdate = $pdo->prepare($fullsql);
                    $massUpdate->execute();
                }
                #endregion

                echo "<br /><br />";

                echo "<div class='columns is-centered'>";
                echo "<div class='column is-narrow'>";
                echo "<div class='message is-warning has-text-centered'><div class='message-body'>";
                echo "Successful deletion. ".$count." cars deleted.</div></div>";
                echo "</div></div>";

                echo "<div class='has-text-centered'>";
                echo "<br />";
                echo "Perform another deletion? ";
                echo "<a class='button is-danger' href='Admin_MassDelete.php' target='_self'>Yes</a> ";
                echo "<a class='button is-info' href='Admin_Main.php' target='_self'>No</a>";
                echo "</div>";
            }

        ?>
    </section>

</body>

</html>