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
        require 'Templates/databaseTemplate.php';
    ?>

    <section class="container">
        <div class="block"></div>
        <h1 class="is-size-3 has-text-centered"><br /><br />Welcome to the Administration Area.<br /><br /></h1>
        <div class="block"></div>

        <div class="container columns is-centered has-text-centered">
            <div class="column"><a class="button is-large is-info" href="Admin_Insert.php" target="">Add New Car</a></div>
            <div class="column"><a class="button is-large is-info" href="Admin_MassUpdate.php" target="">Mass Update</a></div>
            <div class="column"><a class="button is-large is-danger" href="Admin_MassDelete.php" target="">Mass Delete</a></div>
        </div>
    </section>
</body>

</html>