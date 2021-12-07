<?php
    Session_start();

    #region - check if logged in and set session variables if needed
    if (!isset($_SESSION["loggedin"]))
    {
        //check cookies
        if (isset($_COOKIE['loggedin']))
        {
            //set session login to true
            $_SESSION["loggedin"] = "Y";

            //and re-get the user details from database
            require 'Templates/databaseTemplate.php';
            $loginDetails = $pdo->prepare("SELECT users.type, users.custid, customers.firstname 
                FROM users
                LEFT JOIN customers ON users.custid = customers.id
                WHERE users.username LIKE :username");
            $loginDetails->bindParam(':username', $_COOKIE['username'], PDO::PARAM_INT);
            $loginDetails->execute();

            //and save them as session variables
            while ($row = $loginDetails->Fetch())
            {
                $_SESSION['custid'] = $row['users.custid'];
                $_SESSION['firstname'] = $row['customers.firstname'];
                $_SESSION['utype'] = $row['users.type'];
            }
        }
        else
        {
            $_SESSION["loggedin"] = "N";
        }
    }
    #endregion

    #region - set default session values if none set
    if (!isset($_SESSION["custid"]))
    {
        $_SESSION["custid"] = "";
    }

    if (!isset($_SESSION["firstname"]))
    {
        $_SESSION["firstname"] = "";
    }

    if (!isset($_SESSION["backUrl"]))
    {
        $_SESSION["backUrl"] = "Home.php";
    }

    if (!isset($_SESSION["changingBackUrl"]))
    {
        $_SESSION["changingBackUrl"] = "Home.php";
    }

    if (!isset($_SESSION["utype"]))
    {
        $_SESSION["utype"] = "Buyer";
    }
    #endregion

?>