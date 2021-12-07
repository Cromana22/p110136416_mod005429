<?php
    require 'Templates/session.php';
	echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css'>";
	
#region - Set Main Variables
//get all the variables. select lists won't be null ever so don't need if statements.
$make = $_GET['make'];
$model = $_GET['model'];
$reg = $_GET['reg'];
$colour = $_GET['colour'];
$region = $_GET['region'];

if(empty($_GET['miles']))
	{$miles = 999999;}
else
	{$miles = $_GET['miles'];}
	
if (empty($_GET['priceFrom']))
	{$priceFrom = 0;}
else
	{$priceFrom = $_GET['priceFrom'];}

if (empty($_GET['priceTo']))
	{$priceTo = 99999999999;}
else
	{$priceTo = $_GET['priceTo'];}

require 'Templates/databaseTemplate.php';

$numOfRecords = 10; //create a variable to limit the number of records shown
$pageNum = 0;
$offset = 0;
#endregion

#region - Pagination Page Set
//if page variable doesn't exist i.e. page never loaded before
if (!isset($_GET['page']))
{
    //set page as 1, and the offset of record results shown to 1 i.e. 1x1 = 1
    $pageNum = 1;
    $offset = 0;
}
else
{
    $pageNum = $_GET['page'];
    $offset = ($pageNum-1) * $numOfRecords;
}
#endregion

#region - Row Count Query and Page Count
//create the count query
$count = $pdo->prepare("SELECT COUNT(*) FROM cars
WHERE make LIKE :make 
AND model LIKE :model 
AND reg LIKE :reg 
AND colour LIKE :colour 
AND region LIKE :region 
AND miles <= :miles 
AND price >= :priceFrom
AND price <= :priceTo");

//bind the variables and parameters together
$count->bindParam(':make', $make, PDO::PARAM_INT);
$count->bindParam(':model', $model, PDO::PARAM_INT);
$count->bindParam(':reg', $reg, PDO::PARAM_INT);
$count->bindParam(':colour', $colour, PDO::PARAM_INT);
$count->bindParam(':region', $region, PDO::PARAM_INT);
$count->bindParam(':miles', $miles, PDO::PARAM_INT);
$count->bindParam(':priceFrom', $priceFrom, PDO::PARAM_INT);
$count->bindParam(':priceTo', $priceTo, PDO::PARAM_INT);

//run the statement and create page count
$count->execute();
$countResults = $count->fetchColumn();
$numPages = ceil($countResults/$numOfRecords);
#endregion

#region - Search Query
//create the sql query
$search = $pdo->prepare("SELECT * FROM cars
WHERE make LIKE :make 
AND model LIKE :model 
AND reg LIKE :reg 
AND colour LIKE :colour 
AND region LIKE :region 
AND miles <= :miles 
AND price >= :priceFrom
AND price <= :priceTo 
ORDER BY carIndex 
LIMIT " . $offset . ", " . $numOfRecords);

//bind the variables and parameters together
$search->bindParam(':make', $make, PDO::PARAM_INT);
$search->bindParam(':model', $model, PDO::PARAM_INT);
$search->bindParam(':reg', $reg, PDO::PARAM_INT);
$search->bindParam(':colour', $colour, PDO::PARAM_INT);
$search->bindParam(':region', $region, PDO::PARAM_INT);
$search->bindParam(':miles', $miles, PDO::PARAM_INT);
$search->bindParam(':priceFrom', $priceFrom, PDO::PARAM_INT);
$search->bindParam(':priceTo', $priceTo, PDO::PARAM_INT);


//run the statement with the variables as inputs
$search->execute();
#endregion

#region - Result Table
//write out the table header
echo "<table class='table is-hoverable is-striped is-fullwidth'>";
echo "<thead><tr>";
echo "<th>Make</th>";
echo "<th>Model</th>";
echo "<th>Registration</th>";
echo "<th>Colour</th>";
echo "<th>Mileage</th>";
echo "<th>Price</th>";
echo "<th>Image</th>";
echo "<th> </th>";
if ($_SESSION['utype']=="Admin")
{
	echo "<th> </th>";
	echo "<th> </th>";
}
echo "</tr></thead>";
echo "<tbody>";

//write out the table content
while($row = $search->fetch())
{
	if ($_SESSION['utype']=="Admin")
	{
		echo "<tr>";
		echo "<td>".$row['make']."</td>";
		echo "<td>".$row['model']."</td>";
		echo "<td>".$row['Reg']."</td>";
		echo "<td>".$row['colour']."</td>";
		echo "<td>".$row['miles']."</td>";
		echo "<td>£".$row['price']."</td>";
		echo "<td><img src='pictures/" . $row['picture'] . "' width='100'></td>";
		echo "<td><a href='Car_Details.php?carIndex=" . $row['carIndex'] . "' target='_blank'>More Details</a></td>";
		echo "<td><a href='Admin_Update.php?carIndex=" . $row['carIndex'] . "' target='_blank'>Edit</a></td>";
		echo "<td><a href='Admin_Delete.php?carIndex=" . $row['carIndex'] . "' target=''>Delete</a></td>";
		echo "</tr>";
	}

	else
	{
		if ($row['available']=="Y")
		{
			echo "<tr>";
			echo "<td>".$row['make']."</td>";
			echo "<td>".$row['model']."</td>";
			echo "<td>".$row['Reg']."</td>";
			echo "<td>".$row['colour']."</td>";
			echo "<td>".$row['miles']."</td>";
			echo "<td>£".$row['price']."</td>";
			echo "<td><img src='pictures/" . $row['picture'] . "' width='100'></td>";
			echo "<td><a href='Car_Details.php?carIndex=" . $row['carIndex'] . "' target='_blank'>More Details</a></td>";
			echo "</tr>";
		}
	}
	
}
echo "</tbody>";
echo "</table>";
#endregion

echo "<div class='has-text-centered'>";
#region - Pagination Controls
	$next = $pageNum+1;
	$prev = $pageNum-1;

	//takes the current URL query and strips out the page number if exists, then creates URL
	$queryString = $_SERVER['QUERY_STRING'];
	$removePage = "&page=".$pageNum;
	$queryString = str_replace($removePage, "", $queryString);
	$url = basename($_SERVER['PHP_SELF'])."?".$queryString."&page=";

	//write out a back-to-start button
	echo "<a class='pagination-link' href='".$url."1'> << </a>";

	//check if it can go back another page, otherwise disable the link
	if ($prev > 0)
	{
		echo "<a class='pagination-previous' href='".$url.$prev."'> < </a>";
	}
	else
	{
		echo "<a class='pagination-previous'> < </a>";
	}

	//write out page number and total pages
	echo "<p class='pagination-link'><b>".$pageNum."</b>&nbspof ".$numPages."</p>";

	//check if it can go forward a page, otherwise disable the link
	if ($next <= $numPages)
	{
		echo "<a class='pagination-next' href='".$url.$next."'> > </a>";
	}
	else
	{
		echo "<a class='pagination-next'> > </a>";
	}

	//write out a go-to-end button
	echo "<a class='pagination-link' href='".$url.$numPages."'> >> </a>";

	#endregion
echo "</div>";
?>