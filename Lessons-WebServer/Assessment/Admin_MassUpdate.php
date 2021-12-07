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

    <section class='has-text-centered'>
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
            if (isset($_POST['updatemake'])) { $updatemake = $_POST['updatemake']; } else { $updatemake = ""; }
            if (isset($_POST['updatemodel'])) { $updatemodel = $_POST['updatemodel']; } else { $updatemodel = ""; }
            if (isset($_POST['updatereg'])) { $updatereg = $_POST['updatereg']; } else { $updatereg = ""; }
            if (isset($_POST['updatecolour'])) { $updatecolour = $_POST['updatecolour']; } else { $updatecolour = ""; }
            if (isset($_POST['updatemiles'])) { $updatemiles = $_POST['updatemiles']; } else { $updatemiles = ""; }
            if (isset($_POST['updateprice'])) { $updateprice = $_POST['updateprice']; } else { $updateprice = ""; }
            if (isset($_POST['updatedealer'])) { $updatedealer = $_POST['updatedealer']; } else { $updatedealer = ""; }
            if (isset($_POST['updatetown'])) { $updatetown = $_POST['updatetown']; } else { $updatetown = ""; }
            if (isset($_POST['updatetelephone'])) { $updatetelephone = $_POST['updatetelephone']; } else { $updatetelephone = ""; }
            if (isset($_POST['updatedescription'])) { $updatedescription = $_POST['updatedescription']; } else { $updatedescription = ""; }
            if (isset($_POST['updateregion'])) { $updateregion = $_POST['updateregion']; } else { $updateregion = ""; }
            if (isset($_POST['updatepicture'])) { $updatepicture = $_POST['updatepicture']; } else { $updatepicture = ""; }
            if (isset($_POST['updateavailable'])) { $updateavailable = $_POST['updateavailable']; } else { $updateavailable = ""; }
            #endregion

            echo "<div class='block'></div>";
            echo "<h2 class='is-size-3'><u>Mass Updates</u></h2><br />";
            echo "<div class='container'>";

            if (!isset($_POST['submit']))
            {
                #region - find input form
                echo "<form method='POST'>";
                echo "<div class='container columns is-centered'>";

                echo "<div class='column'>";
                    echo "<fieldset>";
                    echo "<legend><u>Find Cars Matching</u><br /></legend>";
                    echo "<div style='border: solid 1px grey; border-radius: 10px; padding: 5px'>";
                        echo "<div class='columns'>";
                            echo "<div class='column'>";
                                echo "<label class='label is-small'>Make: </label>";
                                echo "<input class='input' type='text' name='findmake' value='".$findmake."'>";
                                echo "<label class='label is-small'>Model: </label>";
                                echo "<input class='input' type='text' name='findmodel' value='".$findmodel."'>";
                                echo "<label class='label is-small'>Reg: </label>";
                                echo "<input class='input' type='text' name='findreg' value='".$findreg."'>";
                                echo "<label class='label is-small'>Colour: </label>";
                                echo "<input class='input' type='text' name='findcolour' value='".$findcolour."'>";
                                echo "<label class='label is-small'>Miles: </label>";
                                echo "<input class='input' type='text' name='findmiles' value='".$findmiles."'>";
                                echo "<label class='label is-small'>Price: </label>";
                                echo "<input class='input' type='text' name='findprice' value='".$findprice."'>";
                            echo "</div>";
                            echo "<div class='column'>";
                                echo "<label class='label is-small'>Dealer: </label>";
                                echo "<input class='input' type='text' name='finddealer' value='".$finddealer."'>";
                                echo "<label class='label is-small'>Town: </label>";
                                echo "<input class='input' type='text' name='findtown' value='".$findtown."'>";
                                echo "<label class='label is-small'>Telephone: </label>";
                                echo "<input class='input' type='text' name='findtelephone' value='".$findtelephone."'>";
                                echo "<label class='label is-small'>Description: </label>";
                                echo "<input class='input' type='text' name='finddescription' value='".$finddescription."'>";
                                echo "<label class='label is-small'>Region: </label>";
                                echo "<input class='input' type='text' name='findregion' value='".$findregion."'>";
                                echo "<label class='label is-small'>Picture: </label>";
                                echo "<input class='input' type='text' name='findpicture' value='".$findpicture."'>";
                            echo "</div>";
                        echo "</div>";
                        echo "<label class='label is-small'>Available: </label>";
                        echo "<select class='input has-text-centered' name='findavailable'>";
                        echo "<option value='' selected>--select--</option>";
                        echo "<option value='Y'>Yes</option>";
                        echo "<option value='N'>No</option>";
                        echo "</select>";
                    echo "</div>";
                    echo "</fieldset>";
                echo "</div>";
                #endregion

                #region - update input form
                echo "<div class='column'>";
                    echo "<fieldset>";
                    echo "<legend><u>Update To</u><br /></legend>";
                    echo "<div style='border: solid 1px grey; border-radius: 10px; padding: 5px'>";
                        echo "<div class='columns'>";
                            echo "<div class='column'>";
                                echo "<label class='label is-small'>Make: </label>";
                                echo "<input class='input' type='text' name='updatemake' value='".$updatemake."'>";
                                echo "<label class='label is-small'>Model: </label>";
                                echo "<input class='input' type='text' name='updatemodel' value='".$updatemodel."'>";
                                echo "<label class='label is-small'>Reg: </label>";
                                echo "<input class='input' type='text' name='updatereg' value='".$updatereg."'>";
                                echo "<label class='label is-small'>Colour: </label>";
                                echo "<input class='input' type='text' name='updatecolour' value='".$updatecolour."'>";
                                echo "<label class='label is-small'>Miles: </label>";
                                echo "<input class='input' type='text' name='updatemiles' value='".$updatemiles."'>";
                                echo "<label class='label is-small'>Price: </label>";
                                echo "<input class='input' type='text' name='updateprice' value='".$updateprice."'>";
                            echo "</div>";
                            echo "<div class='column'>";
                                echo "<label class='label is-small'>Dealer: </label>";
                                echo "<input class='input' type='text' name='updatedealer' value='".$updatedealer."'>";
                                echo "<label class='label is-small'>Town: </label>";
                                echo "<input class='input' type='text' name='updatetown' value='".$updatetown."'>";
                                echo "<label class='label is-small'>Telephone: </label>";
                                echo "<input class='input' type='text' name='updatetelephone' value='".$updatetelephone."'>";
                                echo "<label class='label is-small'>Description: </label>";
                                echo "<input class='input' type='text' name='updatedescription' value='".$updatedescription."'>";
                                echo "<label class='label is-small'>Region: </label>";
                                echo "<input class='input' type='text' name='updateregion' value='".$updateregion."'>";
                                echo "<label class='label is-small'>Picture: </label>";
                                echo "<input class='input' type='text' name='updatepicture' value='".$updatepicture."'>";
                            echo "</div>";
                        echo "</div>";
                        echo "<label class='label is-small'>Available: </label>";
                        echo "<select class='input has-text-centered' name='updateavailable'>";
                        echo "<option value='' selected>--select--</option>";
                        echo "<option value='Y'>Yes</option>";
                        echo "<option value='N'>No</option>";
                        echo "</select>";
                    echo "</div>";
                    echo "</fieldset>";
                echo "</div>";
                #endregion

                echo "</div>";
                echo "<input class='button is-primary' type='submit' name='submit' value='Mass Update'>";
                echo "</form>";
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

                #region - create the update sql
                $updatesql = "";
                if($updatemake !="" && $updatesql=="") { $updatesql = $updatesql."make='".$updatemake."'"; }
                elseif($updatemake !="" && $updatesql!="") { $updatesql = $updatesql.", make='".$updatemake."'"; }
                if($updatemodel !="" && $updatesql=="") { $updatesql = $updatesql."model='".$updatemodel."'"; }
                elseif($updatemodel !="" && $updatesql!="") { $updatesql = $updatesql.", model='".$updatemodel."'"; }
                if($updatereg !="" && $updatesql=="") { $updatesql = $updatesql."Reg='".$updatereg."'"; }
                elseif($updatereg !="" && $updatesql!="") { $updatesql = $updatesql.", Reg='".$updatereg."'"; }
                if($updatecolour !="" && $updatesql=="") { $updatesql = $updatesql."colour='".$updatecolour."'"; }
                elseif($updatecolour !="" && $updatesql!="") { $updatesql = $updatesql.", colour='".$updatecolour."'"; }
                if($updatemiles !="" && $updatesql=="") { $updatesql = $updatesql."miles='".$updatemiles."'"; }
                elseif($updatemiles !="" && $updatesql!="") { $updatesql = $updatesql.", miles='".$updatemiles."'"; }
                if($updateprice !="" && $updatesql=="") { $updatesql = $updatesql."price='".$updateprice."'"; }
                elseif($updateprice !="" && $updatesql!="") { $updatesql = $updatesql.", price='".$updateprice."'"; }
                if($updatedealer !="" && $updatesql=="") { $updatesql = $updatesql."dealer='".$updatedealer."'"; }
                elseif($updatedealer !="" && $updatesql!="") { $updatesql = $updatesql.", dealer='".$updatedealer."'"; }
                if($updatetown !="" && $updatesql=="") { $updatesql = $updatesql."town='".$updatetown."'"; }
                elseif($updatetown !="" && $updatesql!="") { $updatesql = $updatesql.", town='".$updatetown."'"; }
                if($updatetelephone !="" && $updatesql=="") { $updatesql = $updatesql."telephone='".$updatetelephone."'"; }
                elseif($updatetelephone !="" && $updatesql!="") { $updatesql = $updatesql.", telephone='".$updatetelephone."'"; }
                if($updatedescription !="" && $updatesql=="") { $updatesql = $updatesql."description='".$updatedescription."'"; }
                elseif($updatedescription !="" && $updatesql!="") { $updatesql = $updatesql.", description='".$updatedescription."'"; }
                if($updateregion !="" && $updatesql=="") { $updatesql = $updatesql."region='".$updateregion."'"; }
                elseif($updateregion !="" && $updatesql!="") { $updatesql = $updatesql.", region='".$updateregion."'"; }
                if($updatepicture !="" && $updatesql=="") { $updatesql = $updatesql."picture='".$updatepicture."'"; }
                elseif($updatepicture !="" && $updatesql!="") { $updatesql = $updatesql.", picture='".$updatepicture."'"; }
                if($updateavailable !="" && $updatesql=="") { $updatesql = $updatesql."available='".$updateavailable."'"; }
                elseif($updateavailable !="" && $updatesql!="") { $updatesql = $updatesql.", available='".$updateavailable."'"; }
                #endregion

                #region - create and run count then update
                if ($findsql != "" && $updatesql != "")
                {
                    $countsql = "SELECT COUNT(*) FROM cars WHERE ".$findsql.";";
                    $countMassUpdate = $pdo->prepare($countsql);
                    $countMassUpdate->execute();
                    $count = $countMassUpdate->fetchColumn();

                    $fullsql = "UPDATE cars SET ".$updatesql." WHERE ".$findsql.";";
                    $massUpdate = $pdo->prepare($fullsql);
                    $massUpdate->execute();
                }
                #endregion

                echo "<br /><br />";

                echo "<div class='columns is-centered'>";
                echo "<div class='column is-narrow'>";
                echo "<div class='message is-success has-text-centered'><div class='message-body'>";
                echo "Changes saved. ".$count." cars affected.</div></div>";
                echo "</div></div>";

                echo "<div class='has-text-centered'>";
                echo "<br />";
                echo "Perform another update? ";
                echo "<a class='button is-primary' href='Admin_MassUpdate.php' target='_self'>Yes</a> ";
                echo "<a class='button is-info' href='Admin_Main.php' target='_self'>No</a>";
                echo "</div>";
            }

        ?>
    </section>

</body>

</html>