<!DOCTYPE html>
<html>

<head>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    td,
    th {
        border: 1px solid black;
        padding: 5px;
    }

    th {
        text-align: left;
    }
    </style>
</head>

<body>
    <?php
        $q = intval($_GET['q']);

        require 'databaseTemplate.php';

        $sql = "SELECT * FROM user WHERE id='".$q."'";
        $result = $pdo->prepare($sql);
        $result->execute(); 

        echo "<table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Home</th>
                    <th>Patronas</th>
                </tr>
        ";

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            echo "<tr>";
            echo "<td>".$row['FirstName']."</td>";
            echo "<td>".$row['LastName']."</td>";
            echo "<td>".$row['Age']."</td>";
            echo "<td>".$row['Home']."</td>";
            echo "<td>".$row['Patronus']."</td>";
            echo "</tr>";
        }

        echo "</table>";
    ?>
</body>

</html>