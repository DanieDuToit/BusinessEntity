<html>
<head>
	<title>Divisions</title>
	<style>
table,td,th {border: 1px solid black}
		table {border-collapse:collapse}
		td,th {padding: 1px}
	</style>
	<meta charset="utf-8">
</head>
<body>
<h1>Branches</h1>
<form name="form1" action="DivisionDisplayGrid.php" method="post">
	<div>
		<label for="SearchBC">Division Code</label>
		<input type="text" name="SearchDC" id="SearchDC" >
		<label for="Search"></label>
		<input type="submit" value="Search" name="Search">
	</div>
</form>
<form name="form2" action="Division.php" method="post">
	<div>
		<input type="submit" value="Create" name="Create" id="Create">
	</div>
</form>
<br>

<?php
/**
 * Created by PhpStorm.
 * User: Danie
 * Date: 2014/10/21
 * Time: 09:38 PM
 */

include_once "IncludesAndClasses/DBBase.class.php";
include_once "IncludesAndClasses/DivisionBase.class.php";
include_once "IncludesAndClasses/functions.inc.php";
$dbBaseClass = new DBBase();
if ($dbBaseClass->conn === false)
{
	die("ERROR: Could not connect. " . printf('%s',dbGetErrorMsg()));
}


if (isset($_POST["Search"])) {
	$dc = $_POST['SearchDC'];
	$records = $dbBaseClass->getFieldsByFieldName('BusinessEntity', 'BusinessEntityCode', $dc, array( 'id', 'Name', 'BusinessEntityCode', 'BusinessEntityDescription', 'BusinessEntityShortName'));
}
else {
	$records = $dbBaseClass->getFieldsForAll('BusinessEntity', array('id', 'Name', 'BusinessEntityCode', 'BusinessEntityDescription', 'BusinessEntityShortName'));
}
if ($records === false) {
	die(dbGetErrorMsg());
}
echo "<table>";
echo '<thead>';
echo '<td>BusinessEntityCode</td><td>Name</td><td>BusinessEntityDescription</td><td>BusinessEntityShortName</td>';
echo '<tr>';
echo '</tr>';
echo '</thead>';
while ($record = sqlsrv_fetch_array($records, SQLSRV_FETCH_BOTH)) {
	echo "<tr>";
	echo "<td>{$record['BusinessEntityCode']}</td>";
	echo "<td>{$record['Name']}</td>";
	echo "<td>{$record['BusinessEntityDescription']}</td>";
	echo "<td>{$record['BusinessEntityShortName']}</td>";
	echo "<td><a href=Division.php?action=r&id={$record['id']}>Read</a></td>";
	echo "<td><a href=Division.php?action=u&id={$record['id']}>Update</a></td>";
	echo "<td><a href=Division.php?action=d&id={$record['id']}>Delete</a></td>";
	echo "</tr>";
}
echo "</table>";
$dbBaseClass->close();
?>