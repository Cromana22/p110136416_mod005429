<?php

$numOfRecords = 8; //create a variable to limit the number of records shown
$pageNum = 0;
$offset = 0;

//if page variable doesn't exist i.e. page never loaded before
if (!isset($_GET['page']))
{
    //set page as 1, and the offset of record results shown to 1 i.e. 1x1 = 1
    $pageNum = 1;
    $offset = 1;
}
else
{
    $pageNum = $_GET['page'];
    $offset = $pageNum * $numOfRecords;
}

require 'Templates/databaseTemplate.php';
$query = ("SELECT * FROM cars ORDER BY id LIMIT " . $offset . ", " . $numOfRecords);

?>