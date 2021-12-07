<?php
    require 'Templates/session.php';

    $_SESSION['backUrl'] = $_SESSION['changingBackUrl'];
        
    //unset cookies if selected
    if (isset($_COOKIE['loggedin']))
    {
        unset($_COOKIE['loggedin']);
        setcookie(loggedin, "N", time()-1);
    }

    if (isset($_COOKIE['username']))
    {
        unset($_COOKIE['username']);
        setcookie(username, "", time()-1);
    }

    //unset session variables
    unset($_SESSION["loggedin"]);
    unset($_SESSION['custid']);
    unset($_SESSION['firstname']);
    unset($_SESSION['utype']);
    
    //redirect back to previous location
    $redirect = $_SESSION['backUrl'];
    header("Location: $redirect");
?>