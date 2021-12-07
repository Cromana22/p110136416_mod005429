<?php
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<meta charset='utf-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1'>";
    echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css'>";

    //takes the current page name and converts it to a suitable tab title
    $titleFullString = basename($_SERVER['PHP_SELF']);
    $titleSpaceString = str_replace("_", " ", $titleFullString);
    $title = ucwords(str_replace(".php", "", $titleSpaceString));

    echo "<head><title>".$title."</title></head>";
?>