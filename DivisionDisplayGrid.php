<?php
	// Start session
	session_start();
?>
<?php
	/* Header.inc.php contains all styling and <head> tags*/
	include "Header.inc.php";

	if (isset($_POST["Return"])) {
		header("Location: Default.php");
	}

	$cbStatus = '';
	$filter = '';
	$active = null;
	if (isset($_POST["Search"])) {
		$dn = $_POST['SearchDN'];
		$filter = "WHERE Name LIKE '%$dn%' AND BusinessLevelId = 2";
		if (isset($_POST['cbActive'])) {
			$active = true;
			$filter .= ' AND Active = 1';
		} else {
			$action = false;
			$filter .= ' AND Active = 0';
		}
	} else {
		$filter = "WHERE BusinessLevelId = 2 AND Active = 1";
		$active = true;
	}
?>
<body>
<h1>Divisions</h1>

<form name="form1" action="DivisionDisplayGrid.php" method="post">
	<table width="400" border="1" cellspacing="2px" cellpadding="2px">
		<tbody>
		<tr>
			<td><label for="SearchDN">Division Name</label>
				<input type="text" name="SearchDN" id="SearchDN"></td>
			<td>Active?
				<input name="cbActive" type="checkbox" id="cbActive" title="Active" onClick="cbChanged(this)"
					<?php
						if ($active === true) {
							echo ' checked="checked"';
						}
					?>
					>
			</td>
			<td><label for="Search"></label>
				<input type="submit" value="Search" name="Search"></td>
		</tr>
		</tbody>
	</table>
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
	if (Database::getConnection() === false) {
		$_SESSION['error'] = dbGetErrorMsg();
		header("Location: Default.php");
		exit;
	}

	$records = $dbBaseClass->getFieldsByFilter('BusinessEntity', array('id', 'Name', 'BusinessEntityCode', 'BusinessEntityDescription', 'BusinessEntityShortName'), $filter);
	if ($records === false) {
		$_SESSION['error'] = dbGetErrorMsg();
		header("Location: Default.php");
		exit;
	}
	echo "<table>";
	echo "<thead>";
	$name = BaseBusinessEntity::$BusinessEntity['Name']['FriendlyName'];
	$shortName = BaseBusinessEntity::$BusinessEntity['BusinessEntityShortName']['FriendlyName'];
	$description = BaseBusinessEntity::$BusinessEntity['BusinessEntityDescription']['FriendlyName'];
	echo "<tr><th>$name</th><th>$shortName</th><th>$description</th></tr>";
	echo "<tr>";
	echo "</tr>";
	echo "</thead>";
	while ($record = sqlsrv_fetch_array($records, SQLSRV_FETCH_BOTH)) {
		echo "<tr>";
		echo "<td>" . $record["Name"] . "</td>";
		echo "<td>" . $record["BusinessEntityDescription"] . "</td>";
		echo "<td>" . $record["BusinessEntityShortName"] . "</td>";
		echo "<td><a href=Division.php?action=r&id=" . $record["id"] . "><img src=\"images/icons/view.png\" /></a></td>";
		echo "<td><a href=Division.php?action=u&id=" . $record["id"] . "><img src=\"images/icons/edit.png\" /></a></td>";
//		echo "<td><a href=Division.php?action=d&id=" . $record["id"] . "><img src=\"images/icons/delete.png\" /></a></td>";
		echo "</tr>";
	}
	echo "</table>";
	$dbBaseClass->close();
?>
<script type="text/javascript" src="JavaScripts/jquery-2.0.2.js"></script>
<script type="text/javascript" src="JavaScripts/ActiveCheckboxHandler.js"></script>
