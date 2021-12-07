<?php
    echo "<table width='450px' border='1' style='border-collapse:collapse; font-family:arial'>";

        echo "<tr bgcolor='grey'>";
            echo "<th>HTML</th>";
            echo "<th>PHP</th>";
        echo "</tr>";

        echo "<tr>";
            echo "<td style='color:red; padding:5px;'>Used to create Websites, code runs on the clients computer and is interpreted by the web browser</th>";
            echo "<td style='color:red; padding:5px;'>Used to access Databases and to interact with the user, code runs on the web server and is displayed on the clients web browser</th>";
        echo "</tr>";

    echo "</table>";
?>

<br><p style='color:blue'>I hate PHP already.</p><br>

<?php
    echo "
        <table width='450px' border='1' style='border-collapse:collapse; font-family:arial'>
            
            <tr bgcolor='grey'>
                <th>HTML</th>
                <th>PHP</th>
            </tr>

            <tr>
                <td style='color:red; padding:5px;'>Used to create Websites, code runs on the clients computer and is interpreted by the web browser</th>
                <td style='color:red; padding:5px;'>Used to access Databases and to interact with the user, code runs on the web server and is displayed on the clients web browser</th>
            </tr>

        </table>
    ";

    echo "<br><br><br>";

    echo "<a href='home.php' style='font-size:12pt'>HOME</a>";    
?>