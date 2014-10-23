<?php
	/**
	 * Created by PhpStorm.
	 * User: dutoitd1
	 * Date: 2014/10/14
	 * Time: 09:56 AM
	 */
	if (isset($_POST['Return'])) {
		header("Location: BranchDisplayGrid.php");
	}
	include "Header.inc.php";
//	include_once "BaseClasses/settings.inc.php";
//	include_once "BaseClasses/BaseDB.class.php";
//	include_once "BaseClasses/BaseBranch.class.php";
//	include_once "BaseClasses/functions.inc.php";
	$action = '';
	if (!isset($_POST['Create'])) {
		if (isset($_GET['id']) === false || isset($_GET['action']) === false) {
			header("Location: BranchDisplayGrid.php");
		}
		$id = (int)$_GET['id'];
		$action = $_GET['action'];
		sanitizeString($id);
	} else {
		$action = 'c';
		$id = -1;
	}
	sanitizeString($action);

	// Set up DB connection
	$dbBaseClass = new BaseDB();
	if ($dbBaseClass->conn === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}

	// An existing record is expected when the action is not "Create"
	if ($action != 'c') {
		// Read the record
		$records = $dbBaseClass->getAll('Branch', "WHERE id = $id");

		if ($records === false) {
			die(dbGetErrorMsg());
		}

		// Get the specific record
		$record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC);
	}

	$recordBase = BaseBranch::$Branch;
	function echoField($fieldIdName)
	{
		global $action;
		global $record;
		global $recordBase;
		$fieldParams = initializeFieldParametersArray($fieldIdName, $recordBase);
		if ($action == 'r' || $action == 'd') {
			$fieldParams[FieldParameters::disabled_par] = 'Disabled';
		}
		$inputField = (string)drawInputField($fieldIdName, $recordBase[$fieldIdName]['Type'], $record[$fieldIdName], $fieldParams);
		$str = (string)$recordBase[$fieldIdName]['FriendlyName'];
		if ($str == "") $str = $fieldIdName;
		echo "<td class=\"fieldName\"><b>$str</ b></td>";
		echo("<td>$inputField</td>");
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<link href="skin/demo/menu.css" rel="stylesheet" type="text/css">
	<link href="skin/stylesheet.css" rel="stylesheet" type="text/css">
	<link href="skin/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
	<title>Branch</title>
</head>
<body>

<?php
	if ($action == 'c') {
		$val = 'Insert';
	} elseif ($action == 'u') {
		$val = 'Update';
	} elseif ($action == 'd') {
		$val = 'Remove';
	} else {
		$val = 'Display';
	}
	echo sprintf('<div class="heading"><h2>%s a Branch</h2></div>', $val);
?>

<form action="BranchAction.php" method="post">
	<input type="hidden" value="<?php echo $id ?>" id="id" name="id">
	<table width="200" border="0" cellspacing="2px" cellpadding="2px">
		<tbody>
		<tr>
			<?php echoField("BranchCode") ?>
		</tr>
		<tr>
			<?php echoField("Name") ?>
		</tr>
		<tr>
			<?php echoField("Active") ?>
		<tr>
			<?php echoField("CustomMessage") ?>
		</tr>
		<tr>
			<?php echoField("PhoneNumber") ?>
		</tr>
		<tr>
			<?php echoField("FaxNumber") ?>
		</tr>
		<tr>
			<?php echoField("PhysicalAddressLine1") ?>
		</tr>
		<tr>
			<?php echoField("PhysicalAddressLine2") ?>
		</tr>
		<tr>
			<?php echoField("PhysicalAddressLine3") ?>
		</tr>
		<tr>
			<?php echoField("PhysicalAddressLine4") ?>
		</tr>
		<tr>
			<?php echoField("PhysicalAddressLine5") ?>
		</tr>
		<tr>
			<?php echoField("PostalAddressLine1") ?>
		</tr>
		<tr>
			<?php echoField("PostalAddressLine2") ?>
		</tr>
		<tr>
			<?php echoField("PostalAddressLine3") ?>
		</tr>
		<tr>
			<?php echoField("PostalAddressLine4") ?>
		</tr>
		<tr>
			<?php echoField("PostalAddressLine5") ?>
		</tr>
		<tr>
			<?php echoField("BankName") ?>
		</tr>
		<tr>
			<?php echoField("BankBranchName") ?>
		</tr>
		<tr>
			<?php echoField("BankBranchCode") ?>
		</tr>
		<tr>
			<?php echoField("BankAccountNumber") ?>
		</tr>
		<tr>
			<?php echoField("ContactPersonName") ?>
		</tr>
		<tr>
			<?php echoField("ContactPersonNumber") ?>
		</tr>
		<tr>
			<?php echoField("ContactPersonEmail") ?>
		</tr>
		<tr>
			<?php echoField("AdminContactPersonName") ?>
		</tr>
		<tr>
			<?php echoField("AdminContactPersonNumber") ?>
		</tr>
		<tr>
			<?php echoField("AdminContactPersonEmail") ?>
		</tr>
		<tr>
			<?php echoField("Longitude") ?>
		</tr>
		<tr>
			<?php echoField("Latitude") ?>
		</tr>
		<tr>
			<?php echoField("BusinessEntityId") ?>
		</tr>
		</tbody>
	</table>
	<?php if ($action == 'c') ?>
	<div>
		<?php
			if ($action == 'c') {
				echo (string)drawSubmitButton("Create", "Create");
			}
			if ($action == 'u') {
				echo (string)drawSubmitButton("Update", "Update");
			}
			if ($action == 'd') {
				echo (string)drawSubmitButton("Delete", "Delete");
			}
		?>
		<form action="Division.php" method="post">
			<?php
				echo(string)drawSubmitButton("Return", "Return");
			?>
		</form>
	</div>
</form>
</body>
</html>