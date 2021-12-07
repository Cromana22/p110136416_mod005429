<?php
    $quantity = $_POST['quantity'];
    $book = $_POST['book'];

    if ($book=="The Name of the Wind")
        {
            $price=2.25;
        }

    else if ($book=="Harry Potter and the Deathly Hallows (Book 7) [Adult Edition]")
        {
            $price=3.25;
        }
        
    else
        {
            $price=4.25;
        }
    
    $total=$quantity*$price;

    echo "You ordered $quantity x <cite>$book</cite> at £$price each.<br>";
    echo "Total: £$total. <br><br>";
    echo "Thank you for ordering from <b>Books R US<b>!<br><br>";

    echo "<a href='books.html'>Return to ordering page.</a>";
?>