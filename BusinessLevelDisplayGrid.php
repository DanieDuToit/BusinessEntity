<! doctype html>
<html>
<head>
	<style>
		.withBorder ,td ,th {
			border: 1px solid black;
		}

		table {
			border-collapse: collapse;
		}

		td, th {
			padding: 1px;
		}
		.noBorder {
			border: none;
		}
	</style>

	<meta charset="utf-8">
</head>

<body>
<h1>BusinessLevel</h1>


<form name="form1" method="post">
	<div>
		<label for="SearchN">Company Name</label>
		<input type="text" name="searchN" id="searchN">
		<label for="Search"></label>
		<input type="submit" value="Search" name="Search">
	</div>
</form>

<div>
	<table class="noBorder">
		<tr>
			<td class="noBorder">
				<form name="form2" action="Division.php" method="post">
					<input type="submit" value="Create" name="Create" id="Create">
				</form>
			</td>
			<td class="noBorder">
				<form name="form3" action="BusinessLevelDisplayGrid.php" method="post">
					<input type="submit" value="Return" name="Return" id="Return">
				</form>
			</td>
		</tr>
	</table>
</div>
<br>
<?php

	//include_once 'Includes\BaseDB.class.php';
	//include_once 'Includes\BaseBusinessLevel.class.php';
	//include_once 'Includes\functions.inc.php';
	include "Header.inc.php";

	$dbBaseClass = new BaseDB();
	if ($dbBaseClass->conn === false) {
		die("ERROR: Could not connect." . printf('%s', dbGetErrorMsg()));
	}
	if (isset($_POST["Search"])) {
		$bc = $_POST['SearchCN'];

		echo $bc;
		$records = $dbBaseClass->getFieldsByFieldName('Company', 'Name', $bc, array('id', 'Name', 'CompanyCode', 'Active', 'ShortName'));
	} else {

		$records = $dbBaseClass->getFieldsForAll('BusinessLevel', array('id', 'Name', 'Active'));
	}

	if ($records === false) {
		die(dbGetErrorMsg());
	}

	echo "<table>";
	echo "<tr>";
	echo "<thead>";
	echo "<td>BusinessLevelName</td><td>Active</td>";
	echo "</thead>";
	echo "</tr>";

	while ($record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC)) {

		echo "<tr>";
		echo "<td>{$record['Name']}</td>";
		echo "<td>{$record['Active']}</td>";
		echo "<td><a href = 'BusinessLevel.php?action=r&id={$record["id"]}'>Display</a>";
		echo "<td><a href ='BusinessLevel.php?action=u&id={$record["id"]}'>Edit</a>";
		echo "<td><a href ='BusinessLevel.php?action=d&id={$record["id"]}'> Delete </a> </td>";
		echo "</tr>";
	}
	echo "</table>";

	$dbBaseClass->close();


?>

</body>
</html>