<?php
	if (isset($_POST['Return'])) {
		header("Location: Default.php");
	}
	include "Header.inc.php";

	/**
	 * Created by PhpStorm.
	 * User: dutoitd1
	 * Date: 2014/10/14
	 * Time: 01:52 PM
	 */

?>
<html>
<head>
	<title>Branches</title>
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
<h1>Branches</h1>

<form name="form1" action="BranchDisplayGrid.php" method="post">
	<div>
		<label for="SearchBC">Branch Code</label>
		<input type="text" name="SearchBC" id="SearchBC">
		<label for="Search"></label>
		<input type="submit" value="Search" name="Search">
	</div>
</form>
<div>
	<table class="noBorder">
		<tr>
			<td class="noBorder">
				<form name="form2" action="Branch.php" method="post">
					<input type="submit" value="Create" name="Create" id="Create">
				</form>
			</td>
			<td class="noBorder">
				<form name="form3" action="BranchDisplayGrid.php" method="post">
					<input type="submit" value="Return" name="Return" id="Return">
				</form>
			</td>
		</tr>
	</table>
</div>
<br>
<?php
	$dbBaseClass = new BaseDB();
	if ($dbBaseClass->conn === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}
	if (isset($_POST["Search"])) {
		$bc = $_POST['SearchBC'];
		echo $bc;
		$records = $dbBaseClass->getFieldsByFilter('Branch', array('id', 'BranchCode', 'Name', 'PhoneNumber', 'ContactPersonName', 'ContactPersonNumber', 'FaxNumber', 'ContactPersonEmail'),
			"WHERE BranchCode LIKE %$bc%");
	} else {
		$records = $dbBaseClass->getFieldsForAll('Branch', array('id', 'BranchCode', 'Name', 'PhoneNumber', 'ContactPersonName', 'ContactPersonNumber', 'FaxNumber', 'ContactPersonEmail'));
	}
	if ($records === false) {
		die(dbGetErrorMsg());
	}
	$numFields = sqlsrv_num_fields($records);
	echo "<table class='withBorder'>";
	echo '<thead>';
	echo '<tr></tr><th>Branch</th><th>Name</th><th>Phone Number</th><th>ContactPersonName</th><th>ContactPersonNumber</th><th>FaxNumber</th><th>ContactPersonEmail</th><tr></tr>';
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
		echo "<td><a href=Branch.php?action=r&id={$record['id']}>Read</a></td>";
		echo "<td><a href=Branch.php?action=u&id={$record['id']}>Update</a></td>";
		echo "<td><a href=Branch.php?action=d&id={$record['id']}>Delete</a></td>";
		echo "</tr>";
	}
	echo "</table>";
	$dbBaseClass->close();
?>
</body>