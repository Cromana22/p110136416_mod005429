<?php
    require 'Templates/session.php';
    require 'Templates/header.php';
?>

<body>
    <?php
        require 'Templates/navbar.php';
    ?>

    <section class="container has-text-centered">
        <div class="block"></div>
        <div class="block"></div>
        <h1 class='is-size-3'><u>Register</u></h1>
        <div class="block"></div>

        <?php
        #region - set all form variables
        if (isset($_POST['username'])) { $username = $_POST['username']; } else { $username = ""; }
        if (isset($_POST['remember'])) { $rememberState = "checked"; } else { $rememberState = ""; }
        if (isset($_POST['passwrd'])) { $passwrd = $_POST['passwrd']; } else { $passwrd = ""; }

        if (isset($_POST['firstname'])) { $firstname = $_POST['firstname']; } else { $firstname = ""; }
        if (isset($_POST['surname'])) { $surname = $_POST['surname']; } else { $surname = ""; }
        if (isset($_POST['address1'])) { $address1 = $_POST['address1']; } else { $address1 = ""; }
        if (isset($_POST['address2'])) { $address2 = $_POST['address2']; } else { $address2 = ""; }
        if (isset($_POST['town'])) { $town = $_POST['town']; } else { $town = ""; }
        if (isset($_POST['postcode'])) { $postcode = $_POST['postcode']; } else { $postcode = ""; }
        if (isset($_POST['email'])) { $email = $_POST['email']; } else { $email = ""; }

        $userType = "Buyer";
        #endregion
        
        #region - user details input form
        echo "<form class='form' method='POST'>";
        echo "<div class='container columns is-centered'>";

        echo "<div class='column'>";
        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>Username: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' required type='text' name='username' value='".$username."'><br /></div></div></div></div>";
        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>Password: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' required type='password' name='passwrd' value='".$passwrd."'><br /></div></div></div></div>";
        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>First Name: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' required type='text' name='firstname' value='".$firstname."'><br /></div></div></div></div>";
        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>Surname: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' required type='text' name='surname' value='".$surname."'><br /></div></div></div></div>";
        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>Email: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' required type='email' name='email' value='".$email."'><br /></div></div></div></div>";
        echo "</div>";
        
        echo "<div class='column'>";
        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>Address Line 1: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' required type='text' name='address1' value='".$address1."'><br /></div></div></div></div>";
        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>Address Line 2: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' type='text' name='address2' value='".$address2."'><br /></div></div></div></div>";
        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>Town: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' required type='text' name='town' value='".$town."'><br /></div></div></div></div>";
        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>Postcode: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' required type='text' name='postcode' value='".$postcode."'><br /></div></div></div></div>";
        echo "</div>";

        echo "</div>";

        echo "<br />Keep me logged in: <input class='checkbox' type='checkbox' name='remember' ".$rememberState."><br /><br />";
        echo "<input class='button is-primary' type='submit' name='createAccount' value='Create Account'>";

        echo "</form>";
        #endregion

        require 'Templates/databaseTemplate.php';


        if (isset($_POST['createAccount']))
        {
            //check is username is available
            $usernameCheck = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username LIKE :username");
            $usernameCheck->bindParam(':username', $username, PDO::PARAM_INT);
            $usernameCheck->execute();
            $usernameResults = $usernameCheck->fetchColumn();
            
            if ($usernameResults > 0)
            {
                echo "Sorry, this username is not available.";
            }

            else
            {
                //if username IS available, check email is not a duplicate
                $emailCheck = $pdo->prepare("SELECT COUNT(*) FROM customers WHERE email LIKE :email");
                $emailCheck->bindParam(':email', $_POST['email'], PDO::PARAM_INT);
                $emailCheck->execute();
                $emailResults = $emailCheck->fetchColumn();
                
                if ($emailResults > 0)
                {
                    echo "Sorry, this email address is already registered.";
                }

                //if both checks are ok, insert customer and user
                else
                {
                    #region - Insert Customer
                    $insertCustomer = $pdo->prepare("INSERT INTO customers (firstname, surname, address1, address2, town, postcode, email)
                    VALUES (:firstname, :surname, :address1, :address2, :town, :postcode, :email)");
                    $insertCustomer->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                    $insertCustomer->bindParam(':surname', $surname, PDO::PARAM_STR);
                    $insertCustomer->bindParam(':address1', $address1, PDO::PARAM_STR);
                    $insertCustomer->bindParam(':address2', $address2, PDO::PARAM_STR);
                    $insertCustomer->bindParam(':town', $town, PDO::PARAM_STR);
                    $insertCustomer->bindParam(':postcode', $postcode, PDO::PARAM_STR);
                    $insertCustomer->bindParam(':email', $email, PDO::PARAM_STR);
                    $insertCustomer->execute();
                    #endregion
    
                    //load the customer id for user insert
                    $_SESSION['custid'] = $pdo->lastInsertId();
    
                    $hash = password_hash($passwrd, PASSWORD_BCRYPT);

                    #region - Insert User
                    $insertUser = $pdo->prepare("INSERT INTO users (username, passwrd, custid, type)
                    VALUES (:username, :passwrd, :custid, :type)");
                    $insertUser->bindParam(':username', $username, PDO::PARAM_STR);
                    $insertUser->bindParam(':passwrd', $hash, PDO::PARAM_STR);
                    $insertUser->bindParam(':custid', $_SESSION['custid'], PDO::PARAM_STR);
                    $insertUser->bindParam(':type', $userType, PDO::PARAM_STR);
                    $insertUser->execute();
                    #endregion
    
                    #region - login of new registered user
                    //set cookies if selected
                    if (isset($_POST['remember']))
                    {
                        setcookie(loggedin, "Y", time()+3600);
                        setcookie(username, $username);
                    }
    
                    //set session variables
                    $_SESSION["loggedin"] = "Y";
                    $_SESSION['firstname'] = $firstname;
                    $_SESSION['type'] = $userType;
                    #endregion
    
                    //redirect back to previous location
                    $redirect = $_SESSION['backUrl'];
                    header("Location: $redirect");
                }
                
            }
        }
        ?>

    </section>

</body>

</html>