<?php
    //set current page URL as a variable for "back" function if necessary
    $changingBackURL = basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
    $_SESSION['changingBackUrl'] = $changingBackURL;

    echo "<nav class='navbar has-background-white-ter'>";
    echo "<div class='navbar-brand'><a class='navbar-item' href='Home.php'><img src='./pictures/logo.png' /></a></div>";
    echo "<div class='navbar-menu'>";

    echo "<div class='navbar-start'>";
    #region - admin site link
    if ($_SESSION['utype'] == "Admin")
    {
        echo "<a class='navbar-item is-tab' href='Admin_Main.php'>Administration</a>";
    }
    #endregion
    echo "</div>";

    echo "<h1 class='is-size-1 has-text-centered'><b>-- UCP AUTOS --</b></h1>";


    echo "<div class='navbar-end'>";
    #region - login_logout link
    if ($_SESSION['loggedin'] == "Y")
    {
        echo "<p class='navbar-item'>Welcome " . $_SESSION['firstname'] . "</p>";
        echo "<div class='navbar-item'><div class='buttons'><a class='button is-primary' href='logout.php'>Log Out</a></div></div>";
    }
    
    else
    {
        echo "<div class='navbar-item'><div class='buttons'><a class='button is-primary' href='login.php'>Login</a></div></div>";
    }
    #endregion
    echo "</div>";

    echo "</div>";
    echo "<hr />";
    echo "</nav>";
?>