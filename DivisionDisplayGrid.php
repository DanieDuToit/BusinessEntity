<?php

	if (isset($_POST['Return'])) {
		header("Location: Default.php");
	}

	include_once "BaseClasses/settings.inc.php";
	include_once "BaseClasses/BaseDB.class.php";
	include_once "BaseClasses/BaseBranch.class.php";
	include_once "BaseClasses/functions.inc.php";

//	echo buildPostForDebug($_POST);
//	die;

?>
	<html>
	<head>
		<title>Divisions</title>
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
	<h1>Divisions</h1>

	<form name="form1" action="DivisionDisplayGrid.php" method="post">
		<div>
			<label for="SearchDC">Division Code</label>
			<input type="text" name="SearchDC" id="SearchDC">
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
					<form name="form3" action="DivisionDisplayGrid.php" method="post">
						<input type="submit" value="Return" name="Return" id="Return">
					</form>
				</td>
			</tr>
		</table>
	</div>
	<br>

<?php
	/**
	 * Created by PhpStorm.
	 * User: Danie
	 * Date: 2014/10/21
	 * Time: 09:38 PM
	 */

	$dbBaseClass = new BaseDB();
	if ($dbBaseClass->conn === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}


	if (isset($_POST["Search"])) {
		$dc = $_POST['SearchDC'];
		$records = $dbBaseClass->getFieldsByFilter('BusinessEntity', array('id', 'Name', 'BusinessEntityCode', 'BusinessEntityDescription', 'BusinessEntityShortName'),
			"WHERE BusinessEntityCode LIKE '%$dc%' AND BusinessLevelId = 2");
	} else {
		$records = $dbBaseClass->getFieldsForAll('BusinessEntity', array('id', 'Name', 'BusinessEntityCode', 'BusinessEntityDescription', 'BusinessEntityShortName'),
			"WHERE BusinessLevelId = 2");
	}
	if ($records === false) {
		die(dbGetErrorMsg());
	}
	echo "<table>";
	echo '<thead>';
	echo '<tr></tr><th>BusinessEntityCode</th><th>Name</th><th>BusinessEntityDescription</th><th>BusinessEntityShortName</th></tr>';
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