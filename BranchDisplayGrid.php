<html>
<head>
	<title>Branches</title>
	<style>
		table,td,th {border: 1px solid black}
		table {border-collapse:collapse}
		td,th {padding: 1px}
	</style>
	<meta charset="utf-8">
</head>
<body>
<h1>Branches</h1>
<form action="BranchDisplayGrid.php" method="post">
	<div>
		<label for="SearchBC">Branch Code</label>
		<input type="text" name="SearchBC" id="SearchBC" >
		<label for="Search"></label>
		<input type="submit" value="Search" name="Search">
	</div>
</form>
<br>
<?php
/**
 * Created by PhpStorm.
 * User: dutoitd1
 * Date: 2014/10/14
 * Time: 01:52 PM
 */
	include_once "IncludesAndClasses/DBBase.class.php";
	include_once "IncludesAndClasses/BranchBase.class.php";
	include_once "functions.php";
	$dbBaseClass = new DBBase();
	if ($dbBaseClass->conn === false)
	{
		die("ERROR: Could not connect. " . printf('%s',$dbBaseClass->dbGetErrorMsg()));
	}
	if (isset($_POST["Search"])) {
		$bc = $_POST['SearchBC'];
		echo $bc;
		$records = $dbBaseClass->getFieldsByFieldName('Branch', 'BranchCode', $bc, array( 'id', 'BranchCode', 'Name', 'PhoneNumber', 'ContactPersonName', 'ContactPersonNumber', 'FaxNumber', 'ContactPersonEmail'));
	}
	else {
		$records = $dbBaseClass->getFieldsForAll('Branch', array('id', 'BranchCode', 'Name', 'PhoneNumber', 'ContactPersonName', 'ContactPersonNumber', 'FaxNumber', 'ContactPersonEmail'));
	}
	if ($records === false) {
		die($dbBaseClass->dbGetErrorMsg());
	}
	$numFields = sqlsrv_num_fields( $records );
	echo "<table>";
	echo '<thead>';
	echo '<td>Branch Code</td><td>Name</td><td>Phone Number</td><td>ContactPersonName</td><td>ContactPersonNumber</td><td>FaxNumber</td><td>ContactPersonEmail</td>';
	echo '<tr>';
	echo '</tr>';
	echo '</thead>';
	while ($record = sqlsrv_fetch_array($records, SQLSRV_FETCH_BOTH)) {
		echo "<tr>";
		echo "<td>{$record['BranchCode']}</td>";
		echo "<td>{$record['Name']}</td>";
		echo "<td>{$record['PhoneNumber']}</td>";
		echo "<td>{$record['ContactPersonName']}</td>";
		echo "<td>{$record['ContactPersonNumber']}</td>";
		echo "<td>{$record['FaxNumber']}</td>";
		echo "<td>{$record['ContactPersonEmail']}</td>";
		echo "<td><a href=Branch.php?action=c&id={$record['id']}>Create</a></td>";
		echo "<td><a href=Branch.php?action=r&id={$record['id']}>Read</a></td>";
		echo "<td><a href=Branch.php?action=u&id={$record['id']}>Update</a></td>";
		echo "<td><a href=Branch.php?action=d&id={$record['id']}>Delete</a></td>";
		echo "</tr>";
	}
	echo "</table>";
	$dbBaseClass->close();
?>