<?php
    require 'Templates/session.php';
    require 'Templates/header.php';
?>

<body>
    <?php
        $_SESSION['backUrl'] = $_SESSION['changingBackUrl'];
        require 'Templates/navbar.php';
    ?>

    <section class="container has-text-centered">
        <div class="block"></div>
        <div class="block"></div>
        <h1 class='is-size-3'><u>Login</u></h1>
        <div class="block"></div>

        <?php

        #region - set form variable values
        if (isset($_POST['username'])) { $username = $_POST['username']; } else { $username = ""; }
        if (isset($_POST['remember'])) { $rememberState = "checked"; } else { $rememberState = ""; }
        if (isset($_POST['passwrd'])) { $passwrd = $_POST['passwrd']; } else { $passwrd = ""; }
        #endregion

        #region - login form
        echo "<div class='columns is-centered'>";
        echo "<div class='column is-one-third'><br />";

        echo "<form class='form' method='POST'>";
        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>Username: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' type='text' name='username' value='".$username."'><br /></div></div></div></div>";

        echo "<div class='field is-horizontal'>";
        echo "<div class='field-label'><label class='label'>Password: </label></div>";
        echo "<div class='field-body'><div class='field'><div class='control'><input class='input' type='password' name='passwrd' value='".$passwrd."'><br /></div></div></div></div>";

        echo "<br />Remember Me: <input class='checkbox' type='checkbox' name='remember' ".$rememberState."><br /><br />";
        echo "<input class='button is-primary' type='submit' name='submit' value='Login'>";
        echo "</form>";

        echo "</div>";
        echo "</div>";

        echo "<br /><br />Not Registered? Click <a href='Register.php'>Here</a> to sign up!<br /><br />";
        #endregion

        if (isset($_POST['submit']))
        {
            echo "<script>alert(test);</script>";
            require 'Templates/databaseTemplate.php';

            #region - check login details are valid
            $loginCheck = $pdo->prepare("SELECT passwrd FROM users WHERE username LIKE :username");
            $loginCheck->bindParam(':username', $username, PDO::PARAM_INT);
            $loginCheck->execute();

            //check if any matching rows returned
            $row = $loginCheck->fetch();
            $hash = $row['passwrd'];
            $test = password_verify($passwrd , $hash);
            #endregion  

            #region - If login found
            if ($test == true)
            {
                //get the details
                $loginDetails = $pdo->prepare("SELECT users.type AS uType, 
                    users.custid AS custid, 
                    customers.firstname AS firstname 
                FROM users
                LEFT JOIN customers ON users.custid = customers.id
                WHERE users.username LIKE :username");
                $loginDetails->bindParam(':username', $username, PDO::PARAM_INT);
                $loginDetails->execute();

                while($row = $loginDetails->fetch())
                {
                    $uType = $row['uType'];
                    $custid = $row['custid'];
                    $firstname = $row['firstname'];
                }
                
                //set cookies if selected
                if (isset($_POST['remember']))
                {
                    setcookie(loggedin, "Y", time()+3600);
                    setcookie(username, $username, time()+3600);
                }
                
                //set session variables
                $_SESSION['loggedin'] = "Y";
                $_SESSION['custid'] = $custid;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['utype'] = $uType;
                
                //redirect back to previous location
                if ($_SESSION['backUrl'] != "login.php?")
                {
                    $redirect = $_SESSION['backUrl'];
                }
                else
                {
                    $redirect = "Home.php";
                }
                
                header("Location: $redirect");
            }
            
            else
            {
                echo "Account not found. Please try again.";
            }
            #endregion
        }
        ?>

    </section>

</body>

</html>