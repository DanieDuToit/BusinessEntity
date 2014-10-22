<!doctype html>
<html>
<head>
	<style>
		table, td, th {
			border: 1px solid black
		}

		thead {
			font-size: medium
		}

		table {
			border-collapse: collapse background-color #00ff00
		}

		td, th {
			padding: 5px
		}
	</style>

	<meta charset="utf-8">
</head>

<body>
<h1> Company</h1>

<form name="form1" method="post">
	<div>
		<label for="searchCN">Company Name</label>
		<input type="text" name="searchCN" id="searchCN">
		<label for="Search"></label>
		<input type="submit" value="Search" name="Search">
	</div>
</form>
<br>

<form name="form2" action="Company.php" method="post">
	<div>
		<input type="submit" value="Create" name="Create" id="Create">
	</div>
</form>

<br>

<?php


	//include_once 'Classes/BaseClasses/BaseDB.class.php';
	//include_once 'Classes/BaseClasses/BaseCompany.class.php';
	//include_once 'Includes/functions.inc.php';
	include "Header.inc.php";

	$dbBaseClass = new BaseDB();
	if ($dbBaseClass->conn === false) {
		die("ERROR: could not connect." . printf('%s', dbGetErrorMsg()));
	}
	if (isset($_POST["Search"])) {
		$bc = $_POST['SearchCN'];

		echo $bc;
		$records = $dbBaseClass->getFieldsByFieldName('Company', 'Name', $bc, array('id', 'Name', 'CompanyCode', 'Active', 'ShortName'));
	} else {
		$records = $dbBaseClass->getFieldsForAll('Company', array('id', 'Name', 'CompanyCode', 'Active', 'ShortName', 'BusinessEntityId'));
	}

	if ($records === false) {
		die(dbGetErrorMsg());
	}

	echo "<table>";
	echo "<tr>";
	echo "<thead>";
	echo "<td>CompanyName</td><td>CompanyCode</td><td>Active</td><td>ShortName</td>";
	echo "<td colspan =\"3\">Action</td>";
	echo "</thead>";
	echo "</tr>";
	while ($record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC)) {

		echo "<tr>";
		echo "<td>{$record['Name']}</td>";
		echo "<td>{$record['CompanyCode']}</td>";
		echo "<td>{$record['Active']}</td>";
		echo "<td>{$record['ShortName']}</td>";
		echo "<td><a href='Company.php?action=r&id={$record["id"]}'>Display </a></td> ";
		echo "<td><a href='Company.php?action=u&id={$record['id']}'>Edit </a></td> ";
		echo "<td><a href ='Company.php?action=d&id={$record['id']}'> Delete </a> </td>";
		echo "</tr>";
	}
	echo "</table>";

	$dbBaseClass->close();


?>

</body>
</html>

